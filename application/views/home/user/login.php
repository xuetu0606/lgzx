<link rel="stylesheet" href="/static/css/login.css"/>

<section>
    <div class="logo">
        <img src="/static/images/LOGObig.png" alt=""/>
        <p>一个专业的分类信息网站</p>
    </div>
    <div class="main">
        <div class="img">
            <img src="/static/images/login/zy.png" alt=""/>
        </div>
        <div class="login">
            <span class="type">微信登录</span>
            <span class="type">账号登录</span>
            <div class="wxdl">
                <img src="/static/images/login/ewm.png" alt=""/>
                <p>扫描微信二维码登录</p>
            </div>
            <div class="zhdl">
                <?php echo form_open('user/login','name="login"'); ?>
                    <p>用户名/手机号</p>
                    <input type="text" name="username" value="<?php echo get_cookie('username')?get_cookie('username'):set_value('username'); ?>"/>
                    <p>密码</p>
                    <input type="password" name="passwd" value="<?php echo get_cookie('passwd')?get_cookie('passwd'):set_value('passwd'); ?>"/>
                <?php if(!empty($_POST)):?>
                    <div class="error">
                        <div class="list">
                            <img width="16" height="16" src="/static/images/tpls/error.png" alt="错误"/>
                            <?php echo validation_errors(); ?>
                            <?php echo (empty($error_string))?'':'<span>'.$error_string.'</span>'; ?>
                        </div>

                    </div>
                <?php endif;?>

                <input type="submit" value="登录"/>
                    <input type="checkbox"/><span class="zddl">下次自动登录</span>
                </form>
                <nav>
                    <a href="/user/reset">忘记密码</a>
                    <span>|</span>
                    <a href="#">登录注册</a>
                </nav>
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
        <p>Copyright © 2016 lg-zx.com Corporation, All Rights Reserved 鲁ICP备16012134号-1 </p>
    </div>
</footer>

</body>
<script src="/static/js/jquery.js"></script>
<script src="/static/js/head-foot.js"></script>
<script src="/static/js/login.js"></script>
</html>