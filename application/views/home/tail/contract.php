<link rel="stylesheet" href="/static/css/lgb/title.css"/>
<link rel="stylesheet" href="/static/css/publish/personal.publish.css"/>
<section>
    <p class="title3">
        <span>签约推广</span>
    </p>
    <p style="text-align: center;margin: 2rem;font-size: 1.2rem;">签约推广申请表</p>
    <form action="<?php echo site_url('home/contractads'); ?>" method="POST">
        <div>
            <span>姓名</span>
            <span><?php echo $personal['realname']; ?></span>
            <input type="hidden" name='username' value="<?php echo $personal['realname']; ?>" />
        </div>
        <div>
            <span>身份证号码</span>
            <span><?php echo $personal['idno']; ?></span>
            <input type="hidden" name='idno' value="<?php echo $personal['idno']; ?>" />
        </div>
        <div>
            <span>联系电话</span>
            <span><?php echo $personal['mobile']; ?></span>
        </div>
        <div>
            <span>QQ</span>
            <input type="text" name='qq' value="<?php echo $personal['qq']; ?>" />
        </div>
        <div>
            <span>微信</span>
            <input type="text" name='wechat' value="<?php echo $personal['wechat']; ?>"/>
        </div>
        <div>
            <span>我要留言</span>
            <textarea name="words" cols="30" rows="6"></textarea>
        </div>
        <div class="list">
            <div class="check" onclick="changeDiv()"></div>
            <input type="checkbox" name="agree" checked="checked" onchange="changeBox()"/>
            <p>
                我已阅读并同意 <a href="<?php echo site_url('home/agreement'); ?>">《零工在线用户协议》</a>
            </p>

        </div>
        <div>
        <input type="hidden" name='post_flag' value=1>
                <input type="submit" name="register" id="submit" value="申请签约" style="width: 5rem;"/>
        </div>
    </form>
    <p style="color:red; position:absolute; left:40%;"><?php echo $error ?></p>
    <div class="explain">
        <p>签约条件</p>
        <ul>
            <li>
                乙方必须是经零工在线（www.lg-zx.com）网站注册会员；
            </li>
            <li> 乙方应为中华人民共和国公民，具有完全民事行为能力；</li>
            <li> 乙方须具备经营管理能力及良好的社会信誉，无犯罪记录；</li>
            <li>乙方须具备手机等与甲方进行交流的信息平台；</li>
            <li>乙方必须是自愿从事服务推广活动。</li>
        </ul>
    </div>
</section>
<script src="/static/js/jquery.js"></script>
<script src="/static/js/agree.js"></script>
<style>
    body section div.list div.check {
        width: 1.2rem;
        height: 1.2rem;
        position: absolute;
        top: -.9rem;
        left: 1.5rem;
        display: inline-block;
        background: url(/static/images/tpls/register/agree_03.gif) no-repeat;
        background-size: cover;
    }
    div.list{
        position: relative;

    }
    section div.list p {
        margin: 1rem 0 1rem 5rem;
        font-size: 1rem;
    }
    section div.list input[type=checkbox] {
        position: absolute;
        top: -.2rem;
        left: 3.2rem;
        width: 1.4rem;
        visibility: hidden;
        z-index: 1;
    }
    section div.list p a {
        color: #2647ff;
        text-decoration: underline;
        vertical-align: middle;
    }
    section div.explain {
        width: 92%;
        margin: 6rem auto 2rem auto;
    }
    div.explain ul,div.explain p{
        padding: 0;
        margin: .5rem;
        color: #727171;
        list-style-type: disc;
    }
    ul li{
        display: list-item !important;
        list-style:disc !important;
        margin: .3rem;
    }
</style>
