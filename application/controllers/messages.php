<?php
require_once APPPATH.'controllers/core.php';
class messages extends core {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('messages_model');
	}

	public function index($id=0)
	{
		if($id > 0)
			$this->profileId = $id;
		
		$data['currentPage'] = 'friends';
		$data['member'] = $this->member;
		$data['groupList'] = $this->groupList;
		$data['newRequestNb'] = 0;
		$data['newMessageNb'] = 0;
		$data['title'] = 'Messages of '.$data['member']['firstName'].' '.$data['member']['lastName'];
		$data['userMessageList'] = $this->messages_model->get_messages($this->profileId);
		
		$this->render('pages/messages', $data);
	}
}