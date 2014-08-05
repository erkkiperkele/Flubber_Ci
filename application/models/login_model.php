<?php
Class login_model extends CI_Model
{
	private $db2;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('fl_DatabaseAccessObject');
		$this->db2 = new DatabaseAccessObject('127.0.0.1', 'flubber.database', 'root', '');
	}
	

 function doLogin($user, $pass)
 {
   return $this->db2->verifyLogin($user, $pass);
 }
 
 function get_user($memberId)
 {
	$userInfo = $this->db2->getMemberInfo($memberId);
	return $userInfo;
 }
 
}


