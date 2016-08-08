<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;

use App\Http\Model\Category;
use App\Http\Model\Links;
use App\Http\Model\Zambia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    public function index()
    {

        //顶部文章 banner
        $top = Article::where('art_top','yes')->get();
        //周排行五遍文章
        $weekHot = Article::orderBy('art_view','desc')->take(5)->get();
        //最新发布的文章8篇
        $new = Article::orderBy('art_time','desc')->paginate(5);
        foreach($new as $k=>$v) {
            $new[$k]->keys = explode(',', $v['art_tag']);
        }
        return view('home.index',compact('weekHot','allHot','new','top'));

    }

    //get.cate/{cate_id?}   列表
    public function cate($cate_id=-1)
    {
//        $count = Article::where('cate_id', $cate_id)->count();
        if($cate_id!=-1) {
            $cate = Category::find($cate_id);

            $cate_list[] = $cate;

            if ($cate->cate_pid==0) {
                $arts = Article::Join('category','category.cate_id','=','article.cate_id')->where('cate_pid', $cate_id)->paginate(5);
                $sup_cate = Category::where('cate_pid', $cate_id)->get();
            }else{
                $arts = Article::where('cate_id', $cate_id)->paginate(5);
                $sup_cate = Category::where('cate_pid', $cate->cate_pid)->get();
                $cate = Category::find($cate->cate_pid);
                $cate_list[] = $cate;
            }
            $cate_list = array_reverse($cate_list);

            //查看次数自增
            Category::where('cate_id',$cate_id)->increment('cate_view');

            foreach($arts as $k=>$v) {
                $arts[$k]->keys = explode(',', $v['art_tag']);
            }

            return view('home.list',compact('arts','cate','sup_cate','cate_list','cate_id'));
        }else{
            return view('errors.404');
        }
    }

    //get.art/{art_id?}   文章
    public function article($art_id=-1)
    {
        $count = Article::where('art_id', $art_id)->count();
        if($count!=1) {
            return view('errors.404');
        }else{
            //当前文章
            $art = Article::Join('category','category.cate_id','=','article.cate_id')->where('art_id', $art_id)->first();

            //上一篇 下一篇
            $field['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
            $field['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();

            //查看次数自增
            Article::where('art_id',$art_id)->increment('art_view');

            //相关文章
            $data = Article::where('cate_id',$art->cate_id)->orderBy('art_id','desc')->take(4)->get();

            //读者IP
            $uip = parent::Get_real_ip();

            //赞
            $count = Zambia::where('zan_uip',$uip)->where('zan_aid',$art_id)->count();
            $zan_count = Zambia::where('zan_aid',$art_id)->count();
            if ($count>0){
                $zan = [
                    'status' => '已赞',
                    'num' => $zan_count
                ];
            }else{
                $zan = [
                    'status' => '点赞',
                    'num' => $zan_count
                ];
            }

            //分隔标签重组数组
            $art->_art_tags = explode(',', $art['art_tag']);

            return view('home.new',compact('art','field','data','uip','zan'));
        }
    }

    public function zambia($art_id = -1)
    {
        $input = Input::except('_token');
        $uip = Zambia::where('zan_uip',$input['zan_uip'])->where('zan_aid',$art_id)->count();
        if ($uip>0){
            $msg = [
                'status' => 1,
                'data' => '这篇文章您已经点过赞啦！'
            ];
        }else {
            $re = Zambia::create($input);
            if ($re) {
                $data = Zambia::where('zan_aid', $art_id)->count();
                $msg = [
                    'status' => 0,
                    'data' => $data
                ];
            } else {
                $msg = [
                    'status' => 1,
                    'data' => '点赞失败，请联系管理员！'
                ];
            }
        }
        return $msg;
    }

    public function search()
    {
        $input = Input::all();
        $arts = Article::where('art_title','like','%'.$input['key_word'].'%')->paginate(5);
        foreach($arts as $k=>$v) {
            $arts[$k]->keys = explode(',', $v['art_tag']);
        }
        $key_word = $input['key_word'];
        return view('home.search',compact('arts','key_word'));
    }

    public function links()
    {
        $data = Links::all();
        return view('home.friendly',compact('data'));
    }

    public function about()
    {
        return view('home.about');
    }
}
