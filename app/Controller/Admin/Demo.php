<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Hoa\Compiler\Llk\TreeNode;
use HPlus\Admin\Admin;
use HPlus\UI\Components\Attrs\SelectOption;
use HPlus\UI\Components\Form\IconChoose;
use HPlus\UI\Components\Form\InputNumber;
use HPlus\UI\Components\Form\Select;
use HPlus\UI\Components\Widgets\BaseForm;
use HPlus\UI\Components\Widgets\Button;
use HPlus\UI\Components\Widgets\Card;
use HPlus\UI\Components\Widgets\Category;
use HPlus\UI\Components\Widgets\Dialog;
use HPlus\UI\Components\Widgets\Html;
use HPlus\UI\Components\Widgets\Markdown;
use HPlus\Admin\Controller\AbstractAdminController;
use HPlus\Admin\Form;
use HPlus\Admin\Grid;
use HPlus\UI\Layout\Column;
use HPlus\UI\Layout\Content;
use HPlus\UI\Layout\Row;
use HPlus\Admin\Model\Admin\Menu;
use HPlus\Admin\Traits\HasApiCreate;
use HPlus\UI\Tree;
use HPlus\Route\Annotation\ApiController;
use HPlus\Route\Annotation\GetApi;
/**
 * @ApiController(tag="Demo",ignore=true)
 * Class IndexAdminController
 * @package HPlus\Admin\Controller
 */
class Demo extends AbstractAdminController
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

        // 单行单列
        $content->row($this->card('col-md-24', '#81C784'));

        // 一行多列
        $content->row(function (Row $row) {
            $row->gutter(15);
            $row->column(8, $this->card('col-md-8', '#7986CB'));
            $row->column(8, $this->card('col-md-8', '#7986CB'));
            $row->column(8, $this->card('col-md-8', '#7986CB'));
        });

        // 行里面有多个列,列里面再嵌套行
        $content->row(function (Row $row) {
            $row->gutter(15);
            $row->column(18, function (Column $column) {
                // 一列多行
                $column->row($this->card(['col-md-24', 20], '#4DB6AC'));
                // 行里面再嵌套列
                $column->row(function (Row $row) {
                    $row->gutter(15);
                    $row->column(8, $this->card(['col-md-8', 30], '#80CBC4'));
                    $row->column(8, $this->card(['col-md-8', 30], '#4DB6AC'));
                    $row->column(8, function (Column $column) {
                        $column->row(function (Row $row) {
                            $row->gutter(15);
                            $row->column(12, $this->card(['col-md-12', 30], '#26A69A'));
                            $row->column(12, $this->card(['col-md-12', 30], '#26A69A'));
                        });
                    });
                });
            });
            $row->column(6, $this->card(['col-md-6', 120], '#00897B'));
        });
        return $content;
    }

    protected function br()
    {
        return Html::make()->html("<br>");
    }

    protected function p($text, $height = 80)
    {
        return "<p style='height:{$height}px;color:#fff'><span>$text</span></p>";
    }

    protected function card($text, $color = '#fff')
    {
        $text = $this->p(...(is_string($text) ? [$text] : $text));

        $html = <<<EOF
<div style="background:$color;padding:10px 22px 16px;box-shadow:0 1px 3px 1px rgba(34, 25, 25, 0.1);margin-bottom:15px;border-radius: 5px;">
$text
</div>
EOF;
        return Html::make()->html($html);

    }

    protected function code()
    {
        return Button::make("查看源代码")->dialog(function (Dialog $dialog) {
            $dialog->width('80%')->title("查看源码");
            $dialog->slot(function (Content $content) {
                $code = "```php\n";
                $code .= file_get_contents(__FILE__);
                $code .= "\n```";

                $content->body(Markdown::make($code)->style("height:60vh;"));
            });
        });
    }

}
