<link rel="stylesheet" href="/static/css/4-details.css"/>
<section>
    <div class="head">
        <img src="/static/images/section/4-details/little.jpg" alt=""/>
        <span>用户实名认证信息详情页</span>
    </div>
    <div class="infor">
        <div class="intro">
            <div class="portrait">
            <?php if($is_co == 1){ ?>
                <img src="/upload/<?php echo $pinyin['pinyin']; ?>/gssm/<?php echo $detail['idno_img']; ?>" alt="" class="img1"/>
            <?php }else{ ?>
                <img src="/upload/<?php echo $pinyin['pinyin']; ?>/grsm/<?php echo $detail['idno_img']; ?>" alt="" class="img1"/>
            <?php } ?>
            </div>
             <p><?php echo $detail['info']; ?></p> 

        </div>

        <p class="line"></p>
        <div class="txt">
            <table>
                <tr>
                    <td>用户id：</td>
                    <td><?php echo $detail['uid']; ?></td>
                </tr>
                <tr>
                    <td>证件号：</td>
                    <td><?php echo $detail['idno']; ?></td>
                </tr>
                <?php if($is_co == 1){ ?>
                <tr>
                    <td>公司名：</td>
                    <td><?php echo $detail['coname']; ?></td>
                </tr>
                <?php }else{ ?>
                <tr>
                    <td>真实姓名：</td>
                    <td><?php echo $detail['realname']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <form action='<?php echo site_url("admin/check"); ?>' method='POST'>
            <input type="hidden" name="uid" value="<?php echo $detail['uid']; ?>">
            <input type="submit" name="check" value='同意'>
            <input type="submit" name="check" value='不同意'>
        </form>
    </div>
</section>