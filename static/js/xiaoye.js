/**
 * Created by Administrator on 2017/3/10.
 */
$(function(){
    $(function(){
        $('span.package').click(function(){
            $(this).addClass('active');
            $(this).parent().siblings().children('.package').removeClass('active');
        })
    })
});