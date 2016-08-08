@extends('layouts.home')
@section('title')
  <title>{{'【'.$key_word.'】'.'的搜索结果'}} - {{Config::get('web.seo_title')}}</title>
  <meta name="keywords" content="Wseek,个人博客,博客" />
  <meta name="description" content="laravel框架的个人博客系统，优雅、稳重、大气,低调。" />
@endsection
  @section('content')
      <div class="content-block new-content">
        <h2 id="float" class="title" style="width: 630px;"><a href="{{url('/')}}" ><strong style="border-bottom: none;">首页</strong></a> &gt; <a href="#" ><strong>搜索结果</strong></a></h2>
        <div class="row">
          <!--最新文章-->
          @forelse($arts as $m)
          <div class="news-list">
            <div class="news-img col-xs-5 col-sm-5 col-md-4">
              <a target="_blank" href="{{url('art/'.$m->art_id)}}"><img src="{{asset($m->art_thumb)}}" style="max-width: 200px;max-height: 150px;" alt="" /> </a>
            </div>
            <div class="news-info col-xs-7 col-sm-7 col-md-8">
              <dl>
                <dt>
                  <a href="{{url('art/'.$m->art_id)}}" target="_blank">{{$m->art_title}}</a>
                </dt>
                <dd>
                  <span class="name"><a href="#" title="由 {{$m->art_editor}} 发布" rel="author">{{$m->art_editor}}</a></span>
                  <span class="identity"></span>
                  <span class="time"> {{date('Y-m-d H:i:s',$m->art_time)}} </span>
                </dd>
                <dd class="text">
                  {{$m->art_description}}
                </dd>
              </dl>
              <div class="news_bot col-sm-7 col-md-8">
                <span class="tags visible-lg visible-md">
                  @foreach($m['keys'] as $n)
                  <a href="#">{{$n}}</a>
                    @endforeach
                </span>
                <span class="look"> 共 <strong>{{$m->art_view}}</strong> 人围观，发现 <strong> 0 </strong> 个不明物体 </span>
              </div>
            </div>
          </div>
          @empty
            <div class="news-list">
              <div class="news-info col-xs-7 col-sm-7 col-md-8">
              <strong>当前没有数据</strong>
                </div>
            </div>
          @endforelse
          <!--最新文章-->
        </div>
        <!--<div class="news-more" id="pagination">
              <a href="index.html">查看更多</a>
          </div>-->
        <div class="quotes" style="margin-top:15px">
          {{--<span class="disabled">首页</span>--}}
          {{--<span class="disabled">上一页</span>--}}
          {{--<span class="current">1</span>--}}
          {{--<a href="index.html">2</a>--}}
          {{--<a href="index.html">下一页</a>--}}
          {{--<a href="index.html">尾页</a>--}}
          {{$arts->links()}}
        </div>
      </div>
  @endsection
  @section('script')
    <script type="text/javascript">
      //异步加载更多内容
      jQuery("#pagination a").on("click", function ()
      {
        var _url = jQuery(this).attr("href");
        var _text = jQuery(this).text();
        jQuery(this).attr("href", "javascript:viod(0);");
        jQuery.ajax(
                {
                  type : "POST",
                  url : _url,
                  success : function (data)
                  {
                    //将返回的数据进行处理，挑选出class是news-list的内容块
                    result = jQuery(data).find(".row .news-list");
                    //newHref获取返回的内容中的下一页的链接地址
                    nextHref = jQuery(data).find("#pagination a").attr("href");
                    jQuery(this).attr("href", _url);
                    if (nextHref != undefined)
                    {
                      jQuery("#pagination a").attr("href", nextHref);
                    }
                    else
                    {
                      jQuery("#pagination a").html("下一页没有了").removeAttr("href")
                    }
                    // 渐显新内容
                    jQuery(function ()
                    {
                      jQuery(".row").append(result.fadeIn(300));
                      jQuery("img").lazyload(
                              {
                                effect : "fadeIn"
                              });
                    });
                  }
                });
        return false;
      });
      //启用页面元素智能定位
      $(function(){
        $("#float").smartFloat();
      });
      </script>
  @endsection