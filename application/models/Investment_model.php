<?php
class Investment_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }
	public function save($province ,$city ,$name ,$contact ,$phone ,$mailbox ,$address ,$profession){
		$sql = "insert into daili_application 
		( id,province ,city ,name ,contact ,phone ,mailbox ,address ,profession )
		value
		('".md5($name."".$contact)."',".$province.",".$city.",'".$name."','".$contact."','".$phone."','".$mailbox."','".$address."','".$profession."')";
		$this->db->query($sql);
	}
	public function findName($name,$province ,$city){
		$sql = "select id,province ,city ,name ,contact ,phone ,mailbox ,address ,profession form daili_application where name=".$name." and province=".$province ." and city=".$city;
		$result = $this->db->query($sql);
		$daili = $result->result_array();
		return $daili;
	}
}
?>