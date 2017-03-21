<link rel="stylesheet" href="/static/css/3-list.css"/>
<link rel="stylesheet" href="/static/css/onload.css"/>
<link rel="stylesheet" href="/static/css/nodata.css"/>
<!--<script src="/static/js/onload.js"></script>-->

<section>
    <div class="filter">
            <div onclick="show(1)"><?php if($url_arr['a']&&$url_arr['d']){echo mb_substr($list_area[$url_arr['d']][$url_arr['a']],0,4);}elseif($url_arr['d']){echo mb_substr($list_dist[$url_arr['d']],0,4);}else{echo "区域";}?> <span class="sanjiao sanjiao-down updown"></span></div>
            <span class="line"></span>
        <div onclick="show(2)"><?php if($url_arr['l3']&&$url_arr['l2']&&$url_arr['l1']){echo mb_substr($list_level_3[$url_arr['l1']][$url_arr['l2']][$url_arr['l3']],0,4);}elseif($url_arr['l2']&&$url_arr['l1']){echo mb_substr($list_level_2[$url_arr['l1']][$url_arr['l2']],0,4);}elseif($url_arr['l1']){echo mb_substr($list_level_1[$url_arr['l1']],0,4);}else{echo '类别';}?> <span class="sanjiao sanjiao-down updown"></span></div>
        <span class="line"></span>
        <div onclick="show(3)">筛选<span class="sanjiao sanjiao-down updown"></span></div>
        <span class="line"></span>
        <div onclick="show(4)"> <?php if($url_arr['or']==1){echo "按等级排";}elseif($url_arr['or']==0){echo '按日期排';}else{echo "默认顺序";}?><span class="sanjiao sanjiao-down updown"></span></div>
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
        	<a href="<?php echo site_url('Home/lgdetail/'.$value['id'].''); ?>">
            <div class="portrait">
                <img src="<?php echo $value['img'];?>" alt=""/>
                <span>工号：</span><span><?php echo $value['no'];?></span>
            </div>
            <div class="txt">
                <h3><?php if(mb_strlen($value['info1'])>15){echo mb_substr($value['info1'],0,15,'utf-8')."...";}else{echo mb_substr($value['info1'],0,15,'utf-8'); }?>                    
                    <?php if($user['vip_endtime']){?>
                    <span style="color:#FADA5E;">VIP</span>
                    <?php }else{?>
                    <span class="hui">VIP</span>
                    <?php } ?></h3>
                 <span><?php echo $value['name']?></span>
                 <span><?php echo $value['area_name']?$value['area_name']:$value['district_name'];?></span>
                 <span><?php echo $value['realname']?$value['realname']:$value['username'];?></span>
                <span><?php echo $value['flushtime']?date('y-m-d',$value['flushtime']):date('y-m-d',$value['addtime']);?></span>
                <img src="/static/images/section/3-list/<?php echo $value['is_real']?"rz.png":"wrz.png";?>" alt="实名认证" class="rz"/>
                <img src="/static/images/section/3-list/<?php echo $value['medal']?>.png" alt="" class="jp"/>
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
    <div class="areaLeft">
    <div class="scroll">
    <!--<form action="#" id="form1">-->
        <div class="category "  value=''>
            <span class="fl"><a href="<?php echo site_url($url['d_url']); ?>">不限</a></span>
        </div>
        <?php foreach($list_dist as $key=>$value){?>
        <div class="category area" value='<?php echo $key;?>'>
            <span class="fl" ><?php echo $value;?></span>
            <span class="fa fa-angle-right fr"></span>
        </div>
        <?php }?>
    <!--</form>-->
    </div>
    </div>
    <?php $i = 0; foreach($list_area as $key=>$value){?>
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
    <?php $i++; }?>
</div>



<div class="hidebox" id="hide2" style="display: none">
    <div class="industryLeft">
    <div class="scroll">
    <!--<form action="#" id="form1">-->
        <div class="category ">
            <span class="fl" value=''><a href="<?php echo site_url($url['l1_url'])?>">不限</a></span>
            <!--<span class="fa fa-chevron-right fr"></span>-->
        </div>
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
        <div class="category ">
            <span class="fl" value=''><a href="<?php echo site_url($url['l1_url'].$key)?>">不限</a></span>
            <!--<span class="fa fa-chevron-right fr"></span>-->
        </div>
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
	        <div class="category ">
	            <span class="fl" value=''><a href="<?php echo site_url($url['l2_url'].$ke."/l1/".$key)?>">不限</a></span>
	            <!--<span class="fa fa-chevron-right fr"></span>-->
	        </div>
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
    <form action="" id="form3">
    	<div class="category">
            <span>类型：</span>
            <input type="radio" name="t" value="all" <?php echo (is_null($url_arr['t'])||$url_arr['t']=='all')?"checked='checked'":"";?> onclick="choose_s1();"/>不限
            <input type="radio" name="t" value="0" <?php echo (!is_null($url_arr['t'])&&$url_arr['t']=='0')?"checked='checked'":"";?> onclick="choose_s1();"/>个人
            <input type="radio" name="t" value="1"  <?php echo ($url_arr['t']==1)?"checked='checked'":"";?>  onclick="choose_s();"/>公司
        </div>
        <div class="category">
            <span>性别：</span>
            <input type="radio" name="s" value="0" <?php echo (is_null($url_arr['s'])||$url_arr['s']==0)?"checked='checked'":"";?> onclick="choose_t1();"/>不限
            <input type="radio" name="s" value="1" <?php echo $url_arr['s']==1?"checked='checked'":"";?> onclick="choose_t();"/>男
            <input type="radio" name="s" value="2" <?php echo $url_arr['s']==2?"checked='checked'":"";?> onclick="choose_t();"/>女
        </div>
        
        <div class="category">
            <span>大学生零工：</span>
            <input type="radio" name="stu" <?php echo (is_null($url_arr['stu'])||$url_arr['stu']=='all')?"checked='checked'":"";?> value="all"/>不限
            <input type="radio" name="stu" <?php echo ($url_arr['stu']==1)?"checked='checked'":"";?> value="1"/>是
            <input type="radio" name="stu" <?php echo (!is_null($url_arr['stu'])&&$url_arr['stu']=='0')?"checked='checked'":"";?> value="0"/>否
        </div>
        <div class="category">
            <span>涉外零工：</span>
            <input type="radio" name="f" <?php echo (is_null($url_arr['f'])||$url_arr['f']=='all')?"checked='checked'":"";?> value="all"/>不限
            <input type="radio" name="f" <?php echo ($url_arr['f']==1)?"checked='checked'":"";?> value="1"/>是
            <input type="radio" name="f" <?php echo (!is_null($url_arr['f'])&&$url_arr['f']=='0')?"checked='checked'":"";?> value="0"/>否
        </div>
        <div class="category">
            <span>实名认证：</span>
            <input type="radio" name="r" <?php echo (is_null($url_arr['r'])||$url_arr['r']=='all')?"checked='checked'":"";?> value="all"/>不限
            <input type="radio" name="r" <?php echo ($url_arr['r']==1)?"checked='checked'":"";?> value="1"/>是
            <input type="radio" name="r" <?php echo (!is_null($url_arr['r'])&&$url_arr['r']=='0')?"checked='checked'":"";?> value="0"/>否
        </div>
        <div class="category">
            <span>上门服务：</span>
            <input type="radio" name="o" <?php echo (is_null($url_arr['o'])||$url_arr['o']=='all')?"checked='checked'":"";?> value="all"/>不限
            <input type="radio" name="o" <?php echo ($url_arr['o']==1)?"checked='checked'":"";?> value="1"/>是
            <input type="radio" name="o" <?php echo (!is_null($url_arr['o'])&&$url_arr['o']=='0')?"checked='checked'":"";?> value="0"/>否
        </div>
        <div class="category">
            <input type="reset" value="重置"/>
            <input type="button" value="保存" class="save" onclick="turntonew()"/>
        </div>
    </form>
</div>
<script type="text/javascript">
function choose_t(){
	$("input[name='t']").removeAttr('checked');
	$("input[name='t'][value=0]").attr("checked",true);
	$("input[name='t']").attr("disabled","disabled");
}
function choose_s(){
	$("input[name='s']").removeAttr('checked');
	$("input[name='s'][value=0]").attr("checked",true);
	$("input[name='s']").attr("disabled","disabled");
}
function choose_t1(){
	$("input[name='t']").removeAttr("disabled");
}
function choose_s1(){
	$("input[name='s']").removeAttr("disabled");
}
function turntonew(){
	var s = $("input[name='s']:checked").val();  
	var t = $("input[name='t']:checked").val();  
	var stu = $("input[name='stu']:checked").val();  
	var f = $("input[name='f']:checked").val();  
	var r = $("input[name='r']:checked").val();  
	var o = $("input[name='o']:checked").val();  
	var url = "<?php echo site_url($url['zh_url']);?>"+"/s/"+s+"/t/"+t+"/stu/"+stu+"/f/"+f+"/r/"+r+"/o/"+o;
	window.location.href=url;
}
</script>
<div class="hidebox" id="hide4" style="display: none">
            <!--<form action="#" id="form1">-->
            <a href="<?php echo site_url($url['or_url'].'0')?>">
            <div class="category sort">
                <span class="fl">按日期排序</span>
                <!--<span class="fa fa-chevron-right fr"></span>-->
            </div>
            </a>
            <a href="<?php echo site_url($url['or_url'].'1')?>">
            <div class="category sort">
                <span class="fl">按等级排序</span>
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
	                var urla = '/lista/ajaxlist<?php echo $url['p_ajax_url']?>'+p;
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
//		console.log($(document).scrollTop() + $(window).height() +1);
//    console.log($(document).height());
});
</script>