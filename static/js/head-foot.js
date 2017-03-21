/**
 * Created by Administrator on 2017/2/28.
 */
$(function(){
    //悬浮出现下拉框
    $('.lgbxl').mouseover(function(){
        $('div.lgb').css('display','block');
    });
    $('div.lgb').hover(function(){
        $('div.lgb a.lgba').mouseover(function(){
            $(this).addClass('a-backcolor').siblings().removeClass('a-backcolor');
        });
    },function(){
        $('div.lgb').css('display','none');

    });
    $('.wxb').hover(function(){
        $('div.wx').css('display','block');
    },function(){
        $('div.wx').css('display','none');

    });
    $('div.wx').hover(function(){
        $(this).css('display','block');
    },function(){
        $(this).css('display','none');

    });
    //判断滚动条，设置下拉框位置
    {
        var w=($(document).width()-1190)/2+160;
        $('div.lgb').css('right',w+'px');
        $('div.wx').css('right',w-80+'px');
        //console.log(w);
        //if($(document).height()<=$(document.body).height()+2)//有滚动条
        //{
        //    $('div.lgb').css('right',w+'px');
        //    $('div.wx').css('right',w-80+'px');
        //}
        //else{
        //    $('div.lgb').css('right',w+'px');
        //    $('div.wx').css('right',w-80+'px');
        //}

    }
    $(window).resize(function(){
        w=($(document).width()-1190)/2+160;
        //console.log(w);
        $('div.lgb').css('right',w+'px');
        $('div.wx').css('right',w-80+'px');
    });
});
