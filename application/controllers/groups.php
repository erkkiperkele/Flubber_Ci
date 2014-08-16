<?php
class groups extends FL_Controller {

	private $groupId;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('groups_model');
	}

	public function index($id=0, $id2=0)
	{
		if($id > 0)
			$this->groupId = $id;
		
		if($id2 > 0)
			$this->profileId = $id2;
		
		$data['currentPage'] = 'groups';
		$data['member'] = $this->member;
		$data['groupList'] = $this->groupList;
		$data['newRequestNb'] = 0;
		$data['newMessageNb'] = 0;
		$data['group'] = $this->groups_model->get_group($this->groupId);
		$data['owner'] = $this->groups_model->get_owner($this->groupId);
		$data['groupMembers'] = $this->groups_model->get_groupMembers($this->groupId);
		$data['title'] = 'Groups - '.$data['group']['groupName'];
		$data['groupPosts'] = $this->groups_model->get_groupPosts($this->groupId);
		
		$this->render('pages/groups', $data);
	}
}