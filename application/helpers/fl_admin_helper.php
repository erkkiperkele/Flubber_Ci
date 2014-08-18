<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Random Element - Takes an array as input and returns a random element
*
* @access	public
* @param	User 			contains	FirstName, LastName and photographURL
* @param   PostContent		contains	content, TimeStamp
* @return	nothing
*/
if ( ! function_exists('AdminMessageBox'))
{
    function AdminMessageContent($fromMemberId, $previousTitle = '')
    {
        if ($previousTitle <> '')
            $previousTitle = '';
        echo form_open('adminMsg/messageAllMembers');
        echo "
            <div id='AddUserMessageContent' class='panel panel-default'>
	            <div class='input-group'>
                    <input type='text' class='form-control' name='title' id='title' style='border:0px; width: 100%;'
                        value='".$previousTitle."' placeholder='Your title here' />
		            <textarea id='messageContent' class='form-control' name='messageContent' 
                        placeholder='Your message here' rows='3'></textarea> 
		            <input type='hidden' class='form-control' id='fromMemberId' name='fromMemberId' value='" .$fromMemberId ."'>
		            <input type='hidden' class='form-control' id='toMemberId' name='toMemberId' value='" . '' ."'>
		            <span class='input-group-btn' style='vertical-align:bottom;'>
			            <button class='btn btn-default' type='submit'>Send</button>
		            </span>
	            </div>
            </div>
            ";
        echo form_close();
    }
}
//-------------------------

if ( ! function_exists('SimpleMemberBox'))
{
	function SimpleMemberBox($MemberInfo = "")
	{
		echo "
		<div class='panel panel-default'>
			<div class='panel-heading membereditable' id='".$MemberInfo['memberId']."' style='margin: 0 0 0 0; padding: 0 0 0 0'>";
				
						echo "
							<button class='member-del-btn btn pull-right clearfix' style='margin:6px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit;'>
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
			<div class='panel-heading groupiseditable' id='".$GroupInfo['groupId']."'style='margin: 0 0 0 0; padding: 0 0 0 0'>";
						echo
						"<button class='group-del-btn btn pull-right clearfix' style='margin:6px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit;'>
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

/**
* Random Element - Takes an array as input and returns a random element
*
* @access	public
* @param	User 			contains	FirstName, LastName and photographURL
* @param   PostContent		contains	content, TimeStamp
* @return	nothing
*/
if ( ! function_exists('AdminMessageBox'))
{
	function AdminMessageBox($PostInfo = "")
	{
	echo "
		<div class='message panel panel-default'>
			<div class='panel-heading editable' style='margin: 0 0 0 0; padding: 0 0 0 0'>";
						echo 
								"<div class='panel-title row' style='margin-right:10px;'id='".$PostInfo['messageNumber']."'>
									<a href='" .CreateURL("/index.php/profile/index/".$PostInfo['memberId']) ."'>
										<img class='profilePic col-md-1 col-md-offset-1' id='".$PostInfo['memberId'] ."' src='" .$PostInfo['thumbnailURL'] ."' width='26px' height='26px' style='margin:10px 10px'/>
									</a>
									<h4 class='col-md-3 text-left'>".$PostInfo['firstName'] ." <small>" .$PostInfo['lastName']." </small></h4>
									<h4 class='col-md-3 text-left'>".$PostInfo['title']."</h4>
									<h4 class='col-md-6 pull-right text-right small'>";
										echo "<small>" .$PostInfo['timeStamp'] ."</small>
									</h4>
								</div>
							</div>
							<div class='panel-body'> 
								<input type='text' class='editbar-input form-control hide' placeholder=''>
								<div class='editText'>";
								echo $PostInfo['content'];
								echo "
								</div>
							</div>";
							echo
							"
						</div>
						";
	}
}

/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	User 			contains	FirstName, LastName and photographURL
 * @param   PostContent		contains	content, TimeStamp
 * @return	nothing
 */
if ( ! function_exists('AdminPublicContentBox'))
{
	function AdminPublicContentBox($profileId)
	{
		echo form_open('adminMsg/postPublic');
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
		</div>
		";
		echo form_close();
	}
}
//------------------------------------

if ( ! function_exists('AdminReportRequest'))
{
    function AdminReportRequest()
    {
	echo form_open('adminReport/reportRequest');
	/*echo "
	<div id='requestForm' class='panel panel-default'>
		<div class='input-group'>
			<input type='textarea' class='form-control' id='category' name='category' placeholder='Type a category'>
			
			<input type='text' class='form-control' name='title' id='title' style='border:0px; width: 100%;'
                        value='".$previousTitle."' placeholder='Your title here' />
	*/
	echo form_close();
    }
}

if( ! function_exists('ResultBox') )
{
	function ResultBox($key , $count)
	{
		echo "
		<div class='panel panel-default'>
			<div class='panel-title row'>
				<h4 class='col-md-2 text-left'>".$key." </h4>
				<h4 class='cold-md-3 text-right'>".$count."</h4>
			</div>
		</div>
	";
	}
}