<link rel="stylesheet" href="/static/css/lgb/title.css"/>
<link rel="stylesheet" href="/static/css/tpls/excharge.css"/>
<link rel="stylesheet" href="/static/css/publish/personal.publish.css"/>

<section>
    <p class="title2">
        <a href="/user/center"><</a>
        <span>工分提现</span>
    </p>
    <?php echo form_open('/pay/cash'); ?>
        <div>
            <span>姓名</span>
            <input type="text" name="name"/>
            <span class="blue remind">请输入真实姓名</span>
        </div>
        <div>
            <span>身份证号码</span>
            <input type="text" name="idno"/>
            <span class="blue remind">请输入与姓名对应的身份证号码</span>
        </div>
        <div>
            <span>提现选择</span>
            <input type="radio" name="mode" value="1" checked="checked"/><span>支付宝</span>
            <input type="radio" name="mode" value="2"/> <span>银行卡</span>
        </div>
        <div style="display: none" id="bank">
            <span>开户行</span>
            <input type="text" name="bank"/>
            <span class="blue remind">例如：中国工商银行</span>
        </div>
        <div>
            <span id="withdraw">支付宝账号</span>
            <input type="text" name="account"/>
            <span class="blue remind">请输入有效的支付宝账号</span>
        </div>

    <div>
        <span>提现金额</span>
        <input type="text" name="money" value="<?php echo $user['credit2']?$user['credit2']:'0' ?>" readonly="true"/>
        <span class="blue remind">提现金额为您的工分余额. <a href="/home/contractads">怎么赚取工分?</a> </span>
    </div>

    <div class="error">
        <?php echo validation_errors(); ?>
    </div>

        <div>
            <input type="submit" value="提现"/>
        </div>

    </form>
    <div class="explain">
        <p>提现说明：</p>
        <p>申请提现后，48小时之内到账（周六、周日和节假日除外）</p>
        <p>请仔细核对身份证信息和银行账户信息，如填写有误，提现将不成功！</p>
        <p>如有问题，请拔打客服电话：400-860-6286</p>
    </div>
</section>

<script>
    $('input:radio').click(function(){
        if($(this).index()==1)
        {
            $('#withdraw').text('支付宝账号');
            $('#bank').css('display','none');
        }
        else{
            $('#withdraw').text('银行账号');
            $('#bank').css('display','block');
        }
    })
</script>