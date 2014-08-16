<?php
// include "FL_Controller.php";

class admin extends FL_Controller {
	
	private $targetId;	#current ID under scrutiny
	private $admin;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->helper('form');
	}

	//todo
	//search member by name->populate entries. Group as well
	//search with list result?

	public function index()
	{
		$this->load->model('admin_model');
		
		$admin = $this->session->userdata('memberId');
		$data['currentPage'] = 'admin';
		$data['publicposts'] = $this->admin_model->getPublicContent();
		$data['requests'] = $this->admin_model->getRequests($admin); //Need to show accept button per request linked to request type
		
		$this->load->view('pages/admin_view');
	}

	//member functions
	public function addMember() 
	{
		$firstname = $this->input->post('newfirstname');
		$lastname = $this->input->post('newlastname');
		$email = $this->input->post('newemail');
		$pass = $this->input->post('newpass');
		$dob = $this->input->post('newdob');
		$status = $this->input->post('newstatus');
		$privilege = $this->input->post('newprivilege');
	
		$this->admin_model->createMember($firstname, $lastname, $email, $pass, $dob, $status, $privilege);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function editMember()
	{
		$email = $this->input->post('targetemail');
		
		$edemail = $this->input->post('editemail');
		$this->admin_model->editMemberEmail($email , $edemail);
		
		$edproff = $this->input->post('editprofession');
		$this->admin_model->editMemberProfession($email , $edproff);
		
		$edaddress = $this->input->post('editaddress');
		$edcity = $this->input->post('editcity');
		$edcountry = $this->input->post('editcountry');
		$this->admin_model->editMemberAddress($email , $edaddress , $edcity , $edcountry);
		
		$edstatus = $this->input->post('editstatus');
		$this->admin_model->editMemberStatus($email , $edstatus);
		
		$edpriv = $this->input->post('editprivilege');
		$this->admin_model->editMemberPrivilege($email , $edpriv);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function deleteMember()
	{
		$email = $this->input->post('targetemail');
		
		$this->admin_model->deleteMember($email);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	//group functions
	
	public function addGroup() 
	{
		$name = $this->input->post('newgroupname');
		$owner = $this->input->post('newowneremail');
		$description = $this->input->post('newdescription');
		$photo = $this->input->post('newphoto');
		$coverpic = $this->input->post('newcoverpic');
		$thumbnail = $this->input->post('newthumbnail');
	
		$this->admin_model->createGroup($name, $owner , $description , $photo , $coverpic , $thumbnail);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function removeGroup()
	{
		$name = $this->input->post('targetgroup');
		
		$this->admin_model->deleteGroup($name);
	}
	
	public function addGroupMember()
	{
		//REQUIRES NAME + DOB + EMAIL??
		$groupname = $this->input->post('targetgroup');
		$email = $this->input->post('groupemail');
		
		$this->admin_model->addGroupMember( $email , $groupname);
	}
	
	public function removeGroupMember()
	{
		$groupname = $this->input->post('targetgroup');
		$email = $this->input->post('groupemail');
		
		$this->admin_model->removeGroupMember( $email , $groupname);
	}
	
	//Public content functions
	public function postPublic()
	{
		$contentType = $this->input->post('contentType');
		$content = $this->input->post('content');
		$this->admin_model->postPublicContent( $admin , $contentType, $content);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function deletePublic($postId)
	{
		$this->admin_model->deletePublicContent($admin, $postId);
	}
	
	//POSN message function
	public function messageAllMembers() 
	{
		$subject = $this->input->post('subjectAll');
		$content = $this->input->post('contentAll');
		
		$this->admin_model->messagePOSN ($subject , $content , $admin);
	}
	
	//Request functions
	public function deleteRequest()
	{
		//TODO retrieve sender and msgnumber from requests
		// $this->admin_model->deleteRequest($admin, $sender , $msgnumber); 
	}
	
	public function acceptRequest()
	{
		//Button accept
		//Check requestType
		
		//Call appropriate edit function
		//Mark request as read?
	}
}