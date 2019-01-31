<?php
namespace app\admin\validate;
use think\Validate;

class Banner extends Validate
{
    protected $rule = [     //错误规则
        'title'    => 'unique:article|require|max:60',    //此处的unique必须跟表明(如link),才能生效
        'content'  => 'require',
    ];
    
    protected $message = [
        'title.require'   => '标题不得为空',
        'title.unique'    => '标题不得重复',
        'content.require' => '内容不得为空',
    ];
    
    protected $scene = [    //场景有二,一个是添加,一个是编辑
        'add' => ['title' => 'unique:article|require','content'],
        'edit'=> ['title'],               //这里只是定义继承了title和cate的验证，content没有定义
    ];
}
