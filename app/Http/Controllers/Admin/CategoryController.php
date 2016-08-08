<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    //get.admin/category        全部分类列表
    public function index()
    {
        $categorys = (new Category()) -> tree();
//        $categorys = Category::tree();
        return view('admin.category.index') -> with('data',$categorys);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $re = $cate->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '分类排序更新成功！'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '分类排序更新失败，请稍后重试！'
            ];
        }
        return $data;
    }

    //get.admin/category/create     添加分类
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.add',compact('data'));
    }

    //post.admin/category   添加分类提交
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $rules = [
            'cate_name' => 'required',
//                'password_confirmation' => 'same:password',
        ];
        $message = [
            'cate_name.required' => '分类名称不能为空！',
            'password.between' => '新密码必须在6-20位之间！',
            'password.confirmed' => '两次输入的密码不一致！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Category::create($input);
            if($re){
                return redirect('admin/category');
            }else{
                return back()->withErrors('分类添加失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get.admin/category/{category}/edit   编辑分类
    public function edit($cate_id)
    {
        $field = Category::find($cate_id);
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.edit',compact('field','data'));
    }

    //put|patch.admin/category/{category}   更新分类
    public function update(Request $request, $cate_id)
    {
        $input = Input::except('_method','_token');
        $re = Category::where('cate_id',$cate_id)->update($input);
        if($re){
            return redirect('admin/category');
        }else{
            return back()->withErrors('分类信息更新失败，请稍后重试！');
        }
    }


    //get.admin/category/{category}   显示单个分类信息
    public function show($id)
    {
        //
    }

    //delete.admin/category/{category}    删除单个分类
    public function destroy($cate_id)
    {
        if(Article::where('cate_id',$cate_id)->count()>0){
            $data = [
                'status' => 1,
                'msg' => '当前分类下有文章，请删除文章或更改文章分类后执行此操作！',
            ];
        }else if(Category::where('cate_pid',$cate_id)->count()>0){
            $data = [
                'status' => 1,
                'msg' => '当前分类下有子分类，请删除子分类后执行此操作！',
            ];
        }else {
            $re = Category::where('cate_id', $cate_id)->delete();
            if ($re) {
                $data = [
                    'status' => 0,
                    'msg' => '删除成功！',
                ];
            } else {
                $data = [
                    'status' => 1,
                    'msg' => '删除分类失败，请稍后重试！'
                ];
            }
        }
        return $data;
    }
}
