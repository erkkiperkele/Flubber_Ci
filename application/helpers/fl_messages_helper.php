<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// --------------------------------------------------------------------

/**
* Random Element - Takes an array as input and returns a random element
*
* @access	public
* @param	User 			contains	FirstName, LastName and photographURL
* @param   PostContent		contains	content, TimeStamp
* @return	nothing
*/
if ( ! function_exists('AddUserMessageBox'))
{
    function AddUserMessageContent($fromMemberId, $toMemberId, $previousTitle = '')
    {
        if ($previousTitle <> '')
            $previousTitle = 'RE: ' . $previousTitle;
        echo form_open('messages/addMessage');
        echo "
            <div id='AddUserMessageContent' class='panel panel-default'>
	            <div class='input-group'>
                    <input type='text' class='form-control' name='title' id='title' style='border:0px; width: 100%;'
                        value='".$previousTitle."' placeholder='Your title here' />
		            <textarea id='messageContent' class='form-control' name='messageContent' 
                        placeholder='Your message here' rows='3'></textarea> 
		            <input type='hidden' class='form-control' id='fromMemberId' name='fromMemberId' value='" .$fromMemberId ."'>
		            <input type='hidden' class='form-control' id='toMemberId' name='toMemberId' value='" .$toMemberId ."'>
		            <span class='input-group-btn' style='vertical-align:bottom;'>
			            <button class='btn btn-default' type='submit'>Send</button>
		            </span>
	            </div>
	            <div class='panel-heading privacy'>
		            <h3 class='panel-title pull-left'>Message</h3>
				    <p/>
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
* @param	User 			contains	FirstName, LastName and photographURL
* @param   PostContent		contains	content, TimeStamp
* @return	nothing
*/
if ( ! function_exists('UserMessageBox'))
{
    function UserMessageBox($PostInfo = "")
    {
        echo "
<div class='message panel panel-default'>
	<div class='panel-heading editable' style='margin: 0 0 0 0; padding: 0 0 0 0'>";
        echo 
        "<div class='panel-title row' style='margin-right:10px;' id='".$PostInfo['messageNumber']."'>
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