@include('public.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>会员注册</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/images/head.jpg" />
    </div><!--head-top/-->
    <form action="" method="post" class="reg-login" onsubmit="return false">
        <h3>已经有账号了？点此<a class="orange" href="{{url('/user/login')}}">登陆</a></h3>
        <div class="lrBox">
            <div class="lrList"><input type="text" placeholder="输入手机号码或者邮箱号" name="user_email" id="user_email"/></div>
            <div class="lrList2"><input type="text" placeholder="输入短信验证码" name="user_code" id="user_code"/> <button class="user_code">获取验证码</button></div>
            <div class="lrList"><input type="password" placeholder="设置新密码（6-18位数字或字母）" name="user_pwd" class="user_pwd"/></div>
            <div class="lrList"><input type="password" placeholder="再次输入密码"  name="user_repwd" class="user_repwd"/></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="button" value="立即注册" class="submit"/>
        </div>
    </form><!--reg-login/-->
    <div class="height1"></div>
@include('public.footer')
    <link rel="stylesheet" href="/layui/css/layui.css">
    <script src="/layui/layui.js"></script>
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
                    //判断唯一
                    $.ajax({
                        method:"POST",
                        url:"/user/checkName",
                        data:{user_email:user_email}
                    }).done(function(res){
                        $('input[name=user_email]').next().remove();
                        if(res.code==1){
                            // alert(res);
                            $('input[name=user_email]').after("<b style='color:red;'>"+res.res+"</b>")
                        }
                    });
                })

                //验证码失焦
                $('#user_code').blur(function(){
                    var user_code=$('#user_code').val();
                    if(user_code == '') {
                        layer.msg('验证码不能为空');
                        return;
                    }

                    //验证验证码
                    $.ajax({
                        async:false,
                        method: "post",
                        url: "/user/code",
                        data: {user_code:user_code}
                    }).done(function( res ) {
                        if(res.code==2){
                            layer.msg(res.font,{icon:res.code});
                            flag=false;
                        }else if(res.code==1){
                            layer.msg(res.font,{icon:res.code});
                            flag = true;
                        }
                    });
                    if (flag) {
                        return flag;
                    }
                })

                /** 点击获取验证码 */
                $(".user_code").click(function(){
                    var user_email=$("#user_email").val();
                    // alert(user_email);
                    if(user_email==''){
                        $(this).after("<b style='color:red;'>邮箱号不能为空</b>");
                        flag=false;
                    }
                    $.ajax({
                        method:"POST",
                        url:"/user/send",
                        data:{user_email:user_email}
                    }).done(function(res){
                        if(res.code == 1){
                            layer.msg(res.res,{icon:res.code});
                            flag==true;
                        }else if(res.code == 2){
                            layer.msg(res.res,{icon:res.code});
                            flag==false;
                        }
                        // alert(res);
                    });

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

                /**验证确认密码与密码一致*/
                $(".user_repwd").blur(function(){
                    var user_repwd = $(this).val();
                    var user_pwd = $(".user_pwd").val();
                    if(user_repwd==''){
                        $(".user_repwd").next().remove();
                        $(this).after("<b style='color:red;'>确认密码必填</b>");
                        flag=false;
                        return;
                    }
                    $(".user_repwd").next().remove();
                    if(user_repwd!=user_pwd){
                        $(this).after("<b style='color:red;'>确认密码必须与密码一致</b>");
                        flag=false;
                        return;
                    }
                })

                /** 点击立即注册*/
                $(".submit").click(function(){
                    var user_email=$("#user_email").val();
                    var user_code=$("#user_code").val();
                    var user_pwd=$(".user_pwd").val();
                    var user_repwd = $(this).val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    //邮箱号验证
                    if(user_email == ''){
                        layer.msg('手机号或邮箱号不能为空');
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
                    //判断唯一
                    $.ajax({
                        method:"POST",
                        url:"/user/checkName",
                        data:{user_email:user_email}
                    }).done(function(res){
                        $('input[name=user_email]').next().remove();
                        if(res.code==1){
                            // alert(res);
                            $('input[name=user_email]').after("<b style='color:red;'>"+res.res+"</b>")
                        }
                    });

                    if(user_code == '') {
                        layer.msg('验证码不能为空');
                        return;
                    }

                    //验证验证码
                    $.ajax({
                        async:false,
                        method: "post",
                        url: "/user/code",
                        data: {user_code:user_code}
                    }).done(function( res ) {
                        if(res.code==2){
                            layer.msg(res.font,{icon:res.code});
                            flag=false;
                        }else if(res.code==1){
                            layer.msg(res.font,{icon:res.code});
                            flag = true;
                        }
                    });
                    if (flag) {
                        return flag;
                    }

                    //密码
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

                    //确认密码
                    if(user_repwd==''){
                        $(".user_repwd").next().remove();
                        $(this).after("<b style='color:red;'>确认密码必填</b>");
                        flag=false;
                        return;
                    }
                    $(".user_repwd").next().remove();
                    if(user_repwd!=user_pwd){
                        $(this).after("<b style='color:red;'>确认密码必须与密码一致</b>");
                        flag=false;
                        return;
                    }



                    $.ajax({
                    method:"POST",
                    url:"/user/registerdo",
                    dataType:'json',
                    async:false,
                    data:{user_email:user_email,user_code:user_code,user_pwd:user_pwd}
                    }).done(function(res){
                        if (res.code==1){
                            layer.msg(res.font,{icon:res.code});
                            // location.href="/user/login"
                            flag = true;
                        } else if(res.code==2){
                            layer.msg(res.font,{icon:res.code});
                            flag = false;
                        }
                    });
                    if (flag) {
                        return flag;
                    }
                })

            });
        });
    </script>


