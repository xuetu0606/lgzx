<?php
class Sign_model extends CI_Model{
	public function __construct()
    {
        //继承父类的构造方法
        parent::__construct();
        $this->load->database();
    }
	
	/**
	* 用户签到
	*参数：uid-用户id   citycode-城市简码
	* 返回值：成功返回签到次数，失败返回失败原因
	*
	*/
	public function sign_add($uid,$citycode){
		$time = time();
		$time_y = strtotime('-1 day');
//		print_r()
		$sql = "select id from user_sign_log where uid='$uid' and signtime>'$time_y' order by signtime desc limit 1 ";
//		echo $sql;exit;
		$query = $this->db->query($sql);
		$arr = $query->row_array();
		// var_dump($arr);die();
		if($arr['id']){//时间间隔不够24小时，不能再次签到
			$this_month = strtotime(date("Y-m-01"));//获取每月一号
			$sql2 = "select count({$uid}) from user_sign_log where uid={$uid} and signtime>='$this_month'";
			$query2 = $this->db->query($sql2);
			$arr = $query2->row_array();
			$info = $arr["count({$uid})"];
			return $sign_num = array('flag'=>-2,'info'=>"{$info}");
		}else{
			$sql = "insert into user_sign_log(uid,sign_citycode,signtime) values({$uid},'{$citycode}',{$time})";
			$query = $this->db->query($sql);
			if($query){
				$this_month = strtotime(date("Y-m-01"));//获取每月一号
				$sql2 = "select count({$uid}) from user_sign_log where uid={$uid} and signtime>='$this_month'";
				$query2 = $this->db->query($sql2);
				$arr = $query2->row_array();
				$info = $arr["count({$uid})"];
				return $sign_num = array('flag'=>1,'info'=>"{$info}");
			}else{
				return $sign_num = array('flag'=>-1,'info'=>'签到失败'); 
			}
		}
			

	}
}
