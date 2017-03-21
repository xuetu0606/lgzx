<?php
class Main_model extends CI_Model {


    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }
    /**
     * 根据url获取城市简码
     */
    public function getCityCode(){
    	$host = $_SERVER['HTTP_HOST'];
    	$host_arr = explode('.',$host);
/*    	if(strpos($host_arr[0],'-m')){
    		$citycode = str_replace("-m","",$host_arr[0]);
    	}else{
    		$citycode = 'qd';
    	}*/
    	$citycode = $host_arr[0];
    	return $citycode;
    }
     /**
     * 切换城市页，根据上一级URL地址获取城市简码
     */
        public function getCityCode2(){
    	$host = $_SERVER['HTTP_REFERER'];
    	$host_arr = explode('.',$host);
    	$citycode = substr($host_arr[0],7,2);
    	//$a = parse_url($host);
    	return $citycode;
    }
    /**
     *根据简码获取城市id和名称
     *
     */
    public function getCityInfoByCode($code){
    	$sql = "select district_dic.id,province_city.name,province_city.pinyin,province_city.pre_dist_id from district_dic 
				inner join province_city on province_city.dist_id=district_dic.id and province_city.level=2 ";

		$query = $this->db->query($sql);
		while($row = $query->unbuffered_row('array')){
			$arr[$row['pinyin']] = array('id'=>$row['id'],'name'=>$row['name'],'pro_id'=>$row['pre_dist_id']);
		}
		return $arr[$code];   	
    }

    /*
    *   获取全国省份、城市
    *   
    *   返回值：省份、城市数组
     */
    public function get_provinc_city(){
    	$sql = "select dist_id,name,pinyin,level,pre_dist_id from province_city  ";
    	$query = $this->db->query($sql);
    	$list = array();
    	while ($row = $query->unbuffered_row('array')) {
    		if($row['level']==1){
    			$list[$row['dist_id']] = array('name'=>$row['name']); 
    		}elseif($row['level']==2){
    			$list[$row['pre_dist_id']]['sub'][$row['pinyin']]= $row['name'];
    		}
    	}
    	return $list;
    }


    /**
     * 获取城市拼音首字母列表
     * 
     */
    public function getCityGroup(){
    	$sql = "SELECT left(pinyin,1) as py from province_city 
				where level=2 group by left(pinyin,1)";
    	$query = $this->db->query($sql);
    	$list = $query->result_array();
    	return $list;

    }
    /**
     * 获取城市根据拼音分组的详细列表
     *
     * @return unknown
     */
    public function getCityList(){
    	$sql = "SELECT left(pinyin,1) as py ,pinyin,name from province_city 
				where level=2 
				order by py ";
    	$query = $this->db->query($sql);
    	while($row = $query->unbuffered_row('array')){
			$arr[$row['py']][$row['pinyin']] = $row['name'];
			$arr1[$row['name']] = $row['pinyin']; 
		}
		return array($arr,$arr1);
    }
    /**
     * 根据城市获取区县和片区
     *
     */
    public function getDistArea(){
    	$citycode = $this->getCityCode();
    	$cityid = $this->getCityInfoByCode($citycode);
//    	print_r($cityid);
    	$sql = "select district_dic.id,district_dic.name,dist_dic.id as id1,dist_dic.name as name1 
				from district_dic 
    			inner join district_dic dist_dic on district_dic.id = dist_dic.upid and dist_dic.level=4
    			where district_dic.upid = '{$cityid['id']}' and district_dic.level=3";
//    	echo $sql;
    	$query = $this->db->query($sql);
    	while($row = $query->unbuffered_row('array')){
//    		var_dump($row);
    		$arr[$row['id']] = $row['name'];
    		$arr1[$row['id']][$row['id1']] = $row['name1'];
    	}
    	$this->list_dist = $arr;
    	$this->list_area = $arr1;
//    	print_r($arr);
//    	print_r($arr1);exit;
    	
    }
    /**
     * 根据当前城市获取该城市所在省份的所有城市和行政区
     * 返回 城市数组和城市行政区数组
     */
	public function getCityDist(){
		$citycode = $this->getCityCode();
		$cityid = $this->getCityInfoByCode($citycode);
		$pro_arr = $this->getprovinc($cityid['id']);
		$province_id = $pro_arr[0]['upid'];
		$sql = "SELECT district_dic.id as city_id ,district_dic.name as city_name ,dist_dic.id as dist_id , dist_dic.name as dist_name FROM `district_dic`
inner join district_dic dist_dic on district_dic.id=dist_dic.upid and dist_dic.level=3
where district_dic.upid='{$province_id}' and district_dic.level=2 ";
//		print_r($pro_arr);
		$query = $this->db->query($sql);
		while($row = $query->unbuffered_row('array')){
			$arr_city[$row['city_id']] = $row['city_name'];
			$arr_city_dist[$row['city_id']][$row['dist_id']] = $row['dist_name'];
		}
//		print_r($arr_city);
//		print_r($arr_city_dist);
		$this->province_id = $province_id;  //省份编码
		$this->arr_city = $arr_city; //城市数组
		$this->arr_city_dist = $arr_city_dist; //城市行政区数组
	}
	 /**
     * 根据城市id获取省份id
     *参数：城市id		return :省份id
     */
	public function getprovinc($c_id){
		$sql = "select upid from district_dic where id={$c_id}";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/**
	 * 时间转换
	 *
	 * @param unknown_type $time
	 * @param unknown_type $str  格式化后时间后面追加的文本
	 * @return unknown
	 */
	public function time_tran($time,$str=''){
	    $now_time = time();  
	    $now_date = date("Y-m-d", $now_time);  
	    //echo $now_time;  
	    $the_time = date("Y-m-d",$time);  
	    $dur = $now_time - $time;  
//	    var_dump($this_time);echo 'aaaaa';exit;
	    if ($dur < 0) {  
	        return $the_time;  
	    } else {  
	        if ($dur < 60) {  
	            return $dur . '秒前'.$str;  
	        } else {   
	            if ($dur < 3600) {  
	                return floor($dur / 60) . '分钟前'.$str;  
	            } else { 
	                if ($dur < 24*3600) {  
	                    return floor($dur / 3600) . '小时前'.$str;  
	                } else {   
	                    if ($dur < 259200) {//3天内  
	                        return floor($dur / 86400) . '天前'.$str;  
	                    } else { 
	                        return $the_time;  
	                    }  
	                }  
	            }  
	        }  
	    };  
	}
	//函数:通用提示
//参数:提示訊息,類型或網址,窗口名或函數名,延时毫秒Alert("","function","close2",300);
	public function alert($Str,$Typ="back",$TopWindow="",$Tim=100){
	    Echo "<script>".Chr(10);
	    If(!Empty($Str)){
	        Echo "alert(\"\\n\\n{$Str}\\n\\n\");".Chr(10);
	    }
	 
	    Echo "function _r_r_(){";
	    $WinName=(!Empty($TopWindow))?"top":"self";
	    Switch (StrToLower($Typ)){
	    Case "#":
	        Break;
	    Case "back":
	        Echo $WinName.".history.go(-1);".Chr(10);
	        Break;
	    Case "reload":
	        Echo $WinName.".window.location.reload();".Chr(10);
	        Break;
	    Case "close":
	        Echo "window.opener=null;window.close();".Chr(10);
	        Break;
	    Case "function":
	        Echo "var _T=new Function('return {$TopWindow}')();_T();".Chr(10);
	        Break;
	        //Die();
	    Default:
	        If($Typ!=""){
	            //Echo "window.{$WinName}.location.href='{$Typ}';";
	            Echo "window.{$WinName}.location=('{$Typ}');";
	        }
	    }
	 
	    Echo "}".Chr(10);
	 
	    //為防止Firefox不執行setTimeout
	    Echo "if(setTimeout(\"_r_r_()\",".$Tim.")==2){_r_r_();}";
	    IF($Tim==100){
	        Echo "_r_r_();".Chr(10);
	    }Else{
	        Echo "setTimeout(\"_r_r_()\",".$Tim.");".Chr(10);
	    }
	    Echo "</script>".Chr(10);
	    Exit();
	}
/**
 * 添加消息文件
 *
 * @param array $data ----- uid,title,message
 * 
 */
	public function addMessage($data){
		extract($data);
		$time = time();
		$sql = "insert into `user_message_log`(uid,title,message,addtime,updatetime)
				values ('$uid','$title','$message','$time','$time'); ";
		if($query = $this->db->query($sql)){
			return true;
		}else{
			return false;
		}
	}


/*
*	根据城市id获取城市名
* 	参数：城市id
 */
	public function getcityName($city_id){
		$sql = "select name from district_dic where id={$city_id}";
		$query = $this->db->query($sql);

		$arr = $query->row_array();

		//处理省市区域名称，过滤最后一位
		if(mb_substr($arr['name'],-1,1)=='区'||mb_substr($arr['name'],-1,1)=='市'){
    	$arr['name'] = mb_substr($arr['name'],0,-1);}

		return $arr;
	}

	/**
	 *	根据城市名获取城市简码
	 *   参数：城市名称
	 *   返回值：城市简码
	 */
	public function cnameGetCcode($cname){
		$sql = "select pinyin from province_city where name='{$cname}' and level=2";
		$query = $this->db->query($sql);
		$arr = $query->row_array();

		return $arr;
	}

}