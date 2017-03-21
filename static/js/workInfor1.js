$(function(){
    //选择工种、地区
    $('.type ul li').click(function(){
        $(this).children('a').css('color','#ff3c5a');
        $(this).siblings().children('a').css('color','#333');

        if($(this).parents('.fenlei').length==1&&$(this).children('a').text()!="不限"){
            $('.zhiye').hide();
            $('.gongzhong').hide();
            $('.zhiye#'+$(this).children()[0].name).show();
            // console.log($(this).children()[0].name);
        }
        else if($(this).parents('.fenlei').length==1&&$(this).children('a').text()=="不限"){
            $('.zhiye').hide();
        }
        else if($(this).parents('.zhiye').length==1&&$(this).children('a').text()!="不限"){
            $('.gongzhong').hide();
            $('.gongzhong#'+$(this).children()[0].name).show();
            // console.log($(this).children()[0].name);
        }
        else if($(this).parents('.zhiye').length==1&&$(this).children('a').text()=="不限"){
            $('.gongzhong').hide();
        }
        else if($(this).parents('.quyu').length==1&&$(this).children('a').text()!="不限"){
            $('.dizhi').hide();
            $('.dizhi#'+$(this).children()[0].name).show();
            // console.log($(this).children()[0].name);
        }
        else if($(this).parents('.quyu').length==1&&$(this).children('a').text()=="不限"){
            $('.dizhi').hide();
        }
    });
    $('.dizhi a').click(function(){
        $(this).css('color','#ff3c5a');
        $(this).siblings().css('color','#546e7a');
    });
    //发布时间下拉
    $('#time span.xl').click(function(){
        var ul=$(this).siblings('ul.list-group');
        if(ul.css('display')=='none'){
            $('img.timejt').prop('src','/static/images/shangla.png');
           ul.show();
        }else{
            $('img.timejt').prop('src','/static/images/form/xl.png');
            ul.hide();
        }
    });
    $('.citya').click(function(){
       $('.fbsj').text($(this).text());
        $('#time ul.list-group').hide();
        $('img.timejt').prop('src','/static/images/form/xl.png');
    });
    $(document).bind("click", function (e) {
        var target = $(e.target);
        if(target.closest("#time").length == 0){
            //进入if则表明点击的不是#province,#proDiv元素中的一个
            $("#time ul.list-group").hide();
            $('img.timejt').prop('src','/static/images/form/xl.png');
        }
        e.stopPropagation();
    });
    //分页
    $('.fenye a').click(function(){
        if($(this).index()!=10)
           $(this).addClass('current').siblings().removeClass('current');
    })
});