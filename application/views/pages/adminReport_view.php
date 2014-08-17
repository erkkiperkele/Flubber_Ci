<section class="container content-section col-md-4 col-xs-4 col-md-offset-1 col-xs-offset-1">
<?php
	//options
	echo '<pre>'; print_r($test); echo '</pre>';
	
	//echo '<pre>'; print_r($ageGroups); echo '</pre>';

	echo '<pre>'; print_r($interestList); echo '</pre>';

	echo '<pre>'; print_r($ageList); echo '</pre>';
	
	echo '<pre>'; print_r($cityList); echo '</pre>';
	
	echo '<pre>'; print_r($countryList); echo '</pre>';
	
	echo '<pre>'; print_r($professionList); echo '</pre>';
	
?>
</section>
<section class="container content-section col-md-6 col-xs-6">
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(
          
	  )
        var options = {
          title: 'Distribution of members by age',
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

<?php
	
	//render graphs?
?>
</section>
</div>
