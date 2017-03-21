<link rel="stylesheet" href="/static/css/tpls/reset.css">

<section>
    <div class="reset1 reset">
        <div class="register">
            <p><a href="#" class="fa fa-angle-left" onClick="javascript :history.back(-1);"></a><span><?php echo $title; ?></span></p>
        </div>
        <!--<?php echo form_open('user/reset','name="reset1"'); ?>-->
        <form action="http://<?php echo $localhost; ?>/user/reset" name="reset1"method="post">
        <form action="#" name="reset1">
            <div class="input">
                <input type="text" name="mobile" id="mobile" placeholder="请输入手机号" value="<?php echo set_value('mobile'); ?>" class="tel"/>
                <input type="text" name="username" value="<?php echo set_value('username'); ?>" placeholder="用户名" id='username'/>
                <input type="text" name="messagecode" value="<?php echo set_value('messagecode'); ?>" placeholder="请输入验证码"/>
                <img src="/static/images/tpls/reset/reset1_04.gif" alt="清除" style="display: none" class="clearimg"/>
                <img src="/static/images/tpls/reset/reset1_08.gif" alt="获取验证码" style="display:block" class="getcode"/>
                <span id="gotcode">重新获取&#40;<span id="seconds" style="color: #fff;">120</span>s&#41;</span>
                
                <div class="error" <?php if(!empty($_POST)){?>style="display: block;"<?php }else{ ?>style="display: none;"<?php } ?>>
                    <div class="list">
                        <img src="/static/images/tpls/error.png" alt="错误"/>
                        <span id="mobileError"><?php echo validation_errors(); ?><?php echo $codeError; ?></span>
                    </div>
                </div>
                
            </div>
            <div class="login">
                <input type="submit" value="下一步"/>
            </div>
        </form>
    </div>
</section>
<style>
    html body footer{
        /*min-height: 100%;*/
        position: absolute;
        bottom: .02rem;

    }
    section div.input #gotcode {
        display: none;
        width: 8rem;
        height: 1.5rem;
        line-height: 1.5rem;
        border: solid 1px #ff3c5a;
        background-color: #ff3c5a;
        color: #fff;
        text-align: center;
        border-radius: 4px;
        font-size: 1rem;

        float: right;
        margin-right: 1.8rem;
        margin-top: -2.5rem;
    }
    .getcode{
        position: absolute;
        right: 0.5em;
        z-index: 999999;
    }
</style>
<script src="/static/js/jquery.js"></script>
<script>
    $('#mobile').blur(function(){
        ajaxblur();
    });
    function ajaxblur(){
        $.ajax({
            url:'getUsername',
            type:'POST',
            //dataType:'json',
            data: {mobile:$("#mobile").val()},
            cache: false,
            error: function(){
                alert('获取用户名失败，请重试！');
            },
            success:function(data){
                //alert($("#mobile").val());
                var dataa = jQuery.parseJSON( data );
                $('#username').val(dataa.username);
            }
        });
    }
    $('.getcode').click(function(){
        if($('#username').val().length==0 ){
             ajaxblur();
        }
    });
    $('.getcode').click(function(){

        if($("#mobile").val().length==0){
            $('.error').show();
            $('#mobileError').html('手机号码不能为空');
            return false;
        }
        var str = $('#username').val();
        if(str == '' ){
            $('.error').show();
            $('#mobileError').html('您填写的手机号码无法匹配出用户名');
            return false;
        }
        $.ajax({
            url: 'getcode/res',
            type: "POST",
            dataType: 'json',
            data: {mobile:$("#mobile").val(),username:$('#username').val()},
            cache: false,
            error: function(){
                alert('检测失败，请重试');
            },
            success: function(data){
                if(data.status=="success"){
                    $('.getcode').css('display','none');
                    // $('.error').css('display','block');
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
                }else if(data.status=="failed"){
                     $('.error').show();
                    $('#mobileError').html(data.msg);
                }
            }
        });
    });

    $('.tel').bind('input propertychange',function(){
        if($(this).val()!=''){
            $('.clearimg').css('display','block');
        }
        else{
            $('.clearimg').css('display','none');
        }
        $('.clearimg').click(function(){
            $('.tel').val('').focus();
            $('.clearimg').css('display','none');
        });

    });

</script>