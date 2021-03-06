<?php
class requests_model extends flubber_model {
	
	public function __construct()
	{
		parent::__construct();
	}
    
	public function get_requests($memberId)
	{
		$requestList = $this->db2->getRequestsSentToMember($memberId);
		$requestList = $this->ExtendWithMemberDetails($requestList, 'sentFrom');
		
		return $requestList;
	}
	
	#adds full member information to every object of the array. allows to specify the array's fieldName for the memberId
	private function ExtendWithMemberDetails($arrayToExtend, $fieldNameForMemberId = 'sentFrom')
	{
		$extendedArray = array();
		
		#Extends each message with its member details
        if (!empty($arrayToExtend))
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