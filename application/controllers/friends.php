<?php
class friends extends FL_Controller {

	private $memberId = 1;	#dummy user (Aymeric, he!he!he! :)

	public function __construct()
	{
		parent::__construct();
		$this->load->model('friends_model');
	}

	public function index($id=0)
	{
		if($id > 0)
			$this->memberId = $id;
			
		$data['title'] = 'Friends';
		$data['member'] = $this->friends_model->get_user($this->memberId);
		$data['memberRelatives'] = $this->friends_model->get_family($this->memberId);
		$data['memberFriends'] = $this->friends_model->get_friends($this->memberId);
		$data['memberColleagues'] = $this->friends_model->get_colleagues($this->memberId);
		
		$this->render('pages/friends', $data);
	}
}