<?php
class messages_model extends flubber_model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_messages($memberId)
	{
        $userMessageList = array();
        $messageTo = array();
        $messageFrom = array();
        
        $messageList= $this->db2->getMessagesSentToMember($memberId);
        $messageList = $this->db2->getMessagesSentFromMember($memberId);
            
        $messageTo = $this->ExtendWithMemberDetails($messageTo, 'sentFrom', 'receiver');
        $messageFrom = $this->ExtendWithMemberDetails($messageFrom, 'sentFrom', 'sender');
        
        if (!empty($messageTo))
            $messageList = array_merge($messageTo, $messageFrom);
        else
            $messageList = $messageFrom;
        
        if (!empty($messageList))
        {
            $userMessageList = $this->sortMessage($messageList);
            
        }
        
		return $userMessageList;
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
    
    private function sortMessage($messageList)
    {
        #REFACTOR: TO MOVE SOMEWHERE MORE GENERIC
		function cmp($a, $b)
		{
		    return strcmp($a["timeStamp"], $b["timeStamp"]);
		}
        function revcmp($a, $b)
		{
		    return strcmp($a["timeStamp"], $b["timeStamp"]) * (-1);	#UGLY hack to reverse order (* (-1)
		}
        
        $userMessageList = array();
        $userKey = array();
        
        if (!empty($messageList))
        {
            usort($messageList, 'revcmp');
            foreach($messageList as $message)
            {
                $targetId = 0;
                if($message['msgType'] == 'sender')
                    $targetId = $message['sentTo'];
                else if($message['msgType'] == 'receiver')
                    $targetId = $message['sentFrom'];
                $targetId = 'id'.$targetId;
                
                if(empty($userKey) || !in_array($targetId, $userKey)) 
                {
                    array_push($userKey, $targetId);
                }
            }
            
            foreach ($userKey as $key)
            {
            	$userMessageList[$key] = array();
            }
            
            usort($messageList, 'revcmp');
            foreach($messageList as $message)
            {
                $targetId = 0;
                if($message['msgType'] == 'sender')
                    $targetId = $message['sentTo'];
                else if($message['msgType'] == 'receiver')
                    $targetId = $message['sentFrom'];
                
                $target = $this->get_user($targetId);
                if (!empty($target))
                {
                    $message['targetId'] = $target['memberId'];
                    $message['targetFirstName'] = $target['firstName'];
                    $message['targetLastName'] = $target['lastName'];
                    $message['targetThumbnailURL'] = $target['thumbnailURL'];
                }
                
                $targetId = 'id'.$targetId;
                array_push($userMessageList[$targetId], $message);
            }
        }
        
		return $userMessageList;
    }
    
    public function add_message($toMemberId, $fromMemberId, $messageTitle, $messageContent)
    {
        if ($toMemberId > 0 && $fromMemberId > 0)
            $this->db2->sendMessage($toMemberId, $fromMemberId, $messageTitle, $messageContent);
    }
    
    public function delete_message($msgType, $targetId, $messageNumber)
    {
        $profileId = $this->session->userdata('memberId');
        $sendToId = 0;
        $sendFromId = 0;
        if ($msgType == 'sender')
        {
            $sendToId = $targetId;
            $sendFromId = $profileId;
            $this->db2->hideMessageFromSender($sendToId, $sendFromId, $messageNumber);
        }
        else if ($msgType == 'receiver')
        {
            $sendToId = $profileId;
            $sendFromId = $targetId;
            $this->db2->hideMessageFromReceiver($sendToId, $sendFromId, $messageNumber);
        }
        
        $msgInfo = $this->db2->getMessageInfo($sendToId, $sendFromId, $messageNumber);
        if(!empty($msgInfo) && $msgInfo['hideFromSender'] == 1 && $msgInfo['hideFromReceiver'] == 1)
            $this->db2->deleteMessage($sendToId, $sendFromId, $messageNumber);
    }
}