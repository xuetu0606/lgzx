<?php
class Lista extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('main_model');
        $this->load->helper('url_helper');
		$this->load->model('list_model');
		$this->load->library('session');
    }


	public function index(){
		if ( ! file_exists(APPPATH.'views/list/gongzhong.php')){
	        show_404();
	    }
	    $data['title'] = '工种查询';//网页标题
	    $citycode = $this->main_model->getCityCode();		//获取当前地区名，放到首页头部
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		
	    $this->load->view('templates/header',$data);
	    $this->load->view('templates/head_search');
	    $data['url_arr'] = $url_array = $this->uri->uri_to_assoc(3);
	    $this->load->model('user_model');
	    $data['user'] = $this->user_model->getUserBaseInfo($_SESSION['uid']);
	    
	    $this->list_model->getGzList($url_array);//获取工种列表
	   $data['list'] = $this->list_model->list;
	    $data['count'] = $this->list_model->count;
	    $data['pagec'] = $this->list_model->pagec;
	    $data['url'] = $this->list_model->makeUrl_gz($url_array);
//	    print_r($url_array);
	    $this->main_model->getDistArea();//获取区域二级列表
	    $data['list_dist'] = $this->main_model->list_dist;
	    $data['list_area'] = $this->main_model->list_area;
	    $tmp_arr = $this->list_model->get_three_level();//获取行业职业工种三级列表
	    $data['list_level_1'] = $tmp_arr[0];
	    $data['list_level_2'] = $tmp_arr[1];
	    $data['list_level_3'] = $tmp_arr[2];
//	    print_r($tmp_arr);
	    $this->load->view('list/gongzhong',$data);
	    $this->load->view('templates/footer',$data);
	     
	}
	public function zlg(){
		if ( ! file_exists(APPPATH.'views/list/gongzhong.php')){
	        show_404();
	    }
	    $data['title'] = '招零工查询';//网页标题
	    $citycode = $this->main_model->getCityCode();		//获取当前地区名，放到首页头部
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		
	    $this->load->view('templates/header',$data);
	    $this->load->view('templates/head_search');
	    $data['url_arr'] = $url_array = $this->uri->uri_to_assoc(3);
	    
	    $this->list_model->getZlgList($url_array);//获取工种列表
	   $data['list'] = $this->list_model->list;
	    $data['count'] = $this->list_model->count;
	    $data['pagec'] = $this->list_model->pagec;
	    $data['url'] = $this->list_model->makeUrl_zlg($url_array);
//	    print_r($url_array);
	    $this->main_model->getDistArea();//获取区域二级列表
	    $data['list_dist'] = $this->main_model->list_dist;
//	    $data['list_area'] = $this->main_model->list_area;
	    $tmp_arr = $this->list_model->get_three_level();//获取行业职业工种三级列表
	    $data['list_level_1'] = $tmp_arr[0];
	    $data['list_level_2'] = $tmp_arr[1];
	    $data['list_level_3'] = $tmp_arr[2];
	    $this->load->model('form_model');
	    $data['pay_circle'] = $this->form_model->getPayCircle();
	    
//	    print_r( $data['pay_circle']);
	    $this->load->view('list/zhaolinggong',$data);
	    $this->load->view('templates/footer',$data);
	}
	public function ajaxlist(){
		$url_arr = $this->uri->uri_to_assoc(3);
		$this->list_model->getGzList($url_arr);//获取工种列表
		$list = $this->list_model->list;
	    $count = $this->list_model->count;
	    $pagec = $this->list_model->pagec;
//	    $data['url'] = $this->list_model->makeUrl($url_array);

	    $str = '<div  class = "page_flag" page="'.($url_arr['p']?$url_arr['p']:'1').'">';
	    foreach($list as $key=>$value){
	    $str .= '<div class="infor">';
	    $str .= '<a href="'.site_url('home/lgdetail/'.$value['id']).'">';
	    $str .= '<div class="portrait">';
	    $str .= '<img src="'.$value['img'].'" alt=""/>';
	    $str .= '<span>工号：</span><span>'.$value['no'].'</span>';
	    $str .= '</div>';
	    $str .= '<div class="txt">';
	    $str .= '<h3>';
	    if(mb_strlen($value['info1'])>15){$str .= mb_substr($value['info1'],0,15,'utf-8')."...";}else{$str .= mb_substr($value['info1'],0,15,'utf-8');}
	    $str .= '</h3>';
	    $str .= ' <span>'.$value['name'].'</span>';
	    $str .= '<span>'.($value['area_name']?$value['area_name']:$value['district_name']).'</span>';
	    $str .= '<span>'.($value['realname']?$value['realname']:$value['username']).'</span>';
	    $str .= '<span>'.($value['flushtime']?date('y-m-d',$value['flushtime']):date('y-m-d',$value['addtime'])).'</span>';
	    $str .= "<img src='/static/images/section/3-list/".($value['is_idno']?'rz.png':'wrz.png')."' class='rz' />";
	    $str .= '<img src="/static/images/section/3-list/'.$value['medal'].'.png" alt="" class="jp"/>';
	    $str .= '</div>';
	    $str .= '</a>';
	    $str .= '<a href="tel:'.$value['mobile'].'" class="img-tel"><img src="/static/images/section/3-list/tel.png" alt="电话" class="tel"/></a>';
	    $str .= '</div>';
	    }
	    $str .= '</div>';
        echo $str;exit;        
        
	}
	public function ajaxzlglist(){
		$url_arr = $this->uri->uri_to_assoc(3);
		$this->list_model->getZlgList($url_arr);//获取工种列表
		$list = $this->list_model->list;
	    $count = $this->list_model->count;
	    $pagec = $this->list_model->pagec;
//	    $data['url'] = $this->list_model->makeUrl($url_array);

	    $str = '<div  class = "page_flag" page="'.($url_arr['p']?$url_arr['p']:'1').'">';
	    foreach($list as $key=>$value){
	    $str .= '<div class="infor">';
	    $str .= '<a href="'.site_url('lista/zplgdetail/'.$value['id']).'">';
	    $str .= '<div class="portrait">';
	    $str .= '<img src="'.$value['img'].'" alt=""/>';
	    $str .= '<span>工号：</span><span>'.$value['no'].'</span>';
	    $str .= '</div>';
	    $str .= '<div class="txt">';
	    $str .= '<h3>';
	    if(mb_strlen($value['title'])>15){$str .= mb_substr($value['title'],0,15,'utf-8')."...";}else{$str .= mb_substr($value['title'],0,15,'utf-8');}
	    $str .= '</h3>';
	    $str .= ' <span>'.$value['pay'].$value['name'].'</span>';
	    $str .= '<span>'.'</span>';
	    $str .= '<span>'.($value['coname']?$value['coname']:$value['username']).'</span>';
	    $str .= '<span>'.($value['flushtime']?date('y-m-d',$value['flushtime']):date('y-m-d',$value['addtime'])).'</span>';
	    $str .= '</div>';
	    $str .= '</a>';
	    $str .= '<a href="tel:'.$value['mobile'].'" class="img-tel"><img src="/static/images/section/3-list/tel.png" alt="电话" class="tel"/></a>';
	    $str .= '</div>';
	    }
	    $str .= '</div>';
        echo $str;exit;        
	}
	public function ajaxsearch(){
		$k = $_POST['key'];
		$result = $this->list_model->getkeywordSearch($k);
		$str = "<ul>";
		foreach ($result[0] as $key=>$value){
			$value['name'] = str_replace($k,"<span class='hui'>$k</span>",$value['name']);
			if($value['level']==3){
				$url = "/lista/index/l1/".$value['pre_pre_id']."/l2/".$value['pre_id']."/l3/".$value['id'];
			}elseif($value['level']==2){
				$url = "/lista/index/l1/".$value['pre_id']."/l2/".$value['id'];
			}else{
				$url = "/lista/index/l1/".$value['id'];
			}
			$str .= "<li>";
			$str .= "<a href='".site_url($url)."'>";
			$str .= "<span >{$value['name']}</span>";
			$str .= "</a>";
			$str .= "</li>";
		}
		foreach($result[1] as $ke=>$val){
			$value['info1'] = str_replace($k,"<span class='hui'>$k</span>",$val['info1']);
			$str .= "<li>";
			$str .= "<a href='".site_url("home/lgdetail/".$val['id'])."'>";
			$str .= "<span >{$value['info1']}</span>";
			$str .= "</a>";
			$str .= "</li>";
		}
         $str .= "</ul>";
         echo $str;exit;
	}
	public function searchlist(){
		$data['k'] =  $_POST['k'];
		$data['title']= '查询结果';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/head_search',$data);
		$data['result'] = $this->list_model->getkeywordSearch($data['k'],10);
//		print_r($data['result']);
		$this->load->view('list/searchlist',$data);
	    $this->load->view('templates/footer',$data);
	}

	//点击招聘零工列表页，跳转到招聘零工详情页
	public function zplgdetail(){
		if ( ! file_exists(APPPATH.'views/home/lg_list/zplgdetail.php')){
	        show_404();
	    }
	    $citycode = $this->main_model->getCityCode();		//地区名
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		$data['title'] = '招聘零工详情页'; // 定义标题

		$id = $this->uri->segment(3);//获取URL传过来的id;
		$data['id'] = $id;
		$this->load->model('user_model');

		$data['details'] = $this->list_model->getZlgDetail($id);//查询详情页内容

		$data['pv'] = $this->list_model->addZlgPv($id);//添加pageview
		$id = $data['details']['uid'];
		$data['isvip'] = $this->user_model->isVip($id);

		$this->load->view('templates/header',$data);
	    $this->load->view('home/lg_list/zplgdetail',$data);
	    $this->load->view('templates/footer');
	}

	//点击消息文件，跳转到消息文件页
	public function message(){
		if ( ! file_exists(APPPATH.'views/home/lg_list/message.php')){
	        show_404();
	    }
	    //$this->load->model('user_model');
	    //var_dump($_SESSION);die();
	    if($_SESSION['uid']){
	    	$uid = $_SESSION['uid'];
	    	$citycode = $this->main_model->getCityCode();		//地区名
			$city_arr = $this->main_model->getCityInfoByCode($citycode);
			$data['cityname'] = $city_arr['name'];
			$data['title'] = '消息文件'; // 定义标题
			$data['get_message'] = $this->list_model->getMessage($uid);
			//var_dump($data['get_message']);
	    	$this->load->view('templates/header',$data);
	    	$this->load->view('home/lg_list/message',$data);
	    	$this->load->view('templates/footer');
	    }else{
	    	redirect('http://'.$_SERVER['HTTP_HOST'].'/user/index');
	    }
	}

	//点击消息文件，查看内容,并修改flag状态为已读
	public function messageContent(){
		if ( ! file_exists(APPPATH.'views/home/lg_list/messageContent.php')){
	        show_404();
	    }
	    if($_SESSION['uid']){
	    	$uid = $_SESSION['uid'];
	    	$citycode = $this->main_model->getCityCode();		//地区名
			$city_arr = $this->main_model->getCityInfoByCode($citycode);
			$data['cityname'] = $city_arr['name'];
			$data['title'] = '消息文件'; // 定义标题
			//$data['get_message'] = $this->list_model->getMessage(13);
			$id = $this->uri->segment(3);
			$data['idget_message'] = $this->list_model->get_row_Message($id);
			$this->list_model->updates($id);
			$this->load->view('templates/head_simple',$data);
			$this->load->view('home/lg_list/messageContent',$data);
			$this->load->view('templates/footer2');
	    }else{
	    	redirect('http://'.$_SERVER['HTTP_HOST'].'/user/index');
	    }
	}

	//点击删除，修改flag为-1
	public function delete(){
		//var_dump($_POST);
		foreach($_POST as $key => $value){
			$status = $this->list_model->deletes($key);
		}
		if($status){
			$data['errors'] = '删除成功';
		}else{
			$data['errors'] = '删除失败';
		}
			$uid = $_SESSION['uid'];
			$citycode = $this->main_model->getCityCode();		//地区名
			$city_arr = $this->main_model->getCityInfoByCode($citycode);
			$data['cityname'] = $city_arr['name'];
			$data['title'] = '消息文件'; // 定义标题
			$data['get_message'] = $this->list_model->getMessage($uid);

	    	$this->load->view('templates/header',$data);
	    	$this->load->view('home/lg_list/message',$data);
	    	$this->load->view('templates/footer');
	}

	//点击零工宝评价，跳转到相对应的uid评价页
	public function evaluate(){
		if ( ! file_exists(APPPATH.'views/home/tail/myevaluate.php')){
	        show_404();
	    }
	    if($_SESSION['uid']){
	    	$uid = $_SESSION['uid'];
	    	$citycode = $this->main_model->getCityCode();		//地区名
			$city_arr = $this->main_model->getCityInfoByCode($citycode);
			$data['cityname'] = $city_arr['name'];
			$data['title'] = '我的评价'; // 定义标题
			$this->load->model('user_model');
			$data['result'] = $this->user_model->getcredits($uid);
			//var_dump($data['result']);

			$this->load->view('templates/head_simple',$data);
			$this->load->view('home/tail/myevaluate',$data);
			$this->load->view('templates/footer2');
	    }else{
	    	redirect('http://'.$_SERVER['HTTP_HOST'].'/user/index');
	    }
	}
}