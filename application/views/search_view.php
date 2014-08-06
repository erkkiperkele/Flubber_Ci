<section class="container content-section text-center col-md-10 col-xs-10 col-md-offset-1 col-xs-offset-1">

	<div class="panel interests panel-default">
	  <div class="panel-heading text-center"><h1>Member Results</h1></div>
  		<div class="panel-body">
  			<?php foreach ($result[0] as $member)
				echo SearchResultMember($member);
			?>
		</div>
	</div>
	
	<div class="panel interests panel-default">
	  <div class="panel-heading text-center"><h1>Group Results</h1></div>
  		<div class="panel-body">
		  	<?php foreach ($result[1] as $group) 
				echo SearchResultGroup($group);
			?>
		</div>
	</div>
</section>