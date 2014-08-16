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
	
	public function updateGroupPost()
	{
		$permissionId = 1; #HARD CODED TEST!!! DO NOT CHECKIN!
		$contentType = 'text'; #HARD CODED TEST!!! DO NOT CHECKIN!
		$content = $this->input->post('updatedPost');
		$postId = $this->input->post('id');
		$this->groups_model->update_groupPost($this->groupId, $postId, $permissionId, $contentType, $content);
	}

	public function updateGroupPostPrivacy()
	{
		$postId = $this->input->post('postId');
		$privacy = $this->input->post('privacy');
		$permissionId = 1;		//default is private
		switch ($privacy) {
			case 'public':
				$permissionId=2;
				break;
			default:
				$permissionId=3;	//Should never happen. If permissionId not in db, update won't work
			//TO COMPLETE once we have the drop down.
		}
		$this->groups_model->update_groupPostPrivacy($this->groupId, $postId, $permissionId);
	}

	public function deleteGroupPost($postId)
	{
		$profileId = $this->input->post('memberId');
		$this->groups_model->delete_groupPost($this->groupId, $profileId, $postId);
	}
}