<?php

include "DatabaseAccessObject.php";

class profile_model extends CI_Model {
	
	private $db2;
	private $memberId = 1;	#dummy user (Aymeric, he!he!he! :)

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		#$this->load->helper('fl_DatabaseAccessObject');
		
		#REFACTOR: Call the variables from the config file instead of hardcoded
		$this->db2 = new DatabaseAccessObject('127.0.0.1', 'flubber.database', 'root', '');
	}
	
	public function get_publicContent()
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
	
	public function get_WallContent($memberId)
	{
		#REFACTOR: TO MOVE SOMEWHERE MORE GENERIC
		function cmp($a, $b)
		{
		    return strcmp($a["timeStamp"], $b["timeStamp"]) * (-1);	#UGLY hack to reverse order (* (-1)
		}
		
		#Get every public post information
		$wallContents = $this->db2->getWallContents($memberId);
		$posts = $this->ExtendWithMemberDetails($wallContents, 'currentPosterId');
		usort($posts, 'cmp');
		return $posts;
	}
	
	public function get_Interests($memberId)
	{
		$interestContents = $this->db2->getInterestsOfMember($memberId);
		$interestTypes = $this->GroupInterestsByType($interestContents);
		return $interestTypes;
	}
	
	private function get_InterestTypeDetails($interestTypeId)
	{
		$interestTypeDetails = $this->db2->getInterestTypeInfo($interestTypeId);
		 return $interestTypeDetails;
	}
	
	public function add_status($permissionId, $contentType, $content)
	{
		$currentPosterId = $this->memberId;
		$previousPosterId = $this->memberId;
		$originalPosterId = $this->memberId;
		$this->db2->postWallContent($this->memberId, $permissionId, $currentPosterId, $previousPosterId, $originalPosterId, $contentType, $content);
	}

	public function get_Post($wallContentNumber)
	{
		return $this->db2->getWallContentInfo($this->memberId, $wallContentNumber);
	}
	
	public function update_Post($wallContentNumber, $permissionId, $contentType, $content)
	{
		$this->delete_post($wallContentNumber);
		$this->add_status($permissionId, $contentType, $content);
	}

	public function update_PostPrivacy($wallContentNumber, $permissionId)
	{
		$post = $this->get_Post($wallContentNumber);
		$this->update_Post($wallContentNumber, $permissionId, $post['contentType'], $post['content']);
	}	

	public function delete_post($wallContentNumber)
	{
		$this->db2->deleteWallContent($this->memberId, $wallContentNumber);
	}

	public function update_MemberAddress($newAddress, $newCity, $newCountry)
	{
		$this->db2->setAddressOfMember($this->memberId, $newAddress, $newCity, $newCountry);
	}

	public function update_MemberEmail($newEmail)
	{
		$this->db2->setEmailOfMember($this->memberId, $newEmail);
	}

	public function update_MemberProfession($newProfession)
	{
		$this->db2->setProfessionOfMember($this->memberId, $newProfession);
	}

	#adds full member information to every object of the array. allows to specify the array's fieldName for the memberId
	private function ExtendWithMemberDetails($arrayToExtend, $fieldNameForMemberId = 'currentPosterId')
	{
		$extendedArray = array();
		
		#Extends each post with its member details
		foreach($arrayToExtend as $content):
			$member = $this->get_user($content[$fieldNameForMemberId]);
			$contentTemp = $content;
			$extendedContent = (object) array_merge((array) $contentTemp, (array) $member);		#extends the post information with full member details
			array_push($extendedArray, (array)$extendedContent);
		endforeach;
		return $extendedArray;
	}
	
	private function GroupInterestsByType($interests)
	{
		$extendedArray = array();
		
		#Extends each post with its member details
		foreach($interests as $content):
			$type = $this->get_InterestTypeDetails($content['interestTypeId']);
			  if (isset($extendedArray[$type['description']])) {
			     $extendedArray[$type['description']][] = $content;
			  } else {
			     $extendedArray[$type['description']] = array($content);
			  }
		endforeach;
		return $extendedArray;
	}
	
	

	
}