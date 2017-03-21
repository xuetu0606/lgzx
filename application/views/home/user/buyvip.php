<link rel="stylesheet" href="/static/css/lgb/buyVIP.css">
<link rel="stylesheet" href="/static/css/lgb/title.css"/>

<section>
    <p class="title2">
        <a href="/user"><</a>
        <span><?php echo $title; ?></span>
    </p>
    <div class="main">
        <div class="type">
            <span>注册类型：<?php echo $is_co?'公司':'个人'; ?></span>
            <span class="right">
                零工币余额：<span id="credit1" class="red"><?php echo $user['credit1']; ?></span>
                <a href="recharge" class="blue">充值></a>
            </span>
        </div>
        <?php echo form_open('user/buyvip','name="buyvip"'); ?>
        <input type="hidden" name="vipid" id="vipid">
        <input type="hidden" name="credit" id="credit">
            <div class="VIP">
        <?php
        if($is_co) {
            ?>

                <p><span class="jin">VIP</span>会员</p>
                <div class="demo">
                    <span class="package" data-id="4">月度 <span class="blue">30</span>零工币</span>
                    <span class="money">60元</span>
                    <span class="youhui">优惠</span>
                    <p class="hui txt">购买日起1个月内，免费发布、刷新信息</p>
                </div>
                <div class="demo">
                    <span class="package" data-id="5">季度 <span class="blue">80</span>零工币</span>
                    <span class="money">240元</span>
                    <span class="youhui">特惠</span>
                    <p class="hui txt">购买日起3个月内，免费发布、刷新信息</p>
                </div>
                <div class="demo">
                    <span class="package" data-id="6">年度 <span class="blue">300</span>零工币</span>
                    <span class="money">1200元</span>
                    <span class="youhui">超值</span>
                    <p class="hui txt">购买日起1年内，免费发布、刷新信息</p>
                </div>

            <?php
        }else {
            ?>

                <p><span class="jin">VIP</span>会员</p>
                <div class="demo">
                    <span class="package" data-id="1">月度 <span class="blue">15</span>零工币</span>
                    <span class="money">30元</span>
                    <span class="youhui">优惠</span>
                    <p class="hui txt">购买日起1个月内，免费发布、刷新信息</p>
                </div>
                <div class="demo">
                    <span class="package" data-id="2">季度 <span class="blue">30</span>零工币</span>
                    <span class="money">90元</span>
                    <span class="youhui">特惠</span>
                    <p class="hui txt">购买日起3个月内，免费发布、刷新信息</p>
                </div>
                <div class="demo">
                    <span class="package" data-id="3">年度 <span class="blue">100</span>零工币</span>
                    <span class="money">400元</span>
                    <span class="youhui">超值</span>
                    <p class="hui txt">购买日起1年内，免费发布、刷新信息</p>
                </div>

            <?php
        }
        ?>
                <div class="error" style=" color: red"><?php echo $error; ?></div>
                <div class="demo">
                    <input type="submit" value="购买"/>
                </div>
            </div>
        </form>
    </div>
</section>
<script src="/static/js/jquery.js"></script>
<script>
    $(function(){
        $('.package').click(function(){

            $(this).parent().children('.package').addClass('active');
            $('#vipid').val($(this).attr('data-id'));
            $('#credit').val($(this).children('span').html());
            $(this).parent().siblings().children('.package').removeClass('active');
        })
    })

</script>