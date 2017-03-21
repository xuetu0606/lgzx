/**
 * Created by Administrator on 2017/1/6.
 */
function changeDiv(){
    var box=document.getElementsByName('agree')[0];
    var div=document.getElementsByClassName('check')[0];
    box.checked=!box.checked;
    box.style.visibility="visible";
    div.style.display="none";
    document.getElementById('submit').disabled=true;
}
function changeBox(){
    var box=document.getElementsByName('agree')[0];
    var div=document.getElementsByClassName('check')[0];
    box.style.visibility="hidden";
    div.style.display="inline-block";
    document.getElementById('submit').disabled=false;
}
$(function(){
   $('.check-div').click(function(){
       $(this).parent().find('.check-box').css('visibility','visible');
       $(this).parent().find('.check-box').prop('checked',false);
       $(this).css('display','none');
   });
    $('.check-box').click(function(){
            $(this).parent().children('.check-div').css('display','inline-block');
           $(this).css('visibility','hidden');
    })
});