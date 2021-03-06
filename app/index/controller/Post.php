<?php
namespace app\index\controller;

class Post extends Common
{

    public function index()
    {
        if (empty(input('id'))) $this->error('非法参数');
        $post = db('article')->find(input('id'));
        if (empty($post)) $this->error('非法参数');

        //数据更新
        db('article')->where('id', input('id'))->setInc('see');

        $this->view->assign([
            'post'  => $post,
        ]);
        return $this->view->fetch('post/post');
    }
    
    
}
