<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>招零工详情页</title>
    <link rel="stylesheet" href="/static/css/common.css"/>
    <link rel="stylesheet" href="/static/css/head-foot.css"/>
    <link rel="stylesheet" href="/static/css/workInfor.css"/>
    <link rel="stylesheet" href="/static/css/form.css"/>
    <link rel="stylesheet" href="/static/css/detail.css"/>
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
                <li><a href="#">1kglskgkfmv</a></li>
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
<div class="full">
    <div class="main">
        <img src="/static/images/LOGOa.png" alt="" class="logo"/>
        <form action="">
            <input type="text" class="input-normal"/>
            <input type="submit" value="" class="fdj"/>
        </form>
        <a href="#">免费发布信息</a>
    </div>
</div>
<section>
    <div class="position">
        <span>青岛零工在线</span>
        <span> > </span>
        <span>家政服务</span>
        <span> > </span>
        <span>保姆/月嫂</span>
        <span> > </span>
        <span>优优家政、招聘信息</span>
    </div>
    <div class="main">
        <div class="title">
            <div class="left">
                <div class="line1">
                    <span class="name"><?= $news[0]['title'] ?></span>
                    <span class="vip">
						<?php
							if($news[0]['vip'] == 1){
								echo '<img src="/static/images/vip/vip1.png" alt=""/>';
							}else{
								echo '';
							}
						?>
					</span>
                    <span class="identify">
						<?php
							if($news[0]['yingyezhiz'] == 1){
								echo '<img src="/static/images/renzheng/yingyezhiz.png" alt=""/>';
							}else{
								echo '';
							}
						?>
					</span>
                </div>
                <div class="line2">
                    <span>信用等级</span><img src="/static/images/vip/yp.png" alt=""/>
                    <img src="/static/images/vip/sj.png" alt=""class="clock"/>
                    <span class="time"><?= date('Y-m-d',$news[0]['addtime']) ?></span>
                    <span>|</span>
                    <span class="pageview"><?= $news[0]['pv'] ?>次浏览</span>
                </div>
            </div>
           <div class="right">
            <span class="salary"><?= $news[0]['pay'] ?><?= $news[0]['pay_unit'] ?></span>
               <a href="#"> 应聘该职位</a>
           </div>
        </div>
        <div class="infor">
            <div class="scale">
                <p>
                    <span class="name">公司名称：</span>
                    <span class="content"><?= $news[0]['coname'] ?></span>
                </p>
                <p>
                    <span class="name">职位名称：</span>
                    <span class="content"><?= $news[0]['job_name'] ?></span>
                </p>
                <p>
                    <span class="name">学历要求：</span>
                    <span class="content">不限</span>
                </p>
                <p>
                    <span class="name">工作经验：</span>
                    <span class="content">1-3年</span>
                </p>
                <p>
                    <span class="name">工作时间：</span>
                    <span class="content"><?= $news[0]['worktime'] ?></span>
                </p>
                <p>
                    <span class="name">工资结算：</span>
                    <span class="content"><?= $news[0]['pay_circle'] ?></span>
                </p>
                <p>
                    <span class="name">公司地址：</span>
                    <span class="content"><?= $news[0]['address'] ?></span>
                </p>
            </div>
             <div class="scale-right">
                 <p>
                     <span class="name"></span>
                     <span class="content"></span>
                 </p>
                 <p>
                     <span class="name">工作区域：</span>
                     <span class="content"><?= $news[0]['district_dic'] ?></span>
                 </p>
                 <p>
                     <span class="name">雇佣类型：</span>
                     <span class="content">普通零工</span>
                 </p>
                 <p>
                     <span class="name">招聘人数：</span>
                     <span class="content"><?= $news[0]['sum'] ?></span>
                 </p>
                 <p>
                     <span class="name">性别要求：</span>
                     <span class="content">不限</span>
                 </p>
                 <p>
                     <span class="name">联系人：</span>
                     <span class="content"><?= $news[0]['contacts'] ?></span>
                 </p>
                 <p>
                     <span class="name">联系电话：</span>
                     <span class="content stress"><?= $news[0]['mobile'] ?></span>
                 </p>
             </div>
        </div>
        <div class="introduce">
            <p class="line">
                <span class="active">工作内容</span>
                <span>公司详情</span>
            </p>
            <div class="fwjs">
                <pre>
	<?= $news[0]['info'] ?>
                </pre>
            </div>
            <div class="gsxq">
                <p>
                    <span class="name">公司名称：</span>
                    <span class="content"><?= $news[0]['coname'] ?></span>
                </p>
                <p>
                    <span class="name">公司地址：</span>
                    <span class="content"><?= $news[0]['address'] ?></span>
                </p>
                <p>
                    <span class="name">公司简介：</span>
                    <span class="content">
						<?= $news[0]['co_info'] ?>
                    </span>
                </p>
            </div>
        </div>
    </div>
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
<script src="/static/js/jquery.js"></script>
<script src="/static/js/head-foot.js"></script>
<script src="/static/js/detail.js"></script>
<script src="/static/js/star.js"></script>
</html>