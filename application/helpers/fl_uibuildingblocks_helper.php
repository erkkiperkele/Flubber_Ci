<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Flubber
 *
 * 
 *
 * @package		Flubber
 * @author		Flubber Dev Team
 * @copyright	Copyright (c) 2014, COMP 5531 Group 3
 * @license		
 * @link		
 * @since		Version 0.1
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Flubber UI BuildingBlocks Helpers
 *
 * @package		Flubber
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Flubber Dev Team
 * @link		
 */

// ------------------------------------------------------------------------

/**
 * CreateURL
 *
 * Lets you simply call all the javascript files that are needed for the UI. Since all the
 * JS is called via CDNs (except our own custom.js), it shouldn't put a strain on the browser
 *
 * @access	public
 */
if ( ! function_exists('CreateURL'))
{
	function CreateURL($uri)
	{
		return base_url() .$uri; //MUST BE EDITED BASED ON APPLICATION LOCATION
	}
}

// ------------------------------------------------------------------------

/**
 * LoadJSBundle
 *
 * Lets you simply call all the javascript files that are needed for the UI. Since all the
 * JS is called via CDNs (except our own custom.js), it shouldn't put a strain on the browser
 *
 * @access	public
 */
if ( ! function_exists('LoadJSBundle'))
{
	function LoadJSBundle()
	{
		echo "	
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
		<script src='http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js'></script>
		<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
		<script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js'></script>
		<script src='" .CreateURL("assets/js/custom.js'") ."></script>		
				";
	}
}

// ------------------------------------------------------------------------

/**
 * LoadCSSBundle - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	array
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('LoadCSSBundle'))
{
	function LoadCSSBundle()
	{
		echo "
		<!-- Bootstrap Core CSS -->
		<link href='http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
		<link href='/flubberC/assets/css/carousel.css' rel='stylesheet' type='text/css'> 
		<!-- jQuery UI CSS -->
		<link rel='stylesheet' href='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css' />
		<!-- Fonts -->
		<link href='http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
		<!-- Custom Styling -->
		<link href='" .CreateURL("assets/css/custom.css'") ."rel='stylesheet' type='text/css'>
		";
	}
}

// --------------------------------------------------------------------

/**
 * Elements
 *
 * Returns only the array items specified.  Will return a default value if
 * it is not set.
 *
 * @access	public
 * @param	array
 * @param	array
 * @param	mixed
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('ProfileHeader'))
{
	function ProfileHeader($member)
	{
		echo "
		<div id='profile-name' class='jumbotron col-md-9' style='background-image:url(".$member['coverPictureURL']."); background-size: cover'>
		<h1>" .$member['firstName'] ."<small> " .$member['lastName'] ."</small></h1>
		</div>
		<div class='col-md-3'>
		<img id='profile-pic' class='img-responsive pull-right' src='" .$member['photographURL'] ."' style='width:190px; height:190px'/>
		</div>
		";
	}
}

// --------------------------------------------------------------------

/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	array
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('InterestsBox'))
{
	function InterestBox($interestInfo = "")
	{
		echo "
		<li class='list-group-item'>"
		.$interestInfo['title']
		."</p>"
		.$interestInfo['artist']
		."</li>
		";
	}
}

// --------------------------------------------------------------------

/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	array
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('memberInfoBox'))
{
	function memberInfoBox($member = "")
	{
		echo
"<div class='interests panel panel-default'>
	<div class='panel-heading'>Profile Info
	
	</div>
	 <ul class='list-group'>
		<li class='list-group-item'>
		Email:
		<div contentEditable='true'>"
		.$member['email']
		."</div></li>
		<li class='list-group-item'>"
		."Profession: 
		<div contentEditable='true'>"
		.$member['profession']
		."</div></li>
		<li class='list-group-item'>"
		."Address: 
		<div contentEditable='true'>"
		.$member['address']
		."</div></li>
		<li class='list-group-item'>"
		."City: 
		<div contentEditable='true'>"
		.$member['city']
		."</div></li>
		<li class='list-group-item'>"
		."Country: 
		<div contentEditable='true'>"
		.$member['country']
		."</div></li>
		<li class='list-group-item'>"
		."Date of birth: 
		<div contentEditable='true'>"
		.$member['dateOfBirth']
		."</div></li>
		<li class='list-group-item'>"
		."Status: 
		<div contentEditable='true'>"
		.$member['status']
		."</div></li>
		</ul>
	</div>
	</div>
";
	}
}

// --------------------------------------------------------------------

/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	User 			contains	firstName, lastName and photographURL
 * @param   PostContent		contains	content, TimeStamp
 * @return	nothing
 */
if ( ! function_exists('ContentBox'))
{
	function ContentBox($PostInfo = "")
	{
		echo "
		<div class='content panel panel-default'>
			<div class='panel-heading editable' style='margin: 0 0 0 0; padding: 0 0 0 0'>
				<div class='panel-title row'>
					<img class='col-md-1 col-md-offset-1' src='" .$PostInfo['thumbnailURL'] ."' width='26px' height='26px' style='margin:10px 10px'/>
					<h4 class='col-md-3 text-left'>".$PostInfo['firstName'] ." <small>" .$PostInfo['lastName']." </small></h4>
					<h4 class='col-md-6 pull-right text-right small privacy'><small>" .$PostInfo['timeStamp'] ."</small></h4>
				</div>
			</div>
			<div class='panel-body'> <div class='editText'>"
			.$PostInfo['content']
			."</div><div><button type='button' class='heart btn pull-right' style='background:none'><span class='glyphicon glyphicon-heart-empty'></span></button></div>
			</div>
		</div>
		";
	}
}

// --------------------------------------------------------------------

/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	User 			contains	FirstName, LastName and photographURL
 * @param   PostContent		contains	content, TimeStamp
 * @return	nothing
 */
if ( ! function_exists('AddContentBox'))
{
	function AddContentBox()
	{
		echo form_open('profile/addStatus'); #ToTest
		echo "
		<div class='panel panel-default'>
			<div class='input-group'>
				<input type='textarea' class='form-control' name='updatedStatus'>
				<span class='input-group-btn'>
					<button class='btn btn-default' type='submit'>Post</button>
				</span>
			</div>
			<div class='panel-heading privacy'>
				<h3 class='panel-title pull-left'>Status</h3>
				</p>
			</div>

		</div>
		";
		echo form_close();
	}
}

// --------------------------------------------------------------------

/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	array
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('MenuBar'))
{
	function MenuBar()
	{
		echo "
		<nav class='navbar navbar-default navbar-fixed-top' role='navigation'>
			<div class='container-fluid'>
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class='navbar-header'>
					<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#menu'>
						<span class='sr-only'>Toggle navigation</span>
						<span class='icon-bar'></span>
						<span class='icon-bar'></span>
						<span class='icon-bar'></span>
					</button>
				<a class='navbar-brand' href='#'>Flubber</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class='collapse navbar-collapse' id='menu'>
					<ul class='nav navbar-nav'>
						<li class='active'><a href='" .CreateURL('index') ."'>Home</a></li>
						<li><a href='" .CreateURL('profile') ."'>Profile</a></li>
						<li><a href='" .CreateURL('groups') ."'>Groups</a></li>
						<li><a href='" .CreateURL('friends') ."'>Friends</a></li>
						<li class='Settings'>
							<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Settings<span class='caret'></span></a>
							<ul class='dropdown-menu' role='menu'>
								<li><a href='#'>Privacy</a></li>
								<li class='divider'></li>
								<li><a href='#'>Logout</a></li>
							</ul>
						</li>
					</ul>
					<form class='navbar-form navbar-left' role='search'>
						<div class='form-group'>
							<input type='text' class='form-control' placeholder='Search'>
						</div>
						<button type='submit' class='btn btn-default'><span class='glyphicon glyphicon-search'></span></button>
					</form>
					<div id='menu-profile' class='navbar-right'></div>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
		";
	}
}

// --------------------------------------------------------------------

/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	array
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('InputBox'))
{
	function InputBox($buttonText = "Status Update")
	{
		echo "
		<!-- input-group -->
		<div class='input-group'> 
			<input type='text-area' class='form-control'>
			<span class='input-group-btn'>
				<button class='btn btn-default' type='button'>".buttonText ."</button>
			</span>
		</div><!-- /input-group -->
		";
	}
}

// --------------------------------------------------------------------

/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	array
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('GroupHeader'))
{
	function GroupHeader($firstName, $lastName, $picHref = "http://placehold.it/220x160")
	{
		echo "
		<div class='col-md-3'>
			<img id='group-pic' class='img-responsive pull-right' src='" .$picHref ."'/>
		</div>	
		<div id='group-name' class='jumbotron text-center col-md-9'>
			<h2>" .$firstName ."<small>" .$lastName ."</small></h2>
		</div>
		";
	}
}

// --------------------------------------------------------------------

/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	array
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('FriendBox'))
{
	function FriendBox($friendFirst, $friendLast, $picHref = "http://placehold.it/100x95")
	{
		echo "
		<div class='col-md-6 portfolio-item'>
			<a href='#'>
				<ul class='list-inline'>
					<li><img class='img-circle' src='" .$picHref ."'></li>
					<li>
						<ul class='list-unstyled'>
							<li><small class='nopadding'>" .$friendFirst ."Friend Person</small></li>
							<li><small class='nopadding'>" .$friendLast ."</small></li>
						</ul>
					</li>
				</ul>
			</a>
		</div>
		";
	}
}

/* End of file FL_UIBuildingBlocks_helper.php */
/* Location: ./system/helpers/FL_UIBuildingBlocks_helper.php */