<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.plus
 * @link     https://www.hyperf.plus
 * @document https://doc.hyperf.plus
 * @contact  4213509@qq.com
 * @license  https://github.com/hyperf-plus/admin/blob/master/LICENSE
 */

namespace App\Controller\Admin;

use App\Model\Member;
use App\Model\Order as OrderAlias;
use App\Service\OrderService;
use HPlus\Admin\Controller\AbstractAdminController;
use HPlus\Route\Annotation\AdminController;
use HPlus\Route\Annotation\GetApi;
use HPlus\Route\Annotation\PostApi;
use HPlus\UI\Components\Form\DateTimePicker;
use HPlus\UI\Components\Form\Input;
use HPlus\UI\Components\Form\Select;
use HPlus\UI\Components\Grid\Image;
use HPlus\UI\Components\Grid\Tag;
use HPlus\UI\Components\Widgets\Button;
use HPlus\UI\Components\Widgets\Dialog;
use HPlus\UI\Components\Widgets\Markdown;
use HPlus\UI\Form;
use HPlus\UI\Form\FormActions;
use HPlus\UI\Grid;
use HPlus\UI\Grid\Actions\ActionButton;
use HPlus\UI\Layout\Content;
use HPlus\UI\Layout\Row;
use Hyperf\Di\Annotation\Inject;

/**
 * @AdminController(prefix="order", tag="收取订单管理", ignore=true))
 */
class Order extends AbstractAdminController
{
    /**
     * @Inject
     * @var OrderService
     */
    protected $orderService;

    protected function grid()
    {
        $grid = new Grid(new OrderAlias());


        # 重点。 这里是form 如果用到ref自定义绑定的时候必须设置  看182行的用法
        $grid->ref('photo');

        $grid->top(function (Content $content) {
            $content->row($this->code())->className('mb-10');
        });
        $grid
            ->dialogForm($this->form()->isDialog()->backButtonName('关闭'))
            ->selection()
            ->batchActions(function (Grid\BatchActions $action) {
                $down = Grid\BatchActions\BatchAction::make('批量下载');
                $down->handler('link')->uri(route('order/down') . '?keys=selectionKeys');
                $action->add($down);
            })
            ->autoHeight();
        $grid->filter(function (Grid\Filter $filter) {
            $filter->like('order_no')->component(Input::make()->placeholder('订单号'));
            $filter->equal('user_id')->component(Select::make()->placeholder('名称/手机号/身份证号')->filterable()->remote(route('user/search')));
            $filter->equal('status')->component(Select::make()
                ->placeholder('订单状态')
                ->options(function () {
                    $options[] = ['value' => '', 'label' => '全部'];
                    foreach (OrderAlias::STATUS as $key => $title) {
                        $options[] = ['value' => $key, 'label' => $title];
                    }
                    return $options;
                }));
            $filter->between('create_at', '发货时间')->component(DateTimePicker::make()->type('datetimerange'));
        });
        $grid->column('id', '编号')->width(80);
        $grid->column('order_no', '订单编号')->defaultValue('-')->width(200);
        $grid->column('photo.title', '照片名称')->width(150)->component(Tag::make());
        $grid->column('photo.image', '订单照片')->component(Image::make())->width(100);
        $grid->column('user.nickname', '所属用户');
        $grid->column('address.detail', '邮寄地址')->width(200)->customValue(function ($model) {
            return '收货人：' . $model->address->real_name
                . '<br>电话：' . $model->address->phone
                . '<br>地址：' . $model->address->province
                . $model->address->city
                . $model->address->district
                . $model->address->detail;
        });
        $grid->column('price_total', '订单金额')->customValue(function ($model) {
            return toPrice($model->money);
        })->itemPrefix('￥');
        $grid->column('status', '状态')->customValue(function ($data) {
            return OrderAlias::STATUS[$data->status] ?? '';
        });
        $grid->column('address_no', '发货信息')->width(200)->customValue(function ($model) {
            return '物流公司：' . $model->express_company
                . '<br>物流单号：' . $model->express_no;
        });
        $grid->column('create_at', '创建时间')->width(150);
        $grid->actions(function (Grid\Actions $actions) {
            $actions->add(ActionButton::make("发货")->order(4)->dialog(function (Dialog $dialog) use ($actions) {
                $dialog->title("订单发货")->width('500px');
                $dialog->slot(function (Content $content) use ($actions) {
                    $form = $this->deliverForm($actions->getRow());
                    $content->row($form);
                });
            }));
        });
        return $grid;
    }

    /**
     * @GetApi
     *
     */
    public function down()
    {
        $keys = $this->request->query('keys');
        $keys = explode(",", $keys);
        $files = $this->orderService->down($keys);
        return $this->response->download($files);
    }

    protected function form()
    {
        $form = new Form(new OrderAlias());
        $form->className('m-15');
        $form->row(function (Row $row, Form $form) {
            $row->gutter(10);
            $row->column(11, $form->rowItem('price_total', '订单金额')->component(Input::make()));
            //$row->column(11, $form->rowItem('photo.image', '照片')->component(Image::make()));
        });
        $form->item('user_id', '所属用户')->help('可以输入搜索')
            ->component(Select::make()->filterable()
                ->options(
                    function () use ($form) {
                    }
                )
                ->remote(route('user/search')))->inputWidth(450);
        $form->item('status', '状态')->component(Select::make()->options(function () {
            $data = [];
            foreach (OrderAlias::STATUS as $key => $status) {
                $data[] = [
                    'value' => $key,
                    'label' => $status,
                ];
            }
            return $data;
        }));
        $form->item('remark', '备注')->component(Input::make()->textarea(2));
        return $form;
    }

    protected function deliverForm($row)
    {
        $form = new Form();
        $form->action(route('order/deliver'));
        $form->isGetData(false);
        $real_name = $row->address->real_name;
        $phone = $row->address->phone;
        $address = $row->address->province
            . $row->address->city
            . $row->address->district
            . $row->address->detail;

        $form->item('id', '订单ID', 'id')->defaultValue($row->id)->component(Input::make()->readonly());
        $form->item('real_name', '收货人')->defaultValue($real_name)->component(Input::make()->readonly());
        $form->item('phone', '电话')->defaultValue($phone)->component(Input::make()->readonly());
        $form->item('province', '地址')->defaultValue($address)->component(Input::make()->readonly());
        $form->item("express_company", "物流公司")->defaultValue($row->express_company)->required();
        $form->item("express_no", "物流单号")->defaultValue($row->express_no)->required();

        # 用这个是关闭弹窗
        //$form->successRefData('closeDialog', '');
        # 关闭弹窗、并刷新表格  绑定到ref为photo 看54行定义
        $form->successRefData('photo', function () {
            return <<<JS
ref.\$bus.emit("tableReload");
ref.\$bus.emit("closeDialog");
JS;
        });
        $form->actions(function (FormActions $form) {
            $form->hideCancelButton();
            $form->submitButton()->content('发货');
            return $form;
        });
        return $form;
    }

    /**
     * @PostApi
     */
    public function deliver()
    {
        $data = $this->request->getParsedBody();
        $order = OrderAlias::findFromCache($data['id']);
        $order->express_at = date("Y-m-d H:i:s");
        $order->express_no = $data['express_no'];
        $order->express_company = $data['express_company'];
        $order->status = 2;
        $order->save();
        return $this->response->json([
            'message' => '发货成功',
            'code' => 200
        ]);
    }


    protected function code($name = "查看源代码", $ref = "codeButton")
    {
        return Button::make($name)->ref($ref)->dialog(function (Dialog $dialog) use ($name) {
            $dialog->width('80%')->title($name);
            $dialog->slot(function (Content $content) {
                $code = "```php\n";
                $code .= file_get_contents(__FILE__);
                $code .= "\n```";
                $content->body(Markdown::make($code)->style("height:60vh;"));
            });
        });
    }
}
