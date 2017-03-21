<?php
class Listlg extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url_helper');
		$this->load->model('list_model');
		$this->load->model('main_model');
		$this->load->model('user_model');
	}

	//列表
	public function index(){
		if ( ! file_exists(APPPATH.'views/list/gzlist.php')){
	        show_404();
	    }
	    $citycode = $this->main_model->getCityCode();		//获取当前地区名，放到首页头部
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
			
		$data['title'] = '零工列表页'; // 定义标题

		$data['firsts'] = $this->list_model->get_first_level();
		     $aaa = $this->list_model->get_one_two_three();

		     		 $data['lists'] = array();//调换在数据库里查出来的顺序    /**********
				     foreach($aaa as $key => $value){
				     	if($key == 1){
				     		$data['lists'][$key] = $value;
				     	}
				     }
				     foreach($aaa as $key => $value){
				     	if($key == 257){
				     		$data['lists'][$key] = $value;
				     	}
				     }
				     foreach($aaa as $key => $value){
				     	if($key == 412){
				     		$data['lists'][$key] = $value;
				     	}
				     }
				     foreach($aaa as $key => $value){
				     	if($key == 33){
				     		$data['lists'][$key] = $value;
				     	}
				     }
				     foreach($aaa as $key => $value){
				     	if($key == 218){
				     		$data['lists'][$key] = $value;
				     	}
				     }
				     foreach($aaa as $key => $value){
				     	if($key == 328){
				     		$data['lists'][$key] = $value;
				     	}
				     }
				     foreach($aaa as $key => $value){
				     	if($key == 375){
				     		$data['lists'][$key] = $value;
				     	}
				     }
				     // *********************/调换顺序结束	

		$one_id = $this->uri->segment(4);
		if($one_id){//根据Url地址获取一级分类id，如果有值就获取，没值不获取
		$data['one_name'] = $this->list_model->get_one($one_id);//根据url传过来的id获取分类、
	    }
		$two_id = $this->uri->segment(6);
		if($two_id){
			$data['two_name'] = $this->list_model->get_one($two_id);//根据url传过来的id获取职业、如果有值获取。没值不获取
		}
		$three_id = $this->uri->segment(8);

		$data['url_arr'] = $url_array = $this->uri->uri_to_assoc(3);
		
		$this->list_model->getGzList($url_array);//获取工种列表
	    $data['list'] = $list = $this->list_model->list;
	    foreach($list as $k => $v){
			$userinfo=$this->user_model->getUserBaseInfo($v['uid']);
			$data['user'][$k] = $userinfo['vip_endtime'];//检测是否是vip
			$c_name = $this->main_model->getcityName($v['city_id']);//获取发布的城市名

			$data['city_code'] = $this->main_model->cnameGetCcode($c_name['name']);//获取发布的城市名对应的城市简码
		}
//var_dump($this->list_model->list);

		$this->main_model->getDistArea();//获取区域二级列表
	    $data['list_dist'] = $this->main_model->list_dist;
	    $data['list_area'] = $this->main_model->list_area;	

		$this->load->view('templates/header',$data);
		$this->load->view('list/gzlist',$data);
		$this->load->view('templates/footer');
	}

	//零工详情页
	public function lgDetail(){
		if ( ! file_exists(APPPATH.'views/list/lgdetail.php')){
	        show_404();
	    }
	    $citycode = $this->main_model->getCityCode();		//获取当前地区名，放到首页头部
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
			
		$data['title'] = '零工详情页'; // 定义标题

		var_dump($_SESSION);
		$id = $this->uri->segment(3);
		$data['pv'] = $this->list_model->addGzPv($id);
		$this->list_model->getGzDetail($id);
		$data['person'] = $this->list_model->row;
		$data['firms'] = $this->list_model->row_user;
		$data['pl'] = $this->list_model->row_pl;

		$this->load->view('templates/header',$data);
		$this->load->view('list/lgdetail',$data);
		$this->load->view('templates/footer');
	}

	//零工搜索框
	public function lgsearch(){
		if ( ! file_exists(APPPATH.'views/list/gzlist.php')){
	        show_404();
	    }
	    $citycode = $this->main_model->getCityCode();		//获取当前地区名，放到首页头部
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
			
		$data['title'] = '零工列表页'; // 定义标题
		$keyword = $_POST['search'];
		$data['searchList'] = $this->list_model->getkeywordSearch($keyword);
var_dump($data['searchList']);
		$this->load->view('templates/header',$data);
		$this->load->view('list/gzlist',$data);
		$this->load->view('templates/footer');
	}

}

