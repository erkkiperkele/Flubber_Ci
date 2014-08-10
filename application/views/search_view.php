<section class="container content-section text-center col-md-10 col-xs-10 col-md-offset-1 col-xs-offset-1">

	<div class="panel interests panel-default">
	  <div class="panel-heading text-center"><h1>Member Results</h1></div>
  		<div class="panel-body">
  			<?php if(is_array($result) && !empty($result[0]))
  			{
  				foreach ($result[0] as $member)
					echo SearchResultMember($member);
  			} else
  				echo "<p>No results found!</p>";
			?>
		</div>
	</div>
	
	<div class="panel interests panel-default">
	  <div class="panel-heading text-center"><h1>Group Results</h1></div>
  		<div class="panel-body">
		  	<?php if(is_array($result) && !empty($result[1]))
  			{
				foreach ($result[1] as $group) 
					echo SearchResultGroup($group);
			}else
				echo "<p>No results found!</p>";
			?>
		</div>
	</div>
</section>