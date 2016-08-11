@extends('layouts.home')
@section('title')
    <title>{{Config::get('web.web_title')}} - {{Config::get('web.seo_title')}}</title>
    <meta name="keywords" content="Wseek,个人博客,博客" />
    <meta name="description" content="laravel框架的个人博客系统，优雅、稳重、大气,低调。" />
  @endsection
  @section('content')
      <!--/banner-->
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          @foreach($top as $k => $t)
          <li data-target="#carousel-example-generic" data-slide-to="{{$k}}" @if($k==0)class="active" @endif></li>
          @endforeach
        </ol>
        <div class="carousel-inner" role="listbox">
            @foreach($top as $k => $t)
              <div class="item @if($k==0)active @endif">
                <a href="{{url('art/'.$t->art_id)}}" target="_blank"><img src="{{url($t->art_thumb)}}" alt="" /></a>
                <div class="carousel-caption">
                  {{$t->art_title}}
                </div>
                <span class="carousel-bg"></span>
              </div>
            @endforeach
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
      </div>
      <!--/banner-->
      <!--热门排行-->
      <div class="content-block hot-content hidden-xs">
        <h2 class="title"><strong>本周热门排行</strong></h2>
        <ul>
          @foreach($weekHot as $k=>$h)
            <li @if($k==0)class="large" @endif>
                <a href="{{url('art/'.$h->art_id)}}" target="_blank"><img src="{{url($h->art_thumb)}}" alt="" /><h3> {{$h->art_title}} </h3> </a>
            </li>
          @endforeach
        </ul>
      </div>
      <!--/热门排行-->
      <div class="content-block new-content">
        <h2 id="float" class="title" style="width: 630px;"><strong>最新文章</strong></h2>
        <div class="row">
          <!--最新文章-->
          @foreach($new as $n)
          <div class="news-list">
            <div class="news-img col-xs-5 col-sm-5 col-md-4">
              <a target="_blank" href="{{url('art/'.$n->art_id)}}"><img src="{{url($n->art_thumb)}}" style="max-width: 200px;max-height: 150px;" alt="" /> </a>
            </div>
            <div class="news-info col-xs-7 col-sm-7 col-md-8">
              <dl>
                <dt>
                  <a href="{{url('art/'.$n->art_id)}}" target="_blank">{{$n->art_title}}</a>
                </dt>
                <dd>
                  <span class="name"><a href="#" title="由 {{$n->art_editor}} 发布" rel="author">{{$n->art_editor}}</a></span>
                  <span class="identity"></span>
                  <span class="time"> {{date('Y-m-d H:i:s',$n->art_time)}} </span>
                </dd>
                <dd class="text">
                  {{$n->art_description}}
                </dd>
              </dl>
              <div class="news_bot col-sm-7 col-md-8">
                <span class="tags visible-lg visible-md">
                  @foreach($n['keys'] as $k)
                  <a href="#">{{$k}}</a>
                    @endforeach
                </span>
                <span class="look"> 共 <strong>{{$n->art_view}}</strong> 人围观，发现 <strong> 0 </strong> 个不明物体 </span>
              </div>
            </div>
          </div>
          @endforeach
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
            {{$new->links()}}
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
      </script>
  @endsection