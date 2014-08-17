<section class="container content-section col-md-4 col-xs-4 col-md-offset-1 col-xs-offset-1">
	<?php

	memberInfoBox($member);

	if(count($interestTypes) > 0)
	foreach ($interestTypes as $key => $interests): 
		echo"
		<div class='interests panel panel-default'>
	  		<div class='panel-heading'>"
	  		.$key
	  		."</div>
	  		 <ul class='list-group'>
  		";

		AddInterest($key);

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
</div>