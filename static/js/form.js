
$(function(){
    $('#username').blur(function(){
        var Reg=/^[_a-zA-Z0-9\u4E00-\u9FA5]{4,20}$/;
        var username=$(this).val();
        var check=Reg.test(username);
        if(check==false){
            $('.errorname').css('display','block');
            $('.duihaoname').css('display','none');
            $('.noticename').css('display','none');
        }else{
            $('.duihaoname').css('display','block');
            $('.errorname').css('display','none');
            $('.noticename').css('display','none');
        }
    });
    $('#password').blur(function(){
        var Reg=/^[^\s\u4e00-\u9fa5]{8,20}$/;
        var pass=$(this).val();
        var check=Reg.test(pass);
        if(check==false){
            $('.errorpass').css('display','block');
            $('.duihaopass').css('display','none');
            $('.noticepass').css('display','none');
        }else{
            $('.duihaopass').css('display','block');
            $('.errorpass').css('display','none');
            $('.noticepass').css('display','none');
        }
        if(pass!==repass){
            $('.errorrepass').css('display','block');
            $('.duihaorepass').css('display','none');
            $('.noticerepass').css('display','none');
        }else{
            $('.duihaorepass').css('display','block');
            $('.errorrepass').css('display','none');
            $('.noticerepass').css('display','none');
        }
    });
    $('#repass').blur(function(){
        var pass=$('#password').val();
        var repass=$(this).val();
        if(pass!==repass){
            $('.errorrepass').css('display','block');
            $('.duihaorepass').css('display','none');
            $('.noticerepass').css('display','none');
        }else{
            $('.duihaorepass').css('display','block');
            $('.errorrepass').css('display','none');
            $('.noticerepass').css('display','none');
        }
    });
    $('#tel').blur(function(){
        var Reg=/^1[3|4|5|8][0-9]\d{8}$/;
        var pass=$(this).val();
        var check=Reg.test(pass);
        if(check==false){
            $('.errortel').css('display','block');
            $('.getyzm').css('display','none');
        }else{
            $('.errortel').css('display','none');
            $('.getyzm').css('display','block');
        }
    });
    //------CheckBox选中才能点击submit----------------------------
    {
        if($('#agree').prop('checked')==false){
           $('#submit').prop('disabled',"true");
        }
    }
$('#agree').change(function(){
    if($(this).prop('checked')==false){
        $('#submit').prop('disabled',"true");
    }else{
        $('#submit').prop('disabled',false);

    }
});


});
//----表单验证是否能提交-----------
function confirm(){
  if( $('.duihaoname').css('display')=='block'&&
      $('.duihaopass').css('display')=='block'&&
      $('.duihaorepass').css('display')=='block'

  )
  {
      return true;
  }
    else
    return false;
}