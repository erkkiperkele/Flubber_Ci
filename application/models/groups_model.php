<?php
require_once APPPATH.'models/flubber_model.php';
class groups_model extends flubber_model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
    public function get_blankGroup($ownerId){
        $group = array();
        $group['groupId'] = -1;
        $group['groupName'] = 'Create a group';
        $group['description'] = '';
        $group['ownerId'] = $ownerId;
        $group['photographURL'] = '';
        $group['coverPictureURL'] = '';
        $group['thumbnailURL'] = '';
        return $group;
    }
    
	public function update_groupDescription($groupId, $newDescription)
	{
		$this->db2->setDescriptionOfGroup($groupId, $newDescription);
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
    
	public function add_group($privilegeId, $name, $ownerId, $description)
	{
        if($privilegeId < 3)
        {
            $success = $this->db2->createGroup($name, $ownerId, $description, null, null, null);
            $groupList = $this->db2->getGroupId($name);
            $groupInfo = array();
            if(!empty($groupList))
                return $groupList[count($groupList) - 1];
        }
        return 0;
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
		if (!empty($groupContents))
		{
			$postsTemp = $this->ExtendWithMemberDetails($groupContents, $this->memberId, 'currentPosterId');
			usort($postsTemp, 'cmp');
			return $postsTemp;
		}
		return $groupContents;
	}
	
	#adds full member information to every object of the array. allows to specify the array's fieldName for the memberId
	private function ExtendWithMemberDetails($arrayToExtend, $currentMemberId, $fieldNameForMemberId = 'currentPosterId')
	{
		$extendedArray = array();
		
		#Extends each post with its member details
        if (!empty($arrayToExtend))
		foreach($arrayToExtend as $content):
			$content['isEditable'] = 
				($this->memberId == $content[$fieldNameForMemberId]);		//can only edit content originally created by the member connected

			$content['isDeletable'] = 
				($this->memberId == $content[$fieldNameForMemberId])		//can remove your own content
				|| ($this->session->userdata('privilege') == 1)				//can remove content if admin
				|| ($this->memberId == $content['memberId']);				//can remove content on your wall

			$postedBy = $this->get_user($content[$fieldNameForMemberId]);
			$contentTemp = $content;
			$extendedContent = (object) array_merge((array) $contentTemp, (array) $postedBy);		#extends the post information with full member details
			array_push($extendedArray, (array)$extendedContent);
		endforeach;
		return $extendedArray;
	}
	
	public function add_groupPost($groupId, $permissionId, $contentType, $content)
	{
		$currentPosterId = $this->memberId;
		$previousPosterId = null;
		$originalPosterId = $this->memberId;
		$this->db2->postGroupContent($groupId, $permissionId, $currentPosterId, $previousPosterId, $originalPosterId, $contentType, $content);
	}

	public function delete_groupPost($groupId, $groupContentNumber)
	{
		$previousPost = $this->get_groupPost($groupId, $groupContentNumber);
		
		//TO KEEP IN SYNC WITH EXTENDWITHMEMBERDETAILS!!
		$isDeletable = ($this->memberId == $previousPost['currentPosterId'])
				|| ($this->session->userdata('privilege') == 1);
		if ($isDeletable)
		{
			$this->db2->deleteGroupContent($groupId, $groupContentNumber);
		}
	}

	public function get_groupPost($groupId, $groupContentNumber)
	{
		return $this->db2->getGroupContentInfo($groupId, $groupContentNumber);
	}
	
	public function update_groupPost($groupId, $groupContentNumber, $permissionId, $contentType, $content)
	{
		$previousPost = $this->get_groupPost($groupId, $groupContentNumber);
		if ($previousPost['currentPosterId'] == $this->memberId)
		{
            $this->delete_groupPost($groupId, $groupContentNumber);
			$this->add_groupPost($groupId, $permissionId, $contentType, $content);
		}
	}

	public function update_groupPostPrivacy($groupId, $groupContentNumber, $permissionId)
	{
		$isEditable = $this->memberId == $previousPost['currentPosterId'];
		if ($isEditable)
		{
			$post = $this->get_groupPost($groupId, $groupContentNumber);
			$this->update_groupPost($groupId, $groupContentNumber, $permissionId, $post['contentType'], $post['content']);	
		}
	}
}