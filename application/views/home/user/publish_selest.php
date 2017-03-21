<link rel="stylesheet" href="/static/css/publish.css"/>

<section>
    <div class="position">
        <span>青岛零工在线</span>
        <span> > </span>
        <span>发布信息</span>
    </div>
    <div class="main">
        <div class="middle">
            <div class="buzhou">
                <span class="step stress step1">选择分类</span>
                <span class="step b"> > </span>
                <span class="step step2">选择职业</span>
                <span class="step b"> > </span>
                <span class="step step3"> 填写信息 </span>
                <span class="step b"> > </span>
                <span class="step step4"> 完成发布 </span>
            </div>
        </div>
        <div class="classify">

            <ul>
                <?php
                //var_dump($hang);
                foreach ($hang as $k => $v){
                ?>
                <li><a href="/pub/selest/<?php echo $k;?>" <?php echo $k==$this->uri->segment(3, 0)?'class="active"':'';?>><?php echo $v;?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="type">
            <ul>
                <?php
                //var_dump($hang);
                foreach ($zhi as $k => $v){
                    ?>
                    <li><a href="/pub/index/<?php echo $this->uri->segment(3, 0).'/'.$k;?>"><?php echo $v;?></a></li>
                <?php } ?>
            </ul>

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
    $(function() {
        if(<?php echo $this->uri->segment(3, 0);?>){
            $('.step2').addClass('stress');
        }
        $('.type').show();
        var count1 = 0;
        var count2 = 0;
        $('.allcheck1').click(function () {
            count1++;
            if (count1 % 2 == 1)
                $(this).parent().parent().find('input[type=checkbox]').prop('checked', 'checked');
            else {
                $(this).parent().parent().find('input[type=checkbox]').prop('checked', false);
            }
        });
        $('.allcheck2').click(function () {
            count2++;
            if (count2%2==1)
                $(this).parent().parent().find('input[type=checkbox]').prop('checked', 'checked');
            else {
                $(this).parent().parent().find('input[type=checkbox]').prop('checked', false);
            }
        });
        $('.gb').click(function(){
            $(this).parent().remove();
        })
    });
</script>
</html>