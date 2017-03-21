<link rel="stylesheet" href="/static/css/lgb/publish.css"/>
<link rel="stylesheet" href="/static/css/lgb/title.css">
<link rel="stylesheet" href="/static/css/tpls/table.css">
<section>
    <p class="title">
        <a href="<?php echo site_url('user/center'); ?>"><</a>
        <span>我的发布</span>
    </p>
    <p class="servicetype">
        <span>服务工种</span>
        <a href="publish" class="fb right">
            <img src="/static/images/tpls/lgb/fb.png" alt=""/>
            <span>发布</span>
        </a>
    </p>
    <table cellspacing="0">
        <thead>
        <tr>
            <th width="10%">城市</th>
            <th>服务内容</th>
            <th>时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
<?php foreach ($gong as $k){?>
        <tr>
            <td><?php echo $k['name']?></td>
            <td><?php echo $k['info1']?></td>
            <td><?php echo $k['flushtime']?date("Y-m-d",$k['flushtime']):date("Y-m-d",$k['addtime'])?></td>
            <td>
                <a href="<?php echo site_url('user/dealMyInfo/type/gz/ac/flush/id/'.$k['id'])?>" >刷新</a>
                <a href="publish/edit/<?php echo $k['id']?>" >修改</a>
                <a href="javascript:void(0);" onclick="if(confirm('确定要删除吗？')){window.location.href='<?php echo site_url('user/dealMyInfo/type/gz/ac/del/id/'.$k['id'])?>';}else{return false;}">删除</a>
            </td>
        </tr>
<?php }?>
        </tbody>
    </table>
    <?php if ($_SESSION['is_co']){ ?>
    <p class="servicetype">
        <span>招零工</span>
        <a href="recruit" class="fb right">
            <img src="/static/images/tpls/lgb/fb.png" alt=""/>
            <span>发布</span>
        </a>
    </p>
    <table cellspacing="0">
        <thead>
        <tr>
            <th width="10%">城市</th>
            <th>标题</th>
            <th>时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($zlg as $k){?>
            <tr>
                <td><?php echo $k['name']?></td>
                <td><?php echo $k['title']?></td>
                <td><?php echo $k['flushtime']?date("Y-m-d",$k['flushtime']):date("Y-m-d",$k['addtime'])?></td>
                <td>
                    <a href="<?php echo site_url('user/dealMyInfo/type/zlg/ac/flush/id/'.$k['id'])?>" >刷新</a>
                    <a href="recruit/edit/<?php echo $k['id']?>">修改</a>
                    <a href="javascript:void(0);" onclick="if(confirm('确定要删除吗？')){window.location.href='<?php echo site_url('user/dealMyInfo/type/zlg/ac/flush/id/'.$k['id'])?>';}else{return false;}" >删除</a>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
    <?php }?>
</section>
