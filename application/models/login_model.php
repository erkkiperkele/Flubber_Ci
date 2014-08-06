<?php

include "DatabaseAccessObject.php";

Class login_model extends CI_Model
{
	private $db2;

	public function __construct()
	{
		parent::__construct();
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

 function register_user($first, $last, $email, $pass, $dob)
 {
 	return $this->db2->addMember($first,$last,$email, $pass, "", "", "", "", "", "", "", $dob, 1);
 }

 function user_exists($user)
 {
 	return true;
 	//return $this->db2->CHECKIFUSEREXISTS($user['name'],$user['dob'],$user['email']);
 }
}


