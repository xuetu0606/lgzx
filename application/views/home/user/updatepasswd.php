<link rel="stylesheet" href="/static/css/lgb/title.css"/>
<link rel="stylesheet" href="/static/css/lgb/alterBaseDate.css"/>
<style>
    html body footer{
        position: absolute;
        bottom: .02rem;
    }
</style> 
<section>
    <p class="title">
        <a href="<?php echo site_url('user/myinfo'); ?>"><</a>
        <span>密码修改</span>
    </p>

    <form action="<?php echo site_url('user/doupdatepasswd'); ?>" method='POST'>
        <div>
            <span class="name">用户名</span>
            <span><?php echo $username; ?></span>
        </div>
        <div>
            <span class="name">原密码</span>
            <input type="password" name='oldpasswd'/>
<!--             <a href="<?php echo site_url('user/reset'); ?>" class="blue">忘记密码？</a> -->
        </div>
        <div>
            <span class="name">新密码</span>
            <input type="password" name='newpasswd'/>
        </div>
        <div>
            <span class="name">确认密码</span>
            <input type="password" name='renewpasswd'/>
        </div>
        <div>
            <p><?php echo $error; ?></p>
        </div>
        <div class="button">
            <input type="submit" value="确认"/>
        </div>
    </form>
</section>
