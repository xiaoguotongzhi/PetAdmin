<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8"/>
    <title>陪它-后台管理</title>
    <link rel="shortcut icon" href="/Public/AdminStyle/assets/img/logo.jpg" type="image/x-icon" />
    <!--<script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.js"></script>-->
    <script type="text/javascript" src="/Public/LoginStyle/jquery.js"></script>
    <link href="/Public/alertStyle/css/style.css" rel="stylesheet">
    <script src="/Public/alertStyle/js/ui.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/SlowLoginStyle/css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="/Public/SlowLoginStyle/assets/less/unlock.css">
    <style>
        body{
            background: #ebebeb;
            font-family: "Helvetica Neue","Hiragino Sans GB","Microsoft YaHei","\9ED1\4F53",Arial,sans-serif;
            color: #222;
            font-size: 12px;
        }
        *{padding: 0px;margin: 0px;}
        .top_div{
            background: #008ead;
            width: 100%;
            height: 400px;
        }
        .ipt{
            border: 1px solid #d3d3d3;
            padding: 10px 10px;
            width: 290px;
            border-radius: 4px;
            padding-left: 35px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s
        }
        .ipt:focus{
            border-color: #66afe9;
            outline: 0;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6)
        }
        .u_logo{
            background: url("/Public/LoginStyle/images/username.png") no-repeat;
            padding: 10px 10px;
            position: absolute;
            top: 43px;
            left: 40px;

        }
        .p_logo{
            background: url("/Public/LoginStyle/images/password.png") no-repeat;
            padding: 10px 10px;
            position: absolute;
            top: 12px;
            left: 40px;
        }
        a{
            text-decoration: none;
        }
        .tou{
            background: url("/Public/LoginStyle/images/tou.png") no-repeat;
            width: 97px;
            height: 92px;
            position: absolute;
            top: -87px;
            left: 140px;
        }
        .left_hand{
            background: url("/Public/LoginStyle/images/left_hand.png") no-repeat;
            width: 32px;
            height: 37px;
            position: absolute;
            top: -38px;
            left: 150px;
        }
        .right_hand{
            background: url("/Public/LoginStyle/images/right_hand.png") no-repeat;
            width: 32px;
            height: 37px;
            position: absolute;
            top: -38px;
            right: -64px;
        }
        .initial_left_hand{
            background: url("/Public/LoginStyle/images/hand.png") no-repeat;
            width: 30px;
            height: 20px;
            position: absolute;
            top: -12px;
            left: 100px;
        }
        .initial_right_hand{
            background: url("/Public/LoginStyle/images/hand.png") no-repeat;
            width: 30px;
            height: 20px;
            position: absolute;
            top: -12px;
            right: -112px;
        }
        .left_handing{
            background: url("/Public/LoginStyle/images/left-handing.png") no-repeat;
            width: 30px;
            height: 20px;
            position: absolute;
            top: -24px;
            left: 139px;
        }
        .right_handinging{
            background: url("/Public/LoginStyle/images/right_handing.png") no-repeat;
            width: 30px;
            height: 20px;
            position: absolute;
            top: -21px;
            left: 210px;
        }

        .wrapper {
            min-width: 300px;
            max-width: 1200px;
            margin: 5px 50px;
        }
        .bar {
            height: 40px;
            width: 300px;
        }


    </style>
    <script type="text/javascript">
        $(function(){
            //得到焦点
            $("#password").focus(function(){
                $("#left_hand").animate({
                    left: "150",
                    top: " -38"
                },{step: function(){
                    if(parseInt($("#left_hand").css("left"))>140){
                        $("#left_hand").attr("class","left_hand");
                    }
                }}, 2000);
                $("#right_hand").animate({
                    right: "-64",
                    top: "-38px"
                },{step: function(){
                    if(parseInt($("#right_hand").css("right"))> -70){
                        $("#right_hand").attr("class","right_hand");
                    }
                }}, 2000);
            });
            //失去焦点
            $("#password").blur(function(){
                $("#left_hand").attr("class","initial_left_hand");
                $("#left_hand").attr("style","left:100px;top:-12px;");
                $("#right_hand").attr("class","initial_right_hand");
                $("#right_hand").attr("style","right:-112px;top:-12px");
            });
        });
    </script>
</head>
<body>
<div class="top_div"></div>
<div style="width: 400px;height: 200px;margin: auto auto;background: #ffffff;text-align: center;margin-top: -100px;border: 1px solid #e7e7e7">
    <div style="width: 165px;height: 96px;position: absolute">
        <div class="tou"></div>
        <div id="left_hand" class="initial_left_hand"></div>
        <div id="right_hand" class="initial_right_hand"></div>
    </div>

    <p style="padding: 30px 0px 10px 0px;position: relative;">
        <span class="u_logo"></span>
        <input class="ipt" id="username" type="text" placeholder="请输入账号">
    </p>
    <p style="position: relative;">
        <span class="p_logo"></span>
        <input id="password" class="ipt" type="password"  placeholder="请输入密码">
    </p>

    <div style="height: 50px;line-height: 50px;margin-top: 30px;border-top: 1px solid #e7e7e7;">
        <p style="margin: 5px 10px;" id="sub_button">
           <span style="float: right">
               <span id="tips" style="margin-right: 80px;"></span>
               <a href="javascript:void(0);" id="sub" style="background: #008ead;padding: 7px 10px;border-radius: 4px;border: 1px solid #1a7598;color: #FFF;font-weight: bold;" onclick="sub();">登录</a>
           </span>
        </p>


        <div class="wrapper" id="sub_hua">
            <div class="bar3 bar"></div>
        </div>
    </div>

</div>

<div style="position: fixed;bottom: 0px;text-align: center;width: 100%;">
    Copyright ©2017 天讯互联
    <!--<a style="margin-left: 10px;color: #000000;text-decoration: underline" href="http://www.peita.net">http://www.peita.net</a>-->
</div>

<script>window.jQuery || document.write('<script src="/Public/SlowLoginStyle/js/jquery-1.11.0.min.js"><\/script>')</script>
<script src='/Public/SlowLoginStyle/assets/js/unlock.js'></script>
<script type="text/javascript">

    window.onload = function () {
        var screen_width = screen.width;
        if(screen_width>1024){
            $("#sub_button").css('display','none');
            $("#sub_hua").css('display');
        }else{
            $("#sub_button").css('display');
            $("#sub_hua").css('display','none');
        }
    }

    //滑动验证码
    $('.bar3').slideToUnlock({
        text : '滑动登录！',
        succText: '已验证！',
        successFunc:function () {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            if(trim(username).length<=0 || trim(password).length<=0){
                mizhu.toast('请正确填写账号信息');
                //document.getElementById('tips').innerHTML = '账号信息错误';
                //document.getElementById('tips').style.color = 'red';
                //document.getElementById('tips').style.fontWeight = 'bold';
                return false;
            }

            //提交
            $.post("/admin.php/Home/Login/LoginVerification",
                    {
                        username:username,
                        password:password
                    },
                    function(data,status){
                        if(status=='success'){
                            if(data.res=='ok'){
                                mizhu.toast(data.tip);
                                //alert(data.tip);
                                location.href = '/admin.php/Home/Login/Home';
                            }else if(data.res=='error'){
                                mizhu.toast(data.tip);
                                history.go(0);
                                //document.getElementById('tips').innerHTML = data.tip;
                                //document.getElementById('tips').style.color = 'red';
                                //document.getElementById('tips').style.fontWeight = 'bold';
                                //alert(data.tip);
                                //history.go(0);
                            }else{
                                mizhu.toast('登录失败，请检查网络');
                                history.go(0);
                            }
                        }else{
                            mizhu.toast('登录失败，请检查网络');
                            history.go(0);
                        }
                    },'json');
        }
    });


    //表单登录验证
    function trim(str) {
        return str.replace(/(^\s+)|(\s+$)/g, "");
    }

    function sub() {
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        if(trim(username).length<=0 || trim(password).length<=0){
            mizhu.toast('请正确填写账号信息');
            //document.getElementById('tips').innerHTML = '账号信息错误';
            //document.getElementById('tips').style.color = 'red';
            //document.getElementById('tips').style.fontWeight = 'bold';
            return false;
        }

        //提交
        $.post("/admin.php/Home/Login/LoginVerification",
                {
                    username:username,
                    password:password
                },
                function(data,status){
                    if(status=='success'){
                        if(data.res=='ok'){
                            mizhu.toast(data.tip);
                            //alert(data.tip);
                            location.href = '/admin.php/Home/Login/Home';
                        }else if(data.res=='error'){
                            mizhu.toast(data.tip);
                        }else{
                            mizhu.toast('登录失败，请检查网络');
                            history.go(0);
                        }
                    }else{
                        mizhu.toast('登录失败，请检查网络');
                        history.go(0);
                    }
                },'json');
    }
</script>
</body>
</html>