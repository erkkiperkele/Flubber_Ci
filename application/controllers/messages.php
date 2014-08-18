<?php
class messages extends FL_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('messages_model');
		$this->load->helper('form');
	}

	public function index($targetId=0, $id=0)
	{
		if($id > 0)
			$this->profileId = $id;
		
		$data['currentPage'] = 'messages';
		$data['member'] = $this->member;
		$data['groupList'] = $this->groupList;
		$data['newRequestNb'] = 0;
		$data['newMessageNb'] = 0;
		$data['title'] = 'Messages of '.$data['member']['firstName'].' '.$data['member']['lastName'];
		$data['userMessageList'] = $this->messages_model->get_messages($this->profileId);
		$data['targetId'] = $targetId;
		$data['newConversation'] = false;
        
		$this->render('pages/messages', $data);
	}
    
	public function newConversation($targetId=0, $id=0)
	{
		if($id > 0)
			$this->profileId = $id;
		
		$data['currentPage'] = 'messages';
		$data['member'] = $this->member;
		$data['groupList'] = $this->groupList;
		$data['newRequestNb'] = 0;
		$data['newMessageNb'] = 0;
		$data['title'] = 'Messages of '.$data['member']['firstName'].' '.$data['member']['lastName'];
		$data['userMessageList'] = $this->messages_model->get_messages($this->profileId);
		$data['targetId'] = $targetId;
		$data['newConversation'] = true;
		
		$this->render('pages/messages', $data);
	}
    
    public function addMessage() 
    {
		$messageTitle = $this->input->post('title');
		$messageContent = $this->input->post('messageContent');
		$fromMemberId = $this->input->post('fromMemberId');
		$toMemberId = $this->input->post('toMemberId');
		$this->messages_model->add_message($toMemberId, $fromMemberId, $messageTitle, $messageContent);
		
        redirect(CreateURL("/index.php/messages/index/".$toMemberId));
    }
    
    public function deleteMessage($msgType, $targetId, $messageNumber)
    {
        $this->messages_model->delete_message($msgType, $targetId, $messageNumber);
    }
}