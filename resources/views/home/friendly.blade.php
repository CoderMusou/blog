@extends('layouts.home')
@section('content')
      <div class="content-block friendly-content row">
        <h2 class="title"><strong>本站友链</strong></h2>
          @foreach($data as $v)
            <div class="col-md-4 col-xs-6">
              <span data-toggle="tooltip" data-placement="bottom" title="点击进入 {{$v -> link_name}} 站点">
                  <a href="{{$v -> link_url}}">{{$v -> link_name}}</a></span>
              <p>{{$v -> link_title}}</p>
            </div>
          @endforeach
      </div>
     {{--<div class="content-block comment">--}}
      {{--<h2 class="title"><strong>提交友链</strong></h2>--}}
      {{--<form action="message.php" method="post" class="form-inline" id="comment-form">--}}
        {{--<div class="comment-title">--}}
          {{--<div class="form-group">--}}
            {{--<label for="messageName">网站名称：</label>--}}
            {{--<input type="text" name="messageName" class="form-control" id="messageName" placeholder="异清轩技术博客">--}}
          {{--</div>--}}
          {{--<div class="form-group">--}}
            {{--<label for="messageEmail">网站地址：</label>--}}
            {{--<input type="email" name="messageEmail" class="form-control" id="messageEmail" placeholder="admin@ylsat.com">--}}
          {{--</div>--}}
        {{--</div>--}}
        {{--<div class="comment-form">--}}
          {{--<textarea placeholder="请填写网站服务内容" name="messageContent"></textarea>--}}
          {{--<div class="comment-form-footer">--}}
            {{--<div class="comment-form-text">请先 <a href="javascript:;">登录</a> 或 <a href="javascript:;">注册</a>，也可匿名提交友链 </div>--}}
            {{--<div class="comment-form-btn">--}}
              {{--<button type="submit" class="btn btn-default btn-comment">提交友链</button>--}}
            {{--</div>--}}
          {{--</div>--}}
        {{--</div> --}}
      {{--</form>--}}
    {{--</div>--}}
@endsection
