<?php
namespace app\index\controller;

use think\Controller;

/**
 * TODO 静态资源pic的删除
 * TODO upload_max_filesize=6M
 *
 */

class Index extends Controller
{

    public function index()
    {
        /**
         * # recent post
         * # links
         * # keywords
         * # ARCHIVES
         * # 分页数据
         * 文章keywords
         * # category
         * # index 770X400px
         */
        //url模糊查询
        if (!empty(input('author'))){
            $input_author = input('author');
            $where = 'author like "%'.$input_author.'%"';
        }
        $where_blog   = ['type' => config('article_type.blog')];
        $blogs    = db('article')->field('a.*,b.catename')->alias('a')->join('alexa_category b','a.cate=b.id')->order('a.id desc')->where(['type' => config('article_type.blog')])->where($where)->paginate(6);
        $archives = db('article')->field('author')->group('author')->order('see', 'desc')->select();  //ARCHIVES data

        if (!empty(input('cateid'))){
            $where_blog = array_merge($where_blog, ['cate' => intval(input('cateid'))]);
            $blogs    = db('article')->field('a.*,b.catename')->alias('a')->join('alexa_category b','a.cate=b.id')->order('a.id desc')->where($where_blog)->where($where)->paginate(6);
        }
        $links    = db('link')->field('name,url')->order('sort', 'desc')->select();
        $keywords = (db('system')->field('keywords')->find())['keywords'];
        $recent   = db('article')->field('id,title')->order('order', 'desc')->where($where_blog)->limit(3)->select();
        $now_post = db('article')->field('a.*,b.catename')->alias('a')->join('alexa_category b','a.cate=b.id')->order('a.id desc')->where(['type' => config('article_type.blog')])->limit(5)->select();
        $cate     = db('category')->field('id,catename')->order('sort', 'desc')->select();
        $banner   = db('article')->field('id,title,desc,content,pic')->where(['type' => config('article_type.banner')])->order('order','desc')->select();

        $this->view->assign([
            'links'    => $links,
            'keywords' => explode(',', $keywords),
            'recent'   => $recent,
            'blogs'    => $blogs,
            'cate'     => $cate,
            'now_post' => $now_post,
            'banner'   => $banner,
            'archives' => $archives,
        ]);
        return $this->view->fetch('index');
    }

    /**
     * 单条文章blog
     */
    public function singlePost()
    {
        if (!empty(input('id'))){
            $data = db('article')->find(['id' => input('id')]); //单文章数据
            halt(1);die;
        }
    }

//    /**
//     * @return string
//     * contactMe page
//     */
//    public function contactMe()
//    {
//        return $this->view->fetch('index/contact');
//    }

    /**
     * @return string
     * aboutMe page
     */
    public function aboutMe()
    {
        return $this->view->fetch('index/about');
    }


    
}
