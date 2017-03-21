<?php
	/**
	 * 零工小参
	 */
	class Help extends CI_Controller {
		public function __construct(){
	        parent::__construct();
	        $this->load->helper('url');
	    }
	    //零工小参
	    public function index(){
	    	
	    }
	    //帮助中心
	    public function help(){
	    	$this->load->view('help');
	    }
	    //用户协议
	    public function yhxy(){
	    	$this->load->view('yhxy');
	    }
	    //常见问题
	    public function cjwt(){
	    	$this->load->view('cjwt');
	    }
	    //了解
	    public function lj(){
	    	$this->load->view('lj');
	    }
	    //加入
	    public function jr(){
	    	$this->load->view('jr');
	    }
	    //更多帮助
	    public function gdbz(){
	    	$this->load->view('gdbz');
	    }
	    //意见反馈
	    public function yjfk(){
	    	if($_POST){
	    		var_dump($_POST);
	    	}
	    	$this->load->view('yjfk');
	    }
	}
?>