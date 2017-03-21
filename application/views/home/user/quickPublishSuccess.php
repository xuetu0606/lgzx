<link rel="stylesheet" href="/static/css/lgb/all.success.css"/>
<link rel="stylesheet" href="/static/css/tpls/reset.css"/>
<section>
    <div class="reset3 reset">
        <div class="success">
            <img src="/static/images/tpls/success.png" alt=""/>
            <p class="pink"><span class="deepblue"><?php echo $user['username'];?>&nbsp;</span>恭喜您，发布成功！</p>
            <p>您的注册工号是<span class="deepblue"><?php echo $user['no'];?>&nbsp;</span>，初始密码 <span class="deepblue">123456789</span></p>
            <p>请及时登录零工宝修改密码</p>
            <p style="margin-top: 2rem;">零工在线送您 <span class="red">10</span>个工分，您可以免费使用更多功能</p>
        </div>
    </div>
</section>
<style>
    html body footer{
        position: absolute;
        bottom: .02rem;
    }
</style>