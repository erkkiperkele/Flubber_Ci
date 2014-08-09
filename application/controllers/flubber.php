<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class flubber extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('FL_UIBuildingBlocks');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('login_model');
		$this->load->library('form_validation');

	}
	function index()
	{
		$data['doLogin'] = FALSE;
		$data['doRegister'] = FALSE;
		$this->load->view('login_view');
	}

	function login()
	{
    	$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|valid_email|');
    	$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_verify_pwd|callback_verify_notsuspended');

    	if($this->form_validation->run() == TRUE)
	    {	
	    	redirect('/profile/');
	    }
	    else
	    {
	    	$data['doLogin'] = TRUE;
	    	$data['doRegister'] = FALSE;
	      	$this->load->view('login_view', $data);
	    }

	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}

	function register()
	{
		$this->form_validation->set_rules('username', "User's name", 'trim|required|xss_clean');
    	$this->form_validation->set_rules('userdob', 'Date of Birth of User', 'trim|required|xss_clean|');
    	$this->form_validation->set_rules('useremail', "User's Email", 'trim|required|xss_clean|valid_email|callback_verify_user');
    	$this->form_validation->set_rules('newfirstname', 'Firstname', 'trim|required|xss_clean');
    	$this->form_validation->set_rules('newlastname', 'Lastname', 'trim|required|xss_clean');
    	$this->form_validation->set_rules('newdob', 'Date Of Birth', 'trim|required|xss_clean|');
    	$this->form_validation->set_rules('newemail', 'Email', 'trim|required|xss_clean|valid_email|callback_verify_email_is_unique');
    	$this->form_validation->set_rules('newpassword', 'Password', 'trim|required|xss_clean');

    	if($this->form_validation->run() == TRUE)
	    {	
	    	$first = $this->input->post('newfirstname');
	    	$last = $this->input->post('newlastname');
	    	$dob = $this->input->post('newdob');
	    	$email = $this->input->post('newemail');
	    	$pass = $this->input->post('newpassword');
	    	$this->login_model->register_user($first, $last, $email, $pass, $dob);
			$this->login_model->doLogin($email, $pass);	
	    	$userdata = $this->login_model->get_user($_SESSION['login']);
			$this->session->set_userdata( $userdata );
    		redirect('/profile/');
	    }
	    else
	    {
	    	$data['doRegister'] = TRUE;
	    	$data['doLogin'] = FALSE;
	      	$this->load->view('login_view', $data);
	    }
	}

	function verify_pwd($password)
	{
		$username = $this->input->post('username');
	   	if($this->login_model->doLogin($username, $password))
		{
			$userdata = $this->login_model->get_user($_SESSION['login']);

			$this->session->set_userdata( $userdata );

			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('verify_pwd', "Invalid Username or Password");
		    return FALSE;
		}
	}

	function verify_notsuspended($password)
	{
		if($this->session->userdata('status') === 3)
		{
			$this->form_validation->set_message('verify_notsuspended', "You have been suspended. Please contact the admin!");
		}
		else
		{
			return TRUE;
		}
		return FALSE;
	}
	function verify_user($useremail)
	{
		$user['name'] = $this->input->post('username');
		$user['dob'] = $this->input->post('userdob');
		$user['email'] = $useremail;
		if($this->login_model->user_exists($user) === TRUE)
			return TRUE;
		else
			$this->form_validation->set_message('verify_user', 'There is no user with this info! Please try again.');
		return FALSE;
	}
	function verify_email_is_unique($registrantEmail)
	{
		if($this->login_model->email_unique($registrantEmail))
			return TRUE;
		else
			$this->form_validation->set_message('verify_email_is_unique', 'This email is already registered in our system. If you have forgotten your password, please contact the administrator.');
		return FALSE;
	}
}