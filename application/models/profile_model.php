<?php

include "DatabaseAccessObject.php";

class profile_model extends CI_Model {
	
	private $db2;
	private $memberId;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->memberId = $this->session->userdata('memberId');
		
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
		if (!empty($wallContents))
		{
			$postsTemp = $this->ExtendWithMemberDetails($wallContents, $memberId, 'currentPosterId');
		
		
			$posts = $this->ExtendWitComments($postsTemp, 'currentPosterId');
			usort($posts, 'cmp');
			return $posts;
		}
	}
	
	public function get_Interests($memberId)
	{
		$interestContents = $this->db2->getInterestsOfMember($memberId);
		if (!empty($interestContents))
		{
			$interestTypes = $this->GroupInterestsByType($interestContents);
			return $interestTypes;
		}
	}
	
	private function get_InterestTypeDetails($interestTypeId)
	{
		$interestTypeDetails = $this->db2->getInterestTypeInfo($interestTypeId);
		 return $interestTypeDetails;
	}
	
	public function add_status($permissionId, $contentType, $content, $profileId)
	{
		$currentPosterId = $this->memberId;
		$previousPosterId = null;
		$originalPosterId = $this->memberId;
		$this->db2->postWallContent($profileId, $permissionId, $currentPosterId, $previousPosterId, $originalPosterId, $contentType, $content);
	}

	public function add_comment($profileId, $wallContentNumber, $commentContent)
	{
		$this->db2->postComment($profileId, $wallContentNumber, $this->memberId, $commentContent);
	}

	//NOT TESTED!
	public function get_Comments($memberId, $wallContentNumber)
	{
		return $this->db2->getComments($memberId, $wallContentNumber);
	}

	public function get_Post($profileId, $wallContentNumber)
	{
		return $this->db2->getWallContentInfo($profileId, $wallContentNumber);
	}
	
	public function update_Post($profileId, $wallContentNumber, $permissionId, $contentType, $content)
	{
		$previousPost = $this->get_Post($profileId, $wallContentNumber);
		if ($previousPost['currentPosterId'] == $this->memberId)
		{
			$this->delete_post($profileId, $wallContentNumber);
			$this->add_status($permissionId, $contentType, $content, $previousPost['memberId']);
		}
	}

	public function update_PostPrivacy($wallContentNumber, $permissionId)
	{
		$post = $this->get_Post($this->memberId, $wallContentNumber);
		$this->update_Post($wallContentNumber, $permissionId, $post['contentType'], $post['content']);
	}	

	public function delete_post($profileId, $wallContentNumber)
	{

		$previousPost = $this->get_Post($profileId, $wallContentNumber);

		if ($previousPost['currentPosterId'] == $this->memberId)
		{
			$this->db2->deleteWallContent($profileId, $wallContentNumber);
		}
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
	private function ExtendWithMemberDetails($arrayToExtend, $currentMemberId, $fieldNameForMemberId = 'currentPosterId')
	{
		$extendedArray = array();
		
		#Extends each post with its member details
		foreach($arrayToExtend as $content):
			$content['isEditable'] = $this->memberId == $content['currentPosterId'];		//can only edit content originally created by the member connected
			$content['profileId'] = $content['memberId'];		//memberId copied because it gets overwritten by member's table memberId
			$member = $this->get_user($content[$fieldNameForMemberId]);
			$contentTemp = $content;
			$extendedContent = (object) array_merge((array) $contentTemp, (array) $member);		#extends the post information with full member details
			array_push($extendedArray, (array)$extendedContent);
		endforeach;
		return $extendedArray;
	}

	private function ExtendWitComments($posts, $fieldNameForMemberId = 'currentPosterId')
	{
		$extendedArray = array();
		foreach($posts as $content):
			$content['comments'] = $this->get_Comments($content[$fieldNameForMemberId], $content['wallContentNumber']);
			$contentTemp = $content;
			array_push($extendedArray, $contentTemp);
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