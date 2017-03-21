<link rel="stylesheet" href="/static/css/publish.css"/>
<link rel="stylesheet" href="/static/css/form.css"/>
<style>
    .gb {
        position: relative;
        top: -85px;
        right: -130px;
    }
</style>

<section>
    <div class="position">
        <span>青岛零工在线</span>
        <span> > </span>
        <span><a href="/user">零工宝</a></span>
        <span> > </span>
        <span><?php echo $title?></span>
    </div>
    <div class="main">
        <div class="middle">
            <div class="buzhou">
                <span class="step step1"><?php echo $hang[$baseinfo['job_level_1']];?> </span>
                <span class="step b"> > </span>
                <span class="step step2"><?php echo $zhi[$baseinfo['job_level_2']];?> </span>
                <span class="step b"> > </span>
                <span class="step step3 stress"> 修改信息 </span>
                <span class="step b"> > </span>
                <span class="step step4"> 完成 </span>
            </div>
        </div>
        <div class="infor">
            <h1>修改工种信息</h1>

            <form method="post" action="<?php echo base_url();?>pub/edit/<?php echo $this->uri->segment(3, 0);?>" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="form-control">
                        <label><span class="xing">*</span>标题：</label>
                        <input name="title" type="text" class="input-normal" value="<?php echo $baseinfo?$baseinfo['info1']:set_value('title'); ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-control wrap">
                        <label><span class="xing">*</span>服务内容：</label>
                        <div class="check">
                            <?php foreach ($gong as $k => $v):?>
                                <div class="marginr">
                                    <input type="radio" name="job_code" value="<?php echo $k;?>" <?php echo $k==$baseinfo['job_level_3']?'checked':'';?> /><span <?php echo ($k==$baseinfo['job_level_3']?'style="background-color: #3cd3ff">':'>').$v;?></span>
                                </div>
                            <?php endforeach;?>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <div class="form-control wrap">
                        <label><span class="xing">*</span>服务区域：</label>
                        <div class="check">
                            <?php
                            $count = count($qyinfo);
                            foreach ($qyinfo as $k => $v){
                                echo $dist[$v['district_id']].($v['area_id']?('-'.$area[1][$v['district_id']][$v['area_id']]):'');
                                if($k+1 != $count){
                                    echo ' , ';
                                }
                            }
                            ?>
                            <span style="color: red">(如需修改服务区域请重新勾选)</span>
                            <br>
                            <?php foreach ($area[0] as $k => $v):?>
                                <div class="marginr">
                                    <input type="checkbox" name="districtid[]" value="<?php echo $k;?>"/><span><?php echo $v;?></span>
                                </div>
                            <?php endforeach;?>

                            <div class="margin-right">
                                <span class="allcheck allcheck2" id="quanxuan">全选</span>
                            </div>
                        </div>

                    </div>
                    <?php foreach ($area[0] as $k => $v):?>
                        <div class="form-control wrap jiedao" id="jiedao<?php echo $k?>" style="display: none;">
                            <label><span class="xing">*</span><?php echo $v?>：</label>
                            <div class="check">
                                <?php foreach ($area[1][$k] as $k => $v):?>
                                    <div class="marginr">
                                        <input type="checkbox" name="areaid[]" value="<?php echo $k;?>"/><span><?php echo $v;?></span>
                                    </div>
                                <?php endforeach;?>

                                <div class="margin-right">
                                    <span class="allcheck allcheck2">全选</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
                <div class="form-group">
                    <div class="form-control wrap">
                        <label>服务介绍：</label>
                        <textarea name="fwjs"><?php echo $baseinfo?$baseinfo['info3']:set_value('fwjs'); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="upload_box form-control wrap">
                        <label>已上传图片：</label>
                        <div class="upload_main imgs">
                            <div id="preview_old" class="upload_preview_old">
                                <?php
                                $img=explode(',',$baseinfo['img']);
                                foreach ($img as $k => $v){
                                    $img_arr=explode('.',$v);
                                ?>
                                <div id="uploadList_<?php echo '9'.$k;?>" class="upload_append_list zhtp">
                                    <a href="javascript:" class="upload_delete gb" title="删除" data-index="<?php echo '9'.$k;?>" data-img="/upload/<?php echo $citycode;?>/gzxx/<?php echo $_SESSION['uid'].'/'.$img_arr[0].'|'.$img_arr[1]?>">
                                        <img src="/static/images/publish/gb.png" alt="">
                                    </a>
                                    <img id="uploadImage_<?php echo '9'.$k;?>" src="/upload/<?php echo $citycode;?>/gzxx/<?php echo $_SESSION['uid'].'/'.$img_arr[0].'_150_100.'.$img_arr[1];?>" class="upload_image tp">
                                </div>
                                <?php }?>
                            </div>

                        </div>

                        <input type="hidden" name="delfile" id="delfile">
                    </div>
                    <div class="upload_box form-control wrap">
                        <label>上传新图片：</label>
                        <div class="upload_main imgs">
                            <div id="preview" class="upload_preview">
                            </div>

                            <div class="upload_choose">
                                <label for="fileImage" style="display: block"> <img src="/static/images/publish/xz.png" alt="" class="sctp"/></label>
                                <input type="file" id="fileImage" name="fileselect[]" style="display: none;" multiple="multiple"/>
                                <p style="margin-top: 20px;color: #888888;font-size: 14px">最多可上传8张图片，每张不超过5M(按住Ctrl键进行多选)</p>
                            </div>

                        </div>

                        <input type="hidden" name="delfile" id="delfile">
                    </div>
                </div>
                <?php if($_SESSION['is_co']==1):?>
                    <div class="form-group">
                        <div class="form-control wrap">
                            <label>公司名称：</label>
                            <span><?php echo $user['coname']?></span>

                        </div>
                    </div>
                <?php endif;?>
                <div class="form-group">
                    <div class="form-control wrap">
                        <label><?php echo $user['is_co']==1?'公司地址':'联系地址'?>：</label>
                        <input type="text" name="address" class="input-normal" value="<?php echo $baseinfo['address']?>"/>
                    </div>
                </div>
                <!--
                <div class="form-group">
                    <div class="form-control wrap">
                        <label>微信号：</label>
                        <input type="text" name="wechat" class="input-normal" value="<?php echo $baseinfo['wechat']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-control wrap">
                        <label>QQ号：</label>
                        <input type="text" name="wechat" class="input-normal" value="<?php echo $baseinfo['qq']?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-control wrap">
                        <label><span class="xing">*</span> 联系人：</label>
                        <input type="text" class="input-normal" value=""/>
                    </div>
                </div>
                -->
                <div class="form-group">
                    <div class="form-control wrap">
                        <label><span class="xing">*</span> 联系电话：</label>
                        <input type="text" name="mobile" class="input-normal" value="<?php echo $baseinfo['mobile']?>"/>
                    </div>
                </div>

                <div class="form-group" style="text-align: center;  "><?php echo validation_errors()?validation_errors():($formerror?$formerror:''); ?></div>

                <div class="form-group">
                    <div class="form-control wrap">
                        <label></label>
                        <input type="submit" class="btn btn-main" id="fileSubmit" value="发布" style="font-size: 16px"/>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>
<footer>
    <div class="main">
        <ul>
            <li><a href="#">法律声明 |</a></li>
            <li><a href="#">零工宝 |</a></li>
            <li><a href="#">零工小参 |</a></li>
            <li><a href="#">招贤纳士 |</a></li>
            <li><a href="#">关注微博</a></li>
        </ul>
        <p>Copyright © 2016 lg-zx.com Corporation, All Rights Reserved 鲁ICP备16012134号-1 站长统计</p>
    </div>
</footer>
</body>
<script src="/static/js/jquery.js"></script>
<script src="/static/js/ajaxfileupload.js"></script>
<script src="/static/js/head-foot.js"></script>
<script>
    $(function() {
        $('.classify ul li').click(function () {
            $(this).children('a').addClass('active');
            $(this).siblings().children('a').removeClass('active');
            $('.step2').addClass('stress');
            $('.type').show();
        });
        var count1 = 0;
        var count2 = 0;
        $('.allcheck1').click(function () {
            count1++;
            if (count1 % 2 == 1)
                $(this).parent().parent().find('input[type=checkbox]').prop('checked', 'checked');
            else {
                $(this).parent().parent().find('input[type=checkbox]').prop('checked', false);
            }
        });
        $('.allcheck2').click(function () {
            count2++;
            if (count2%2==1)
                $(this).parent().parent().find('input[type=checkbox]').prop('checked', 'checked');
            else {
                $(this).parent().parent().find('input[type=checkbox]').prop('checked', false);
            }
        });
        $('.gb').click(function(){
            $(this).parent().remove();
            $.ajax({
                url: '<?php echo base_url();?>pub/delimg',
                type: "POST",
                dataType: 'json',
                data: {id:'<?php echo $this->uri->segment(3, 0)?>',img:$(this).data('index'),img_url:$(this).data('img')},
                cache: false,
                error: function(){
                    alert('检测失败，请重试');
                },
                success: function(data){
                    if(data.status=="success"){
                        alert('删除成功!');
                    }else {
                        alert(data.msg);
                    }
                }
            });
        })
    });
</script>
<script>
    var params = {
        fileInput: $("#fileImage").get(0),
        dragDrop: $("#fileDragArea").get(0),
        upButton: $("#fileSubmit").get(0),
        url: $("#uploadForm").attr("action"),
        filter: function(files) {
            var arrFiles = [];
            for (var i = 0, file; file = files[i]; i++) {
                if (file.type.indexOf("image") == 0) {
                    if (file.size >= 512000) {
                        alert('您这张"'+ file.name +'"图片大小过大，应小于500k');
                    } else {
                        arrFiles.push(file);
                    }
                } else {
                    alert('文件"' + file.name + '"不是图片。');
                }
            }
            return arrFiles;
        },
        onSelect: function(files) {
            var html = '', i = 0;
            $("#preview").html('<div class="upload_loading"></div>');
            var funAppendImage = function() {
                file = files[i];
                if (file) {
                    var reader = new FileReader()
                    reader.onload = function(e) {
                        html = html + '<div id="uploadList_'+ i +'" class="upload_append_list zhtp"><a href="javascript:" class="upload_delete gb" title="删除" data-index="'+ i +'"><img src="/static/images/publish/gb.png" alt=""></a>' + '<img id="uploadImage_' + i + '" src="' + e.target.result + '" class="upload_image tp" /></div>';

                        //html = html + '<div id="uploadList_'+ i +'" class="upload_append_list zhtp">' + '<img id="uploadImage_' + i + '" src="' + e.target.result + '" class="upload_image tp" /></div>';

                        i++;
                        funAppendImage();
                    }
                    reader.readAsDataURL(file);
                } else {
                    $("#preview").html(html);

                        //删除方法
                        $(".upload_delete").click(function() {
                            ZXXFILE.funDeleteFile(files[parseInt($(this).attr("data-index"))]);
                            //alert($(this).attr("data-index"));
                            return false;
                        });

                }
            };
            funAppendImage();
        },
        onDelete: function(file) {
            $("#uploadList_" + file.index).fadeOut();
            $("#delfile").val($("#delfile").val()+','+file.index);
        },
        onDragOver: function() {
            $(this).addClass("upload_drag_hover");
        },
        onDragLeave: function() {
            $(this).removeClass("upload_drag_hover");
        },
        onProgress: function(file, loaded, total) {
            var eleProgress = $("#uploadProgress_" + file.index), percent = (loaded / total * 100).toFixed(2) + '%';
            eleProgress.show().html(percent);
        },
        onSuccess: function(file, response) {
            $("#uploadInf").append("<p>上传成功，图片地址是：" + response + "</p>");
        },
        onFailure: function(file) {
            $("#uploadInf").append("<p>图片" + file.name + "上传失败！</p>");
            $("#uploadImage_" + file.index).css("opacity", 0.2);
        },
        onComplete: function() {
            //提交按钮隐藏
            $("#fileSubmit").hide();
            //file控件value置空
            $("#fileImage").val("");
            $("#uploadInf").append("<p>当前图片全部上传完毕，可继续添加上传。</p>");
        }
    };
    ZXXFILE = $.extend(ZXXFILE, params);
    ZXXFILE.init();
</script>
<script>
    $("input:checkbox").click(function () {

        //alert($(this).attr('value'));
        if ($(this).is(":checked")) {
            $("#jiedao"+$(this).attr('value')).show();
        } else {
            $("#jiedao"+$(this).attr('value')).hide();
        }
    });
    $("#quanxuan").click(function () {
        $(".jiedao").hide();
    })
</script>
</html>