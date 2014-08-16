<?php
require_once APPPATH.'models/core_model.php';
class groups_model extends core_model {
	
	public function __construct()
	{
		parent::__construct();
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
		$groupContents = $this->db2->getGroupContents($memberId);
		if (!empty($groupContents))
		{
			$postsTemp = $this->ExtendWithMemberDetails($groupContents, $memberId, 'currentPosterId');
			usort($posts, 'cmp');
			return $posts;
		}
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
	
	public function get_Post($posterId, $groupContentNumber)
	{
		return $this->db2->getGroupContentInfo($posterId, $groupContentNumber);
	}
	
	public function update_Post($posterId, $groupContentNumber, $permissionId, $contentType, $content)
	{
		$previousPost = $this->get_Post($posterId, $groupContentNumber);
		if ($previousPost['currentPosterId'] == $this->memberId)
		{
			$this->delete_post($posterId, $groupContentNumber);
			$this->add_status($permissionId, $contentType, $content, $previousPost['memberId']);
		}
	}

	public function update_PostPrivacy($groupContentNumber, $permissionId)
	{
		$post = $this->get_Post($this->memberId, $groupContentNumber);
		$this->update_Post($groupContentNumber, $permissionId, $post['contentType'], $post['content']);
	}	

	public function delete_Post($posterId, $groupContentNumber)
	{

		$previousPost = $this->get_Post($posterId, $groupContentNumber);

		if ($previousPost['currentPosterId'] == $this->memberId)
		{
			$this->db2->deleteWallContent($posterId, $groupContentNumber);
		}
	}
}