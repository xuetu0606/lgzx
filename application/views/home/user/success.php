<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册成功</title>
    <link rel="stylesheet" href="/static/css/common.css"/>
    <link rel="stylesheet" href="/static/css/head-foot.css"/>
    <link rel="stylesheet" href="/static/css/success.css"/>
</head>
<body>
<header>
    <div class="main">
        <div class="city">
            <span class="stress">青岛</span>
            <a href="切换城市.html">[切换城市]</a>
        </div>
        <div class="fr">
            <ul>
                <li><a href="#">用户名1234567</a></li>
                <li><a href="#">退出</a></li>
                <li class="lgbxl"><a href="#">零工宝</a><img src="/static/images/xiala.png" alt=""/></li>
                <li class="stress wxb">微信版</li>
                <li><a href="#" class="stress">手机版</a></li>
                <li><a href="#">帮助</a></li>
            </ul>
            <div class="lgb">
                <a href="#">零工宝<img src="/static/images/xiala.png" alt="" /></a>
                <a href="#" class="lgba">我的发布</a>
                <a href="#" class="lgba">我的收藏</a>
                <a href="#" class="lgba">我的资料</a>
            </div>
            <div class="wx">
                <img src="/static/images/head-foot/weixin.png" alt=""/>
            </div>
        </div>
    </div>

</header>
<section>
    <h1>恭喜您，用户名<?php echo  $user['username'];?>注册成功！</h1>
    <p class="p1">零工在线赠送您 <span class="stress">10</span>个零工币，您可以免费使用更多功能</p>
    <p><a href="/user">进入零工宝</a> <a href="/publish">免费发布信息</a></p>
</section>
<footer>
    <div class="main">
        <ul>
            <li><a href="#">法律声明 |</a></li>
            <li><a href="#">零工宝 |</a></li>
            <li><a href="#">零工小参 |</a></li>
            <li><a href="#">招贤纳士 |</a></li>
            <li><a href="#">关注微博</a></li>
        </ul>
        <p>Copyright © 2016 lg-zx.com Corporation, All Rights Reserved 鲁ICP备16012134号-1 站长统计</p>
    </div>
</footer>

</body>
<script src="js/jquery.js"></script>
<script src="js/head-foot.js"></script>
</html>