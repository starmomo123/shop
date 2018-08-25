<?php

namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'id' => ['number'],
	    'name' => ['require', 'max:10'],
        'parent_id' => ['require', 'number'],
        'listorder' => ['number'],
        'status' => ['number', 'in:-1,0,1']
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'id.number' => '分类id必须是数字',
        'name.require' => '分类名不能为空',
        'name.max' => '分类名最大不能超过10个字符',
        'parent_id.number' => '父分类必须是数字',
        'status.in' => '分类状态范围不合法'
    ];

    protected $scene = [
        'add' => ['name', 'parent_id'],   //添加操作
        'listOrder' => ['id', 'listorder'], //排序操作
        'edit' => ['id'] //编辑操作
    ];
}
