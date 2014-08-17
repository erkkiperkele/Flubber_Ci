<?php
class groups extends FL_Controller {

	public $groupId;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('groups_model');
		$this->load->helper('form');
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
	
	public function addGroupPost()
	{
		$permissionId = 1; #HARD CODED TEST!!! DO NOT CHECKIN!
		$contentType = $this->input->post('contentType');
		$content = $this->input->post('updatedPost');
		$groupId = $this->input->post('groupId');
		$this->groups_model->add_groupPost($groupId, $permissionId, $contentType, $content);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function updateGroupPost()
	{
		$permissionId = 1; #HARD CODED TEST!!! DO NOT CHECKIN!
		$contentType = 'text'; #HARD CODED TEST!!! DO NOT CHECKIN!
		$content = $this->input->post('updatedPost');
		$postId = $this->input->post('id');
		$groupId = $this->input->post('groupId');
		$this->groups_model->update_groupPost($groupId, $postId, $permissionId, $contentType, $content);
	}

	public function updateGroupPostPrivacy()
	{
		$postId = $this->input->post('postId');
		$privacy = $this->input->post('privacy');
		$groupId = $this->input->post('groupId');
		$permissionId = 1;		//default is private
		switch ($privacy) {
			case 'public':
				$permissionId=2;
				break;
			default:
				$permissionId=3;	//Should never happen. If permissionId not in db, update won't work
			//TO COMPLETE once we have the drop down.
		}
		$this->groups_model->update_groupPostPrivacy($groupId, $postId, $permissionId);
	}

	public function deleteGroupPost($postId)
	{
		$groupId = $this->input->post('groupId');
		$this->groups_model->delete_groupPost($groupId, $postId);
	}
	
	public function updateGroupInfo()
	{
		$field = $this->input->post('field');
		$content = $this->input->post('changedInfo');
		$group = $this->groups_model->get_group($groupId);
		switch ($field) {
			case 'description':
				$group['description'] = $content;
				$this->groups_model->update_groupDescription($group['description']);
				break;
			default:
				#TODO!!!!!!!
				break;
		}
	}
}