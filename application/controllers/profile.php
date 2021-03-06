<?php
class profile extends FL_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('profile_model');
		$this->load->helper('form');
	}

	public function index($id=0)
	{
		if($id > 0)
		{
			$this->profileId = $id;
		}
			
		$data['member'] = $this->profile_model->get_user($this->profileId);	//Isn't it stored on top controller?
		$data['groupList'] = $this->groupList;
		$data['newRequestNb'] = 0;
		$data['newMessageNb'] = 0;
		$data['currentPage'] = 'profile';
		$data['posts'] = $this->profile_model->get_WallContent($this->profileId);
		$data['interests'] = $this->profile_model->get_Interests($this->profileId);
		$data['interestTypes'] = $this->profile_model->get_InterestTypes($this->profileId);
		$data['title'] = $data['member']['firstName'];
		$data['profileId'] = $this->profileId;
		$data['canAddInterests'] = $this->profileId == $this->session->userdata('memberId');
		$this->render('pages/profile', $data);
	}

	public function addStatus()
	{
			$permissionId = 2; #HARD CODED TEST!!! DO NOT CHECKIN!
			$contentType = $this->input->post('contentType');
			$content = $this->input->post('updatedStatus');
			$profileId = $this->input->post('profileId');
			$this->profile_model->add_Status($permissionId, $contentType, $content, $profileId);
			redirect($_SERVER['HTTP_REFERER']);
	}

	public function addComment()
	{
		$postMemberId = $this->input->post('postMemberId');
		$wallContentNumber = $this->input->post('postId');
		$commentContent = $this->input->post('commentContent');
		$this->profile_model->add_comment($postMemberId, $wallContentNumber, $commentContent);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function updatePost()
	{
		$permissionId = 2; #HARD CODED TEST!!! DO NOT CHECKIN!
		$contentType = 'text'; #HARD CODED TEST!!! DO NOT CHECKIN!
		$content = $this->input->post('updatedPost');
		$postId = $this->input->post('id');
		$profileId = $this->input->post('profileId');
		$this->profile_model->update_Post($profileId, $postId, $permissionId, $contentType, $content);
	}

	public function updatePostPrivacy()
	{
		$postId = $this->input->post('postId');
		$privacy = $this->input->post('privacy');
		$permissionId = 1;		//default is private

		switch ($privacy) {
			case 'private':
				$permissionId=1;
				break;
			case 'public':
				$permissionId=2;
				break;
			default:
				$permissionId=3;	//Should never happen. If permissionId not in db, update won't work
			//TO COMPLETE once we have the drop down.
		}
		$this->profile_model->update_PostPrivacy($postId, $permissionId);
	}

	public function deletePost($postId)
	{
		$profileId = $this->input->post('profileId');
		$this->profile_model->delete_post($profileId, $postId);
	}

	public function deleteComment($wallContentNumber, $profileId, $commentNumber)
	{
		$this->profile_model->delete_comment($profileId, $wallContentNumber, $commentNumber);
	}
	
	public function updateMemberInfo()
	{
		$field = $this->input->post('field');
		$content = $this->input->post('changedInfo');
		$member = $this->profile_model->get_user($this->session->userdata('memberId'));
		switch ($field) 
		{
			case 'email':
				$member['email'] = $content;
				$this->profile_model->update_MemberEmail($member['email']);
				break;
			case 'profession':
				$member['profession'] = $content;
				$this->profile_model->update_MemberProfession($member['profession']);
				break;
			case 'address':
				$member['address'] = $content;
				$this->profile_model->update_MemberAddress($member['address'], $member['city'], $member['country']);
				break;
			case 'city':
				$member['city'] = $content;
				$this->profile_model->update_MemberAddress($member['address'], $member['city'], $member['country']);
				break;
			case 'country':
				$member['country'] = $content;
				$this->profile_model->update_MemberAddress($member['address'], $member['city'], $member['country']);
				break;
			default:
				#TODO!!!!!!!
				break;
		}
	}

	public function addInterest()
	{
		$interestType = $this->input->post('interestType');
		$title = $this->input->post('interestTitle');
		$artist = $this->input->post('interestArtist');
		$memberId = $this->session->userdata('memberId');

		//REFACTOR: Should get the key from form directly!
		$interestTypeId = 0;
		switch ($interestType) 
		{
			case 'Music':
				$interestTypeId = 1;
				break;
			case 'Movies':
				$interestTypeId = 2;
				break;
			case 'Books':
				$interestTypeId = 3;
				break;
			case 'Paintings':
				$interestTypeId = 4;
				break;
			default:
			//TODO!!
				break;
		}
		$this->profile_model->add_interest($memberId, $interestTypeId, $title, $artist);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function deleteInterest($memberId, $interestTypeId)
	{
		$this->profile_model->delete_interest($memberId, $interestTypeId);
	}

}