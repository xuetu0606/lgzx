<?php
class Form_model extends CI_Model {


    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model('string_model');
    }
    /**
     * 添加工种
     * @param unknown_type $data
     * 参数说明：uid-uid，title-标题，job_code-工种编码，is_student-是否大学生，is_for_foreign-是否涉外，is_onsite_service-是否上门，mobile-手机号码，address-联系地址，
     *         zwjj-自我简介，fwjs-服务介绍，lxfs-联系方式，cityid-城市编码，districtid-区县编码，areaid-片区编码
     * 返回值说明：array(flag=>[1成功，-1失败]，info=>[成功返回插入的id，失败返回失败提示])
     */
    public function addGz($data){
        extract($data);
        if(!trim($title)){
            return array('flag'=>-1,'info'=>'标题为必填项，请填写完整后提交');
        }
        if(!trim($job_code)){
            return array('flag'=>-1,'info'=>'服务工种为必填项，请选择后提交');
        }
//  		if(!is_null($is_student)){
//  			return array('flag'=>-1,'info'=>'是否大学生零工为必填项，请选择后提交');
//  		}
//  		if(!is_null($is_for_foreign)){
//  			return array('flag'=>-1,'info'=>'是否涉外零工为必填项，请选择后提交');
//  		}
//  		if(!is_null($is_onsite_service)){
//  			return array('flag'=>-1,'info'=>'是否上门服务为必填项，请选择后提交');
//  		}
        if(!trim($mobile)){
            return array('flag'=>-1,'info'=>'联系电话为必填项，请填写正确后提交');
        }
        if(!trim($address)){
            return array('flag'=>-1,'info'=>'联系地址为必填项，请填写完整后提交');
        }
        $title = $this->string_model->filter($title);
        $mobile = $this->string_model->filter($mobile);
        $address = $this->string_model->filter($address);
        $zwjj = $this->string_model->filter($zwjj);
        $fwjs = $this->string_model->filter($fwjs);
        $lxfs = $this->string_model->filter($lxfs);
        $now = time();
        $this->load->model('Main_model');
        $citycode = $this->Main_model->getCityCode();
        $cityid = $this->Main_model->getCityInfoByCode($citycode);
        $sql_check = "select addtime from publish_list where uid='$uid' order by id desc limit 1 ";
        $query_check = $this->db->query($sql_check);
        $arr_check = $query_check->row_array();
        //if($arr_check&&($now-$arr_check['addtime']<60)){
        //	return array('flag'=>-1,'info'=>'您的操作过于频繁，请休息一下再操作吧~');
        //}

        $sql = "insert into publish_list
				set uid='$uid', info1='$title',job_code='$job_code',is_student='".($is_student?$is_student:0)."',is_for_foreign='".($is_for_foreign?$is_for_foreign:0)."',
				is_onsite_service='".($is_onsite_service?$is_onsite_service:0)."',mobile='$mobile',address='$address',info2='$zwjj',info3='$fwjs',info4='$lxfs',
				addtime='$now',flag=1,city_id='{$cityid['id']}',img='$img'";
        if($query = $this->db->query($sql)){
            $query_u = $this->db->query("select id from publish_list where city_id='{$cityid['id']}' and uid='$uid' order by id desc limit 1");
            $arr = $query_u->row_array();

            if($areaid){
                    foreach ($areaid as $v){
                        $sql2 = "select upid from district_dic where id='{$v}'";
                        $query2 = $this->db->query($sql2);
                        $row = $query2->row_array();

                        $sql1 = "insert into publish_list_service_district set publish_id='{$arr['id']}',district_id='{$row['upid']}',area_id='$v'";
                        //var_dump($row);
                        //echo $sql1;
                        //die();
                        if($query1 = $this->db->query($sql1)){
                            $return['flag']=1;
                            $return['info'][]=$arr['id'];
                        }else{
                            return array('flag'=>-1,'info'=>'插入信息异常，请稍后处理');
                        }
                    }

            }else{
                foreach ($districtid as $v){
                    $sql1 = "insert into publish_list_service_district set publish_id='{$arr['id']}',district_id='{$v}'";
                    if($query1 = $this->db->query($sql1)){
                        $return['flag']=1;
                        $return['info'][]=$arr['id'];
                    }else{
                        return array('flag'=>-1,'info'=>'插入信息异常，请稍后处理');
                    }
                }
            }
            return $return;

        }else{
            return array('flag'=>-1,'info'=>'插入记录异常，请稍后处理');
        }
    }
    /**
     * 快速发布工种
     * @param unknown_type $data
     * * 参数说明：uid-uid，title-标题，mobile-手机号码，cityid-城市编码，districtid-区县编码
     * 返回值说明：array(flag=>[1成功，-1失败]，info=>[成功返回插入的id，失败返回失败提示])
     */
    public function addGzQuick($data){
        extract($data);
        $this->load->model('string_model');
        if(!trim($uid)){
            return array('flag'=>-1,'info'=>'用户id未传递，请确认自动注册成功后快速发布');
        }
        if(!trim($title)){
            return array('flag'=>-1,'info'=>'标题为必填项，请填写完整后提交');
        }
        if(!trim($mobile)){
            return array('flag'=>-1,'info'=>'联系电话为必填项，请填写正确后提交');
        }
        if(!trim($cityid)){
            return array('flag'=>-1,'info'=>'城市为必选项，请选择后提交');
        }
        if(!trim($districtid)){
            return array('flag'=>-1,'info'=>'区县为必选项，请选择后提交');
        }
        $title = $this->string_model->filter($title);
        $mobile = $this->string_model->filter($mobile);
        $now = time();
        $sql_check = "select addtime from publish_list where uid='$uid' order by id desc limit 1 ";
        $query_check = $this->db->query($sql_check);
        $arr_check = $query_check->row_array();
        if($arr_check&&($now-$arr_check['addtime']<60)){
            return array('flag'=>-1,'info'=>'您的操作过于频繁，请休息一下再操作吧~');
        }
        $sql = "insert into publish_list
				set uid='$uid', info1='$title',mobile='$mobile',addtime='$now',flag=1,city_id='$cityid',quick_flag=1";
        if($query = $this->db->query($sql)){
            $query_u = $this->db->query("select id from publish_list where city_id='$cityid' and uid='$uid' order by id desc limit 1");
            $arr = $query_u->row_array();
            if($districtid){
                $sql1 = "insert into publish_list_service_district set publish_id='{$arr['id']}',district_id='{$districtid}'";
                if($query1 = $this->db->query($sql1)){
                    return array('flag'=>1,'info'=>$arr['id']);
                }else{
                    return array('flag'=>-1,'info'=>'插入信息异常，请稍后处理');
                }
            }else{
                return array('flag'=>1,'info'=>$arr['id']);
            }
        }else{
            return array('flag'=>-1,'info'=>'插入信息异常，请稍后处理~');
        }
    }
    /**
     * 根据uid查询是否有过快速发布记录
     * @param unknown_type $uid
     */
    public function checkQuickPublish($uid){
        $sql = "select id from publish_list where uid='$uid' and quick_flag=1 limit 1";
        $query = $this->db->query($sql);
        $return_arr = $query->row_array();
        if($return_arr){
            return $return_arr['id'];
        }else{
            return false;
        }

    }
    /**
     * 添加招零工
     * @param unknown_type $data
     * 参数说明：uid-uid，title-标题，job_code-工种编码，pay-工资，unit-工资单位，pay_circle-薪资结算周期，sum-招聘人数，worktime-工作时间，cityid-城市编码，districtid-区县编码
     *         mobile-手机号码，address-联系地址，contacts-联系人，info-工作内容
     * 返回值说明：array(flag=>[1成功，-1失败]，info=>[成功返回插入的id，失败返回失败提示])
     */
    public function addZlg($data){
        extract($data);
        if(!trim($title)){
            return array('flag'=>-1,'info'=>'标题为必填项，请填写完整后提交');
        }
        if(!trim($job_code)){
            return array('flag'=>-1,'info'=>'服务工种为必填项，请选择后提交');
        }
        if(!trim($pay)){
            return array('flag'=>-1,'info'=>'工资为必填项，请填写正确后提交');
        }
        if(!trim($unit)){
            return array('flag'=>-1,'info'=>'工资单位为必填项，请选择后提交');
        }
        if(!trim($pay_circle)){
            return array('flag'=>-1,'info'=>'工资结算周期为必填项，请填写后提交');
        }
        if(!trim($sum)){
            return array('flag'=>-1,'info'=>'招聘人数为必填项，请填写正确后提交');
        }
        if(!trim($mobile)){
            return array('flag'=>-1,'info'=>'联系电话为必填项，请填写正确后提交');
        }
        if(!trim($address)){
            return array('flag'=>-1,'info'=>'联系地址为必填项，请填写完整后提交');
        }
        $title = $this->string_model->filter($title);
        $worktime = $this->string_model->filter($worktime);
        $address = $this->string_model->filter($address);
        $contacts = $this->string_model->filter($contacts);
        $mobile = $this->string_model->filter($mobile);
        $info = $this->string_model->filter($info);
        $now = time();
        $sql_check = "select addtime from invite_list where uid='$uid' order by id desc limit 1 ";
        $query_check = $this->db->query($sql_check);
        $arr_check = $query_check->row_array();
        if($arr_check&&($now-$arr_check['addtime']<60)){
            return array('flag'=>-1,'info'=>'您的操作过于频繁，请休息一下再操作吧~');
        }
        $sql = "insert into invite_list
				set uid='$uid',job_code='$job_code',title='$title',city_id='$cityid',district_id='$districtid',pay='$pay',pay_unit='$unit',pay_circle='$pay_circle',
				sum='$sum',worktime='$worktime',contacts='$contacts',mobile='$mobile',address='$address',info='$info',flag=1,addtime='$now'";
        if($query = $this->db->query($sql)){
            $query_u = $this->db->query("select id from invite_list where city_id='$cityid' and uid='$uid' order by id desc limit 1");
            $arr = $query_u->row_array();
            return array('flag'=>1,'info'=>$arr['id']);
        }else{
            return array('flag'=>-1,'info'=>'插入信息异常，请稍后处理');
        }
    }
    /**
     * 获取工资单位列表
     *
     */
    public function getUnit(){
        $sql = "select id ,name from pay_unit_dic order by id ";
        $query = $this->db->query($sql);
        while($row = $query->unbuffered_row('array')){
            $arr[$row['id']] = $row['name'];
        }
        return $arr;
    }
    /**
     * 获取工资结算周期列表
     *
     */
    public function getPayCircle(){
        $sql = "select id, name from pay_circle_dic order by id ";
        $query = $this->db->query($sql);
        while($row = $query->unbuffered_row('array')){
            $arr[$row['id']] = $row['name'];
        }
        return $arr;
    }
    /**
     * 查询用户自己尚未删除的工种记录,按照刷新时间和添加时间倒序排列
     *uid用户id $start开始分页 $pagenum分页数 $del 1已发布 0未审核 -1已删除
     */
    public function getMyGZPublish($uid,$start,$pagenum,$del){
        if($pagenum){
            $addsql=" LIMIT {$start} , {$pagenum}";
        }
        $sql = "SELECT publish_list.id,(SELECT name from job_type where id=publish_list.job_code) as job_name,(SELECT pre_id from job_type where id=publish_list.job_code) as zhi_code,(SELECT name from job_type where id=zhi_code) as zhi_name,info1,img,addtime,flushtime,flag,city_id,province_city.name,province_city.pinyin FROM `publish_list`
				inner join province_city on publish_list.city_id=province_city.dist_id where uid='$uid' and flag='$del'
				order by publish_list.flushtime desc,publish_list.addtime desc 
				$addsql";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    /**
     * 查询用户自己尚未删除的招零工记录,按照刷新时间和添加时间倒序排列
     *
     */
    public function getMyZlgPublish($uid){
        $sql = "select invite_list.id,invite_list.title,invite_list.addtime,invite_list.flushtime,invite_list.flag,invite_list.city_id,province_city.name 
				from invite_list 
				inner join province_city on invite_list.city_id=province_city.dist_id 
				where uid='{$uid}' and flag<>-1
				order by invite_list.flushtime desc,invite_list.addtime desc ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    /**
     * 刷新单条工种记录
     * @param unknown_type $data
     * 参数说明 uid-uid,id-工种记录id
     * 返回值说明 true-刷新成功，false-刷新失败
     */
    public function flushGzInfo($data){
        extract($data);
        $time = time();
        $sql1 = "select addtime from publish_list where uid='$uid' and id='$id'";
        $query1 = $this->db->query($sql1);
        $row = $query1->row_array();
        if($row&&$row['addtime']&&($time-$row['addtime']<3600)){
            return array('flag'=>-1,'info'=>'您的操作过于频繁,一个小时内只能刷新一次哟~');
        }
        $sql = "update publish_list set addtime='$time' where uid='$uid' and id='$id'";
//  		echo $sql;exit;
        $query = $this->db->query($sql);
        if($query){
            return array('flag'=>1,'info'=>'');
        }else{
            return array('flag'=>-1,'info'=>'刷新失败，请稍后重试');
        }
    }
    /**
     * 刷新单条招零工记录
     * @param unknown_type $data
     * 参数说明 uid-uid,id-工种记录id
     * 返回值说明 true-刷新成功，false-刷新失败
     */
    public function flushZlgInfo($data){
        extract($data);
        $time = time();
        $sql1 = "select flushtime from invite_list where uid='$uid' and id='$id'";
        $query1 = $this->db->query($sql1);
        $row = $query1->row_array();
        if($row&&$row['flushtime']&&($time-$row['flushtime']<3600)){
            return array('flag'=>-1,'info'=>'您的操作过于频繁,一个小时内只能刷新一次哟~');
        }
        $sql = "update invite_list set flushtime='$time' where uid='$uid' and id='$id'";
        $query = $this->db->query($sql);
        if($query){
            return array('flag'=>1,'info'=>'');
        }else{
            return array('flag'=>-1,'info'=>'刷新失败，请稍后重试');
        }
    }
    /**
     * 逻辑删除单条工种记录
     * @param unknown_type $data
     * 参数说明 uid-uid,id-工种记录id
     * 返回值说明 true-删除成功，false-删除失败
     */
    public function delGzInfo($data){
        extract($data);
        $time = time();
        $sql = "update publish_list set flag=-1 where uid='$uid' and id='$id'";
        $query = $this->db->query($sql);
        if($query){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 逻辑删除单条招零工记录
     * @param unknown_type $data
     * 参数说明 uid-uid,id-招零工记录id
     * 返回值说明 true-删除成功，false-删除失败
     */
    public function delZlgInfo($data){
        extract($data);
        $time = time();
        $sql = "update invite_list set flag=-1 where uid='$uid' and id='$id'";
        $query = $this->db->query($sql);
        if($query){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 获取用户发布的工种详情
     *参数说明：uid=uid,id=工种记录id
     * 返回值说明：array('baseinfo'=>基础信息，'qy'=>服务区域)
     */
    public  function getGzDetal($data){
        extract($data);
        //获取工种发布的基础信息,包括job_level_1 行业id，job_level_2 职业id，job_level_3 工种id
        $sql = "SELECT publish_list.img,publish_list.info1,userlist.no,userlist.uid,publish_list.is_student,publish_list.is_for_foreign,publish_list.is_onsite_service,
				publish_list.mobile,publish_list.address, userlist.is_co,publish_list.info2,publish_list.info3,publish_list.info4,
				publish_list.job_code as job_level_3,job_type.pre_id as job_level_2,job_type.pre_pre_id as job_level_1
				FROM `publish_list`
				inner JOIN userlist on userlist.uid=publish_list.uid
				left join job_type on publish_list.job_code=job_type.id
				where publish_list.id='$id' and publish_list.uid='$uid' ";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
//  		echo $sql;print_r($arr);
        //获取服务区域三级id,可能匹配多项结果
        $sql1 = "select publish_list.city_id,publish_list_service_district.district_id,publish_list_service_district.area_id 
				from publish_list
				left join publish_list_service_district on publish_list.id = publish_list_service_district.publish_id
				where publish_list.id='$id' and publish_list.uid='$uid'";
        $query1 = $this->db->query($sql1);
        $result_qy = $query1->result_array();
        $this->baseinfo = $arr;
        $this->qyinfo = $result_qy;
    }
    /**
     * 获取用户发布的招零工详情
     *参数说明：uid=uid,id=招零工记录id
     * 返回值说明：array('baseinfo'=>基础信息，'qy'=>服务区域)
     */
    public  function getZlgDetal($data){
        extract($data);
        //获取工种发布的基础信息,包括job_level_1 行业id，job_level_2 职业id，job_level_3 工种id
        $sql = "SELECT invite_list.title,invite_list.job_code as job_level_3,job_type.pre_id as job_level_2,job_type.pre_pre_id as job_level_1,
				pay, invite_list.pay_unit,invite_list.pay_circle,`sum`,worktime,invite_list.uid,invite_list.city_id,invite_list.district_id,
				invite_list.address,user_co.coname,invite_list.contacts,invite_list.mobile,invite_list.info
				FROM `invite_list` 
				inner JOIN userlist on userlist.uid=invite_list.uid
				left join user_co on userlist.uid=user_co.uid
				left join job_type on invite_list.job_code=job_type.id
				where invite_list.id='$id'  and invite_list.uid='$uid' ";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
        return $arr;
    }
    /**
     * 修改工种
     * 参数说明：uid-uid，id-工种id，title-标题，job_code-工种编码，is_student-是否大学生，is_for_foreign-是否涉外，is_onsite_service-是否上门，mobile-手机号码，address-联系地址，
     *         zwjj-自我简介，fwjs-服务介绍，lxfs-联系方式，cityid-城市编码，districtid-区县编码，areaid-片区编码
     * 返回值说明：array(flag=>[1成功，-1失败]，info=>[成功返回插入的id，失败返回失败提示])
     */
    public function updateGz($data){
        extract($data);
        if(!trim($uid)){
            return array('flag'=>-1,'info'=>'没取到用户id，请稍后重试');
        }
        if(!trim($id)){
            return array('flag'=>-1,'info'=>'没取到记录id，请稍后重试');
        }
        if(!trim($title)){
            return array('flag'=>-1,'info'=>'标题为必填项，请填写完整后提交');
        }
        if(!trim($job_code)){
            return array('flag'=>-1,'info'=>'服务工种为必填项，请选择后提交');
        }
//  		if(!is_null($is_student)){
//  			return array('flag'=>-1,'info'=>'是否大学生零工为必填项，请选择后提交');
//  		}
//  		if(!is_null($is_for_foreign)){
//  			return array('flag'=>-1,'info'=>'是否涉外零工为必填项，请选择后提交');
//  		}
//  		if(!is_null($is_onsite_service)){
//  			return array('flag'=>-1,'info'=>'是否上门服务为必填项，请选择后提交');
//  		}
        if(!trim($mobile)){
            return array('flag'=>-1,'info'=>'联系电话为必填项，请填写正确后提交');
        }
        if(!trim($address)){
            return array('flag'=>-1,'info'=>'联系地址为必填项，请填写完整后提交');
        }
        $title = $this->string_model->filter($title);
        $mobile = $this->string_model->filter($mobile);
        $address = $this->string_model->filter($address);
        $zwjj = $this->string_model->filter($zwjj);
        $fwjs = $this->string_model->filter($fwjs);
        $lxfs = $this->string_model->filter($lxfs);
        $now = time();
        $this->load->model('Main_model');
        $citycode = $this->Main_model->getCityCode();
        $cityid = $this->Main_model->getCityInfoByCode($citycode);
        $sql = "update publish_list
				set uid='$uid', info1='$title',job_code='$job_code',is_student='".($is_student?$is_student:0)."',is_for_foreign='".($is_for_foreign?$is_for_foreign:0)."',
				is_onsite_service='".($is_onsite_service?$is_onsite_service:0)."',mobile='$mobile',address='$address',info2='$zwjj',info3='$fwjs',info4='$lxfs',
				updatetime='$now',flag=1,city_id='{$cityid['id']}',img='{$img}' where id='$id'";

        if($query = $this->db->query($sql)){


            if($districtid||$areaid){
                $sql2 = "delete from publish_list_service_district where publish_id='$id'";
                $query2 = $this->db->query($sql2);
                if($query2){
                    if($areaid){
                        foreach ($areaid as $v){
                            $sql3 = "select upid from district_dic where id='{$v}'";
                            $query3 = $this->db->query($sql3);
                            $row = $query3->row_array();

                            $sql1 = "insert into publish_list_service_district set publish_id='{$id}',district_id='{$row['upid']}',area_id='$v'";
                            //var_dump($row);
                            //echo $sql1;
                            //die();
                            if($query1 = $this->db->query($sql1)){
                                $return['flag']=1;
                                $return['info'][]=$query1['id'];
                            }else{
                                return array('flag'=>-1,'info'=>'插入信息异常，请稍后处理');
                            }
                        }

                    }else{
                        foreach ($districtid as $v){
                            $sql1 = "insert into publish_list_service_district set publish_id='{$id}',district_id='{$v}'";
                            if($query1 = $this->db->query($sql1)){
                                $return['flag']=1;
                                $return['info'][]=$query1['id'];
                            }else{
                                return array('flag'=>-1,'info'=>'插入信息异常，请稍后处理');
                            }
                        }
                    }
                    return $return;
                }

            }else{
                return array('flag'=>1,'info'=>$uid['id']);
            }




        }else{
            return array('flag'=>-1,'info'=>'插入信息异常，请稍后处理');
        }

    }
    /**
     * 修改招零工详情
     * 参数说明：uid-uid，id-招零工id，title-标题，job_code-工种编码，pay-工资，unit-工资单位，pay_circle-薪资结算周期，sum-招聘人数，worktime-工作时间，cityid-城市编码，districtid-区县编码
     *         mobile-手机号码，address-联系地址，contacts-联系人，info-工作内容
     * 返回值说明：array(flag=>[1成功，-1失败]，info=>[成功返回插入的id，失败返回失败提示])
     * @param unknown_type $data
     */
    public function updateZlg($data){
        extract($data);
        if(!trim($uid)){
            return array('flag'=>-1,'info'=>'没取到用户id，请稍后重试');
        }
        if(!trim($id)){
            return array('flag'=>-1,'info'=>'没取到记录id，请稍后重试');
        }
        if(!trim($title)){
            return array('flag'=>-1,'info'=>'标题为必填项，请填写完整后提交');
        }
        if(!trim($job_code)){
            return array('flag'=>-1,'info'=>'服务工种为必填项，请选择后提交');
        }
        if(!trim($pay)){
            return array('flag'=>-1,'info'=>'工资为必填项，请填写正确后提交');
        }
        if(!trim($unit)){
            return array('flag'=>-1,'info'=>'工资单位为必填项，请选择后提交');
        }
        if(!trim($pay_circle)){
            return array('flag'=>-1,'info'=>'工资结算周期为必填项，请填写后提交');
        }
        if(!trim($sum)){
            return array('flag'=>-1,'info'=>'招聘人数为必填项，请填写正确后提交');
        }
        if(!trim($mobile)){
            return array('flag'=>-1,'info'=>'联系电话为必填项，请填写正确后提交');
        }
        if(!trim($address)){
            return array('flag'=>-1,'info'=>'联系地址为必填项，请填写完整后提交');
        }
        $title = $this->string_model->filter($title);
        $worktime = $this->string_model->filter($worktime);
        $address = $this->string_model->filter($address);
        $contacts = $this->string_model->filter($contacts);
        $mobile = $this->string_model->filter($mobile);
        $info = $this->string_model->filter($info);
        $now = time();
        $sql = "update invite_list
				set uid='$uid',job_code='$job_code',title='$title',city_id='$cityid',district_id='$districtid',pay='$pay',pay_unit='$unit',pay_circle='$pay_circle',
				sum='$sum',worktime='$worktime',contacts='$contacts',mobile='$mobile',address='$address',info='$info',flag=1,updatetime='$now' where id='$id'";
        if($query = $this->db->query($sql)){
            return array('flag'=>1,'info'=>$id);
        }else{
            return array('flag'=>-1,'info'=>'插入信息异常，请稍后处理');
        }
    }
    /**
     * 检查是否已签约推广,不分城市
     * 返回值:arr不存在则未提交过签约推广记录，arr[flag]==1则审核通过。arr[flag]==0则等待审核
     */
    public function checkIsPro($uid){
        $sql = "select id,flag from user_promotion_log where uid='$uid' and ( flag!=-1 or flag is null )";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
//  		echo $sql;
//  		print_r($arr);exit;
        return $arr;
    }
    /**
     * 添加签约推广记录
     *参数说明： uid-uid,name-用户姓名，idno-身份证，qq-qq，wechat-微信，info-留言
     */
    public function addPromotion($data){
        extract($data);
        $this->load->model('Main_model');
        $citycode = $this->Main_model->getCityCode();
//    	$cityid = $this->Main_model->getCityInfoByCode($citycode);
        $time = time();
        $sql = "insert into user_promotion_log SET uid='$uid',city_py='$citycode',name='$name',idno='$idno',qq='$qq',wechat='$wechat',info='$info',addtime='$time'";
        $query = $this->db->query($sql);
        if($query){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 根据uid获取推荐人所推荐的用户的注册和购买服务信息
     *
     * @param unknown_type $uid
     * @return unknown
     */
    public function getPromotionList($uid){
        $sql1 = "select username from userlist where uid='$uid'";
        $query1 = $this->db->query($sql1);
        $user = $query1->row_array();

        $sql = "select userlist.uid,username,userlist.`no`,userlist.addtime as useraddtime,vip_service_dic.`name`,user_service_log.addtime as serviceaddtime 
				from userlist
				left join user_service_log on userlist.uid=user_service_log.uid
				left join vip_service_dic on vip_service_dic.id=user_service_log.vip_id
				and user_service_log.addtime
				where promotion_flag=1 and referrer='{$user['username']}'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}