<link rel="stylesheet" href="/static/css/lgb/myinfor.css"/>
<link rel="stylesheet" href="/static/css/lgb/title.css"/>
<section>
    <p class="title">
        <a href="<?php echo site_url('user/center'); ?>"><</a>
        <span>个人信息</span>
    </p>
    <p class="location">
        <a href="<?php echo site_url('user/updateinfo'); ?>">基本资料
        <span class='right'>></span></a>
    </p>
    <table>
        <tr>
            <td>注册地</td>
            <td><?php echo $info['province']; echo $info['city'];  ?></td>
        </tr>
        <?php if($_SESSION['is_co'] == 1){ ?>
        <tr>
            <td>公司名称</td>
            <td><?php echo $info['coname']; ?></td>
        </tr>
        <tr>
            <td>规模</td>
            <td><?php echo $info['scale']; ?></td>
        </tr>
        <?php }else{ ?>
        <tr>
            <td>姓名</td>
            <td><?php echo $info['realname']; ?></td>
        </tr>
        <tr>
            <td>性别</td>
            <td>
            <?php
                if($info['sex'] == 1){
                    echo '男';
                }elseif($info['sex'] == 2){
                    echo '女';
                }
            ?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td>手机号</td>
            <td><?php echo $info['mobile']; ?></td>
        </tr>
        <tr>
            <td>微信号</td>
            <td><?php echo $info['wechat']; ?></td>
        </tr>
        <tr>
            <td>QQ号</td>
            <td><?php echo $info['qq']; ?></td>
        </tr>
        <?php if($_SESSION['is_co'] == 1){ ?>
        <tr>
            <td>公司简介</td>
            <td><?php echo $info['info']; ?></td>
        </tr>
        <?php }else{ ?>
        <tr>
            <td>我的简介</td>
            <td><?php echo $info['info']; ?></td>
        </tr>
        <?php } ?>
    </table>
    <div class="modify">
        <ul>
            <li>
                <a href="<?php echo site_url('user/identify'); ?>"><span>实名认证</span>
                <span class='right'>></span></a>
            </li>
            <li>
               <a href="<?php echo site_url('user/updatepasswd'); ?>"><span>密码修改</span>
                <span class='right'>></span></a>
            </li>
        </ul>
    </div>
</section>
<script src="/static/js/jquery.js"></script>

