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
            url:"/admin.php/Home/Encyclopedias/MenuLists",
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
<link src="/Public/MyStyle/Encyclopedias/EncyclopediasForm.css">
    <div class="row">
        <div class="col-lg-12">
            <!--<h3 class="page-header"><i class="fa fa-laptop"></i> 主页</h3>-->
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="<?php echo U('Login/Home');?>">主页</a></li>
                <li><i class="fa fa-trophy"></i>百科管理</li>
                <li><i class="fa fa-location-arrow"></i>新增百科</li>
            </ol>
        </div>
    </div>

    <?php if($num == 1): ?><div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Success!</strong> 问答题目提交成功!
    </div><script type="text/javascript">
        location:reload();
    </script>
        <?php elseif($num == 2): ?><div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Error!</strong> 问答题目提交失败!
        </div>
        <?php elseif($num == 3): ?><div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Help!</strong> 网络中断了,尝试一下重新提交吧!
        </div>
        <?php elseif($num == 4): ?><div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4 class="alert-heading">Warning!</h4>
            <p>请重新打开页面,不能重复提交数据哦~</p>
        </div>
        <?php else: endif; ?>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2><i class="fa fa-indent red"></i><strong>新增百科</strong></h2>
            </div>
            <div class="panel-body">
                <form action="/admin.php/Home/Encyclopedias/AddNewEncyclopedias" method="post" enctype="multipart/form-data" class="form-horizontal ">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="text-input">标题：</label>
                        <div class="col-md-3">
                            <?php $_SESSION['code']=mt_rand(1,1000);?>
                            <input type="hidden" name="scode" value="<?php echo $_SESSION['code']?>" />
                            <input type="text" id="text-input" name="title" class="form-control" placeholder="输入标题">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="email-input">作者ID：</label>
                        <div class="col-md-1">
                            <input type="email" id="email-input" name="author_id" class="form-control" value="1" readonly="readonly">
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label" for="disabled-input">奖励金额数量：</label>
                        <div class="col-md-1">
                            <input type="text" id="disabled-input" name="disabled-input" class="form-control" placeholder="不支持" readonly="readonly">
        
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">标签自定义：</label>
                        <div class="col-md-9">
                            <input type="text" style="width:250px;height:40px;border:none;border:2px solid #eee;border-radius:4px;font-size:12px;outline: none;"  name="tags" placeholder=" 多个标签使用英文逗号隔开">
                            <span style="color:red">参考：耳朵，眼睛，皮毛，肩高，肠胃，鼻子，嘴巴，四肢，体形，排泄</span>
                        </div>
                    </div>

            
                    <div class="form-group">
                        <label class="col-md-3 control-label">图片:</label>
                        <div class="col-md-9">
                                <ul>
                                    <li class="t" id="tt1">
                                        <input type="file" name="img1">
                                        <span style="margin-left: 21%" id="t1"><button type="button" style="margin-left:10px;background:#0072CC;border:none;border-radius:10px;outline: none;" class="btn btn-sm btn-danger" id="again1">再来一张</button></span>
                                    </li>

                                    <li class="t" style="display: none" id="tt2">
                                        <input type="file" name="img2">
                                        <span style="margin-left: 21%" id="t2"><button type="button" style="margin-left:10px;background:#0072CC;border:none;border-radius:10px;outline: none;" class="btn btn-sm btn-danger" id="again2">再来一张</button></span>
                                    </li>

                                    <li class="t" style="display: none" id="tt3">
                                        <input type="file" name="img3">
                                        <!--<span style="margin-left: 21%" id="t3"><button type="button" style="margin-left:10px;background:#0072CC;border:none;border-radius:10px;outline: none;" class="btn btn-sm btn-danger" id="again3">再来一张</button></span>-->
                                    </li>

                                    <!--<li class="t" style="display: none" id="tt4">-->
                                        <!--<input type="file" name="img4">-->
                                        <!--<span style="margin-left: 21%" id="t4"><button type="button" style="margin-left:10px;background:#0072CC;border:none;border-radius:10px;outline: none;" class="btn btn-sm btn-danger" id="again4">再来一张</button></span>-->
                                    <!--</li>-->

                                    <!--<li class="t" style="display: none" id="tt5">-->
                                        <!--<input type="file" name="img5">-->
                                    <!--</li>-->
                                </ul>
                        </div>
                        <!--<div style="margin-left: 38%">-->
                        <!--<button type="button" style="margin-left:10px;background:#0072CC;border:none;border-radius:10px;outline: none;" class="btn btn-sm btn-danger" id="again">再来一张</button>-->
                        <!--</div>-->
                    </div>
                  <!-- <div class="form-group">
                        <label class="col-md-3 control-label" for="file-multiple-input">Multiple File input</label>
                        <div class="col-md-9">
                            <input type="file" id="file-multiple-input" name="file-multiple-input" multiple>
                        </div>
                    </div> -->
                    <br>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="textarea-input">内容：</label>
                        <div class="col-md-5">
                            <textarea id="textarea-input" name="content" rows="9" class="form-control" placeholder=""></textarea>
                        </div>
                    </div>
        <br>
                    <div style="margin-left: 21%">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-dot-circle-o"></i> 提交</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> 重置</button>                                   </div>
                </form>
            </div>
            <!--<div class="panel-footer">-->
                <!--<button type="submit" style="margin-left:300px;background:#0072CC;border:none;border-radius:10px;outline: none;" class="btn btn-sm btn-success">重置</button>-->
                <!--<button type="reset" style="margin-left:10px;background:#0072CC;border:none;border-radius:10px;outline: none;" class="btn btn-sm btn-danger">提交</button>-->
            <!--</div>-->
        </div>
    </div>

</div>
<script>
    $("#again1").click(function () {
        $("#t1").hide();
        $("#tt2").slideDown();
    });

    $("#again2").click(function () {
        $("#t1").hide();
        $("#t2").hide();
        $("#tt3").slideDown();
    });

//    $("#again3").click(function () {
//        $("#t1").hide();
//        $("#t2").hide();
//        $("#t3").hide();
//        $("#tt4").slideDown();
//    });
//
//    $("#again4").click(function () {
//        $("#t1").hide();
//        $("#t2").hide();
//        $("#t3").hide();
//        $("#t4").hide();
//        $("#tt5").slideDown();
//    });
</script>
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
            $.get("/admin.php/Home/Encyclopedias/LogOut",
                    function(data,status){
                        if(status=='success'){
                            location.href = '/admin.php/Home/Encyclopedias/index';
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