<?php
class messages_model extends flubber_model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_messages($memberId, $targetId = -1)
	{
		#REFACTOR: TO MOVE SOMEWHERE MORE GENERIC
		function cmp($a, $b)
		{
		    return strcmp($a["timeStamp"], $b["timeStamp"]);	#UGLY hack to reverse order (* (-1)
		}
		
        $messageTo = $this->db2->getMessagesSentToMember($memberId);
        $messageTo = $this->ExtendWithMemberDetails($messageTo, 'sentFrom', 'sender');
        
        $messageFrom = $this->db2->getMessagesSentFromMember($memberId);
        $messageFrom = $this->ExtendWithMemberDetails($messageFrom, 'sentFrom', 'receiver');
        
        if (!empty($messageTo))
            $messageList = array_merge($messageTo, $messageFrom);
        else
            $messageList = $messageFrom;
        
        if (!empty($messageList))
			usort($messageList, 'cmp');
		
		return $messageList;
	}
	
	#adds full member information to every object of the array. allows to specify the array's fieldName for the memberId
	private function ExtendWithMemberDetails($arrayToExtend, $fieldNameForMemberId, $msgType)
	{
		$extendedArray = array();
		
		#Extends each message with its member details
        if (!empty($arrayToExtend))
		foreach($arrayToExtend as $content):
			$content['memberId'] = $fieldNameForMemberId;
            $content['msgType'] = $msgType;
			$member = $this->get_user($content[$fieldNameForMemberId]);
			$contentTemp = $content;
			$extendedContent = (object) array_merge((array) $contentTemp, (array) $member);		#extends the message information with full member details
			array_push($extendedArray, (array)$extendedContent);
		endforeach;
		return $extendedArray;
	}
	
}