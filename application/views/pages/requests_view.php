	<body>
		<section class="container content-section text-center col-md-6 col-xs-6 col-md-offset-1 col-xs-offset-1">
			<div class="row">
			<?php
			if(is_array($userRequestList) && count($userRequestList) > 0)
				foreach($userRequestList as $userRequest):
					UserRequestBox($userRequest);
				endforeach;
			else
				echo 'You do not have any request yet.';
            ?>
			</div>
		</section>
	</body>