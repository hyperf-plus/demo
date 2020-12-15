<?php
declare(strict_types=1);
namespace App\Controller\Admin;
use HPlus\Admin\Components\Widgets\Alert;
use HPlus\Admin\Components\Widgets\Button as Button;
use HPlus\Admin\Components\Widgets\Dialog;
use HPlus\Admin\Components\Widgets\Html;
use HPlus\Admin\Components\Widgets\Markdown;
use HPlus\Admin\Controller\AbstractAdminController;
use HPlus\Admin\Layout\Content;
use HPlus\Route\Annotation\AdminController;
use HPlus\Route\Annotation\ApiController;
use HPlus\Route\Annotation\GetApi;
use HPlus\Route\Annotation\PostApi;
/**
 * @ApiController(tag="alert警告",ignore=true)
 * Class IndexAdminController
 * @package HPlus\Admin\Controller
 */
class AlertController extends AbstractAdminController
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
        $content->row(Alert::make("成功提示的文案", "文字说明文字说明文字说明文字说明文字说明文字说明")->type('success')->showIcon());
        $content->row($this->br());
        $content->row(Alert::make("消息提示的文案", "文字说明文字说明文字说明文字说明文字说明文字说明")->type('info')->showIcon());
        $content->row($this->br());
        $content->row(Alert::make("警告提示的文案", "文字说明文字说明文字说明文字说明文字说明文字说明")->type('warning')->showIcon());
        $content->row($this->br());
        $content->row(Alert::make("错误提示的文案", "文字说明文字说明文字说明文字说明文字说明文字说明")->type('error')->showIcon()->ref("errorAlert"));
        $content->row($this->br());
        //ref 就是组件内的this
        $js = '
ref.$refs.errorAlert.close = ()=>{
    alert("我是被注入的事件")
}
ref.$message.success("注入成功，可以点击关闭按钮试试");
';
        $content->row(Button::make("动态注入错误提示的文案的关闭回调事件")->refData("errorAlert", $js)->plain());

        return $content;
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
                $code .= file_get_contents(__FILE__);
                $code .= "\n```";
                $content->body(Markdown::make($code)->style("height:60vh;"));
            });
        });
    }
}