<link rel="stylesheet" href="/static/css/lgb/quickPublish.css"/>
<link rel="stylesheet" href="/static/css/lgb/title.css"/>
<link rel="stylesheet" href="/static/css/lgb/alterBaseDate.css"/>
<?php
echo $script;
?>
<section>
    <p class="title">
        <a href="javascript :history.back(-1);"><</a>
        <span>快速发布</span>
    </p>
    <?php echo form_open('user/quickpublish'); ?>
        <div id="area">
            <span class="name">城市</span>
            <select name="cityid" class="cityid"></select>
            <select name="districtid" class="districtid"></select>
        </div>
        <div>
            <span class="name">联系电话</span>
            <input type="text" id="mobile" name="mobile" value="<?php echo set_value('mobile'); ?>" placeholder="请输入手机号"/>
            <span id="mobileError" class="error"></span>
        </div>
        <div class="code">
            <span class="name">验证码</span>
            <input type="text" name="messagecode" required="required"/>
            <span class="getcode">获取验证码</span>
            <span id="gotcode">重新获取&#40;<span id="seconds" style="color: #fff;width: auto;margin: 0;">120</span>s&#41;</span>
        </div>
        <div>
            <span class="name">服务内容</span>
            <input type="text" name="title" value="<?php echo set_value('title'); ?>" placeholder="请输入区域和服务内容，20字以内" class="service"/>
        </div>
        <div>
            <p>
                <input type="checkbox" name="agree" checked="checked" onchange="changeBox()"/>
                <!--<img src="/static/images/tpls/register/register_04.gif" alt=""/>-->
                我已阅读并同意 <a href="<?php echo site_url("/user/useragreement")?>">《零工在线用户协议》</a>
            </p>
            <div class="check" onclick="changeDiv()"></div>
        </div>
        <div>
            <span class="error">
                <?php echo $codeError; ?>
                <?php echo validation_errors(); ?>
                <?php echo $error; ?>
            </span>
            <p>
                <input type="submit" name="register" id="submit" value="免费发布"/>
            </p>
        </div>
    </form>
</section>

<script src="/static/js/jquery.cxselect.min.js"></script>
<script>
    $('.getcode').click(function(){
        $.ajax({
            url: 'getcode/ksfb',
            type: "POST",
            dataType: 'json',
            data: {mobile:$("#mobile").val()},
            cache: false,
            error: function(){
                 //alert('检测失败，请重试');
            },
            success: function(data){
                $('#mobileError').html(data.msg);
                if(data.status=="success"){
                    $('.getcode').css('display','none');
                    $('#gotcode').css('display','inline-block');
                    var num=120;
                    function countDown(){
                        if(num>1){
                            num--;
                            $('#seconds').text(num);
                        }
                        else{
                            $('.getcode').css('display','inline-block');
                            $('#gotcode').css('display','none');
                            $('#seconds').text(120);
                            clearInterval(time);
                        }
                    };
                    var time=setInterval(countDown,1000);
                }else{
                    var sure=confirm( '快速发布只能发布一次,是否进入正常发布? ');
                    if (sure==true){location.href='/user/publish';}else{location.href=history.back();}
                }
            }
        });
    })

    $('#area').cxSelect({
        selects: ['cityid', 'districtid'],
        required: true,
        jsonValue: 'v',
        jsonName: 'n',
        jsonSub: 's',
        data: [
            <?php
            foreach ($area[0] as $k1=>$v1) {
                echo '{\'v\': \''.$k1.'\', \'n\': \''.$v1.'\', \'s\': [';
                echo '{\'v\':\'\',\'n\':\'全部\'},';
                foreach($area[1][$k1] as $k2=>$v2){

                    echo '{\'v\': \''.$k2.'\', \'n\': \''.$v2.'\'';

                    if(end($area[1][$k1])==$v2){
                        echo '}';
                    }else{
                        echo '},';
                    }
                }
                if(end($area[0])==$v1){
                    echo ']}';
                }else{
                    echo ']},';
                }
            }

            ?>

        ]
    });
</script>