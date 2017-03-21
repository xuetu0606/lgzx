<?php var_dump($lists);  ?>
<link rel="stylesheet" href="/static/css/shouye.css"/>
<div class="hiddenHeader">
    <div class="hiddenSearchP">
        <div class="logo">
            <img src="/static/images/LOGO.png" alt=""/>
        </div>
        <form action="#" method="" class="formsousuo">
            <div class="search">
                <input type="text" placeholder="输入工种或关键字" class="sousuo"/>
                <a class="sousuo">
                    <img src="/static/images/shouye/fangdajing.png" alt=""/>
                </a>
            </div>

        </form>
        <a href="#" class="fabu">免费发布信息</a>
    </div>
</div>
<section>
    <div class="head">
        <div class="invest">
            <img src="/static/images/shouye/zhaoshang.png" alt=""/>
        </div>
        <div class="logoSearchP">
            <div class="logo">
                <img src="/static/images/shouye/LOGOa.png" alt=""/>
                <span>一个专业的分类信息网站</span>
            </div>
            <form action="<?php echo site_url('Listlg/lgsearch'); ?>" method="POST" class="formsousuo">
            <div class="search">
                <input type="text" placeholder="输入工种或关键字" class="sousuo" name='search'/>
                <a class="sousuo">搜索</a>
                <ul>
                    <li class="stress">热门搜索：</li>
                    <li><a href="#">月嫂</a></li>
                    <li><a href="#">保姆</a></li>
                    <li><a href="#">家庭装修</a></li>
                    <li><a href="#">外卖</a></li>
                </ul>
            </div>

            </form>
            <div class="publish">
                <a href="#" class="fabu">免费发布信息</a>
                <a href="#" class="xiugai">修改/删除信息</a>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="/" class="active">首页</a></li>
                <li><a href="<?php echo site_url('listlg/index/news'); ?>">最新发布</a></li>
                <?php foreach($first_level as $key => $value){//循环遍历出来7个一级分类 ?>
                <li><a href="<?php echo site_url('listlg/index/l1/'.$key); ?>"><?php echo $value['name']; ?></a></li>
                <?php } ?>
                <li><a href="<?php echo site_url('listlg/index/student'); ?>">大学生专栏</a></li>
                <li><a href="#">招零工</a></li>
            </ul>
        </nav>
    </div>
    <div class="body">
        <div class="main main1">
        <?php $i=1; foreach($lists as $key_one => $value){//遍历三级二级一级分类列表 

        ?>
            <div class="demo">
                <p class="h1"><a href="<?php echo site_url('listlg/index/l1/'.$key_one); ?>"><?php echo $value['name']; //一级分类 *****?></a></p>
                
                    <?php foreach($value['sub'] as $key => $val){ ?>
                <div class="type">
                    
                    <?php if($val['name'] == '其他'){ //二级分类 ****?>
                    <div class="h2">
                        <span><a href="<?php echo site_url('listlg/index/l1/'.$key_one.'/l2/'.$key); ?>"><?php echo $val['name']; ?></a></span>
                    </div>
                   <?php }else{ ?>
                   <div class="h2">
                        <span><a href="<?php echo site_url('listlg/index/l1/'.$key_one.'/l2/'.$key); ?>"><?php echo $val['name']; ?></a></span>
                        <a href="<?php echo site_url('listlg/index/l1/'.$key_one.'/l2/'.$key); ?>"><img src="/static/images/shouye/<?php echo $key; ?>.png" alt=""/></a>
                    </div>
                    <div class="h3">
                        <ul>
                        <?php $a = 0; 
                        foreach($val['sub'] as $k => $v){ 
                            if($v['name'] != '其他'){
                                if($v['name'] == '保姆' || $v['name'] == '月嫂' || $v['name'] == '家具' || $v['name'] == '珍稀木器' || $v['name'] == '室内卫生' || $v['name'] == '除虫害' || $v['name'] == '干洗洗涤' || $v['name'] == '送水' || $v['name'] == '家庭搬家' || $v['name'] == '钢琴搬家' || $v['name'] == '开锁换锁' || $v['name'] == '汽车秘钥' || $v['name'] == '小型车维修' || $v['name'] == '安全接送' || $v['name'] == '红娘' || $v['name'] == '婚纱照写真' || $v['name'] == '全家福' || $v['name'] == '疑难杂症' || $v['name'] == '诊所' || $v['name'] == '殡仪服务' || $v['name'] == '刻碑' || $v['name'] == '起名改名' || $v['name'] == '学生托管' || $v['name'] == '家教' || $v['name'] == '京剧' || $v['name'] == '棋牌' || $v['name'] == '书法' || $v['name'] == '会计培训' || $v['name'] == '财税服务' || $v['name'] == '工商注册' || $v['name'] == '礼品定制' || $v['name'] == '广告服务' || $v['name'] == '常规货运' || $v['name'] == '保温保鲜货运' || $v['name'] == '整体卫生' || $v['name'] == '玻璃幕墙' || $v['name'] == '电脑' || $v['name'] == '手机' || $v['name'] == '电视' || $v['name'] == '凿墙拆改' || $v['name'] == '腻子' || $v['name'] == '线路' || $v['name'] == '复印机' || $v['name'] == '一体机' || $v['name'] == '传真机' || $v['name'] == '楼宇装修' || $v['name'] == 'LED显示屏' || $v['name'] == '手机软件APP' || $v['name'] == '微信推广' || $v['name'] == '社交平台推广' || $v['name'] == '职业经理' || $v['name'] == '会计师' || $v['name'] == '业务员' || $v['name'] == '驾驶员' || $v['name'] == '学徒工'){ ?>
                                        <li><a href="<?php echo site_url('listlg/index/l1/'.$key_one.'/l2/'.$key.'/l3/'.$k); ?>" class="stress"><?php echo $v['name']; ?></a></li>
                             <?php   }else{ ?>
                                        <li><a href="<?php echo site_url('listlg/index/l1/'.$key_one.'/l2/'.$key.'/l3/'.$k); ?>">
                                            <?php echo $v['name']; ?></a></li>
                             <?php  }
                                ?>
                            
                            <?php } $a++; 
                            if($a%4==0){
                                echo "</ul><ul>";
                            }}  ?>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
                <?php  } ?>
            </div>
        <?php $i++; 
            if($i == 4){
                echo "</div>";                                
                echo '<div class=" main main2">';
            }else if($i == 5){
                echo '            
            <div class="ads">
                <img src="/static/images/shouye/xuweiyidai.png" alt=""/>
                <img src="/static/images/shouye/xuweiyidai.png" alt=""/>
                <img src="/static/images/shouye/erweima2_03.gif" alt=""/>
            </div>';
                echo '</div>';
                echo '<div class=" main main3">';
            }
        } ?>

        </div>
    <div class="about">
        <ul>
            <li>关注我们</li>
            <li><a href="#">新浪微博</a></li>
            <li><a href="#">官网微信</a></li>
        </ul>
        <ul>
            <li>关于零工在线</li>
            <li><a href="#">了解零工在线</a></li>
            <li><a href="#">加入零工在线</a></li>
        </ul>
        <ul>
            <li>服务支持</li>
            <li><a href="#">签约推广</a></li>
            <li><a href="#">渠道招商</a></li>
        </ul>
        <ul>
            <li>零工小参</li>
            <li><a href="#">常见问题</a></li>
            <li><a href="#">更多帮助</a></li>
            <li><a href="#">意见反馈</a></li>
        </ul>
    </div>

    </div>
    <div class="foot">
        <nav>
        <span>青岛区域：</span>
        <a href="#">市南</a>
        <a href="#">市北</a>
        <a href="#">黄岛</a>
        <a href="#">崂山</a>
        <a href="#">李沧</a>
        <a href="#">城阳</a>
        <a href="#">胶州</a>
        <a href="#">即墨</a>
        <a href="#">平度</a>
        <a href="#">莱西</a>
        </nav>
        <nav>
        <span>周边城市：</span>
        <a href="#">日照</a>
        <a href="#">济南</a>
        <a href="#">淄博</a>
        <a href="#">枣庄</a>
        <a href="#">东营</a>
        <a href="#">烟台</a>
        <a href="#">潍坊</a>
        <a href="#">济宁</a>
        <a href="#">泰安</a>
        <a href="#">威海</a>
        <a href="#">莱芜</a>
        <a href="#">临沂</a>
        <a href="#">德州</a>
        <a href="#">聊城</a>
        <a href="#">滨州</a>
        <a href="#">菏泽</a>
        </nav>
        <nav>
        <span>热门城市：</span>
        <a href="#">上海</a>
        <a href="#">北京</a>
        <a href="#">广州</a>
        <a href="#">深圳</a>
        <a href="#">苏州</a>
        <a href="#">沈阳</a>
        <a href="#">重庆</a>
        <a href="#">杭州</a>
        <a href="#">大连</a>
        <a href="#">西安</a>
        <a href="#">郑州</a>
        <a href="#">成都</a>
        <a href="#">天津</a>
        <a href="#">东莞</a>
        <a href="#">青岛</a>
        <a href="#">武汉</a>
        <a href="#">石家庄</a>
        <a href="#">济南</a>
        <a href="#">南京</a>
        <a href="#">南宁</a>
        <a href="#">昆明</a>
        <a href="#">宁波</a>
        <a href="#">银川</a>
        <a href="#">其他城市</a>
        </nav>
        <nav>
        <span>友情链接：</span>
        <a href="#">人力资源和社会保障部</a>
        <a href="#">劳动法</a>
        <a href="#">工信部</a>
        </nav>
    </div>
</section>
<script src="/static/js/search.js"></script>
<script src="/static/js/shouye.js"></script>
