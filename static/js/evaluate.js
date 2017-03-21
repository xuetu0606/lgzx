/**
 * Created by Administrator on 2017/1/12.
 */
$(function(){
    var flag=false;
    var num=new Array();
    //$('.xiaolian').click(function(){
    //    //alert($(this).index());
    //    $(this).css('display','none');
    //    $(this).parent().children('.xiaolianred').css('display','inline-block');
    //    $(this).parent().siblings().children('.xiaolianred').css('display','none');
    //    $(this).parent().siblings().children('.xiaolian').css('display','inline-block');
    //    $(this).parent().children('.txt').css('color','#ff2727');
    //    $(this).parent().siblings().children('.txt').css('color','#333');
    //    flag=true;
    //}) ;
    //$('.xiaolianred').click(function(){
    //    $(this).css('display','none');
    //    $(this).parent().children('.xiaolian').css('display','inline-block');
    //    $(this).parent().children('.txt').css('color','#333');
    //    flag=false;
    //}) ;
    $('.star .xing').click(function(){
        var index=$(this).index();
        var parentindex=$(this).parent('.star').index();
        $('.star').eq(parentindex).children('input').val(index);
        var oldsrc=$(this).attr('src');
        var lastindex=oldsrc.lastIndexOf('/');
        var src1=oldsrc.substring(0,lastindex+1);
        var name=oldsrc.substring(lastindex+1,oldsrc.length);
        var newsrc;
        if(name=='xingxing.png'){
            name='xingred.png';
            newsrc=src1+name;
            for(var i=0;i<index;i++){
                $('.star').eq(parentindex).children('.xing').eq(i).attr('src',newsrc);
            }
        }
        else{
            name='xingxing.png';
            newsrc=src1+name;
            for(var i=index;i<5;i++){
                $('.star').eq(parentindex).children('.xing').eq(i).attr('src',newsrc);
            }
        }
        var text=$('.star').eq(parentindex).children('.txt');
        text.css('display','inline-block');
        switch (index){
            case 1:text.text('非常差');break;
            case 2:text.text('差');break;
            case 3:text.text('一般');break;
            case 4:text.text('好');break;
            case 5:text.text('非常好');break;

        }
        var score=document.getElementsByClassName('score');
        var sumScore=0;
        var gradeIndex=-1;
        for(var j=0;j<score.length;j++)
        {
            sumScore+=parseInt(score[j].value);
        }
        if(sumScore>=1&&sumScore<=9)
        {
            gradeIndex=0;

        }
        else if(sumScore>=10&&sumScore<=16)
        {
            gradeIndex=1;

        }
        else if(sumScore>=17&&sumScore<=20)
        {
            gradeIndex=2;

        }
        {
            $('.grade').eq(gradeIndex).children('.xiaolian').css('display','none');
            $('.grade').eq(gradeIndex).children('.xiaolianred').css('display','inline-block');
            $('.grade').eq(gradeIndex).siblings().children('.xiaolianred').css('display','none');
            $('.grade').eq(gradeIndex).siblings().children('.xiaolian').css('display','inline-block');
        }
    });
    $('.content textarea').focus(function(){
        var score=document.getElementsByClassName('score');
        for(var i=0;i<score.length;i++)
        {
            if(score[i].value==0)
            {
                alert('评价尚未完成！');
                $(this).blur();
                break;
            }
        }
    })
});
