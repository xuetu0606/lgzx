$(function(){
    $('.introduce .line span').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
        var index=$(this).index();
        if(index==0) {
            $('.fwjs').show();
            $('.gsxq').hide();
            $('.fwpj').hide();
        }
        else if(index==1) {
            $('.fwjs').hide();
            $('.gsxq').show();
            $('.fwpj').hide();
        }
        else if(index==2){
            $('.fwjs').hide();
            $('.gsxq').hide();
            $('.fwpj').show();
        }
    });
    $('.remark').focus(function(){
        $('.warning').hide();
    });
$()
});
function starsubmit(){
    var flag=true;
    $('input.score').each(function(k,v){
        if($(this).val()==0){
            flag=false;
            return false;
        }
        else flag=true;
    });
    if(!flag||$('.remark').text()==''){
        $('.warning').show();
        return false;
    }
    else{
        $('.warning').hide();
        return true;
    }
}