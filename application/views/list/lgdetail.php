    <link rel="stylesheet" href="/static/css/workInfor.css"/>
    <link rel="stylesheet" href="/static/css/form.css"/>
    <link rel="stylesheet" href="/static/css/detail.css"/>
    <script src="/static/js/jquery.js"></script>
    <script src="/static/js/head-foot.js"></script>
    <script src="/static/js/detail.js"></script>
    <script src="/static/js/star.js"></script>
<div class="full">
    <div class="main">
        <img src="/static/images/LOGOa.png" alt="" class="logo"/>
        <form action="<?php echo site_url('Listlg/lgsearch'); ?>" method="POST" >
            <input type="text" class="input-normal" name="search" />
            <input type="submit" value="" class="fdj"/>
        </form>
        <a href="#">免费发布信息</a>
    </div>
</div>
<section><?php  
var_dump($person); 
var_dump($pl);
 var_dump($firms);?>
    <div class="position">
        <span><?php echo $cityname?$cityname:$city; ?>零工在线</span>
        <span> > </span>
        <span>家政服务</span>
        <span> > </span>
        <span>保姆/月嫂</span>
    </div>
    <div class="main">
        <div class="title">
            <div class="line1">
                <span class="name"><?php echo $person['info1']; ?></span>
                <span class="vip">
                <?php //if($user[$key]){ ?>
                <img src="/static/images/vip/vip1.png" alt=""/>
                <?php// } ?></span>
                <span class="identify"><img src="/static/images/renzheng/yingyezhiz.png" alt=""/></span>
            </div>
            <div class="line2">
            <span>信用等级</span><img src="/static/images/vip/yp.png" alt=""/>
                <img src="/static/images/vip/sj.png" alt="" class="clock"/>
                <span class="time">今天11:20</span>
                <span>|</span>
                <span class="pageview"><?php echo $pv; ?>次浏览</span>
            </div>
        </div>
        <div class="infor">
            <div class="scale">
                <p>
                    <span class="name">公司名称：</span>
                    <span class="content"><?php echo $firms['coname']; ?></span>
                </p>
                 <p>
                     <span class="name">服务内容：</span>
                     <span class="content"><?php foreach($person['job_name'] as $k => $value){ echo $value.'　'; } ?></span>
                 </p>
                <p>
                     <span class="name">服务范围：</span>
                     <span class="content">
                     <?php 
                        foreach($person['service_addr'] as $addr_k => $addr_v){
                            if($addr_v['areaname']){
                                echo $addr_v['areaname'].'　';
                            }else{
                                echo $addr_v['distname'].'　';
                            }
                        }
                     ?></span>
                 </p>
                <p>
                    <span class="name">联系地址：</span>
                    <span class="content"><?php echo $person['address']; ?></span>
                </p>
<!--                 <p>
    <span class="name">联系人：</span>
    <span class="content">王经理</span>
</p> -->
                <p>
                    <span class="name">联系电话：</span>
                    <span class="content stress"><?php echo $person['mobile']; ?></span>
                </p>
            </div>

        </div>
        <div class="introduce">
            <p class="line">
                <span class="active">服务介绍</span>
                <span>公司详情</span>
                <span>服务评价</span>
            </p>
            <div class="fwjs">
                <pre>
                    <?php echo $person['info3']; ?>
                </pre>
            </div>
            <div class="gsxq">
                <p>
                    <span class="name">公司名称：</span>
                    <span class="content"><?php echo $firms['coname']; ?></span>
                </p>
                <p>
                    <span class="name">公司规模：</span>
                    <span class="content"><?php echo $firms['name']; ?></span>
                </p>
                <p>
                    <span class="name">公司地址：</span>
                    <span class="content"><?php echo $person['address']; ?></span>
                </p>
                <p>
                    <span class="name">公司简介：</span>
                    <span class="content">
                        <?php echo $firms['info']; ?>
                    </span>
                </p>
            </div>
            <div class="fwpj">
                <p class="evaluate1">您已评价过该服务！</p>
                <p class="evaluate1">
                    请您先<a href="<?php echo site_url('user/login'); ?>">登录</a>或<a href="<?php echo site_url('user/reg'); ?>">注册</a>再进行评价！
                </p>
                <div class="evaluate3">
                    <p style="margin: 10px 80px;color: #ff3c5a;font-size: 16px;display: none;" class="warning">评价尚未完成，不能提交！</p>
                    <form action="" onsubmit=" return starsubmit()">
                    <div class="xingxing">
                        <div class="star">
                            <span>专业技能</span>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <!--<span class="txt">一般</span>-->
                            <input type="number" value="0" class='score' style="visibility: hidden"/>
                        </div>
                        <div class="star">
                            <span>服务及时</span>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <!--<span class="txt">一般</span>-->
                            <input type="number" value="0" class='score' style="visibility: hidden"/>

                        </div>
                        <div class="star">
                            <span>服务态度</span>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <!--<span class="txt">一般</span>-->
                            <input type="number" value="0" class='score' style="visibility: hidden"/>


                        </div>
                        <div class="star">
                            <span>现场标准</span>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <div class="stardiv">
                                <div class="back"></div>
                                <img src="/static/images/star/xx.png" alt="" class="xing"/>
                            </div>
                            <!--<span class="txt">一般</span>-->
                            <input type="number" value="0" class='score' style="visibility: hidden"/>

                        </div>
                    </div>

                        <div class="form-control" style="height: auto;">
                            <label for=""><span>评价内容</span></label>
                            <textarea name="" id=""class="remark"></textarea>
                        </div>
                        <div class="form-control" style="margin-top: 40px;margin-left: 118px;">
                            <input type="submit" value="提交" id="submit" class="btn btn-primary"/>
                        </div>
                    </form>
                    <div class="pjlist">
                    <?php foreach($pl as $key => $value){ ?>
                        <div class="type">
                        <p class="name"><?php echo mb_substr($value['username'],0,2); ?>******</p>
                            <div class="content">
                                <p class="left">
                                    <?php echo $value['info']; ?>
                                </p>
                                <p class="right">
                                    <span><?php date_default_timezone_set('PRC'); echo date("Y-m-d",$value['addtime']); ?></span>
                                    <span><?php date_default_timezone_set('PRC'); echo date("H:i",$value['addtime']); ?></span>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
