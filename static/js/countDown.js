$(function(){
    var count=5;
    var time=setInterval(function(){
        if(count==1){
            clearInterval(time);
                window.location.href="./center";
        }
        else{
            count--;
            $('#time').text(count);
        }
    },1000);

})/**
 * Created by Administrator on 2016/12/29.
 */
