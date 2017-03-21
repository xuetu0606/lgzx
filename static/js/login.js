/**
 * Created by Administrator on 2017/3/3.
 */
$(function(){
   $('span.type').click(function(){
       $(this).css('background-color','#c6c6c6');
       $(this).siblings('span.type').css('background-color','#ffffff');
       if($(this).index()==0){
           $('.wxdl').show();
           $('.zhdl').hide();
       }
       else{
           $('.wxdl').hide();
           $('.zhdl').show();
       }
   })
});