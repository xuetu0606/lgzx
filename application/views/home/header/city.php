<script src="/static/js/jquery.js"></script>
<?php if($flag == 1){//如果来源非本站或无来源则跳转到指定城市首页
 //****调用新浪接口根据用户IP获取用户当前城市**********/
function getip(){ 
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
        $ip = getenv("HTTP_CLIENT_IP"); 
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
        $ip = getenv("HTTP_X_FORWARDED_FOR"); 
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
        $ip = getenv("REMOTE_ADDR"); 
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
        $ip = $_SERVER['REMOTE_ADDR']; 
    else 
        $ip = "unknown"; 
    return($ip); 
} 
function getIPLoc_sina($queryIP){ 
    $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=' . $queryIP; 
    $ch = curl_init($url);//初始化url地址 
    curl_setopt($ch, CURLOPT_ENCODING, 'utf8');//设置一个cURL传输选项 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回 
    $location = curl_exec($ch);//执行一个cURL会话 
    $location = json_decode($location);//对 JSON 格式的字符串进行编码 
    curl_close($ch);//关闭一个cURL会话 
    $loc = ""; 
    if ($location === FALSE) return "地址不正确"; 
    if (empty($location->desc)) { 
        $loc = $location->city;
    } else { $loc = $location->desc;} 
    return $loc; 
} 
 
$SA_IP=getip(); //ip地址
$city = getIPLoc_sina($SA_IP);  //城市名

//echo $city;
//var_dump($citylist_json);
?>
<script type="text/javascript">
    var city = "<?php echo $city; ?>";
    //alert(city);
    $.ajax({
        url:'<?php echo site_url('home/currentCity')?>',
        type:'POST',
        //dataType:'json',
        data:{city:city},
        cache:false,
        error:function(){
            //alert('失败');
        },
        success:function(data){
            //alert('成功');
            //var code = eval(data);
            var code = JSON.parse(data);
            //alert(code.pinyin);
            window.location='http://' + code.pinyin + '.lg-zx.com';
        }
    });
</script>

<?php }else{?>
<link rel="stylesheet" href="/static/css/changeCity.css"/>
<section>
    <div class="logo">
        <img src="/static/images/LOGOa.png" alt=""/>
    </div>
    <div class="search">
        <form action="<?php echo site_url('home/searchCity'); ?>" class="formsousuo" method="POST" >
                <input type="text" placeholder="搜索城市" class="sousuo" name='city'/>
                <input type='submit' value="" class='sousuo' />
            <!--     <a class="sousuo">
                <img src="/static/images/city/fdj.png" alt=""/>
                <input type='image' src="/static/images/city/fdj.png" />
            </a> -->
        </form>
        <div class="hotcity">
            <span class="hot">热门城市</span>
            <a href="http://bj.lg-zx.com">北京</a>
            <a href="http://sh.lg-zx.com">上海</a>
            <a href="http://gz.lg-zx.com">广州</a>
            <a href="http://sz.lg-zx.com">深圳</a>
            <a href="http://cq.lg-zx.com">重庆</a>
            <a href="http://cd.lg-zx.com">成都</a>
            <a href="http://hz.lg-zx.com">杭州</a>
            <a href="http://nj.lg-zx.com">南京</a>
            <a href="http://wh.lg-zx.com">武汉</a>
            <a href="http://tj.lg-zx.com">天津</a>
        </div>
    </div>
<?php //var_dump($citylist); ?>
    <div class="cities">
        <?php foreach($citylist as $key => $value){ 
            if($value['name'] != '北京' && $value['name'] != '天津' && $value['name'] != '上海' && $value['name'] != '重庆' && $value['name'] != '台湾' && $value['name'] != '香港' && $value['name'] != '澳门'){
            ?>
            <span class="pro"><?php echo $value['name']; ?></span>
            <div class="container">
            <?php foreach($value['sub'] as $k => $v){ ?>
                <a href="http://<?php echo "$k.lg-zx.com"; ?>"><?php echo $v; ?></a>
            <?php } ?>
            </div>
        <?php }} ?>
    </div>
</section>

<?php } ?>