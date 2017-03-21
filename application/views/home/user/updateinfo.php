<link rel="stylesheet" href="/static/css/lgb/title.css"/>
<link rel="stylesheet" href="/static/css/lgb/alterBaseDate.css"/>

<section>
    <p class="title">
        <a href="<?php echo site_url('user/myinfo'); ?>"><</a>
        <span>基本资料</span>
    </p>

    <form action="<?php echo site_url('user/doupdateinfo'); ?>" method='POST'>
        <div>
            <span class="name">注册地</span>
            <span><?php echo $info['province']; echo $info['city']; ?></span>
        </div>
        <?php if($_SESSION['is_co'] == 1){ ?>
        <div>
            <span class="name">公司名称</span>
            <input type="text" value="<?php echo $info['coname']; ?>" name='coname' <?php if($info['coname']){echo 'disabled="disabled";';}?> />

        </div>
        <div>
            <span class="red">*</span>
            <span class="name">规模</span>
            <select name="scale">
            <?php
                foreach($scale as $key => $value){ ?>
                <option value="<?php echo $key + 1; ?>"><?php echo $value['name']; ?></option>
            <?php } ?>
            </select>
        </div>
        <?php }else{ ?>
        <div>
            <span class="name">姓名</span>
            <input type="text" value="<?php echo $info['realname']; ?>" name='realname' <?php if($info['realname']){echo 'disabled="disabled";';}?> />
        </div>
        <div>
            <span class="red">*</span>
            <span class="name">性别</span>
            <select name="sex">
                <option value="1">男</option>
                <option value="2">女</option>
            </select>
        </div>
        <?php } ?>
        <div>
            <span class="name">手机号</span>
            <span><?php echo $info['mobile']; ?></span>
        </div>
        <div class="summary">
            <span class="red">*</span>
            <span class="name">联系地址</span>
            <textarea name="address" cols="30" rows="6" placeholder="详细地址"><?php echo $info['address']; ?></textarea>
        </div>
        <div>
            <span class="red">*</span>
            <span class="name">微信号</span>
            <input type="text" name='wechat' value="<?php echo $info['wechat']; ?>" />
        </div>
        <div>
            <span class="red">*</span>
            <span class="name">QQ号</span>
            <input type="text" name='qq' value="<?php echo $info['qq']; ?>"/>
        </div>
        <div class="summary">
            <span class="red">*</span>
            <span class="name">
            <?php 
                if($_SESSION['is_co'] == 1){ 
                    echo '公司简介'; 
                }else{ echo '我的简介'; } 
            ?>
            </span>
            <textarea name="info" cols="30" rows="6" class="summaryNum"><?php echo $info['info']; ?></textarea>
            <span class="number"><span class="currentNum">200</span>/200</span>
        </div>
        <div class="button">
            <input type="submit" value="保存"/>
            <a href="<?php echo site_url('user/myinfo'); ?>">关闭</a>
        </div>
        <p style="color:red; position:absolute; left:30%;"><?php echo $error; ?></p>
        <div class="right">
            <span class="red">注 * </span>
            <span>为必填项</span>
        </div>
    </form>
</section>
<script src="/static/js/limitNum.js"></script>
