<section class="container content-section col-md-4 col-xs-4 col-md-offset-1 col-xs-offset-1">
	<?php

	memberInfoBox($member);

	if(count($interestTypes) > 0)
	foreach ($interestTypes as $key => $interests): 
		echo"
		<div class='interests panel panel-default'>
	  		<div class='panel-heading'>"
	  		.$key
	  		."	<button class='add-interests-btn btn pull-right clearfix' style='margin:0px 0px 0px 0px; padding:0px 0px 0px 0px; background:inherit;'>
					<span class='glyphicon glyphicon-chevron-down'></span>
				</button>
			</div>
	  		 <ul class='list-group'>
  		";

  		//TO VERIFY
  		if($member['memberId'] == $profileId)
  		{
			AddInterest($key);
  		}

    	if(count($interests) > 0)
    	foreach ($interests as $interest): 
    		InterestBox($interest);
    	endforeach;

		echo"
			</ul>
		</div>
		";
	endforeach;
	?>
	
</section>
<section class="container content-section col-md-6 col-xs-6">
<?php
	AddContentBox($profileId);

	if(count($posts) > 0)
	foreach ($posts as $postInfo): 
		if (array_key_exists('wallContentNumber',$postInfo))
		{
			ContentBox($postInfo);
		}
		if (array_key_exists('publicContentNumber',$postInfo))
		{
			PublicContentBox($postInfo);
		}
	endforeach 
?>
</section>