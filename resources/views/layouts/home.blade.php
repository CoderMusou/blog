<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @yield('title')
    <link href="{{asset('resources/views/home/css/bootstrap.min.css')}}" type="text/css" rel="stylesheet" />
    <link href="{{asset('resources/views/home/css/style.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/nprogress.css')}}" type="text/css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{asset('resources/views/home/js/html5shiv.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/views/home/js/respond.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/views/home/js/selectivizr-min.js')}}" type="text/javascript"></script>
    <![endif]-->
    <link rel="apple-touch-icon-precomposed" href="{{asset('resources/views/home/images/icon/icon.png')}}" />
    <link rel="shortcut icon" href="{{asset('resources/views/home/images/icon/favicon.ico')}}" />
    <script type="text/javascript">
        //判断浏览器是否支持HTML5
        window.onload = function() {
            if (!window.applicationCache) {
                window.location.href="ie.html";
            }
        }
    </script>
</head>
<body>
<section class="container user-select">
    <header>
        <div class="hidden-xs header">
            <!--超小屏幕不显示-->
            <h1 class="logo"> <a href="{{url('/')}}" title="Wseek技术博客 - POWERED BY Wseek"></a> </h1>
            <ul class="nav hidden-xs-nav">
                @foreach($navs as $v)
                <li class="active"><a href="{{$v->nav_url}}"><span class="{{$v->nav_alias}}"></span>{{$v->nav_name}}</a></li>
                    @endforeach
            </ul>
            <div class="feeds">
            <a class="feed feed-xlweibo" href="http://weibo.com/5486224298" target="_blank"><i></i>新浪微博</a>
            <a class="feed feed-txweibo" href="tencent://message/?uin=610075792&Site=&Menu=yes" target="_blank"><i></i>腾讯QQ</a>
            <a class="feed feed-rss" href="{{url('/')}}" target="_blank"><i></i>订阅本站</a>
            <a class="feed feed-weixin" data-toggle="popover" data-trigger="hover" title="微信扫一扫" data-html="true" data-content="&lt;img src='{{asset('resources/views/home/images/weixin.png')}}' width='150px' alt=''&gt;" href="javascript:;" target="_blank"><i></i>关注微信</a>
            </div>
            {{--<div class="wall">--}}
                {{--<a href="readerWall.html" target="_blank">读者墙</a> |--}}
                {{--<a href="tags.html" target="_blank">标签云</a>--}}
            {{--</div>--}}
            <div class="sentence"><span style="position: absolute;left: 80px;top: 5px;color: #3399CC;">{{date('Y年m月d日')}}</span>
                <strong>每日一句</strong>
                <p style="margin-top: 5px;">{{$say['note']}}</p>
            </div>
        </div>
        <!--/超小屏幕不显示-->
        <div class="visible-xs header-xs">
            <!--超小屏幕可见-->
            <div class="navbar-header header-xs-logo">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-xs-menu" aria-expanded="false" aria-controls="navbar"><span class="glyphicon glyphicon-menu-hamburger"></span></button>
            </div>
            <div id="header-xs-menu" class="navbar-collapse collapse">
                <ul class="nav navbar-nav header-xs-nav">
                    @foreach($navs as $v)
                        <li class="active"><a href="{{$v->nav_url}}"><span class="{{$v->nav_alias}}"></span>{{$v->nav_name}}</a></li>
                    @endforeach
                </ul>
                <form class="navbar-form" action="{{url('/search')}}" method="post" style="padding:0 25px;">
                    {{csrf_field()}}
                    <div class="input-group">
                        <input type="text" class="form-control" name="key_word" placeholder="请输入关键字" />
                        <span class="input-group-btn"> <button class="btn btn-default btn-search" type="submit">搜索</button> </span>
                    </div>
                </form>
            </div>
        </div>
    </header>
    <!--/超小屏幕可见-->
    <div class="content-wrap">
        <!--内容-->
        <div class="content">
            @yield('content')
        </div>
    </div>
    <!--/内容-->
    <aside class="sidebar visible-lg">
        <!--右侧>992px显示-->
        @yield('category')
        <div id="search" class="sidebar-block search" role="search">
            <h2 class="title"><strong>搜索文章</strong></h2>
            <form class="navbar-form" action="{{url('/search')}}" method="post">
                {{csrf_field()}}
                <div class="input-group">
                    <input type="text" class="form-control" name="key_word" size="35" placeholder="请输入关键字" />
                    <span class="input-group-btn"> <button class="btn btn-default btn-search" type="submit">搜索</button> </span>
                </div>
            </form>
        </div>
        <div class="sidebar-block recommend">
            <h2 class="title"><strong>热评文章</strong></h2>
            <!-- 多说热评文章 start -->
            <div class="ds-top-threads" data-range="monthly" data-num-items="5" ></div>
            <!-- 多说热评文章 end -->
        </div>
        <div class="sidebar-block comment">
            <h2 class="title"><strong>最新评论</strong></h2>
            <!-- 多说最新评论 start -->
            <div class="ds-recent-comments" data-num-items="5" data-show-avatars="1" data-show-time="1" data-show-title="1" data-show-admin="1" data-excerpt-length="70"></div>
            <!-- 多说最新评论 end -->
        </div>
    </aside>
    <!--/右侧>992px显示-->
    <footer class="footer">
        {!! Config::get('web.copyright') !!}
        {!! Config::get('web.web_count') !!}
    </footer>
</section>
<div>
    <a href="javascript:;" class="gotop" style="display:none;"></a>
</div>
<!--/返回顶部-->
<script src="{{asset('resources/views/home/js/jquery-2.1.4.min.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/views/home/js/nprogress.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/views/home/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('resources/org/layer/layer.js')}}"></script>
<script type="text/javascript">
    //页面加载
    $('body').show();
    $('.version').text(NProgress.version);
    NProgress.start();
    setTimeout(function() { NProgress.done(); $('.fade').removeClass('out'); }, 1000);
    //返回顶部按钮
    $(function(){
        $(window).scroll(function(){
            if($(window).scrollTop()>100){
                $(".gotop").fadeIn();
            }
            else{
                $(".gotop").hide();
            }
        });
        $(".gotop").click(function(){
            $('html,body').animate({'scrollTop':0},500);
        });
    });
    //提示插件启用
    $(function () {
        $('[data-toggle="popover"]').popover();
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    //鼠标滑过显示 滑离隐藏
    //banner
    $(function(){
        $(".carousel").hover(function(){
            $(this).find(".carousel-control").show();
        },function(){
            $(this).find(".carousel-control").hide();
        });
    });
    //本周热门
    $(function(){
        $(".hot-content ul li").hover(function(){
            $(this).find("h3").show();
        },function(){
            $(this).find("h3").hide();
        });
    });
    //页面元素智能定位
    $.fn.smartFloat = function() {
        var position = function(element) {
//            var top = element.position().top;
            var top = element.offset().top; //当前元素对象element距离浏览器上边缘的距离
            var pos = element.css("position"); //当前元素距离页面document顶部的距离
            var _width = element.css("width");
            $(window).scroll(function() { //侦听滚动时
                var scrolls = $(this).scrollTop();
                if (scrolls > top) { //如果滚动到页面超出了当前元素element的相对页面顶部的高度
                    if (window.XMLHttpRequest) { //如果不是ie6
                        element.css({ //设置css
                            position: "fixed", //固定定位,即不再跟随滚动
                            top: '0', //距离页面顶部为0
                            width: _width
                        }).addClass("shadow"); //加上阴影样式.shadow
                    } else { //如果是ie6
                        element.css({
                            top: scrolls  //与页面顶部距离
                        });
                    }
                }else {
                    element.css({ //如果当前元素element未滚动到浏览器上边缘，则使用默认样式
                        position: pos,
                        top: top
                    }).removeClass("shadow");//移除阴影样式.shadow
                }
            });
        };
        return $(this).each(function() {
            position($(this));
        });
    };
    //启用页面元素智能定位
    $(function(){
        $("#search").smartFloat();
    });

    <!-- 多说公共JS代码 start (一个网页只需插入一次) -->
    var duoshuoQuery = {short_name:"wseek"};
    (function() {
        var ds = document.createElement('script');
        ds.type = 'text/javascript';ds.async = true;
        ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
        ds.charset = 'UTF-8';
        (document.getElementsByTagName('head')[0]
        || document.getElementsByTagName('body')[0]).appendChild(ds);
    })();
    <!-- 多说公共JS代码 end -->
</script>
@yield('script')
</body>
</html>