/**
 * Created by Administrator on 2017/1/9.
 */
$(function(){
    $('.detail a').click(function(){
        var index=$(this).index();
        switch (index){
            case 0:$('#kind').text('充');break;
            case 1:$('#kind').text('支');break;
            case 2:$('#kind').text('收');break;
        };
        $(this).children('.previous').css('display','inline-block');
        $(this).children('.current').css('display','none');
        $(this).siblings().children('.current').css('display','inline-block');
        $(this).siblings().children('.previous').css('display','none');
    })
});
