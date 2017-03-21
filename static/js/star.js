/**
 * Created by Administrator on 2017/1/12.
 */
$(function(){
    var flag=false;
    var index=0;
    var star, k, i,j;
    $('img.xing').click(function(){
        $('.warning').hide();
        k=$(this).parent().index();
        star=$(this).parent().parent();
        star.children('.score').val('1');
        if(index<=k)
        {
            //alert("index="+index+"k="+k);
            for( i=0;i<k;i++){
            star.children('.stardiv').eq(i).children('.back').addClass('redxing').removeClass('whitexing');
        }
            index=k;
        }
        else{
            //alert("index="+index+"k="+k);
            for(j=4;j>=k;j--){
                star.children('.stardiv').eq(j).children('.back').removeClass('redxing').addClass('whitexing');
            }
            index=k;
        }
    })
});
