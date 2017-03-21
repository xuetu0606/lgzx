<style>
    section div.fenye a {
        padding: 0 5px;
        height: 35px;
        text-align: center;
        line-height: 35px;
        color: #333;
        font-size: 16px;
        margin: 0 5px;
        background-color: #ffffff;
        font-weight: bold;
        border: solid 1px #cccccc;
    }
</style>
<div class="content">
    <p class="title">
        <span class="gz-zlg">发布的工种</span>
        <?php if($_SESSION['is_co']){?>
        <span>招零工</span>
        <?php }?>
    </p>
    <p class="xz">
        <span class="xsxx">显示中的信息</span>
        <span>已删除的信息</span>
        <span>未显示的信息</span>
    </p>
    <div class="fbgz">
        <h1 class="zwsj">暂无数据!</h1>
        <div class="now">
            <form action="/pub/del/type/gz/ac/del" method="get">
                <?php foreach ($gong as $k):?>
                <div class="demo">
                    <input type="checkbox" class="should-check" name="del_check[]" value="<?php echo $k['id']?>"/>
                    <div class="right">
                        <p class="xxbh">
                            <span>信息编号：</span>
                            <span><?php echo $k['id']?></span>
                        </p>
                        <div class="jsh">
                            <?php $img=explode(',',$k['img']);$img=explode('.',$img[0])?>
                            <img src="/upload/<?php echo $k['pinyin']?>/lgxx/<?php echo $_SESSION['uid']?>/<?php echo $img[0]?>_150_100.jpg" alt=""/>
                            <div class="m">
                                <h1><?php echo $k['info1']?></h1>
                                <h2><?php echo $k['name'].'-'.$k['zhi_name'].'-'.$k['job_name']?></h2>
                                <h3>
                                    <span><?php echo date('Y-m-d',$k['addtime'])?></span>
                                    <span><?php echo date('h:m',$k['addtime'])?></span>
                                </h3>
                            </div>
                            <div class="r">
                                <a href="<?php echo site_url('user/dealMyInfo/type/gz/ac/flush/id/'.$k['id'])?>">刷新</a>
                                <a href="/pub/edit/<?php echo $k['id']?>">修改</a>
                                <!--<a href="/pub/edit">下架</a>-->
                                <a href="javascript:void(0);" onclick="if(confirm('确定要删除吗？')){window.location.href='<?php echo site_url('user/dealMyInfo/type/gz/ac/del/id/'.$k['id'])?>';}else{return false;}" class="delete">删除</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
                <div class="acheck">
                    <input class="allcheck" type="checkbox">
                    <span>全选 </span>
                    <input type="submit" value="删除">
                </div>
            </form>
            <div class="fenye">
                <?php echo $page;?>
            </div>
        </div>
        <div class="deleted">
            <form action="/pub/del/type/gz/ac/del" method="get">
                <?php foreach ($gong_del as $k):?>
                    <div class="demo">
                        <input type="checkbox" class="should-check" name="del_check[]" value="<?php echo $k['id']?>"/>
                        <div class="right">
                            <p class="xxbh">
                                <span>信息编号：</span>
                                <span><?php echo $k['id']?></span>
                            </p>
                            <div class="jsh">
                                <?php $img=explode(',',$k['img']);$img=explode('.',$img[0])?>
                                <img src="/upload/<?php echo $k['pinyin']?>/lgxx/<?php echo $_SESSION['uid']?>/<?php echo $img[0]?>_150_100.jpg" alt=""/>
                                <div class="m">
                                    <h1><?php echo $k['info1']?></h1>
                                    <h2><?php echo $k['name'].'-'.$k['zhi_name'].'-'.$k['job_name']?></h2>
                                    <h3>
                                        <span><?php echo date('Y-m-d',$k['addtime'])?></span>
                                        <span><?php echo date('h:m',$k['addtime'])?></span>
                                    </h3>
                                </div>
                                <div class="r">
                                    <a href="<?php echo site_url('user/dealMyInfo/type/gz/ac/flush/id/'.$k['id'])?>">刷新</a>
                                    <a href="/pub/edit/<?php echo $k['id']?>">修改</a>
                                    <!--<a href="/pub/edit">下架</a>-->
                                    <a href="javascript:void(0);" onclick="if(confirm('确定要删除吗？')){window.location.href='<?php echo site_url('user/dealMyInfo/type/gz/ac/del/id/'.$k['id'])?>';}else{return false;}" class="delete">删除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </form>
            <div class="fenye">
            </div>
        </div>
        <div class="before">
            <form action="/pub/del/type/gz/ac/del" method="get">
                <?php foreach ($gong_not as $k):?>
                    <div class="demo">
                        <input type="checkbox" class="should-check" name="del_check[]" value="<?php echo $k['id']?>"/>
                        <div class="right">
                            <p class="xxbh">
                                <span>信息编号：</span>
                                <span><?php echo $k['id']?></span>
                            </p>
                            <div class="jsh">
                                <?php $img=explode(',',$k['img']);$img=explode('.',$img[0])?>
                                <img src="/upload/<?php echo $k['pinyin']?>/lgxx/<?php echo $_SESSION['uid']?>/<?php echo $img[0]?>_150_100.jpg" alt=""/>
                                <div class="m">
                                    <h1><?php echo $k['info1']?></h1>
                                    <h2><?php echo $k['name'].'-'.$k['zhi_name'].'-'.$k['job_name']?></h2>
                                    <h3>
                                        <span><?php echo date('Y-m-d',$k['addtime'])?></span>
                                        <span><?php echo date('h:m',$k['addtime'])?></span>
                                    </h3>
                                </div>
                                <div class="r">
                                    <a href="<?php echo site_url('user/dealMyInfo/type/gz/ac/flush/id/'.$k['id'])?>">刷新</a>
                                    <a href="/pub/edit/<?php echo $k['id']?>">修改</a>
                                    <!--<a href="/pub/edit">下架</a>-->
                                    <a href="javascript:void(0);" onclick="if(confirm('确定要删除吗？')){window.location.href='<?php echo site_url('user/dealMyInfo/type/gz/ac/del/id/'.$k['id'])?>';}else{return false;}" class="delete">删除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
                <div class="acheck">
                    <input class="allcheck" type="checkbox">
                    <span>全选 </span>
                    <input type="submit" value="删除">
                </div>
            </form>
            <div class="fenye">
            </div>
        </div>
    </div>
    <?php if($_SESSION['is_co']){?>
        <div class="zlg">
            <h1 class="zwsj">暂无数据!</h1>
            <div class="now">
                <form action="/pub/del/type/gz/ac/del" method="get">
                    <?php foreach ($zlg as $k):?>
                        <div class="demo">
                            <input type="checkbox" class="should-check" name="del_check[]" value="<?php echo $k['id']?>"/>
                            <div class="right">
                                <p class="xxbh">
                                    <span>信息编号：</span>
                                    <span><?php echo $k['id']?></span>
                                </p>
                                <div class="jsh">
                                    <?php $img=explode(',',$k['img']);$img=explode('.',$img[0])?>
                                    <img src="/upload/<?php echo $k['pinyin']?>/lgxx/<?php echo $_SESSION['uid']?>/<?php echo $img[0]?>_150_100.jpg" alt=""/>
                                    <div class="m">
                                        <h1><?php echo $k['info1']?></h1>
                                        <h2><?php echo $k['name'].'-'.$k['zhi_name'].'-'.$k['job_name']?></h2>
                                        <h3>
                                            <span><?php echo date('Y-m-d',$k['addtime'])?></span>
                                            <span><?php echo date('h:m',$k['addtime'])?></span>
                                        </h3>
                                    </div>
                                    <div class="r">
                                        <a href="<?php echo site_url('user/dealMyInfo/type/gz/ac/flush/id/'.$k['id'])?>">刷新</a>
                                        <a href="/pub/edit/<?php echo $k['id']?>">修改</a>
                                        <!--<a href="/pub/edit">下架</a>-->
                                        <a href="javascript:void(0);" onclick="if(confirm('确定要删除吗？')){window.location.href='<?php echo site_url('user/dealMyInfo/type/gz/ac/del/id/'.$k['id'])?>';}else{return false;}" class="delete">删除</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                    <div class="acheck">
                        <input class="allcheck" type="checkbox">
                        <span>全选 </span>
                        <input type="submit" value="删除">
                    </div>
                </form>
                <div class="fenye">
                    <?php echo $page;?>
                </div>
            </div>
            <div class="deleted">
                <form action="/pub/del/type/gz/ac/del" method="get">
                    <?php foreach ($zlg_del as $k):?>
                        <div class="demo">
                            <input type="checkbox" class="should-check" name="del_check[]" value="<?php echo $k['id']?>"/>
                            <div class="right">
                                <p class="xxbh">
                                    <span>信息编号：</span>
                                    <span><?php echo $k['id']?></span>
                                </p>
                                <div class="jsh">
                                    <?php $img=explode(',',$k['img']);$img=explode('.',$img[0])?>
                                    <img src="/upload/<?php echo $k['pinyin']?>/lgxx/<?php echo $_SESSION['uid']?>/<?php echo $img[0]?>_150_100.jpg" alt=""/>
                                    <div class="m">
                                        <h1><?php echo $k['info1']?></h1>
                                        <h2><?php echo $k['name'].'-'.$k['zhi_name'].'-'.$k['job_name']?></h2>
                                        <h3>
                                            <span><?php echo date('Y-m-d',$k['addtime'])?></span>
                                            <span><?php echo date('h:m',$k['addtime'])?></span>
                                        </h3>
                                    </div>
                                    <div class="r">
                                        <a href="<?php echo site_url('user/dealMyInfo/type/gz/ac/flush/id/'.$k['id'])?>">刷新</a>
                                        <a href="/pub/edit/<?php echo $k['id']?>">修改</a>
                                        <!--<a href="/pub/edit">下架</a>-->
                                        <a href="javascript:void(0);" onclick="if(confirm('确定要删除吗？')){window.location.href='<?php echo site_url('user/dealMyInfo/type/gz/ac/del/id/'.$k['id'])?>';}else{return false;}" class="delete">删除</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </form>
                <div class="fenye">
                    <?php echo $page_del;?>
                </div>
            </div>
            <div class="before">
                <form action="/pub/del/type/gz/ac/del" method="get">
                    <?php foreach ($gong_not as $k):?>
                        <div class="demo">
                            <input type="checkbox" class="should-check" name="del_check[]" value="<?php echo $k['id']?>"/>
                            <div class="right">
                                <p class="xxbh">
                                    <span>信息编号：</span>
                                    <span><?php echo $k['id']?></span>
                                </p>
                                <div class="jsh">
                                    <?php $img=explode(',',$k['img']);$img=explode('.',$img[0])?>
                                    <img src="/upload/<?php echo $k['pinyin']?>/lgxx/<?php echo $_SESSION['uid']?>/<?php echo $img[0]?>_150_100.jpg" alt=""/>
                                    <div class="m">
                                        <h1><?php echo $k['info1']?></h1>
                                        <h2><?php echo $k['name'].'-'.$k['zhi_name'].'-'.$k['job_name']?></h2>
                                        <h3>
                                            <span><?php echo date('Y-m-d',$k['addtime'])?></span>
                                            <span><?php echo date('h:m',$k['addtime'])?></span>
                                        </h3>
                                    </div>
                                    <div class="r">
                                        <a href="<?php echo site_url('user/dealMyInfo/type/gz/ac/flush/id/'.$k['id'])?>">刷新</a>
                                        <a href="/pub/edit/<?php echo $k['id']?>">修改</a>
                                        <!--<a href="/pub/edit">下架</a>-->
                                        <a href="javascript:void(0);" onclick="if(confirm('确定要删除吗？')){window.location.href='<?php echo site_url('user/dealMyInfo/type/gz/ac/del/id/'.$k['id'])?>';}else{return false;}" class="delete">删除</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                    <div class="acheck">
                        <input class="allcheck" type="checkbox">
                        <span>全选 </span>
                        <input type="submit" value="删除">
                    </div>
                </form>
                <div class="fenye">
                    <?php echo $page_not;?>
                </div>
            </div>
        </div>
    <?php }?>

</div>