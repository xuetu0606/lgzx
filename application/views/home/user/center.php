<link rel="stylesheet" href="/static/css/tpls/lgb.css"/>
<link rel="stylesheet" href="/static/css/tpls/table.css"/>

<section>
    <p class="title">
        <span><?php echo $title; ?></span>
    </p>
    <div class="infor">
        <div class="portrait">
            <a href="/user/personalInfor">
                <img src="<?php echo $user['img']; ?>" alt=""/>
            </a>
        </div>
        <div class="logo">
            <a href="#"><?php echo $user['username']; ?></a>
        </div>
        <div class="message">
            <div class="detail">
                <div>
                    <span><?php echo $user['is_co']==1?$user['coname']:$user['realname']; ?></span>
                    <?php if($user['vip_endtime']){?>
                    <span style="color:#FADA5E;">VIP</span>
                    <span class="hui"><?php echo date('Y-m-d',$user['vip_endtime'])."前有效"?></span>
                    <?php }else{?>
                    <span class="hui">VIP</span>
                    <a href="buyvip" class="right">购买会员></a>
                    <?php } ?>
                </div>
            </div>
            <div class="detail">
                <div>
                    <span>工号：</span>
                    <span><?php echo $user['no']; ?></span>
                </div>
            </div>
            <div class="detail">
                <div>
                    <span>零工币余额：</span>
                    <span><span class="stress"><?php echo $user['credit1']?$user['credit1']:'0'; ?></span>个</span>
                    <a href="recharge" class="right">充值></a>
                </div>
            </div>
            <div class="detail">
                <div>
                    <span>工分余额：</span>
                    <span class="stress"><?php echo $user['credit2']?$user['credit2']:'0'; ?></span>
                    <?php if($user['credit2']){?><a href="/pay/cash" class="right">提现></a><?php }?>
                </div>
            </div>
            <div class="detail">
                <div>
                    <span>实名认证：</span>
                    <?php echo $user['is_real']?'<span>已认证</span>':'<span class="hui">未认证</span><a href="identify" class="stress right">去认证></a>'?>
                </div>
            </div>
            <div class="detail">
                <div>
                    <span>信用等级：</span>
                    <span><img src="<?php echo $user['medal']; ?>" alt=""/></span>
                </div>
            </div>
        </div>
    </div>
    <div class="mine">
        <div class="list">
            <p class="left">
                <a href="<?php echo site_url('user/myinfo'); ?>">
                <img src="/static/images/tpls/lgb/wdzl.png" alt="我的资料"/>
                <span>我的资料</span>
                </a>
            </p>
            <p class="right">
                <a href="<?php echo site_url('pay/myaccount'); ?>">
                <img src="/static/images/tpls/lgb/wdzh.png" alt="我的账户"/>
                <span>我的账户</span>
                </a>
            </p>
        </div>
        <div class="list">
            <p class="left">
                <a href="mypublish">
                <img src="/static/images/tpls/lgb/wdfb.png" alt="我的发布"/>
                <span>我的发布</span>
                </a>
            </p>
            <p class="right">
                <a href="<?php echo site_url('home/contractads'); ?>">
                <img src="/static/images/tpls/lgb/qytg.png" alt="签约推广"/>
                <span>签约推广</span>
                </a>
            </p>
        </div>
        <div class="list">
            <a href="<?php echo site_url('Lista/message'); ?>">
            <p class="left">
                <img src="/static/images/tpls/lgb/xxwj.png" alt="消息文件"/>
                <span>消息文件</span>
            </p>
            </a>

            <a href="<?php echo site_url('Lista/evaluate'); ?>">
            <p class="right">
                <img src="/static/images/tpls/lgb/wdpj.png" alt="我的评价"/>
                <span>评价</span>
            </p>
            </a>
        </div>
        <div class="list">
            <a href="logout"> <input type="button" value="退出"/></a>
        </div>
    </div>

    </div>

</section>