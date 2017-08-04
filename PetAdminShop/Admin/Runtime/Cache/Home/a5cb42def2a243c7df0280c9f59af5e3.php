<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>陪它-后台管理</title>

    <!-- Import google fonts - Heading first/ text second -->
    <!--<link rel='stylesheet' type='text/css' href='http://fonts.useso.com/css?family=Open+Sans:400,700|Droid+Sans:400,700' />-->
    <!--[if lt IE 9]>
    <!--<link href="http://fonts.useso.com/css?family=Open+Sans:400" rel="stylesheet" type="text/css" />-->
    <!--<link href="http://fonts.useso.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css" />-->
    <!--<link href="http://fonts.useso.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" />-->
    <!--<link href="http://fonts.useso.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" />-->
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="/Public/AdminStyle/assets/img/logo.jpg" type="image/x-icon" />
    <!--<link rel="shortcut icon" href="/Public/AdminStyle/assets/ico/favicon.ico" type="image/x-icon" />-->

    <!-- Css files -->
    <link href="/Public/AdminStyle/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/AdminStyle/assets/css/jquery.mmenu.css" rel="stylesheet">
    <link href="/Public/AdminStyle/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="/Public/AdminStyle/assets/css/climacons-font.css" rel="stylesheet">
    <link href="/Public/AdminStyle/assets/plugins/xcharts/css/xcharts.min.css" rel=" stylesheet">
    <link href="/Public/AdminStyle/assets/plugins/fullcalendar/css/fullcalendar.css" rel="stylesheet">
    <link href="/Public/AdminStyle/assets/plugins/morris/css/morris.css" rel="stylesheet">
    <link href="/Public/AdminStyle/assets/plugins/jquery-ui/css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <link href="/Public/AdminStyle/assets/plugins/jvectormap/css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <link href="/Public/AdminStyle/assets/css/style.min.css" rel="stylesheet">
    <link href="/Public/AdminStyle/assets/css/add-ons.min.css" rel="stylesheet">
    <link href="/Public/alertStyle/css/style.css" rel="stylesheet">
    <link href="/Public/MyCss/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/Public/AdminStyle/assets/js/html5shiv.js"></script>
    <script src="/Public/AdminStyle/assets/js/respond.min.js"></script>
    <![endif]-->
    <script src="/Public/AdminStyle/assets/js/jquery-2.1.1.min.js"></script>
    <script src="/Public/alertStyle/js/ui.js"></script>

    <script>
        var data2
        $.ajax({
            type:"get",
            url:"/admin.php/Home/Login/MenuLists",
            dataType:"json",
            success:function(data){
                //console.log(data);
                $.each(data.data, function(i,val){
                    //循环一级菜单
                    $("#menu2").append('<li> <a href="'+val.jurisdiction_url+'" onclick="showUl(this)" style="display"><i class="fa fa-trophy"></i><span class="text">'+val.jurisdiction_name+'</span><span class="fa fa-angle-down pull-right"></span></a> <ul class="nav sub" id='+val.j_id+'> </ul></li>')

                    //循环二级菜单
                    $.each(val.child,function (o,vv) {
                        $("#" + val.j_id).append('<li><a href="/admin.php/Home/'+vv.jurisdiction_url+'"><i class="fa fa-location-arrow"></i><span class="text">'+vv.jurisdiction_name+'</span></a></li>')
                    });


                });

                /*if(data.code == 200){
                    for (var i = 0;i<data.data.length;i++) {
                        var data1 = data.data[i]
                        var id = data1.j_id
                        var url = "daikunxiangqing.html?id="+id
                        $("#menu2").append('<li> <a href="'+data1.jurisdiction_url+'" onclick="showUl(this)" style="display: block"><i class="fa fa-trophy"></i><span class="text">'+data1.jurisdiction_name+'</span><span class="fa fa-angle-down pull-right"></span></a> <ul class="nav sub" id='+data1.j_id+'> </ul></li>')

                        for(var j = 0;j<data1.child.length;j++){
                            data2 = data1.child[j]
                            $("#" + data1.j_id).append('<li><a href="/admin.php/Home/'+data2.jurisdiction_url+'"><i class="fa fa-location-arrow"></i><span class="text">'+data2.jurisdiction_name+'</span></a></li>')
                        }
                    }

                }*/
            }

        });

    </script>

    <style>
        .t{
            margin-top: 15px;
            margin-left: -35px;
        }

        #pay-module ul li{
            list-style-type: none;
            float: left;
            margin:10px 5px;
            border: 1px solid #FFEBCD;
            border-radius: 10px;
            height: 100px;
            width: 250px;
            background: #FFE4B5;
        }

        #pay-module ul li h4{
            text-align: center;
        }
        #pay-module ul li h1{
            text-align: center;
        }
    </style>
</head>

<body>
<!-- start: Header -->
<div class="navbar" role="navigation">

    <div class="container-fluid" style="background:#181c20;">

        <ul class="nav navbar-nav navbar-actions navbar-left">
            <li class="visible-md visible-lg"><a href="javascript:void(0);" id="main-menu-toggle"><i class="fa fa-th-large"></i></a></li>
            <li class="visible-xs visible-sm"><a href="javascript:void(0);" id="sidebar-menu"><i class="fa fa-navicon"></i></a></li>
        </ul>


        <ul class="nav navbar-nav navbar-right">
            <!--<li class="dropdown visible-md visible-lg">-->
                <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i><span class="badge">3</span></a>-->
                <!--<ul class="dropdown-menu">-->
                    <!--<li class="dropdown-menu-header">-->
                        <!--<strong>Notifications</strong>-->
                        <!--<div class="progress thin">-->
                            <!--<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%">-->
                                <!--<span class="sr-only">30% Complete (success)</span>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</li>-->
                    <!--<li class="clearfix">-->
                        <!--<i class="fa fa-comment"></i>-->
                        <!--<a href="page-activity.html" class="notification-user"> Sharon Rose </a>-->
                        <!--<span class="notification-action"> replied to your </span>-->
                        <!--<a href="page-activity.html" class="notification-link"> comment</a>-->
                    <!--</li>-->
                    <!--<li class="clearfix">-->
                        <!--<i class="fa fa-pencil"></i>-->
                        <!--<a href="page-activity.html" class="notification-user"> Nadine </a>-->
                        <!--<span class="notification-action"> just write a </span>-->
                        <!--<a href="page-activity.html" class="notification-link"> post</a>-->
                    <!--</li>-->
                    <!--<li class="clearfix">-->
                        <!--<i class="fa fa-trash-o"></i>-->
                        <!--<a href="page-activity.html" class="notification-user"> Lorenzo </a>-->
                        <!--<span class="notification-action"> just remove <a href="#" class="notification-link"> 12 files</a></span>-->
                    <!--</li>-->
                    <!--<li class="dropdown-menu-footer text-center">-->
                        <!--<a href="page-activity.html">View all notification</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</li>-->
            <li class="dropdown visible-md visible-lg">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i>
                    <?php echo session('username');?>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="/admin.php/Home/Login/MyInfo"><i class="fa fa-user"></i>个人中心</a></li>
                    <li><a href="javascript:void(0);" onclick="logout();"><i class="fa fa-sign-out"></i>退出</a></li>
                </ul>
            </li>
        </ul>

    </div>

</div>
<!-- end: Header -->

<div class="container-fluid content">

    <div class="row">

        <!-- start: Main Menu -->
        <div class="sidebar ">

            <div class="sidebar-collapse">
                <div class="sidebar-header t-center">
                    <span>
                        <font size="5px;">Menu</font>
                        <!--<i class="fa fa-leaf fa-3x blue"></i>-->
                    </span>
                    <!--<span><img class="text-logo" src="/Public/AdminStyle/assets/img/logo1.png"><i class="fa fa-space-shuttle fa-3x blue"></i></span>-->
                </div>
                <div class="sidebar-menu">
                    <ul class="nav nav-sidebar" id="menu2">
                        <li><a href="/admin.php/Home/Login/Home"><i class="fa fa-home"></i><span class="text"> 主页</span></a></li>


                        <!--<li><a href="<?php echo U('Login/Home');?>"><i class="fa fa-home"></i><span class="text"> 主页</span></a></li>-->
                        <!--<li>-->
                            <!--<a href="#"><i class="fa fa-lock"></i><span class="text"> Pages</span> <span class="fa fa-angle-down pull-right"></span></a>-->
                            <!--<ul class="nav sub" id="pages">-->
                            <!--<li><a href="page-activity.html"><i class="fa fa-unlock-alt"></i><span class="text"> Activity</span></a></li>-->
                            <!--</ul>-->
                        <!--</li>-->
                    </ul>
                </div>
            </div>
            <div class="sidebar-footer">

                <div class="sidebar-brand">
                    Pet
                </div>
            </div>

        </div>
        <!-- end: Main Menu -->
<div class="main">

    <div class="row">
        <div class="col-lg-12">
            <!--<h3 class="page-header"><i class="fa fa-laptop"></i> 主页</h3>-->
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="<?php echo U('Login/Home');?>">主页</a></li>
                <li><i class="fa fa-user"></i>个人中心</li>
            </ol>
        </div>
    </div>

    <div id="tip"></div>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2><i class="fa fa-indent red"></i><strong>个人中心</strong></h2>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <br><br>
                    <div class="form-group">
                        <label class="col-md-3 control-label">用户账号</label>
                        <div class="col-md-9">
                            <p class="form-control-static"><?php foreach($data as $key=>$val){ echo $val['username'];}?></p>
                        </div>
                    </div>
                    <p></p>
                    <div class="form-group">
                        <label class="col-md-3 control-label">当前职务</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                <?php foreach($data as $key=>$val){ foreach($val['role_name'] as $kk=>$vv){ echo "<span class='label label-warning'>".$vv."</span>"; } }?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="OldPass">旧密码</label>
                        <div class="col-md-2">
                            <input type="password" id="OldPass" name="OldPass" class="form-control" placeholder="旧密码">
                        </div>
                    </div>
                    <p></p>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="NewPass">新密码</label>
                        <div class="col-md-2">
                            <input type="password" id="NewPass" name="NewPass" class="form-control" placeholder="新密码">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="InCode">  验证码 </label>
                        <div>
                            <input type="text" id="InCode" style=" margin-left:10px; width: 100px; height: 35px; border-radius: 6px; border:2px solid darkturquoise;" name="InCode" placeholder="&nbsp;&nbsp;&nbsp;验证码">
                            <input type = "button" id="code" onclick="createCode()" style="font-family:Arial; font-style:italic; font-weight:bold;  border:0;  letter-spacing:5px;  color:blue; height: 35px;"/>
                        </div>
                    </div>
                    <br>
                    <div style="margin-left: 21%">
                        <button type="button" class="btn btn-sm btn-success" onclick="UserSelfInfoSave()"><i class="fa fa-dot-circle-o"></i> 提交</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> 重置</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script type="text/javascript">

        function UserSelfInfoSave() {
            var OldPass = document.getElementById('OldPass').value;
            $.get("/admin.php/Home/Login/OldPassValidate/OldPass/"+OldPass,
                    function(data,status){
                        if(status=='success')
                        {
                            if(data.code==201){
                                $("#tip").empty();
                                $("#tip").append('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">×</button> <strong>Error!</strong> '+data.msg+'</div>');
                                return false;
                            }else{
                                $("#tip").empty();
                                NewPassValidate();
                            }
                        }else{
                            $("#tip").empty();
                            $("#tip").append('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">×</button> <strong>Error!</strong> 网络出错!</div>');
                            return false;
                        }
                    },'json'
            );


        }


        //设置一个全局的变量，便于保存验证码
        var code;
        function createCode(){
            //首先默认code为空字符串
            code = '';
            //设置长度，这里看需求，我这里设置了4
            var codeLength = 4;
            var codeV = document.getElementById('code');
            //设置随机字符
            var random = new Array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R', 'S','T','U','V','W','X','Y','Z');
            //循环codeLength 我设置的4就是循环4次
            for(var i = 0; i < codeLength; i++){
                //设置随机数范围,这设置为0 ~ 36
                var index = Math.floor(Math.random()*36);
                //字符串拼接 将每次随机的字符 进行拼接
                code += random[index];
            }
            //将拼接好的字符串赋值给展示的Value
            codeV.value = code;
        }

        //下面就是判断是否== 的代码，无需解释
        function validate(){
            var oValue = document.getElementById('InCode').value.toUpperCase();
            if(oValue ==0){
                $("#tip").empty();
                $("#tip").append('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">×</button> <strong>Error!</strong> 请输入验证码!</div>');
                return false;
            }else if(oValue != code){
                $("#tip").empty();
                $("#tip").append('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">×</button> <strong>Error!</strong> 验证码不正确!</div>');
                oValue = ' ';
                createCode();
                return false;
            }else{
                $("#tip").empty();
                return true;
            }
        }

        //设置此处的原因是每次进入界面展示一个随机的验证码，不设置则为空
        window.onload = function (){

            createCode();
        }
        
        function NewPassValidate() {
            var NewPass = $.trim($("#NewPass").val());
            if(NewPass.length<=0){
                $("#tip").empty();
                $("#tip").append('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">×</button> <strong>Error!</strong> 新密码不能为空!</div>');
                return false;
            }else{
                $("#tip").empty();
                validate();

                $.get("/admin.php/Home/Login/UserSelfInfoSave/NewPass/"+NewPass,
                    function(data,status){
                        if(status='success'){
                            if(data.code==200){
                                alert(data.msg);
                            }else{
                                $("#tip").empty();
                                $("#tip").append('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">×</button> <strong>Error!</strong>'+data.msg+'</div>');
                                createCode();
                                return false;
                            }
                        }else{
                            $("#tip").empty();
                            $("#tip").append('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">×</button> <strong>Error!</strong> 网络中断了,尝试一下重新提交吧!</div>');
                            createCode();
                            return false;
                        }
                    },'json'
                );

            }

        }


    </script>

</div>
<div id="usage">
    <div style="text-align: center; margin-top: 10px;">陪它-后台管理</div>
    <!--<ul>-->
        <!--<li>-->
            <!--<div class="title">Memory</div>-->
            <!--<div class="bar">-->
                <!--<div class="progress">-->
                    <!--<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="desc">4GB of 8GB</div>-->
        <!--</li>-->
        <!--<li>-->
            <!--<div class="title">HDD</div>-->
            <!--<div class="bar">-->
                <!--<div class="progress">-->
                    <!--<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="desc">250GB of 1TB</div>-->
        <!--</li>-->
        <!--<li>-->
            <!--<div class="title">SSD</div>-->
            <!--<div class="bar">-->
                <!--<div class="progress">-->
                    <!--<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%"></div>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="desc">700GB of 1TB</div>-->
        <!--</li>-->
        <!--<li>-->
            <!--<div class="title">Bandwidth</div>-->
            <!--<div class="bar">-->
                <!--<div class="progress">-->
                    <!--<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%"></div>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="desc">90TB of 100TB</div>-->
        <!--</li>-->
    <!--</ul>-->
</div>

</div><!--/container-->


<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Warning Title</h4>
            </div>
            <div class="modal-body">
                <p>Here settings can be configured...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="clearfix"></div>


<!-- start: JavaScript-->
<!--[if !IE]>-->

<script src="/Public/AdminStyle/assets/js/jquery-2.1.1.min.js"></script>

<!--<![endif]-->

<!--[if IE]>

<script src="/Public/AdminStyle/assets/js/jquery-1.11.1.min.js"></script>

<![endif]-->

<!--[if !IE]>-->

<script type="text/javascript">
    window.jQuery || document.write("<script src='/Public/AdminStyle/assets/js/jquery-2.1.1.min.js'>"+"<"+"/script>");
</script>

<!--<![endif]-->

<!--[if IE]>

<script type="text/javascript">
    window.jQuery || document.write("<script src='/Public/AdminStyle/assets/js/jquery-1.11.1.min.js'>"+"<"+"/script>");
</script>

<![endif]-->
<script src="/Public/AdminStyle/assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/Public/AdminStyle/assets/js/bootstrap.min.js"></script>


<!-- page scripts -->
<script src="/Public/AdminStyle/assets/plugins/jquery-ui/js/jquery-ui-1.10.4.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/moment/moment.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/fullcalendar/js/fullcalendar.min.js"></script>
<!--[if lte IE 8]>
<script language="javascript" type="text/javascript" src="/Public/AdminStyle/assets/plugins/excanvas/excanvas.min.js"></script>
<![endif]-->
<script src="/Public/AdminStyle/assets/plugins/flot/jquery.flot.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/flot/jquery.flot.stack.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/flot/jquery.flot.time.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/flot/jquery.flot.spline.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/xcharts/js/xcharts.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/autosize/jquery.autosize.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/placeholder/jquery.placeholder.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/raphael/raphael.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/morris/js/morris.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/jvectormap/js/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/jvectormap/js/jquery-jvectormap-world-mill-en.js"></script>
<script src="/Public/AdminStyle/assets/plugins/jvectormap/js/gdp-data.js"></script>
<script src="/Public/AdminStyle/assets/plugins/gauge/gauge.min.js"></script>


<!-- theme scripts -->
<script src="/Public/AdminStyle/assets/js/SmoothScroll.js"></script>
<script src="/Public/AdminStyle/assets/js/jquery.mmenu.min.js"></script>
<script src="/Public/AdminStyle/assets/js/core.min.js"></script>
<script src="/Public/AdminStyle/assets/plugins/d3/d3.min.js"></script>

<!-- inline scripts related to this page -->
<script src="/Public/AdminStyle/assets/js/pages/index.js"></script>

<script>
    function logout() {

        mizhu.confirm('温馨提醒', '确定要退出吗？', function() {
            $.get("/admin.php/Home/Login/LogOut",
                    function(data,status){
                        if(status=='success'){
                            location.href = '/admin.php/Home/Login/index';
                        }else{
                            mizhu.toast('请求失败，请检查网络！');
                        }
                    },'json');
        });
    }


    function showUl(obj) {

        var ulObj = $(obj).next()
        var display = $(ulObj).css("display")
        if(display == "none"){
            var display = $(ulObj).css("display")
            ulObj.slideDown();
            return false;
        }else{
            ulObj.slideUp();
            return false;
        }

    }


    function tiaozhuan() {
        var page = $("#Tpage").val();
        var word = $("#word2").val();
        window.location.href='?page='+page+'&word='+word;
    }
</script>

<!-- end: JavaScript-->

</body>
</html>