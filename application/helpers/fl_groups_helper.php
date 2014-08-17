<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


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
    function GroupHeader($group, $owner)
    {
        echo "
            <div class='col-md-3'>
            <img id='group-pic' index='" .$group['groupId'] ."' class='img-responsive pull-right' src='" .$group['photographURL'] ."' style='width:190px; height:190px'/>
            </div>
            <div id='group-name' index='" .$group['groupId'] ."' class='jumbotron col-md-9' style='background-image:url(".$group['coverPictureURL']."); background-size: cover; padding:17px 10px'>
            <h1>" .$group['groupName'] ."<br/><small> " .$owner['firstName'].' '.$owner['lastName'] ."</small></h1>
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
if ( ! function_exists('GroupBox'))
{
	function GroupBox($GroupInfo = "")
	{
		echo "
		<div class='content panel panel-default'>
			<div class='panel-heading editable' style='margin: 0 0 0 0; padding: 0 0 0 0'>";
						echo
						"<button class='editbar-del-btn btn pull-right clearfix' style='margin:6px 6px 0px 0px; padding:0px 0px 0px 0px; background:inherit;'>
							<span class='glyphicon glyphicon-remove'></span>
						</button>
						";

						echo 
								"<div class='panel-title row' style='margin-right:10px;'id='".$GroupInfo['groupId']."'>
									<a href='" .CreateURL("/index.php/profile/index/".$GroupInfo['groupId']) ."'>
										<img class='profilePic col-md-1 col-md-offset-1' id='".$GroupInfo['coverPictureURL'] ."' src='" .$GroupInfo['thumbnailURL'] ."' width='26px' height='26px' style='margin:10px 10px'/>
									</a>
									<h4 class='col-md-3 text-left'>".$GroupInfo['groupName'] ." <small>" ." </small></h4>
									<h4 class='col-md-6 pull-right text-right small'>";
									"</h4>
								</div>
						<div class='panel-body'> 
						</div>
			</div>";
			echo"
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
if ( ! function_exists('GroupsCarousel'))
{
	function GroupsCarousel($memberList, $ownerId, $boxsize = 8)
	{
		$total = count($memberList);
		$page = ceil($total / $boxsize);
		
		if (is_array($memberList) && $total > 0)
		{
			echo "
			<div class=\"col-md-12\">
			<!-- Start Carousel -->
			<div id=\"group-carousel\" class=\"carousel slide\" data-ride=\"carousel\">
			<!-- Indicators -->
			<ol class=\"carousel-indicators\">
			";
			
			if ($page > 1)
			{
				echo "				
				<li data-target=\"#group-carousel\" data-slide-to=\"0\" class=\"active\"></li>
				";
				
				for($i = 1; $i < $page; $i++)
				{
					echo "
					<li data-target=\"#group-carousel\" data-slide-to=\"".$i."\"></li>
					";
				}
			}
			
			echo "
			</ol>

			<!-- Wrapper for slides -->
			<div class=\"carousel-inner\">
				<div class=\"item active\">
					<div class=\"row\">
			";
			
			for($i = 0; $i < $total; $i++)
			{
				$member = $memberList[$i];
				if($i != 0)
				{
					if ($i % $boxsize == 0)
					{
						echo "
							</div>
						</div>
						<div class=\"item\">
							<div class=\"row\">
						";
					}
					else if ($i % 2 == 0)
					{
						echo "
						</div>
						<div class=\"row\">
						";
					}
				}
				if ($member['memberId'] == $ownerId)
					echo PersonBox($member, true, $member['thumbnailURL']);
				else
					echo PersonBox($member, false, $member['thumbnailURL']);
			}
			
			echo "
				</div>
			</div>
			</div>
			";
			
			if ($page > 1)
			{
				echo "
				  <!-- Controls -->
				  <a class=\"left carousel-control\" href=\"#group-carousel\" role=\"button\" data-slide=\"prev\">
					<span class=\"glyphicon glyphicon-chevron-left\"></span>
				  </a>
				  <a class=\"right carousel-control\" href=\"#group-carousel\" role=\"button\" data-slide=\"next\">
					<span class=\"glyphicon glyphicon-chevron-right\"></span>
				  </a>
				";
			}
			
			echo "
			</div>
			</div>
			";
		}
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
if ( ! function_exists('AddGroupContentBox'))
{
	function AddGroupContentBox($groupId, $profileId)
	{
		echo form_open('groups/addGroupPost');
		echo "
		<div id='addGroupContentBox' class='panel panel-default'>
			<div class='input-group'>
				<input type='textarea' class='form-control' id='updatedPost' name='updatedPost'>
				<input type='hidden' class='form-control' id='contentType' name='contentType' value='text'>
				<input type='hidden' class='form-control' id='profileId' name='profileId' value='" .$profileId ."'>
				<input type='hidden' class='form-control' id='groupId' name='groupId' value='" .$groupId ."'>
				<span class='input-group-btn'>
					<button class='btn btn-default' type='submit'>Post</button>
				</span>
			</div>
			<div class='panel-heading privacy'>
				<h3 class='panel-title pull-left'>Comment</h3>
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
 * @param	User 			contains	firstName, lastName and photographURL
 * @param   PostContent		contains	content, TimeStamp
 * @return	nothing
 */
if ( ! function_exists('GroupContentBox'))
{
	function GroupContentBox($groupId, $PostInfo = "")
	{
        echo "
		<div class='content panel panel-default'>
			<div class='panel-heading groupeditable' id='".$groupId."' style='margin: 0 0 0 0; padding: 0 0 0 0'>";
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
        "<div class='panel-title row' style='margin-right:10px;' id='".$PostInfo['groupContentNumber']."'>";
        PostHeader($PostInfo, 'currentPosterId');
        
        echo "</div>";

        echo "<div class='panel-body'>";

        PostBody($PostInfo, 'currentPosterId');

        echo "</div>
			</div>
			";
	}
}