<link rel="stylesheet" href="/static/css/lgb/publish.css"/>
<link rel="stylesheet" href="/static/css/lgb/title.css">
<link rel="stylesheet" href="/static/css/tpls/table.css">
<section>
    <p class="title">
        <a href="<?php echo site_url('user/center'); ?>"><</a>
        <span>我的评价</span>
    </p>
    <table cellspacing="0">
        <thead>
        <tr>
            <th style="width:70px">评价时间</th>
            <th style="width:70px">评价分数</th>
            <th>评价内容</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($result as $key => $value){              if(!$value['credits']){ 
                    continue;
                }?>
        <tr>
            <td>
            <?php 
                date_default_timezone_set('PRC'); 
                echo date('Y-m-d',$value['addtime']); 
            ?>
            </td>
            <td style="text-align:center"><?php echo $value['credits']; ?></td>
            <td><?php if($value['info']){ echo $value['info']; }else{ echo "<span style='color:#E5E5E5'>此人很懒，并没有对您评价什么。</span>"; } ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</section>