<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class search extends FL_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('search_model');
	}

	function index()
	{				
		$user = $this->session->userdata('memberId');
		$query = $this->input->post('query');
		if(!isset($query) || empty($query))
			redirect("/profile/");
		$result = $this->search_model->do_search($user, $query);
		$data['currentPage'] = 'search';
		$data['title'] = 'Flubber - Search Results for ' .$query;
		$data['member'] = $this->member;
		$data['groupList'] = $this->groupList;
		$data['newRequestNb'] = 0;
		$data['newMessageNb'] = 0;
		//Get all the relations of the searching member
		$friends = $this->search_model->get_relations($user, "friends");
		$family = $this->search_model->get_relations($user, "family");
		$colleagues = $this->search_model->get_relations($user, "colleagues");
		//Connect all the relations of the member to the members in the search query results
		if(!empty($result))
		{
			if(!empty($friends))
				$result = $this->search_model->join_relations_with_search_members($friends, "friend", $result);
			if(!empty($family))
				$result = $this->search_model->join_relations_with_search_members($family, "family", $result);
			if(!empty($colleagues))
				$result = $this->search_model->join_relations_with_search_members($colleagues, "colleague", $result);
		}
		if(!empty($result))
			$result = $this->search_model->join_with_blocked($this->session->userdata('memberId'), $result);
		if(!empty($result))
			$result = $this->search_model->join_with_groups($this->session->userdata('memberId'), $result);
		$data['result'] = $result;

		$this->render('search', $data);
	}

	function block($blockId)
	{
		$this->search_model->doBlock($this->session->userdata('memberId'), $blockId);
		redirect('/');
	}
	function unblock($blockId)
	{
		$this->search_model->doUnblock($this->session->userdata('memberId'), $blockId);
		redirect('/profile/index/'.$blockId);	
	}
	function add($relationshipType, $personToAdd)
	{
		switch ($relationshipType) {
			case 'family': $relationshipType = 1; break;
			case 'friend': $relationshipType = 2; break;
			case 'colleague': $relationshipType = 3; break;
		}
		$this->search_model->doAddRelation($this->session->userdata('memberId'), $personToAdd, $relationshipType);
		redirect('/profile/index/'. $personToAdd);
	}
	function remove($personToRemove)
	{
		$this->search_model->doRemoveRelation($this->session->userdata('memberId'), $personToRemove);
		redirect('/');
	}
	function join($groupId)
	{
		$this->search_model->doJoinGroup($this->session->userdata('memberId'), $groupId);
		redirect('/groups/' .$groupId);
	}
	function unjoin($groupId)
	{
		$this->search_model->doUnjoinGroup($this->session->userdata('memberId'), $groupId);
		redirect('/');
	}
}