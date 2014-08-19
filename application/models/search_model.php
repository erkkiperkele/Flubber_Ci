<?php
Class search_model extends flubber_model
{

	public function __construct()
	{
		parent::__construct();
	}
	

 function do_search($user, $query)
 {
   return $this->db2->searchString($user, $query);
 }
 function get_relations($user, $relationship)
 {
 	switch($relationship){
	 	case "friends": return $this->db2->getRelated($user, 2);
	 	case "family": return $this->db2->getRelated($user, 1);
	 	case "colleagues": return $this->db2->getRelated($user, 3);
	 	default: return;
 	}
 }
 function join_relations_with_search_members($relations, $relationship, $searchResults)
 {
 	$results = array();
 	$relate = 0;
 	foreach ($relations as $relation) {
 		$i = 0;
 		foreach ($searchResults[0] as $resultingMember) {
	 		if($resultingMember['memberId'] == $relation['relatedId'] && strtolower($relation['description']) == $relationship)
	 		{
	 			$resultingMember['related'] = $relationship;
	 		}
	 		$results[$i++] = $resultingMember;
 		}
 	}
 	$searchResults[0] = $results;
 	return $searchResults;
 }
 function join_with_blocked($me, $searchResults)
 {
 	$results = array();
 	$i = 0;
 	foreach ($searchResults[0] as $searchMember) {
 		$resultingMember = $searchMember;
 		$resultingMember['isBlocked'] = $this->db2->checkBlocked($me, $searchMember['memberId']);
 		$results[$i++] = $resultingMember;
 	}
 	$searchResults[0] = $results;
 	return $searchResults;
 }

 function join_with_groups($me, $searchResults)
 {
 	$results = array();
 	$myGroups = $this->db2->getGroupsOfMember($me);
 	$i = 0;
 	foreach ($searchResults[1] as $searchGroup) {
 		$resultingGroup = $searchGroup;
 		$resultingGroup['isJoined'] = false;
 		if(!empty($myGroups)){
	 		foreach ($myGroups as $group) {
	 			if($group['groupId'] === $resultingGroup['groupId'])
	 			{
	 				$resultingGroup['isJoined'] = true;
	 				break;
	 			}
	 		}
 		}
 		$results[$i++] = $resultingGroup;
 	}
 	$searchResults[1] = $results;
 	return $searchResults;
 }
 function join_with_member_privileges($myPrivilege, $searchResults)
 {
	$results = array();
 	$i = 0;
 	foreach ($searchResults[0] as $searchMember) {
 		$resultingPerson = $searchMember;
 		if($myPrivilege == "1")
 		{
			$PersonSearched = $this->db2->getMemberInfo($searchMember['memberId']);
	 		$resultingPerson['privilege'] = $PersonSearched['privilege'];
 		} 
 		else
 		{
 			$resultingPerson['privilege'] = 0;
 		}
 		$results[$i++] = $resultingPerson;
 	}
 	$searchResults[0] = $results;
 	return $searchResults; 	
 }

 function doBlock($me, $personToBlock)
 {
 	return $this->db2->blockMember($me, $personToBlock);
 }
 
 function doUnblock($me, $personToUnBlock)
 {
 	return $this->db2->unblockMember($me, $personToUnBlock);
 }
 
 function doAddRelation($me, $personToAdd, $relationshipType)
 {
 	return $this->db2->addRelation($me, $personToAdd, $relationshipType);
 }
 
 function doRemoveRelation($me, $personToRemove)
 {
 	return $this->db2->removeRelation($me, $personToRemove);
 }
 
 function doJoinGroup($me, $groupId)
 {
 	return $this->db2->addMemberOfGroup($me, $groupId);
 }

 function doUnjoinGroup($me, $groupId)
 {
 	return $this->db2->removeMemberOfGroup($me, $groupId);
 }
 function giveHeart($me, $to)
 {
 	$this->db2->updateHearts($me, 1);
 	$this->db2->updateHearts($to, -1);
 }
 function getGifts()
 {
 	return $this->db2->getGiftTypes();
 }
 function getGiftInfo($giftId)
 {
 	return $this->db2->getGiftTypeInfo($giftId);
 }
 function checkIfGiftAffordable($me, $giftCost)
 {
 	return $this->db2->checkHearts($me, $giftCost);
 }

 function giveAGift($me, $to, $gift)
 {
	$this->db2->updateHearts($me, $gift['cost']);
	$content = "<b>You recieved a gift: </b>" .$gift['description'];
	$this->db2->postWallContent($to, 2, $me, null, $me, "text", $content);
 }
 function upgradeToSenior($memberToUpgrade)
 {
 	$this->db2->setPrivilegeOfMember($memberToUpgrade, 2);
 }
}