<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    //get.admin/config        全部配置项
    public function index()
    {
        $data = Config::orderBy('conf_order','asc')->get();
        foreach ($data as $k => $v) {
            switch($v -> field_type){
                case 'input':
                    $data[$k] -> _html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'"';
                    break;
                case 'textarea':
                    $data[$k] -> _html = '<textarea class="lg" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    $arr = explode(',',$v->field_value);
                    $str ='';
                    foreach($arr as $n){
                        $r = explode('|',$n);
                        $checked = $v->conf_content==$r[0]?' checked ':'';
                        $str .= '<input type="radio" name="conf_content[]" value="'.$r[0].'"'.$checked.' />'.$r[1].'　';
                    }
                    $data[$k] -> _html = $str;
                    break;
            }

        }

        return view('admin/config/index',compact('data'));
    }

    //配置项内容修改提交
    public function changeContent(){
        $input = Input::all();
        foreach($input['conf_id'] as $k=>$v){
            $re = Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->withErrors('配置项更新成功！');
    }

    //Ajax异步修改排序
    public function changeOrder()
    {
        $input = Input::all();
        $conf = Config::find($input['conf_id']);
        $conf->conf_order = $input['conf_order'];
        $re = $conf->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '配置项排序更新成功！'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '配置项排序更新失败，请稍后重试！'
            ];
        }
        return $data;
    }

    public function putFile()
    {
        $config = Config::pluck('conf_content','conf_name')->all();;
        $config = var_export($config,true);
        $path = base_path().'\config\web.php';
        $str = '<?php return '.$config.';';
        file_put_contents($path,$str);
    }

    //get.admin/config/create     添加配置项
    public function create()
    {
        return view('admin/config/add');
    }

    //post.admin/config   添加配置项提交
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $rules = [
            'conf_name' => 'required',
            'conf_title' => 'required',
        ];
        $message = [
            'conf_name.required' => '配置项名称不能为空！',
            'conf_title.required' => '配置项标题不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Config::create($input);
            if($re){
                return redirect('admin/config');
            }else{
                return back()->withErrors('配置项添加失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }


    public function show($id)
    {
        //
    }

    //get.admin/config/{config}/edit   编辑配置项
    public function edit($conf_id)
    {
        $field = Config::find($conf_id);
        return view('admin/config/edit',compact('field'));
    }

    //put|patch.admin/config/{config}   更新配置项
    public function update(Request $request, $conf_id)
    {
        $input = Input::except('_method','_token');
        $re = Config::where('conf_id',$conf_id)->update($input);
        if($re){
            $this->putFile();
            return redirect('admin/config');
        }else{
            return back()->withErrors('配置项信息更新失败，请稍后重试！');
        }
    }

    //delete.admin/config/{config}    删除单个配置项
    public function destroy($conf_id)
    {
        $re = Config::where('conf_id',$conf_id)->delete();
        if($re){
            $this->putFile();
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
