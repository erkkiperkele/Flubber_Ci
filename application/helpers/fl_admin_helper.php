<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	User 			contains	FirstName, LastName and photographURL
 * @param   PostContent		contains	content, TimeStamp
 * @return	nothing
 */
if ( ! function_exists('adminMessageBox'))
{
	function adminMessageBox($profileId)
	{
	echo form_open('adminMsg/messageAllMembers');
	echo "
		<div id='messagePOSNBox' class='panel panel-default'>
			<div class='input-group'>
				<input type='textarea' class='form-control' id='subjectALL' name='title'>
				<input type='hidden' class='form-control' id='contentALL' name='content' value='text'>
				<input type='hidden' class='form-control' id='profileId' name='profileId' value='" .$profileId ."'>
				<span class='input-group-btn'>
					<button class='btn btn-default' type='submit'>Post</button>
				</span>
			</div>
		</div>
		";
	echo form_close();
	}
}

if ( ! function_exists('SimpleMemberBox'))
{
	function SimpleMemberBox($MemberInfo = "")
	{
		echo "
		<div class='panel panel-default'>
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
			</div>";
			echo
			"
		</div>
		";
	}
}

if ( ! function_exists('SimpleGroupBox'))
{
	function SimpleGroupBox($GroupInfo = "")
	{
		echo "
		<div class='panel panel-default'>
			<div class='panel-heading editable' style='margin: 0 0 0 0; padding: 0 0 0 0'>";
						echo
						"<button class='editbar-del-btnMember btn pull-right clearfix' style='margin:6px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit;'>
							<span class='glyphicon glyphicon-remove'></span>
						</button>
						";

						echo 
								"<div class='panel-title row' style='margin-right:10px;'id='".$GroupInfo['groupId']."'>
									<a href='" .CreateURL("/index.php/groups/index/".$GroupInfo['groupId']) ."'>
										<img class='profilePic col-md-1 col-md-offset-1' id='".$GroupInfo['coverPictureURL'] ."' src='" .$GroupInfo['thumbnailURL'] ."' width='26px' height='26px' style='margin:10px 10px'/>
									</a>
									<h4 class='col-md-3 text-left'>".$GroupInfo['groupName'] ." <small>" ." "." </small></h4>
								</div>
							</div>
			</div>";
			echo
			"
		</div>
		";
	}
}