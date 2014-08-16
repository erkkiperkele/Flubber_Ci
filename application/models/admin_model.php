<?php
class admin_model extends flubber_model {
	
	// private $db2;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
		#REFACTOR: Call the variables from the config file instead of hardcoded
		// $this->db2 = new DatabaseAccessObject('127.0.0.1', 'flubber.database', 'root', '');
		// $this->db2 = new DatabaseAccessObject('localhost', 'admin', 'admin', 'admin');
	}
	
	
	//admin member functions
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
	
	public function createMember($firstName,$lastName,$email, $password, $dob, $status = 'active', $privilege = 'junior')
	{
		$this->db2->addMember($firstName,$lastName,$email,$password,"","","","","","","",$dateOfBirth,$privacy);
		$targetID = $this->db2->getMemberId($email) ;
		
		$this->editMemberStatus($targetID , $status);
		$this->editMemberPrivilege($targetID , $privilege);
	}
	
	public function editMemberStatus($targetEmail, $newStatus) 
	{
		$id = $this->getMemberID ($targetEmail);
		$this->db2->setStatusOfMember($id, $newStatus);
	}

	public function editMemberPrivilege($targetEmail, $newPrivilege)
	{
		$id = $this->getMemberID ($targetEmail);
		$this->db2->setPrivilegeOfMember($id, $newPrivilege);
	}
	
	public function editMemberAddress($targetEmail , $newAddress, $newCity, $newCountry)
	{
		$id = $this->getMemberID ($targetEmail);
		$this->db2->setAddressOfMember($id, $newAddress, $newCity, $newCountry);
	}

	public function editMemberEmail($targetEmail , $newEmail)
	{
		$id = $this->getMemberID ($targetEmail);
		$this->db2->setEmailOfMember($id, $newEmail);
	}

	public function editMemberProfession($targetEmail , $newProfession)
	{
		$id = $this->getMemberID ($targetEmail);
		$this->db2->setProfessionOfMember($id, $newProfession);
	}
	
	function searchMember($memberID)
	{
		//array indexed by column
		return $this->db2->getMemberInfo($memberID);
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
	
	public function getGroupID ($groupName)
	{
		$groupID = $this->db2->getGroupId ($groupName);
		return $groupID;
	}
	
	public function createGroup($groupName, $ownerEmail , $description , $photo , $coverPic , $thumbnail)
	{
		$ownerID = $this->getMemberID ($ownerEmail);
		
		$this->db2->createGroup($groupName, $ownerID, $description , $photo , $coverPic , $thumbnail);
	}
	
	public function deleteGroup($groupName)
	{
		$groupId = $this->getGroupID ($groupName);
		$this->db2->deleteGroup($groupId);
	}
	
	public function addGroupMember( $memberEmail , $groupName)
	{
		$groupId = $this->getGroupID ($groupName);
		$memberId = $this->getMemberID ($memberEmail);
		
		$this->db2->addMemberOfGroup ( $memberId , $groupId);
	}
	
	public function removeGroupMember( $memberEmail , $groupName)
	{
		$groupId = $this->getGroupID ($groupName);
		$memberId = $this->getMemberID ($memberEmail);
		
		$this->db2->removeMemberOfGroup ( $memberId , $groupId);
	}
	///////////////////////////////
	//Admin requests 
	
	public function getRequests ($admin)
	{
		$requests = $this->db2->getRequestsSentToMember ($admin);
	}
	
	public function deleteRequest ($admin , $sender , $msgnumber)
	{
		$this->db2->deleteRequest($admin , $sender , $msgnumber);
	}
	
	//mark request read?
}