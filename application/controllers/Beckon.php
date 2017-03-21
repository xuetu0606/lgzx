<?php
	class Beckon extends CI_Controller {
		public function __construct(){
			parent::__construct();
			$this->load->model('beckon_model');
			$this->load->helpers('url');
			$this->load->library('session');
		}
		//打开招零工列表页
		public function index(){
			$data['job_type']  = $this->beckon_model->getJob_type();
			$data['area'] = $this->beckon_model->getArea(/*$city_id']*/224);
			$data['pay_circle'] = $this->beckon_model->getPay_circle();
			$data['beckons'] = $this->beckon_model->getBeckons();
			$this->load->view('beckon/beckons',$data);
		}
		//根据条件查询招聘信息
		public function getBeckonsByParam(){
			//将一个数组遍历成一个个以key命名的值
			extract($_REQUEST);
			$list = $this->beckon_model->getBeckons($job_code,$quyu,$gongzi,$jiesuan,$fbsj,$renzheng,$xinyong);
			// $str = json_encode($list);
			// echo $str;
			echo $list;
		}
		//打开招零工详情页
		public function toBeckon(){

		}
	}
?>