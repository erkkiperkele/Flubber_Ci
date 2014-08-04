<?php
class groups extends FL_Controller {

	private $memberId = 1;	#dummy user (Aymeric, he!he!he! :)
	private $groupId = 3; #dummy group

	public function __construct()
	{
		parent::__construct();
		$this->load->model('groups_model');
	}

	public function index($id=0)
	{
		if($id > 0)
			$this->memberId = $id;
		
		$data['currentPage'] = 'groups';
		$data['member'] = $this->groups_model->get_user($this->memberId);
		$data['group'] = $this->groups_model->get_group($this->groupId);
		$data['owner'] = $this->groups_model->get_owner($this->groupId);
		$data['groupMembers'] = $this->groups_model->get_groupMembers($this->groupId);
		$data['title'] = 'Groups - '.$data['group']['groupName'];
		$data['posts'] = $this->groups_model->get_groupPosts($this->groupId);
		
		$this->render('pages/groups', $data);
	}
}