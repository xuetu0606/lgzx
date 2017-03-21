<link rel="stylesheet" href="/static/css/lgb/alterBaseDate.css"/>
<link rel="stylesheet" href="/static/css/lgb/quickPublish.css"/>
<!-- <script src="/static/js/getcode.js"></script> -->
<style>
    body section form div {
        left: 10%;
    }
     html body footer{
        position: absolute;
        bottom: .02rem;
    }
</style>
<section>
    <form action="<?php echo site_url('Home/signs'); ?>" method='POST'>
        <div>
            <span class="name">手机号</span>
            <input id="mobile" type="tel" placeholder="请输入手机号" name='phone' required="required"/>
        </div>
        <div class="code">
            <span class="name">验证码</span>
            <input type="text" name='code' />
            <span class="getcode">获取验证码</span>
            <span id="gotcode" style="display: none;">重新获取(<span id="seconds" style="color: #fff;width: auto;margin: 0;">120</span>s)</span>
        </div>
        <div>
        <p id="errorinfo" style='color:red'><span style='color:red'><?php echo $errors; ?></span></p>
            <p>
                <input type="hidden" name='codenum' id='codenum' value=''>

                <input type="submit" name="register" id="submit" value="签到"/>
            </p>
        </div>
    </form>
</section>
<script type='text/javascript'>
        $('.getcode').click(function(){
        $.ajax({
            url: 'ajaxcheckmobile',
            type: "POST",
            dataType: 'json',
            data: {mobile:$("#mobile").val()},
            cache: false,
            error: function(){
                // alert('检测失败，请重试');
            },
            success: function(data){ 
                var code = data.msg;
                var status = data.status;
                // alert(data);
                if(status=='success'){//手机号码有效且发送短信成功
                    $("#errorinfo").html('');
                    $("#submit").removeAttr("disabled");
                    $('.getcode').css('display','none');
                    $('#gotcode').css('display','inline-block');
                    //$('#submit').attr('type','submit');
                    var num=120;
                    function countDown(){
                        if(num>1){
                            num--;
                            $('#seconds').text(num);
                        }else{
                            $('.getcode').css('display','inline-block');
                            $('#gotcode').css('display','none');
                            $('#seconds').text(120);
                            clearInterval(time);
                        }
                    };
                    var time=setInterval(countDown,1000);

                   // $("#errorinfo").html('您的手机号码无效，请检查后重新填写!')
                }else if(status=='fails'){//正在发送中
                    $("#errorinfo").html(code);
                    $("#submit").removeAttr("disabled");
                }else{//手机号码无效或发送失败
                    $("#errorinfo").html(code);
                    $("#submit").attr("disabled","disabled");
                }

            }
        });
    })
</script>
