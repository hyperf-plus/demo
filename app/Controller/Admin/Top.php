<?php

namespace App\Controller\Admin;

use HPlus\UI\Components\Grid\Image;
use HPlus\UI\Components\Widgets\Button;
use HPlus\UI\Components\Widgets\Dialog;
use HPlus\UI\Components\Widgets\Markdown;
use HPlus\Admin\Controller\AbstractAdminController;
use HPlus\UI\Grid;
use HPlus\UI\Layout\Content;
use HPlus\Route\Annotation\ApiController;
use HPlus\Route\Annotation\GetApi;

/**
 * @ApiController(tag="TopDemo",ignore=true)
 * Class IndexAdminController
 * @package HPlus\Admin\Controller
 */
class Top extends AbstractAdminController
{
    public function grid()
    {
        $page = request('page');
        $pre = 10;

        $grid = new Grid();

        if ($grid->isGetData()) {

            $start = ($page - 1) * $pre;

            $data = file_get_contents('http://web.peakchao.top:250/music/getMusicBanner');
            $data = json_decode($data, true);
            $lsat_page = (int)10;
            $grid->customData($data['result'], $page, $pre, $lsat_page, 100);
        }

        $grid->autoHeight();
        $grid->column('name')->width(180);
        $grid->column('img', 'Image')->component(Image::make()->preview()->size(270 / 5, 400 / 5))->width(120);
        $grid->column('singer')->width(80);

        $grid->batchActions(function (Grid\BatchActions $actions) {
            $actions->hideDeleteAction();
        });
        $grid->ref("top250");
        $grid->toolbars(function (Grid\Toolbars $toolbars) {
            $toolbars->createButton()->disabled();
            $js = <<<JS
self.attrs.type='success'
self.\$message.success("获取成功，请在浏览器调试器查看打印数据")
console.log(ref)
JS;
            $toolbars->addLeft(Button::make("动态获取已选择的项目")->refData("top250", $js));
            $js = <<<JS
ref.\$refs.top250.clearSelection();
JS;

            $toolbars->addLeft(Button::make("调用表格事件，清除全选")->refData("top250", $js)->className('ml-10'));

            $js = <<<JS
ref.\$bus.emit("tableReload");
JS;

            $toolbars->addLeft(Button::make("手动发送emit")->refData("top250", $js)->className('ml-10'));

            $toolbars->addLeft(Button::make("表格交互")->ref('gButton')->className('ml-10')->dialog(function (Dialog $dialog) {
                $dialog->width('80%');
                $dialog->ref("gDialog")->showClose(false);
                $dialog->slot(function (Content $content) {
                    $this->dialogGrid($content);
                });
                $dialog->title("表格交互");
            }));
            $js = <<<JS
let table = ref.\$refs.top250
table.stripe=false;
table['rowClassName'] = ({row, rowIndex})=>{
        if (rowIndex === 1) {
          return 'warning-row';
        } else if (rowIndex === 3) {
          return 'success-row';
        }
        return '';
}
JS;


            $toolbars->addLeft(Button::make("设置表格row-class-name")->refData("top250", $js)->className('ml-10'));
        });

        $grid->top(function (Content $content) {
            $content->row($this->code())->className('mb-10');
        });

        $grid->selection();
        $grid->actions(function (Grid\Actions $actions) {
            $actions->hideEditAction();
            $actions->hideDeleteAction();
            $title = $actions->getRow()['name'] ?? '';
            $actions->add(Grid\Actions\ActionButton::make("操作：$title"));
        });

        return $grid;
    }


    /**
     * @GetApi(path="dialogGrid")
     * @return array|mixed
     */
    public function apiDialogGrid()
    {
        $content = new Content();
        return  $this->dialogGrid($content)->jsonSerialize();
    }

    protected function dialogGrid(Content $content)
    {
        $page = request('page');
        $pre = 10;
        $grid = new Grid();
        $grid->dataUrl(route('top/dialogGrid'));

        if ($grid->isGetData()) {
            $data = file_get_contents('http://web.peakchao.top:250/music/getMusicBanner');
            $data = json_decode($data, true);
            $lsat_page = (int)10;
            $grid->customData($data['result'], $page, $pre, $lsat_page, 100);
        }
        $grid->column('name')->width(180);
        $grid->column('img.small', 'Image')->component(Image::make()->preview()->size(270 / 5, 400 / 5))->width(120);
        $grid->column('singer')->width(80);
        $grid->hideActions()->selection();
        $grid->toolbars(function (Grid\Toolbars $toolbars) {
            $toolbars->hide();
        });
        $grid->batchActions(function (Grid\BatchActions $actions) {
            $actions->hideDeleteAction();
        });
        if ($grid->isGetData()) {
            return $grid;
        }
        $content->row($grid);
        $grid->ref("dialogGrid");

        $grid->bottom(function (Content $content) {
            $js = <<<JS
ref.\$bus.emit("gButton",{data:"ref.attrs.content = '一共选择了：'+self.selectionRows.length;ref.dialogTableVisible=false;ref.attrs.type='success';",self:ref})

JS;

            $content->row(Button::make("将选中的匹配到页面")->refData("dialogGrid", $js))->className('p-10');
        });


        return $content;
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