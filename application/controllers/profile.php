<?php
class profile extends FL_Controller {

	private $memberId = 1;	#dummy user (Aymeric, he!he!he! :)

	public function __construct()
	{
		parent::__construct();
		$this->load->model('profile_model');
		$this->load->helper('form');

		
		#$this->load->helper('fl_DatabaseAccessObject');
	}

	public function index($id=0)
	{
		if($id > 0)
			$this->memberId = $id;
		#$data['posts'] = $this->profile_model->get_publicContent();
		$data['posts'] = $this->profile_model->get_WallContent($this->memberId);
		$data['member'] = $this->profile_model->get_user($this->memberId);
		$data['interestTypes'] = $this->profile_model->get_Interests($this->memberId);
		$data['title'] = $data['member']['firstName'];
		
		$this->render('pages/profile', $data);
	}

	public function addStatus()
	{
		$permissionId = 1; #HARD CODED TEST!!! DO NOT CHECKIN!
		$contentType = 'text'; #HARD CODED TEST!!! DO NOT CHECKIN!
		$content = $this->input->post('updatedStatus');
		$this->profile_model->add_Status($permissionId, $contentType, $content);
		$this->index();
	}
}