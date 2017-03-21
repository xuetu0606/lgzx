<link rel="stylesheet" href="/static/css/friendly-link/lgxc.css"/>
<section>
    <p class="title">
        <span>零工小参</span>
    </p>
    <?php foreach($content as $key => $value){ ?>
    <div class="question">
            <p class="headline">
                <?php echo $value['title']; ?>：
            </p>
            <nav>
                <a style="color:blue" href="<?php echo site_url('/Home/content/').$value['id']; ?>"><?php echo $value['sub_title']; ?> </a>
            </nav>
    </div>
    <?php } ?>
</section>