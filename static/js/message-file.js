/**
 * Created by Administrator on 2017/1/12.
 */
$(function(){
    $('.notice-top span').click(function(){
        $(this).addClass('active').removeClass('static');
        $(this).siblings().removeClass('active').addClass('static');
    });
    $('#check-all').click(function(){
        var flag=true;
        for(var i=0;i<$('.check-box').length;i++){
            //alert($('.check-box').eq(i).prop('checked'));
            if($('.check-box').eq(i).prop('checked')==false){
                flag=false;
                break;
            }
        }//没有被全选，flag=false
        if(flag){
            $('.check-div').click();
        }
        else{
            $('.check-box').prop('checked',true).css('visiblity','hidden');
            $('.check-div').css('display','inline-block');
        }
    });
})