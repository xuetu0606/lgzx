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
<section>
    <p class="title">
        <a href="<?php echo site_url('user/center'); ?>"><</a>
        <span>消息文件</span>
    </p>
   <div class="notice">
      <p class="notice-top">
          <span class="active">公告</span>
          <span class="static">通知</span>
      </p>
       <form action='delete' method='POST'>
       <ul>
       <?php //var_dump($get_message);
          date_default_timezone_set('PRC');
          foreach($get_message as $key => $value){ 
            if($value['flag'] != -1){
        ?>     
           <li >
               <input type="checkbox" name="<?php echo $value['id']; ?>" class="check-box" />
               <div class="check check-div"></div>
               <a href="<?php echo site_url('lista/messageContent/'.$value['id']); ?>">
                   <span class="content"><?php echo mb_substr($value['title'],0,13); ?></span>
                   <span class="right hui"> ></span>
                   <span class="date right"><?php echo date("m-d",$value['addtime']); ?></span>
               </a>
           </li>
          
        <?php }} ?>
       </ul>
       <?php if($get_message){ ?>
       <div class="button">
           <input type="button" value="全选" id="check-all"/>
           <input type="submit" value="删除" class="right" id="delete"/>
       </div> <?php }else{ ?>
            <p id='cent'>
              <img src="/static/images/section/bkx.png" alt=""/>
              <span>暂无数据</span>
            </p>
            <?php } ?>
       </form>
   </div>
</section>

