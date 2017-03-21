$(function() {
    var list = [
        {
            "p": "江西省",
            "c": [
                {
                    "ct": "南昌市",
                    "d": [
                        {"dt": "西湖区"},
                        {"dt": "东湖区"},
                        {"dt": "高新区"}
                    ]
                },
                {
                    "ct": "赣州市",
                    "d": [
                        {"dt": "瑞金县"},
                        {"dt": "南丰县"},
                        {"dt": "全南县"}
                    ]
                }
            ]
        },
        {
            "p": "北京",
            "c": [
                {"ct": "东城区"},
                {"ct": "西城区"}
            ]
        },
        {
            "p": "河北省",
            "c": [
                {
                    "ct": "石家庄",
                    "d": [
                        {"dt": "长安区"},
                        {"dt": "桥东区"},
                        {"dt": "桥西区"}
                    ]
                },
                {
                    "ct": "唐山市",
                    "d": [
                        {"dt": "滦南县"},
                        {"dt": "乐亭县"},
                        {"dt": "迁西县"}
                    ]
                }
            ]
        }
    ];
    var pro = $('#province');
    var city = $('#city');
    var proDiv = $('#proDiv');
    var cityDiv = $('#cityDiv');
    var index=0;
    var divhtml2='';
    var cityhtml='';
    var proFun = function () {
        var prohtml = '';
        $.each(list, function (k, v) {
            //prohtml+= "<option value='"+v.p+"'>"+v.p+"</option>";
            prohtml += "<a href='javascript:void(0);' class='list-group-item'>" + v.p + "</a>";
        });
        pro.html(prohtml);
        //初始化省份、城市------------------------------------
        var divhtml = proDiv.html() + "<span class='text'>"+list[0].p+"</span>";
        proDiv.html(divhtml);
        console.log(proDiv.html());
    };

    var cityFun=function(){
        cityhtml='';
        $.each(list[index].c,function(k,v){
            cityhtml+= "<a href='javascript:void(0);' class='list-group-item citya'>" + v.ct + "</a>";
        });
        city.html(cityhtml);
        cityDiv.parent().find('span.text').eq(0).text(list[index].c[0].ct);
        console.log(cityDiv.html());

    };
    proFun();
    cityFun();

  $('span.xl').click(function(){
      $(this).parent().find('ul').toggle();
      //$('#province').toggle();
  });
    $(document).bind("click", function (e) {
        var target = $(e.target);
        if(target.closest("#province,#proDiv").length == 0){
            //进入if则表明点击的不是#province,#proDiv元素中的一个
            $("#province").hide();
        } if(target.closest("#city,#cityDiv").length == 0){
            //进入if则表明点击的不是#province,#proDiv元素中的一个
            $("#city").hide();
        }
        e.stopPropagation();
    });
$('#province a').click(function(){
    $('#proDiv span.text').text($(this).text());
    $('#province').hide();
    index=$(this).index();
    cityFun();
});
    $(document).on('click','.citya', function() {
        cityDiv.parent().find('span.text').eq(0).text($(this).text());
        $('#city').hide();

    });
});