<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class core extends FL_Controller {

	public $profileId;	#profile memberId being viewed.
	public $member;
	public $groupList;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core_model');
		$this->profileId = $this->session->userdata('memberId');
		$this->member = $this->core_model->get_user($this->profileId);
		$this->groupList = $this->core_model->get_groupList($this->profileId);
	}
}

?>