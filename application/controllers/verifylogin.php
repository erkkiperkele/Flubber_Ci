<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('user','',TRUE);
  }

  function index()
  {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_pw_check');

    if($this->form_validation->run() == TRUE)
    {
      redirect('home', 'refresh');
    }
    else
    {
      $this->load->view('login_view');
    }
  }

  function pw_database($password)
  {
    $username = $this->input->post('username');

    $result = $this->user->login($username, $password);

    if($result)
    {
      $sess_array = array();
      foreach($result as $row)
      {
        $member = array(
          'id' => $row->id,
          'username' => $row->username
        );
        $this->session->set_userdata('logged_in', $sess_array);
      }
      return TRUE;
    }
    else
    {
      $this->form_validation->set_message('check_database', 'Invalid username or password');
      return false;
    }
  }
}
?>
