<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //get.admin/article        全部文章列表
    public function index()
    {
        $data = Article::orderBy('art_id','desc')->paginate(10);
        return view('admin.article.index',compact('data'));
    }

    //get.admin/article/create     添加文章
    public function create()
    {
        $data = (new Category)->tree();
        return view('admin/article/add',compact('data'));
    }

    //post.admin/article   添加文章提交
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $input['art_time'] = time();
        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
//                'password_confirmation' => 'same:password',
        ];
        $message = [
            'art_title.required' => '文章标题不能为空！',
            'art_content.required' => '文章内容不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Article::create($input);
            if($re){
                return redirect('admin/article');
            }else{
                return back()->withErrors('文章添加失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get.admin/article/{article}/edit   编辑文章
    public function edit($art_id)
    {
        $data = (new Category)->tree();
        $field = Article::find($art_id);
        return view('admin.article.edit',compact('data','field'));
    }

    //put|patch.admin/article/{article}   更新文章
    public function update(Request $request, $art_id)
    {
        $input = Input::except('_method','_token');
        $re = Article::where('art_id',$art_id)->update($input);
        if($re){
            return redirect('admin/article');
        }else{
            return back()->withErrors('文章更新失败，请稍后重试！');
        }
    }


    //get.admin/article/{article}   显示单个文章
    public function show($id)
    {
        //
    }

    //delete.admin/article/{article}    删除单篇文章
    public function destroy($art_id)
    {
        $re = Article::where('art_id',$art_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '文章删除成功！'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '文章删除失败，请稍后重试！'
            ];
        }
        return $data;
    }

    public function changeTop()
    {
        $input = Input::all();
        $status = $input['art_top'];
        if ($status == 'yes'){
            $art = Article::find($input['art_id']);
            $art->art_top = 'no';
            $re = $art->update();
        }else{
            $art = Article::find($input['art_id']);
            $art->art_top = 'yes';
            $re = $art->update();
        }
        if($re){
            $data = [
                'status' => 0,
                'msg' => '状态更新成功！'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '状态更新失败，请稍后重试！'
            ];
        }
        return $data;
    }
}
