<link rel="stylesheet" href="/static/css/tpls/reset.css"/>
<link rel="stylesheet" href="/static/css/lgb/all.success.css"/>
<section>
    <div class="reset3 reset">
        <div class="success">
            <p class="pink">恭喜您，首次签到成功！</p>
            <p>您用于注册的手机号为 <span class="hui"><?php echo $mobile; ?></span></p>
            <p>初始密码 <span class="hui">123456</span></p>
            <p>请及时登录 <a href="<?php echo site_url('User/index'); ?>" class="deepblue">修改密码</a></p>
        </div>
    </div>
</section>
<style>
    html body footer{
        position: absolute;
        bottom: .02rem;
    }
</style>
