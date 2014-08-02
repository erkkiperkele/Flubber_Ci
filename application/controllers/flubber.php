<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class flubber extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('FL_UIBuildingBlocks');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('login_model');

	}
	function index()
	{
		$data = array('username' => 'Enter your Username', 'password' => '');

		$this->load->view('login_view');
	}

	function login()
	{
		$this->load->library('form_validation');

    	$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|valid_email');
    	$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_verify_pwd');

    	if($this->form_validation->run() == TRUE)
	    {	
	    	redirect('/profile/');
	    }
	    else
	    {
	      $this->load->view('login_view');
	    }

	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}

	function verify_pwd($password)
	{
		$username = $this->input->post('username');
	   	$this->load->model('login_model');
	   	if($this->login_model->doLogin($username, $password))
		{
			$userdata = array(
				'memberId' => $_SESSION['login']
			);
			
			$this->session->set_userdata( $userdata );

			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('verify_pwd', "Invalid Username or Password");
		    return FALSE;
		}

	}
}

?>

