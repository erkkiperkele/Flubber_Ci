<?php

require_once APPPATH.'core/FL_Controller.php';
class adminList extends FL_Controller {
	
	private $targetId;	#current ID under scrutiny
	private $admin;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->helper('form');
	}

	//todo
	//search member by name->populate entries. Group as well
	//search with list result?

	public function index()
	{
		
		$admin = $this->session->userdata('memberId');
		$data['currentPage'] = 'admin';
		$data['memberList'] = $this->admin_model->getMemberList();
		$data['allGroupsList'] = $this->admin_model->getGroupList();
		
		//Needed for header?
		$data['member'] = $this->member;
		$data['groupList'] = $this->groupList;
		$data['newRequestNb'] = 0;
		$data['newMessageNb'] = 0;
		//end need
		
		$this->render('pages/adminList', $data);
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
	
	//Public content functions
	public function postPublic()
	{
		$contentType = $this->input->post('contentType');
		$content = $this->input->post('content');
		$this->admin_model->postPublicContent( $admin , $contentType, $content);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function deletePublic($postId)
	{
		$this->admin_model->deletePublicContent($admin, $postId);
	}
	
	//POSN message function
	public function messageAllMembers() 
	{
		$subject = $this->input->post('subjectAll');
		$content = $this->input->post('contentAll');
		
		$this->admin_model->messagePOSN ($subject , $content , $admin);
	}
}