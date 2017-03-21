<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?> - 零工在线</title>
    <link rel="stylesheet" href="/static/css/head-foot.css"/>
    <link rel="stylesheet" href="/static/css/common.css"/>
    <script src="/static/js/jquery.js"></script>
    <script src="/static/js/head-foot.js"></script>
</head>
<body>
<header>
<?php //****调用新浪接口根据用户IP获取用户当前城市**********/
 
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


?>
<script type="text/javascript">
    function findWeather() {  
        var cityUrl = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js';  
        $.getScript(cityUrl, function(script, textStatus, jqXHR) {  
            //var citytq = remote_ip_info.city ;
            var citytq = "<?php echo $cityname?$cityname:$city; ?>";
            //alert(citytq);
            // 获取当前城市（'北京'，'上海'等市级字符串）  
            var url = "http://php.weather.sina.com.cn/iframe/index/w_cl.php?code=js&city=" + citytq + "&day=0&dfc=3";  
            $.ajax({  
                url : url,  
                dataType : "script",  
                scriptCharset : "gbk",  
                success : function(data) {  
                    var _w = window.SWther.w[citytq][0];  
                    //_w 获得的是一个对象 其中有d1,d2,p1,p2,f1,f2,s1,s2,等属性  
                    // (d,p,f,s分别表示风向，风的等级，天气图标，天气，下表1，2分别表示白天和晚上)，  
                    // t1,t2表示最高和最低温度。  
                    var _f= _w.f1+"_0.png";  
                    var img = "<img width='16px' height='16px' class='weather-condition' src='http://i2.sinaimg.cn/dy/main/weather/weatherplugin/wthIco/20_20/" +_f + "' />";  
                    $('.weather').prepend(img);
                    var tq = citytq + " " + img + " " + _w.s1 + " " + _w.t1 + "℃～" + _w.t2 + "℃  " + _w.d1 + _w.p1 + "级";  
                   var w = _w.s1 + "  " + _w.t1 + "℃～" + _w.t2 + "℃  " + _w.d1 + _w.p1 + "级";
                    $('#w').html(w);//拼上天气、温度、风速，并写入标签中
                    if(new Date().getHours() > 17){  
                        _f= _w.f2+"_1.png";  
                        tq = citytq + " " + img + " " + _w.s2 + " " + _w.t1 + "℃～" + _w.t2 + "℃  " + _w.d2 + _w.p2 + "级";  
                    }  
                    //alert(tq)  
                }  
            });  
        });  
    }  
    findWeather() //成都 <img width='16px' height='16px' src='http://i2.sinaimg.cn/dy/main/weather/weatherplugin/wthIco/20_20/duoyun_0.png' /> 多云 14℃～3℃  北风≤3级  
</script>
    <div class="main">
        <div class="city">
            <span class="stress"><?php echo $cityname?$cityname:$city; ?></span>
            <a href="http://pc.lg-zx.com">[切换城市]</a>
        </div>
        <div class="weather">
            <!-- <img class="weather-condition" src="/static/images/head-foot/weather.png"/> -->
            <span id='w'></span>
            <!-- <span class="air-condition liang">良</span> -->
        </div>
        <div class="fr">
            <ul>
                <li><a href="<?php echo site_url('user/reg'); ?>">注册</a></li>
                <li><a href="<?php echo site_url('user/login'); ?>">登录</a></li>
                <li class="lgbxl"><a href="#">零工宝</a><img src="/static/images/xiala.png" alt=""/></li>
                <li class="stress wxb">微信版</li>
                <li><a href="#" class="stress">手机版</a></li>
                <li><a href="#">帮助</a></li>
            </ul>
            <div class="lgb">
                <a href="#">零工宝<img src="/static/images/xiala.png" alt="" /></a>
                <a href="#" class="lgba">我的发布</a>
                <a href="#" class="lgba">我的收藏</a>
                <a href="#" class="lgba">我的资料</a>
            </div>
            <div class="wx">
                <img src="/static/images/head-foot/weixin.png" alt=""/>
            </div>
        </div>
    </div>
</header>


