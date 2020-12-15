<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use HPlus\UI\Components\Widgets\Button as Button;
use HPlus\UI\Components\Widgets\Card;
use HPlus\UI\Components\Widgets\Dialog;
use HPlus\UI\Components\Widgets\Html;
use HPlus\UI\Components\Widgets\Markdown;
use HPlus\Admin\Controller\AbstractAdminController;
use HPlus\UI\Layout\Content;
use HPlus\UI\Layout\Row;
use HPlus\Route\Annotation\ApiController;
use HPlus\Route\Annotation\GetApi;

/**
 * @ApiController(tag="DemoButton",ignore=true)
 * Class IndexAdminController
 * @package HPlus\Admin\Controller
 */
class ButtonController extends AbstractAdminController
{
    /**
     * @GetApi()
     * @return Content
     */
    public function index()
    {
        $content = new Content();
        $content->className('m-15');


        $content->row($this->code());

        $content->row($this->br());


        $content->row(Card::make()->header("基础用法")->content(function (Content $content) {
            $content->row(function (Row $row) {
                $row->item(Button::make("默认按钮")->type('default'));
                $row->item(Button::make("主要按钮"));
                $row->item(Button::make("成功按钮")->type('success'));
                $row->item(Button::make("信息按钮")->type('info'));
                $row->item(Button::make("警告按钮")->type('warning'));
                $row->item(Button::make("危险按钮")->type('danger'));
            });
            $content->row($this->br());
            $content->row(function (Row $row) {
                $row->item(Button::make("朴素按钮")->type('default')->plain());
                $row->item(Button::make("主要按钮")->plain());
                $row->item(Button::make("成功按钮")->type('success')->plain());
                $row->item(Button::make("信息按钮")->type('info')->plain());
                $row->item(Button::make("警告按钮")->type('warning')->plain());
                $row->item(Button::make("危险按钮")->type('danger')->plain());
            });
            $content->row($this->br());
            $content->row(function (Row $row) {
                $row->item(Button::make("圆角按钮")->type('default')->round());
                $row->item(Button::make("主要按钮")->round());
                $row->item(Button::make("成功按钮")->type('success')->round());
                $row->item(Button::make("信息按钮")->type('info')->round());
                $row->item(Button::make("警告按钮")->type('warning')->round());
                $row->item(Button::make("危险按钮")->type('danger')->round());
            });
            $content->row($this->br());
            $content->row(function (Row $row) {
                $row->item(Button::make()->type('default')->icon('el-icon-search')->circle()->size('medium'));
                $row->item(Button::make()->icon('el-icon-edit')->circle());
                $row->item(Button::make()->type('success')->icon('el-icon-check')->circle());
                $row->item(Button::make()->type('info')->icon('el-icon-message')->circle());
                $row->item(Button::make()->type('warning')->icon('el-icon-star-off')->circle());
                $row->item(Button::make()->type('danger')->icon('el-icon-delete')->circle());
            });
        }));
        $content->row($this->br());

        $content->row(Card::make()->header("禁用状态")->content(function (Content $content) {
            $content->row(function (Row $row) {
                $row->item(Button::make("默认按钮")->type('default')->disabled());
                $row->item(Button::make("主要按钮")->disabled());
                $row->item(Button::make("成功按钮")->type('success')->disabled());
                $row->item(Button::make("信息按钮")->type('info')->disabled());
                $row->item(Button::make("警告按钮")->type('warning')->disabled());
                $row->item(Button::make("危险按钮")->type('danger')->disabled());
            });
            $content->row($this->br());
            $content->row(function (Row $row) {
                $row->item(Button::make("朴素按钮")->type('default')->plain()->disabled());
                $row->item(Button::make("主要按钮")->plain()->disabled());
                $row->item(Button::make("成功按钮")->type('success')->plain()->disabled());
                $row->item(Button::make("信息按钮")->type('info')->plain()->disabled());
                $row->item(Button::make("警告按钮")->type('warning')->plain()->disabled());
                $row->item(Button::make("危险按钮")->type('danger')->plain()->disabled());
            });
        }));

        $content->row($this->br());

        $content->row(Card::make()->header("文字按钮")->content(function (Content $content) {
            $content->row(function (Row $row) {
                $row->item(Button::make("文字按钮")->type('text'));
                $row->item(Button::make("文字按钮")->type('text')->disabled());
            });
        }));

        $content->row($this->br());

        $content->row(Card::make()->header("不同尺寸")->content(function (Content $content) {
            $content->row(function (Row $row) {
                $row->item(Button::make("默认按钮")->type('default')->size('default'));
                $row->item(Button::make("中等按钮")->type('default')->size('medium'));
                $row->item(Button::make("小型按钮")->type('default')->size('small'));
                $row->item(Button::make("超小按钮")->type('default')->size('mini'));
            });
            $content->row($this->br());
            $content->row(function (Row $row) {
                $row->item(Button::make("默认按钮")->type('default')->round()->size('default'));
                $row->item(Button::make("中等按钮")->type('default')->round()->size('medium'));
                $row->item(Button::make("小型按钮")->type('default')->round()->size('small'));
                $row->item(Button::make("超小按钮")->type('default')->round()->size('mini'));
            });
        }));

        $content->row($this->br());

        $content->row(Card::make()->header("事件处理")->content(function (Content $content) {
            $this->handler($content);
            $content->row($this->br());
            $content->row($this->code("弹窗按钮", "DialogButton"));
            $content->row($this->br());


            $content->row(function (Row $row) {
                $data = <<<JS
ref.attrs.disabled= !_this.attrs.disabled;
JS;
                $row->item(Button::make("改变弹窗按钮属性")->tooltip("这里改变的是弹窗按钮的attrs，修改的是props")->refData("DialogButton", $data));
                $data = <<<JS
ref.dialogTableVisible= !_this.dialogTableVisible;
JS;
                $row->item(Button::make("跨组件调用")->tooltip("这里改变的是弹窗按钮的组件data")->refData("DialogButton", $data));

                $url = route('demo/request');
                $data = <<<JS
ref.loading = true;
ref.axios.get("$url").then(res=>{
    console.log(res);
    ref.attrs.content = res.message
    ref.attrs.disable = true
    ref.loading = false;
});
JS;

                $row->item(Button::make("在组件内注入逻辑")->refData("logic", $data));
                $row->item(Button::make("我是被注入逻辑的组件")->type('danger')->ref('logic'));
            });

        }));

        return $content;
    }


    protected function handler(Content $content)
    {
        $content->row(function (Row $row) {
            $row->item(Button::make("路由跳转")->handler(Button::HANDLER_ROUTE)->uri('/home')->tooltip("跳转到首页"));
            $row->item(Button::make("链接跳转")->handler(Button::HANDLER_LINK)->uri('https://laravel-vue-admin.com')->message("是否要跳转？"));
            $row->item(Button::make("异步请求")->handler(Button::HANDLER_REQUEST)->uri(route('demo/request')));
            $row->item(function () {
                return Button::make("异步请求-请求前触发事件")
                    ->type("info")
                    ->handler(Button::HANDLER_REQUEST)
                    ->uri(route('demo/request'))
                    ->beforeEmit("message", ["type" => "info", "message" => "请求前触发的事件消息"]);
            });
            $row->item(function () {
                return Button::make("异步请求-请求成功触发事件")
                    ->type("success")
                    ->handler(Button::HANDLER_REQUEST)
                    ->uri(route('demo/request'))
                    ->successEmit("message", ["type" => "success", "message" => "请求成功触发事件"]);
            });
            $row->item(function () {
                return Button::make("异步请求-请求完成触发事件")
                    ->type("default")
                    ->tooltip("不管成功还是失败都会触发")
                    ->handler(Button::HANDLER_REQUEST)
                    ->uri(route('demo/request', ['error' => true]))
                    ->afterEmit("message", ["type" => "info", "message" => "请求完成触发事件"]);
            });
        });
    }

    protected function br()
    {
        return Html::make()->html("<br>");
    }

    protected function code($name = "查看源代码", $ref = "codeButton")
    {
        return Button::make($name)->ref($ref)->dialog(function (Dialog $dialog) use ($name) {
            $dialog->width('80%')->title($name);
            $dialog->slot(function (Content $content) {
                $code = "```php\n";
                $code .= file_get_contents((__FILE__));
                $code .= "\n```";
                $content->body(Markdown::make($code)->style("height:60vh;"));
            });
        });
    }

}