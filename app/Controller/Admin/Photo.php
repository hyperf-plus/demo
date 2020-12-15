<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.plus
 *
 * @link     https://www.hyperf.plus
 * @document https://doc.hyperf.plus
 * @contact  4213509@qq.com
 * @license  https://github.com/hyperf-plus/admin/blob/master/LICENSE
 */

namespace App\Controller\Admin;

use App\Model\Photo as PhotoAlias;
use HPlus\Admin\Controller\AbstractAdminController;
use HPlus\Route\Annotation\AdminController;
use HPlus\UI\Components\Form\Input;
use HPlus\UI\Components\Form\Select;
use HPlus\UI\Components\Form\Upload;
use HPlus\UI\Components\Grid\Image;
use HPlus\UI\Components\Grid\Tag;
use HPlus\UI\Components\Widgets\Button;
use HPlus\UI\Components\Widgets\Dialog;
use HPlus\UI\Components\Widgets\Markdown;
use HPlus\UI\Form;
use HPlus\UI\Grid;
use HPlus\UI\Layout\Content;
use HPlus\UI\Layout\Row;
use Hyperf\Contract\ContainerInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Qbhy\HyperfAuth\AuthManager;

/**
 * @AdminController(prefix="photo", tag="入口文件")
 */
class Photo extends AbstractAdminController
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var AuthManager
     */
    protected $auth;

    public function __construct(AuthManager $auth, ContainerInterface $container, RequestInterface $request, ResponseInterface $response)
    {
        $this->response = $response;
        $this->request = $request;
        $this->auth = $auth;
    }

    protected function grid()
    {
        $grid = new Grid(new PhotoAlias());
        $grid->top(function (Content $content) {
            $content->row($this->code())->className('mb-10');
        });
        $grid
            ->quickSearch(['id', 'title'])
            ->quickSearchPlaceholder('编号 / 标题')
            ->pageBackground()
            ->defaultSort('id', 'desc')
            ->selection()
            ->stripe(true)->emptyText('暂无图片')
            ->perPage(10)
            ->dialogForm($this->form()->isDialog()->backButtonName('关闭'))
            ->autoHeight();
        $grid->filter(function (Grid\Filter $filter) {
            $filter->equal('user_id')->component(Input::make()->placeholder('用户'))
                ->component(Select::make()->placeholder('名称/手机号/身份证号')->filterable()
                    ->remote(route('user/search')));
        });
        $grid->column('id', 'ID')->width(80);
        $grid->column('title', '标题');
        $grid->column('image', '图片')->component(Image::make()->preview())->width(100);
        $grid->column('content', '内容')->customValue(function ($item) {
            $content = (array)$item->content;
            $data = [];
            foreach ($content as $value) {
                if (!is_array($value)) {
                    continue;
                }
                $data[] = $value['content'];
            }
            return $data;
        })->component(Tag::make());
        $grid->column('status', '状态')->customValue(function ($data) {
            return PhotoAlias::STATUS[$data->status] ?? '';
        })->component(Tag::make()->type(PhotoAlias::STATUS_TAGS));
        $grid->column('remark', '备注');
        $grid->column('user.nickname', '所属用户')->component(Tag::make());
        $grid->column('created_at', '创建时间')->width(150);
        $grid->column('updated_at', '更新时间')->width(150);
        return $grid;
    }

    protected function form()
    {
        $form = new Form(new PhotoAlias());
        $form->className('m-15');
        $form->item('title', '标题')->component(Input::make())->required();
        $form->item('image', '图片')->component(Upload::make()->image()->path('image')->uniqueName())->required();
        $form->item('user_id', '所属用户')->help('可以输入搜索')
            ->component(Select::make()->filterable()
                ->options(
                    function () use ($form) {
                    }
                )
                ->remote(route('user/search')))->inputWidth(450);
        $form->item('status', '状态')->component(Select::make()->options(function () {
            $data = [];
            foreach (PhotoAlias::STATUS as $key => $status) {
                $data[] = [
                    'value' => $key,
                    'label' => $status,
                ];
            }
            return $data;
        }));
        $form->item('remark', '备注')->component(Input::make()->textarea(3));
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
