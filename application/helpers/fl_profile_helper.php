<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


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

if ( ! function_exists('InterestsBox'))
{
	function InterestBox($interestInfo = "", $canDelete)
	{
		echo "
		<ul class='list-group'>
			<div id='". $interestInfo['memberId'] ."'>
				<li class='list-group-item interest-editable' id='". $interestInfo['interestNumber'] ."'>"
				.$interestInfo['title'];

		if ($canDelete)
		{
		echo "
				<button class='interest-del-btn btn pull-right clearfix' style='margin:6px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit;'>
					 	<span class='glyphicon glyphicon-remove'></span>
				</button>
		";
		}

		echo "
				</p>"
				.$interestInfo['artist'];
				echo "
				</li>
			</div>
		</ul>
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
 				echo 	"<row class='comment-editable'id='". $comment['commentNumber'] ."'>
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
				<p/>
			</div>

		</div>
		";
		echo form_close();
	}
}
