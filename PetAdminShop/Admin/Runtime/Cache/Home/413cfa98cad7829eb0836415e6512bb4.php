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
            url:"/admin.php/Home/Orders/MenuLists",
            dataType:"json",
            success:function(data){
                //console.log(data);

                if(data.code == 200){
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

                }
            }

        });

    </script>

    <style>
        .t{
            margin-top: 15px;
            margin-left: -35px;
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
                <li><i class="fa fa-trophy"></i>商户管理</li>
                <li><i class="fa fa-location-arrow"></i>店铺审核</li>
                <li><i class="fa fa-paperclip"></i>审核信息</li>
            </ol>
        </div>
    </div>

    <div id="tip"></div>

    <?php if($num == 1): ?><div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Success!</strong> 操作执行成功!
    </div><script type="text/javascript">
        location:reload();
    </script>
        <?php elseif($num == 2): ?><div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Error!</strong> 操作执行失败!
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
                <h2><i class="fa fa-indent red"></i><strong>审核信息</strong></h2>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <br><br>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="in_city">所在城市</label>
                        <div class="col-md-2">
                            <input type="hidden" name="s_id" id="s_id" value="<?php echo ($data["s_id"]); ?>"/>
                            <input type="text" id="in_city" name="in_city" class="form-control" value="<?php echo ($data["in_city"]); ?>" readonly = "readonly">
                            <!--<span class="help-block">This is a help text</span>-->
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="position">位置</label>
                        <div class="col-md-2">
                            <input type="text" id="position" name="position" class="form-control" value="<?php echo ($data["position"]); ?>" readonly = "readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="detailed_address">详细位置</label>
                        <div class="col-md-2">
                            <input type="text" id="detailed_address" name="detailed_address" class="form-control" value="<?php echo ($data["detailed_address"]); ?>" readonly = "readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="merchant_name">商户名称</label>
                        <div class="col-md-2">
                            <input type="text" id="merchant_name" name="merchant_name" class="form-control" value="<?php echo ($data["merchant_name"]); ?>" readonly = "readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="merchant_type">商店类型</label>
                        <div class="col-md-2">
                            <input type="text" id="merchant_type" name="merchant_type" class="form-control" value="<?php echo ($data["merchant_type"]); ?>" readonly = "readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="scope">经营范围</label>
                        <div class="col-md-2">
                            <input type="text" id="scope" name="scope" class="form-control" value="<?php echo ($data["scope"]); ?>" readonly = "readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="shopkeeper">店铺联系人</label>
                        <div class="col-md-2">
                            <input type="text" id="shopkeeper" name="shopkeeper" class="form-control" value="<?php echo ($data["shopkeeper"]); ?>" readonly = "readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="phone">联系电话</label>
                        <div class="col-md-2">
                            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo ($data["phone"]); ?>" readonly = "readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="tel">客服电话</label>
                        <div class="col-md-2">
                            <input type="text" id="tel" name="tel" class="form-control" value="<?php echo ($data["tel"]); ?>" readonly = "readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="front">店铺门脸图</label>
                        <div class="col-md-2">
                            <img class="img-thumbnail" id="front" src="<?php echo ($data["front"]); ?>" alt="加载失败" height="200px;" width="200px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">店铺环境图</label>
                        <div class="col-md-2 shop_image">

                            <table class="img-table">
                                <tr>
                                    <td><img class="img-thumbnail" id="shop_image_one" src="<?php echo ($data["shop_image_one"]); ?>" alt="加载失败" height="200px;" width="200px;"></td>
                                    <td><img class="img-thumbnail" id="shop_image_two" src="<?php echo ($data["shop_image_two"]); ?>" alt="加载失败" height="200px;" width="200px;"></td>
                                    <td><img class="img-thumbnail" id="shop_image_three" src="<?php echo ($data["shop_image_three"]); ?>" alt="加载失败" height="200px;" width="200px;"></td>
                                    <td><img class="img-thumbnail" id="shop_image_four" src="<?php echo ($data["shop_image_four"]); ?>" alt="加载失败" height="200px;" width="200px;"></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="business_num">营业执照号码</label>
                        <div class="col-md-2">
                            <input type="text" id="business_num" name="business_num" class="form-control" value="<?php echo ($data["business_num"]); ?>" readonly = "readonly">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label" for="license_one">营业执照</label>
                        <div class="col-md-2">
                            <img class="img-thumbnail" id="license_one" src="<?php echo ($data["license_one"]); ?>" alt="加载失败" height="200px;" width="200px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="id_card">身份证号码</label>
                        <div class="col-md-2">
                            <input type="text" id="id_card" name="id_card" class="form-control" value="<?php echo ($data["id_card"]); ?>" readonly = "readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="id_card_img">身份证图片</label>
                        <div class="col-md-2">
                            <img class="img-thumbnail" id="id_card_img" src="<?php echo ($data["id_card_img"]); ?>" alt="加载失败" height="200px;" width="200px;">
                        </div>
                    </div>


                    <div class="form-group" style="display: none" id="reg">
                        <label class="col-md-3 control-label">拒绝原因</label>
                        <div class="col-md-9">
                            <textarea name="failure_reason" id="failure_reason" rows="9" class="form-control" placeholder="请输入回复信息"></textarea>
                        </div>

                        <!--<button type="button" class="btn btn-sm btn-success" style="float: right; margin-top: 15px;"><i class="fa fa-dot-circle-o"></i> 确定</button>-->
                    </div>

                    <br>
                    <div style="margin-left: 27%">
                        <button type="button" class="btn btn-sm btn-success" onclick="ok();"><i class="fa fa-dot-circle-o"></i> 通过</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-sm btn-danger" onclick="AlertTip();"><i class="fa fa-ban"></i> 拒绝</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        function ok() {
            var s_id = $.trim($("#s_id").val());
            mizhu.confirm('温馨提醒', '确定要通过这条信息吗？', function() {
                $.get(
                        "/admin.php/Home/Orders/ShopOk/s_id/"+s_id,
                        function(data,status){
                            if(status=='success'){
                                if(data.code==200){
                                    mizhu.toast(data.msg);
                                    history.go(0);
                                }else{
                                    mizhu.toast(data.msg);
                                }
                            }
                        },'json'
                );
            });
        }
        
        
        function AlertTip() {
            $("#reg").dialog({
                buttons : {
                    '提交' : function () {
                        var failure_reason = $.trim($("#failure_reason").val());
                        var s_id = $.trim($("#s_id").val());
                        if(failure_reason.length<=0){
                            mizhu.toast("请输入拒绝原因");
                            return false;
                        }

                        $.get(
                                "/admin.php/Home/Orders/ShopNo/s_id/"+s_id+"/failure_reason/"+failure_reason,
                                function(data,status){
                                    if(status=='success'){
                                        if(data.code==200){
                                            mizhu.toast(data.msg);
                                            history.go(0);
                                        }else{
                                            mizhu.toast(data.msg);
                                            history.go(0);
                                        }
                                    }
                                },'json'
                        );


                    },
                    '取消' : function () {
                        $(this).dialog('close');
                    }
                },
                width:500,
                height:210,
                show : 'puff',
                hide : 'puff',
                closeText : '关闭'
            }
            );
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
            $.get("/admin.php/Home/Orders/LogOut",
                    function(data,status){
                        if(status=='success'){
                            location.href = '/admin.php/Home/Orders/index';
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