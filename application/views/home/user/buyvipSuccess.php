<section>
    <div class="main">
        <p>恭喜您购买<?php echo $info['name'];?>VIP会员成功！</p>
        <p>本次扣除<?php echo $info['credit'];?>个零工币，您的零工币余额为<?php echo $user['credit1']; ?>个。</p>
    </div>
</section>

<style>
    div.main{
        margin-top: 50%;
    }
    p{
        margin: 1rem 0;
        font-size: 1.2rem;
        text-align: center;
        color: #ff3c5a;
    }
</style>