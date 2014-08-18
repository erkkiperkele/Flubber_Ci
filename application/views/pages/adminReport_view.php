<section class="container content-section col-md-4 col-xs-4 col-md-offset-1 col-xs-offset-1">


<?php
	//AdminReportRequest();
	$options = array(
			'0' => 'Choose Interest',
			'1' => 'Music',
			'2' => 'Movies',
			'3' => 'Books',
			'4' => 'Paintings');
	
	echo form_open('adminReport/generateReport');
	echo"
		<div class='input-group'>
			<input type='textarea' class='form-control' id='reportType' name='reportType' placeholder='Desired Report Type'>
			<span class='input-group-btn'>
				<button class='btn btn-default' type='submit'>Generate Report</button>
			</span>
		</div>
	";
	echo form_close();
	
	echo "<br />";
	
	foreach($cityList as $city => $count)
	{
		ResultBox($city , $count);
	}
	
	/*
	echo form_dropdown('Interest Menu' , $options, 'Options');
	echo "<br />";
	echo "<br />";
	echo form_submit('genReport' , 'Generate Report');*/
	
	//Lists to generate reports from
	echo '<pre>'; print_r($ageGroups); echo '</pre>';

	echo '<pre>'; print_r($ageList); echo '</pre>';
	
	echo '<pre>'; print_r($interestList); echo '</pre>';
	
	echo '<pre>'; print_r($cityList); echo '</pre>';
	
	echo '<pre>'; print_r($countryList); echo '</pre>';
	
	echo '<pre>'; print_r($professionList); echo '</pre>';
	
?>
</section>

<section class="container content-section col-md-6 col-xs-6">
<?php //graphs, maybe?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([

        var options = {
          title: 'Lengths of dinosaurs, in meters',
          legend: { position: 'none' },
        };

        var chart = new google.visualization.Histogram(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>
</section>
</div>
