<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function index()
	{
		$data = array('username' => 'Enter your Username', 'password' => '');
		$this->load->helper('url');
		$this->load->helper('FL_UIBuildingBlocks');
		$this->load->helper('form');
		$this->load->view('login_view');
	}
}

?>

