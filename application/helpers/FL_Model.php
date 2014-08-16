<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include "/../models/DatabaseAccessObject.php";

/**
 * Flubber
 *
 *
 * @package		Flubber
 * @author		Flubber Dev Team
 * @copyright	Copyright (c) 2014, Flubber, Inc.
 * @license		
 * @link		
 * @since		Version 0.03
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Flubber Application Model Class
 *
 * This class object is the super class that every model in
 * Flubber will derive from.
 *
 * @package		Flubber
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Flubber Dev Team
 */
class FL_Model extends CI_Model {

	public $db2;
	public $memberId;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->memberId = $this->session->userdata('memberId');
		
		#REFACTOR: Call the variables from the config file instead of hardcoded
		$this->db2 = new DatabaseAccessObject('127.0.0.1', 'flubber', 'root', '');
	}
	
	public function get_user($memberId)
	{
		$userInfo = $this->db2->getMemberInfo($memberId);
		return $userInfo;
	}
	
	public function get_group($groupId)
	{
		$groupInfo = $this->db2->getGroupInfo($groupId);
		return $groupInfo;
	}
	
	public function get_groupList($memberId)
	{
		$groupList = $this->db2->getGroupsOfMember($memberId);
		$groupInfoList = array();
		
		if(is_array($groupList) && count($groupList) > 0)
		foreach($groupList as $group):
			$groupInfo = $this->get_group($group['groupId']);
			array_push($groupInfoList, $groupInfo);
		endforeach;
		
		return $groupInfoList;
	}
}
// END FL_Model class

/* End of file FL_Model.php */
/* Location: ./application/core/FL_Model.php */