<link rel="stylesheet" href="/static/css/lgb/personalInfor.css"/>


<section>
    <p class="title">
        <a href="/user/center"><</a>
        <span>个人信息</span>
    </p>

    <?php echo form_open_multipart('user/personalinfor')?>
        <div>
            <span>头像</span>
            <a href="javascript:;" class="toux">
                <img src="<?php echo $user['img']; ?>" alt=""/>
                <input type="file" name="toux_img" value="<?php echo $user['img']; ?>" style="width: 100%;"/>
            </a>
        </div>
        <div>
            <span>昵称</span>
            <input type="text" name="nickname" placeholder="<?php echo $nickname['nickname']?$nickname['nickname']:'零工在线'; ?>" value="<?php echo $nickname['nickname']?$nickname['nickname']:'零工在线'; ?>"/>

        </div>
        <div>
            <span>用户名</span>
            <input type="text" disabled="true" placeholder="<?php echo $user['username']; ?>"/>

        </div>
    <span class="error"><?php echo $error; ?></span>
        <div class="out" style="margin-top: 2rem;">

            <span><input type="submit" value="修改"/></span>
        </div>

    </form>

</section>

<style>

    .toux input {
        position: absolute;
        right: 0;
        top: 0;
        opacity: 0;
    }
    .toux:hover {
        background: #AADFFD;
        border-color: #78C3F3;
        color: #004974;
        text-decoration: none;
    }

    .out input {
        height: inherit;
        width: 70%;
        border-bottom: none;
        background: transparent;
        margin-left: .2rem;
        font-size: 1rem;
    }

    .out span{
        line-height: 1.4rem;
    }

</style>