/**
 * Created by Administrator on 2017/1/6.
 */
$(function(){
   $('.summaryNum').bind('input propertychange',function() {
       var val=$(this).val();
       if(val.length>=200){
           val=val.substring(0,200);
           $(this).val(val);
       }
       var num=200-val.length;
       $(this).parent().find('.currentNum').text(num);
       //$('.currentNum').text(num);

   });
    $('.summaryNum1').bind('input propertychange',function() {
        var val=$(this).val();
        if(val.length>=200){
            val=val.substring(0,200);
            $(this).val(val);
        }
        var num=200-val.length;
        $(this).parent().find('.currentNum').text(num);

    });
    $('.summaryNum2').bind('input propertychange',function() {
        var val=$(this).val();
        if(val.length>=200){
            val=val.substring(0,200);
            $(this).val(val);
        }
        var num=200-val.length;
        $(this).parent().find('.currentNum').text(num);


    })
});