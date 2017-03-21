<link rel="stylesheet" href="/static/css/lgb/title.css"/> 
<link rel="stylesheet" href="/static/css/lgb/evalute.css"/>
<section>
    <p class="title3">
        <a href="/"><</a>
        <span>我要评价</span>
    </p>
    <div class="main">
        <form action='<?php echo site_url('Home/doevaluate'); ?>' method='POST'>
        <div class="gonghao">
            <span>被评价零工工号</span>
            <input type="text" placeholder="请输入零工工号" name='number'/>
        </div>
        <div class="face">
            <div class="grade">
                <img src="/static/images/tpls/lgb/evaluate/bumanyi.png" alt="" class="xiaolian"/>
                <img src="/static/images/tpls/lgb/evaluate/bumanyired.png" alt="" class="xiaolianred"/>
                <span class="txt">不满意</span>
            </div>
            <div class="grade">
                <img src="/static/images/tpls/lgb/evaluate/yiban.png" alt="" class="xiaolian"/>
                <img src="/static/images/tpls/lgb/evaluate/yibanred.png" alt="" class="xiaolianred"/>
                <span class="txt">一般</span>
            </div>
            <div class="grade">
                <img src="/static/images/tpls/lgb/evaluate/manyi.png" alt="" class="xiaolian"/>
                <img src="/static/images/tpls/lgb/evaluate/manyired.png" alt="" class="xiaolianred"/>
                <span class="txt">满意</span>
            </div>
        </div>
        <div class="xingxing">
            <div class="star">
                <span>专业技能</span>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <span class="txt">一般</span>
                <input type="hidden" value="0" name='skill' style="width: 2rem;" class="score"/>
            </div>
            <div class="star">
                <span>服务及时</span>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <span class="txt">一般</span>
                <input type="hidden" value="0" name='timely' style="width: 2rem;" class="score"/>

            </div>
            <div class="star">
                <span>服务态度</span>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <span class="txt">一般</span>
                <input type="hidden" value="0" name='manner' style="width: 2rem;" class="score"/>

            </div>
            <div class="star">
                <span>现场标准</span>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <img src="/static/images/tpls/lgb/evaluate/xingxing.png" alt="" class="xing"/>
                <span class="txt">一般</span>
                <input type="hidden" value="0" name='standard' style="width: 2rem;" class="score"/>
            </div>
        </div>
        <div class="content">
            <textarea  placeholder="请输入内容" name='textarea'></textarea>
        </div>
        <input type="submit" value="提交" id="submit"/>
        <!-- <span style='color:red;'><?php echo $error; ?></span> -->
        </form>

    </div>

</section>
<script src="/static/js/evaluate.js"></script>
<script type="text/javascript">
    var value = '<?php echo $error; ?>';    
    if(value){
        alert(value);
    }
    $.ajax({
        url: '',
        type: "POST",
 //       dataType: 'json',
        data: {id:$("#id").val()},
        cache: false,
        error: function(){
           // alert('获取失败');
        },
        success: function(){
           // alert('获取成功');
        } 
    });
</script>
