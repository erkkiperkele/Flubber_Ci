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
 	$id = $this->db2->getMemberId(strtolower($user['email']));
 	$info = $this->db2->getMemberInfo($id['memberId']);
 	if (strtolower($info['firstName']) == strtolower($user['name']) &&
 	    $info['dateOfBirth'] == $user['dob']) 
 		return true;
 	else
 		return $info;
 }
 function email_unique($email)
 {
 	return $this->db2->checkEmailNotDuplicate($email);
 }
}


