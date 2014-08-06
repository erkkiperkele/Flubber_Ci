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
}