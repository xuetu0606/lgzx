<!-- Content Wrapper. Contains page content d-->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo '工号:'.$member['no'].$title;?>
            <small><?php echo $city['name'];?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/daili"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="#">客情维护</a></li>
            <li class="active">会员统计</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="callout callout-info">
            <!--<h4>Tip!</h4>-->
            <p>
                <b>用户名 : </b><?php echo $member['username']; ?> |
                <b>性质 : </b><?php echo $member['is_co']?'公司零工':'个人零工'; ?> |
                <b>是否实名 : </b><?php echo $member['is_real']==1?'已实名':'未实名'; ?> |
                <b>工分 : </b><?php echo $member['credit2']?$member['credit2']:'0'; ?> |
                <b>零工币 : </b><?php echo $member['credit1']?$member['credit1']:'0'; ?> |
                <b>注册时间 : </b><?php echo date('Y-m-d',$member['addtime']); ?> |
                <b>注册来源 : </b><?php echo $member['referrer ']?('推介人工号->'.$member['credit1']):'站内注册'; ?> |
                <b>注册地 : </b><?php echo $provinceCity?($provinceCity['province']!=$provinceCity['city']?($provinceCity['province'].' '.$provinceCity['city']):$provinceCity['city']):'获取失败';?>

            </p>
            <p>
                <?php //if($member['is_real']==1):?>
                <?php if(1):?>
                    <b><?php echo $member['is_co']==1?'公司名称':'真实姓名'; ?> : </b><?php echo $member['is_co']==1?$member['coname']:$member['realname']; ?> |
                    <b><?php echo $member['is_co']==1?'营业执照号':'身份证号'; ?> : </b><?php echo $member['idno']; ?>
                <?php endif;?>
            </p>
        </div>
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">编辑</h3>
            </div>
            <div class="box-body">
                <form role="form" action="/admin/edit" method="post">
                    <input type="hidden" value="<?php echo $member['no']; ?>" name="no">
                    <input type="hidden" value="<?php echo $member['is_co']; ?>" name="is_co">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>重置密码</label><span> *不填则为不修改</span>
                            <input class="form-control" placeholder="******" type="password" name="password">
                        </div>
                        <div class="form-group">
                            <label>地址</label>
                            <input class="form-control" placeholder="<?php echo $member['address']; ?>" name="address" type="text">
                        </div>
                        <div class="form-group">
                            <label>手机</label>
                            <input class="form-control" placeholder="<?php echo $member['mobile']; ?>" name="mobile" type="text">
                        </div>
                        <div class="form-group">
                            <label>email</label>
                            <input class="form-control" placeholder="<?php echo $member['email']; ?>" name="email" type="text">
                        </div>
                        <div class="form-group">
                            <label>QQ</label>
                            <input class="form-control" placeholder="<?php echo $member['qq']; ?>" name="qq" type="text">
                        </div>
                        <div class="form-group">
                            <label>微信号</label>
                            <input class="form-control" placeholder="<?php echo $member['wechat']; ?>" name="wechat" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php if($member['is_co']!=1){?>
                        <div class="form-group">
                            <label>昵称</label>
                            <input class="form-control" placeholder="<?php echo $member['nickname']; ?>" type="text" name="nickname">
                        </div>
                            <div class="form-group">
                                <label>性别</label>
                                <input name="sex" id="sex" value="1" <?php echo $member['sex']==1?'checked=""':''; ?> type="radio">男
                                <input name="sex" id="sex" value="2" <?php echo $member['sex']==2?'checked=""':''; ?> type="radio">女
                            </div>
                        <?php }else{ ?>
                            <div class="form-group">
                                <label>公司名称</label>
                                <input class="form-control" placeholder="<?php echo $member['coname']; ?>" type="text" name="coname">
                            </div>
                            <div class="form-group">
                                <label>公司规模</label>
                                <select class="form-control" name="scale_code">
                                    <?php foreach ($scale as $k=>$v){
                                        echo '<option '.($k==$member['scale_code']?'selected=selected':'').'>'.$v.'</option>';
                                    }?>
                                </select>
                            </div>
                        <?php }?>


                        <div class="form-group">
                            <label><?php echo $member['is_co']==1?'公司简介':'个人简介'; ?></label>
                            <textarea class="form-control" rows="3" placeholder="<?php echo $member['info']; ?>" name="info"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">修 改</button>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>证件图片</label>
                            <!--<label><img class="col-md-4" src="/upload/<?php echo $provinceCity['pinyin'].'/'.$member['idno_img']; ?>"></label>
                            -->
                            <label><img class="col-md-10" src="/static/images/LOGObig.png"></label>
                        </div>
                        <div class="form-group">
                            <label><?php echo $member['is_co']==1?'企业形象':'头像'; ?></label>
                            <label><img class="col-md-8" src="/upload/<?php echo $provinceCity['pinyin'].'/'.$member['img']; ?>"></label>
                        </div>
                    </div>
                </form>
            </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                Footer
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->