<?php
class Admin_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model('string_model');
        $this->load->helper('string');
        $this->load->helper('text');
    }



    /**
     * 根据代理商userid获取 代理区域id
     * 参数：userid
     * 返回值数组：城市编码=>城市名称
     */
    public function getCityid($userid){
        $sql = "select city_id from daili_userlist where uid='{$userid}'";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
        if($arr){
            return $arr['city_id'];
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
     * 登陆验证
     * 参数：$data数组-登录数据项，包含 username-用户名或手机号；passwd-加密后密码
     * 返回值：有该用户则返回uid，否则返回false
     */
    public function getuserlist($data){
//    	$data = array('username'=>'shane','passwd'=>'123123');
        extract($data);
        $sql = "select uid,username,quanxian,zhiwu from admin_userlist where (username = '$username') and password = '$passwd'";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
        if($arr){
            return $arr;
        }else{
            return false;
        }
    }

    /**
     * 获取用户信息
     */
    public function getuserinfo($uid){
        $sql = "select uid,username,quanxian,zhiwu from admin_userlist where uid = '$uid'";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
        if($arr){
            return $arr;
        }else{
            return false;
        }
    }


    /**
     * 获取当前代理商 注册会员信息列表
     * 参数：$data array(userid=>用户id,time=>查询vip截止,gong=>公司类型0不限 1个人 2公司,reg=>注册类型0不限 1推广注册 2站内注册,addsql=>增加分页sql语句)
     * 返回值数组：no=>工号,name=>昵称/公司名,gong=>工种,is_vip=>零工状态/套餐期限,referrer=>注册类型(推介人id),vip_starttime=>充值时间,
     */
    public function getMemberInfo1($data){
        extract($data);
        if($city_id){
            $city_sql="and userlist.city_id='{$city_id}'";
        }else{
            $city_sql='';
        }
        if($gong==1){
            $gong_sql="and userlist.is_co!='1'";
        }elseif($gong==2){
            $gong_sql="and userlist.is_co='1'";
        }else{
            $gong_sql='';
        }
        if($reg==2){
            $reg_sql="and userlist.promotion_flag='0'";
        }elseif($reg==1){
            $reg_sql="and userlist.promotion_flag='1'";
        }else{
            $reg_sql='';
        }
        if($vip==1){
            $time=time()+2592000;
            $time="and user_service_log.endtime>{$time}";
        }else{
            $time='';
        }
        if($starttime and $endtime){
            $riqi="and {$starttime} < userlist.addtime and userlist.addtime < {$endtime} ";
        }else{
            $riqi='';
        }

        $sql = "select userlist.no,userlist.username,userlist.is_co,(select coname from user_co where uid=userlist.uid limit 1) as coname,
(select nickname from user_personal where uid=userlist.uid limit 1) as nickname,
GROUP_CONCAT( distinct job_type.name ) as gong,

userlist.addtime,userlist.referrer,userlist.promotion_flag,userlist.mobile,
user_service_log.vip_id,user_service_log.starttime as vip_starttime,user_service_log.endtime as is_vip,vip_service_dic.name
 from userlist 
left join publish_list on publish_list.uid=userlist.uid
left join job_type on job_type.id=publish_list.job_code
left join user_service_log on userlist.uid=user_service_log.uid 
left join vip_service_dic on user_service_log.vip_id=vip_service_dic.id
where 1=1 {$city_sql} {$reg_sql} {$gong_sql} {$time} {$riqi}
group by userlist.uid {$addsql}";
        $query = $this->db->query($sql);
        $arr = $query->result_array();
        return $arr;
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
     * 根据省分获取城市
     * 返回值数组：城市编码=>城市名称
     */
    public  function getAllCityByProvinceId($Province_id){
        $sql = "select pre_dist_id,dist_id,name from province_city where level=2 and pre_dist_id=".$Province_id;
        $query = $this->db->query($sql);
        $list = array();
        while ($row = $query->unbuffered_row('array')) {
            $list[$row['pre_dist_id']][$row['dist_id']] = $row['name'];
        }
        return $list;
    }

    /**
     * 获取会员信息
     */
    public function getMemberInfo($no){
        $sql = "select *
                from userlist 
                left join user_personal on user_personal.uid=userlist.uid 
                left join user_co on user_co.uid=userlist.uid 
                where no = '$no'";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
        if($arr){
            return $arr;
        }else{
            return false;
        }
    }


    /**
     * 根据城市id获取省市名
     *
     * 返回值数组：province=>省,city=>市
     */
    public  function getProvinceCity($city_id){
        if(empty($city_id)){
            return false;
        }
        $sql = "select name AS city,pre_dist_id,pinyin from province_city where level=2 and dist_id={$city_id}";
        $query = $this->db->query($sql);
        $row = $query->unbuffered_row('array');

        $sql2 = "select name AS province from province_city where level=1 and dist_id={$row['pre_dist_id']}";
        $query2 = $this->db->query($sql2);
        $row2 = $query2->unbuffered_row('array');

        return array_merge($row,$row2);
    }

    /**
     * 获取所有公司规模
     *
     * 返回值数组
     */
    public  function getScale(){
        $sql = "select * from co_scale";
        $query = $this->db->query($sql);
        $list = array();
        while ($row = $query->unbuffered_row('array')) {
            $list[$row['code']] = $row['name'];
        }

        return $list;
    }

    /**
     * 获取所有公司规模
     *
     * 返回值数组
     */
    public  function seveMemberInfo(){
        $sql = "select * from co_scale";
        $query = $this->db->query($sql);
        $list = array();
        while ($row = $query->unbuffered_row('array')) {
            $list[$row['code']] = $row['name'];
        }

        return $list;
    }

	//获取所有招聘信息
    public function getReveal(){
        //查询所有招聘信息
        $sql = "select id,uid,job_code,city_id,district_id,title,pay,pay_unit,pay_circle,sum,worktime,contacts,mobile,address,info,flag,pv,addtime,updatetime,flushtime from invite_list";
        $result = $this->db->query($sql);
        $users = $result->result_array();
        //循环查询所有的工种名称
        for($i = 0 ; $i < count($users) ; $i++){
            $sql = "select name from job_type where id=".$users[$i]['job_code'];
            $result = $this->db->query($sql);
            $name = $result->result_array();
            $users[$i]['job_name'] = $name[0]['name'];
        }
        //循环查询所有的区县名称
        for($i = 0 ; $i < count($users) ; $i++){
            $sql = "select name from district_dic where id=".$users[$i]['district_id'];
            $result = $this->db->query($sql);
            $name = $result->result_array();
            $users[$i]['district_name'] = $name[0]['name'];
        }
		//查询薪资单位
		for($i = 0 ; $i < count($users) ; $i++){
            $sql = "select name from pay_unit_dic where id=".$users[$i]['pay_unit'];
            $result = $this->db->query($sql);
            $name = $result->result_array();
            $users[$i]['pay_unit_name'] = $name[0]['name'];
        }
		//查询结算周期
		for($i = 0 ; $i < count($users) ; $i++){
            $sql = "select name from pay_circle_dic where id=".$users[$i]['pay_circle'];
            $result = $this->db->query($sql);
            $name = $result->result_array();
            $users[$i]['pay_circle_name'] = $name[0]['name'];
        }
        return $users;
    }
    //删除一条招聘信息
    public function deleteReveal($id){
        $sql = "delete from invite_list where id=".$id;
        $this->db->query($sql);
    }
    //查询一条信息
    public function findReveal($id){
        
		$sql = "select id,uid,job_code,city_id,district_id,title,pay,pay_unit,pay_circle,sum,worktime,contacts,mobile,address,info,flag,pv,addtime,updatetime,flushtime from invite_list where id=".$id;
        $result = $this->db->query($sql);
        $user = $result->result_array();
		
		$sql = "select name from district_dic where id=".$user[0]['district_id'];
		$result = $this->db->query($sql);
		$name = $result->result_array();
		$user[0]['district_name'] = $name[0]['name'];
		
		$sql = "select name from pay_unit_dic where id=".$user[0]['pay_unit'];
		$result = $this->db->query($sql);
		$name = $result->result_array();
		$user[0]['pay_unit_name'] = $name[0]['name'];
		
		$sql = "select name from pay_circle_dic where id=".$user[0]['pay_circle'];
		$result = $this->db->query($sql);
		$name = $result->result_array();
		$user[0]['pay_circle_name'] = $name[0]['name'];
		
		$sql = "select name from job_type where id=".$user[0]['job_code'];
		$result = $this->db->query($sql);
		$name = $result->result_array();
		$user[0]['job_name'] = $name[0]['name'];
        
		return $user[0];
    }
    //修改一条信息
    public function updateReveal($id,$job_code,$district_id,$title,$pay,$pay_unit,$pay_circle,$sum,$worktime,$contacts,$mobile,$address,$info,$flag){
        $sql = "update invite_list set 
            job_code=".$job_code.",
            district_id=".$district_id.",
            title='".$title."',
            pay=".$pay.",
            pay_unit=".$pay_unit.",
            pay_circle=".$pay_circle.",
            sum=".$sum.",
            worktime='".$worktime."',
            contacts='".$contacts."',
            mobile='".$mobile."',
            address='".$address."',
            info='".$info."'
            where id=".$id."
            ";
        $this->db->query($sql);
    }
    /**
     * 查询所有工种
     */
    public function getJob(){
        $sql = "select id,name from job_type where level=3";
        $result = $this->db->query($sql);
        $list = $result->result_array();
        return $list;
    }
    /**
     * 根据城市查询区县
     */
    public function getJoin($upid){
        $sql = "select id,name from district_dic where upid=".$upid;
        $result = $this->db->query($sql);
        $list = $result->result_array();
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
        $is_co = trim($is_co);
        //生成工号uid
        $new_uid = $this->addUid();
        //公司
        if($is_co == 'gongsi'){
            $is_co = 1;
            $sql = "insert into user_co (uid,coname,scale_code,weburl,idno,info,updatetime)
            values
            ('$new_uid','$coname','$scale_code','$weburl','$idno','$info','$time_now')";
            $this->db->query($sql);

            $sql = " insert into publish_list (uid,job_code,info1,info3,addtime,city_id,mobile,address,flag)
            values
            ('$new_uid','$job_type','$info1','$info3','$time_now','$c_id','$mobile','$address',1)";
            $this->db->query($sql);
            $publish_id = $this->getPublish_list_id();
            $sql = " insert into publish_list_service_district (publish_id,district_id,area_id)
            values
            ('$publish_id','$arae','$street')";
            $this->db->query($sql);
            //个人
        }else if($is_co == 'geren'){
            $is_co = 0;
             $sql = "insert into user_personal (uid,realname,nickname,sex,idno,info)
            values
            ('$new_uid','$realname','$nickname','$sex','$idno','$info')";
            $this->db->query($sql);
            
            $sql = " insert into publish_list (uid,job_code,info1,info3,addtime,city_id,mobile,address,flag)
            values
            ('$new_uid','$job_type','$info1','$info3','$time_now','$c_id','$mobile','$address',1)";
            $this->db->query($sql);
            $publish_id = $this->getPublish_list_id();
            $sql = " insert into publish_list_service_district (publish_id,district_id,area_id)
            values
            ('$publish_id','$arae','$street')";
            $this->db->query($sql);
        }
        if(strlen($new_uid) < 3){
            $new_uid = "0".$new_uid;
        }
        $password = $this->encryptPwd($password);
        $sql = "insert into userlist 
            (no ,
            username ,
            password ,
            province_id ,
            city_id ,
            address ,
            mobile  ,
            tel  ,
            email ,
            qq  ,
            wechat ,
            is_co  ,
            addtime)
            values
            (
            '".$new_uid."',
            '".$username."',
            '".$password."',
            ".$p_id.",
            ".$c_id.",
            '".$address."',
            '".$mobile."',
            '".$tel."',
            '".$email."',
            '".$qq."',
            '".$wechat."',
            ".$is_co.",
            ".$time_now."
            )
        ";
        $this->db->query($sql);
    }

    /**
     * 生成新的工号uid
     * 规则：最新自增id+1
     *格式为：lg+数字编号，若最新id小于4位则前面加0补齐
     */
    public function addUid(){
        $min_len = 3;//小于最小位数则前面加0补齐
        $pr = "";//工号前缀
//      $pr = "lg";//工号前缀
        $query = $this->db->query("select max(uid) as uid from userlist ");
        $id_arr = $query->row_array();
        $max_id = $id_arr['uid']?($id_arr['uid']+1):1;
        return $max_id;
    }
    //获取publish_list当前id
    public function getPublish_list_id(){
        $min_len = 3;//小于最小位数则前面加0补齐
        $pr = "";//工号前缀
//      $pr = "lg";//工号前缀
        $query = $this->db->query("select max(id) as id from publish_list ");
        $id_arr = $query->row_array();
        return $id_arr['id'];
    }
}