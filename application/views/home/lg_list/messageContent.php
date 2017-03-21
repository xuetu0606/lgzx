<link rel="stylesheet" href="/static/css/friendly-link/lgxc.css"/>
<?php// var_dump($idget_message); die();?>
<section>
    <p class="title">
        <span>消息文件</span>
    </p>
    <div class="question">
            <p class="headline">
                <?php echo $idget_message[0]['title']; ?>：
            </p>
            <nav>
                <a href="<?php //echo site_url('/Home/content')?>"> <?php echo $idget_message[0]['message']; ?> </a>
            </nav>
    </div>
</section>