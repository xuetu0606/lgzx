<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>招零工</title>
    <link rel="stylesheet" href="/static/css/common.css"/>
    <link rel="stylesheet" href="/static/css/head-foot.css"/>
    <link rel="stylesheet" href="/static/css/workInfor.css"/>
    <link rel="stylesheet" href="/static/css/form.css"/>
</head>
<body>
<header>
    <div class="main">
        <div class="city">
            <span class="stress">青岛</span>
            <a href="切换城市.html">[切换城市]</a>
        </div>
        <div class="fr">
            <ul>
                <li><a href="javascript:void(0);">注册</a></li>
                <li><a href="javascript:void(0);">登录</a></li>
                <li class="lgbxl"><a href="javascript:void(0);">零工宝</a><img src="/static/images/xiala.png" alt=""/></li>
                <li class="stress wxb">微信版</li>
                <li><a href="javascript:void(0);" class="stress">手机版</a></li>
                <li><a href="javascript:void(0);">帮助</a></li>
            </ul>
            <div class="lgb">
                <a href="javascript:void(0);">零工宝<img src="/static/images/xiala.png" alt="" /></a>
                <a href="javascript:void(0);" class="lgba">我的发布</a>
                <a href="javascript:void(0);" class="lgba">我的收藏</a>
                <a href="javascript:void(0);" class="lgba">我的资料</a>
            </div>
            <div class="wx">
                <img src="/static/images/head-foot/weixin.png" alt=""/>
            </div>
        </div>
    </div>

</header>
<div class="full">
    <div class="main">
        <img src="/static/images/LOGOa.png" alt="" class="logo"/>
        <a href="javascript:void(0);" style="position: relative;width: 200px;left: 720px;">免费发布招零工信息</a>
    </div>
</div>
<section>
    <div class="position">
        <span>青岛零工在线</span>
        <span> > </span>
        <span>招零工</span>
    </div>
    <div class="main">
        <div class="conditions">
            <div class="type fenlei">
                <span>分类：</span>
                <ul>
                    <li><a href="javascript:void(0);" id="job" name="0" onclick="next(this);">不限</a></li>
                    <?php 
                        foreach($job_type as $item){
                            if($item['level'] == 1){
                                echo '<li><a href="javascript:void(0);" id="job" name="'.$item['id'].'" onclick="next(this);">'.$item['name'].'</a></li>';
                            }
                        }
                    ?>
                </ul>
            </div>
            <?php 
                foreach($job_type as $item){
                    if($item['level'] == 1){
                        echo
                        '<div class="type zhiye" id="'.$item['id'].'">
                            <span>职业：</span>
                            <ul>
                                <li><a href="javascript:void(0);" id="job" name="0" onclick="next(this);">不限</a></li>';
                                foreach($job_type as $item2){
                                    if($item2['pre_id'] == $item['id']){
                                        echo '<li><a href="javascript:void(0);" id="job" name="'.$item2['id'].'" onclick="next(this);">'.$item2['name'].'</a></li>';
                                    }
                                }
                        echo
                            '</ul>
                        </div>';
                    }
                }
                foreach($job_type as $item){
                    if($item['level'] == 2){
                        echo
                        '<div class="type gongzhong" id="'.$item['id'].'">
                            <span>工种：</span>
                            <ul>
                                <li><a href="javascript:void(0);" id="job" name="0" onclick="next(this);">不限</a></li>';
                                foreach($job_type as $item2){
                                    if($item2['pre_id'] == $item['id']){
                                        echo '<li><a href="javascript:void(0);" id="job" name="'.$item2['id'].'" onclick="next(this);">'.$item2['name'].'</a></li>';
                                    }
                                }
                        echo
                            '</ul>
                        </div>';
                    }
                }
            ?>
            <div class="type quyu">
                <span>区域：</span>
                <ul>
                    <li><a href="javascript:void(0);" id="quyu" name="0" onclick="next(this);">不限</a></li>
                    <?php 
                        foreach($area as $item){
                                echo 
                                '<li><a href="javascript:void(0);" id="quyu" name="'.$item['id'].'" onclick="next(this);">'.$item['name'].'</a></li>';
                        }
                    ?>
                </ul>
            </div>
            <div class="type dizhi">
                <a href="javascript:void(0);">冠县路</a>
                <a href="javascript:void(0);">冠县路</a>
                <a href="javascript:void(0);">冠县路</a>
                <a href="javascript:void(0);">冠县路</a>
            </div>
            <div class="type xinzi">
                <span>工资：</span>
                <ul>
                    <li><a href="javascript:void(0);" id="gongzi" name="0" onclick="next(this);">不限</a></li>
                    <li><a href="javascript:void(0);" id="gongzi" name="50" onclick="next(this);">50元以下/天（次、时）</a></li>
                    <li><a href="javascript:void(0);" id="gongzi" name="100" onclick="next(this);">50-100元以下/天（次、时）</a></li>
                    <li><a href="javascript:void(0);" id="gongzi" name="num" onclick="next(this);">100元以上/天（次、时）</a></li>
                    &nbsp;
                    &nbsp;
                    <form action="" style="display:inline-block;">
                        自定义
                        <input type="text" class="input-normal" style="width: 60px;height: 26px;"/>
                        ~
                        <input type="text" class="input-normal" style="width: 60px;height: 26px;"/>
                        元/天（次、时）
                        &nbsp;&nbsp;
                        <input type="submit" value="">
                    </form>

                </ul>
            </div>
            <div class="type jiesuan">
                <span>结算：</span>
                <ul>
                    <li><a href="javascript:void(0);" id="jiesuan" name="0" onclick="next(this);">不限</a></li>
                    <?php
                        foreach($pay_circle as $item){
                            echo 
                                '<li><a href="javascript:void(0);" id="jiesuan" name="'.$item['id'].'" onclick="next(this);">'.$item['name'].'</a></li>';
                        }
                    ?>
                </ul>
            </div>
            <div class="type sgz">
                <form action="" style="
        border-right: none;
        border-bottom-right-radius: 0px;
        border-top-right-radius: 0;
        padding-right: 10px;">
                    <form action="">
                        <div class="form-control"> <input type="text" placeholder="搜工作" class="input-normal"/>
                            <input type="submit" value="" class="fdj" /></div>
                    </form>
                </form>
            </div>
        </div>
        <div class="middle">
            <form action="">
                <div class="select">
                    <div id="time">
                        <span class="fbsj">发布时间</span>
                        <span class="xl"><img src="/static/images/form/xl.png" alt="" class="timejt"/></span>
                        <ul class="list-group">
                            <a href='javascript:void(0);' class='list-group-item citya' id="fbsj" name="3" onclick="next(this);">三天内</a>
                            <a href='javascript:void(0);' class='list-group-item citya' id="fbsj" name="7" onclick="next(this);">一周内</a>
                            <a href='javascript:void(0);' class='list-group-item citya' id="fbsj" name="31" onclick="next(this);">一月内</a>
                            <a href='javascript:void(0);' class='list-group-item citya' id="fbsj" name="0" onclick="next(this);">全部时间</a>
                        </ul>
                    </div>
                </div>
                <div class="marginr">
                    <input type="checkbox" id="renzheng" name="1" onclick="next(this);"/>  <span class="xz">认证</span>
                </div>
                <div class="marginr">
                    <input type="checkbox" id="xinyong" name="1" onclick="next(this);"/>  <span class="xz">按信用等级排序</span>
                </div>
            </form>
        </div>
        <div class="information">
            <?php foreach($beckons as $item):?>
                <div class="type">
                    <img src="<?= $item['coimg'] ?>" alt="" class="tx"/>
                    <div class="jieshao">
                        <div class="line1">
                            <a href="javascript:void(0);" class="name"><?= $item['title'] ?></a>
                            <span class="vip">
                                <?php
                                    if($item['vip'] == 1){
                                        echo '<img src="/static/images/vip/vip1.png" alt=""/>';
                                    }
                                ?>
                            </span>
                            <span class="identify">
                                <?php  
                                    if($item['flag'] == 1){
                                        echo '<img src="/static/images/renzheng/yingyezhiz.png" alt=""/>';
                                    }
                                ?>
                            </span>
                        </div>
                        <span class="address"><?= $item['aera'] ?> - <?= $item['address'] ?></span>
                        <div class="line3">
                            <span class="gs"><?= $item['coname'] ?></span>
                            <span class="sj"><?= date('Y-m-d H:i:s',$item['addtime']) ?></span>
                        </div>
                    </div>
                    <span class="tel"><?= $item['mobile'] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="fenye">
        <a href="javascript:void(0);">1</a>
        <a href="javascript:void(0);">2</a>
        <a href="javascript:void(0);">3</a>
        <a href="javascript:void(0);">4</a>
        <a href="javascript:void(0);">5</a>
        <a href="javascript:void(0);">6</a>
        <a href="javascript:void(0);">7</a>
        <a href="javascript:void(0);">8</a>
        <a href="javascript:void(0);">9</a>
        <a href="javascript:void(0);">10</a>
        <a href="javascript:void(0);">下一页</a>
    </div>
</section>
<footer>
    <div class="main">
        <ul>
            <li><a href="javascript:void(0);">法律声明 |</a></li>
            <li><a href="javascript:void(0);">零工宝 |</a></li>
            <li><a href="javascript:void(0);">零工小参 |</a></li>
            <li><a href="javascript:void(0);">招贤纳士 |</a></li>
            <li><a href="javascript:void(0);">关注微博</a></li>
        </ul>
        <p>Copyright © 2016 lg-zx.com Corporation, All Rights Reserved 鲁ICP备16012134号-1 站长统计</p>
    </div>
</footer>
</body>
<script src="/static/js/jquery.js"></script>
<script src="/static/js/head-foot.js"></script>
<script src="/static/js/workInfor1.js"></script>
<script type="text/javascript">
    function next(obj){
        console.log(obj);
        $.get('<?php echo site_url('beckon/getBeckonsByParam'); ?>/'+obj.id+'/'+obj.name, function(str){
            console.log(str);
        });
    }
</script>
</html>