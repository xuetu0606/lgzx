/**
 * Created by Administrator on 2017/3/1.
 */
$(function(){
    //点击获取
    $('.getyzm').click(function(){
        $(this).addClass('djh').removeClass('djq');
        $(this).text("重新获取（59s）");
        var count=59;
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
    });

});
