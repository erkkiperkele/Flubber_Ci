<?php
//<<<<<<< HEAD
require_once APPPATH.'models/flubber_model.php';
//=======
class admin_model extends flubber_model {
//>>>>>>> origin/master

	// private $db2;

	public function __construct()
	{
		parent::__construct();
		#REFACTOR: Call the variables from the config file instead of hardcoded
		// $this->db2 = new DatabaseAccessObject('127.0.0.1', 'flubber.database', 'root', '');
		// $this->db2 = new DatabaseAccessObject('localhost', 'admin', 'admin', 'admin');
	}
	
	
	//admin member functions
	
	//Returns members with their info
	public function getMemberList ()
	{
		$list = array();
		$idList = $this->db2->retrieveAllMembers();
		
		foreach ($idList as $memberid)
		{
			$list[$memberid['memberId']] = $this->db2->getMemberInfo($memberid['memberId']);
		}
		
		return $list;
	}
	
	public function getMemberID ($targetEmail)
	{
		//Not a real change
		$memberID = $this->db2->getMemberId ($targetEmail);
		return $memberID;
	}
	
	public function deleteMember($targetEmail)
	{
		$id = $this->getMemberID ($targetEmail);
		$this->db2->removeMember($id);
	}
	
	///////////////////////////////
	
	//admin public content functions
	public function postPublicContent($adminID , $contentType , $content) 
	{
		$this->db2->postPublicContent($adminID, $contentType, $content);
	}
	
	public function deletePublicContent($adminID, $publicContentNumber) 
	{
		$this->db2->deletePublicContent($adminID, $publicContentNumber);
	}
	
	//for admin viewing
	public function getPublicContent()
	{
		#Get every public post information
		$publicContents = $this->db2->getPublicContents();
		
		$posts = array();
		
		#Extends each post with its member details
		foreach($publicContents as $content):
			$member = $this->get_user($content['memberId']);
			$contentTemp = $content;
			$postDetails = (object) array_merge((array) $contentTemp, (array) $member);		#extends the post information with full member details
			array_push($posts, (array)$postDetails);
		endforeach;

		return $posts;
	}
	
	public function get_user($memberId)
	{
		 $userInfo = $this->db2->getMemberInfo($memberId);
		 return $userInfo;
	}
	///////////////////////////////
	
	//admin POSN public content (as a send message to all)
	public function messagePOSN ($subject , $content , $admin) 
	{
		$members = $this->db2->retrieveAllMembers();
		foreach ($members as $key => $member)
		{
			$this->db2->sendMessage($member , $admin , $subject , $content);
		}
	}
	
	///////////////////////////////
	//Admin group functions
	
	//Returns groups with their info
	public function getGroupList ()
	{
		$list = array();
		/* Disabled pending approval of Dao modification, returns empty list
		$idList = $this->db2->retrieveAllGroups();
		
		foreach ($idList as $groupid)
		{
			$list[$memberid['groupId']] = $this->db2->getMemberInfo($memberid['groupId']);
		}
		*/
		return $list;
	}
	
	public function getGroupID ($groupName)
	{
		$groupID = $this->db2->getGroupId ($groupName);
		return $groupID;
	}
	
	public function deleteGroup($groupName)
	{
		$groupId = $this->getGroupID ($groupName);
		$this->db2->deleteGroup($groupId);
	}
	
	///////////////////////////////
}