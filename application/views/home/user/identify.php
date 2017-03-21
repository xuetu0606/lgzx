<link rel="stylesheet" href="/static/css/lgb/title.css"/>
<link rel="stylesheet" href="/static/css/lgb/identify.css"/>
<section>
    <p class="title">
        <a href="/user/center"><</a>
        <span>实名认证</span>
    </p>
    <?php echo form_open_multipart('user/identify')?>

    <?php
if($this->session->is_co){
?>
    <div class="caution">
            <h3>营业执照注意事项</h3>
            <ul>
                <li>
                    (1) 营业执照需为加盖公司公章的副本复印件或扫描件；
                </li>
                <li>
                    (2) 证件要求完整、清晰；
                </li>
                <li>
                    (3) 证件上必须有工商部门的有效盖章；
                </li>
                <li>
                    (4) 证件必须在有效期内
                </li>
            </ul>
        </div>
    <div class="license company">
            <div>
                <span class="red">*</span><span>营业执照号</span>
                <input type="text" name="idno" value="<?php set_value('idno'); ?>"/>
                <span class="blue remind">请填写营业执照注册号</span>
            </div>
            <div class="id">
                <span class="red">*</span><span>营业执照扫描件</span>
                <input type="file" name="idno_img" value="<?php set_value('idno_img'); ?>" />
                <span class="blue remind">图片格式为gif、jpg、jpeg、png,大小不超过2M</span>
            </div>
            <div>
                <span class="red">*</span><span>公司名称</span>
                <input type="text" name="coname" value="<?php set_value('coname'); ?>"/>
                <span class="blue remind">需与营业执照一致</span>
            </div>
        </div>
<?php
}else{
?>
    <div class="license">
        <div>
            <span class="red">*</span><span>姓名</span>
            <input type="text" name="realname" value="<?php set_value('realname'); ?>"/>
            <span class="blue remind">请输入真实姓名</span>
        </div>
        <div>
            <span class="red">*</span><span>身份证号</span>
            <input type="text" name="idno" value="<?php set_value('idno'); ?>"/>
            <span class="blue remind">请输入18位身份证号码</span>
        </div>
        <div class="id">
            <span class="red">*</span><span>身份证扫描件</span>
            <input type="file" name="idno_img" value="<?php set_value('idno_img'); ?>" />
            <span class="blue remind">图片格式为gif、jpg、jpeg、png,大小不超过2M</span>
        </div>

    </div>
<?php
}
?>

    <div class="error"><?php validation_errors();?><?php echo $error;?></div>
    <input type="submit" value="提交" class="submit"/>
    </form>
    <div class="right">
        <span class="red">注 *</span>
        <span>为必填项</span>
    </div>
</section>
