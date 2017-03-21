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
						i.id as id,
						i.uid as uid,
						i.job_code as job_code,
						i.city_id as city_id,
						i.district_id as district_id,
						i.title as title,
						i.pay as pay,
						i.pay_unit as pay_unit,
						i.pay_circle as pay_circle,
						i.sum as sum,
						i.worktime as worktime,
						i.contacts as contacts,
						i.mobile as mobile,
						i.address as address,
						i.info as info,
						i.flag as flag,
						i.pv as pv,
						i.addtime as addtime,
						i.updatetime as updatetime,
						i.flushtime as flushtime,
						u.credit3 as credit3
					from
						invite_list i
						LEFT OUTER JOIN
						userlist u
						ON i.uid = u.uid
					where 
						1=1";
			// $array_job_code = array();
			// $array_renzheng = array();
			if($job_code){
				$job_code_sql = "select level from job_type where id=".$job_code;
				$result = $this->db->query($job_code_sql);
				$list = $result->result_array();
				switch($list[0]['level']){
					case 1 :
						$job_code_sql = "select id from job_type where pre_pre_id=".$job_code;
						$result = $this->db->query($job_code_sql);
						$list = $result->result_array();
						foreach($list as $item){
							$sql.=" or i.job_code=".$item['id'];
							// $array_job_code[] = $item['uid'];
							// var_dump($item);
						}
						break ;
					case 2 :
						$job_code_sql = "select id from job_type where pre_id=".$job_code;
						$result = $this->db->query($job_code_sql);
						$list = $result->result_array();
						foreach($list as $item){
							$sql.=" or i.job_code=".$item['id'];
							// $array_job_code[] = $item['uid'];
						}
						break ;
					case 3 :
						$sql.=" and i.job_code=".$job_code;
						// $array_job_code[] = $job_code;
						break ;
				}
			}
			if($quyu){
				$sql.=" and i.district_id=".$quyu;
			}
			if($gongzi){
				if($gongzi == 50){
					$sql.=" and i.pay<50";
				}else if($gongzi == 100){
					$sql.=" and i.pay>50 and pay<100";
				}else if($gongzi == 'num'){
					$sql.=" and i.pay>100";
				}
			}
			if($jiesuan){
				$sql.=" and i.pay_circle=".$jiesuan;
			}
			if($fbsj){
				$sql.=" and i.current_time-addtime > 1*24*60*60*1000*7*".$fbsj;
			}
			if($renzheng){
				$renzheng_sql = "select uid from userlist where is_real=1";
				$result = $this->db->query($renzheng_sql);
				$query = $result->result_array();
				echo '<pre>';
				var_dump($query);
				echo '</pre>';
				foreach($query as $item){
					$sql.=" or u.uid=".$item['uid'];
					// $array_renzheng[] = $item['uid'];
				}
			}
			if($xinyong){
				$sql.=" ORDER BY credit3 ";
			}
			return $sql;
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
			//return $list;
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