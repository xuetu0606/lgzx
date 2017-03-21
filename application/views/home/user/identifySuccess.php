<link rel="stylesheet" href="/static/css/lgb/title.css"/>
<link rel="stylesheet" href="/static/css/lgb/identify.css"/>
<section>
    <p class="title">
        <a href="<?php echo site_url('user/center'); ?>"><</a>
        <span>实名认证</span>
    </p>
    <?php
    if($this->session->is_co){
        ?>
        <div class="success">
            <p class="p1">
                已认证 <span class="fa fa-check red"></span>
            </p>
            <p class="p2">
                <span>营业执照号</span>
                <span><?php echo $identifyinfo['idno']; ?></span>
            </p>
            <p class="p2">
                <span>公司名称</span>
                <span><?php echo $identifyinfo['coname']; ?></span>
            </p>
        </div>
        <?php
    }else{
        ?>
        <div class="success">
            <p class="p1">
                已认证 <span class="fa fa-check red"></span>
            </p>
            <p class="p2">
                <span>身份证号</span>
                <span><?php echo $identifyinfo['idno']; ?></span>
            </p>
            <p class="p2">
                <span>姓名</span>
                <span><?php echo $identifyinfo['realname']; ?></span>
            </p>
        </div>
        <?php
    }
    ?>
</section>