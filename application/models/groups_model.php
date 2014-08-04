<?php

include "DatabaseAccessObject.php";

class groups_model extends CI_Model {
	
	private $db2;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
		#REFACTOR: Call the variables from the config file instead of hardcoded
		$this->db2 = new DatabaseAccessObject('127.0.0.1', 'flubber.database', 'root', '');
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
	
	public function get_owner($groupId)
	{
		$groupInfo = $this->get_group($groupId);
		$ownerInfo = $this->get_user($groupInfo['ownerId']);
		return $ownerInfo;
	}
	
	public function get_groupMembers($groupId)
	{
		$memberList = $this->db2->getMembersOfGroup($groupId);
		$memberInfoList = array();
		
		if(is_array($memberList) && count($memberList) > 0)
		foreach($memberList as $member):
			$memberInfo = $this->get_user($member['memberId']);
			array_push($memberInfoList, $memberInfo);
		endforeach;
		
		return $memberInfoList;
	}
	
	public function get_groupPosts($groupId)
	{
		#REFACTOR: TO MOVE SOMEWHERE MORE GENERIC
		function cmp($a, $b)
		{
		    return strcmp($a["timeStamp"], $b["timeStamp"]) * (-1);	#UGLY hack to reverse order (* (-1)
		}
		
		#Get every public post information
		$groupContents = $this->db2->getGroupContents($groupId);
		$posts = $this->ExtendWithMemberDetails($groupContents, 'currentPosterId');
		usort($posts, 'cmp');
		return $posts;
	}
	
	#adds full member information to every object of the array. allows to specify the array's fieldName for the memberId
	private function ExtendWithMemberDetails($arrayToExtend, $fieldNameForMemberId = 'currentPosterId')
	{
		$extendedArray = array();
		
		#Extends each post with its member details
		if(is_array($arrayToExtend) && count($arrayToExtend) > 0)
		foreach($arrayToExtend as $content):
			$member = $this->get_user($content[$fieldNameForMemberId]);
			$contentTemp = $content;
			$extendedContent = (object) array_merge((array) $contentTemp, (array) $member);		#extends the post information with full member details
			array_push($extendedArray, (array)$extendedContent);
		endforeach;
		return $extendedArray;
	}
}