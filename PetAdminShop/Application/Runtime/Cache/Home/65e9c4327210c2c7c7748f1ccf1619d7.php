<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <style>
        *{margin: 0;padding: 0;}
        input{margin-top: 6px;border:none;outline: none;background:none;font-size:14px;}
        #play{width: 100%;}
        #play ul{list-style:none;}
        #play ul li{display:none;}
        #play ul li img{width:100%;margin: 10% 0 10% 0;}
        #play #prev{font-size:18px;float:left; border:none;background:none;margin-left: 10px;outline: none;}
        #play #next{font-size:18px;float: right;border:none;background:none;margin-right: 10px;outline: none;}
    </style>
</head>
<body>
<input type="button" name="Submit" onclick="javascript:history.back(-1);" value="〈 返回首頁">
<div id="play">
    <ul id="ul">
        <li style="display: block;"><img src="/Public/CardExplain/images/P_d.jpg" alt=""></li>
        <li><img src="/Public/CardExplain/images/P_e.jpg" alt=""></li>
        <li><img src="/Public/CardExplain/images/p_f .jpg" alt=""></li>
        <li><img src="/Public/CardExplain/images/P_g.jpg" alt=""></li>
        <li><img src="/Public/CardExplain/images/p_h.jpg" alt=""></li>
        <li><img src="/Public/CardExplain/images/P_i.jpg" alt=""></li>
        <li><img src="/Public/CardExplain/images/P_j.jpg" alt=""></li>
        <li><img src="/Public/CardExplain/images/P_k.jpg" alt=""></li>
        <li><img src="/Public/CardExplain/images/P_l.jpg" alt=""></li>
        <li><img src="/Public/CardExplain/images/p_m.jpg" alt=""></li>
    </ul>
    <button id="prev">上一页</button>
    <button id="next">下一页</button>
</div>
<script>
    // 获取所有的图片集合
    var Imgs = document.getElementById('ul').getElementsByTagName('li');
    var Prev = document.getElementById('prev');
    var Next = document.getElementById('next');
    var ii = 0; // 默认显示的图片;
    // 跳转到指定的图片
    function goTo(num){
        for (var i =0; i<Imgs.length;i++) {
            if(num == i){
                // 显示当前的图片
                Imgs[num];
                // 改图片标记的样式
                Imgs[num].style.display = 'block';
            }else{
                Imgs[i].style.display = 'none';
                Imgs[i];
            }
        }
    }
    // 上一页
    Prev.onclick = function (){
        ii -= 1;
        if(ii<0) ii = Imgs.length-1;
        goTo(ii);
    }
    // 下一页
    Next.onclick = function (){
        ii += 1;
        if(ii>Imgs.length-1) ii = 0;
        goTo(ii);
    }


</script>
</body>

</html>