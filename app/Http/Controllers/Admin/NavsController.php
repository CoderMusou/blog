<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    //get.admin/navs        全部自定义菜单
    public function index()
    {
        $data = Navs::orderBy('nav_order','asc')->get();
        return view('admin/navs/index',compact('data'));
    }

    //Ajax异步修改排序
    public function changeOrder()
    {
        $input = Input::all();
        $nav = Navs::find($input['nav_id']);
        $nav->nav_order = $input['nav_order'];
        $re = $nav->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '自定义菜单排序更新成功！'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '自定义菜单排序更新失败，请稍后重试！'
            ];
        }
        return $data;
    }

    //get.admin/navs/create     添加菜单
    public function create()
    {
        return view('admin/navs/add');
    }

    //post.admin/navs   添加菜单提交
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $rules = [
            'nav_name' => 'required',
            'nav_url' => 'required',
        ];
        $message = [
            'nav_name.required' => '菜单名称不能为空！',
            'nav_url.required' => '菜单地址不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Navs::create($input);
            if($re){
                return redirect('admin/navs');
            }else{
                return back()->withErrors('菜单添加失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }


    public function show($id)
    {
        //
    }

    //get.admin/navs/{navs}/edit   编辑菜单
    public function edit($nav_id)
    {
        $field = Navs::find($nav_id);
        return view('admin/navs/edit',compact('field'));
    }

    //put|patch.admin/navs/{navs}   更新菜单
    public function update(Request $request, $nav_id)
    {
        $input = Input::except('_method','_token');
        $re = Navs::where('nav_id',$nav_id)->update($input);
        if($re){
            return redirect('admin/navs');
        }else{
            return back()->withErrors('菜单信息更新失败，请稍后重试！');
        }
    }

    //delete.admin/navs/{navs}    删除单个菜单
    public function destroy($nav_id)
    {
        $re = Navs::where('nav_id',$nav_id)->delete();
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
