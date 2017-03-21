<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/static/css/common.css"/>
    <link rel="stylesheet" href="/static/css/head-foot.css"/>
    <link rel="stylesheet" href="/static/css/zhaoshang.css"/>
    <link rel="stylesheet" href="/static/css/form.css"/>
    <title>招商</title>
</head>
<body>
<section>
    <div class="head">
        <img src="/static/images/LOGOa.png" alt=""/>
    </div>
</section>
<div class="body">
    <div class="top">
    <span id="dlssq">代理商申请</span>
       <div class="tx" <?= $display ?>>
           <p>请认真填写以下信息，提交后会有专人与您联系
               <img src="/static/images/zhaoshang/xx.png" alt="" class="close"/>
           </p>
		   <!--  -->
           <form action="<?php echo site_url('investment/add');?>" method="get">
            <div class="form-group">
             <div class="form-control">
                 <label><span class="xing">*</span>意向代理城市：</label>
                 <div class="select">
                     <div id="proDiv">
                         <span class="xl"><img src="/static/images/form/xl.png" alt=""/></span>
                             <ul class="list-group" id="province">
                             </ul>
                     </div>
                 </div>
                 <div class="select">
                     <div id="cityDiv">
                         <span class="text"></span>
                         <span class="xl"><img src="/static/images/form/xl.png" alt=""/></span>
                         <ul class="list-group" id="city">
                         </ul>
                     </div>
                 </div>
				<input type="hidden" name="province" id="pro_id" value="">
				<input type="hidden" name="city" id="city_id" value="1">
             </div>
            </div>
            <div class="form-group">
                   <div class="form-control">
                       <label><span class="xing">*</span>公司全称：</label>
                       <input name="name" type="text" value="<?= $_SESSION['name'] ?>" class="input-normal" required="required"/><span class="xing"><font color="#FF0000"><?= $name_error ?></font></span>
                   </div>
               </div>
            <div class="form-group">
                   <div class="form-control">
                       <label><span class="xing">*</span>公司联系人：</label>
                       <input name="contact" type="text" value="<?= $_SESSION['contact'] ?>" class="input-normal" required="required"/><span class="xing"><font color="#FF0000"><?= $contact_error ?></font></span>
                   </div>
               </div>
            <div class="form-group">
                   <div class="form-control">
                       <label><span class="xing">*</span>公司联系电话：</label>
                       <input name="phone" type="tel" value="<?= $_SESSION['phone'] ?>" class="input-normal" required="required"/><span class="xing"><font color="#FF0000"><?= $phone_error ?></font></span>
                   </div>
               </div>
            <div class="form-group">
                   <div class="form-control">
                       <label><span class="xing">*</span>公司邮箱：</label>
                       <input name="mailbox" type="text" value="<?= $_SESSION['mailbox'] ?>" class="input-normal" required="required"/><span class="xing"><font color="#FF0000"><?= $mailbox_error ?></font></span>
                   </div>
               </div>
            <div class="form-group">
                   <div class="form-control">
                       <label><span class="xing">*</span>公司地址：</label>
                       <input name="address" type="text" value="<?= $_SESSION['address'] ?>" class="input-normal" required="required"/>
                   </div>
               </div>
            <div class="form-group">
                   <div class="form-control">
                       <label>公司主营业务：</label>
                       <input name="profession" type="text" value="<?= $_SESSION['profession'] ?>" class="input-normal"/>
                   </div>
               </div>
            <div class="form-group">
                   <div class="form-control">
                       <label></label>
                       <input type="submit" class="btn btn-primary" required="required"/>
                   </div>
               </div>
           </form>
       </div>

    </div>
    <div class="bottom">
        <img src="/static/images/zhaoshang/xm.png" alt=""/>
    </div>
</div>
<footer>
    <div class="main">
        <ul>
            <li><a href="#">法律声明 |</a></li>
            <li><a href="#">零工宝 |</a></li>
            <li><a href="#">零工小参 |</a></li>
            <li><a href="#">招贤纳士 |</a></li>
            <li><a href="#">关注微博</a></li>
        </ul>
        <p>Copyright © 2016 lg-zx.com Corporation, All Rights Reserved 鲁ICP备16012134号-1 站长统计</p>
    </div>
</footer>
</body>
<script src="/static/js/jquery.js"></script>
<script src="/static/js/zhaoshang.js"></script>
<!--<script src="/static/js/city.js"></script>-->
<?php
	echo '<script>';
	echo $js;
	echo '</script>';
?>
</html>