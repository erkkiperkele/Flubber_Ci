<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Flubber
 *
 * 
 *
 * @package		Flubber
 * @author		Flubber Dev Team
 * @copyright	Copyright (c) 2014, COMP 5531 Group 4
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
		<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js'></script>
		<script type='text/javascript'>
			var baseURL = '" .base_url()
		."'</script>	
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
		<div id='profile-name' index='" .$member['memberId'] ."' class='jumbotron col-md-9' style='background-image:url(".$member['coverPictureURL']."); background-size: cover'>
		<h1>" .$member['firstName'] ."<small> " .$member['lastName'] ."</small></h1>
		</div>
		<div class='col-md-3'>
		<img id='profile-pic' index='" .$member['memberId'] ."' class='img-responsive pull-right' src='" .$member['photographURL'] ."' style='width:190px; height:190px'/>
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

if ( ! function_exists('AddInterest'))
{
	function AddInterest($InterestType = 'Movies')
	{
		echo "<div class='addInterest'>";
		echo 	form_open('profile/addInterest/');
						
		echo "
				<div class='input-group'>
					<input type='textarea' class='form-control' id='interestTitle' name='interestTitle'>
					<input type='textarea' class='form-control' id='interestArtist' name='interestArtist'>
					<input type='hidden' class='form-control' id='interestType' name='interestType' value='" .$InterestType ."'>
					<span class='input-group-btn'>
						<button class='btn btn-default' type='submit'>Post</button>
					</span>
				</div>
		";

		echo form_close();
		echo "</div>";
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
	<div class='panel-heading'>About "
	.$member['firstName']
	."</div>
	 <ul class='list-group'>
		<li class='list-group-item'>
		Email:
		<div id='email' class='memberEdit'>"
		.$member['email']
		."</div></li>
		<li class='list-group-item'>"
		."Profession: 
		<div id='profession' class='memberEdit'>"
		.$member['profession']
		."</div></li>
		<li class='list-group-item'>"
		."Address: 
		<div id='address' class='memberEdit'>"
		.$member['address']
		."</div></li>
		<li class='list-group-item'>"
		."City: 
		<div id='city' class='memberEdit'>"
		.$member['city']
		."</div></li>
		<li class='list-group-item'>"
		."Country: 
		<div id='country' class='memberEdit'>"
		.$member['country']
		."</div></li>
		<li class='list-group-item'>"
		."Date of birth: 
		<div>"
		.$member['dateOfBirth']
		."</div></li>
		</ul>
	</div>
	</div>
";
	}
}

// --------------------------------------------------------------------
if ( ! function_exists('PublicContentBox'))
{
	function PublicContentBox($PostInfo = "")
	{
		echo "
		<div class='publicContent panel panel-default'>
			<div class='panel-heading' style='margin: 0 0 0 0; padding: 0 0 0 0'>";
				echo "<div class='panel-body'><strong>";
				PostBody($PostInfo);
				echo "
				</strong></div>
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
			<div class='panel-heading editable' style='margin: 0 0 0 0; padding: 0 0 0 0'>";

						if($PostInfo['isEditable'])
						{
							echo
							"<button class='editbar-btn btn pull-right clearfix' style='margin:6px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit;'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>";
						}
						if ($PostInfo['isDeletable'])
						{
							echo "
							<button class='editbar-del-btn btn pull-right clearfix' style='margin:6px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit;'>
								<span class='glyphicon glyphicon-remove'></span>
							</button>
							";
						}

						echo 
								"<div class='panel-title row' style='margin-right:10px;'id='".$PostInfo['wallContentNumber']."'>";
						
						PostHeader($PostInfo);
								
						echo "</div>";

						echo "<div class='panel-body'>";

						PostBody($PostInfo);

						echo "</div>";

						AddComment($PostInfo['profileId'], $PostInfo['wallContentNumber']);

						if (isset($PostInfo['comments']))
						{
				    		CommentContent($PostInfo['comments']);
						}
						echo
						"
					</div>
					";
	}
}


// --------------------------------------------------------------------
if ( ! function_exists('PostHeader'))
{
	function PostHeader($PostInfo, $memberId = 'profileId')
	{
		echo "
			<a href='" .CreateURL("/index.php/profile/index/".$PostInfo['memberId']) ."'>
				<img class='profilePic col-md-1 col-md-offset-1' id='".$PostInfo[$memberId] ."' src='" .$PostInfo['thumbnailURL'] ."' width='26px' height='26px' style='margin:10px 10px'/>
			</a>
			<h4 class='col-md-3 text-left'>".$PostInfo['firstName'] ." <small>" .$PostInfo['lastName']." </small></h4>
			<h4 class='col-md-6 pull-right text-right small'>";
			switch($PostInfo['permissionId']){
				case 1: echo "<span class='"; 
						if($PostInfo['isEditable']) 
							echo "privacy "; 
						echo "pull-right fa fa-user'><small> Private</small></span>"; 
						break;
				case 2: echo "<span class='";
				 		if($PostInfo['isEditable'])
				 			echo "privacy ";
				 		echo "pull-right fa fa-users'><small> Public</small></span>";
				 		break;
				default: echo "<span class='";
						 if($PostInfo['isEditable'])
						 	echo "privacy ";
						 echo "pull-right fa fa-user'><small> Private</small></span>";
						 break;
			}
				echo "<small>" .$PostInfo['timeStamp'] ."</small>
			</h4>
		</div>";
	}
}

if ( ! function_exists('PostBody'))
{
	function PostBody($PostInfo)
	{
		echo "
			<input type='text' class='editbar-input form-control hide' placeholder=''>
			<div class='editText'>";
			if($PostInfo['contentType'] === 'image')
				echo "<img style='width:480px; height:640px' src='".$PostInfo['content']."'/>";
			else if($PostInfo['contentType'] === 'video')
				echo "<video width='320' height='240' controls>  
						<source src=" .$PostInfo['content'] ." type='video/mp4'>
						Your browser does not support the video tag.
					  </video>";
			else
				echo $PostInfo['content'];


		echo "</div>";
	}
}

if ( ! function_exists('AddComment'))
{
	function AddComment($PostMemberId, $PostId)
	{
		echo form_open('profile/addComment/');
						
		echo "
		<div class='input-group'>
			<input type='textarea' class='form-control' id='commentContent' name='commentContent'>
			<input type='hidden' class='form-control' id='postMemberId' name='postMemberId' value='" .$PostMemberId ."'>
			<input type='hidden' class='form-control' id='postId' name='postId' value='" .$PostId ."'>
			<span class='input-group-btn'>
				<button class='btn btn-default' type='submit'>Post</button>
			</span>
		</div>
		";

		echo form_close();
	}
}


//TO BE FINISHED WHEN COMMENTS ARE PROPERLY FETCHED
if ( ! function_exists('CommentContent'))
{
	function CommentContent($PostComments = "")
	{
		echo "<ul class='list-group'>";

		if (!empty($PostComments))
		{
			foreach ($PostComments as $comment): 

 				echo "<li class='list-group-item' style='background-color: rgb(253, 253, 253); margin:0px 0px 0px 0px;padding:5px 5px 5px 5px;'>";
 				echo 	"<row class='comment-editable'id='". $comment['commentNumber'] .">
	    			 		<a href='" .CreateURL("/index.php/profile/index/".$comment['memberId']) ."'>
								<img class='profilePic col-md-1 col-md-offset-1' id='".$comment['profileId'] ."' src='" .$comment['thumbnailURL'] ."' width='26px' height='26px' style='margin:10px 10px'/>
							</a>
				 			<button class='comment-del-btn btn pull-right clearfix' style='margin-right:6px; padding:0px 0px 0px 0px; background:inherit;'>
								<span class='glyphicon glyphicon-remove'></span>
						 	</button>
							<h5 class='text-left'>".$comment['firstName'] ." <small>" .$comment['lastName'].":</small>
								<row class='small'>"
									.$comment['content']
								."</row>
								<br/>
								<div class='pull-right text-right' style='margin-right:0px;'>
							 		<small>" .$comment['timeStamp'] ."</small>
								</div>
							</h5>
 						</row>
	    			</li>";
	    	endforeach;
		}
		echo "</ul>";
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
	function AddContentBox($profileId)
	{
		echo form_open('profile/addStatus');
		echo "
		<div id='addContentBox' class='panel panel-default'>
			<div class='input-group'>
				<input type='textarea' class='form-control' id='updatedStatus' name='updatedStatus'>
				<input type='hidden' class='form-control' id='contentType' name='contentType' value='text'>
				<input type='hidden' class='form-control' id='profileId' name='profileId' value='" .$profileId ."'>
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
	function MenuBar($memberInMenu, $groupList, $newRequestNb, $newMessageNb, $privilege)
	{
		if(!isset($memberInMenu))
		{
			$memberInMenu['firstName'] = "";
			$memberInMenu['photographURL'] = "";
		}
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
						<li class=''><a href='" .CreateURL('/') ."'>Home</a></li>
						<li class='active'><a href='" .CreateURL('index.php/profile') ."'>Profile</a></li>
						";
						if ((!is_array($groupList) || count($groupList) == 0) && $privilege > 2){
							echo "
								<li><a href='" .CreateURL('index.php/search') ."'>Groups</a></li>
								";
						}
						else {
							echo "<li class='Groups'>
								<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Groups<span class='caret'></span></a>
								<ul class='dropdown-menu' role='menu'>
								";
							if(is_array($groupList) && count($groupList) > 0) {
								foreach($groupList as $group):
									echo "
									<li><a href='" .CreateURL('index.php/groups/index/'.$group['groupId']) ."'>".$group['groupName']."</a></li>
									";
								endforeach;
							}
							if (is_array($groupList) && count($groupList) > 0 && $privilege < 3) {
								echo "
								<li class='divider'></li>
								";
							}
							if($privilege < 3){
								echo "
								<li><a href='#'>New group</a></li>
								";
							}
							echo "
								</ul>
							</li>
							";
						}
						echo "
							<li><a href='" .CreateURL('index.php/friends') ."'>Friends</a></li>
							<li><a href='" .CreateURL('index.php/requests') ."'>Requests"; if ($newRequestNb > 0) { echo " (".$newRequestNb.")"; } echo "</a></li>
							<li><a href='" .CreateURL('index.php/messages') ."'>Messages"; if ($newMessageNb > 0) { echo " (".$newMessageNb.")"; } echo "</a></li>
							";
						if($privilege==1){
							echo "<li>
									<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Admin<span class='caret'></span></a>
									<ul class='dropdown-menu' role='menu'>
										<li><a href='#'>Add New Member</a></li>
										<li><a href='#'>Change status of a Member</a></li>
										<li class='divider'></li>
										<li><a href='#'>Ran out of things to write</a></li>
									</ul>
								  </li>
							";
						}
						echo "<li class='Settings'>
							<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Settings<span class='caret'></span></a>
							<ul class='dropdown-menu' role='menu'>
								<li><a href='#'>Privacy</a></li>
								<li class='divider'></li>
								<li><a href='" .CreateURL('index.php/flubber/logout') ."'>Logout</a></li>
							</ul>
						</li>
					</ul>
					<form action='" .CreateURL('index.php/search') ."' class='navbar-form navbar-left' method='POST' role='search'>
						<div class='form-group'>
							<input type='text' name='query' class='form-control' placeholder='Search'>
						</div>
						<button type='submit' class='btn btn-default'><span class='glyphicon glyphicon-search'></span></button>
					</form>
					<div id='menu-profile' class='hide navbar-right' style='display: block; margin-right: 20px'>
						<img class='nav navbar-nav img-circle' src='". $memberInMenu['photographURL'] ."' 
							style='width: 50px; height: 50px; margin-right: 10px;'>
						<h1 class='nav navbar-nav'>" .$memberInMenu['firstName'] ."</h1>
					</div>
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
if ( ! function_exists('SearchResultMember'))
{
	function SearchResultMember($member)
	{
		echo "
		<div class='well well-sm'>";
		if($member['isBlocked']){
			echo "<a href='" .CreateURL('index.php/search/unblock/' .$member['memberId']) ."' class='pull-left btn clearfix' style='margin:0px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit;' id='unblock'><span class='glyphicon glyphicon-ok-circle' style='font-size:1.5em; color:red;'></span></a>";
		}
		else{
			echo "<a href='" .CreateURL('index.php/search/block/' .$member['memberId']) ."' class='pull-left btn clearfix' style='margin:0px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit;' id='block'><span class='glyphicon glyphicon-ban-circle' style='font-size:1.5em; color:red;'></span></a>";
		}

		echo"<a class='col-md-offset-4' href='" .CreateURL('index.php/profile/index/') .$member['memberId'] ."'
				<h1 style='font-size:large'>" .$member['firstName'] ."<small> " .$member['lastName'] ."</small></h1>
			</a>";
		if(isset($member['related']))
		{
			echo "<div class='pull-right text-left btn-group btn-group-sm'>";
			echo	"<a href='" .CreateURL('index.php/search/remove/'.$member['memberId']) ."' class='btn pull-right clearfix' style='margin:6px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit; color:#2ecc71;'id='remove'>Remove ";
					switch($member['related']){
						case 'family': 		echo "Family";	break;
						case 'friend': 		echo "Friend"; break;
						case 'colleague': 	echo "Colleague";	break;
						}
			echo 	"</a>";
			echo  "</div>";
		} 
		else if(!isset($member['related']) || $member['related'] == 0)
		{
			echo "
				<div class='pull-right text-left btn-group btn-group-sm'>
					<button type='button' class='btn pull-right clearfix dropdown-toggle' style='margin:6px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit; color:#2ecc71;' data-toggle='dropdown'>
					Add as..<span class='caret'></span>
					</button>
					<ul class='dropdown-menu' role='menu'>
						<li><a href='" .CreateURL('index.php/search/add/friend/' .$member['memberId']) ."'>Friend</a></li>
		 				<li><a href='" .CreateURL('index.php/search/add/family/' .$member['memberId']) ."'>Family</a></li>
		 				<li><a href='" .CreateURL('index.php/search/add/colleague/' .$member['memberId']) ."'>Colleague</a></li>
		    		</ul>
	    		</div>";
		}
		echo "</div>";
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
if ( ! function_exists('SearchResultGroup'))
{
	function SearchResultGroup($group)
	{
		echo "
		<div class='well well-sm'>
			<a class='col-md-offset-5 col-md-2' href='" .CreateURL('index.php/group/') .$group['groupId'] ."'
				<h1 style='font-size:large'>" .$group['groupName'] ."</h1>
			</a>
			<div class='text-left col-md-offset-3 btn-group btn-group-sm'>
				<a type='button' class='btn' style='margin:6px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit; color:#2ecc71;'";
				if($group['isJoined'])
					echo "href='".CreateURL('index.php/search/unjoin/'.$group['groupId']) ."'>UnJoin";
				else
					echo "href='".CreateURL('index.php/search/join/'.$group['groupId']) ."'>Join!";
		echo"	</a>
			</div>
		</div>";
	}
}

/////////////////////////
//Admin building blocks

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
if ( ! function_exists('AdminHeader'))
{
	function AdminHeader($member, $adminSectionTitle)
	{
		echo "
		<div id='profile-name' index='" .$member['memberId'] ."' class='jumbotron col-md-9' style='background-image:url(".$member['coverPictureURL']."); background-size: cover'>
		<h1>" . $adminSectionTitle ."<small> " ."Admin"."</small></h1>
		</div>
		<div class='col-md-3'>
		<img id='profile-pic' index='" .$member['memberId'] ."' class='img-responsive pull-right' src='" .$member['photographURL'] ."' style='width:190px; height:190px'/>
		</div>
		";
	}
}

/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	User 			contains	firstName, lastName and photographURL
 * 
 * @return	nothing
 */
if ( ! function_exists('MemberBox'))
{
	function MemberBox($MemberInfo = "")
	{
		echo "
		<div class='content panel panel-default'>
			<div class='panel-heading editable' style='margin: 0 0 0 0; padding: 0 0 0 0'>";
						echo
						"<button class='editbar-del-btnMember btn pull-right clearfix' style='margin:6px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit;'>
							<span class='glyphicon glyphicon-remove'></span>
						</button>
						";

						echo 
								"<div class='panel-title row' style='margin-right:10px;'id='".$MemberInfo['memberId']."'>
									<a href='" .CreateURL("/index.php/profile/index/".$MemberInfo['memberId']) ."'>
										<img class='profilePic col-md-1 col-md-offset-1' id='".$MemberInfo['coverPictureURL'] ."' src='" .$MemberInfo['thumbnailURL'] ."' width='26px' height='26px' style='margin:10px 10px'/>
									</a>
									<h4 class='col-md-3 text-left'>".$MemberInfo['firstName'] ." <small>" .$MemberInfo['lastName']." </small></h4>
								</div>
							</div>
						<div class='panel-body'> 
						</div>
			</div>";
			echo
			"
		</div>
		";
		
		
		
	}
}

include ('fl_profile_helper.php');
include ('fl_search_helper.php');
include ('fl_groups_helper.php');
include ('fl_friends_helper.php');
include ('fl_messages_helper.php');
include ('fl_requests_helper.php');
include ('fl_admin_helper.php');

/* End of file FL_UIBuildingBlocks_helper.php */
/* Location: ./system/helpers/FL_UIBuildingBlocks_helper.php */