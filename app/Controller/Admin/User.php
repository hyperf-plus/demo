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
use HPlus\Admin\Controller\AbstractAdminController;
use HPlus\Route\Annotation\AdminController;
use HPlus\Route\Annotation\GetApi;
use HPlus\UI\Components\Attrs\SelectOption;
use HPlus\UI\Components\Form\Input;
use HPlus\UI\Components\Form\Select;
use HPlus\UI\Components\Grid\Avatar;
use HPlus\UI\Components\Grid\Tag;
use HPlus\UI\Components\Widgets\Button;
use HPlus\UI\Components\Widgets\Dialog;
use HPlus\UI\Components\Widgets\Divider;
use HPlus\UI\Components\Widgets\Markdown;
use HPlus\UI\Form;
use HPlus\UI\Grid;
use HPlus\UI\Layout\Content;
use HPlus\UI\Layout\Row;
use function foo\func;

/**
 * @AdminController(prefix="user", tag="机构管理", ignore=true))
 */
class User extends AbstractAdminController
{
    /**
     * @GetApi
     */
    public function search()
    {
        $name = $this->request->query('query');
        $list = \App\Model\Member::query()
            ->where(function ($query) use ($name) {
                $query->orWhere('mobile', 'like', '%' . $name . '%');
                $query->orWhere('id_card', 'like', '%' . $name . '%');
                $query->orWhere('nickname', 'like', '%' . $name . '%');
            })
            ->get(['nickname as label', 'id as value'])->map(function ($item) {
                $item->label = $item->label . '- ID:' . $item->value;
                return $item;
            });
        return $this->response->json(['code' => 200, 'data' => ['data' => $list, 'total' => count($list)]]);
    }

    protected function grid()
    {
        $grid = new Grid(new Member());
        $grid->top(function (Content $content) {
            $content->row($this->code())->className('mb-10');
        });
        $grid
            ->quickSearch(['id', 'nickname'])
            ->quickSearchPlaceholder('用户ID / 昵称')
            ->pageBackground()
            ->defaultSort('id', 'desc')
            ->selection()
            ->stripe(true)->emptyText('暂无')
            ->perPage(10)
            ->dialogForm($this->form()->isDialog()->backButtonName('关闭'))
            ->autoHeight();
        $grid->filter(function (Grid\Filter $filter) {
            $filter->like('mobile')->component(Input::make()->placeholder('手机号'));
            $filter->like('id_card')->component(Input::make()->placeholder('身份证号'));
        });
        $grid->column('id', '编号')->width(80);
        $grid->column('head_pic', '头像')->component(Avatar::make())->width(100);
        $grid->column('nickname', '昵称')->defaultValue('-')->width(150);
        $grid->column('mobile', '手机号');
        $grid->column('money', '账户余额')->itemPrefix('￥');
        $grid->column('total', '快乐个数')->defaultValue('-');
        $grid->column('openid', 'OPENID')->defaultValue('-');

        $grid->column('create_time', '创建时间')->width(150);
        $grid->column('update_time', '更新时间')->width(150);
        $grid->toolbars(function (Grid\Toolbars $toolbars) {
            $toolbars->hideCreateButton();
        });
        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Member());
        $form->className('m-15');
        $form->row(function (Row $row) {
            $row->item(Divider::make('基本信息')->style('color: #909399;'));
        });
        $form->row(function (Row $row, Form $form) {
            $row->gutter(10);
            $row->column(11, $form->rowItem('nickname', '昵称')->component(Input::make()));
            $row->column(11, $form->rowItem('head_pic', '头像')->component(Avatar::make()));
        });

        $form->row(function (Row $row, Form $form) {
            $row->gutter(10);
            $row->column(11, $form->rowItem('money', '账户余额')->component(Input::make()));
            $row->column(11, $form->rowItem('total', '快乐个数')->component(Input::make()));
        });
        $form->row(function (Row $row) {
            $row->item(Divider::make('用户信息'));
        });
        $form->row(function (Row $row, Form $form) {
            $row->gutter(10);
            $row->column(11, $form->rowItem('mobile', '手机号')->component(Input::make()));
            $row->column(11, $form->rowItem('id_card', '身份证号')->component(Input::make()));
        });
        $form->item('remark', '备注')->component(Input::make()->textarea(2));
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
