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
