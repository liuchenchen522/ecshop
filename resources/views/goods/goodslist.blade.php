@include('public.header')
<div class="maincont">
 <header>
  <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
  <div class="head-mid">
   <form action="#" method="get" class="prosearch"><input type="text" /></form>
  </div>
 </header>
 <ul class="pro-select">
  <li class="pro-selCur"><a href="javascript:;">新品</a></li>
  <li><a href="javascript:;">销量</a></li>
  <li><a href="javascript:;">价格</a></li>
 </ul><!--pro-select/-->
 <div class="prolist">
  <dl>
   @foreach($data as $v)
    <dt>
     <a href="/goods/goodsdetail/{{$v->goods_id}}"><img src="{{config('app.img_url')}}{{$v->goods_img}}" width="100" height="100" /></a>
    </dt>
    <dd>
     <h3><a href="/goods/goodsdetail/{{$v->goods_id}}">{{$v->goods_name}}</a></h3>
     <div class="prolist-price"><strong>¥{{$v->market_price}}</strong> <span>¥{{$v->self_price}}</span></div>
     <div class="prolist-yishou"><span>5.0折</span> <em>已售：{{$v->goods_score}}</em></div>
    </dd>
    <div class="clearfix"></div>
   @endforeach
  </dl>
 </div><!--prolist/-->
 <div class="height1"></div>
@include('public.footer')