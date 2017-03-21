/**
 * Created by Administrator on 2017/1/24.
 */
window.onload=function(){
    var h;
    if(document.body.clientHeight<window.screen.height) {
        h = window.screen.height-220 + "px";

        console.log(document.body.clientHeight);
        console.log(window.screen.height);
        $('section').css('height', h);
    }
    //$(window).resize(function(){
    //    alert(1);
    //    h=document.body.clientHeight+"px";
    //    $('section').css('height',h);
    //
    //});
    $("input").focus(function(){$("footer").hide();});
    $("input").focusout(function(){$("footer").show();});
};
