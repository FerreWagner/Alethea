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
        $this->artSee();

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

    public function artSee()
    {
         $see_time  = db('artsee')->field('time')->where('ip', request()->ip())->order('time', 'desc')->find();
         if ((time() - $see_time['time']) > 30){
             $see = [
                 'type'     => $this->getBrowser(),
                 'rid'      => 1,
                 'ip'       => request()->ip(),
                 'country'  => '',
                 'province' => '',
                 'city'     => '',
                 'time'     => time(),
             ];
             db('artsee')->insert($see);
         }

//         if (empty($see_time)){    //(time() - $see_time['time']) > 30 ||
//
//             //sina地理位置接口
//             //&改为'(&)'或%26
//             $area      = file_get_contents("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip={$request->ip()}");
//             $arr_data  = json_decode($area, true);
//             $error     = json_last_error();
//
//             //json是否存在错误
//             if (!empty($error)) {
//                 $see = [
//                     'type'     => $this->getBrowser(),
//                     'rid'      => $rid,
//                     'ip'       => $request->ip(),
//                     'country'  => '',
//                     'province' => '',
//                     'city'     => '',
//                     'time'     => time(),
//                 ];
//             }else {
//                 $see = [
//                     'type'     => $this->getBrowser(),
//                     'rid'      => $rid,
//                     'ip'       => $request->ip(),
//                     'country'  => $arr_data['country'],
//                     'province' => $arr_data['province'],
//                     'city'     => $arr_data['city'],
//                     'time'     => time(),
//                 ];
//             }
//             db('artsee')->insert($see);
//         }

    }

    /**
     * user get browser
     * @return string
     */
    public function getBrowser()
    {

        switch ($_SERVER['HTTP_USER_AGENT'])
        {
            case null:
                return 'machine';
                break;

            case false !== strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 9.0'):
                return 'ie9';
                break;

            case false !== strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 8.0'):
                return 'ie8';
                break;

            case false !== strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0'):
                return 'ie7';
                break;

            case false !== strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0'):
                return 'ie6';
                break;

            case false !== strpos($_SERVER['HTTP_USER_AGENT'],'Firefox'):
                return 'fox';
                break;

            case false !== strpos($_SERVER['HTTP_USER_AGENT'],'Chrome'):
                return 'chrome';
                break;

            case false !== strpos($_SERVER['HTTP_USER_AGENT'],'Safari'):
                return 'safari';
                break;

            case false !== strpos($_SERVER['HTTP_USER_AGENT'],'Opera'):
                return 'opera';
                break;

            case false !== strpos($_SERVER['HTTP_USER_AGENT'],'360SE'):
                return '360se';
                break;

            default:
                return 'notidentify';
                break;

        }

    }
    
    
}
