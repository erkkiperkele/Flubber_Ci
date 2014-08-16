<?php
class friends extends FL_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('friends_model');
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
		$data['title'] = 'Friends of '.$data['member']['firstName'].' '.$data['member']['lastName'];
		$data['memberRelatives'] = $this->friends_model->get_family($this->profileId);
		$data['memberFriends'] = $this->friends_model->get_friends($this->profileId);
		$data['memberColleagues'] = $this->friends_model->get_colleagues($this->profileId);
		
		$this->render('pages/friends', $data);
	}
}