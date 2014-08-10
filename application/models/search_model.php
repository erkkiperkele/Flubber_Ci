<?php

include "DatabaseAccessObject.php";

Class search_model extends CI_Model
{
	private $db2;

	public function __construct()
	{
		parent::__construct();
		$this->db2 = new DatabaseAccessObject('127.0.0.1', 'flubber.database', 'root', '');
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
}