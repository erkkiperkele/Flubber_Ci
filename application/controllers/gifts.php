<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class gifts extends FL_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('search_model');
  }

  function index()
  {       
    $user = $this->session->userdata('memberId');
    echo "<div class='modal fade'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
        <h4 class='modal-title'>Modal title</h4>
      </div>
      <div class='modal-body'>
        <p>One fine body&hellip;</p>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        <button type='button' class='btn btn-primary'>Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->";

    $this->render('search', $data);
  }
}