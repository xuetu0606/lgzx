/**
 * Created by Administrator on 2016/12/26.
 */
$(function(){
$('#hidebg').click(function(){
    //document.formName.reset();
    $('.hidebox').css('display','none');
    $(this).css('display','none');
    $('.updown').removeClass('fa-caret-up').addClass('fa-caret-down');
});
    $('.save').click(function(){
        var id=$(this).parent().parent().attr('id');
        $(id).submit();
        $('.hidebox').css('display','none');
        $('#hidebg').css('display','none');
        $('.updown').removeClass('fa-caret-up').addClass('fa-caret-down');
    });
    $('.area').click(function(){
       $('.areaLeft').css('width','50%');
        $(this ).addClass('changeBc').siblings().removeClass('changeBc');
        $(this).children().addClass('changeC');
        $(this).siblings().children().removeClass('changeC');
        $('.countyRight').css('display','block');
        $('.county').removeClass('changeBc').children().removeClass('changeC');
    });
    $('.county').click(function(){
        $(this ).addClass('changeBc').siblings().removeClass('changeBc');
        $(this).children().addClass('changeC');
        $(this).siblings().children().removeClass('changeC');

    });
    $('.industry').click(function(){
        //alert($('.lowerLevel').css('display'));
        if($('.lowerLevel').css('display')=='none')
        {
            $('.industryLeft').css('width','50%');
        }
        $(this ).addClass('changeBc').siblings().removeClass('changeBc');
        $(this).children().addClass('changeC');
        $(this).siblings().children().removeClass('changeC');
        $('.professionRight').css('display','block');
        $('.profession').removeClass('changeBc').children().removeClass('changeC');
        $('.third').removeClass('changeBc').children().removeClass('changeC');
    });
    $('.profession').click(function(){
        $('.industryLeft').css('width','33%');
        $('.professionRight').css('width','33%').css('left','33%');
        $(this ).addClass('changeBc').siblings().removeClass('changeBc');
        $(this).children().addClass('changeC');
        $(this).siblings().children().removeClass('changeC');
        $('.lowerLevel').css('display','block');
        $('.third').removeClass('changeBc').children().removeClass('changeC');

    });
    $('.third').click(function(){
        $(this ).addClass('changeBc').siblings().removeClass('changeBc');
        $(this).children().addClass('changeC');
        $(this).siblings().children().removeClass('changeC');

    });
    $('.sort').click(function(){
        $(this ).addClass('changeBc').siblings().removeClass('changeBc');
        $(this).children().addClass('changeC');
        $(this).siblings().children().removeClass('changeC');
    });
    //É¾³ýÌõ¼þ
    $('.x').click(function(){
        $(this).parent().remove();
    });

});
function show(index){
    var siblings;
    var id='hide'+index;
    var hidebg=document.getElementById('hidebg');
    var hideobj=document.getElementById(id);
    var span=document.getElementsByClassName('updown');
    var display=hideobj.style.display;
    if(display=='none')
    {
        hideobj.style.display="block";
    hidebg.style.display="block";
        if(document.body.clientHeight>=window.screen.height)
    hidebg.style.height=document.body.clientHeight-40+"px";
        else
    hidebg.style.height=window.screen.height -40+"px";
    for(var i=0;i<span.length;i++)
    {
        if(index==i+1)
        {
                span[i].setAttribute('class','sanjiao updown sanjiao-up');
            break;
        }
    }
    }
    else{
        hideobj.style.display="none";
        hidebg.style.display="none";
        hidebg.style.height=0+'px';
        for(var j=0;j<span.length;j++)
        {
            if(index==j+1)
            {
                span[j].setAttribute('class','sanjiao updown sanjiao-down');
                break;
            }
        }

    }
    for(i=1;i<=4;i++){
        if(index!=i)
        {
            siblings='hide'+i;
            document.getElementById(siblings).style.display='none';
            span[i-1].setAttribute('class','sanjiao updown sanjiao-down');
        }
    }
}