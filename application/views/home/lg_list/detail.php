<link rel="stylesheet" href="/static/css/4-details.css"/>
<section>
    <div class="head">
        <img src="/static/images/section/4-details/little.jpg" alt=""/>
        <span>首页></span>
        <span><?php echo $cityname;?>></span>
        <span>零工展示></span>
        <span>零工信息</span>
    </div>

    <div class="infor">
        <div class="intro">
            <div class="portrait">
            <?php if($firms['img']){//判断用户是否上传头像了
                
                if($person['is_co'] == 0){//个人头像
                    echo "<img src='/upload/".$citycode."/grtx/".$firms['img']."' alt='' class='img1'/>";
                }else if($person['is_co'] == 1){//公司头像
                    echo "<img src='/upload/".$citycode."/gstx/".$firms['img']."' alt='' class='img1'/>";
                }
            }else{
               echo "<img src='/static/images/default/noimg1.jpg' alt='' class='img1'/>";
            }
            ?>
            </div>
            <p><?php echo $person['info1']; ?></p>
        </div>

        <p class="line"></p>
        <div class="txt">
            <table>
                <tr>
                    <td>工号：</td>
                    <td><?php echo $person['no']; ?></td>
                </tr>
                <tr>
                    <td>用户名：</td>
                    <td><?php echo $person['username']; ?></td>
                </tr>
                <?php if($person['is_co'] == 0){ //这是个人类型?>
                <tr>
                    <td>类型：</td>
                    <td>个人</td>
                </tr>
                <tr>
                    <td>姓名：</td>
                    <td>
                        <?php echo $firms['realname']; ?>
                        <?php if($person['is_real'] == 1){ ?>
                        <img src="/static/images/section/duihao.png" alt="" class="duihao"/>
                        <span class="hui" style="font-size: .9rem;">实名认证</span>
                        <img src="/static/images/tpls/lgb/jin.png" alt=""/>
                        <?php }else if($person['is_real'] == 0){ ?>
                        <span class="hui" style="font-size: .9rem;">未实名认证</span>
                        <?php $credit3 = $person['credit3'];
                            if($credit3 >= 17 && $credit3 <= 20){
                            echo "<img src='/static/images/tpls/lgb/jin.png' alt=''/>";
                        }else if($credit3 > 9 && $credit3 <= 16){
                            echo "<img src='/static/images/tpls/lgb/yin.png' alt=''/>";
                        }else if($credit3 >= 4 && $credit3 <= 9){
                            echo "<img src='/static/images/tpls/lgb/tong.png' alt=''/>";
                        }else{
                            echo "<img src='/static/images/tpls/lgb/wudengji.png' alt=''/>";
                        }
                         } ?>
                        
                    </td>
                </tr>
                <tr>
                    <td>性别：</td>
                    <td><?php if($firms['sex'] == 1){echo '男'; }else if($firms['sex'] == 0){ echo '女'; } ?></td>
                </tr>
                <?php }else if($person['is_co'] == 1){//这是公司类型 ?>
                <tr>
                    <td>类型：</td>
                    <td>公司</td>
                </tr>
                <tr>
                    <td>公司名称：</td>
                    <td>
                        <?php echo $firms['coname']; ?>
                        <img src="/static/images/section/duihao.png" alt="" class="duihao"/>
                        <?php if($person['is_real'] == 1){ ?>
                        <span class="hui" style="font-size: .9rem;">营业执照已认证</span>
                        <img src="/static/images/tpls/lgb/jin.png" alt=""/>
                        <?php }else{echo 222;} ?>
                    </td>
                </tr>
                <tr>
                    <td>规模：</td>
                    <td><?php echo $firms['name']; ?></td>
                </tr>
                <? } ?>
                <tr>
                    <td>服务工种：</td>
                    <td class="serviceType"> 
                    <?php if($person['job_code']){
                        echo  "<span class='red'>".$person['job_name'][$id]."</span> ";
                        foreach($person['job_name'] as $jk => $jv){
                            if($jk == $id){
                                continue;
                            }else{
                                echo "<a href='".site_url("Home/lgdetail/{$jk}")."'>".$jv."</a> ";
                            }
                        }
                    ?>
                    <?php }else{ ?>
                    <span class="red">此工种为快速发布</span>
                    <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>服务区域：</td>
                    <td><?php foreach($person['service_addr'] as $key => $value){ 
                            if($value['areaname']){//判断主要街道有没有值，如果有，输出，如果没有，输出上一级街道
                                echo $value['areaname'].' ';
                            }else{
                                echo $value['distname'].' ';
                            }
                     } ?>
                    </td>
                </tr>
                <tr>
                    <td>大学生零工：</td>
                    <td>
                        <?php 
                            if($person['is_student'] == 1){
                                echo '是';
                            }else if($person['is_student'] == 0){
                                echo '否';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>涉外零工：</td>
                    <td>
                        <?php 
                            if($person['is_for_foreign'] == 1){
                                echo '是';
                            }else if($person['is_for_foreign'] == 0){
                                echo '否';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>上门服务：</td>
                    <td>
                        <?php 
                            if($person['is_onsite_service'] == 1){
                                echo '是';
                            }else if($person['is_onsite_service'] == 0){
                                echo '否';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>联系电话：</td>
                    <td>
                        <span><?php echo $person['mobile']; ?></span>
                        <a href="tel:<?php echo $person['mobile']; ?>"><img src="/static/images/section/3-list/tel.png" alt="" class="tel"/></a>
                    </td>
                </tr>
                <tr>
                    <td>联系地址：</td>
                    <td><?php echo $person['address']; ?></td>
                </tr>
            </table>
        </div>

    </div>
    <div class="introduce">
        <p class="position"><span>零工首页</span></p>
        <div class="module">
            <span class="title">自我简介</span>
            <p class="blank" style="font-size:12px; color:666;"><?php echo $person['info2']; ?></p>
        </div>
        <div class="module">
            <span class="title">服务介绍</span>
            <p class="blank" style="font-size:12px; color:666;"><?php echo $person['info3']; ?></p>
        </div>
                <div class="module">
            <span class="title">联系方式</span>
            <p class="blank" style="font-size:12px; color:666;"><?php echo $person['info4']; ?></p>
        </div>
        <div class="module">
            <span class="title">零工评价</span>
            <p class="blank" style="font-size:12px; color:666;">
            <?php foreach($pl as $pk => $pv){ 
                    $ptime = date('Y-m-d',$pv['addtime']);
                    echo "<b>".$ptime.":</b><br/>";
                    echo $pv['info'].'<br/><br/>';
             } ?>
            </p>
        </div>
    </div>
</section>

<input type='hidden' id='id' value="<?php echo $id; ?>" />
<script type="text/javascript">
    $.ajax({
        url: '<?php echo site_url('home/pv')?>',
        type: "POST",
 //       dataType: 'json',
        data: {id:$("#id").val()},
        cache: false,
        error: function(){
            //alert('pv失败');
        },
        success: function(){
            //alert('pv成功');
        } 
    });
</script>


