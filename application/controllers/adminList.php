<?php

require_once APPPATH.'core/FL_Controller.php';
class adminList extends FL_Controller {
	
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
		$data['currentPage'] = 'Repository';
		$data['memberList'] = $this->admin_model->getMemberList();
		$data['allGroupsList'] = $this->admin_model->getGroupList();
		
		//Needed for header?
		$data['title'] = "Admin" . "Lists";
		$data['member'] = $this->member;
		$data['groupList'] = $this->groupList;
		$data['newRequestNb'] = 0;
		$data['newMessageNb'] = 0;
		//end need
		
		$this->render('pages/adminList', $data);
	}

	//member functions
	
	public function deleteMember($memberId)
	{
		$this->admin_model->deleteMember($$memberId);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	//group functions
	
	public function removeGroup($groupId)
	{
		$this->admin_model->deleteGroup($groupId);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
}