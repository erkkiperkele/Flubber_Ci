<?php
class requests extends FL_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('requests_model');
	}

	public function index($id=0)
	{
		if($id > 0)
			$this->profileId = $id;
		
		$data['currentPage'] = 'requests';
		$data['member'] = $this->member;
		$data['groupList'] = $this->groupList;
		$data['newRequestNb'] = 0;
		$data['newMessageNb'] = 0;
		$data['title'] = 'Requests of '.$data['member']['firstName'].' '.$data['member']['lastName'];
		$data['userRequestList'] = $this->requests_model->get_requests($this->profileId);
				
		$this->render('pages/requests', $data);
	}
}

class requestsType {
    
    const GEN_REPLY = 'GenReply';
    const GRP_JOIN = 'GrpJoin';
    const GRP_INVITE = 'GrpInvite';
    const REL_FRIEND = 'RelFriend';
    const REL_FAMILY = 'RelFamily';
    const REL_COLLEAGUE = 'RelColleague';
    const USR_UPGRADE = 'UsrUpgrade';    
}