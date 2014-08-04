<?php
class profile extends FL_Controller {

	private $memberId = 1;	#dummy user (Aymeric, he!he!he! :)
	private $currentMember;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('profile_model');
		$this->load->helper('form');
		$this->currentMember = $this->profile_model->get_user($this->memberId);

		
		#$this->load->helper('fl_DatabaseAccessObject');
	}

	public function index($id=0)
	{
		if($id > 0)
			$this->memberId = $id;
		
		$data['currentPage'] = 'profile';
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
		redirect('/profile/');
	}

	public function updatePost()
	{
		$permissionId = 1; #HARD CODED TEST!!! DO NOT CHECKIN!
		$contentType = 'text'; #HARD CODED TEST!!! DO NOT CHECKIN!
		$content = $this->input->post('updatedPost');
		$postId = $this->input->post('id');
		$this->profile_model->update_Post($postId, $permissionId, $contentType, $content);
	}

	public function updatePostPrivacy()
	{
		$postId = $this->input->post('postId');
		$privacy = $this->input->post('privacy');
		$permissionId = 1;		//default is private
		switch ($privacy) {
			case ' Public':
				$permissionId=2;
				break;
			default:
				$permissionId=3;	//Should never happen. If permissionId not in db, update won't work
			//TO COMPLETE once we have the drop down.
		}
		$this->profile_model->update_PostPrivacy($postId, $permissionId);
		//$this->profile_model->add_Status($permissionId, 'text', $privacy);
	}

	public function updateMemberInfo()
	{
		echo "IT IS HERE!!";
		$field = $this->input->post('field');
		$content = $this->input->post('changedInfo');
		$member = $this->currentMember;
		switch ($field) {
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
}