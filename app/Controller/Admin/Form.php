<?php


namespace App\Controller\Admin;


use HPlus\UI\Components\Attrs\SelectOption;
use HPlus\UI\Components\Attrs\TransferData;
use HPlus\UI\Components\Form\Cascader;
use HPlus\UI\Components\Form\Checkbox;
use HPlus\UI\Components\Form\CheckboxGroup;
use HPlus\UI\Components\Form\ColorPicker;
use HPlus\UI\Components\Form\CSwitch;
use HPlus\UI\Components\Form\DatePicker;
use HPlus\UI\Components\Form\DateTimePicker;
use HPlus\UI\Components\Form\IconChoose;
use HPlus\UI\Components\Form\Input;
use HPlus\UI\Components\Form\InputNumber;
use HPlus\UI\Components\Form\Radio;
use HPlus\UI\Components\Form\RadioGroup;
use HPlus\UI\Components\Form\Rate;
use HPlus\UI\Components\Form\Select;
use HPlus\UI\Components\Form\Slider;
use HPlus\UI\Components\Form\TimePicker;
use HPlus\UI\Components\Form\Transfer;
use HPlus\UI\Components\Form\Upload;
use HPlus\UI\Components\Form\WangEditor;
use HPlus\UI\Components\Widgets\Button;
use HPlus\UI\Components\Widgets\Dialog;
use HPlus\UI\Components\Widgets\Divider;
use HPlus\UI\Components\Widgets\Html;
use HPlus\UI\Components\Widgets\Markdown;
use HPlus\UI\Components\Widgets\Text;
use HPlus\Admin\Controller\AbstractAdminController;
use HPlus\Admin\Facades\Admin;
use HPlus\UI\Form as asForm;
use HPlus\UI\Form\FormActions;
use HPlus\UI\Form\FormItem;
use HPlus\UI\Layout\Content;
use HPlus\UI\Layout\Row;
use HPlus\Admin\Model\Admin\Menu;
use HPlus\Admin\Model\Admin\Permission;
use HPlus\Route\Annotation\ApiController;
use HPlus\Route\Annotation\GetApi;

/**
 * @ApiController(tag="FormDemo",ignore=true)
 * Class IndexAdminController
 * @package HPlus\Admin\Controller
 */
class Form extends AbstractAdminController
{
    /**
     * @GetApi ()
     * @return array|mixed
     */
    public function tree()
    {
        $content = new Content();
        $content->className('m-15');
        $content->row($this->code());
        $content->row($this->br());
        // 单行单列
        $content->description('test');
        //  TreeTable
        return $content;
    }

    public function grid()
    {
    }

    public function store()
    {
        return Admin::responseMessage("表单提交成功");
    }

    public function form($isEdit = false)
    {
        $form = new asForm();
        $form->ref('demoForm');

        $form->item('input')->component(Input::make())->required()->inputWidth(10);
        $form->item('textarea')->component(Input::make()->textarea())->required();
        $form->item('password')->component(Input::make()->password())->required();
        $form->item('file')->component(Upload::make()->file()->multiple()->limit(3));
        $form->item('image')->component(Upload::make()->image()->multiple()->limit(3)->width(200)->height(100));
        $form->item('avatar')->component(Upload::make()->avatar());
        $form->item('IconChoose')->component(IconChoose::make())->required();
        $form->item('InputNumber')->component(InputNumber::make())->required('number');
        $form->item('Select')->component(Select::make()->options(function () {

            return collect(range(0, 50))->map(function () {
                return SelectOption::make(11233, '测试3')->avatar("https://gw.alipayobjects.com/zos/antfincdn/XAosXuNZyF/BiazfanxmamNRoxxVxka.png")->desc("测试2");
            })->all();
        }))->required();
        $form->item('Select-multiple')->component(Select::make()->multiple()->filterable()->options(function () {
            return collect(range(0, 50))->map(function () {
                return SelectOption::make(123123, '哈哈哈')->avatar("https://gw.alipayobjects.com/zos/antfincdn/XAosXuNZyF/BiazfanxmamNRoxxVxka.png")->desc("测试");
            })->all();
        }))->required('array');

        $form->item('Checkbox')->component(Checkbox::make(99999, 'hahah'))->defaultValue(0);


        $form->item('CheckboxGroup')->component(CheckboxGroup::make([10], [
            Checkbox::make(10, "测试1"),
            Checkbox::make(20, "测试2"),
        ]))->required("array");

        $form->item('RadioGroup')->component(RadioGroup::make(11, [
            Radio::make(10, "测试3"),
            Radio::make(11, "测试4"),
        ]))->required("number");

        $form->item('Switch')->component(CSwitch::make(true))->refData('demoForm', function () {
            return <<<JS
ref.formData.Switch2 = self.value
JS;
        })->help("我可以控制下面的Switch2哦");
        $form->item('Switch2')->component(CSwitch::make(true))->ref('Switch2');

        $form->item('Slider')->defaultValue([20, 30])->component(Slider::make()->showInput()->range(true)->max(40)->min(10)->showStops());
        $form->item('Slider-vertical')->defaultValue(20)->component(Slider::make()->max(40)->min(10)->vertical(true, "100px"));

        $form->item('TimePicker')->component(TimePicker::make()->pickerOptions([
            'start' => '00:00',
            'step' => '00:30',
            'end' => '24:00'
        ])->placeholder("TimePicker"));
        $form->item('TimePicker2')->component(TimePicker::make([])->pickerOptions([
            'start' => '00:00',
            'step' => '00:30',
            'end' => '24:00'
        ])->isRange()->rangeSeparator("至")->placeholder("TimePicker"));

        $form->item('DatePicker')->component(DatePicker::make())->ref('DatePicker')->componentRightComponent(function () {
            return (new Content())->row(function (Row $row) {
                $row->item(Text::make("选择类型："));
                $typeStr = "year/month/date/dates/week/datetime/datetimerange/daterange/monthrange";
                foreach (explode("/", $typeStr) as $type) {
                    $row->item(Button::make($type)->type("text")->refData('DatePicker', function () use ($type) {
                        return <<<JS
ref.attrs.type="$type";
JS;
                    }));
                }


            })->className("ml-10");
        });
        $form->item('DatePicker2')->component(DatePicker::make([])->type("daterange"));

        $form->item('DateTimePicker')->component(DateTimePicker::make())->ref('DateTimePicker')->componentRightComponent(function () {
            return (new Content())->row(function (Row $row) {
                $row->item(Text::make("选择类型："));
                $typeStr = "year/month/date/week/datetime/datetimerange/daterange";
                foreach (explode("/", $typeStr) as $type) {
                    $row->item(Button::make($type)->type("text")->refData('DateTimePicker', function () use ($type) {
                        return <<<JS
ref.attrs.type="$type";
JS;
                    }));
                }


            })->className("ml-10");
        });

        $form->item('Rate')->component(Rate::make(1));
        $form->item('ColorPicker')->component(ColorPicker::make("#ff6600"));

        $form->item('Cascader')
            ->component(function () {
                return Cascader::make()->options((new Menu())->toTree())->value('id')->label('title')->expandTrigger('hover')->ref('Cascader');
            })
            ->componentBottomComponent(function () {
                return Content::make()->row(function (Row $row) {
                    $button = Button::make("改变Cascader面板模式")->type('danger')->size('mini')->plain()->refData('Cascader', function () {
                        return <<<JS
ref.attrs.panel = !ref.attrs.panel
JS;
                    })->className('mt-10')->tooltip('我是动态注入实现的功能');
                    $row->item(Html::make("下边"));
                    $row->item($button);

                    $row->item(Html::make("下边"));
                });
            })
            ->componentTopComponent(Html::make("上边")->ref("zrHtml"))
            ->componentLeftComponent(Html::make("左边"))
            ->componentRightComponent(Html::make("右边组件：可以选择一下联动数据，看下我的变化")->ref("zrHtml")->className('ml-10'))
            ->topComponent(Divider::make("item上边组件"))
            ->bottomComponent(Divider::make("item底部组件"))->refData("zrHtml", function () {
                return <<<JS
ref.attrs.html = "动态注入change事件，获取到选择的数据，展现到这个组件："+self.value.join("-")
JS;

            });


        $form->item('Transfer', "权限", 'permissions.id')->component(
            Transfer::make()->data(Permission::get()->map(function ($item) {
                return TransferData::make($item->id, $item->name);
            }))->titles(['可授权', '已授权'])->filterable()
        );


        $form->item('WangEditor')->component(WangEditor::make()->style('height:200px;')->className('flex-sub'));


        $form->top(function (Content $content) {
            $content->row($this->code())->className('mb-10');
        });


        $form->successRefData("demoForm", function () {
            return <<<JS
self.\$message.info("表单提交成功代码注入");
JS;

        });

        $form->actions(function (FormActions $formActions) {
            $formActions->hideCancelButton();

            $formActions->submitButton()->content("提交表单")->style("width:200px");

            $formActions->fixed();

            $formActions->getForm();
        });

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