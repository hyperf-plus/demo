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

use App\Service\MachineService;
use HPlus\Admin\Controller\AbstractAdminController;
use HPlus\Route\Annotation\AdminController;
use HPlus\Route\Annotation\GetApi;
use HPlus\Route\Annotation\PostApi;
use HPlus\UI\Components\Form\CSwitch;
use HPlus\UI\Components\Form\DateTimePicker;
use HPlus\UI\Components\Form\Input;
use HPlus\UI\Components\Form\Select;
use HPlus\UI\Components\Form\Upload;
use HPlus\UI\Components\Grid\Boole;
use HPlus\UI\Components\Grid\Route;
use HPlus\UI\Components\Grid\Tag;
use HPlus\UI\Components\Widgets\Button;
use HPlus\UI\Components\Widgets\Dialog;
use HPlus\UI\Components\Widgets\Divider;
use HPlus\UI\Components\Widgets\Markdown;
use HPlus\UI\Form;
use HPlus\UI\Form\FormActions;
use HPlus\UI\Grid;
use HPlus\UI\Grid\Actions\ActionButton;
use HPlus\UI\Layout\Column;
use HPlus\UI\Layout\Content;
use HPlus\UI\Layout\Row;
use HPlus\UI\UI;
use HPlus\Validate\Annotations\RequestValidation;
use Hyperf\Di\Annotation\Inject;

/**
 * @AdminController(prefix="merchant", tag="机构管理", ignore=true))
 */
class Merchant extends AbstractAdminController
{


    /**
     * @GetApi
     */
    public function search()
    {
        $name = $this->request->query('query');
        $list = \App\Model\Merchant::query()->where('name', 'like', '%' . $name . '%')->get(['name as label', 'merchant_id as value']);
        return $this->response->json(['code' => 200, 'data' => ['data' => $list, 'total' => count($list)]]);
    }

    protected function grid()
    {
        $grid = new Grid(new \App\Model\Merchant());
        $grid->top(function (Content $content) {
            $content->row($this->code())->className('mb-10');
        });

        $grid->ref('merchantGrid');
        $grid
            ->quickSearch(['merchant_id', 'name'])
            ->quickSearchPlaceholder('商户编号 / 商户名称')
            ->pageBackground()
            ->defaultSort('merchant_id', 'desc')
            ->selection()
            ->stripe(true)->emptyText('暂无商家')
            ->perPage(10)
            ->dialogForm($this->form()->isDialog()->backButtonName('关闭'))
            ->autoHeight();
        $grid->column('merchant_id', '编号')->width(80);
        $grid->column('name', '商户名称')->defaultValue('-');
        $grid->column('sales', '总销量')->itemPrefix('￥')->width(100);
        $grid->column('total', '资金')->customValue(function (\App\Model\Merchant $Model) {
            return
                "累计资金：" . $Model->total_money . "<br/>" .
                "提现资金：" . $Model->wd_money . "<br/>" .
                "冻结资金：" . $Model->lock_money;
        });
        $grid->column('real_name', '商户联系人')->defaultValue('-')->width(80);
        $grid->column('phone', '联系电话')->defaultValue('-')->width(100);
        $grid->column('address', '商户地址')->defaultValue('-');
        $grid->column('manages.nickname', '管理员')->component(Tag::make());
        $grid->column('sales', '销量');
        $grid->column('link', '自定义链接')->customValue(function () {
            return '链接名称';
            # 取表格行字段可以用参数 {字段}
        })->component(Route::make("list?id={merchant_id}"));
        $grid->column('status', '商户状态')->component(Boole::make());
        return $grid;
    }

    protected function form()
    {
        $form = new Form(new \App\Model\Merchant());
        $form->className('m-15');
        $form->row(function (Row $row, Form $form) {
            $row->gutter(20);
            $row->column(24, function (Column $column) {
                $column->row(Divider::make("基本资料"));
            });
            $row->column(11, $form->rowItem('name', '商户名称')
                ->component(Input::make())->required());
            $row->column(11, $form->rowItem('address', '商户地址')->component(Input::make()->showWordLimit()->maxlength(20))->required());
        });


        $form->row(function (Row $row, Form $form) {
            $row->gutter(20);
            $row->column(24, function (Column $column) {
                $column->row(Divider::make("联系方式"));
            });
            $row->column(11, $form->rowItem('real_name', '联系人')
                ->component(Input::make())->required());
            $row->column(11, $form->rowItem('phone', '联系电话')->component(Input::make()->showWordLimit()->maxlength(20))->required());
        });

        $form->row(function (Row $row, Form $form) {
            $row->gutter(20);
            $row->column(24, function (Column $column) {
                $column->row(Divider::make("银行资料"));
            });
            $row->column(11, $form->rowItem('bank_name', '开户行')
                ->component(Input::make())->required());
            $row->column(11, $form->rowItem('bank_user', '开户姓名')->component(Input::make()->showWordLimit()->maxlength(20))->required());
        });

        $form->item('manages', '管理员')->component(Select::make()->block()->multiple());
        $form->item('status', '状态')->component(CSwitch::make(1));
        $form->item('mark', '商户备注')->component(Input::make()->textarea(2));
        return $form;
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
