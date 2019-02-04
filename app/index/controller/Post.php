<?php
namespace app\index\controller;

use think\Controller;

class Post extends Controller
{
    public function _initialize()
    {
        /*
         * header posts
         */
        $recent   = db('article')->field('id,title')->order('order', 'desc')->where(['type' => config('article_type.projects')])->limit(3)->select();
        $this->view->assign([
            'recent'   => $recent,
        ]);
    }

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
