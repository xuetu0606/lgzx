$(function(){
    $('.next-step1').click(function(){
        $('.send').hide();
        $('.reset').show();
        $('span.step2').addClass('stress');
    });
    $('.next-step2').click(function(){
        $('.reset').hide();
        $('.complete').show();
        $('span.step3').addClass('stress');
    })
});