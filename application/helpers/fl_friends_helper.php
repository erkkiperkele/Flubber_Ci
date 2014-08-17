<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// --------------------------------------------------------------------

/**
* Random Element - Takes an array as input and returns a random element
*
* @access	public
* @param	array
* @return	mixed	depends on what the array contains
*/
if ( ! function_exists('PersonBox'))
{
    function PersonBox($member, $isOwner = false, $picHref = "http://placehold.it/100x95")
    {
        echo "
<div class='col-md-6 portfolio-item'>
	<a href='".CreateURL('index.php/profile/index/').$member['memberId'] ."'>
		<ul class='list-inline'>
			<li><img class='img-circle' src='" .$picHref ."'></li>
			<li>
				<ul class='list-unstyled'>
					<li><small class='nopadding'>" .$member['firstName'] ."</small></li>
					<li><small class='nopadding'>" .$member['lastName'];
        if ($isOwner)
            echo " (owner)";
        
        echo "
            </small></li>
				</ul>
			</li>
		</ul>
	</a>
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
if ( ! function_exists('FriendsCarousel'))
{
    function FriendsCarousel($friendList, $friendType = 'friend', $boxsize = 8)
    {
        $total = count($friendList);
        $page = ceil($total / $boxsize);
               
        if (is_array($friendList) && $total > 0)
        {
            echo "
	<div class=\"col-md-12\">
	<!-- Start Carousel -->
	<div id=\"".$friendType."-carousel\" class=\"carousel slide\" data-ride=\"carousel\">
	<!-- Indicators -->
	<ol class=\"carousel-indicators\">
	";
                   
            if ($page > 1)
            {
                echo "				
		<li data-target=\"#".$friendType."-carousel\" data-slide-to=\"0\" class=\"active\"></li>
		";
                       
                for($i = 1; $i < $page; $i++)
                {
                    echo "
			<li data-target=\"#".$friendType."-carousel\" data-slide-to=\"".$i."\"></li>
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
                $friend = $friendList[$i];
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
                echo PersonBox($friend, false, $friend['thumbnailURL']);
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
			<a class=\"left carousel-control\" href=\"#".$friendType."-carousel\" role=\"button\" data-slide=\"prev\">
			<span class=\"glyphicon glyphicon-chevron-left\"></span>
			</a>
			<a class=\"right carousel-control\" href=\"#".$friendType."-carousel\" role=\"button\" data-slide=\"next\">
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
