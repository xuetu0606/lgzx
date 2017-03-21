<link rel="stylesheet" href="/static/css/lgb/publish.css"/>
<link rel="stylesheet" href="/static/css/lgb/title.css">
<link rel="stylesheet" href="/static/css/tpls/table.css">
<section>
    <p class="title">
        <a href="<?php echo site_url('user/center'); ?>"><</a>
        <span>签约收益列表</span>
    </p>
    <table cellspacing="0">
        <thead>
        <tr>
            <th>被推荐人工号</th>
            <th>注册时间</th>
            <th>服务名称</th>
            <th>服务购买时间</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($arr2 as $key => $value){ ?>
        <tr>
            <td><?php echo $value['no']; ?></td>
            <td>
            <?php 
                date_default_timezone_set('PRC'); 
                echo date('Y-m-d',$value['useraddtime']); 
            ?>
            </td>
            <td><?php echo $value['name']; ?>VIP</td>
            <td><?php 
                date_default_timezone_set('PRC'); 
                echo date('Y-m-d',$value['serviceaddtime']); 
                ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</section>