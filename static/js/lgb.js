$(function(){
$('#navlist li').click(function(){
$(this).children('a').addClass('active');
    $(this).siblings().children('a').removeClass('active');
});
    $('p.title span').click(function(){
        $(this).addClass('gz-zlg').siblings().removeClass('gz-zlg');
        if($(this).index()==0){
         $('.fbgz').show();
            $('.zlg').hide();
            $('.third').hide();
        }
        else if($(this).index()==1){
            $('.fbgz').hide();
            $('.zlg').show();
            $('.third').hide();
        }
        else if($(this).index()==2){
            $('.fbgz').hide();
            $('.zlg').hide();
            $('.third').show();

        }
    });
    $('p.xz span').click(function(){
        $(this).addClass('xsxx').siblings().removeClass('xsxx');
        if($(this).index()==0){
            $('.now').show();
            $('.deleted').hide();
            $('.before').hide();
        }
        else if($(this).index()==1){
            $('.now').hide();
            $('.deleted').show();
            $('.before').hide();

        }
        else if($(this).index()==2){
            $('.before').show();
            $('.now').hide();
            $('.deleted').hide();

        }
    });

    $('.allcheck').click(function(){
        if($(this).prop('checked')){
            $('input.should-check').prop('checked',true);
        }
        else{
            $('input.should-check').prop('checked',false);

        }
    });
    {
        if($('input.should-check').length==0)
        {
            $('.zwsj').show();
            $('div.acheck').hide();
        }
    }
//    $('.del').click(function(){
//     var box=$('input.should-check');
//        for(var i=0;i<box.length;i++){
//            if(box.eq(i).prop('checked')){
//                box.eq(i).parent().remove();
//            }
//        }
//        if($('input.should-check').length==0)
//        {
//            $('.zwsj').show();
//            $('div.acheck').hide();
//        }
//})
//    $('.delete').click(function(){
//        $(this).parents('.demo').remove();
//    })
});