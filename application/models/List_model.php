<?php
class List_model extends CI_Model {


    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }
//获取第一级类别列表
    public function get_first_level()
    {
        $query = $this->db->query("select id,name from job_type where level=1 ");
        return $query->result_array();
    }

//获取第一级和第二级类别关联列表
    public function get_two_level(){
    	$arr = array();
        $query = $this->db->query("select id,name from job_type where level=1 ");
        while ($row = $query->unbuffered_row('array')){
				$sub_arr = array();
			   $query1 = $this->db->query("select id,name from job_type where level=2 and pre_id='{$row['id']}'");
			   while($row1 = $query1->unbuffered_row('array')){
			     $sub_arr[$row1['id']] = $row1['name'];
			   }
			   $arr[$row['id']]=array('name'=>$row['name'],'sub'=>$sub_arr);
			}

        return $arr;
    }

    public function get_one_two_three(){
        $sql = "select job_type.id as id_1,job_type.name as name_1,job_type2.id as id_2,job_type2.name as name_2,job_type3.id as id_3,
job_type3.name as name_3,job_type2.sort 
from job_type
inner join job_type as job_type2 on job_type.id = job_type2.pre_id
inner join job_type as job_type3 on job_type2.id = job_type3.pre_id
where  1
order by job_type3.sort,id_3";

$query = $this->db->query($sql);
        while($row = $query->unbuffered_row('array')){
            $arr[$row['id_1']]['name'] =  $row['name_1'];
            $arr[$row['id_1']]['sub'][$row['id_2']]['name'] = $row['name_2'];
            $arr[$row['id_1']]['sub'][$row['id_2']]['sub'] [$row['id_3']]['name']= $row['name_3'];

        }
        return $arr;
    }
    /**
     * 获取行业职业工种三级列表
     *
     */
    public  function get_three_level(){
       $arr = array();
       $query = $this->db->query("select id,name,pre_id,pre_pre_id,level from job_type ");
       while ($row = $query->unbuffered_row('array')){
       		if($row['level']==1){
       			$arr1[$row['id']] = $row['name'];
       		}
       		if($row['level']==2){
       			$arr2[$row['pre_id']][$row['id']] = $row['name'];
       		}
       		if($row['level']==3){
       			$arr3[$row['pre_pre_id']][$row['pre_id']][$row['id']] = $row['name'];
       		}
       }
       return array($arr1,$arr2,$arr3);
    }
    /**
     * 根据第一级（行业）遍历第二级（职业）和关联第三极（工种）热门数据和关联第三级（所有数据）
     *
     */
    public function getTwoThreeList($id){
    	$sql = "select job_type.id as id_2,job_type.name as name_2,job_type1.id as id_3,job_type1.name as name_3,job_type1.sort from job_type
				inner join job_type as job_type1 on job_type.id = job_type1.pre_id
				where job_type.level=2  and job_type1.level=3 and job_type.pre_id=$id
				order by job_type1.sort,job_type.id";
    	$query = $this->db->query($sql);
    	while($row = $query->unbuffered_row('array')){
    		$arr[$row['id_2']]['name'] = $arr_hot[$row['id_2']]['name']  = $row['name_2'];
    		$arr[$row['id_2']]['sub'][$row['id_3']] = $row['name_3'];
    		if($row['sort']>0){
    			$arr_hot[$row['id_2']]['sub'][$row['id_3']] = $row['name_3'];
    		}
    	}
//    	$this->list = $arr;
//    	$this->list_hot = $arr_hot;
		
		$ret['list'] = $arr;
		$ret['list_hot'] = $arr_hot;
    	return $ret;
    }
	
	//根据首页传过来的id。查找一级分类
	public function get_one($id){
		$sql = "select name from job_type where id={$id}";
		$query = $this ->db-> query($sql);
		$arr = $query->row_array();
		return $arr['name'];
	}

    /**
     * 取得最新发布的工种列表
     *参数：$limit 条数限制，默认5条
     * 返回值：列表数组 其中job_code有值则为正常发布，否则为快速发布
     */
    public function getLastList($limit=10){
    	$this->load->model('Main_model');
    	$citycode = $this->Main_model->getCityCode();
    	$city_arr = $this->Main_model->getCityInfoByCode($citycode);
    	
    	$sql="SELECT publish_list.id, userlist.uid,userlist.username,publish_list.mobile, publish_list.info1,publish_list.flag,
    		  publish_list.addtime,publish_list.city_id,publish_list_service_district.district_id,district_dic.`name`,job_code
 			  FROM `publish_list` 
			  inner join userlist on publish_list.uid=userlist.uid
			  left join publish_list_service_district on  publish_list.id=publish_list_service_district.publish_id
			  left join district_dic on district_dic.id = publish_list_service_district.district_id
			  where publish_list.city_id='{$city_arr['id']}' and publish_list.flag<>-1
			  order by addtime desc limit $limit";
    	$query = $this->db->query($sql);
    	while($row = $query->unbuffered_row('array')){
    		
    		//处理省市区域名称，过滤最后一位
			if(mb_substr($row['name'],-1,1)=='区'||mb_substr($row['name'],-1,1)=='市'){
    		$row['distname'] = mb_substr($row['name'],0,-1);}
    		$arr[] = $row;
    		unset($row);
    	}
    	return $arr;
    }
    
    /**
     * 获取工种查询列表
     * @param unknown_type $data 参数包含：
     * l1-一级分类，l2-二级分类，l3-三级分类，d-区县，a-片区，s-性别，t-类型，stu-是否大学生，f-是否涉外，r-是否实名认证，o-是否上门服务，or-顺序,p-当前页码,pz-每页记录数默认10
     * page-当前页码 默认1，pagesie-每页记录条数 默认10，
     * 
     * 
     */
    public function getGzList($data){
    	extract($data);
    	$this->load->model('Main_model');
    	$citycode = $this->Main_model->getCityCode();
    	$city_arr = $this->Main_model->getCityInfoByCode($citycode);
    	$pz = $pz?$pz:10;
    	$start = $p?(($p-1)*$pz):0;
    	
    	$sql_part = "from publish_list ";
    	if($l1||$l2||$l3){
    		$sql_part .=" inner join job_type on job_type.id=publish_list.job_code and level=3 ";
    	}else{
    		$sql_part .=" left join job_type on job_type.id=publish_list.job_code and level=3 ";
    	}
    	if($d||$a){
    		$sql_part .= " inner join publish_list_service_district on publish_list_service_district.publish_id=publish_list.id ";
    	}else{
//    		$sql_part .= " left join publish_list_service_district on publish_list_service_district.publish_id=publish_list.id ";
    	}
		$sql_part .=" inner join userlist on publish_list.uid=userlist.uid ";
		if(!is_null($s)){
    		$sql_part .= " inner join user_personal on userlist.uid=user_personal.uid ";
    	}
		$sql_part .=" where publish_list.city_id= '{$city_arr['id']}' and publish_list.flag=1 ";
		$l1 &&$sql_part .= " and job_type.pre_pre_id=$l1";
		$l2 &&$sql_part .= " and job_type.pre_id=$l2";
		$l3 &&$sql_part .= " and job_type.id=$l3";
		$d && $sql_part .= " and (publish_list_service_district.district_id=$d or publish_list_service_district.district_id is null) ";
		$a && $sql_part .= " and (publish_list_service_district.area_id=$a or publish_list_service_district.area_id is null)";
		$s &&$sql_part .= " and user_personal.sex='$s' ";
		(!is_null($t)&&$t<>'all') &&$sql_part .= " and userlist.is_co='$t' ";
		(!is_null($stu)&&$stu<>'all') &&$sql_part .= " and publish_list.is_student='$stu' ";
		!is_null($f)&&$f<>'all' &&$sql_part .= " and publish_list.is_for_foreign='$f' ";
		!is_null($r)&&$r<>'all' &&$sql_part .= " and userlist.is_real='$r' ";
		!is_null($o)&&$o<>'all' &&$sql_part .= " and publish_list.is_onsite_service='$o' ";
		
		($d||$a) && $sql_part .= " group by publish_list.id";
    	$sql = "select info1,userlist.uid,no,username,userlist.is_real, job_type.`name`,publish_list.id,userlist.is_co,userlist.credit3,publish_list.mobile,publish_list.flushtime,publish_list.img as pimg,publish_list.city_id,publish_list.addtime 
				$sql_part ";
    	($or==0||!$or) && $sql .=" order by publish_list.flushtime desc,publish_list.addtime DESC ";//
    	$or==1 && $sql .=" order by userlist.credit3 DESC ";
		$sql .= " limit $start,$pz ";
//    	echo $sql;
    	$query = $this->db->query($sql);
    	while ($row = $query->unbuffered_row('array')) {
			
			$sql1 = "select district_id,area_id,
					(select name from district_dic where id=publish_list_service_district.district_id )as district_name,
					(select name from district_dic where id=publish_list_service_district.area_id )as area_name 
					from publish_list_service_district where publish_id='{$row['id']}'";
//			echo $sql1;
			$query1 = $this->db->query($sql1);
			while ($row1 = $query1->unbuffered_row('array')) {
				$row['dist'][$row1['district_id']] =  $row1['district_name'];
				$row['dist'][$row1['area_id']] =  $row1['area_name'];
			}

			if($row['is_co']==1){//公司类型
				$sql2 = "select coname as realname,img,idno from user_co where uid='{$row['uid']}'";
				$img_src = "/upload/".$citycode."/gstx/";   
			}else{//个人类型
				$sql2 = "select realname,img,idno from user_personal where uid='{$row['uid']}'";
				$img_src = "/upload/".$citycode."/grtx/";
			}
//			echo $sql2;
			$query1 = $this->db->query($sql2);
			$row2 = $query1->row_array();

			$row['realname'] = $row2['realname'] ;
			
			$row['img'] = $row2['img']?($img_src.$row2['img']):"/static/images/default/noimg.jpg" ;
			$row['idno'] = $row2['idno'] ;
			if($row['is_real']){//是实名认证
				$row['medal'] = 'jin';      
			}elseif($row['credit3']>=17){
				$row['medal'] = 'jin';  
			}elseif($row['credit3']>=9){
				$row['medal'] = 'yin';
			}elseif($row['credit3']>=4){ 
				$row['medal'] = 'tong';
			}else{
				$row['medal'] = 'wdj';
			}
			$arr[] = $row;

    	}
    	$this->list = $arr;
    	//总数
    	$sql_c = "select count(publish_list.id) as c ".$sql_part;
    	$query = $this->db->query($sql_c);
		$row_c = $query->row_array();
		$this->count = $row_c['c'];
		$this->pagec = ceil($row_c['c']/$pz);
    	
    }
    /**
     * 获取工种查询列表
     * @param unknown_type $data 参数包含：
     * l1-一级分类，l2-二级分类，l3-三级分类，d-区县，x-薪资结算类型，or-顺序,p-当前页码,pz-每页记录数默认10
     * page-当前页码 默认1，pagesie-每页记录条数 默认10，
     * 
     * 
     */
    public function getZlgList($data){
    	extract($data);
    	$this->load->model('Main_model');
    	$citycode = $this->Main_model->getCityCode();
    	$city_arr = $this->Main_model->getCityInfoByCode($citycode);
    	$pz = $pz?$pz:10;
    	$start = $p?(($p-1)*$pz):0;
    	
    	$sql_part = " FROM `invite_list`";
    	if($l1||$l2||$l3){
    		$sql_part .=" inner join job_type on job_type.id=invite_list.job_code and level=3 ";
    	}else{
    		$sql_part .=" left join job_type on job_type.id=invite_list.job_code and level=3 ";
    	}
		$sql_part .=" inner join userlist on invite_list.uid=userlist.uid 
					left join user_co on user_co.uid=userlist.uid
					left join pay_unit_dic on invite_list.pay_unit=pay_unit_dic.id";

		$sql_part .=" where invite_list.city_id= '{$city_arr['id']}' and invite_list.flag=1 ";
		$l1 &&$sql_part .= " and job_type.pre_pre_id=$l1";
		$l2 &&$sql_part .= " and job_type.pre_id=$l2";
		$l3 &&$sql_part .= " and job_type.id=$l3";
		$d && $sql_part .= " and (invite_list.district_id=$d or invite_list.district_id is null)";;
		$x &&$sql_part .= " and invite_list.pay_circle='$x' ";
    	$sql = "SELECT invite_list.id,invite_list.title, invite_list.pay,userlist.mobile,
				pay_unit_dic.name,userlist.no,userlist.username,user_co.coname,user_co.img,invite_list.addtime
				$sql_part ";
    	($or==0||!$or) && $sql .=" order by invite_list.flushtime desc,invite_list.addtime DESC ";

		$sql .= " limit $start,$pz ";
//    	echo $sql;
    	$query = $this->db->query($sql);
    	while ($row = $query->unbuffered_row('array')) {
			$img_src = "/upload/".$citycode."/gstx/"; 
			$row['img'] = $row['img']?($img_src.$row['img']):"/static/images/default/noimg.jpg" ;
			$arr[] = $row;

    	}
    	$this->list = $arr;
    	//总数
    	$sql_c = "select count(invite_list.id) as c ".$sql_part;
    	$query = $this->db->query($sql_c);
		$row_c = $query->row_array();
		$this->count = $row_c['c'];
		$this->pagec = ceil($row_c['c']/$pz);
    	
    }
    /**
     * 根据关键词查询
     *
     * @param unknown_type $k
     */
    public function getkeywordSearch($k,$limit=5){
    	//查询工种类别名
    	$sql = "select * from job_type where name like '%$k%' order by level limit $limit ";
    	$query = $this->db->query($sql);
		$result1 = $query->result_array();
    	//查询工种title
    	$sql1 = "select id,info1 from publish_list where info1 like '%$k%' and flag<>-1 order by flushtime desc ,addtime desc limit $limit ";
		$query1 = $this->db->query($sql1);
		$result2 = $query1->result_array();
		return array($result1,$result2);
    }
    
    /**
     * 组织工种查询列表的url
     *l1-一级分类，l2-二级分类，l3-三级分类，d-区县，a-片区，s-性别，t-类型，stu-是否大学生，f-是否涉外，r-是否实名认证，o-是否上门服务，or-顺序,p-当前页码
     * @param unknown_type $data
     */
    public function makeUrl_gz($data){
    	extract($data);
//    	var_dump($t);
//    	var_dump($t==0);
//    	var_dump(is_null($t));
    	$str = "/lista/index";
    	$l1&&$l1_tmp = "/l1/$l1";
    	$l2&&$l2_tmp = "/l2/$l2";
    	$l3&&$l3_tmp = "/l3/$l3";
    	$d&&$d_tmp = "/d/$d";
    	$a&&$a_tmp = "/a/$a";
    	$s&&$s_tmp = "/s/$s";
    	(!is_null($t)&&$t<>'all')&&$t_tmp = "/t/$t";
    	(!is_null($stu)&&$stu<>'all')&&$stu_tmp = "/stu/$stu";
    	(!is_null($f)&&$f<>'all')&&$f_tmp = "/f/$f";
    	(!is_null($r)&&$r<>'all')&&$r_tmp = "/r/$r";
    	(!is_null($o)&&$o<>'all')&&$o_tmp = "/o/$o";
    	$or&&$or_tmp = "/or/$or";
    	$p&&$p_tmp = "/p/$p";
//var_dump( $t_tmp);
    	$l1_str  = $str.($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($s_tmp?$s_tmp:'').($t_tmp?$t_tmp:'').($stu_tmp?$stu_tmp:'').($f_tmp?$f_tmp:'').($r_tmp?$r_tmp:'').($o_tmp?$o_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/l1/";
    	$l2_str  = $str.($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($s_tmp?$s_tmp:'').($t_tmp?$t_tmp:'').($stu_tmp?$stu_tmp:'').($f_tmp?$f_tmp:'').($r_tmp?$r_tmp:'').($o_tmp?$o_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/l2/";
    	$l3_str  = $str.($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($s_tmp?$s_tmp:'').($t_tmp?$t_tmp:'').($stu_tmp?$stu_tmp:'').($f_tmp?$f_tmp:'').($r_tmp?$r_tmp:'').($o_tmp?$o_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/l3/";
    	$d_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($s_tmp?$s_tmp:'').($t_tmp?$t_tmp:'').($stu_tmp?$stu_tmp:'').($f_tmp?$f_tmp:'').($r_tmp?$r_tmp:'').($o_tmp?$o_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/d/";
    	$a_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($s_tmp?$s_tmp:'').($t_tmp?$t_tmp:'').($stu_tmp?$stu_tmp:'').($f_tmp?$f_tmp:'').($r_tmp?$r_tmp:'').($o_tmp?$o_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/a/";
    	$s_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($t_tmp?$t_tmp:'').($stu_tmp?$stu_tmp:'').($f_tmp?$f_tmp:'').($r_tmp?$r_tmp:'').($o_tmp?$o_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/s/";
    	$t_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($s_tmp?$s_tmp:'').($stu_tmp?$stu_tmp:'').($f_tmp?$f_tmp:'').($r_tmp?$r_tmp:'').($o_tmp?$o_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/t/";
    	$stu_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($s_tmp?$s_tmp:'').($t_tmp?$t_tmp:'').($f_tmp?$f_tmp:'').($r_tmp?$r_tmp:'').($o_tmp?$o_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/stu/";
    	$f_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($s_tmp?$s_tmp:'').($t_tmp?$t_tmp:'').($stu_tmp?$stu_tmp:'').($r_tmp?$r_tmp:'').($o_tmp?$o_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/f/";
    	$r_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($s_tmp?$s_tmp:'').($t_tmp?$t_tmp:'').($stu_tmp?$stu_tmp:'').($f_tmp?$f_tmp:'').($o_tmp?$o_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/r/";
    	$o_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($s_tmp?$s_tmp:'').($t_tmp?$t_tmp:'').($stu_tmp?$stu_tmp:'').($f_tmp?$f_tmp:'').($r_tmp?$r_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/o/";
    	$or_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($s_tmp?$s_tmp:'').($t_tmp?$t_tmp:'').($stu_tmp?$stu_tmp:'').($f_tmp?$f_tmp:'').($r_tmp?$r_tmp:'').($o_tmp?$o_tmp:'').($p_tmp?$p_tmp:'')."/or/";
    	$p_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($s_tmp?$s_tmp:'').($t_tmp?$t_tmp:'').($stu_tmp?$stu_tmp:'').($f_tmp?$f_tmp:'').($r_tmp?$r_tmp:'').($o_tmp?$o_tmp:'').($or_tmp?$or_tmp:'')."/p/";
    	$p_ajax_str  = ($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($s_tmp?$s_tmp:'').($t_tmp?$t_tmp:'').($stu_tmp?$stu_tmp:'').($f_tmp?$f_tmp:'').($r_tmp?$r_tmp:'').($o_tmp?$o_tmp:'').($or_tmp?$or_tmp:'')."/p/";
    	$zh_str = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($a_tmp?$a_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'');//单选钮组合条件
    	return array('l1_url'=>$l1_str,'l2_url'=>$l2_str,'l3_url'=>$l3_str,'d_url'=>$d_str,'a_url'=>$a_str,'s_url'=>$s_str,'t_url'=>$t_str,'stu_url'=>$stu_str,'f_url'=>$f_str,'r_url'=>$r_str,'o_url'=>$o_str,'or_url'=>$or_str,'p_url'=>$p_str,'p_ajax_url'=>$p_ajax_str,'zh_url'=>$zh_str);
    }
        /**
     * 组织工种查询列表的url
     *l1-一级分类，l2-二级分类，l3-三级分类，d-区县，x-薪资结算方式，or-顺序,p-当前页码
     * @param unknown_type $data
     */
    public function makeUrl_zlg($data){
    	extract($data);
//    	var_dump($t);
//    	var_dump($t==0);
//    	var_dump(is_null($t));
    	$str = "/lista/zlg";
    	$l1&&$l1_tmp = "/l1/$l1";
    	$l2&&$l2_tmp = "/l2/$l2";
    	$l3&&$l3_tmp = "/l3/$l3";
    	$d&&$d_tmp = "/d/$d";

    	$x&&$x_tmp = "/x/$x";
    	$or&&$or_tmp = "/or/$or";
    	$p&&$p_tmp = "/p/$p";
//var_dump( $t_tmp);
    	$l1_str  = $str.($d_tmp?$d_tmp:'').($x_tmp?$x_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/l1/";
    	$l2_str  = $str.($d_tmp?$d_tmp:'').($x_tmp?$x_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/l2/";
    	$l3_str  = $str.($d_tmp?$d_tmp:'').($x_tmp?$x_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/l3/";
    	$d_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($x_tmp?$x_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/d/";
    	$x_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($or_tmp?$or_tmp:'').($p_tmp?$p_tmp:'')."/x/";
    	$or_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($x_tmp?$x_tmp:'').($p_tmp?$p_tmp:'')."/or/";
    	$p_str  = $str.($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($x_tmp?$x_tmp:'').($or_tmp?$or_tmp:'')."/p/";
    	$p_ajax_str  = ($l1_tmp?$l1_tmp:'').($l2_tmp?$l2_tmp:'').($l3_tmp?$l3_tmp:'').($d_tmp?$d_tmp:'').($x_tmp?$x_tmp:'').($or_tmp?$or_tmp:'')."/p/";
    	return array('l1_url'=>$l1_str,'l2_url'=>$l2_str,'l3_url'=>$l3_str,'d_url'=>$d_str,'x_url'=>$x_str,'or_url'=>$or_str,'p_url'=>$p_str,'p_ajax_url'=>$p_ajax_str);
    }
	/**
	 * 根据id获取零工详情
	 *
	 */
	public function getGzDetail($id){
		$this->load->model('Main_model');
		$citycode = $this->Main_model->getCityCode();
    	$city_arr = $this->Main_model->getCityInfoByCode($citycode);
		//基本信息
		$sql = "SELECT publish_list.info1,userlist.no,userlist.uid,publish_list.mobile, userlist.is_co,publish_list.address,userlist.is_real,publish_list.is_student,userlist.username,userlist.no,
				publish_list.is_for_foreign,publish_list.is_onsite_service,publish_list.info2,publish_list.info3,publish_list.info4,userlist.credit3,publish_list.job_code
				FROM `publish_list`
				inner JOIN userlist on userlist.uid=publish_list.uid
				where publish_list.id='$id' and publish_list.flag=1 and publish_list.city_id='{$city_arr['id']}'";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		//服务工种
		$sql1 = "select publish_list.id,job_type.`name`
				from publish_list 
				inner join job_type on publish_list.job_code=job_type.id and job_type.`level`=3
				where uid='{$row['uid']}' and publish_list.city_id='{$city_arr['id']}' and publish_list.flag=1";
//		echo $sql1;
		$query1 = $this->db->query($sql1);
		while ($row1 = $query1->unbuffered_row('array')) {
			$row['job_name'][$row1['id']] =$row1['name'] ;
		}
		//服务区域
		$sql2 = "select publish_list_service_district.district_id,
				(select name from district_dic where id=publish_list_service_district.district_id and level=3) as distname,
				area_id,
				(SELECT name from district_dic where id =publish_list_service_district.area_id and level=4) as areaname
				from publish_list_service_district
				where publish_list_service_district.publish_id='{$id}'";
		$query2 = $this->db->query($sql2);
		while ($row2 = $query2->unbuffered_row('array')) {
			$row['service_addr'][] =$row2;
		}
		//用户信息
		if($row['is_co']==1){//公司类型
			$sql3 = "select coname ,img,info,co_scale.code,co_scale.name from user_co left join co_scale on user_co.scale_code=co_scale.code where uid='{$row['uid']}'";
		}else{//个人类型
			$sql3 = "select nickname,realname,img,sex from user_personal where uid='{$row['uid']}'";
		}
		$query3 = $this->db->query($sql3);
		$row_user = $query3->row_array();
		//评论信息
		$sql4 = " select user_credits_log.addtime,user_credits_log.info,user_credits_log.adduid,userlist.username from user_credits_log left join userlist on userlist.uid=user_credits_log.adduid where user_credits_log.uid='{$row['uid']}' and user_credits_log.type='credit3' and user_credits_log.way_id='7' and user_credits_log.info is not null and user_credits_log.info !=''";
		$query4 = $this->db->query($sql4);
		while ($row4 = $query4->unbuffered_row('array')) {
			$row_pl[] =$row4;
		}
//		print_r($row);
		$this->row = $row;//基本信息
		$this->row_user = $row_user;//用户信息
		$this->row_pl = $row_pl;//评论信息
	}
	/**
	 * 根据招聘零工列表id获取详情
	 *
	 * @param unknown_type $id
	 */
	public function getZlgDetail($id){
		$sql = "SELECT user_co.img,user_co.weburl,user_co.info,title,job_type.name as job_type, pay, pay_unit_dic.name as unit,
				pay_circle_dic.name as circle,`sum`,worktime,invite_list.uid,
				(select name from district_dic where id=invite_list.city_id and level=2) as cityname,
				(select name from district_dic where id=invite_list.district_id and level=3) as distname,
				invite_list.address,user_co.coname,userlist.is_real,
				invite_list.contacts,invite_list.mobile,invite_list.info,invite_list.pv,invite_list.addtime
				FROM `invite_list` 
				inner JOIN userlist on userlist.uid=invite_list.uid
				inner join pay_unit_dic on pay_unit_dic.id=invite_list.pay_unit
				inner join pay_circle_dic on pay_circle_dic.id=invite_list.pay_circle
				left join user_co on userlist.uid=user_co.uid
				left join job_type on invite_list.job_code=job_type.id
				where invite_list.id='{$id}' ";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		$this->load->model('Main_model');
		$row['addtime'] = $this->Main_model->time_tran($row['addtime'],'发布');
		return $row;
	}
	/**
	 * 访问工种详情时给页面pv加1
	 *
	 * @param unknown_type $id-详情页id
	 * 成功返回true，否则返回false
	 */
	public function addGzPv($id){
		$query =$this->db->query("update publish_list set pv=pv+1 where id='$id'") ;
		if($query){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 访问招零工详情时时给页面pv加1
	 *
	 * @param unknown_type $id-详情页id
	 * 成功返回true，否则返回false
	 */
	public function addZlgPv($id){
		$query =$this->db->query("update invite_list set pv=pv+1 where id='$id'") ;
		if($query){
			return true;
		}else{
			return false;
		}
	}

	/*
	* 查询消息文件
	* @param uid 
	*
	*返回值：成功返回数据；失败返回
	* 
	 */
	public function getMessage($uid){
		$sql = "select id,title,message,addtime,flag from user_message_log where uid={$uid} and flag != -1 order by addtime desc";
		$query = $this->db->query($sql);
		$arr = $query->result_array();
		return $arr;
	}

	/*
	* 根据id获取消息文件内容
	* @param id
	* 
	 */
	public function get_row_Message($id){
		$sql = "select id,title,message,addtime,flag from user_message_log where id={$id}";
		$query = $this->db->query($sql);
		$arr = $query->result_array();
		return $arr;
	}
	
	/*
	* 点击删除根据id修改消息文件flag状态，变成回收站-1状态
	*@param id
	* 
	 */
	public function deletes($id){
		$sql = "update user_message_log set flag=-1 where id={$id}";
		$query = $this->db->query($sql);
		return $query;
	}

	/*
	* 点击标题进入内容页，修改状态为已读  flag=1
	* @param id
	* 
	 */
	public function updates($id){
		$sql = "update user_message_log set flag=1 where id={$id}";
		$query = $this->db->query($sql);
		return $query;
	}
}

