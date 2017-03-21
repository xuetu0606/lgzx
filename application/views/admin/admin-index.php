<link rel="stylesheet" href="/static/css/lgb/title.css"/>
<link rel="stylesheet" href="/static/css/lgb/message-file.css"/>
<script src="/static/js/agree.js"></script>
<script src="/static/js/message-file.js"></script>
<style>
   /* html body footer{
        position: absolute;
        bottom: .02rem;
    }*/
    #cent{
      position:relative;
      left:40%;
    }
</style>
<style>
body{overflow-x:hidden; background:#f2f0f5; padding:15px 0px 10px 5px;}
#searchmain{ font-size:12px;}
#search{ font-size:12px; background:#548fc9; margin:10px 10px 0 0; display:inline; width:100%; color:#FFF}
#search form span{height:40px; line-height:40px; padding:0 0px 0 10px; float:left;}
#search form input.text-word{height:24px; line-height:24px; width:180px; margin:8px 0 6px 0; padding:0 0px 0 10px; float:left; border:1px solid #FFF;}
#search form input.text-but{height:24px; line-height:24px; width:55px; background:url(images/main/list_input.jpg) no-repeat left top; border:none; cursor:pointer; font-family:"Microsoft YaHei","Tahoma","Arial",'宋体'; color:#666; float:left; margin:8px 0 0 6px; display:inline;}
#search a.add{ background:url(images/main/add.jpg) no-repeat 0px 6px; padding:0 10px 0 26px; height:40px; line-height:40px; font-size:14px; font-weight:bold; color:#FFF}
#search a:hover.add{ text-decoration:underline; color:#d2e9ff;}
#main-tab{ border:1px solid #eaeaea; background:#FFF; font-size:12px;}
#main-tab th{ font-size:12px; background:url(images/main/list_bg.jpg) repeat-x; height:32px; line-height:32px;}
#main-tab td{ font-size:12px; line-height:40px;}
#main-tab td a{ font-size:12px; color:#548fc9;}
#main-tab td a:hover{color:#565656; text-decoration:underline;}
.bordertop{ border-top:1px solid #ebebeb}
.borderright{ border-right:1px solid #ebebeb}
.borderbottom{ border-bottom:1px solid #ebebeb}
.borderleft{ border-left:1px solid #ebebeb}
.gray{ color:#dbdbdb;}
td.fenye{ padding:10px 0 0 0; text-align:right;}
.bggray{ background:#f9f9f9}
#addinfo{ padding:0 0 10px 0;}
</style>
<section>
    <p class="title">
        <a href="<?php echo site_url('home/index'); ?>"><<</a>
        <span>后台首页</span>
    </p>
<!--main_top-->
<table width="99%" border="0" cellspacing="0" cellpadding="0" id="searchmain">
  <tr>
    <td width="99%" align="left" valign="top" id="addinfo">您的位置：审核用户认证信息</td>
  </tr>
  <tr>
    <td align="left" valign="top">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="main-tab">
      <tr>
        <th align="center" valign="middle" class="borderright">用户id</th>
      <th align="center" valign="middle" class="borderright">用户名</th>
        <th align="center" valign="middle" class="borderright">手机</th>
        <th align="center" valign="middle">注册时间</th>
      </tr>
      <?php foreach($reallist as $key => $value){ ?>
        <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
          <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['uid']; ?></td>
          <!-- <a href="<?php //echo site_url('admin/userinfo'); ?>" target="mainFrame" onFocus="this.blur()" class="add"> -->
          <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['username']; ?></td><!-- </a> -->
          <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['mobile']; ?></td>
          <td align="center" valign="middle" class="borderright borderbottom">
          <?php 
            date_default_timezone_set('PRC'); 
            echo date('Y-m-d',$value['addtime']); 
          ?><a href="<?php echo site_url('admin/userinfo/'.$value['uid'].'/'.$value['is_co'].'/'.$value['city_id']); ?>" target="mainFrame" onFocus="this.blur()" class="add">查看</a></td>
        </tr>
      
      <?php } ?>
    </table></td>
  </tr>
 <!--  <tr>
   <td align="left" valign="top" class="fenye">11 条数据 1/1 页&nbsp;&nbsp;<a href="#" target="mainFrame" onFocus="this.blur()">首页</a>&nbsp;&nbsp;<a href="#" target="mainFrame" onFocus="this.blur()">上一页</a>&nbsp;&nbsp;<a href="#" target="mainFrame" onFocus="this.blur()">下一页</a>&nbsp;&nbsp;<a href="#" target="mainFrame" onFocus="this.blur()">尾页</a></td>
 </tr> -->
</table>
</section>






