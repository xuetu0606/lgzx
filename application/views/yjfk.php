<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/static/css/common.css"/>
    <link rel="stylesheet" href="/static/css/head-foot.css"/>
    <link rel="stylesheet" href="/static/css/help.css"/>
    <link rel="stylesheet" href="/static/css/form.css"/>
    <title>意见反馈</title>
</head>
<body>
<section>
    <div class="head">
        <img src="/static/images/LOGOa.png" alt=""/>
        <span>意见反馈</span>
    </div>
</section>
<p class="line"></p>
<section>
    <div class="main">
        <form action="<?php echo site_url('help/yjfk'); ?>" method="post">
            <div class="form-group">
                <label><span class="xing">*</span>信息分类：</label>
                <div class="select">
                    <div class="fuji">
                        <span class="option">其他</span>
                        <span class="xl"><img src="/static/images/form/xl.png"/></span>
                        <ul class="list-group">
                            <a href='javascript:void(0);' class='list-group-item'>家政服务</a>
                            <a href='javascript:void(0);' class='list-group-item'>社区便民</a>
                            <a href='javascript:void(0);' class='list-group-item'>文教艺体</a>
                            <a href='javascript:void(0);' class='list-group-item'>商务服务</a>
                            <a href='javascript:void(0);' class='list-group-item'>安装维修</a>
                            <a href='javascript:void(0);' class='list-group-item'>劳务工务</a>
                            <a href='javascript:void(0);' class='list-group-item'>计算机网络</a>
                            <a href='javascript:void(0);' class='list-group-item'>其他</a>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label><span class="xing">*</span>反馈内容：</label>
                <textarea name="" id=""></textarea>
            </div>
            <div class="form-group">
                <label><span class="xing">*</span>您的邮箱：</label>
                <input type="email" class="input-normal"/>
            </div>
            <div class="form-group">
                <label><span class="xing">*</span>联系电话：</label>
                <input type="tel" class="input-normal"/>
            </div>
            <div class="form-group">
                <label><span class="xing"></span>上传图片：</label>
                <label for="xztp"><img src="/static/images/publish/xz.png" alt="" style="vertical-align: middle;"/>
                </label>
                <input type="file" style="display: none;"id="xztp"/>
                <span style="color: #999;font-size: 14px;margin-left: 20px;vertical-align: middle">最多可上传4张图片，每张图片不超过12M</span>
            </div>
            <div class="form-group">
                <label><span class="xing">*</span>输入验证码：</label>
                <input type="text" class="input input-short"/>
                <img src="/static/images/yzm.png" style="vertical-align: middle;"alt=""/>
                <a href="#" style="font-size: 12px;color: #2f2aff;margin-left: 10px;vertical-align: middle">看不清？换个验证码</a>
            </div>
            <div class="form-group">
                <label><span class="xing"></span></label>
                <input type="submit" class="btn btn-primary"/>
            </div>
        </form>
    </div>
</section>
<footer>
    <div class="main">
        <ul>
            <li><a href="#">法律声明 |</a></li>
            <li><a href="#">零工宝 |</a></li>
            <li><a href="<?php echo site_url('help'); ?>">零工小参 |</a></li>
            <li><a href="#">招贤纳士 |</a></li>
            <li><a href="#">关注微博</a></li>
        </ul>
        <p>Copyright © 2016 lg-zx.com Corporation, All Rights Reserved 鲁ICP备16012134号-1 站长统计</p>
    </div>
</footer>
</body>
<style>
    body form div.form-group{
            margin-bottom: 40px;
    }
</style>
<script src="/static/js/jquery.js"></script>
<script src="/static/js/select.js"></script>
</html>