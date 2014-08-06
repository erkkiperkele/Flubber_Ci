<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class search extends FL_Controller {

	function index()
	{
		$this->load->model('search_model');
		
		$user = $this->session->userdata('memberId');
		$query = $this->input->post('query');
		
		$data['result'] = $this->search_model->do_search($user, $query);
		$this->load->view('search_view', $data);
	}
}