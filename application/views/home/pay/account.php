<link rel="stylesheet" href="/static/css/lgb/title.css"/>
<link rel="stylesheet" href="/static/css/lgb/account.css"/>
<link rel="stylesheet" href="/static/css/tpls/table.css"/>
<link rel="stylesheet" href="/static/css/nodata.css"/>
<style>
    html body footer{
        position: absolute;
        bottom: .02rem;
    }
</style>
<section><?php //var_dump($itemstype); ?>
    <p class="title">
        <a href="<?php echo site_url('user/center'); ?>"><</a>
        <span>我的账户</span>
    </p>
    <div class="balance">
        <p>
            <span>零工币余额&nbsp;</span>
            <span class="red"><?php echo $credit['credit1']; ?></span>
            <a href="<?php echo site_url('user/recharge'); ?>" class="blue right">充值></a>
        </p>
        <p>
            <span>工分余额&nbsp;</span>
            <span class="red"><?php echo $credit['credit2']; ?></span>
            <a href="<?php echo site_url('user/exchange'); ?>" class="blue right">兑换></a>
        </p>
    </div>
    <div class="detail">
        <a href="<?php echo site_url('pay/myaccount/1'); ?>">
        
            <img src="/static/images/tpls/lgb/account/chzh2.png" alt="" class="previous" <?php if($itemstype==1){?>style="display: inline-block;"<?php }else{?>style="display: none;"<?php }?>/>
            <img src="/static/images/tpls/lgb/account/chzh1.png" alt="" class="current" <?php if($itemstype==1){?>style="display: none"<?php }else{?>style="display: inline-block;"<?php }?>/>
            <span>充值明细</span>
        </a>
        <a href="<?php echo site_url('pay/myaccount/2'); ?>">
            <img src="/static/images/tpls/lgb/account/xf1.png" alt=""  class="current" <?php if($itemstype==2){?>style="display: none"<?php }else{?>style="display: inline-block;"<?php }?>/>
            <img src="/static/images/tpls/lgb/account/xf2.png" alt=""  class="previous" <?php if($itemstype==2){?>style="display: inline-block;"<?php }else{?>style="display: none;"<?php }?>/>
            <span>消费明细</span>
        </a>
        <a href="<?php echo site_url('pay/myaccount/3'); ?>">
            <img src="/static/images/tpls/lgb/account/sy1.png" alt=""  class="current" <?php if($itemstype==3){?>style="display: none"<?php }else{?>style="display: inline-block;"<?php }?>/>
            <img src="/static/images/tpls/lgb/account/sy2.png" alt=""  class="previous" <?php if($itemstype==3){?>style="display: inline-block;"<?php }else{?>style="display: none;"<?php }?>/>

            <span>收益明细</span>
        </a>
    </div>
 <!--    <div class="search">
        <span>按时间查找</span>
        <input type="text" placeholder="起始时间" class="hui"/>
        <span class="hui">-</span>
        <input type="text" placeholder="结束时间" class="hui"/>
        <input type="button" value="查询"/>
    </div> -->
 	<?php if($items){?>
    <table cellspacing="0" id="chzh">
        <thead>
        <tr>
            <th>科目</th>
            <th>备注</th>
            <th>日期</th>
            <th id="kind">
            <?php 
                if($itemstype == 2){
                    echo '支';
                }else if($itemstype == 3){
                    echo '收';
                }else{
                    echo '充';
                }
            ?>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($items as $key => $value){ ?>
        <tr>
            <td><?php echo $value['way_name']; ?></td>
            <td><?php echo $value['info']; ?></td>
            <td>
                <?php 
                    date_default_timezone_set('PRC'); 
                    echo date('Y-m-d',$value['addtime']); 
                ?>
            </td>
            <td><?php echo $value['credits'];echo $value['type_name']; ?></td>
        </tr>
        <?php } ?>
         
<!--         <tr>
            <td colspan="3">合计</td>
            <td>200</td>
        </tr> -->
        </tbody>
    </table>
    <?php }else{?>
    <div class="nodata">
            <p>
                <img src="/static/images/section/bkx.png" alt="">
                <span>暂无该项明细数据</span>
            </p>

            </div>
    <?php }?>
</section>
<script src="/static/js/account.js"></script>
