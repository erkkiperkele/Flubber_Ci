<?php

require_once APPPATH.'core/FL_Controller.php';
class adminReport extends FL_Controller {
	
	private $admin;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->helper('form');
	}

	public function index()
	{
		
		$admin = $this->session->userdata('memberId');
		$data['currentPage'] = 'admin';
		//Report Lists as (Type => String , Count => int)
		$data['interestList'] = $this->admin_model->getInterests(); 
		$data['ageList'] = $this->admin_model->getAges();
		$data['cityList'] = $this->admin_model->getCities();
		$data['countryList'] = $this->admin_model->getCountries();
		$data['professionList'] = $this->admin_model->getProfessions();
		
		//Needed for header?
		$data['member'] = $this->member;
		$data['groupList'] = $this->groupList;
		$data['newRequestNb'] = 0;
		$data['newMessageNb'] = 0;
		//end need
		
		$this->render('pages/adminReport', $data);
	}

	//member functions
	
	public function deleteMember()
	{
		$email = $this->input->post('targetid');
		
		$this->admin_model->deleteMember($email);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	//group functions
	
	public function removeGroup()
	{
		$name = $this->input->post('targetgroup');
		
		$this->admin_model->deleteGroup($name);
	}
	
}