<?php
class profile_model extends flubber_model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_publicContent()
	{
		$publicContents = $this->db2->getPublicContents();
		return $publicContents;
	}
	
	public function get_WallContent($memberId)
	{
		#REFACTOR: TO MOVE SOMEWHERE MORE GENERIC
		function cmp($a, $b)
		{
		    return strcmp($a["timeStamp"], $b["timeStamp"]) * (-1);	#UGLY hack to reverse order (* (-1)
		}
		
		$publicContent = $this->get_publicContent();
		$wallContents = $this->db2->getWallContents($memberId);
		if (!empty($wallContents))
		{
			$postsTemp = $this->ExtendWithMemberDetails($wallContents, 'currentPosterId');
			$posts = $this->ExtendWitComments($postsTemp, 'profileId');
		}
			
		$bothContents = array();

		//Put both types of contents together, then sorts it by date.
		foreach($publicContent as $content):
			array_push($bothContents, $content);
		endforeach;
		foreach($posts as $content):
			array_push($bothContents, $content);
		endforeach;

		usort($bothContents, 'cmp');
		return $bothContents;

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

	public function add_comment($postMemberId, $wallContentNumber, $commentContent)
	{
		$this->db2->postComment($postMemberId, $wallContentNumber, $this->memberId, $commentContent);
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
		$isEditable = $this->memberId == $previousPost['currentPosterId'];
		if ($isEditable)
		{
			$post = $this->get_Post($this->memberId, $wallContentNumber);
			$this->update_Post($wallContentNumber, $permissionId, $post['contentType'], $post['content']);	
		}
	}	

	public function delete_post($profileId, $wallContentNumber)
	{

		$previousPost = $this->get_Post($profileId, $wallContentNumber);

		//TO KEEP IN SYNC WITH EXTENDWITHMEMBERDETAILS!!
		$isDeletable = ($this->memberId == $previousPost['currentPosterId'])
				|| ($this->session->userdata('privilege') == 1)
				|| ($this->memberId == $content['memberId']);
		if ($isDeletable)
		{
			$this->db2->deleteWallContent($profileId, $wallContentNumber);
		}
	}

	public function delete_comment($profileId, $wallContentNumber, $commentNumber)
	{
		$this->db2->deleteComment($profileId, $wallContentNumber, $commentNumber);
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

	public function add_interest($memberId, $interestTypeId, $title, $artist)
	{
		$this->db2->addInterest($memberId, $interestTypeId, $title, $artist);
	}

	#adds full member information to every object of the array. allows to specify the array's fieldName for the memberId
	private function ExtendWithMemberDetails($arrayToExtend, $fieldNameForMemberId = 'currentPosterId')
	{
		$extendedArray = array();
		
		#Extends each post with its member details
        if (!empty($arrayToExtend))
		foreach($arrayToExtend as $content):

			$comments = $this->get_Comments($content[$fieldNameForMemberId], $content['wallContentNumber']);
			$content['isEditable'] = 
				($this->memberId == $content[$fieldNameForMemberId])		//can only edit content originally created by the member connected
				&& (empty($comments));										//for posts not yet commented

			$content['isDeletable'] = 
				($this->memberId == $content[$fieldNameForMemberId])		//can remove your own content
				|| ($this->session->userdata('privilege') == 1)				//can remove content if admin
				|| ($this->memberId == $content['memberId']);				//can remove content on your wall

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
        if (!empty($posts))
		foreach($posts as $content):
			$comments = $this->get_Comments($content[$fieldNameForMemberId], $content['wallContentNumber']);

			if (!empty($comments))
			{
				$extendedArrayWithMember = $this->ExtendWithMemberDetails($comments, 'commenterId');
				$content['comments'] = $extendedArrayWithMember;
			}
			

			$contentTemp = $content;
			array_push($extendedArray, $contentTemp);
		endforeach;
		return $extendedArray;
	}
	
	private function GroupInterestsByType($interests)
	{
		$extendedArray = array();
		
		#Extends each post with its member details
        if (!empty($interests))
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