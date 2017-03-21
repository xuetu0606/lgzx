<?php
class Home extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper( array('url_helper','form','cookie'));
		$this->load->model('list_model');
		$this->load->model('main_model');
		$this->load->library('session');
    }


	public function index(){
		if ( ! file_exists(APPPATH.'views/home/index.php')){
	        show_404();
	    }
	    echo '<marquee><span style="color:green;font-size:50px;">敬告：零工在线电脑版升级维护中（手机登录http://m.lg-zx.com手机版正常使用），给您带来不便，敬请谅解。400-860-6286</span></marquee>';
	    if($_SERVER['HTTP_HOST']=='pc.lg-zx.com'){//选择城市页面
			if(strpos($_SERVER['HTTP_REFERER'], 'lg-zx.com')){//判断来源是来自本站
				$data['title'] = '选择城市页'; // 定义标题
				$data['citylist'] = $this->main_model->get_provinc_city();

				$citycode = $this->main_model->getCityCode2();		//获取当前地区名，放到首页头部
				$city_arr = $this->main_model->getCityInfoByCode($citycode);
			    $data['cityname'] = $city_arr['name'];
				$this->load->view('templates/header',$data);
				$this->load->view('home/header/city',$data);
			    $this->load->view('templates/footer');
				
			}else{//判断来源非本站
				$data['flag'] = 1;//定一个开关

				$data['citylist'] = $this->main_model->get_provinc_city();
				foreach($data['citylist'] as $k => $v){
					if($v['sub']!=''){
						$data['citylist_json'][] = strval(json_encode($v['sub']));
					}
				}
				$this->load->view('home/header/city',$data);
			}
			

		}else{//城市首页
	    	$data['first_level'] = $this->list_model->get_first_level();
		     $data['two_level'] = $this->list_model->get_two_level();

		     foreach($data['two_level'] as $key => $value){
		     	$row[] = $this->list_model->getTwoThreeList($key);//获取二级三级分类列表
		     }
		     foreach($row as $key => $value){
		     	$data['list'][] = $value['list'];
				$data['list_hot'][] = $value['list_hot'];
		     }
		     
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


		     $data['new_list'] = $this->list_model->getLastList();
		     $c_name = array();
		     foreach($data['new_list'] as $key => $value){ 
		     		$c_name[] = $this->main_model->getcityName($value['city_id']);
		     		$data['c_name'] = $c_name;
		     }

			 $citycode = $this->main_model->getCityCode();		//获取当前地区名，放到首页头部
			 $city_arr = $this->main_model->getCityInfoByCode($citycode);
			 $data['cityname'] = $city_arr['name'];
			
		    $data['title'] = '首页'; // Capitalize the first letter
			$data['localhost'] = $_SERVER['HTTP_HOST'];//获取当前域名
			
			$this->load->view('templates/header',$data);
		    $this->load->view('home/index',$data);
		    $this->load->view('templates/footer');
	    }

	     
	}
	//根据当前城市名，获取城市简码
	public function currentCity(){
		$city = $_POST['city'];//接收ajax传过来的城市名

		$citycode = $this->main_model->cnameGetCcode($city);//根据城市名获取城市简码
		//redirect('http://qd.lg-zx.com');
		echo $return = json_encode($citycode);
		
	}

	//城市页搜索框逻辑
	public function searchCity(){
		if( ! file_exists(APPPATH.'views/home/header/city.php')){
			show_404();
		}
		$city = $_POST['city']; 
		$citycode = $this->main_model->cnameGetCcode($city);
		if($citycode){
			redirect("http://{$citycode['pinyin']}.lg-zx.com");
		}else{
			$this->main_model->alert('查找失败，请重新提供城市名','back');
		}
	}
	
	//根据一级分类，点击跳到二级分类列表
	public function profession(){
		if ( ! file_exists(APPPATH.'views/home/profession.php')){
	        show_404();
	    }
		
		$data['title'] = '分类页'; // 定义标题
		
	    $data['l1'] = $id = $this->uri->segment(3);//获取URL传过来的一级分类的参数
		$row = $this->list_model->getTwoThreeList($id);
		
		$data['list'] = $row['list'];
		$data['list_hot'] = $row['list_hot'];
		
		$citycode = $this->main_model->getCityCode();		//地区名
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		
		$data['get_one'] = $this -> list_model -> get_one($id);
		//var_dump($data['get_one']);die();
	    $this->load->view('templates/header',$data);
		$this->load->view('templates/head_search');
	    $this->load->view('home/profession',$data);
	    $this->load->view('templates/footer');
	}
	
	//点击二级分类，跳到零工列表页
	public function lglist(){
		if ( ! file_exists(APPPATH.'views/home/lg_list/list.php')){
	        show_404();
	    }
		$data['title'] = '列表页'; // 定义标题

		$id = $this->uri->segment(3);//获取URL传过来的二级分类id;
		
		$citycode = $this->main_model->getCityCode();		//地区名
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		
		$this->load->view('templates/header',$data);
		$this->load->view('templates/head_search');
	    $this->load->view('home/lg_list/list');
		$this->load->view('templates/footer');
	}
	
	//点击最新发布，跳转到零工详情页
	public function lgdetail(){
		if ( ! file_exists(APPPATH.'views/home/lg_list/detail.php')){
	        show_404();
	    }
	    $citycode = $this->main_model->getCityCode();		//地区名
		$data['citycode'] = $citycode;
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		$data['title'] = '详情页'; // 定义标题
		
		$id = $this->uri->segment(3);//获取URL传过来的id;
		$data['id'] = $id;
		$this->list_model->getGzDetail($id);
		$data['person'] = $this->list_model->row;
		$data['firms'] = $this->list_model->row_user;
		$data['pl'] = $this->list_model->row_pl;

		$uid = $data['person']['uid'];
		//echo $uid;

		$this->load->view('templates/header',$data);
	    $this->load->view('home/lg_list/detail',$data);
	    $this->load->view('templates/footer');
	}

	//ajax 统计访问量
	public function pv(){
		$id=$this->input->post('id', TRUE);
		// var_dump($id);
		// $this->list_model->getGzDetail($id);//查询详情页内容
		$this->list_model->addGzPv($id);//添加访问量pv
		exit;
	}
	
	//点击零工小参，跳转
	public function lgxc(){
		if ( ! file_exists(APPPATH.'views/home/tail/lgxc.php')){
	        show_404();
	    }
		$citycode = $this->main_model->getCityCode();		//地区名
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		$this->load->model('lgxc_model');
		$data['content'] = $this->lgxc_model->get_lgxc_content();
		$data['title'] = '零工小参页'; // 定义标题

		$this->load->view('templates/head_simple',$data);
		$this->load->view('home/tail/lgxc',$data);
		$this->load->view('templates/footer2');
	}
	
	//点击零工小参标题，查看内容
	public function content(){
		if ( ! file_exists(APPPATH.'views/home/tail/content.php')){
	        show_404();
	    }
		$citycode = $this->main_model->getCityCode();		//地区名
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		$this->load->model('lgxc_model');
		$content = $this->lgxc_model->get_lgxc_content();
		$data['title'] = '零工小参页'; // 定义标题

		$id = $this->uri->segment(3);
		//echo $id;
		foreach($content as $value){
			if($value['id'] == $id){
				$data['content'] = $value;
			}
		}

		$this->load->view('templates/head_simple',$data);
		$this->load->view('home/tail/content',$data);
		$this->load->view('templates/footer2');
	}

	//点击签到，判断用户是否登录
	public function sign(){
		if ( ! file_exists(APPPATH.'views/home/sign/sign.php')){
	        show_404();
	    }
	    $citycode = $this->main_model->getCityCode();		//地区名
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		$data['title'] = '签到页'; // 定义标题
		
		$this->load->model('sign_model');
		if($_SESSION['uid']){
			$uid = $_SESSION['uid'];
			//var_dump($_SESSION);
			$data['signcount'] = $this->sign_model->sign_add($uid,$citycode);
			
			$this->load->view('templates/header',$data);
			$this->load->view('home/sign/sign',$data);
			$this->load->view('templates/footer');
		}else{
			if ( ! file_exists(APPPATH.'views/home/sign/sign-login.php')){
	       		show_404();
	    	}
			$this->load->view('templates/header',$data);
			$this->load->view('home/sign/sign-login.php',$data);
			$this->load->view('templates/footer');
		}
	}

	public function ajaxcheckmobile(){
		$mobile=$this->input->post('mobile', TRUE);
		$this->load->model('user_model');
		$result = $this->user_model->checkIsMobile($mobile);//判断手机号码是否有效
		
		if($result){
               if($this->sendTime($mobile)){
                    //生成随机验证码
                    $code=$this->random(6);
                    //发送内容
                    $content = '【零工在线】您的短信验证码：'.$code.'，请正确输入验证码完成操作。请勿向任何人提供您收到的短信验证码。';
                    if($this->sendSMS($mobile,$content)){

                        $return["status"]="success";
                        $return['msg']=$code;//'发送成功';
                        $_SESSION['code']=$code;

                    }else{
                    	$return["status"]="fail";
                        $return['msg']='发送失败';
                    }
                }else{
                	$return["status"]="fails";
                    $return['msg']='正在发送。。。';
                }

		}else{
			$return["status"]="fail";
            $return['msg']='手机号码无效';
		}
		echo $return = json_encode($return);exit;
	}

	//sign_login点击签到按钮
	public function signs(){
		$sess_code = strtolower($_SESSION['code']);//获取SESSION里的验证码,并转换成小写
		$phone = $_POST['phone'];//获取用户输入的手机号
		$code = strtolower($_POST['code']);//获取用户输入的验证码，并转换成小写
		
			$citycode = $this->main_model->getCityCode();		//地区名
			$city_arr = $this->main_model->getCityInfoByCode($citycode);
			$data['cityname'] = $city_arr['name'];
			$data['title'] = '签到页'; // 定义标题
		if($code == $sess_code){//判断用户输入的验证码和session里存的是否一致
			$this->load->model('user_model');
			$this->load->model('sign_model');
			$uid = $this->user_model->checkMobile($phone);
			if($uid){//根据uid判断用户是否存在
				$data['signcount'] = $this->sign_model->sign_add($uid,$citycode);

				$this->load->view('templates/header',$data);
				$this->load->view('home/sign/sign',$data);
				$this->load->view('templates/footer');
				$this->session->unset_userdata('code');
			}else{
				$data['c_id'] = $city_arr['id'];//城市简码

				//echo $data['c_id'];/************************/

				$param = $this->main_model->getprovinc($data['c_id']);
				$data['p_id'] = $param[0]['upid'];//省份简码
				$data['mobile'] = $phone;
				$info = $this->user_model->addUseAuto($data);
				if($info['flag'] == 1){//自动注册用户，并签到一次

					// echo $info['uid'];/************************/

					$uid = $info['uid'];

					$data['signcount'] = $this->sign_model->sign_add($uid,$citycode);

					$this->load->view('templates/header',$data);
					$this->load->view('home/sign/firstsign',$data);
					$this->load->view('templates/footer');
				}
			}
		}else{
			if ( ! file_exists(APPPATH.'views/home/sign/sign-login.php')){
	       		show_404();
	    	}
	    	$data['errors'] = '验证码输入错误，请重新输入。';
			$this->load->view('templates/header',$data);
			$this->load->view('home/sign/sign-login.php',$data);
			$this->load->view('templates/footer');
		}
	}

	 /**
     * 手机验证码时间限制
     *
     */
    public function sendTime($mobile)
    {
        $spacing = 120; //间隔时间 秒
        if(!get_cookie($mobile)){
            set_cookie($mobile,time(),60);
            return TRUE;
        }else{
            if((time() - get_cookie($mobile)) > $spacing){
                return TRUE;
            }else{
                return FALSE;
            }
        }
    }
       /**
     * 发送手机验证码
     *
     */
    public function sendSMS($mobile,$content,$time='',$mid='')
    {
        $uid = 'qdlgzx';	//用户账号
        $pwd = '63827c906e4e2995130b96c6267ca3da';	//用户密码
        $http = 'http://115.29.103.223:8080/smsServer/submit';		//发送地址
        $data = array
        (
            'CORPID'=>$uid,				//用户账号
            'CPPW'=>$pwd,				//密码
            'PHONE'=>$mobile,				//被叫号码
            'CONTENT'=>$content,				//内容
        );
        $re= '#'.$this->postSMS($http,$data);
        if(strpos ($re, "SUCCESS") > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    public function postSMS($url,$data='')
    {
        $row = parse_url($url);
        $host = $row['host'];
        $port = $row['port'] ? $row['port']:8080;
        $file = $row['path'];
        foreach($data as $k => $v)
        {
            $post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
        }
        $post = substr( $post , 0 , -1 );
        $len = strlen($post);
        $fp = fsockopen( $host ,$port, $errno, $errstr, 10);
        if (!$fp) {
            return "$errstr ($errno)\n";
        } else {
            $receive = '';
            $out = "POST $file HTTP/1.1\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Content-type: application/x-www-form-urlencoded\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Content-Length: $len\r\n\r\n";
            $out .= $post;
            fwrite($fp, $out);
            while (!feof($fp)) {
                $receive .= fgets($fp, 128);
            }
            fclose($fp);
            $receive = explode("\r\n\r\n",$receive);
            unset($receive[0]);
            return implode("",$receive);
        }
    }

     /**
     * 生成随机数
     *
     */
    public function random($v){
        srand((double)microtime()*1000000);//create a random number feed.
        $ychar="0,1,2,3,4,5,6,7,8,9";
        //$ychar="0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
        $list=explode(",",$ychar);
        for($i=0;$i<$v;$i++){
            $randnum=rand(0,10); // 10+26;
            $authnum.=$list[$randnum];
        }
        return $authnum;
    }

    //点击我要评价
    public function evaluate(){
    	if ( ! file_exists(APPPATH.'views/home/tail/evaluate.php')){
	        show_404();
	    }
	    if($_SESSION['uid']){

			$citycode = $this->main_model->getCityCode();		//地区名
			$city_arr = $this->main_model->getCityInfoByCode($citycode);
			$data['cityname'] = $city_arr['name'];
			$data['title'] = '评价页'; // 定义标题
	    	$this->load->view('templates/header',$data);
			$this->load->view('home/tail/evaluate.php',$data);
			$this->load->view('templates/footer2');
	    }else{
			redirect(site_url('user/index'));
	    }
    }

    //提交评价页
    public function doevaluate(){
    	$uid = $_SESSION['uid'];
    	$number = $_POST['number'];
    	$skill = $_POST['skill'];
    	$timely = $_POST['timely'];
    	$manner = $_POST['manner'];
    	$standard = $_POST['standard'];
    	$textarea = $_POST['textarea'];

    	$citycode = $this->main_model->getCityCode();		//地区名
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		$data['title'] = '评价页'; // 定义标题

    	$credits = $skill+$timely+$manner+$standard;
    	if($_POST['number']){
	    	$this->load->model('user_model');
	    	$num = $this->user_model->numGetUid($number);
	    	if($num && $num != $uid){
	    		$this->user_model->addcredits($number,$credits,$textarea,$uid);
	    		$this->load->view('templates/head_simple',$data);
				$this->load->view('home/tail/evaluate2.php',$data);
				$this->load->view('templates/footer2');

	    	}else if($num == $uid){
	    		$data['error'] = '您不能给自己评论！';
		    	$this->load->view('templates/header',$data);
				$this->load->view('home/tail/evaluate.php',$data);
				$this->load->view('templates/footer2');
	    	}else{
		    	$data['error'] = '工号输入错误，请确认后重新输入！';
		    	$this->load->view('templates/header',$data);
				$this->load->view('home/tail/evaluate.php',$data);
				$this->load->view('templates/footer2');
	    	}
	    }else{
	    	$data['error'] = '请输入工号！';
	    	$this->load->view('templates/header',$data);
			$this->load->view('home/tail/evaluate.php',$data);
			$this->load->view('templates/footer2');
	    }

    }

    //签约推广
    public function contractads(){
    	if ( ! file_exists(APPPATH.'views/home/tail/contract.php')){
	        show_404();
	    }
    	$citycode = $this->main_model->getCityCode();		//地区名
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		$data['title'] = '签约推广'; // 定义标题

		$uid = $_SESSION['uid'];
		if($uid){
			//var_dump($_SESSION);die('out');
			if($_SESSION['is_co'] == 1){//判断如果是公司用户，则提示没开通此服务
				$this->load->view('templates/head_simple',$data);
				$this->load->view('home/tail/hint',$data);
				$this->load->view('templates/footer2');
			}else if($_SESSION['is_co'] == 0){
				$this->load->model('user_model');
				$result = $this->user_model->checkIsReal($uid);
				if($result['flag'] == 1){//当用户已经实名的时候
					$this->load->model('form_model');
					$res = $this->form_model->checkIsPro($uid);//检查用户是否已经签约
					if($res){//检查是否已提交过签约信息
							redirect(site_url('home/contract_success'));
	    			}else{
	    				$data['personal'] = $this->user_model->getPersonalBaseInfo($uid);
	    				if($_POST['post_flag']==1){
	    					$arr['name'] = $_POST['username'];
					    	$arr['uid'] = $uid;
					    	$arr['idno'] = $_POST['idno'];
					    	$arr['qq'] = $_POST['qq'];
					    	$arr['wechat'] = $_POST['wechat'];
					    	if(empty($arr['qq'])){//判断QQ号微信号不能为空
	    						$data['error'] = 'QQ号不能为空！';
	    					}elseif(empty($arr['wechat'])){
	    						$data['error'] = '微信号不能为空！';
	    					}else{
	    						$result = $this->form_model->addPromotion($arr);
	    						if($result){
	    							redirect(site_url('home/contract_success'));
	    						}
	    					}	
	    				}
	    				$this->load->view('templates/head_simple',$data);
				        $this->load->view('home/tail/contract',$data);
				        $this->load->view('templates/footer2',$data);	
			    	
	    			}
				}else if($result['flag'] == -1){//当用户未实名的时候
					$this->main_model->alert('请先实名认证，认证通过后签约推广',site_url('user/identify'));
					//redirect(site_url('user/identify'));
				}else if($result['flag'] == 0){
					$this->load->view('templates/head_simple',$data);
					$this->load->view('home/tail/hints',$data);
					$this->load->view('templates/footer2');
				}
			}
		}else{
			redirect(site_url('user/index'));
		}
    }
    public function contract_success(){
    	$data['title'] = "签约推广结果";
    	$this->load->view('templates/head_simple',$data);
    	$this->load->model('form_model');
    	$uid = $_SESSION['uid'];
		$res = $this->form_model->checkIsPro($uid);//检查用户是否已经签约
		if($res){//检查是否签约
    		if($res['flag'] == 1){//审核通过
    			$data['arr2'] = $this->form_model->getPromotionList($uid);
    			
				$this->load->view('home/tail/earnings',$data);
    		}else if($res['flag'] == 0){//待审核
    			$data['info'] = "【我们将尽快审核，稍后将审核结果发到您的消息文件中，如有疑问请拨打客服电话：400-860-6286咨询】";
				$this->load->view('home/tail/contract-success',$data);
    		}
    	}else{
    		redirect(site_url('home/contractads'));
    	}	
    }

    //执行并处理签约推广
    public function docontractads(){
    	if ( ! file_exists(APPPATH.'views/home/tail/contract-success.php')){
	        show_404();
	    }
    	$citycode = $this->main_model->getCityCode();		//地区名
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		$data['title'] = '签约推广'; // 定义标题
		$uid = $_SESSION['uid'];
		$this->load->model('form_model');
    	$arr['name'] = $_POST['username'];
    	$arr['uid'] = $_SESSION['uid'];
    	$arr['idno'] = $_POST['idno'];
    	if(empty($_POST['qq'])){//判断QQ号微信号不能为空
    		$data['error'] = 'QQ号不能为空！';
    		$this->load->model('user_model');
		    
		    $data['personal'] = $this->user_model->getPersonalBaseInfo($uid);
			$this->load->view('templates/head_simple',$data);
			$this->load->view('home/tail/contract',$data);
			$this->load->view('templates/footer2');
    	}else{
    		$arr['qq'] = $_POST['qq'];
    		if(empty($_POST['wechat'])){
    			$data['error'] = '微信号不能为空！';
    			$this->load->model('user_model');
		    	$uid = $_SESSION['uid'];
		    	$data['personal'] = $this->user_model->getPersonalBaseInfo($uid);
				$this->load->view('templates/head_simple',$data);
				$this->load->view('home/tail/contract',$data);
				$this->load->view('templates/footer2');
    		}else{
    			$arr['wechat'] = $_POST['wechat'];

    			if(empty($_POST['words'])){//判断留言不能为空，如果为空，赋值一个空字符串
    				$arr['info'] = " ";
    			}else{
    				$arr['info'] = $_POST['words'];
    			}
    			$res = $this->form_model->checkIsPro($uid);

    			
    		}
    	}

    }
    //签约推广协议
    public function agreement(){
    	if ( ! file_exists(APPPATH.'views/home/tail/service-agreement.php')){
	        show_404();
	    }
    	$citycode = $this->main_model->getCityCode();		//地区名
		$city_arr = $this->main_model->getCityInfoByCode($citycode);
		$data['cityname'] = $city_arr['name'];
		$data['title'] = '签约推广协议'; // 定义标题
    	$this->load->view('templates/head_simple',$data);
		$this->load->view('home/tail/service-agreement',$data);
		$this->load->view('templates/footer2');
    }
}