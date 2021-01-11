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

use HPlus\Admin\Exception\ValidateException;
use HPlus\Admin\Facades\Admin;
use HPlus\Admin\Model\Admin\Administrator;
use HPlus\Route\Annotation\ApiController;
use HPlus\Route\Annotation\GetApi;
use HPlus\Route\Annotation\PostApi;
use HPlus\UI\Components\Antv\Area;
use HPlus\UI\Components\Antv\Funnel;
use HPlus\UI\Components\Antv\Pie;
use HPlus\UI\Components\Antv\Column;
use HPlus\UI\Components\Antv\Line;
use HPlus\UI\Components\Widgets\Html;
use HPlus\UI\Components\Antv\StepLine;
use HPlus\UI\Components\Widgets\Alert;
use HPlus\UI\Components\Widgets\Button;
use HPlus\UI\Components\Widgets\Card;
use HPlus\UI\Components\Widgets\Dialog;
use HPlus\UI\Components\Widgets\Markdown;
use HPlus\UI\Entity\MenuEntity;
use HPlus\UI\Entity\UISettingEntity;
use HPlus\UI\Entity\UserEntity;
use HPlus\UI\Layout\Column as LColumn;
use HPlus\UI\Layout\Content;
use HPlus\UI\Layout\Row;
use HPlus\UI\UI;
use Hyperf\Contract\ContainerInterface;
use Hyperf\HttpMessage\Cookie\Cookie;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Utils\Arr;
use Qbhy\HyperfAuth\AuthManager;

/**
 * @ApiController(prefix="auth", tag="入口文件")
 */
class AuthController
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

    /**
     * @GetApi(path="_self_path")
     * @return array|mixed
     */
    public function index()
    {
        $token = $this->request->cookie($this->getCookieName());
        $userInfo = new UserEntity();
        $setting = new UISettingEntity();
        try {
            $user = Admin::user($token);
            $userInfo->setUsername($user->username);
            $userInfo->setName($user->name);
            $userInfo->setId($user->getId());
            $userInfo->setAvatar($user->avatar);
            $userInfo->setToken($token);
            $menuTree = Admin::menu($user);
            $setting->setMenu(new MenuEntity($menuTree));
        } catch (\Throwable $exception) {
        }
        $setting->setUser($userInfo);
        $setting->setApiRoot(config('admin.route.api_prefix'));
        $setting->setUrl([
            'logout' => route('/auth/logout'),
            'setting' => route('/auth/setting'),
        ]);
        $setting->setTitle(config('admin.title'));
        $setting->setName(config('admin.name'));
        $setting->setHomeUrl(config('admin.route.home'));
        return UI::view($setting);
    }

    /**
     * @GetApi
     */
    public function main()
    {
        $content = new Content();
        $content->className('m-15');
        $content->row($this->code());
        $content->row($this->br());
        // 一行多列
        $content->row(function (Row $row) {
            $row->gutter(15);
            $row->column(8, $this->card('此演示项目地址:<a href=http://github.com/hyperf-plus/demo>http://github.com/hyperf-plus/demo</a><br>项目地址:<a href=http://github.com/hyperf-plus/admin>http://github.com/hyperf-plus/admin</a><br>国内    :<a href=https://gitee.com/hyperf-plus/hyperf-admin>https://gitee.com/hyperf-plus/hyperf-admin</a>', '#4DB6AC'));
            $row->column(8, $this->card('<a href=https://qm.qq.com/cgi-bin/qm/qr?k=pCkT8bLR-scfzGhiLYAu2AuEu5pzOfdD&authKey=0L9w5QrmZJQpDdaH9R5WpPK5mUPyh1RiM3nqcRggpMpM8heAgBBXWdzuk9zkyRko&noverify=0>QQ群号：512465490</a>', '#4DB6AC'));
            $row->column(8, $this->card('col-md-8', '#7986CB'));
        });

        // 行里面有多个列,列里面再嵌套行
        $content->row(function (Row $row) {
            $row->gutter(15);
            $row->column(18, function (LColumn $column) {
                // 一列多行
                $column->row(function (Row $row) {
                    $row->gutter(15);
                    $row->column(8, $this->card(['col-md-8', 30], '#80CBC4'));
                    $row->column(8, $this->card(['col-md-8', 30], '#4DB6AC'));
                    $row->column(8, function (LColumn $column) {
                        $column->row(function (Row $row) {
                            $row->gutter(15);
                            $row->column(12, $this->card(['col-md-12', 30], '#26A69A'));
                            $row->column(12, $this->card(['col-md-12', 30], '#26A69A'));
                        });
                    });
                });
            });
            $row->column(6, $this->card(['col-md-6', 30], '#00897B'));
        });

        $content->className('m-10')
            ->row(function (Row $row) {
                $row->gutter(10);
                $row->column(12, Alert::make('你好，同学！！', '欢迎使用 hyperf-plus-admin')->showIcon()->closable(false)->type('success'));
                $row->column(12, Alert::make('你好，同学！！', '欢迎使用 hyperf-plus-admin')->showIcon()->closable(false)->type('error'));
            })->row(function (Row $row) {
                $row->gutter(10);
                $row->className('mt-10');
                $row->column(12, Alert::make('你好，同学！！', '欢迎使用 hyperf-plus-admin')->showIcon()->closable(false)->type('info'));
                $row->column(12, Alert::make('你好，同学！！', '欢迎使用 hyperf-plus-admin')->showIcon()->closable(false)->type('warning'));
            })->row(function (Row $row) {
                $row->gutter(10);
                $row->column(12,
                    Card::make()->bodyStyle(['padding' => '0'])->content(
                        Funnel::make()->data(
                            [
                                ['stage' => '触达次数', 'times' => rand(1, 100), 'uv' => rand(1, 1000), 'conversionUV' => rand(1, 1000)],
                                ['stage' => '响应次数', 'times' => rand(1, 100), 'uv' => rand(1, 1000), 'conversionUV' => rand(1, 1000)],
                                ['stage' => '分享次数', 'times' => rand(1, 100), 'uv' => rand(1, 1000), 'conversionUV' => rand(1, 1000)],
                                ['stage' => '测试', 'times' => rand(1, 100), 'uv' => rand(1, 1000), 'conversionUV' => rand(1, 1000)],
                                ['stage' => '测试33', 'times' => rand(1, 100), 'uv' => rand(1, 1000), 'conversionUV' => rand(1, 1000)],
                            ]
                        )
                            ->config([
                                "xField" => 'stage',
                                "yField" => 'times',
                                "legend" => false,
                                "conversionTag" => false,
                                "interactions" => [
                                    [
                                        "type" => 'element-active',
                                    ]
                                ],
                                "tooltip" => [
                                    "follow" => true,
                                    "enterable" => true,
                                    "offset" => 5,
                                ]
                            ])
                    )
                );
                $row->column(12,
                    Card::make()->bodyStyle(['padding' => '0'])->content(
                        Pie::make()->data([
                            ['type' => '分类1', 'value' => rand(1, 100)],
                            ['type' => '分类2', 'value' => rand(1, 100)],
                            ['type' => '分类3', 'value' => rand(1, 100)],
                            ['type' => '分类4', 'value' => rand(1, 100)],
                            ['type' => '分类5', 'value' => rand(1, 100)],
                        ])->config([
                            "appendPadding" => 10,
                            "angleField" => 'value',
                            "colorField" => 'type'
                        ]))
                );
            })->row(function (Row $row) {
                $row->gutter(10)->className('mt-10');
                $row->column(12, Card::make()->bodyStyle(['padding' => '0'])
                    ->content(

                        Line::make()
                            ->data(function () {
                                $data = collect();
                                for ($year = 2010; $year <= 2020; ++$year) {
                                    $data->push([
                                        'year' => (string)$year,
                                        'type' => '小红',
                                        'value' => rand(100, 1000),
                                    ]);
                                    $data->push([
                                        'year' => (string)$year,
                                        'type' => '小白',
                                        'value' => rand(100, 1000),
                                    ]);
                                }
                                return $data;
                            })
                            ->config(function () {
                                return [
                                    'title' => [
                                        'visible' => true,
                                        'text' => '折线图',
                                    ],
                                    'description' => [
                                        'visible' => true,
                                        'text' => '他们最常用于表现趋势和关系，而不是传达特定的值。',
                                    ],
                                    'seriesField' => 'type',
                                    'smooth' => true,
                                    'xField' => 'year',
                                    'yField' => 'value',
                                ];
                            })
                    ));
                $row->column(12, Card::make()->bodyStyle(['padding' => '0'])->content(
                    Area::make()
                        ->data(function () {
                            $data = collect();
                            for ($year = 2010; $year <= 2020; ++$year) {
                                $data->push([
                                    'year' => (string)$year,
                                    'type' => '小红面积',
                                    'value' => rand(100, 1000),
                                ]);
                                $data->push([
                                    'year' => (string)$year,
                                    'type' => '小白面积',
                                    'value' => rand(100, 1000),
                                ]);
                            }
                            return $data;
                        })
                        ->config(function () {
                            return [
                                'title' => [
                                    'visible' => true,
                                    'text' => '面积图',
                                ],
                                'description' => [
                                    'visible' => true,
                                    'text' => '他们最常用于表现趋势和关系，而不是传达特定的值。',
                                ],
                                'seriesField' => 'type',
                                'smooth' => false,
                                'xField' => 'year',
                                'yField' => 'value',
                            ];
                        })
                ));
            })->row(function (Row $row) {
                $row->gutter(10)->className('mt-10');
                $row->column(12, Card::make()->bodyStyle(['padding' => '0'])->content(
                    StepLine::make()
                        ->data(function () {
                            $data = collect();
                            for ($year = 2010; $year <= 2020; ++$year) {
                                $data->push([
                                    'year' => (string)$year,
                                    'type' => '小红面积',
                                    'value' => rand(100, 1000),
                                ]);
                            }
                            return $data;
                        })
                        ->config(function () {
                            return [
                                'title' => [
                                    'visible' => true,
                                    'text' => '阶梯图',
                                ],
                                'description' => [
                                    'visible' => true,
                                    'text' => '阶梯线图用于表示连续时间跨度内的数据',
                                ],
                                'smooth' => false,
                                'xField' => 'year',
                                'yField' => 'value',
                            ];
                        })
                ));
                $row->column(12, Card::make()->bodyStyle(['padding' => '0'])->content(
                    Column::make()
                        ->data(function () {
                            $data = collect();
                            for ($year = 2010; $year <= 2020; ++$year) {
                                $data->push([
                                    'year' => (string)$year,
                                    'type' => '小红面积',
                                    'value' => rand(100, 1000),
                                ]);
                            }
                            return $data;
                        })
                        ->config(function () {
                            return [
                                'title' => [
                                    'visible' => true,
                                    'text' => '条形图',
                                ],
                                'description' => [
                                    'visible' => true,
                                    'text' => '条形图即是横向柱状图，相比基础柱状图，条形图的分类文本可以横向排布，因此适合用于分类较多的场景',
                                ],
                                'smooth' => false,
                                'xField' => 'year',
                                'yField' => 'value',
                            ];
                        })
                ));
            });
        return $content;
    }

    /**
     * @PostApi
     */
    public function login()
    {
        $data = $this->request->all();
        # 验证器暂无实现，等后期实现后在对此进行改造
        if (!isset($data['username']) || $data['username'] == '') {
            throw new ValidateException(400, '用户名不能为空');
        }
        if (!isset($data['password']) || $data['password'] == '') {
            throw new ValidateException(400, '密码不能为空');
        }
        $user = Administrator::query()->where('username', $data['username'])->first();
        if (empty($user) || !password_verify($data['password'], $user->password)) {
            throw new ValidateException(400, '用户名或密码不正确');
        }
        $token = $this->auth->login($user);
        $data = [];
        $data['message'] = '登录成功';
        $data['status'] = 200;
        $data['redirect'] = route('/auth');
        return $this->response->withCookie($this->getCookie($token))->json($data);
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
    protected function br()
    {
        return Html::make()->html("<br>");
    }
    /**
     * @GetApi
     */
    public function logout()
    {
        $this->auth->logout();
        $redirect = route('/auth');
        return $this->response->withCookie($this->getCookie(''))->redirect($redirect);
    }

    private function getCookie($token)
    {
        $secure = $this->request->getUri()->getScheme() == 'https';
        return new Cookie($this->getCookieName(), $token, 0, '/', $this->request->getUri()->getHost(), $secure, $secure);
    }

    protected function getCookieName()
    {
        return 'HPLUSSESSIONID';
    }
}
