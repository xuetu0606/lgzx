<link rel="stylesheet" href="/static/css/3-list.css"/>
<link rel="stylesheet" href="/static/css/onload.css"/>
<link rel="stylesheet" href="/static/css/nodata.css"/>
<!--<script src="/static/js/onload.js"></script>-->

<section>
   <?php if(count($result[0])||count($result[1])){?>
   <div class=""><ul>
   <?php foreach($result[0] as $key=>$value){
   	if($value['level']==3){
				$url = "/lista/index/l1/".$value['pre_pre_id']."/l2/".$value['pre_id']."/l3/".$value['id'];
			}elseif($value['level']==2){
				$url = "/lista/index/l1/".$value['pre_id']."/l2/".$value['id'];
			}else{
				$url = "/lista/index/l1/".$value['id'];
			}
	$value['name'] = str_replace($k,"<span class='hui'>$k</span>",$value['name']);
   	?>
   <li><a href="<?php echo site_url($url)?>"><span><?php echo $value['name'] ?></span></a></li>
   <?php }?>
   <?php foreach($result[1] as $ke=>$val){
   	$val['info1'] = str_replace($k,"<span class='hui'>$k</span>",$val['info1']);
   	?>
   <li><a href="<?php echo site_url("home/lgdetail/".$val['id'])?>"><span><?php echo $val['info1'] ?></span></a></li>
   <?php }?>

    </ul></div>
   <?php }else{?>
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
  
</section>

<style>
    ul{
        margin: 0;
        padding: 0;
    }
    body section ul li{
        display: block;
        height: 3.2rem;
        line-height: 3.2rem;
        box-sizing: border-box;
        padding-left: .4rem;
        border-bottom: solid 1px #b0b0b0;
        list-style: none;
    }
    ul li a{
        display: block;
        height: 3.2rem;
        line-height: 3.2rem;
        font-size: 1.2rem;
        color: #000;
        text-decoration: none;
    }
</style>
