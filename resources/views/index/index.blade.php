@include('public.header')
<div class="maincont">
    <div class="head-top">
        <img src="/images/head.jpg" />
        <dl>
            <dt><a href="user.html"><img src="/images/touxiang.jpg" /></a></dt>
            <dd>
                <h1 class="username">三级分销终身荣誉会员</h1>
                <ul>
                    <li><a href="/goods/goodslist"><strong>34</strong><p>全部商品</p></a></li>
                    <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
                    <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
                    <div class="clearfix"></div>
                </ul>
            </dd>
            <div class="clearfix"></div>
        </dl>
    </div><!--head-top/-->
    <form action="#" method="get" class="search">
        <input type="text" class="seaText fl" />
        <input type="submit" value="搜索" class="seaSub fr" />
    </form><!--search/-->
    @if($session == null)
    <ul class="reg-login-click">
        <li><a href="{{url('/user/login')}}">登录</a></li>
        <li><a href="{{url('/user/register')}}" class="rlbg">注册</a></li>
        <div class="clearfix"></div>
    </ul><!--reg-login-click/-->
        <div id="sliderA" class="slider">
            @foreach($goods_imgs as $v)
                <a href="/goods/goodsdetail/{{$goodsImgs->goods_id}}"><img src="{{config('app.img_url')}}{{$v}}" /></a>
            @endforeach
        </div><!--sliderA/-->
        <ul class="pronav">
            @foreach($cate as $v)
                <li><a href="prolist.html">{{$v->cate_name}}</a></li>
            @endforeach
            <div class="clearfix"></div>
        </ul><!--pronav/-->
        {{--<div class="index-pro1">--}}
        {{--<div class="index-pro1-list">--}}
        {{--<dl>--}}
        {{----}}
        {{--<dt>--}}
        {{--<a href="proinfo.html"><img src=""/></a>--}}
        {{--</dt>--}}
        {{--<dd class="ip-text">--}}
        {{--<a href="proinfo.html"></a>--}}
        {{--<span></span>--}}
        {{--</dd>--}}
        {{--<dd class="ip-price">--}}
        {{--<strong></strong>--}}
        {{--<span></span>--}}
        {{--</dd>--}}
        {{----}}
        {{--</dl>--}}
        {{--</div>--}}
        {{--<div class="clearfix"></div>--}}
        {{--</div><!--index-pro1/-->--}}
        <div class="prolist">
            @foreach($data as $v)
                <dl>
                    <dt><a href="/goods/goodsdetail/{{$v->goods_id}}"><img src="{{config('app.img_url')}}{{$v->goods_img}}" width="100" height="100" /></a></dt>
                    <dd>
                        <h3><a href="/goods/goodsdetail/{{$v->goods_id}}">{{$v->goods_name}}</a></h3>
                        <div class="prolist-price"><strong>¥{{$v->market_price}}</strong> <span>¥{{$v->self_price}}</span></div>
                        <div class="prolist-yishou"><span>5.0折</span> <em>购买积分：{{$v->goods_score}}</em></div>
                    </dd>
                    <div class="clearfix"></div>
                </dl>
            @endforeach
        </div><!--prolist/-->
        <div class="joins"><a href="fenxiao.html"><img src="/images/jrwm.jpg" /></a></div>
        <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>

        <div class="height1"></div>
        @include('public.footer')
    @else
    <div id="sliderA" class="slider">
        @foreach($goods_imgs as $v)
            <a href="/goods/goodsdetail/{{$goodsImgs->goods_id}}"><img src="{{config('app.img_url')}}{{$v}}" /></a>
        @endforeach
    </div><!--sliderA/-->
    <ul class="pronav">
        @foreach($cate as $v)
        <li><a href="prolist.html">{{$v->cate_name}}</a></li>
        @endforeach
        <div class="clearfix"></div>
    </ul><!--pronav/-->
    {{--<div class="index-pro1">--}}
        {{--<div class="index-pro1-list">--}}
            {{--<dl>--}}
                {{----}}
                {{--<dt>--}}
                    {{--<a href="proinfo.html"><img src=""/></a>--}}
                {{--</dt>--}}
                {{--<dd class="ip-text">--}}
                    {{--<a href="proinfo.html"></a>--}}
                    {{--<span></span>--}}
                {{--</dd>--}}
                {{--<dd class="ip-price">--}}
                    {{--<strong></strong>--}}
                    {{--<span></span>--}}
                {{--</dd>--}}
                {{----}}
            {{--</dl>--}}
        {{--</div>--}}
        {{--<div class="clearfix"></div>--}}
    {{--</div><!--index-pro1/-->--}}
    <div class="prolist">
        @foreach($data as $v)
        <dl>
            <dt><a href="/goods/goodsdetail/{{$v->goods_id}}"><img src="{{config('app.img_url')}}{{$v->goods_img}}" width="100" height="100" /></a></dt>
            <dd>
                <h3><a href="/goods/goodsdetail/{{$v->goods_id}}">{{$v->goods_name}}</a></h3>
                <div class="prolist-price"><strong>¥{{$v->market_price}}</strong> <span>¥{{$v->self_price}}</span></div>
                <div class="prolist-yishou"><span>5.0折</span> <em>购买积分：{{$v->goods_score}}</em></div>
            </dd>
            <div class="clearfix"></div>
        </dl>
        @endforeach
    </div><!--prolist/-->
    <div class="joins"><a href="fenxiao.html"><img src="/images/jrwm.jpg" /></a></div>
    <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>

    <div class="height1"></div>
    @include('public.footer')
@endif