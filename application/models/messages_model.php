<?php
require_once APPPATH.'models/core_model.php';
class messages_model extends core_model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_messages($memberId)
	{
		$messageList = $this->db2->getMessagesSentToMember($memberId);
		$messageList = $this->ExtendWithMemberDetails($messageList, 'sentFrom');
		
		return $messageList;
	}
	
	#adds full member information to every object of the array. allows to specify the array's fieldName for the memberId
	private function ExtendWithMemberDetails($arrayToExtend, $fieldNameForMemberId = 'sentFrom')
	{
		$extendedArray = array();
		
		#Extends each message with its member details
		foreach($arrayToExtend as $content):
			$content['memberId'] = $fieldNameForMemberId;
			$member = $this->get_user($content[$fieldNameForMemberId]);
			$contentTemp = $content;
			$extendedContent = (object) array_merge((array) $contentTemp, (array) $member);		#extends the message information with full member details
			array_push($extendedArray, (array)$extendedContent);
		endforeach;
		return $extendedArray;
	}
	
}