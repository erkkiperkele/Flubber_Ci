<!DOCTYPE html>
<head>
	<?php LoadCSSBundle(); ?>
	<title><?php echo $title ?> (Flubber)</title>
</head>	
<body>
	<?php MenuBar($member, $groupList, $newRequestNb, $newMessageNb, $this->session->userdata['privilege']); ?>
	<div style="margin-top: 5%">
		<section class="col-md-10 col-xs-10 col-md-offset-1 col-xs-offset-1">
		<?php 
			if($currentPage == 'groups')
				GroupHeader($group, $owner);
			else
				ProfileHeader($member);
		?>
		</section>
	</div>