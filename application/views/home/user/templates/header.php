<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>零工宝-<?php echo $title;?></title>
    <link rel="stylesheet" href="/static/css/common.css"/>
    <link rel="stylesheet" href="/static/css/head-foot.css"/>
    <link rel="stylesheet" href="/static/css/workInfor.css"/>
    <link rel="stylesheet" href="/static/css/form.css"/>
    <?php
    echo $head_css;
    ?>
</head>
<body>
<header>
    <div class="main">
        <div class="city">
            <span class="stress"><?php echo $cityname; ?></span>
            <a href="http://www.lg-zx.com/">[切换城市]</a>
        </div>
        <div class="fr">
            <ul>
                <?php if($_SESSION['uid']){?>
                    <li><a href="/user"><?php echo $_SESSION['username']?></a></li>
                    <li><a href="/user/logout">退出</a></li>
                <?php }else{?>
                    <li><a href="/user/reg">注册</a></li>
                    <li><a href="/user/login">登录</a></li>
                <?php }?>
                <li class="lgbxl"><a href="#">零工宝</a><img src="/static/images/xiala.png" alt=""/></li>
                <li class="stress wxb">微信版</li>
                <li><a href="#" class="stress">手机版</a></li>
                <li><a href="#">帮助</a></li>
            </ul>
            <div class="lgb">
                <a href="/user">零工宝<img src="/static/images/xiala.png" alt="" /></a>
                <a href="/user" class="lgba">我的发布</a>
                <a href="/user/shoucang" class="lgba">我的收藏</a>
                <a href="/user/myinfo" class="lgba">我的资料</a>
            </div>
            <div class="wx">
                <img src="/static/images/head-foot/weixin.png" alt=""/>
            </div>
        </div>
    </div>

</header>
<div class="full">
    <div class="main">
        <img src="/static/images/LOGOa.png" alt="" class="logo"/>
        <form action="">
            <input type="text" class="input-normal"/>
            <input type="submit" value="" class="fdj"/>
        </form>
        <a href="/pub/selest">免费发布信息</a>
    </div>
</div>
<section>
    <div class="position">
        <span>青岛零工在线</span>
        <span> > </span>
        <span>零工宝</span>
    </div>
    <div class="main">
        <div class="head">
            <div class="top">
                <img src="<?php echo $user['img']?>" alt="" class="tx"/>
                <p>
                    <span class="name"><?php echo $_SESSION['username']?></span>
                    <span class="number">工号：<?php echo $_SESSION['no']?></span>
                </p>
            </div>
            <div class="bottom">
                <ul>
                    <li>信用等级: <img src="<?php echo $user['medal']?>" alt=""/></li>
                    <li>会员：<?php echo $user['vip_endtime']?'VIP':'<span style="text-decoration:line-through">VIP</span> <a href="/user/buyvip">购买</a>'?></li>
                    <li>零工币余额：<span class="stress"><?php echo $user['credit1']?$user['credit1']:'0'?></span>个<a href="/user/recharge">购买</a></li>
                    <li>工分余额：<span class="stress"><?php echo $user['credit2']?$user['credit2']:'0'?></span>个<a href="/pay/cash">提现</a></li>
                </ul>
            </div>
        </div>
        <div class="body">
            <div class="navigation">
                <h1>零工宝</h1>
                <ul id="navlist">
                    <li><a href="/user" class="active">我的发布</a></li>
                    <li><a href="#">我的收藏</a></li>
                    <li><a href="/user/myinfo">我的资料</a></li>
                    <li><a href="#">认证管理</a></li>
                    <li><a href="#">认证管理</a></li>
                    <li><a href="#">账户明细</a></li>
                    <li><a href="#">我的评价</a></li>
                    <li><a href="#">消息文件</a></li>
                    <li><a href="#">签约推广</a></li>
                </ul>
            </div>
