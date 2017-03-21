<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>零工币充值</title>
    <link rel="stylesheet" href="/static/css/common.css"/>
    <link rel="stylesheet" href="/static/css/head-foot.css"/>
    <link rel="stylesheet" href="/static/css/workInfor.css"/>
    <link rel="stylesheet" href="/static/css/form.css"/>
    <link rel="stylesheet" href="/static/css/xiaoye.css"/>
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
                <li><a href="#">注册</a></li>
                <li><a href="#">登录</a></li>
                <li class="lgbxl"><a href="#">零工宝</a><img src="/static/images/xiala.png" alt=""/>

                </li>
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
    </div>
</div>
<section>
    <div class="position">
        <span>青岛零工在线</span>
        <span> > </span>
        <span>零工币充值</span>
    </div>
    <div class="lgbcz-main">
        <?php echo form_open('pay','style="margin: 3rem 0"'); ?>
            <div class="form-group">
                <label><span>充值金额 </span></label>
                <input type="text" class="input input-short" name="fee"/> 元
                <span class="hong"> （1元=1个零工币）</span>
            </div>
            <div class="form-group">
                <label><span>支付平台</span></label>
                <div class="select">
                    <div class="fuji">
                        <span class="option">微信支付</span>
                        <span class="xl"><img src="/static/images/form/xl.png" alt="" class="timejt"/></span>
                        <ul class="list-group">
                            <a href='javascript:void(0);' class='list-group-item'>微信支付</a>
                            <a href='javascript:void(0);' class='list-group-item'>支付宝支付</a>
                        </ul>
                    </div>
                </div>
            </div>
            <div><?php echo validation_errors()?validation_errors():$payError;?></div>
            <div class="form-group mar">
                <input type="submit" class="btn btn-primary" value="购买"/>
            </div>
        </form>
        <div class="success">
            <img src="/static/images/lgb/dih.png" alt=""/>
            <span>充值成功！</span>
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
<script>
    $(function(){
        $('span.xl').click(function(){
            var ul=$(this).siblings('ul.list-group');
            if(ul.css('display')=='none'){
                ul.show();
            }else{
                ul.hide();
            }
        });
        $('.list-group-item').click(function(){
            $(this).parent().parent().children('.option').text($(this).text());
            $(this).parent().hide();
        });
        $(document).bind("click", function (e) {
            var target = $(e.target);
            if(target.closest(".fuji").length == 0){
                //进入if则表明点击的不是#province,#proDiv元素中的一个
                $("ul.list-group").hide();
            }
            e.stopPropagation();
        });
    });
</script>
</html>