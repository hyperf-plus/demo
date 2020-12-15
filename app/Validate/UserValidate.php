<?php


namespace App\Validate;


use HPlus\Validate\Validate;

class UserValidate extends Validate
{
    /**
     * 验证规则
     * @var array
     */
    protected $rule = [
        'user_id' => 'integer|gt:0',
        'username' => 'require|length:4,20',
        'password' => 'require|min:6|confirm',
        'mobile' => 'require|number|length:7,15|unique:user,mobile,0,user_id',
        'code' => 'integer|max:6',
        'email' => 'email|max:60',
        'nickname' => 'max:50',
        'head_pic' => 'max:512',
        'sex' => 'in:0,1,2',
        'birthday' => 'date|dateFormat:Y-m-d',
        'user_level_id' => 'integer|gt:0',
        'group_id' => 'integer|gt:0',
        'status' => 'in:0,1',
        'password_old' => 'min:6',
        'refresh' => 'max:512',
        'sign' => 'max:128',
        'account' => 'max:80',
        'platform' => 'max:50',
        'page' => 'integer|gt:0',
        'limit' => 'integer|gt:0',
        'order_type' => 'in:asc,desc',
        'order_field' => 'in:user_id,username,group_id,mobile,nickname,sex,birthday,user_level_id,status,create_time,name,discount',

    ];

    /**
     * 字段描述
     * @var array
     */
    protected $field = [
        'user_id' => '账号编号',
        'encryptedData' => '密文',
        'iv' => '密文',
        'username' => '账号',
        'password' => '密码',
        'mobile' => '手机号',
        'code' => '手机验证码',
        'wx_code' => 'code',
        'sign' => '代表作、签名',
        'email' => '邮箱地址',
        'nickname' => '昵称',
        'head_pic' => '头像',
        'sex' => '性别',
        'birthday' => '生日',
        'user_level_id' => '会员等级',
        'group_id' => '所属用户组',
        'status' => '账号状态',
        'password_old' => '原始密码',
        'last_login' => '登录日期',
        'account' => '账号、昵称、手机号',
        'platform' => '来源平台',
        'page' => '页码',
        'limit' => '每页数量',
        'order_type' => '排序方式',
        'order_field' => '排序字段',
        'introduce' => '个人介绍',
        'org_img' => '证件照片',
        'id_card' => '证件号码',
        'bank_code' => '银行账户',
        'company' => '签约公司',
        'bank_name' => '开户行名称',
        'real_name' => '真实姓名',
        'idcard_face_img' => '身份证正面照片',
        'idcard_rear_img' => '身份证反面照片',
        'user_type' => '身份类型',
        'cate_label' => '种类标签',
        'quoted' => '报价'
    ];

    /**
     * 场景规则
     * @var array
     */
    protected $scene = [
        'update' => [
            'group_id',
            'nickname', 'head_pic',
            'introduce',
            'sign',
        ],
        'status' => [
            'user_id' => 'require|arrayHasOnlyInts',
            'status' => 'require|in:0,1',
        ],
        'change' => [
            'user_id' => 'require|integer|gt:0',
            'password',
            'password_old',
        ],
        'del' => [
            'user_id' => 'require|arrayHasOnlyInts',
        ],
        'item' => [
            'user_id' => 'require|integer|gt:0',
        ],
        'login' => [
            'username' => 'require|alphaDash|length:4,20',
            'password' => 'require|min:6',
        ],
        'refresh' => [
            'refresh' => 'require|max:512',
        ],
        'code' => [
            'wx_code' => 'require|max:32',
            'pid' => 'integer'
        ],
        'wx_register' => [
            'encryptedData' => 'require|max:1024',
            'iv' => 'require|max:50'
        ],
        'send_code' => [
            'mobile' => 'require|number|length:11,11',
            'type' => 'require|number|in:1,2,3'
        ],
        'verify' => [
            'code' => 'require|length:6,6',
            'mobile' => 'require|number|length:11,11',
            'username' => 'require|max:12',
            'id_card' => 'require|max:18',
        ],
        'list' => [
            'user_level_id',
            'group_id',
            'account',
            'status',
            'page',
            'limit',
            'order_type',
            'order_field',
        ],
        'find' => [
            'username' => 'require|alphaDash|length:4,20',
            'mobile' => 'require|number|length:7,15',
            'password',
        ],
    ];
}
