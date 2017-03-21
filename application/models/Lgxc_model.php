<?php
class Lgxc_model extends CI_Model {

    public function __construct()
    {
        // 继承CI框架的父类构造方法
        parent::__construct();
        $this->load->database();
    }

    //获取零工小参标题、内容
    public function get_lgxc_content()
    {
    	$sql = "select id,title,sub_title,info from lgxc where flag=1";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }
}
