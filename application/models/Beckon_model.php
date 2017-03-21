<?php
	class Beckon_model extends CI_Model {
	    public function __construct(){
	        parent::__construct();
	        $this->load->database();
	    }
	    //获取所有工种
	    public function getJob_type(){
	    	$sql = "select 
				    	id,
						name,
						pre_id,
						pre_pre_id,
						level
					from
						job_type";
			$result = $this->db->query($sql);
			$list = $result->result_array();
			return $list;
	    }
	    //获取所有地域
	    public function getArea($city_id){
	    	$sql = "select 
						id,
						name,
						level,
						upid,
						displayorder,
						hot
					from
						district_dic
					where
						1=1";
			if($city_id){
				$sql.=" and upid=".$city_id;
			}
			$result = $this->db->query($sql);
			$list = $result->result_array();
			return $list;
	    }
	    //获取结算周期
	    public function getPay_circle(){
	    	$sql = "select 
		    			id,
		    			name
		   			from 
		   				pay_circle_dic";
		   	$result = $this->db->query($sql);
			$list = $result->result_array();
			return $list;
	    }
	    //获取招零工信息
	    public function getBeckons($job_code = false ,$quyu = false ,$gongzi = false ,$jiesuan = false ,$fbsj = false ,$renzheng = false ,$xinyong = false){
	    	$sql = "select 
						id,
						uid,
						job_code,
						city_id,
						district_id,
						title,
						pay,
						pay_unit,
						pay_circle,
						sum,
						worktime,
						contacts,
						mobile,
						address,
						info,
						flag,
						pv,
						addtime,
						updatetime,
						flushtime
					from
						invite_list
					where 
						1=1";
			if($job_code){
				$job_code_sql = "select level job_type where id=".$job_code;
				$result = $this->db->query($job_code_sql);
				$list = $result->result_array();
				if(false){
					$sql.=" and job_code=".$job_code;
				}
			}else if($quyu){

			}else if($gongzi){

			}else if($jiesuan){

			}else if($fbsj){

			}else if($renzheng){

			}else if($xinyong){

			}
	    	$result = $this->db->query($sql);
			$list = $result->result_array();
			for($i = 0 ; $i < count($list) ; $i++){
				//查询区县
				$sql = "select name from district_dic where id=".$list[$i]['district_id'];
				$result = $this->db->query($sql);
				$name = $result->result_array();
				$list[$i]['aera'] = $name[0]['name'];
				//查询公司名称,公司形象
				$sql = "select coname,img from user_co where uid=".$list[$i]['uid'];
				$result = $this->db->query($sql);
				$name = $result->result_array();
				$list[$i]['coname'] = $name[0]['coname'];
				$list[$i]['coimg'] = $name[0]['img'];
				//查询是否是会员
				$sql = "select endtime from user_service_log where uid=".$list[$i]['uid'];
				$result = $this->db->query($sql);
				$endtime = $result->result_array();
				$now_time = time();
				$list[$i]['vip'] = $endtime[0]['endtime'] > $now_time ? 1 : 2;
			}
			return $list;
	    }

	}
?>