@include('public.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>会员登录</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/images/head.jpg" />
    </div><!--head-top/-->
    <form action="" method="post" class="reg-login" onsubmit="return false">
        @csrf
        <h3>还没有三级分销账号？点此<a class="orange" href="{{url('/user/register')}}">注册</a></h3>
        <div class="lrBox">
            <div class="lrList"><input type="text" placeholder="输入手机号码或者邮箱号" name="user_email" /></div>
            <div class="lrList"><input type="password" placeholder="输入密码" name="user_pwd" /></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="submit" value="立即登录" class="submit" />
        </div>
    </form><!--reg-login/-->
    <div class="height1"></div>
@include('public.footer')
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
    <script src="{{asset('layui/layui.js')}}"></script>
    <script>
        $(function(){
            layui.use(['layer','form'],function(){
                var form=layui.form;
                var layer=layui.layer;
                var flag=false;
                /** csrf保护*/
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //邮箱号失焦
                $("input[name=user_email]").blur(function(){
                    var user_email = $(this).val();
                    $('input[name=user_email]').next().remove();
                    if(user_email == ''){
                        $(this).after("<b style='color:red;'>手机号或邮箱号不能为空</b>");
                        flag=false;
                        return;
                    }
                    var reg = /^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]*\.)+[A-Za-z]{2,14}$/;
                    $('input[name=user_email]').next().remove();
                    if(!reg.test(user_email)){
                        $(this).after("<b style='color:red;'>请写出正确的邮箱格式</b>");
                        flag=false;
                        return;
                    }

                })

                /** 给input框中name值为user_pwd的绑定失去焦点事件*/
                $("input[name=user_pwd]").blur(function(){
                    var user_pwd=$(this).val();
                    $('input[name=user_pwd]').next().remove();
                    if(user_pwd == ''){
                        //alert('网站名称');
                        $(this).after("<b style='color:red;'>密码必填</b>");
                        flag=false;
                        return;
                    }
                    var reg = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,18}$/;
                    $('input[name=user_pwd]').next().remove();
                    if(!reg.test(user_pwd)){
                        $(this).after("<b style='color:red;'>密码须为6-18位字母或数字组成</b>");
                        flag=false;
                        return;
                    }
                })

                $(".submit").click(function(){
                    // alert(123);
                    $('input[name=user_email]').trigger('blur');
                    $('input[name=user_pwd]').trigger('blur')
                    var user_email = $('input[name=user_email]').val();
                    var user_pwd = $('input[name=user_pwd]').val();
                    //验证邮箱是否被注册
                    $.ajax({
                        async:false,
                        method: "post",
                        url: "/user/Email",
                        data: {user_email:user_email}
                    }).done(function( res ) {
                        if (res.code==2) {
                            layer.msg(res.font,{icon:res.code});
                            flag = false;
                        }
                    });
                    if (flag) {
                        return flag;
                    }
                    $.ajax({
                        async:false,
                        method: "post",
                        url: "/user/login",
                        data: {user_email:user_email,user_pwd:user_pwd}
                    }).done(function( res ) {
                        if (res.code==1) {
                            layer.msg(res.font,{icon:res.code});
                            location.href="/";
                            flag = true;
                        }else if(res.code==2){
                            layer.msg(res.font,{icon:res.code});
                            flag = false;
                        }
                    });
                    if (flag) {
                        return flag;
                    }
                });

            });
        });
    </script>