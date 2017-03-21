<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://apps.bdimg.com/libs/html5shiv/3.7/html5shiv.min.js"></script>
    <script src="http://apps.bdimg.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <link rel="stylesheet" href="/static/node_modules/bootstrap/dist/css/bootstrap.css"/>
    <link rel="stylesheet" href="/static/css/common.css"/>
    <link rel="stylesheet" href="/static/css/head-foot.css"/>
    <link rel="stylesheet" href="/static/css/register.css"/>
</head>
<body>
<header>
    <div class="main">
        <div class="city">
            <span class="stress">青岛</span>
            <a href="切换城市.html">[切换城市]</a>
        </div>
        <div class="fr">
            <ul>
                <li><a href="#">注册</a></li>
                <li><a href="#">登录</a></li>
                <li class="lgbxl"><a href="#">零工宝</a><img src="/static/images/xiala.png" alt=""/></li>
                <li class="stress wxb">微信版</li>
                <li><a href="#" class="stress">手机版</a></li>
                <li><a href="#">帮助</a></li>
            </ul>
            <div class="lgb">
                <a href="#">零工宝<img src="/static/images/xiala.png" alt="" /></a>
                <a href="#" class="lgba">我的发布</a>
                <a href="#" class="lgba">我的收藏</a>
                <a href="#" class="lgba">我的资料</a>
            </div>
            <div class="wx">
                <img src="/static/images/head-foot/weixin.png" alt=""/>
            </div>
        </div>
    </div>

</header>
<section>
    <div class="logo">
        <img src="/static/images/LOGObig.png" alt=""/>
        <p>一个专业的分类信息网站</p>
    </div>
    <div class="form">
        <form action="/user/reg" method="post" class="form-horizontal" onsubmit="return confirm();">
            <div class="form-group" >
                <label class="control-label col-sm-4">注册地</label>
                <div class="col-sm-2" style="position: relative">
                    <!--<select name="province"  class=" form-control" id="province">-->
                    <!--</select>-->
                    <div class="form-control" id="proDiv">
                        <span class="xl"><img src="/static/images/form/xl.png" alt=""/></span>
                        <ul class="list-group" id="province">
                        </ul>
                    </div>

                </div>
                <div class="col-sm-2" style="position: relative">
                    <span class="xl"><img src="/static/images/form/xl.png" alt=""/></span>
                    <!--<select name="city" class=" form-control" id="city">-->
                    <!--</select>-->
                    <div class="form-control" id="cityDiv">
                        <span class="text"></span>
                        <span class="xl"><img src="/static/images/form/xl.png" alt=""/></span>
                        <ul class="list-group" id="city">
                        </ul>
                    </div>

                </div>
                <input type="hidden" name="province" id="pro_id" value="45052">
                <input type="hidden" name="city" id="city_id" value="1">
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">注册类型</label>
                <div class="col-sm-4">
                    <div class="radio-inline">
                        <label style="font-weight: normal;">
                            <input type="radio" name="type" id="companyCheck" value="1" checked="checked"/>
                            公司
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label style="font-weight: normal;">
                            <input type="radio" name="type" id="personCheck" value="0"/>
                            个人
                        </label>
                    </div>
                    <input type="hidden" name="is_co" id="is_co" value="<?php echo set_value('is_co')?set_value('is_co'):'0'; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label text-right">用户名</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="username" id="username" required="required" value="<?php echo set_value('username'); ?>"/>
                </div>
                <div class="col-sm-4">
                    <p class="form-control-static text-danger errorname error">！用户名不正确</p>
                    <p class="form-control-static duihaoname duihao"><img src="/static/images/form/dh.png" alt=""/></p>
                    <p class="form-control-static text-primary noticename notice">4-20个字符，字母/数字/下划线和汉字组成</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">密码</label>
                <div class="col-sm-4">
                    <input type="password" name="password" id="password" class="form-control" required="required"/>
                </div>
                <div class="col-sm-4">
                    <p class="form-control-static text-danger errorpass error">！密码格式不正确</p>
                    <p class="form-control-static duihaopass duihao"><img src="/static/images/form/dh.png" alt=""/></p>
                    <p class="form-control-static text-primary noticepass notice">8-20个字符，不包含空格</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">确认密码</label>
                <div class="col-sm-4">
                    <input type="password" name="passconf" class="form-control" id="repass" required="required"/>
                </div>
                <div class="col-sm-4">
                    <p class="form-control-static text-primary notice noticerepass">请再次输入密码</p>
                    <p class="form-control-static text-danger error errorrepass">！两次密码输入不一致</p>
                    <p class="form-control-static text-danger duihao duihaorepass"><img src="/static/images/form/dh.png" alt=""/></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">推介人</label>
                <div class="col-sm-4">
                    <input type="text" name="referer" class="form-control" placeholder="请输入推介人的工号，没有可不填"  value="<?php echo set_value('referer'); ?>"/>
                </div>
                <div class="col-sm-4">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">手机号</label>
                <div class="col-sm-4">
                    <input type="tel" name="mobile" class="form-control" placeholder="请输入手机号码" required="required" id="tel" value="<?php echo set_value('mobile'); ?>"/>
                </div>
                <div class="col-sm-2">
                    <p class="form-control-static text-danger errortel error">！请输入正确手机号</p>
                    <p class="form-control-static text-primary getyzm djq">点击获取验证码</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">验证码</label>
                <div class="col-sm-4">
                    <input type="tel" name="messagecode" class="form-control" placeholder="请输入手机验证码" required="required"/>
                </div>
                <div class="col-sm-2">
                    <p class="form-control-static text-danger erroryzm" id="mobileError"><?php echo $codeError; ?></p>
                    <p class="form-control-static  duihao duihaoyzm"><img src="/static/images/form/dh.png" alt=""/></p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div class="checkbox-inline">
                        <label class="control-label" style="font-weight: normal">
                            <input type="checkbox" id="agree"/>我已阅读并同意 <a href="#" class="xy"> 《零工在线用户协议》</a>
                        </label>
                    </div>
                </div>
            </div>
            <div style="text-align: center;"><?php echo validation_errors(); ?></div>
            <div class="form-group">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <input type="submit" value="注册" class=" btnprimary" id="submit"/>
                </div>
            </div>
        </form>
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
<script src="/static/js/form.js"></script>
<!--<script src="/static/js/getyzm.js"></script>-->
<script>
    /**
     * Created by Administrator on 2017/3/1.
     */
    $(function(){
        //点击获取
        $('.getyzm').click(function(){
            $(this).addClass('djh').removeClass('djq');
            //$(this).text("重新获取（59s）");
            var count=60;
            var time=setInterval(countdown,1000);
            function countdown(){
                if(count>1){
                    count--;
                    $('.getyzm').text("重新获取（"+count+"s）");
                }else{
                    clearInterval(time);
                    $('.getyzm').text("点击获取验证码");
                    $('.getyzm').removeClass('djh').addClass('djq');
                }
            }
            $.ajax({
                url: '<?php echo base_url();?>getcode/index/reg',
                type: "POST",
                dataType: 'json',
                data: {mobile:$("#tel").val()},
                cache: false,
                error: function(){
                    alert('检测失败，请重试');
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
                    }
                }
            });

        });

    });

    if($('#is_co').val()=='1'){
        $("#companyCheck").attr("checked","checked");
    }else{
        $("#personCheck").attr("checked","checked");
    }
</script>
<script><?php
echo $js;
    ?></script>
</html>