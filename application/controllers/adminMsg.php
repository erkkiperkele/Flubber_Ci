<?php

require_once APPPATH.'core/FL_Controller.php';
class adminMsg extends FL_Controller {
	
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
		$data['currentPage'] = 'Messages';
		$data['messageALL'] = $this->admin_model->getPublicContent();
		$data['messagePOSN'] = $this->admin_model->getMessagesPOSN($admin);
		
		//Needed for header?
		$data['title'] = "Admin" . "Messages";
		$data['member'] = $this->member;
		$data['groupList'] = $this->groupList;
		$data['newRequestNb'] = 0;
		$data['newMessageNb'] = 0;
		//end need
		
		$this->render('pages/adminMsg', $data);
	}
	
	//Public content functions
	public function postPublic()
	{
		$contentType = $this->input->post('contentType');
		$content = $this->input->post('updatedStatus');
		$adminId = $this->input->post('profileId');
		
		$this->admin_model->postPublicContent( $adminId , $contentType, $content);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function deletePublic($postId)
	{
		$this->admin_model->deletePublicContent($admin, $postId);
	}
	
	//POSN message function
	public function messageAllMembers() 
	{
		$subject = $this->input->post('title');
		$content = $this->input->post('messageContent');
		$adminId = $this->input->post('fromMemberId');
		
		$this->admin_model->messagePOSN ($subject , $content , $adminId);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
}