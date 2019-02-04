<?php
namespace app\index\controller;

use think\Controller;

class Project extends Controller
{
    public function index()
    {
        /*
         * header posts
         */
        $recent   = db('article')->field('id,title')->order('order', 'desc')->where(['type' => config('article_type.projects')])->limit(3)->select();
        $products = db('article')->field('id,title,order,pic,time,keywords,see,desc')->where(['type' => config('article_type.projects')])->paginate(9);

        $this->view->assign([
            'recent'   => $recent,
            'products' => $products,
        ]);
        return $this->view->fetch('project/projects');
    }
    
    
}
