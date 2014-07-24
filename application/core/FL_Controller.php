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

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$isLoggedIn = $this->isLogged();
		if ($isLoggedIn == false)
		{
			show_404();
		}
	}

	/**
	 * isLogged function checks if the user is logged in before displaying content
	 */
	public function isLogged()
	{
		return true;
	}

	/**
	 * render function properly renders data including the UI code along with the headers and footer 
	 */
	public function render($viewFile, $viewData)
	{
		$this->load->helper('FL_UIBuildingBlocks');
		$this->load->view('templates/header_view', $viewData);		
		$this->load->view($viewFile . '_view', $viewData);
        $this->load->view('templates/footer_view');
        
	}
}
// END FL_Controller class

/* End of file FL_Controller.php */
/* Location: ./application/core/FL_Controller.php */