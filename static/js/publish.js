$(function() {
    $('.classify ul li').click(function () {
        $(this).children('a').addClass('active');
        $(this).siblings().children('a').removeClass('active');
        $('.step2').addClass('stress');
        $('.type').show();
    });
    var count1 = 0;
    var count2 = 0;
    $('.allcheck1').click(function () {
        count1++;
        if (count1 % 2 == 1)
            $(this).parent().parent().find('input[type=checkbox]').prop('checked', 'checked');
        else {
            $(this).parent().parent().find('input[type=checkbox]').prop('checked', false);
        }
    });
    $('.allcheck2').click(function () {
        count2++;
        if (count2%2==1)
            $(this).parent().parent().find('input[type=checkbox]').prop('checked', 'checked');
        else {
            $(this).parent().parent().find('input[type=checkbox]').prop('checked', false);
        }
    });
    $('.gb').click(function(){
       $(this).parent().remove();
    })
});