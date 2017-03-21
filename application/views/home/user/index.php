<section>
    <div class="industry">
           <!-- 遍历Home.php控制器发过来的职业信息 一级分类 -->
           <?php 
                foreach($first_level as $key => $value){ 
            ?>
            <div class="industry-intro">
                <a href="http://<?php echo $localhost; ?>/Home/two_list/<?php echo $value['id']; ?>"><img src="static/images/section/shouye/<?php echo $key + 1; ?>.gif" alt="<?= $value['name']; ?>"/></a>
                <span><?= $value['name']; ?></span>
            </div>
            <?php
                }
            ?>
			
			<div class="industry-intro">
                <a href="http://<?php echo $localhost; ?>/Home/lg_list/"><img src="static/images/section/shouye/8.gif" alt="大学生专栏"/></a>
                <span>大学生专栏</span>
            </div>
            <div class="industry-intro">
                <a href="http://<?php echo $localhost; ?>/Home/lg_list/"><img src="static/images/section/shouye/9.gif" alt="最新发布"/></a>
                <span>最新发布</span>
            </div>
    </div>

    <div class="detail-industry">
        
            <?php 
                foreach($first_level as $key => $value){
            ?>
		<div>
            <div class="head">
                <span class="txt"><?php echo $value['name']; ?></span>
                <a href="#"><span class="fb">发布</span></a>
                <img src="static/images/section/fb.png" alt="发布"/>
            </div>
        
            <div class="middle">
                <ul>
				<?php 
					$i=1;
					foreach($two_level[$value['id']]['sub'] as $k => $v){ 
				?>
                    <li><a href="http://<?php echo $localhost; ?>/Home/lg_list/"><?php echo $v; ?></a></li>
				<?php if($i%4==0)echo "</ul><ul>"; $i++;}?>
                </ul>

		     <!--   <ul class="hui">
                    <li><a href="#">水道疏通</a></li>
                    <li><a href="#">室内卫生</a></li>
                    <li><a href="#">月嫂</a></li>
                    <li><a href="#">家具</a></li>
                </ul>        
		    这里是热门搜索。现在不确定需求  -->
            </div>
		</div>	
		<?php } ?>
		
		<div>
            <div class="head">
                <span class="txt">大学生专栏</span>
            </div>
            <div class="middle dxs">
<!--                <ul class="hui">
                    <li><a href="#">传单发送</a></li>
                    <li><a href="#">促销活动</a></li>
                    <li><a href="#">市场调查</a></li>
                    <li><a href="#">家教</a></li>
                </ul>
                <ul class="hui">
                    <li><a href="#">网站编辑</a></li>
                    <li><a href="#">体育运动</a></li>
                    <li><a href="#">法律咨询</a></li>
                    <li><a href="#">书法</a></li>
                </ul>
-->
            </div>
        </div>
        <!--最新发布start-->
        <div>
            <div class="head">
                <span class="txt">最新发布</span>
                <a href="#"><span class="fb">快速发布</span></a>
                <img src="static/images/section/ksfb.png" alt="快速发布">
            </div>
            <div class="middle">
                <ul class="zxfb">
                    <li>
                        <span class="area">胶南</span>
                        <a href="#" class="txt-a">选家悦清洁、选舒心、安心、放心,选家悦清洁、选舒心、安心、放心,选家悦清洁、选舒心、安心、放心</a>
                        <a href="#"><img src="static/images/section/3-list/tel.png" alt=""></a>
                        <span class="date">12-06</span>
                    </li>
                </ul>
                <ul class="zxfb">
                    <li>
                        <span class="area">李沧</span>
                        <a href="#" class="txt-a red">专业除甲醛</a>
                        <a href="#"><img src="static/images/section/3-list/tel.png" alt=""></a>
                        <span class="date">12-06</span>
                    </li>
                </ul>
            </div>
        </div>
		<!--最新发布 end-->	
    </div>
</section>