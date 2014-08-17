<section class="container content-section col-md-4 col-xs-4 col-md-offset-1 col-xs-offset-1">
	<?php

	memberInfoBox($member);
	
	foreach ($interestTypes as $type): 
		echo"
		<div class='interests panel panel-default'>
	  		<div class='panel-heading'>"
	  		.$type['description'];

	  	if ($canAddInterests)
		{
  			echo "
	  		<button class='add-interests-btn btn pull-right clearfix' style='margin:0px 0px 0px 0px; padding:0px 0px 0px 0px; background:inherit;'>
					<span class='glyphicon glyphicon-chevron-down'></span>
				</button>";

		}
		echo "
			</div>
  		";

		if ($canAddInterests)
		{
			AddInterest($type['description']);
		}

		if(count($interests) > 0)
		{

			foreach ($interests as $singleType): 
				foreach ($singleType as $typeInterest): 
					$value1 = $typeInterest['interestTypeId'];
					$value2 = $type['interestTypeId'];
					if($value1 == $value2)
					{
		    			InterestBox($typeInterest, $canAddInterests);
					}
				endforeach;
			endforeach;
		}

		echo"
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