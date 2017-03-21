<?php
class User_model extends CI_Model {


    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model('string_model');
    }
    /**
     * 获取省份列表
     *返回值数组：省份编码=>省份名称
     */
    public function getProvince(){
    	$sql = "select dist_id,name from province_city where level=1 ";
    	$query = $this->db->query($sql);
    	$list = array();
    	while ($row = $query->unbuffered_row('array')) {
    		$list[$row['dist_id']] = $row['name'];
    	}
    	return $list;
    }
    /**
     * 获取省份城市列表
     * 返回值数组格式：
     * array([省份编码] => Array ( [name] => 省份名称
            					  [sub] => Array(
                    								[城市编码] => 城市名称,
                    								[城市编码] => 城市名称,
                    								……)
     							)
     		  …… )
     */
    public function getProvinceCity(){
    	$sql = "select dist_id,name,level,pre_dist_id from province_city  ";
    	$query = $this->db->query($sql);
    	$list = array();
    	while ($row = $query->unbuffered_row('array')) {
    		if($row['level']==1){
    			$list[$row['dist_id']] = array('name'=>$row['name']); 
    		}elseif($row['level']==2){
    			$list[$row['pre_dist_id']]['sub'][$row['dist_id']]= $row['name'];
    		}
    	}
    	return $list;
    }
    /**
     * 根据省份获取该省份下城市列表
     * 参数：pro_id:省份码
     * 返回值数组：城市编码=>城市名称
     */
    public  function getCityByProvince($pro_id){
    	$sql = "select dist_id,name from province_city where level=2 and pre_dist_id='$pro_id'";
    	$query = $this->db->query($sql);
    	$list = array();
    	while ($row = $query->unbuffered_row('array')) {
    		$list[$row['dist_id']] = $row['name'];
    	}
    	return $list;
    }

    /**
     * 获取全部城市列表
     *
     * 返回值数组：城市编码=>城市名称
     */
    public  function getAllCity(){
        $sql = "select pre_dist_id,dist_id,name from province_city where level=2 ";
        $query = $this->db->query($sql);
        $list = array();
        while ($row = $query->unbuffered_row('array')) {
            $list[$row['pre_dist_id']][$row['dist_id']] = $row['name'];
        }
        return $list;
    }

/**
 * 注册用户
 * @param 数组 $data:【个人用户】  username-用户名 ，password-加密密码，email-邮箱，referer-推介人，p_id-省份编码，c_id-城市编码，mobile-手机，is_co-是否公司（公司1，个人0），$realname-个人用户姓名
 * @param 数组 $data: 【公司用户】 username-用户名 ，password-加密密码，email-邮箱，referer-推介人，p_id-省份编码，c_id-城市编码，mobile-手机，is_co-是否公司（公司1，个人0），$coname-公司名
 * 返回值：若添加失败则返回array('flag'=>-1,'info'=>'失败提示');成功则返回array('flag'=>1,'uid');
 * 
 */
    public function addUser($data){
    	extract($data);
    	$time_now = time();
    	$username= trim($username);
    	$mobile= trim($mobile);
    	$password= trim($password);
    	//检查用户名是否已存在
    	if($this->checkUsername($username)){
    		return array('flag'=>-1,'info'=>'非常抱歉，用户名已被使用请修改!');
    	}
    	//检查手机号是否已存在
    	if($this->checkMobile($mobile)){
    		return array('flag'=>-1,'info'=>'非常抱歉，手机号码已注册!');
    	}
    	//检查手机号是否有效
    	if(!$this->checkIsMobile($mobile)){
    		return array('flag'=>-1,'info'=>'非常抱歉，手机号码填写错误请检查!');
    	}
    	if(!trim($password)){
    		return array('flag'=>-1,'info'=>'密码是必填项，请检查后提交!');
    	}
    	//生成工号uid
    	$new_uid = $this->addUid();
    	if($new_uid){
    		 //添加注册用户记录,返回uid,注册送10工分
	    	$sql = "insert into userlist set  no='$new_uid',username='$username',password='$password' ,email='$email',referrer='$referer',
	    			province_id='$p_id',city_id='$c_id',mobile='$mobile',is_co='$is_co',addtime='$time_now',updatetime='$time_now',credit1=10,credit1_updatetime='$time_now'";
	    	if($query = $this->db->query($sql)){
	    		$query_u = $this->db->query("select uid from userlist where no='$new_uid'");
	    		$arr = $query_u->row_array();
	    		if($is_co==1){//公司类型
		    		$sql1 = "insert into user_co set uid='{$arr['uid']}',coname='$coname',updatetime='$time_now' ";
		    	}else{//个人类型
		    		$sql1 = "insert into user_personal set uid='{$arr['uid']}',realname='$realname',updatetime='$time_now' ";
		    	}
		    	if($this->db->query($sql1)){//写入工分日志
		    		$sql = "insert into user_credits_log set uid='{$arr['uid']}',type='credit1',way_id=1,credits=10,addtime='$time_now'";
		    		$this->db->query($sql);
		    	}else{
		    		//数据回滚，还没做

		    		return array('flag'=>-1,'info'=>'非常抱歉，添加新用户类型失败，请稍后重试!');
		    	}
	    	}else{
	    		return array('flag'=>-1,'info'=>'非常抱歉，添加新用户失败，请稍后重试!');
	    	}
    	}else{
    		return array('flag'=>-1,'info'=>'非常抱歉，生成新用户失败，请稍后重试!');
    	}
		return array('flag'=>1,'uid'=>$arr['uid'],'no'=>$new_uid,'is_co'=>$is_co);
    }
    /**
 * 注册用户
 * @param 数组 $data:【个人用户】 p_id-省份编码，c_id-城市编码，mobile-手机，
 
 * 返回值：若添加失败则返回array('flag'=>-1,'info'=>'失败提示');成功则返回array('flag'=>1,'uid');
 * 
 */
    public function addUseAuto($data){
    	extract($data);
    	$time_now = time();
    	$mobile= trim($mobile);
    	
    	//检查手机号是否已存在
    	if($this->checkMobile($mobile)){
    		return array('flag'=>-1,'info'=>'非常抱歉，手机号码已注册!');
    	}
    	//检查手机号是否有效
    	if(!$this->checkIsMobile($mobile)){
    		return array('flag'=>-1,'info'=>'非常抱歉，手机号码填写错误请检查!');
    	}
    	//var_dump($c_id);var_dump($p_id);var_dump($mobile);/************************/
    	//生成工号uid
    	$new_uid = $this->addUid();
    	$username= "用户".trim($new_uid);
    	$password= trim($this->encryptPwd('123456'));
    	if($new_uid){
    		 //添加注册用户记录,返回uid,注册送10工分
	    	$sql = "insert into userlist set  no='$new_uid',username='$username',password='$password' ,email='$email',referrer='$referer',
	    			province_id='$p_id',city_id='$c_id',mobile='$mobile',is_co='0',addtime='$time_now',updatetime='$time_now',credit1=10,credit1_updatetime='$time_now'";
	    	if($query = $this->db->query($sql)){
	    		$query_u = $this->db->query("select uid from userlist where no='$new_uid'");
	    		$arr = $query_u->row_array();
	    		if($is_co==1){//公司类型
		    		$sql1 = "insert into user_co set uid='{$arr['uid']}',coname='$coname',updatetime='$time_now' ";
		    	}else{//个人类型
		    		$sql1 = "insert into user_personal set uid='{$arr['uid']}',realname='$realname',updatetime='$time_now' ";
		    	}
		    	if($this->db->query($sql1)){//写入工分日志
		    		$sql = "insert into user_credits_log set uid='{$arr['uid']}',type='credit1',way_id=1,credits=10,addtime='$time_now'";
		    		$this->db->query($sql);
		    	}else{
		    		//数据回滚，还没做

		    		return array('flag'=>-1,'info'=>'非常抱歉，添加新用户类型失败，请稍后重试!');
		    	}
	    	}else{
	    		return array('flag'=>-1,'info'=>'非常抱歉，添加新用户失败，请稍后重试!');
	    	}
    	}else{
    		return array('flag'=>-1,'info'=>'非常抱歉，生成新用户失败，请稍后重试!');
    	}
		return array('flag'=>1,'uid'=>$arr['uid'],'no'=>$new_uid,'is_co'=>$is_co);
    }
    /**
     * 检查用户名是否已存在
     *存在则返回id 否则返回false
     */
    public function checkUsername($username){
    	$sql = "select uid from userlist where username='$username'";
    	$query = $this->db->query($sql);
    	$arr = $query->row_array();
    	if($arr){
    		return $arr['uid'];
    	}else{
    		return false;
    	}
    }
    /**
     * 检查手机号是否已存在
     *存在则返回id 否则返回false
     */
    public function checkMobile($mobile){
    	$sql = "select uid,username from userlist where mobile='$mobile'";
    	$query = $this->db->query($sql);
    	$arr = $query->row_array();
    	if($arr){
        $this->username = $arr['username'];
    		return $arr['uid'];
    	}else{
    		return false;
    	}
    }
    /**
     * 检查手机号码有效性
     *
     */
    public function checkIsMobile($mobile){
        // var_dump(preg_match("/^1[345678]{1}\d{9}$/",$mobile));exit;
    	if(preg_match("/^1[345678]{1}\d{9}$/",$mobile)){  
		    return true; 
		}else{  
		    return false;
		} 
    }

    /*
    *根据工号查询uid,判断用户是否存在
    *参数：工号-$number
    *返回值：如果存在返回uid;如果不存在返回false;
    * 
     */
    public function numGetUid($number){
        $sql = "select uid from userlist where no={$number}";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
        if($arr){
            return $arr['uid'];
        }else{
            return false;
        }
    } 

     /*
    *根据uid向user_credits表插入评分数据(我要评价)、修改userlist表的评分
    *参数：uid-用户id;  credits-用户评价分  info-评价内容
    * 返回值：
     */
    public function addcredits($num,$credits,$info,$adduid){
        $time = time();
        $sql = "insert into user_credits_log(uid,type,way_id,credits,addtime,info,adduid) values({$num},'credit3',7,{$credits},{$time},'{$info}',{$adduid})";
        $query = $this->db->query($sql);
        if($query){
            $sql2 = "select credit3 from userlist where uid={$num}";//查询userlist表的评价分
            $query = $this->db->query($sql2);
            $arr = $query->row_array();
            $credit3 = $arr["credit3"];

            if($credit3 = $arr["credit3"]){
              $credit3 = ceil(($credit3+$credits)/2);//根据查询出来的分求平均值
            }else{
              $credit3 = $credits;
            }
            
            $sql3 = "update userlist set credit3={$credit3} where uid={$num}";//修改userlist表的评价分
            $query = $this->db->query($sql3);
        }
    }

    //根据uid获取评价内容
    public function getcredits($uid){
      $sql = "select uid,credits,addtime,info from user_credits_log where uid={$uid} and type='credit3' and way_id=7 order by addtime desc";
      $query = $this->db->query($sql);
      $arr = $query->result_array();
      return $arr;
    }

    /**
     * 生成新的工号uid
     * 规则：最新自增id+1
     *格式为：lg+数字编号，若最新id小于4位则前面加0补齐
     */
    public function addUid(){
    	$min_len = 3;//小于最小位数则前面加0补齐
    	$pr = "";//工号前缀
//    	$pr = "lg";//工号前缀
    	$query = $this->db->query("select max(uid) as uid from userlist ");
    	$id_arr = $query->row_array();
    	$max_id = $id_arr['uid']?($id_arr['uid']+1):1;
    	$len = strlen($max_id);
    	if($len<$min_len){//前面加0补齐
    		$i=0;
    		while($i<($min_len-$len)){
    			$max_id = "0".$max_id;
    			$i++;
    		}
    	}
    	$max_id = $pr.$max_id;
    	return $max_id;
    }
    /**
     * 根据mobile获取用户的名
     */
    public function getUserinfoByMobile($mobile){
    	$sql = "select uid,username from userlist where mobile='$mobile'";
    	$query = $this->db->query($sql);
    	$arr = $query->row_array();
    	if($arr){
    		return $arr;
    	}else{
    		return false;
    	}
    }
    /**
     * 根据uid获取用户基础信息
     */
    public function getUserinfoByUid($uid){
    	$sql = "select uid,username,mobile,address,city_id from userlist where uid='$uid'";
    	$query = $this->db->query($sql);
    	$arr = $query->row_array();
    	if($arr){
    		return $arr;
    	}else{
    		return false;
    	}
    }
    /**
     * 根据username获取用户基础信息
     */
    public function getUserinfoByUsername($username){
    	$sql = "select uid,mobile,address from userlist where username='$username'";
    	$query = $this->db->query($sql);
    	$arr = $query->row_array();
    	if($arr){
    		return $arr;
    	}else{
    		return false;
    	}
    }

        /*
    * 根据uid获取用户公司名和营业执照号
    * 
     */
    public function identifyinfo1($uid){
      $sql = "select coname,idno from user_co where uid={$uid}";
      $query = $this->db->query($sql);
      $arr = $query->row_array();
      return $arr;
    }

        /*
    * 根据uid获取用户真实姓名和身份证号码
    * 
     */
    public function identifyinfo2($uid){
      $sql = "select realname,idno from user_personal where uid={$uid}";
      $query = $this->db->query($sql);
      $arr = $query->row_array();
      return $arr;
    }

    /**
     * 给用户重置默认密码
     * 参数： mobile-用户手机；password-密码
     * 返回值：有该用户则返回uid，否则返回false
     */
    public function modifyPwd($mobile,$password){
    	$pwd = $this->encryptPwd($password);
    	$sql = "update userlist set password='$pwd' where mobile='$mobile'";
    	$query = $this->db->query($sql);
    	if($query){
    		return true;
    	}else{
    		return false;
    	}
    }
  /**密码加密
   * 参数pwd  密码明文
   *return 加密后密码
   */
    public function encryptPwd($pwd){
	     $salt = 'Random_sfqw2frhp3dd';
	     return md5($pwd.$salt);
    }
/**
 * 登陆验证并填写登录日志,半小时内同一个用户在同浏览器下日志不重复写入
 * 参数：$data数组-登录数据项，包含 username-用户名或手机号；passwd-加密后密码 
 * 返回值：有该用户则返回uid，否则返回false
 */
    public function getuserlist($data){
//    	$data = array('username'=>'shane','passwd'=>'123123');
    	extract($data);
    	$sql = "select uid,no,username,is_co from userlist where (username = '$username' or mobile='$username') and password = '$passwd'";
    	$query = $this->db->query($sql);
    	$arr = $query->row_array();   	
    	if($arr){
    		$browser = $this->getBrowser();
    		$sql2 = "select logintime from user_login_log where uid='{$arr['uid']}' and browser='$browser' ";
    		$query2 = $this->db->query($sql2);
    		$arr1 = $query2->row_array(); 
    		$time_now = time();
    		//未登陆过或超过半小时后则写入日志
    		if(!$arr1||($arr1&&($arr1['logintime']+60*30<$time_now))){
    			$ip = $this->getIP();
	    		$sql1 = "insert into user_login_log set uid='{$arr['uid']}',logintime=$time_now,ip='$ip',ismobile=1,browser='$browser'";
	    		$this->db->query($sql1);
    		}  
    		return $arr;
    	}else{
    		return false;
    	}
    }
    /**
     * 获取零工宝首页基础信息
     *
     * @param unknown_type $uid
     */
    public function getUserBaseInfo($uid){
      $this->load->model('Main_model');

        $user=$this->getUserinfoByUid($uid);
        $city = $this->getCityCode($user['city_id']);
        $citycode=$city['pinyin'];

    	$sql = "select uid,username,`no`,credit1,credit2,credit3,is_real,is_co 
				from userlist
				where uid='{$uid}' ";
    	$query = $this->db->query($sql);
    	$arr = $query->row_array();
    	if($arr['is_co']==1){//公司类型
				$sql2 = "select coname,img,idno from user_co where uid='{$uid}'";
				$img_src = "/upload/".$citycode."/gstx/";   
		}else{//个人类型
				$sql2 = "select realname,img,idno from user_personal where uid='{$uid}'";
				$img_src = "/upload/".$citycode."/grtx/";
		}
		$query1 = $this->db->query($sql2);
		$arr1 = $query1->row_array();

		$arr1['img'] = $arr1['img']?($img_src.$arr1['img']):"/static/images/default/noimg.jpg" ;
//			$row['idno'] = $row2['idno'] ;
			$arr['medal'] = "/static/images/section/3-list/";
			if($arr['is_real']){//是实名认证
				$arr['medal'] .= 'jin.png';
			}elseif($arr['credit3']>=17){
				$arr['medal'] .= 'jin.png';
			}elseif($arr['credit3']>=9){
				$arr['medal'] .= 'yin.png';
			}elseif($arr['credit3']>=4){
				$arr['medal'] .= 'tong.png';
			}else{
				$arr['medal'] .= 'wdj.png';
			}
			
		$time= time();
		//查看vip是否过期 有值则为vip
		$arr['vip_endtime'] = $this->isVip($uid);
		return array_merge($arr,$arr1);
		
    }
    /**
     * 充值
     * 参数data数据项: 
     * 				uid-uid，
     * 				type-类型，
     * 				wayid-方式，
     * 				credits-网站零工币、工分、信用积分本次变化数值，
     * 				cost-花费人民币
     * 返回值：array（‘flag’=>1或-1，info=>'失败提示信息'）
     */
    public function recharge($data){
//    	print_r($data);exit;
    	extract($data);
    	$now = time();
    	$sql = "insert into user_credits_log
				set uid='$uid',type='$type',way_id='$wayid',credits='$credits',addtime='$now',costs='$cost' ";
    	 $query = $this->db->query($sql);
    	 if($query){
    	 	if($type=='credit1' && $wayid=='2'){//人民币充值零工币
	    		$sql1 = "update userlist set credit1=credit1+'$credits',updatetime='$now' where uid='$uid' ";
	    		$query1 = $this->db->query($sql1);
	    		if($query1){
	    			return array('flag'=>1,$info=>'');
	    		}else{
	    			return array('flag'=>-1,'info'=>'非常抱歉，充值出现异常，请联系我们尽快处理！');
	    		}
	    	}elseif($type=='credit1' && $wayid=='3'){//发布工种
	    		if ($credits==0) {//会员免费发布工种
	    			return array('flag'=>1,$info=>'');
	    		}else{//非会员需要减掉花费的零工币数量
	    			$sql1 = "update userlist set credit1=credit1-'$credits',updatetime='$now' where uid='$uid' ";
		    		$query1 = $this->db->query($sql1);
		    		if($query1){
		    			return array('flag'=>1,$info=>'');
		    		}else{
		    			return array('flag'=>-1,'info'=>'非常抱歉，发布服务出现异常，请联系我们尽快处理！');
		    		}
	    		}
	    	}elseif($type=='credit1' && $wayid=='8'){//购买会员服务
	    		$sql1 = "update userlist set credit1=credit1-'$credits',updatetime='$now' where uid='$uid' ";
	    		$query1 = $this->db->query($sql1);
	    		if($query1){
	    			return array('flag'=>1,$info=>'');
	    		}else{
	    			return array('flag'=>-1,'info'=>'非常抱歉，购买服务出现异常，请联系我们尽快处理！');
	    		}
	    	
	    	}
    	 }else{
    	 	return array('flag'=>-1,'info'=>'非常抱歉，操作失败，请联系我们尽快处理！');
    	 }
    }
    /**
     * 购买会员服务
     *
     */
    public  function isVip($uid){
    	$time = time();
    	//查看vip是否过期 有值则为vip
		$sql = "select endtime as vip_endtime from user_service_log where uid='$uid' and endtime>'$time'";
		$query = $this->db->query($sql);
		$arr = $query->row_array();
    	return $arr['vip_endtime'];
    }
    /**
     * 根据uid获取用户当前零工币余额
     *
     * @param unknown_type $uid
     */
    public function getUserCredit1($uid){
    	$sql = "select credit1 from userlist where uid='$uid'";
    	$query = $this->db->query($sql);
		$arr = $query->row_array();
    	return $arr['credit1'];
    }
    /**
     * 根据uid获取用户当前零工币，工分，评价积分余额
     *
     * @param unknown_type $uid
     */
    public function getUsercredit($uid){
    	$sql = "select credit1,credit2,credit3 from userlist where uid='$uid'";
    	$query = $this->db->query($sql);
		$arr = $query->row_array();
    	return $arr;
    }
    /**
     * 取会员服务字典列表
     *
     */
    public function getServiceDic(){
    	$sql = "select * from vip_service_dic";
    	$query = $this->db->query($sql);
		while ($row = $query->unbuffered_row('array')) {
			$arr[$row['is_co']][] = $row;
		}
		return $arr;
    }
    /**
     * 购买vip服务
     *
     * @param unknown_type $data
     * data参数说明：uid-uid，vipid-服务id 对应vip_service_dic表id字段，credit-花费的零工币，startime-服务开始时间戳，endtime-服务结束时间戳
     * 返回值说明：array（flag=>[1成功，-1失败],info=>[失败原因]）
     */
    public function buyVipService($data){
    	extract($data);
    	$now = time();
    	$credit_pre = $this->getUserCredit1($uid);//剩余零工币数额
    	if($credit>$credit_pre){
    		return array('flag'=>-1,'info'=>'您的剩余零工币不足，请充值后再来购买会员服务！');
    	}else{
    		//存入会员服务日志表
	    	$sql = "insert into user_service_log set uid='$uid',vip_id='$vipid', credit1='$credit',starttime='$startime',endtime='$endtime', addtime='$now'";
//	    	var_dump($data);
//	    	echo $sql;
	    	$query = $this->db->query($sql);
			if($query){
				$this->addUserPromotion(array('uid'=>$uid,'vipid'=>$vipid));
				$temp = array('uid'=>$uid,'type'=>'credit1','wayid'=>'8','credits'=>$credit,'cost'=>0);
				//存入零工币日志并修改剩余零工币数量
				$return_info = $this->recharge($temp);
//				var_dump($temp);var_dump($return_info);exit;
				return $return_info;
				
			}else{
				return  array('flag'=>-1,'info'=>'购买会员服务失败，请稍后重试！');
			}
    	}
    }
    /**
     * 判断购买服务的用户是否是签约推广用户关联的，如果在有效期内，则给签约推广用户赠送工分
     * 参数说明 uid，vipid-购买服务类型
     */
    public function addUserPromotion($data){
    	extract($data);
    	$sql = "select promotion_flag,referrer,addtime from userlist where uid='$uid'";
    	$query = $this->db->query($sql);
    	$row = $query->row_array();
    	if($row['promotion_flag']==1){//有签约推广用户
    		if($row['addtime']>=strtotime("-3 year")){//注册时间距今3年内
    			if($vipid==1||$vipid==4){
    				$credits = '2';
    			}elseif($vipid==2||$vipid==5){
    				$credits = '5';
    			}else{
    				$credits = '10';
    			}
    			$time = time();
    			$userinfo = $this->getUserinfoByUsername($row['referrer']);
    			$sql = "insert into `user_credits_log` set uid='{$userinfo['uid']}',type='credit2',way_id='5',credits='$credits',addtime='$time'";
    			$query = $this->db->query($sql);
    			if($query1){
    				return true;
    			}else{
    				return false;
    			}
    		}
    	}
    }
    /**
     * 根据用户uid查询公司用户基本信
     * @param unknown_type $uid
     */
    public function getCoUserInfo($uid){
    	$sql = "select pro_t.name as province,city_t.name as city, user_co.coname, co_scale.name as scale,
				userlist.mobile,userlist.wechat,userlist.qq,user_co.info,userlist.is_real,user_co.idno,userlist.address
				from userlist inner join user_co on user_co.uid=userlist.uid
				LEFT JOIN co_scale on co_scale.code=user_co.scale_code
				inner join province_city as pro_t on userlist.province_id=pro_t.dist_id
				inner join province_city  as city_t on userlist.city_id=city_t.dist_id
				where userlist.uid='$uid'";
    	$query = $this->db->query($sql);
		$arr = $query->row_array();
		return $arr;
    }
    /**
     * 根据用户uid查询个人用户基本信息
     * @param unknown_type $uid
     */
    public function getPersonalInfo($uid){
    	$sql = "select pro_t.name as province,city_t.name as city,user_personal.realname,user_personal.sex,
				userlist.mobile,userlist.wechat,userlist.qq,user_personal.info,userlist.is_real,user_personal.idno,userlist.address
				from userlist inner join user_personal on user_personal.uid=userlist.uid
				inner join province_city as pro_t on userlist.province_id=pro_t.dist_id
				inner join province_city  as city_t on userlist.city_id=city_t.dist_id
				where userlist.uid='$uid'";
    	$query = $this->db->query($sql);
		$arr = $query->row_array();
		return $arr;
    }
    /**
     * 修改公司类型用户基本信息
     * @param unknown_type $data
     * 参数说明：uid-uid，scale-公司规模码，address-联系地址，wechat-微信，qq-qq，info-公司简介
     */
    public function updateMyCoInfo($data){
    	extract($data);
    	if(!$uid){
    		return array('flag'=>-1,'info'=>'未获取用户id，请稍后重试！');
    	}
    	if(!$scale){
    		return array('flag'=>-1,'info'=>'您需要选择公司规模！');
    	}
    	if(!trim($address)){
    		return array('flag'=>-1,'info'=>'您需要填写联系地址！');
    	}
    	if(!trim($info)){
    		return array('flag'=>-1,'info'=>'您需要填写公司简介！');
    	}
    	$address = $this->string_model->filter(trim($address));
    	$wechat = $this->string_model->filter($wechat);
    	$qq = $this->string_model->filter($qq);
    	$info = $this->string_model->filter(trim($info));
    	$sql = "update userlist set qq='$qq',wechat='$wechat',address='$address' where uid='$uid' ";
    	$query = $this->db->query($sql);
    	if($query){
    		$sql1 = "update user_co set info='$info', scale_code='$scale' ";
    		if($coname){
    			$sql1 .= ",coname='$coname' ";
    		}
    		$sql1 .= "where uid='$uid'";
    		$query1 = $this->db->query($sql1);
    		if($query1){
    			return array('flag'=>1,'info'=>'');
    		}else{
    			return array('flag'=>-1,'info'=>'更新信息失败，请稍后重试！');
    		}
    	}else{
    		return array('flag'=>-1,'info'=>'更新您的信息失败，请稍后重试！');
    	}
		
    }
    /**
     * 修改个人类型用户基本信息
     * @param unknown_type $data
     * * 参数说明：uid-uid，sex-性别，address-联系地址，wechat-微信，qq-qq，info-个人简介,realname-姓名
     */
    public function updateMyPersonalInfo($data){
    	extract($data);
    	if(!$uid){
    		return array('flag'=>-1,'info'=>'未获取用户id，请稍后重试！');
    	}
    	if(!$sex){
    		return array('flag'=>-1,'info'=>'您需要选择用户性别！');
    	}
    	if(!trim($address)){
    		return array('flag'=>-1,'info'=>'您需要填写联系地址！');
    	}
    	if(!trim($info)){
    		return array('flag'=>-1,'info'=>'您需要填写个人简介！');
    	}
    	$address = $this->string_model->filter(trim($address));
    	$wechat = $this->string_model->filter($wechat);
    	$qq = $this->string_model->filter($qq);
    	$info = $this->string_model->filter(trim($info));
    	$sql = "update userlist set qq='$qq',wechat='$wechat',address='$address' where uid='$uid' ";
    	$query = $this->db->query($sql);
    	if($query){
    		$sql1 = "update user_personal set info='$info', sex='$sex' ";
    		if($realname){
    			$sql1 .= ",realname='$realname' ";
    		}
    		$sql1 .= " where uid='$uid'";
    		$query1 = $this->db->query($sql1);
    		if($query1){
    			return array('flag'=>1,'info'=>'');
    		}else{
    			return array('flag'=>-1,'info'=>'更新信息失败，请稍后重试！');
    		}
    	}else{
    		return array('flag'=>-1,'info'=>'更新您的信息失败，请稍后重试！');
    	}
    }
    /**
     * 检查原始密码是否正确
     * 参数说明：old_pwd-加密后老密码，uid-uid
     */
    public function checkOldPwd($data){
    	extract($data);
    	$sql = "select password from userlist where uid='$uid' ";
    	$query = $this->db->query($sql);
    	$result = $query->row_array();
    	$db_pwd = $result['password'];
    	if ($db_pwd==$old_pwd) {
    		return array('flag'=>1,'info'=>'');
    	}else {
    		return array('flag'=>-1,'info'=>'原始密码填写错误，请重新检查后提交');
    	}
    }
    /**
     * 修改密码
     * 参数说明：pwd--加密后新密码,uid-uid
     */
    public function updatePwd($data){
    	extract($data);
    	if(!trim($pwd)||!trim($uid)){
    		return array('flag'=>-1,'info'=>'信息填写不全，请填写完整后提交！');
    	}
    	$sql = "update userlist set password='$pwd' where uid='$uid'";
    	$query = $this->db->query($sql);
    	if($query){
    		return array('flag'=>1,'info'=>'');
    	}else{
    		return array('flag'=>-1,'info'=>'密码修改失败，请稍后重试');
    	}
    }
    /**
     * 检查用户是否已实名认证
     * @param unknown_type $uid
     */
    public function checkIsReal($uid){
    	extract($data);
    	
    	$sql = "select is_real,is_co from userlist where uid='$uid' ";
    	$query = $this->db->query($sql);
    	$result = $query->row_array();
    	
    	if($result['is_real']==1){
    		return array('flag'=>1,'info'=>'已实名认证');
    	}else{
    		if($result['is_co']==1){
	    		$sql1 = "select idno from user_co where uid='$uid'";
	    		$query1 = $this->db->query($sql1);
    			$result1 = $query1->row_array();
	    	}else{
	    		$sql1 = "select idno from user_personal where uid='$uid'";
	    		$query1 = $this->db->query($sql1);
    			$result1 = $query1->row_array();
	    	}
//	    	echo $sql;
//	    	var_dump($result1);
	    	if($result1&&$result1['idno']){
	    		return array('flag'=>0,'info'=>'实名认证信息待审核');
	    	}else{
	    		return array('flag'=>-1,'info'=>'尚未实名认证');
	    	}
    		
    	}
    }
    /**
     * 更新公司实名认证资料
     * @param unknown_type $data
     * 参数说明 uid-uid,coname-公司名称 idno-公司执照号 idno_img-公司执照照片
     */
    public function updateCoRealInfo($data){
    	extract($data);
    	$result = $this->checkIsReal($uid);
    	if($result['flag']==1){
    		return array('flag'=>-1,'info'=>'您已实名认证请不要再次申请');
    	}
    	if(!trim($idno)){
    		return array('flag'=>-1,'info'=>'您需要填写公司营业执照号');
    	}
    	if(!trim($idno_img)){
    		return array('flag'=>-1,'info'=>'您上传的文件有问题，请稍后重试');
    	}
    	if(!trim($coname)){
    		return array('flag'=>-1,'info'=>'您需要填写公司名称');
    	}
    	$idno = $this->string_model->filter($idno);
  		$coname = $this->string_model->filter($coname);
    	$sql = "update user_co set coname='$coname',idno='$idno',idno_img='$idno_img' where uid='$uid'";
//    	echo $sql;exit;
    	$query = $this->db->query($sql);
    	if($query){
    		return array('flag'=>1,'info'=>'实名认证成功');
    	}else{
    		return array('flag'=>-1,'info'=>'信息提交失败，请稍后重试！');
    	}
    }
    /**
     * 更新个人实名认证资料
     * @param unknown_type $data
     * 参数说明 realname-真实姓名 idno-身份证号 idno_img-身份证照片
     */
    public function updatePersonalRealInfo($data){
    	extract($data);
    	$result = $this->checkIsReal($uid);
    	if($result['flag']==1){
    		return array('flag'=>-1,'info'=>'您已实名认证请不要再次申请');
    	}
    	if(!trim($realname)){
    		return array('flag'=>-1,'info'=>'您需要填写真实姓名');
    	}   	
    	if(!trim($idno)){
    		return array('flag'=>-1,'info'=>'您需要填写身份证号码');
    	}
    	if(!trim($idno_img)){
    		return array('flag'=>-1,'info'=>'您上传的文件有问题，请稍后重试');
    	}
    	
    	$idno = $this->string_model->filter($idno);
  		$coname = $this->string_model->filter($coname);
    	$sql = "update user_personal set realname='$realname',idno='$idno',idno_img='$idno_img' where uid='$uid'";
    	$query = $this->db->query($sql);
    	if($query){
    		return array('flag'=>1,'info'=>'实名认证成功');
    	}else{
    		return array('flag'=>-1,'info'=>'信息提交失败，请稍后重试！');
    	}
    }
    /**
     * 获取用户充值、消费、收益明细
     * @param unknown_type $data
     * 参数说明： uid-uid,type- 1:充值|2：消费|3：收益
     * 
     */
    public function getUserCreditsItems($data){
    	extract($data);
    	$type==1&&$sql = "select user_credits_log.id,user_credits_log.uid,user_credits_log.type,user_credits_log.way_id,
    					user_credits_log.credits,
    					user_credits_log.addtime,user_credits_log.costs ,credits_way_dic.`name`as way_name,
    					credits_type_dic.`name` as type_name 
						from user_credits_log 
						inner join credits_way_dic on user_credits_log.way_id=credits_way_dic.id
						inner join credits_type_dic on credits_type_dic.id=user_credits_log.type
						where user_credits_log.uid='$uid' and user_credits_log.type='credit1' and (way_id='1' or way_id='2')";//注册赠送和充值获得零工币明细
    	$type==2&&$sql = "select user_credits_log.id,user_credits_log.uid,user_credits_log.type,user_credits_log.way_id,
    					user_credits_log.credits,
    					user_credits_log.addtime,user_credits_log.costs ,credits_way_dic.`name`as way_name,
    					credits_type_dic.`name` as type_name 
						from user_credits_log 
						inner join credits_way_dic on user_credits_log.way_id=credits_way_dic.id
						inner join credits_type_dic on credits_type_dic.id=user_credits_log.type
						where user_credits_log.uid='$uid' and user_credits_log.type='credit1' and (way_id='3' or way_id='4' or way_id='8')";//零工币发布、刷新、购买服务明细
    	$type==3&&$sql = "select user_credits_log.id,user_credits_log.uid,user_credits_log.type,user_credits_log.way_id,user_credits_log.credits,
    					user_credits_log.addtime,user_credits_log.costs ,credits_way_dic.`name`as way_name,
    					credits_type_dic.`name` as type_name
						from user_credits_log 
						inner join credits_way_dic on user_credits_log.way_id=credits_way_dic.id
						inner join credits_type_dic on credits_type_dic.id=user_credits_log.type
						where user_credits_log.uid='$uid' and user_credits_log.type='credit2' and (way_id='5' or way_id='6')";//工分签约推广和提现明细
    	$query = $this->db->query($sql);
    	while($row = $query->unbuffered_row('array')){
    		if($row['way_id']==1){//注册免费赠送
    			$row['info'] = "注册免费赠送您".$row['credits'].$row['type_name'];
    		}elseif($row['way_id']==2){//充值得零工币
    			$row['info'] = "您通过充值获得".$row['credits'].$row['type_name'];
    		}elseif($row['way_id']==3){//充值得零工币
    			$row['info'] = "本次发布工种消费您".$row['credits'].$row['type_name'];
    		}elseif($row['way_id']==4){//充值得零工币
    			$row['info'] = "本次刷新工种消费您".$row['credits'].$row['type_name'];	
    		}elseif($row['way_id']==5){//充值得零工币
    			$row['info'] = "您通过签约推广获得".$row['credits'].$row['type_name'];	
    		}elseif($row['way_id']==6){//充值得零工币
    			$row['info'] = "您本次提现".$row['credits'].$row['type_name'];	
    		}elseif($row['way_id']==8){//充值得零工币
    			$row['info'] = "本次购买vip服务消费您".$row['credits'].$row['type_name'];	
    		}
    		$arr[]=$row;
    	}
    	return $arr;
    }
//获取用户ip
    public function getIP() {
			if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
			}
			elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
			}
			elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
			}
			elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');

			}
			elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
			}
			else {
			$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}
//获取用户浏览器
		public function getBrowser ($Agent) {
			   $Browser = $_SERVER['HTTP_USER_AGENT'];
	        if (preg_match('/MSIE/i',$Browser)) {
	            $Browser = 'MSIE';
	        }
	        elseif (preg_match('/Firefox/i',$Browser)) {
	            $Browser = 'Firefox';
	        }
	        elseif (preg_match('/Chrome/i',$Browser)) {
	            $Browser = 'Chrome';
	        }
	        elseif (preg_match('/Safari/i',$Browser)) {
	            $Browser = 'Safari';
	        }
	        elseif (preg_match('/Opera/i',$Browser)) {
	            $Browser = 'Opera';
	        }
	        else {
	            $Browser = 'Other';
	        }
	        return $Browser;
		} 
		/**
		 * 根据用户名获取个人用户的信息
		 *
		 * @param unknown_type $uid
		 */
		public function getPersonalBaseInfo($uid){
			$sql = "select userlist.mobile,userlist.address,userlist.qq,userlist.wechat, user_personal.realname,user_personal.idno 
					from userlist
					inner join user_personal on userlist.uid=user_personal.uid  
					where userlist.uid='$uid'";
			$query = $this->db->query($sql);
			return $query->row_array();
		}
		/**
		 * 获取公司规模字典
		 *
		 * @return unknown
		 */
		public function getCoScale(){
			$sql = "select code,name from co_scale";
			$query = $this->db->query($sql);
			return $query->result_array();
		}


    /**
     * 根据用户uid查询个人用户个人昵称
     * @param unknown_type $uid
     */
    public function getNickname($uid){
        $sql = "select nickname from user_personal where uid=$uid";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
        return $arr;
    }

    /**
     * 更新个人信息资料
     * @param unknown_type $data
     * 参数说明 nickname-昵称 img-头像
     */
    public function updatePersonalInfor($data){
        extract($data);
        if(!trim($nickname)){
            return array('flag'=>-1,'info'=>'您需要填写昵称');
        }
        $nickname = $this->string_model->filter($nickname);
        if($img==''){
            $sql = "update user_personal set nickname='$nickname'where uid='$uid'";
        }else{
            $sql = "update user_personal set nickname='$nickname',img='$img' where uid='$uid'";
        }
        $query = $this->db->query($sql);
        if($query){
            return array('flag'=>1,'info'=>'修改成功');
        }else{
            return array('flag'=>-1,'info'=>'信息提交失败，请稍后重试！');
        }
    }


    /**
     * 工分提现
     * @param unknown_type $data
     * 参数说明：uid-uid
     */
    public function updateCash($data){
        extract($data);
        if(!$uid){
            return array('flag'=>-1,'info'=>'未获取用户id，请稍后重试！');
        }
        $name = $this->string_model->filter(trim($name));
        $account = $this->string_model->filter($account);
        $idno = $this->string_model->filter($idno);
        $bank = $this->string_model->filter(trim($bank));
        $sql = "insert into credits_cash(uid,name,idno,mode,bank,account,money) values({$uid},{$name},{$idno},{$mode},'{$bank}','{$account}',{$money})";
        $query = $this->db->query($sql);
        if($query){
            $sql1 = "update userlist set credit2='0' WHERE uid={$uid}";
            $query1 = $this->db->query($sql1);
            if($query1){
                return array('flag'=>1,'info'=>'');
            }else{
                return array('flag'=>-1,'info'=>'提现失败，请稍后重试！');
            }
        }else{
            return array('flag'=>-1,'info'=>'提现失败，请稍后重试！');
        }

    }


    /**
    *   根据城市id获取城市简码
    **/
    public function getCityCode($city_id){
        $sql = "select pinyin from province_city where dist_id='{$city_id}'";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
        return $arr;
    }


    /**
     *   获取所有行业职业
     **/
    public function getJobType($data){
        extract($data);
        $sql = "select id,name,pre_id,pre_pre_id,level from job_type where level='$level' and pre_id='$pre_id' and pre_pre_id='$pre_pre_id'";
        $query = $this->db->query($sql);
        $list = array();
        while ($row = $query->unbuffered_row('array')) {
            $list[$row['id']] = $row['name'];
        }
        return $list;
    }


    /**
     * 判断用户是否已经登录
     *
     */
    public function hasLogin()
    {
        /** 检查session，并与数据库里的数据相匹配 */
        if (!empty($_SESSION) and NULL !== $_SESSION['uid']) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    /**
     * 根据参数 更新工种信息表publish_list 字段img 和 删除图片
     */
    public function updatePublishImg($id,$img){
        $sql = "select img from publish_list where id='{$id}'";
        $query = $this->db->query($sql);
        $arr = $query->row_array();

        if($img_arr=explode(',',$arr['img'])){
            array_splice($img_arr,substr($img, -1), 1);
            foreach ($img_arr as $v){
                if($v){
                    $text.=$v.',';
                }
            }
            $text=substr($text,0,-1);
            $sql1 = "update publish_list set img='$text' WHERE id={$id}";
            $query1 = $this->db->query($sql1);
        }else{
            $sql1 = "update publish_list set img='' WHERE id={$id}";
            $query1 = $this->db->query($sql1);
        }

        if($query1){
            return array('flag'=>1,'info'=>'删除成功!');
        }else{
            return array('flag'=>-1,'info'=>'提现失败，请稍后重试！');
        }
    }



}