<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Flubber
 *
 *
 * @package		Flubber
 * @author		Flubber Dev Team
 * @copyright	Copyright (c) 2014, Flubber, Inc.
 * @license		
 * @link		
 * @since		Version 0.03
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Flubber Application Controller Class
 *
 * This class object is the super class that every controller in
 * Flubber will derive from.
 *
 * @package		Flubber
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Flubber Dev Team
 */
class FL_Controller extends CI_Controller {

	public $profileId;	#profile memberId being viewed.
	public $member;
	public $groupList;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();


		$this->load->helper('url');
		$this->load->helper('FL_UIBuildingBlocks');
		$this->load->model('flubber_model');
		$this->profileId = $this->session->userdata('memberId');
		$this->member = $this->flubber_model->get_user($this->profileId);
		$this->groupList = $this->flubber_model->get_groupList($this->profileId);
		
		$isLoggedIn = $this->isLogged();
		if ($isLoggedIn == false)
		{
			redirect('/flubber/logout/');
		}
	}

	/**
	 * isLogged function checks if the user is logged in before displaying content
	 */
	public function isLogged()
	{
		if($this->session->userdata('memberId') != "")
			return true;
		return false;
	}

	/**
	 * render function properly renders data including the UI code along with the headers and footer 
	 */
	public function render($viewFile, $viewData)
	{
		$viewData['memberInMenu']['firstname'] = $this->session->userdata('firstName');
		$viewData['memberInMenu']['photographURL'] = $this->session->userdata('photographURL');
		$this->load->view('templates/header_view', $viewData);		
		$this->load->view($viewFile . '_view', $viewData);
        $this->load->view('templates/footer_view');
        
	}
}
// END FL_Controller class

/* End of file FL_Controller.php */
/* Location: ./application/core/FL_Controller.php */