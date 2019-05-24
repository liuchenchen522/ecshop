@include('public.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
    <div class="head-mid">
        <h1>产品详情</h1>
    </div>
    </header>
        <div id="sliderA" class="slider">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" value="{{$data->goods_id}}" id="goods_id">
            @foreach($goods_imgs as $v)
            <img src="{{config('app.img_url')}}{{$v}}"/>
            @endforeach
        </div><!--sliderA/-->
    <table class="jia-len">
        <tr>
            <th><strong class="orange">￥{{$data->self_price}}</strong></th>
            <td>
                <input type="button" style="width:30px;height:25px;" class="n_btn_1" id="less" value="-"/>
                <input type="text" style="width:30px;height:25px;" value="1" name="" class="n_ipt" id="buy_number"/>
                <input type="button" style="width:30px;height:25px;" class="n_btn_2" id="more" value="+"/>
            </td>
        </tr>
        <tr>
            <td>
                <strong>{{$data->goods_name}}</strong>
                <p class="hui">库存共<font color="red" id="goods_num"> {{$data->goods_num}}</font>件</p>
            </td>
            <td align="right">
                <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
            </td>
        </tr>
    </table>
    <div class="height2"></div>
    <div class="zhaieq">
        <a href="javascript:;" class="zhaiCur">用户评论</a>
        <a href="javascript:;">商品简介</a>
        <a href="javascript:;" style="background:none;">商品图片</a>
        <div class="clearfix"></div>
    </div><!--zhaieq/-->
    <div class="proinfoList">
        <table>
            <tr>
                <td>ID:</td>
                <td>用户名：</td>
                <td>E-mail:</td>
                <td>评论等级：</td>
                <td>评论内容：</td>
                <td>评论时间：</td>
            </tr>
            @foreach($res as $v)
            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->user_name}}</td>
                <td>{{$v->email}}</td>
                <td align="center">{{$v->grade}}星</td>
                <td>{{$v->remark}}</td>
                <td>{{date('Y-m-d H:i:s',$v->create_time)}}</td>
            </tr>
            @endforeach
        </table>
        <hr>
        <form action="/goods/remark" method="post" onsubmit="return false">
            <table>
                <tr>
                    <td>用户名:</td>
                    <td><input type="text" name="user_name" class="user_name"></td>
                </tr>
                <tr>
                    <td>E-mail:</td>
                    <td><input type="text" name="email" class="email"></td>
                </tr>
                <tr>
                    <td>评论等级:</td>
                    <td>
                        <input type="radio" name="goods_grade" value="1"> 1级
                        <input type="radio" name="goods_grade" value="2"> 2级
                        <input type="radio" name="goods_grade" value="3"> 3级
                        <input type="radio" name="goods_grade" value="4"> 4级
                        <input type="radio" name="goods_grade" value="5"> 5级
                    </td>
                </tr>
                <tr>
                    <td>评论内容:</td>
                    <td>
                        <textarea name="" id="" cols="30" rows="10" name="remark" class="remark"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" id="sub" value="提交评论"></td>
                </tr>
            </table>
        </form>
    </div><!--proinfoList/-->
    <div class="proinfoList">
        {{$data->goods_desc}}
    </div><!--proinfoList/-->
    <div class="proinfoList">
        <img src="{{config('app.img_url')}}{{$data->goods_img}}" width="636" height="822" />
    </div><!--proinfoList/-->
    <table class="jrgwc">
        <tr>
            <th>
                <a href="/"><span class="glyphicon glyphicon-home"></span></a>
            </th>
            <td><a href="javascript:;" id="cartAdd">加入购物车</a></td>
        </tr>
    </table>
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/layui/css/layui.css">
    <script src="/layui/layui.js"></script>
    <script src="/js/style.js"></script>
    <!--焦点轮换-->
    <script src="/js/jquery.excoloSlider.js"></script>
    <script>
		$(function () {
		 $("#sliderA").excoloSlider();
		});
	</script>
     <!--jq加减-->
    <script src="/js/jquery.spinner.js"></script>
   <script>
	$('.spinnerExample').spinner({});
	</script>
  </body>
</html>
<script>
    $(function(){
        layui.use(['form','layer'],function(){
            var form = layui.form;
            var layer = layui.layer;
            var goods_num = parseInt($('#goods_num').text());
            // alert(goods_num);
            //+号点击事件
            $("#more").click(function(){
                var buy_number = parseInt($('#buy_number').val());
                if(buy_number>=goods_num){
                    $(this).prop('disabled',true);
                    $(this).next('input').prop('disabled',false);
                }else{
                    buy_number = buy_number + 1;
                    $("#buy_number").val(buy_number);
                    $(this).next('input').prop('disabled',false);
                }
            });

            //-号点击事件
            $("#less").click(function(){
                var buy_number = parseInt($('#buy_number').val());
                if(buy_number<=1){
                    $(this).prop('disabled',true);
                    $(this).prev('input').prop('disabled',false);
                }else{
                    buy_number = buy_number - 1;
                    $("#buy_number").val(buy_number);
                    $(this).prev('input').prop('disabled',false);
                }
            });

            //文本框失去焦点事件
            $("#buy_number").blur(function(){
                var buy_number = parseInt($('#buy_number').val());
                var reg = /^[1-9]\d$/;
                if(!reg.test(buy_number)){
                    $("#buy_number").val(1);
                }else if(buy_number<=1){
                    $("#buy_number").val(1);
                }else if(buy_number>=goods_num){
                    $("#buy_number").val(goods_num);
                }
            });

            //添加评论
            $("#sub").click(function(){
                var user_name = $(".user_name").val();
                var email = $(".email").val();
                var grade = $('input:radio:checked').val();
                var remark = $(".remark").val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method:'post',
                    url:'/goods/remark',
                    data:{user_name:user_name,email:email,grade:grade,remark:remark},
                    dataType:"json",
                    success:function(res){
                        // console.log(res);
                        layer.msg(res.font,{icon:res.code});
                        if(res.code == 1){
                            window.location.reload("/goods/goodsdetail");
                        }
                    },
                });

            })

            //加入购物车
            $("#cartAdd").click(function(){
                var goods_id = $("#goods_id").val();
                var buy_number = $('#buy_number').val();
                // alert(buy_number);
                // alert(buy_number);
                /** csrf保护*/
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method:'post',
                    url:'/cart/cartAdd',
                    data:{goods_id:goods_id,buy_number:buy_number},
                    dataType:"json",
                    success:function(res){
                        // console.log(res);
                        layer.msg(res.res,{icon:res.code});
                        if(res.code == 1){
                            location.href="/cart/cartlist";
                        }
                    },
                });
            });
        })
    })
</script>