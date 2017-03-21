/**
 * Created by Administrator on 2017/1/6.
 */
$(function(){
    $('.getcode').click(function(){
        $(this).css('display','none');
        $('#gotcode').css('display','inline-block');
        var num=5;
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
    });


});
