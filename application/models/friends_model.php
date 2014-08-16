<?php
class friends_model extends flubber_model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_family($memberId)
	{
		$familyInfo = $this->get_relationInfo($memberId, 1);
		return $familyInfo;
	}
	
	public function get_friends($memberId)
	{
		$friendsInfo = $this->get_relationInfo($memberId, 2);
		return $friendsInfo;
	}
	
	public function get_colleagues($memberId)
	{
		$colleagueInfo = $this->get_relationInfo($memberId, 3);
		return $colleagueInfo;
	}
	
	private function get_relationInfo($memberId, $relationTypeId)
	{
		$relationList = $this->db2->getRelated($memberId, $relationTypeId);
		$relationInfoList = array();
		
		if(is_array($relationList) && count($relationList) > 0)
		foreach($relationList as $relation):
			$memberInfo = $this->get_user($relation['relatedId']);
			array_push($relationInfoList, $memberInfo);
		endforeach;
		
		return $relationInfoList;
	}
}