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
			$arr
			if($job_code){
				$job_code_sql = "select level from job_type where id=".$job_code;
				$result = $this->db->query($job_code_sql);
				$list = $result->result_array();
				switch($list[0]['level']){
					case 1 :
						$job_code_sql = "select id from job_type pre_pre_id=".$job_code;
						$result = $this->db->query($job_code_sql);
						$list = $result->result_array();
						foreach($list as $item){
							$sql.=" or job_code=".$item['uid'];
						}
						breack;
					case 2 :
						$job_code_sql = "select id from job_type pre_id=".$job_code;
						$result = $this->db->query($job_code_sql);
						$list = $result->result_array();
						foreach($list as $item){
							$sql.=" or job_code=".$item['uid'];
						}
						breack;
					case 3 :
						$sql.=" and job_code=".$job_code;
						breack;
				}
			}
			if($quyu){
				$sql.=" and district_id=".$quyu;
			}
			if($gongzi){
				if($gongzi == 50){
					$sql.=" and pay<50";
				}else if($gongzi == 100){
					$sql.=" and pay>50 and pay<100";
				}else if($gongzi == 'num'){
					$sql.=" and pay>100";
				}
			}
			if($jiesuan){
				$sql.=" and pay_circle=".$jiesuan;
			}
			if($fbsj){
				$sql.=" and current_time-addtime > 1*24*60*60*1000*7*".$fbsj;
			}
			if($renzheng){
				$renzheng_sql = "select uid from userlist where is_real=1";
				$result = $this->db->query($job_code_sql);
				$list = $result->result_array();
				foreach($list as $item){
					$sql.=" or uid=".$item['uid'];
				}
			}
			if($xinyong){

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
				//查询是否实名认证
				$sql = "select is_real from userlist where uid=".$list[$i]['uid'];
				$result = $this->db->query($sql);
				$name = $result->result_array();
				$list[$i]['is_real'] = $name[0]['is_real'];
			}
			return $list;
	    }
		//查询一条数据
		public function find($uid){
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
						uid=".$uid;
			$result = $this->db->query($sql);
	        $news = $result->result_array();
			$time = time();
			for($i = 0 ; $i < count($news) ; $i++){
				//一条数据
				$sql = "select coname,img,info from user_co where uid=".$news[$i]['uid'];
				$query = $this->db->query($sql);
		        $arr = $query->result_array();
				$news[$i]['coname'] = $arr[0]['coname'];
				$news[$i]['img'] = $arr[0]['img'];
				$news[$i]['co_info'] = $arr[0]['info'];
				//是否会员
				$sql = "select endtime from user_service_log where uid=".$news[$i]['uid'];
				$query = $this->db->query($sql);
		        $arr = $query->result_array();
				$news[$i]['vip'] = $arr[0]['endtime'] > $time ? 1 : 2;
				//
				$sql = "select name from pay_circle_dic where id=".$news[$i]['pay_circle'];
				$query = $this->db->query($sql);
		        $arr = $query->result_array();
				$news[$i]['pay_circle'] = $arr[0]['name'];
				
				$sql = "select name from pay_unit_dic where id=".$news[$i]['pay_unit'];
				$query = $this->db->query($sql);
		        $arr = $query->result_array();
				$news[$i]['pay_unit'] = $arr[0]['name'];
				
				$sql = "select name from district_dic where id=".$news[$i]['district_id'];
				$query = $this->db->query($sql);
		        $arr = $query->result_array();
				$news[$i]['district_dic'] = $arr[0]['name'];
				
				$sql = "select is_real from userlist where uid=".$news[$i]['uid'];
				$query = $this->db->query($sql);
		        $arr = $query->result_array();
				$news[$i]['yingyezhiz'] = $arr[0]['is_real'];
				
				$sql = "select name from job_type where id=".$news[$i]['job_code'];
				$query = $this->db->query($sql);
		        $arr = $query->result_array();
				$news[$i]['job_name'] = $arr[0]['name'];
			}
			return $news;
		}

	}
?>