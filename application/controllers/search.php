<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class search extends FL_Controller {

	function index()
	{
		$this->load->model('search_model');
		
		$user = $this->session->userdata('memberId');
		$query = $this->input->post('query');
		if(!isset($query) || $query == "")
			redirect("/profile/");
		$data['result'] = $this->search_model->do_search($user, $query);
		$data['currentPage'] = 'search';
		$data['title'] = 'Flubber - Search Results for ' .$query;
		$data['member'] = $this->session->all_userdata();
		$this->render('search', $data);
	}
}