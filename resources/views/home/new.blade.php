@extends('layouts.home')
@section('title')
    <title>{{$art->art_title}} - {{Config::get('web.seo_title')}}</title>
    <meta name="keywords" content="{{$art->art_tag}},Wseek,个人博客,博客" />
    <meta name="description" content="{{$art->art_description}}" />
@endsection
@section('content')
            <header class="news_header">
                <h2>{{$art->art_title}}</h2>
                <ul>
                    <li>{{$art->art_editor}} 发布于 {{date('Y-m-d H:i',$art->art_time)}}</li>
                    <li>栏目：<a href="{{url('cate/'.$art->cate_id)}}" title="" target="_blank">{{$art->cate_name}}</a></li>
                    <li>来源：<a href="{{$art->art_fromurl}}" title="" target="_blank">{{$art->art_from}}</a></li>
                    <li>共 <strong>{{$art->art_view}}</strong> 人围观 </li>
                    <li><strong>0</strong> 个不明物体</li>
                </ul>
            </header>
            <article class="news_content">
                {!! $art->art_content !!}
            </article>
            <div class="reprint">转载请说明出处：<a href="http://Wseek.cn" title="" target="_blank">Wseek.cn个人博客</a> » <a href="http://Wseek.cn" title="" target="_blank">欢迎来到Wseek个人博客</a></div>
            <div class="zambia"><a href="javascript:;" name="zambia" rel=""><span class="glyphicon glyphicon-thumbs-up"@if($zan['status'] == '已赞') style="color: #000;" @endif></span> {{$zan['status']}}（{{$zan['num']}}）</a></div>
            <div class="tags news_tags">标签：
                @foreach($art['_art_tags'] as $k)
                    <span data-toggle="tooltip" data-placement="bottom" title="查看关于 {{$k}} 的文章">
                        <a href="#">{{$k}}</a>
                    </span>
                @endforeach
            </div>
            <nav class="page-nav">
                <span class="page-nav-prev">上一篇<br />
                    @if($field['pre'])
                        <a href="{{url('art/'.$field['pre']->art_id)}}" rel="prev">{{$field['pre']->art_title}}</a>
                    @else
                        <span rel="prev">没有上一篇了</span>
                    @endif
                </span>
                <span class="page-nav-next">下一篇<br />
                    @if($field['next'])
                        <a href="{{url('art/'.$field['next']->art_id)}}" rel="next">{{$field['next']->art_title}}</a>
                    @else
                        <span rel="next" style="float: right;">没有下一篇了</span>
                    @endif
                </span>
            </nav>
            <div class="content-block related-content visible-lg visible-md">
                <h2 class="title"><strong>相关推荐</strong></h2>
                <ul>
                    @foreach($data as $d)
                    <li><a target="_blank" href="{{url('art/'.$d->art_id)}}"><img src="{{url($d->art_thumb)}}" alt="">
                            <h3> {{$d->art_title}} </h3>
                        </a></li>
                        @endforeach
                </ul>
            </div>
    <!-- 多说评论框 start -->
    <div class="ds-thread" data-thread-key="{{$art -> art_id}}" data-title="{{$art -> art_title}}" data-url="{{url('art/'.$art->art_id)}}"></div>
    <!-- 多说评论框 end -->
@endsection
@section('script')
<script type="text/javascript">

    //相关推荐
    $(function(){
        $(".related-content ul li").hover(function(){
            $(this).find("h3").show();
        },function(){
            $(this).find("h3").hide();
        });
    });
    //ajax更新点赞值
    $(function(){
        $(".content .zambia a").click(function(){
            var zambia = $(this);//对应id
            zambia.fadeOut(1000); //渐隐效果
            $.ajax({
                type:"POST",
                url:"{{url('art/zan/'.$art->art_id)}}",
                data:{'_token':'{{csrf_token()}}','zan_aid':'{{$art->art_id}}','zan_uip':'{{$uip}}'},
                cache:false, //不缓存此页面
                success:function(msg){
                    if(msg.status == 0) {
                        zambia.html('<span class="glyphicon glyphicon-thumbs-up" style="color: #000;"></span> 已赞（'+msg.data+'）');
                        zambia.fadeIn(1000); //渐显效果
                    }else {
                        layer.msg(msg.data, function () {});
                        zambia.fadeIn(1000); //渐显效果
                    }
                }
            });
            return false;
        });
    })
</script>
@endsection
