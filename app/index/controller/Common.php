<?php
namespace app\index\controller;

use think\Controller;

class Common extends Controller
{
    public function _initialize()
    {
        /*
         * header posts
         */
        $recent   = db('article')->field('id,title')->order('order', 'desc')->where(['type' => config('article_type.blog')])->limit(3)->select();
        $system   = db('system')->find(1);
        if ($system['is_close'] == config('website.close')){
            echo '<h2 style="text-align: center;margin-top: 200px;">Alethea已关闭，谢谢</h2>';
            die;
        }

        $this->view->assign([
            'recent'   => $recent,
            'system'   => $system,
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
