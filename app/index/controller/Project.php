<?php
namespace app\index\controller;

class Project extends Common
{
    public function index()
    {
        /*
         * header posts
         */
        $products = db('article')->field('id,title,order,pic,time,keywords,see,desc')->where(['type' => config('article_type.projects')])->paginate(8);

        $this->view->assign([
            'products' => $products,
        ]);
        return $this->view->fetch('project/projects');
    }
    
    
}
