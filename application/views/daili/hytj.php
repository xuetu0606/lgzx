<!-- Content Wrapper. Contains page content d-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                会员统计
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
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">筛选条件</h3>
                        </div>

                        <div class="box-header col-sm-5">
                            <p><b>零工类型:</b>
                                <?php
                                    echo '<a '.($url_gong==0?$class:'').' href="/daili/hytj/gong/0/reg/'.$url_reg.'/vip/'.$url_vip.'">不限</a> 
                                          <a '.($url_gong==1?$class:'').' href="/daili/hytj/gong/1/reg/'.$url_reg.'/vip/'.$url_vip.'">个人</a> 
                                          <a '.($url_gong==2?$class:'').' href="/daili/hytj/gong/2/reg/'.$url_reg.'/vip/'.$url_vip.'">公司</a> 
                                          ';
                                ?></p>
                            <p><b>注册类型:</b>
                                <?php
                                echo '<a '.($url_reg==0?$class:'').' href="/daili/hytj/gong/'.$url_gong.'/reg/0/vip/'.$url_vip.'">不限</a> 
                                          <a '.($url_reg==1?$class:'').' href="/daili/hytj/gong/'.$url_gong.'/reg/1/vip/'.$url_vip.'">推广注册</a> 
                                          <a '.($url_reg==2?$class:'').' href="/daili/hytj/gong/'.$url_gong.'/reg/2/vip/'.$url_vip.'">站内注册</a> 
                                          ';
                                ?>
                            </p>
                            <p><b>套餐期限:</b>
                                <?php
                                echo '<a '.($url_vip==0?$class:'').' href="/daili/hytj/gong/'.$url_gong.'/reg/'.$url_reg.'/vip/0">不限</a> 
                                      <a '.($url_vip==1?$class:'').' href="/daili/hytj/gong/'.$url_gong.'/reg/'.$url_reg.'/vip/1">一个月内</a> 
                                     ';
                                ?>
                            </p>
                        </div>

                        <!-- Date range -->
                        <div class="form-group col-sm-5">
                            <label>选择日期:</label>

                            <div class="input-group">
                                <form action="/daili/hytj" method="post" id="chaxun">
                                    <input name="riqi1" type="text" value="<?php echo $_SESSION['starttime']?date('Y-m-d',$_SESSION['starttime']):date('Y-m-d',time());?>">至
                                    <input name="riqi2" type="text" value="<?php echo $_SESSION['endtime']?date('Y-m-d',$_SESSION['endtime']):date('Y-m-d',time());?>">
                                    <input type="hidden" id="quxiao_text" name="quxiao" value="0">
                                    <input type="submit">
                                    <input type="button" id="quxiao" value="取消">
                                </form>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>工号</th>
                                    <th>零工类型</th>
                                    <th>昵称/公司名称</th>
                                    <th>工种</th>
                                    <th>零工状态</th>
                                    <th>注册类型/推广ID</th>
                                    <th>注册时间</th>
                                    <th>充值时间</th>
                                    <th>套餐期限</th>
                                    <th>联系电话</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(count($users)>0) {
                                    foreach ($users as $item) {
                                        ?>

                                        <tr>
                                            <td><?= $item['no'] ?></td>
                                            <td><?= $item['is_co']==1 ? '公司' : '个人' ?></td>
                                            <td><?= $item['is_co'] ? $item['coname'] : ($item['nickname']?$item['nickname']:'未填写')  ?></td>
                                            <td><?= $item['gong'] ? $item['gong'] : '无' ?></td>
                                            <td><?= $item['is_vip'] ? 'VIP' : '普通会员' ?></td>
                                            <td><?= $item['promotion_flag'] ? $item['referrer'] : '站内注册' ?></td>
                                            <td><?= date('Y-m-d', $item['addtime']) ?></td>
                                            <td><?= $item['is_vip'] ? date('Y-m-d', $item['vip_starttime']) : '无' ?></td>
                                            <td><?= $item['is_vip'] ? date('Y-m-d', $item['is_vip']) : '无' ?></td>
                                            <td><?= $item['mobile'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                }else{
                                    echo '<tr><td>暂无数据显示!</td></tr>';
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>工号</th>
                                    <th>零工类型</th>
                                    <th>昵称/公司名称</th>
                                    <th>工种</th>
                                    <th>零工状态</th>
                                    <th>注册类型/推广ID</th>
                                    <th>注册时间</th>
                                    <th>充值时间</th>
                                    <th>套餐期限</th>
                                    <th>联系电话</th>
                                </tr>
                                </tfoot>
                            </table>

                            <div class="row">

                                <div class="col-sm-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                        <ul class="pagination"><?php echo $page;?></ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->

                    </div>
                    <!-- /.box -->

                </div>
                <!-- /.col -->
            </div>


            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<!-- jQuery 2.2.3 -->
<script src="/static/daili/plugins/jQuery/jquery-2.2.3.min.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="/static/daili/bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="/static/daili/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->


<script src="/static/daili/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/static/daili/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="/static/daili/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->

<script src="/static/daili/js/moment.min.js"></script>
<script src="/static/daili/plugins/daterangepicker/daterangepicker.js"></script>


<!-- bootstrap datepicker -->
<script src="/static/daili/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="/static/daili/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

<!-- bootstrap time picker -->
<script src="/static/daili/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="/static/daili/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="/static/daili/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="/static/daili/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/static/daili/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/static/daili/dist/js/demo.js"></script>
<!-- Page script -->

<script>
    $(function () {
        //Date range picker
        $('#reservation').daterangepicker();

    });

    $('#quxiao').click(function () {
        $('#quxiao_text').val(1);
        document.getElementById("chaxun").submit();
    });

</script>
</body>
</html>