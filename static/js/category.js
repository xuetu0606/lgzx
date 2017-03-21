/**
 * Created by Administrator on 2016/12/26.
 */
$(function(){
    $('#hidebg').click(function(){
        //document.formName.reset();
        $('.hidebox').css('display','none');
        $(this).css('display','none');
        $('.updown').removeClass('sanjiao-up').addClass('sanjiao-down');
    });
    $('.save').click(function(){
        var id=$(this).parent().parent().attr('id');
        $(id).submit();
        $('.hidebox').css('display','none');
        $('#hidebg').css('display','none');
        $('.updown').removeClass('sanjiao-up').addClass('sanjiao-down');
    });
    $('.area').click(function(){
    	var distid = $(this).attr("value");
    	if(distid==''){	
    	}else{
    		$('.areaLeft').css('width','50%');
	        $(this ).addClass('changeBc').siblings().removeClass('changeBc');
	        $(this).find('span').addClass('changeC');
        	$(this).siblings().find('span').removeClass('changeC');
	        $('.countyRight_'+distid).css('display','block');
	        $('.countyRight_'+distid).siblings().not($('.areaLeft')).css('display','none');
	        $('.county').removeClass('changeBc').find('span').removeClass('changeC');
    	}
    });
    $('.county').click(function(){
        $(this ).addClass('changeBc').siblings().removeClass('changeBc');
        $(this).find('span').addClass('changeC');
        $(this).siblings().find('span').removeClass('changeC');

    });
    $('.industry').click(function(){
    	var l_1_id = $(this).attr("value");
//        if($('.lowerLevel').css('display')=='none'){
            $('.industryLeft').css('width','50%');
//        }
        $(this ).addClass('changeBc').siblings().removeClass('changeBc');
        $(this).find('span').addClass('changeC');
        $(this).siblings().find('span').removeClass('changeC');
        $('.professionRight').css('width','50%').css('left','50%')
        $('.professionRight_'+l_1_id).css('display','block');
	    $('.professionRight_'+l_1_id).siblings().not($('.industryLeft')).css('display','none');
//	    alert( $('.professionRight'+l_1_id).attr('class'));
        $('.profession').removeClass('changeBc').find('span').removeClass('changeC');
        $('.third').removeClass('changeBc').find('span').removeClass('changeC');
        
    });
    $('.profession').click(function(){
    	var l_2_id =  $(this).attr("value");
        $('.industryLeft').css('width','33%');
        $('.professionRight').css('width','33%').css('left','33%');
        $(this ).addClass('changeBc').siblings().removeClass('changeBc');
        $(this).find('span').addClass('changeC');
        $(this).siblings().find('span').removeClass('changeC');
        $('.lowerLevel_'+l_2_id).css('display','block');
        $('.lowerLevel_'+l_2_id).siblings().not($('.industryLeft')).not($('.professionRight')).css('display','none');
        $('.third').removeClass('changeBc').find('span').removeClass('changeC');

    });
    $('.third').click(function(){
        $(this ).addClass('changeBc').siblings().removeClass('changeBc');
        $(this).find('span').addClass('changeC');
        $(this).siblings().find('span').removeClass('changeC');

    });
    $('.sort').click(function(){
        $(this ).addClass('changeBc').siblings().removeClass('changeBc');
        $(this).find('span').addClass('changeC');
        $(this).siblings().find('span').removeClass('changeC');
    });
    //ɾ�����
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