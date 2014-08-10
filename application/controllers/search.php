<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class search extends FL_Controller {

	function index()
	{
		$this->load->model('search_model');
		
		$user = $this->session->userdata('memberId');
		$query = $this->input->post('query');
		if(!isset($query) || empty($query))
			redirect("/profile/");
		$result = $this->search_model->do_search($user, $query);
		if(!isset($result) || empty($result))
			redirect("/profile/");
		$data['currentPage'] = 'search';
		$data['title'] = 'Flubber - Search Results for ' .$query;
		$data['member'] = $this->session->all_userdata();
		//Get all the relations of the searching member
		$friends = $this->search_model->get_relations($user, "friends");
		$family = $this->search_model->get_relations($user, "family");
		$colleagues = $this->search_model->get_relations($user, "colleagues");
		//Connect all the relations of the member to the members in the search query results
		if(!empty($friends))
			$result = $this->search_model->join_relations_with_search_members($friends, "friend", $result);
		if(!empty($family))
			$result = $this->search_model->join_relations_with_search_members($family, "family", $result);
		if(!empty($colleagues))
			$result = $this->search_model->join_relations_with_search_members($colleagues, "colleague", $result);
		$data['result'] = $result;

		$this->render('search', $data);
	}
}