<?php
echo $error;
?>

<link rel="stylesheet" href="/static/css/lgb/title.css"/>
<link rel="stylesheet" href="/static/css/publish/personal.publish.css"/>

<section>
    <p class="title2">
        <a href="<?php echo site_url('user/mypublish'); ?>"><</a>
        <span>填写信息</span>
    </p>
    <?php echo $edit?form_open('user/recruit/edit/'.$this->uri->segment(4, 0)):form_open('user/recruit'); ?>

    <div>
            <span>标题</span>
        <input type="text" name="title" class="iptlong" placeholder="请输入标题，限20字以内" value="<?php echo $zlg?$zlg['title']:set_value('title'); ?>"/>
        </div>
        <div id="custom_data">
            <span>工种</span>
            <select class="first select">
                <?php echo $zlg?'<option value="'.$zlg['job_level_1'].'" selected>'.$three_level[0][$zlg['job_level_1']].'</option>':''; ?>
            </select>

            <select class="second select">
                <?php echo $zlg?'<option value="'.$zlg['job_level_2'].'" selected>'.$three_level[1][$zlg['job_level_2']].'</option>':''; ?>
            </select>

            <select name="job_code" class="third select">
                <?php echo $zlg?'<option value="'.$zlg['job_level_3'].'" selected>'.$three_level[2][$zlg['job_level_3']].'</option>':''; ?>
            </select>
        </div>
        <div>
            <span>工资</span>
            <input type="text" name="pay" style="width: 5rem;" value="<?php echo $zlg?$zlg['pay']:set_value('pay'); ?>"/>
            <select name="unit">
                <?php
                foreach ($unit as $k=>$v){
                    if($k==$zlg['unit']){$seected='selected';}
                    echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
                }
                ?>
            </select>
        </div>
        <div>
            <span>薪资结算</span>
            <select name="pay_circle">
                <?php
                foreach ($pay_circle as $k=>$v){
                    if($k==$zlg['pay_circle']){$seected='selected';}
                    echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
                }
                ?>
            </select>
        </div>
        <div>
            <span>招聘人数</span>
            <input type="text" name="sum" style="width: 5rem;" value="<?php echo $zlg?$zlg['sum']:set_value('sum'); ?>"/><span>人</span>
        </div>
        <div>
            <span>工作时间</span>
            <input type="text" name="worktime" placeholder="例如：10:00-12:00" value="<?php echo $zlg?$zlg['worktime']:set_value('worktime'); ?>"/>
        </div>
    <div id="area">
        <span>工作区域</span><?php echo $city; ?>市
        <select name="districtid" class="districtid">
            <?php echo $zlg?('<option value="'.$zlg['district_id'].'" selected>'.$dist[$zlg['district_id']].'</option>'):set_value('districtid'); ?>
        </select>
        <!--<select name="areaid" class="areaid"></select>-->
    </div>
        <div>
            <span>联系地址</span>
            <input type="text" name="address" value="<?php echo $zlg?$zlg['address']:set_value('address'); ?>" class="iptlong"/>
        </div>
        <div>
            <span>公司名称</span>
            <a href="<?php echo site_url('user/myinfo'); ?>" class="deepblue"><?php echo $user['coname']; ?></a>
        </div>
        <div>
            <span>联系人</span>
            <input type="text" name="contacts" value="<?php echo $zlg?$zlg['contacts']:set_value('contacts'); ?>"/>
        </div>
        <div>
            <span>联系电话</span>
            <input type="text" name="mobile" value="<?php echo zlg?$zlg['mobile']:$user['mobile'];?>"/>
        </div>
        <div>
            <span>工作内容</span>
            <textarea name="info" cols="30" rows="6" class="summaryNum"><?php echo $zlg?$zlg['info']:set_value('info'); ?></textarea>
            <span class="number"><span class="currentNum">200</span>/200</span>
        </div>
    <div class="error">
        <?php echo validation_errors(); ?>
        <?php echo $formerror; ?>
    </div>
        <div>
            <input type="submit" value="发布"/>
        </div>
    </form>
</section>

<script src="/static/js/limitNum.js"></script>
<script src="/static/js/jquery.cxselect.min.js"></script>
<script>
    $('#custom_data').cxSelect({
        selects: ['first', 'second', 'third'],
        required: true,
        jsonValue: 'v',
        jsonName: 'n',
        jsonSub: 's',
        data: [
            <?php
            foreach ($gong[0] as $k1=>$v1) {
                echo '{\'v\': \''.$k1.'\', \'n\': \''.$v1.'\', \'s\': [';
                foreach($gong[1][$k1] as $k2=>$v2){
                    echo '{\'v\': \''.$k2.'\', \'n\': \''.$v2.'\', \'s\': [';
                    foreach($gong[2][$k1][$k2] as $k3=>$v3){
                        echo '{\'v\': \''.$k3.'\', \'n\': \''.$v3.'\'';
                        if(end($gong[2][$k1][$k2])==$v3){
                            echo '}';
                        }else{
                            echo '},';
                        }
                    }
                    if(end($gong[1][$k1])==$v2){
                        echo ']}';
                    }else{
                        echo ']},';
                    }
                }
                if(end($gong[0])==$v1){
                    echo ']}';
                }else{
                    echo ']},';
                }
            }

            ?>

        ]
    });
</script>
<script>
    $('#area').cxSelect({
        selects: ['districtid', 'areaid'],
        required: true,
        jsonValue: 'v',
        jsonName: 'n',
        jsonSub: 's',
        data: [
            {'v':'','n':'全部','s':[
                {'v':'','n':'全部'}
            ]},
            <?php
            foreach ($area[0] as $k1=>$v1) {
                echo '{\'v\': \''.$k1.'\', \'n\': \''.$v1.'\', \'s\': [';
                echo '{\'v\':\'\',\'n\':\'全部\'},';
                foreach($area[1][$k1] as $k2=>$v2){

                    echo '{\'v\': \''.$k2.'\', \'n\': \''.$v2.'\'';

                    if(end($area[1][$k1])==$v2){
                        echo '}';
                    }else{
                        echo '},';
                    }
                }
                if(end($area[0])==$v1){
                    echo ']}';
                }else{
                    echo ']},';
                }
            }

            ?>

        ]
    });
</script>