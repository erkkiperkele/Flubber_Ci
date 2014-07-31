<section class="container content-section col-md-4 col-xs-4 col-md-offset-1 col-xs-offset-1">
	<?php
			

			memberInfoBox($member);

	if(count($interestTypes) > 0)
	foreach ($interestTypes as $key => $interests): 
	?>
	
	
			<?php
			echo
				"<div class='interests panel panel-default'>
		  		<div class='panel-heading'>"
		  		.$key
		  		."</div>
		  		 <ul class='list-group'>"
			;
			?>
		<?php
	    	if(count($interests) > 0)
	    	foreach ($interests as $interest): 
	    		InterestBox($interest);
	    	endforeach 
	    ?>
	    <?php
			echo"
					</ul>
				</div>
				</div>
			";
	?>
	
	<?php
	endforeach 
?>
	
</section>
<section class="container content-section col-md-6 col-xs-6">
<?php
	AddContentBox();
?>
<?php
	if(count($posts) > 0)
	foreach ($posts as $postInfo): 
		ContentBox($postInfo);
	endforeach 
?>
</section>
</div>