<?php
class Daili_model extends CI_Model {

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
     * 获取当前代理商 注册会员信息列表
     * 参数：userid
     * 返回值数组：no=>工号,name=>昵称/公司名,gong=>工种,is_vip=>零工状态/套餐期限,promotion_flag=>是否签约推广来的用户,referrer=>推介人username,vip_starttime=>充值时间,
     */
    public function getMemberInfo($userid,$sql){
        $city_id=$this->getCityid($userid);
        $sql = "select uid,userlist.no,is_co,referrer,addtime,mobile,address,promotion_flag 
                from userlist 
                where city_id='$city_id' {$sql}";
        $query = $this->db->query($sql);
        $arr = $query->result_array();
        foreach ($arr as $k => $v){

            if($arr[$k]['is_co']==1){
                $sql1 = "select coname from user_co where uid='{$arr[$k]['uid']}'";
                $query1 = $this->db->query($sql1);
                $arr1 = $query1->row_array();
                $arr[$k]['coname']=$arr1['coname'];
            }else{
                $sql1 = "select nickname from user_personal where uid='{$arr[$k]['uid']}'";
                $query1 = $this->db->query($sql1);
                $arr1 = $query1->row_array();
                $arr[$k]['nickname']=$arr1['nickname'];
            }
            $sql2 = "select job_type.name 
                     from job_type 
                     inner join publish_list on job_type.id=publish_list.job_code
                     where publish_list.uid='{$arr[$k]['uid']}'";
            $query2 = $this->db->query($sql2);
            $gong='';
            $g='';
            foreach ($query2->result_array() as $key=>$row)
            {
                $gong.=$row['name'].',';
            }
            $arr[$k]['gong']=reduce_multiples($gong, ",", TRUE);

            $time = time();
            //查看vip是否过期 有值则为vip
            $sql3 = "select starttime as vip_starttime,endtime as vip_endtime from user_service_log where uid='{$arr[$k]['uid']}' and endtime < {$time} ";
            $query3 = $this->db->query($sql3);
            $arr3 = $query3->row_array();
            $arr[$k]['is_vip']= $arr3['vip_endtime'];
            $arr[$k]['vip_starttime']= $arr3['vip_starttime'];

        }
        return $arr;
    }

    /**
     * 获取当前代理商 注册会员信息列表
     * 参数：$data array(userid=>用户id,time=>查询vip截止,gong=>公司类型0不限 1个人 2公司,reg=>注册类型0不限 1推广注册 2站内注册,addsql=>增加分页sql语句)
     * 返回值数组：no=>工号,name=>昵称/公司名,gong=>工种,is_vip=>零工状态/套餐期限,referrer=>注册类型(推介人id),vip_starttime=>充值时间,
     */
    public function getMemberInfo1($data){
        extract($data);
        $city_id=$this->getCityid($userid);//查询代理商城市id
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
where userlist.city_id='{$city_id}' {$reg_sql} {$gong_sql} {$time} {$riqi}
group by userlist.uid {$addsql}";
        $query = $this->db->query($sql);
        $arr = $query->result_array();
        return $arr;
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
     * 登陆验证并填写登录日志,半小时内同一个用户在同浏览器下日志不重复写入
     * 参数：$data数组-登录数据项，包含 username-用户名或手机号；passwd-加密后密码
     * 返回值：有该用户则返回uid，否则返回false
     */
    public function getuserlist($data){
//    	$data = array('username'=>'shane','passwd'=>'123123');
        extract($data);
        $sql = "select uid,username,coname,city_id from daili_userlist where (username = '$username' or mobile='$username') and password = '$passwd'";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
        if($arr){
            return $arr;
        }else{
            return false;
        }
    }
    
	
}