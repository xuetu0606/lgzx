<link rel="stylesheet" href="/static/css/friendly-link/zlg.details.css"/>
<?php //var_dump($details);var_dump($pv);var_dump($isvip); ?>
<section>
    <div class="img">
    <?php if($details['img']){ ?>
        <img src="/upload/<?php echo $citycode; ?>/grtx/<?php echo $details['img']; ?>" alt="">
    <?php }else{ ?>
        <img src="/static/images/section/contractwhite.png" alt="" />
    <?php } ?>

    </div>
    <div class="main">
    <h3>
        <?php if(!empty($isvip)){ ?>
        <span class="vip" style="color:yellow">VIP</span>
        <?php }else{ ?>
        <span class="vip hui">VIP</span>
        <?php } ?>
        <?php echo $details['title']; ?>
    </h3>
        
        <span class="salary"><?php echo $details['pay'];echo $details['unit']; ?></span>
        <span class="views"><span><?php echo $details['addtime']; ?></span> <span></span><span class="line"></span> <span><?php echo $details['pv']; ?></span><span>次浏览</span></span>
        <p class="title">基本信息</p>
        <div class="list">
            <p>
                <span class="name">工种</span>
                <span class="answer"><?php echo $details['job_type']; ?></span>
            </p><p>
                <span class="name">工资</span>
                <span class="answer"><?php echo $details['pay'];echo $details['unit']; ?></span>
            </p><p>
                <span class="name">薪资结算</span>
                <span class="answer"><?php echo $details['circle']; ?></span>
            </p><p>
                <span class="name">招聘人数</span>
                <span class="answer"><?php echo $details['sum']; ?>人</span>
            </p><p>
                <span class="name">工作时间</span>
                <span class="answer"><?php echo $details['worktime']; ?></span>
            </p><p>
                <span class="name">工作区域</span>
                <span class="answer"><?php echo $details['cityname']; echo $details['distname']; ?></span>
            </p><p>
                <span class="name">联系地址</span>
                <span class="answer"><?php echo $details['address']; ?></span>
            </p><p>
                <span class="name">公司名称</span>
                <span class="answer"><?php echo $details['coname']; ?></span>
            <?php if($details['is_real'] == 1){ ?>
            <img src="/static/images/section/duihao.png" alt="" class="duihao"/>
            <span class="hui" style="font-size: .9rem">已认证</span>
            <?php } ?>
            </p>
            <p>
                <span class="name">公司网址</span>
                <span class="answer"><?php echo $details['weburl']; ?></span>
 
            </p>
            <p>
                <span class="name">公司简介</span>
                <span class="answer"><?php echo $details['info']; ?></span>
 
            </p>
            <p>
                <span class="name">联系人</span>
                <span class="answer"><?php echo $details['contacts']; ?></span>
 
            </p>
            <p>
                <span class="name">联系电话</span>
                <span class="answer"><?php echo $details['mobile']; ?></span>
                <a href="tel:<?php echo $details['mobile']; ?>" >　　　<img src="/static/images/section/3-list/tel.png" alt="" class="tel"/></a>
            </p>
            <p>
                <span class="name">工作内容</span>
                <span class="answer gznr"><?php echo $details['info']; ?></span>
            </p>
        </div>
    </div>
</section>
