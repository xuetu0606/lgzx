
    <link rel="stylesheet" href="/static/css/workInfor.css"/>
    <link rel="stylesheet" href="/static/css/form.css"/>
<div class="full">
    <div class="main">
        <img src="/static/images/LOGOa.png" alt="" class="logo"/>
        <form action="<?php echo site_url('Listlg/lgsearch'); ?>" method="POST" >
            <input type="text" class="input-normal" name='search'/>
            <input type="submit" value="" class="fdj"/>
        </form>
        <a href="#">免费发布信息</a>
    </div>
</div>
<section>
    <div class="position">
        <span><?php echo $cityname?$cityname:$city; ?>零工在线</span>
        <span> > </span>
        <span><?php echo $one_name; ?></span>
        <?php if($two_name){ ?>
        <span> > </span>
        <span><?php echo $two_name; ?></span>
        <?php } ?>
    </div>
    <div class="main">
        <div class="conditions">
          <div class="type fenlei">
              <span>分类：</span>
              <ul>
                  <li><a href="#">不限</a></li>
                   <?php foreach($lists as $k_lists => $v_lists){ ?>
                  <li><a href="#" data="<?php echo $k_lists; ?>"><?php echo $v_lists['name']; ?></a></li>
                  <?php } ?>
              </ul>
          </div>
          <?php foreach($lists as $k_lists => $v_lists){ ?>
          <div class="type zhiyes zhiye<?php echo $k_lists; ?>">
              <span>职业：</span>
              <ul>
                  <li><a href="#">不限</a></li>
                  <?php
                    foreach($v_lists['sub'] as $k_sub => $v_sub){
                      //foreach($v_sub as $k_two => $v_two){
                  ?>
                  <li><a href="#" data="<?php echo $k_sub; ?>"><?php echo $v_sub['name']; ?></a></li>
                  <?php } //}?>
              </ul>
          </div>
          <?php } ?>
          <?php foreach($lists as $k_lists => $v_lists){ 
            foreach($v_lists['sub'] as $k_sub => $v_sub){
              if($v_sub['name'] == '其他'){
                continue;
              }
          ?>
            <div class="type gongzhong gongzhongs<?php echo $k_sub; ?>">
                <span>工种：</span>
                <ul>
                    <li><a href="#">不限</a></li>
                    <?php foreach($v_sub['sub'] as $k_three => $v_three){ ?>
                    <li><a href="<?php echo site_url('listlg/gzlist/l1/'.$k_lists.'/l2/'.$k_sub.'/l3/'.$k_three); ?>"><?php echo $v_three['name']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
          <?php } }?>
          <div class="type quyu">
              <span>区域：</span>
              <ul>
                  <li><a href="#">不限</a></li>
              <?php foreach($list_dist as $k_dist => $v_dist){ ?>
                  <li><a href="#" data="<?php echo $k_dist; ?>"><?php echo $v_dist; ?></a></li>
              <?php } ?>  
              </ul>
          </div>
          <?php foreach($list_area as $k_area => $v_area){ ?>
          <div class="type dizhi">
            <?php foreach($v_area as $k_a => $v_a){ ?>
              <a href="#"><?php echo $v_a; ?></a>
            <?php } ?>
          </div>
          <?php } ?>
        </div>
        <div class="middle">
            <form action="">
                <div class="select">
                    <div id="time">
                        <span class="fbsj">发布时间</span>
                        <span class="xl"><img src="/static/images/form/xl.png" alt="" class="timejt"/></span>
                        <ul class="list-group">
                            <a href='javascript:void(0);' class='list-group-item citya'>三天内</a>
                            <a href='javascript:void(0);' class='list-group-item citya'>一周内</a>
                            <a href='javascript:void(0);' class='list-group-item citya'>一月内</a>
                            <a href='javascript:void(0);' class='list-group-item citya'>全部时间</a>
                        </ul>
                    </div>
                </div>
                <div class="marginr">
                    <input type="checkbox"/>  <span class="xz">公司</span>
                </div>
                <div class="marginr">
                    <input type="checkbox"/>  <span class="xz">个人</span>
                </div>
                <div class="marginr">
                    <input type="checkbox"/>  <span class="xz">认证</span>
                </div>
                <div class="marginr">
                    <input type="checkbox"/>  <span class="xz">按信用等级排序</span>
                </div>
                </form>
        </div>
        <div class="information">
          <?php foreach($list as $key => $value){ ?>
            <div class="type">
                <?php if($value['pimg']){
                 
                  $imgname = explode(',',$value['pimg']);
                  $img_name = explode('.',$imgname[0]); ?>
                  <img src="/upload/<?php echo $city_code['pinyin']; ?>/gzxx/<?php echo $value['uid'].'/'.$img_name[0].'_150_100'.'.'.$img_name[1]; ?>" alt="" class="tx"/>
               <?php }else{  ?>                   
                  <img src="/static/images/people.png" alt="" class="tx"/>
               <?php } ?>

                <div class="jieshao">
                    <div class="line1">
                    <a href="<?php echo site_url('listlg/lgDetail/'.$value['id']); ?>" class="name"><?php echo $value['info1']; ?></a>
                    <?php if($user[$key]){ ?>
                    <span class="vip"><img src="/static/images/vip/vip1.png" alt=""/></span>
                    <?php } ?>
                    <?php if($value['is_real']){ //判断已经实名认证的用户
                        if($value['is_co']){//判断是公司类型的用户
                    ?>
                    <span class="identify"><img src="/static/images/renzheng/yingyezhiz.png" alt=""/></span>
                    <?php }else{ //判断是个人类型的用户?>
                    <span class="identify"><img src="/static/images/renzheng/person.png" alt=""/></span>
                    <?php }} ?>
                    <span class="vip"><img src="/static/images/section/3-list/<?php echo $value['medal']; ?>.png" alt=""/></span>
                </div>
                    <span class="address"><?php
                    foreach($value['dist'] as $v_address){
                        $str = $v_address.' ';
                        echo $str;
                      } ?>
                    </span>
                    <div class="line3">
                        <span class="gs"><?php if($value['realname']){ echo $value['realname']; }else{ echo $value['username']; } ?></span>
                        <span class="sj"><?php date_default_timezone_set("PRC"); echo date("Y-m-d H:i",$value['addtime']); ?></span>
                    </div>
                </div>
                <span class="tel"><?php echo $value['mobile']; ?></span>
            </div>
          <?php } ?>
        </div>
    </div>
    <div class="fenye">
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">6</a>
        <a href="#">7</a>
        <a href="#">8</a>
        <a href="#">9</a>
        <a href="#">10</a>
        <a href="#">下一页</a>
    </div>
</section>
<script src="/static/js/workInfor.js"></script>
