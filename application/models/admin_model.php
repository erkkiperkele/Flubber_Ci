<?php
require_once APPPATH.'models/flubber_model.php';
class admin_model extends flubber_model {

	// private $db2;

	public function __construct()
	{
		parent::__construct();
		#REFACTOR: Call the variables from the config file instead of hardcoded
		// $this->db2 = new DatabaseAccessObject('127.0.0.1', 'flubber.database', 'root', '');
		// $this->db2 = new DatabaseAccessObject('localhost', 'admin', 'admin', 'admin');
	}
	
	
	//admin member functions
	
	//Returns members with their info
	public function getMemberList ()
	{
		$list = array();
		$idList = $this->db2->retrieveAllMembers();
		
		foreach ($idList as $memberid)
		{
			$list[$memberid['memberId']] = $this->db2->getMemberInfo($memberid['memberId']);
		}
		
		return $list;
	}
	
	public function getMemberID ($targetEmail)
	{
		$memberID = $this->db2->getMemberId ($targetEmail);
		return $memberID;
	}
	
	public function deleteMember($targetid)
	{
		$this->db2->removeMember($targetid);
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
		
		if( !empty($publicContents) )
		{
			#Extends each post with its member details
			foreach($publicContents as $content):
				$member = $this->get_user($content['memberId']);
				$contentTemp = $content;
				$postDetails = (object) array_merge((array) $contentTemp, (array) $member);		#extends the post information with full member details
				array_push($posts, (array)$postDetails);
			endforeach;
		}
		return $posts;
	}
	
	public function get_user($memberId)
	{
		 $userInfo = $this->db2->getMemberInfo($memberId);
		 return $userInfo;
	}
	///////////////////////////////
	
	//admin POSN public content (as a send message to all)
	
	public function getMessagesPOSN ($adminId)
	{
		//Only shows messages of yourself as admin
		$messageList = $this->db2->getMessagesSentFromMember($adminId);
		
		$finalMessageList = array();
		
		if( !empty($messageList) )
		{
		 foreach($messageList as $message)
		 {
			if($message['sentTo'] == $message['sentFrom'])
			{
				$finalMessageList[] = $message;
			}
		 }
		}
		$finalMessageList = $this->ExtendWithMemberDetails($finalMessageList, 'sentFrom');
		
		return $finalMessageList;
	}
	
	public function messagePOSN ($subject , $content , $admin) 
	{
		$members = $this->db2->retrieveAllMembers();
		foreach ($members as $member)
		{
			$this->db2->sendMessage($member['memberId'] , $admin , $subject , $content);
			//Perk: add hiding for admin conversations so it doesn't appear in messages to others
			//if($member['memberId'] == $admin)
		}
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
	
	///////////////////////////////
	//Admin group functions
	
	//Returns groups with their info
	public function getGroupList ()
	{
		$groupList = $this->db2->retrieveAllGroups();
		$finalGroupList = $this->ExtendWithGroupDetails($groupList , 'groupId');
		
		return $finalGroupList;
	}
	
	#adds full group information to every object of the array. allows to specify the array's fieldName for the groupId
	private function ExtendWithGroupDetails($arrayToExtend, $fieldNameForGroupId = 'groupId')
	{
		$extendedArray = array();
		
		#Extends each message with its member details
		foreach($arrayToExtend as $content):
			$content['GroupId'] = $fieldNameForGroupId;
			$group = $this->getGroupInfo($content[$fieldNameForGroupId]);
			$contentTemp = $content;
			$extendedContent = (object) array_merge((array) $contentTemp, (array) $group);		#extends the message information with full member details
			array_push($extendedArray, (array)$extendedContent);
		endforeach;
		return $extendedArray;
	}
	
	public function getGroupInfo ($groupId)
	{
		$groupInfo = $this->db2->getGroupInfo ($groupId);
		return $groupInfo;
	}
	
	public function deleteGroup($groupId)
	{
		$this->db2->deleteGroup($groupId);
	}
	
	
	
	///////////////////////////////
	
	//AdminReport functions
	
	//helper function. Returns key attribute => attribute count array sorted in ascendin order of keys. 
	//For attributes in MemberList only
	private function getItemList($itemKey)
	{
		$memberList = $this->getMemberList();
		$itemList = array();
		
		foreach( $memberList as $member)
		{
			//we already have this category, increment its count
			if(array_key_exists( $member[$itemKey] , $itemList ))
			{
				$itemList[ $member[$itemKey] ]= $itemList[ $member[$itemKey] ] + 1;
			}
			//add key-value to array
			else
			{
				$itemList[ $member[$itemKey] ] = 1;
			}
		}
		
		ksort($itemList);
		return $itemList;
	}
	
	//TODO
	public function getInterests()
	{
		//Need access to description of interests for non integer classification
		$idList = $this->db2->retrieveAllMembers();
		$interestList = array();
		$interestList = $this->db2->getInterestsOfMember('1');
		
		return $interestList;
	}
	
	public function getCities()
	{
		$cityList = $this->getItemList('city');
		return $cityList;
	}
	
	public function getCountries()
	{
		$countryList = $this->getItemList('country');
		return $countryList;
	}
	
	public function getProfessions()
	{
		$professionList = $this->getItemList('profession');
		return $professionList;
	}
	
	public function getAges()
	{
		$memberList = $this->getMemberList();
		$ageList = array();
		
		foreach( $memberList as $member)
		{
			//prep age difference
			date_default_timezone_set("UTC");
			$now = new DateTime();
			$birthdate = DateTime::createFromFormat('Y-m-d' ,$member['dateOfBirth']);
			$age = $now->diff($birthdate);
			$age = $age->y;
			
			//we already have this category, increment its count
			if(array_key_exists( $age , $ageList ))
			{
				$ageList[ $age ]= $ageList[ $age ] + 1;
			}
			//add key-value to array
			else
			{
				$ageList[ $age ] = 1;
			}
		}
		
		ksort($ageList);
		return $ageList;
	}
	
}