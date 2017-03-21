<link rel="stylesheet" href="/static/css/tpls/reset.css"/>
<link rel="stylesheet" href="/static/css/lgb/all.success.css"/>
<section>
    <div class="reset3 reset">
    <?php 
        if($signcount['flag'] == 1){ ?>
        <div class="success">
            <p class="pink">恭喜您，签到成功！</p>
            <p>本月已累计签到 <span class="red"><?php echo $signcount['info']; ?></span>次</p>
            <p style="margin-top: 2rem;">进入 <a href="<?php echo site_url("User/center")?>" class="deepblue">零工宝</a></p>
        </div>
    <?php }else if($signcount['flag'] == -2){ ?>
        <div class="success">
            <p class="pink">对不起，签到失败，时间间隔不够24小时！</p>
            <p style="margin-top: 2rem;">点击返回 <a href="<?php echo site_url('Home/index')?>" class="deepblue">首页</a></p>
        </div>
     <?php }else{ ?>
         <div class="success">
                <p class="pink">对不起，签到失败！</p>
                <p style="margin-top: 2rem;">点击返回 <a href="<?php echo site_url('Home/index')?>" class="deepblue">首页</a></p>
          </div>
     <?php } ?>
    </div>
</section>
<style>
    html body footer{
        position: absolute;
        bottom: .02rem;
    }
</style>