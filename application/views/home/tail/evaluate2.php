<link rel="stylesheet" href="/static/css/tpls/reset.css"/>
<link rel="stylesheet" href="/static/css/tpls/register.css"/>
<section>
    <p class="userRegister" style="color: #000;">用户评价</p>
    <div class="reset3 reset">
        <div class="success" style="font-weight: bold">
            <img src="/static/images/tpls/success.png" alt=""/>
            <p class="pink"><span class="username" style="color: #0036ff;"></span> 恭喜您，评价成功！</p>
            <p style="color: #333;">即将为您跳转到零工宝页面（<span id="time">5</span>s）</p>
        </div>
    </div>
</section>
<style>
    html body footer{
        position: absolute;
        bottom: .02rem;
    }
</style>
<script src="/static/js/jquery.js"></script>
<script>
$(function(){
    var count=5;
    var time=setInterval(function(){
        if(count==1){
            clearInterval(time);
                window.location.href="<?php echo site_url('/User/center'); ?>";
        }
        else{
            count--;
            $('#time').text(count);
        }
    },1000);

})
</script>

