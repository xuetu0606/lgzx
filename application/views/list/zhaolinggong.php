<link rel="stylesheet" href="/static/css/3-list.css"/>
<link rel="stylesheet" href="/static/css/onload.css"/>
<link rel="stylesheet" href="/static/css/nodata.css"/>
<!--<script src="/static/js/onload.js"></script>-->

<section>
    <div class="filter">
            <div onclick="show(1)">区域 <span class="sanjiao sanjiao-down updown"></span></div>
            <span class="line"></span>
        <div onclick="show(2)">类别 <span class="sanjiao sanjiao-down updown"></span></div>
        <span class="line"></span>
        <div onclick="show(3)">薪资结算<span class="sanjiao sanjiao-down updown"></span></div>
        <span class="line"></span>
        <div onclick="show(4)">默认排序 <span class="sanjiao sanjiao-down updown"></span></div>
    </div>
    <!--<div class="condition">
        <div><span class="txt">公司</span><img src="../images/section/3-list/x.png" class="x"/></div>
        <div><span class="txt">大学生零工</span><img src="../images/section/3-list/x.png" class="x"/></div>
        <div><span class="txt">大学生零工</span><img src="../images/section/3-list/x.png" class="x"/></div>
        <div><span class="txt">大学生零工</span><img src="../images/section/3-list/x.png" class="x"/></div>
        <div><span class="txt">大学生零工</span><img src="../images/section/3-list/x.png" class="x"/></div>
        <div><span class="txt">大学生零工</span><img src="../images/section/3-list/x.png" class="x"/></div>
    </div>-->
    <div class="list">
        <div  class = "page_flag" page='<?php echo $url_arr['p']?$url_arr['p']:'1';?>'>
        <?php if(count($list)){foreach($list as $key=>$value){ ?>
        <div class="infor">
        	<a href="<?php echo site_url('lista/zplgdetail/'.$value['id'].''); ?>">
            <div class="portrait">
                <img src="<?php echo $value['img'];?>" alt=""/>
                <span>工号：</span><span><?php echo $value['no'];?></span>
            </div>
            <div class="txt">
                <h3><?php if(mb_strlen($value['title'])>15){echo mb_substr($value['title'],0,15,'utf-8')."...";}else{echo mb_substr($value['title'],0,15,'utf-8'); }?></h3>
                 <span><?php echo $value['pay'].$value['name']?></span>
                 <span></span>
                 <span><?php echo $value['coname']?$value['coname']:$value['username'];?></span>
                <span><?php echo $value['flushtime']?date('y-m-d',$value['flushtime']):date('y-m-d',$value['addtime']);?></span>
                <!--<img src="/static/images/section/3-list/<?php // echo $value['is_real']?"rz.png":"wrz.png";?>" alt="实名认证" class="rz"/>
                <img src="/static/images/section/3-list/<?php //echo $value['medal']?>.png" alt="" class="jp"/>-->
            </div>
            </a>
            <a href="tel:<?php echo $value['mobile'];?>" class="img-tel"><img src="/static/images/section/3-list/tel.png" alt="电话" class="tel"/></a>
        </div>
        <?php }}else{?>
        <div class="nodata">
            <p>
                <img src="/static/images/section/bkx.png" alt="">
                <span>暂无数据</span>
            </p>
            <p>
                <a href="<?php echo site_url('user/publish') ?>" class="deepblue">抢沙发</a>
            </p>
            </div>
        <?php }?>
        </div>
    </div>
</section>
<!--<div id="onload" style="visibility: hidden;">
    <img src="/static/images/section/onload.png" alt=""/>
    <span style="color:#727171;">加载中...</span>
</div>-->
<div id="onload"  style="visibility: hidden;">
    <img src="/static/images/section/onload.png" alt="" />
    <span style="color:#727171;">加载中...</span>
</div>
<div id="onload1" style="visibility: hidden;">
    <span style="color:#727171;">点击后加载更多</span>
    <img src="/static/images/section/onload1.png" alt="" id="onload1img"/>
</div>
<input type="hidden" name='onload_flag' value='1'>
<div id="hidebg" style="display: none" ></div>

<div class="hidebox" id="hide1" style="display: none">
<!--    <div class="areaLeft">-->
    <div class="scroll" style="background-color:#fff;">
    <!--<form action="#" id="form1">-->
        <a href="<?php echo site_url($url['d_url']); ?>">
        <div class="category "  value=''>
            <span class="fl">不限</span>
        </div>
        </a>
        <?php foreach($list_dist as $key=>$value){?>
        <a href="<?php echo site_url($url['d_url'].$key); ?>">
        <div class="category area" value='<?php echo $key;?>'>
            <span class="fl" ><?php echo $value;?></span>
            <!--<span class="fa fa-angle-right fr"></span>-->
        </div>
        </a>
        <?php }?>
    <!--</form>-->
    </div>
<!--    </div>-->
    <?php if(0){$i = 0; foreach($list_area as $key=>$value){?>
    <div class="countyRight countyRight_<?php echo $key;?> " value='<?php echo $key;?>'>
    <div class="scroll">
        <div class="category ">
            <span class="fl" value=''><a href="<?php echo site_url($url['d_url'].$key); ?>">不限</a></span>
            <!--<span class="fa fa-chevron-right fr"></span>-->
        </div>
        <?php foreach($value as $k=>$v){?>
        <a href="<?php echo site_url($url['a_url'].$k."/d/".$key)?>">
        <div class="category county">
            <span class="fl" value='<?php echo $k;?>'><?php echo $v?></span>
        </div>
        </a>
        <?php }?>
    </div>
    </div>
    <?php $i++; }}?>
</div>



<div class="hidebox" id="hide2" style="display: none">
    <div class="industryLeft">
    <div class="scroll">
    <!--<form action="#" id="form1">-->
        <a href="<?php echo site_url($url['l1_url'])?>">
        <div class="category ">
            <span class="fl" value=''>不限</span>
            <!--<span class="fa fa-chevron-right fr"></span>-->
        </div>
        </a>
        <?php foreach($list_level_1 as $key=>$value){?>
        <div class="category industry" value='<?php echo $key;?>'>
            <span class="fl" ><?php echo $value;?></span>
            <span class="you">></span>
        </div>
        <?php }?>
        
        <!--</form>-->
    </div>
    </div>
    <?php foreach($list_level_2 as $key=>$value){?>
    <div class="professionRight professionRight_<?php echo $key;?>" value=''>
    <div class="scroll">
        <a href="<?php echo site_url($url['l1_url'].$key)?>">
        <div class="category ">
            <span class="fl" value=''>不限</span>
            <!--<span class="fa fa-chevron-right fr"></span>-->
        </div>
        </a>
        <?php foreach($value as $k=>$v){?>
        <div class="category profession" value='<?php echo $k?>'>
            <span class="fl" ><?php echo $v?></span>
            <span class="you">></span>
        </div>
        <?php }?>
    </div>
    </div>
    <?php }?>
    <?php foreach ($list_level_3 as $key=>$value){?>
	    <?php foreach($value as $ke=>$val){ ?>
	    <div class="lowerLevel lowerLevel_<?php echo $ke;?>">
	    <div class="scroll">
        <a href="<?php echo site_url($url['l2_url'].$ke."/l1/".$key)?>">
	        <div class="category ">
	            <span class="fl" value=''>不限</span>
	            <!--<span class="fa fa-chevron-right fr"></span>-->
	        </div>
        </a>
	        <?php foreach($val as $k=>$v){?>
            <a href="<?php echo site_url($url['l3_url'].$k."/l2/".$ke."/l1/".$key)?>">
	        <div class="category third">
	            <span class="fl" value="<?php echo $k;?>"><?php echo $v;?></span>
	        </div>
            </a>
	        <?php }?>
	
	    </div>
	    </div>
	    <?php }?>
    <?php }?>
</div>
<div class="hidebox" id="hide3" style="display: none">
<!--    <form action="" id="form3">-->
        <div class="scroll" style="background-color:#fff;">
        <a href="<?php echo site_url($url['x_url'])?>">
        <div class="category">
            <span class="fl" value=''>不限</span>
            <!--<span class="fa fa-chevron-right fr"></span>-->
        </div>
        </a>
        <?php foreach($pay_circle as $k=>$v){?>
        <a href="<?php echo site_url($url['x_url'].$k)?>">
        <div class="category " value='<?php echo $k?>'>
            <span class="fl" ><?php echo $v?></span>
            <!--<span class="you">></span>-->
        </div>
        </a>
        <?php }?>
    </div>
<!--    </form>-->
</div>

<div class="hidebox" id="hide4" style="display: none">
            <!--<form action="#" id="form1">-->
            <a href="<?php echo site_url($url['or_url'].'0')?>">
            <div class="category sort">
                <span class="fl">按日期排序</span>
                <!--<span class="fa fa-chevron-right fr"></span>-->
            </div>
            </a>
            <!--</form>-->
        </div>
<script type="text/javascript">
$(function(){
	var pagec = <?php echo $pagec?>;
    $(window).scroll(function(event){
        if($(document).scrollTop() + $(window).height() +30>= $(document).height()){
	 		var p = parseInt($(".page_flag:last").attr('page'))+1;
        		if(p>pagec){
	                 $('#onload1').css('visibility',' hidden');return;
	            }else{
	            	$('#onload1').css('visibility',' visible');
	            }
//            }else{
//                $('#onload1').css('visibility',' hidden');
            }
        });
      $('#onload1').click(function(){
					$('#onload1').css('visibility','hidden');
					$('#onload').css('visibility','visible');//加载中样式
			        var time=setTimeout(function(){
	                var p = parseInt($(".page_flag:last").attr('page'))+1;
	                var urla = '/lista/ajaxzlglist<?php echo $url['p_ajax_url']?>'+p;
	                 $.ajax({
	                        url: urla,
	                        type: "GET",
//		                    dataType: 'json',
	                        data: {mobile:$("#mobile").val()},
	                        cache: false,
	                        beforeSend: function(){
	                            $('#onload').css('visibility',' visible');//加载中样式
	                        },
	                        error: function(){
	                        },
	                        success: function(data){
	                            $(".list").append(data);
	                            $('#onload').css('visibility',' hidden');//加载完毕隐藏加载中样式
	                            if(p>pagec){
				                    $('#onload1').css('visibility',' hidden');return;
	                            }else{
	                            	$('#onload1').css('visibility',' visible');
	                            }
	                            
	                        }
	                    });
	
			        },1000);
				});

});
</script>
<style>
#hide3 .category:last-child {
    background-color: #fff !important;
}
</style>