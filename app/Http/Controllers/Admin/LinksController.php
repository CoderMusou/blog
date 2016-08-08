<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    //get.admin/links        全部友情链接
    public function index()
    {
        $data = Links::orderBy('link_order','asc')->get();
        return view('admin/links/index',compact('data'));
    }

    //Ajax异步修改排序
    public function changeOrder()
    {
        $input = Input::all();
        $link = Links::find($input['link_id']);
        $link->link_order = $input['link_order'];
        $re = $link->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '友情链接排序更新成功！'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '友情链接排序更新失败，请稍后重试！'
            ];
        }
        return $data;
    }

    //get.admin/links/create     添加链接
    public function create()
    {
        return view('admin/links/add');
    }

    //post.admin/links   添加链接提交
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $rules = [
            'link_name' => 'required',
            'link_url' => 'required',
        ];
        $message = [
            'link_name.required' => '链接名称不能为空！',
            'link_url.required' => '链接地址不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Links::create($input);
            if($re){
                return redirect('admin/links');
            }else{
                return back()->withErrors('链接添加失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }


    public function show($id)
    {
        //
    }

    //get.admin/links/{links}/edit   编辑链接
    public function edit($link_id)
    {
        $field = Links::find($link_id);
        return view('admin.links.edit',compact('field'));
    }

    //put|patch.admin/links/{links}   更新链接
    public function update(Request $request, $link_id)
    {
        $input = Input::except('_method','_token');
        $re = Links::where('link_id',$link_id)->update($input);
        if($re){
            return redirect('admin/links');
        }else{
            return back()->withErrors('链接信息更新失败，请稍后重试！');
        }
    }

    //delete.admin/links/{links}    删除单个链接
    public function destroy($link_id)
    {
        $re = Links::where('link_id',$link_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '删除分类失败，请稍后重试！'
            ];
        }
        return $data;
    }
}
