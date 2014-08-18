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
		            <h3 class='panel-title pull-left'>Reply</h3>
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
	<div class='panel-heading messageeditable' style='margin: 0 0 0 0; padding: 0 0 0 0' id='".$PostInfo['msgType'] ."'>
            <button class='message-del-btn btn pull-right clearfix' style='margin:6px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit;'>
				<span class='glyphicon glyphicon-remove'></span>
			</button>
            <div class='panel-title row' style='margin-right:10px;' id='".$PostInfo['messageNumber']."'>
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
					<div class='panel-body' id='".$PostInfo['targetId'] ."'> 
						<input type='text' class='editbar-input form-control hide' placeholder=''>
						<div>";
                        echo $PostInfo['content'];
        echo "
						</div>
					</div>
                </div>";
    }
}

/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access	public
 * @param	array
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('ConversationBox'))
{
    function ConversationBox($targetId, $lastMsg)
    {
        echo
            "<li class='list-group-item'>
	            <a href='".CreateURL('index.php/messages/index/').$targetId."'>
                     <img class='img-circle' src='" .$lastMsg['targetThumbnailURL']. "'/>
                     " .$lastMsg['targetFirstName']. " ".$lastMsg['targetLastName'];
                //if (!$lastMsg['isRead'])
                //    echo " (new)";
            echo
                "</a>
            </li>";
    }
}