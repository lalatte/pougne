<html>
  <head>
   <!--Load the AJAX API-->
		<script type='text/javascript' src='https://www.google.com/jsapi'></script>
		<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
		<script type='text/javascript'>
	   
		// Load the Visualization API.
		google.load('visualization', '1', {'packages':['corechart']});
		</script>
  <?php

include("dbconnect.php");



if(isset($_GET['date']))
{
	$startdate=strtotime("today");
	$enddate=strtotime("tomorrow");
	$result=$database->query("SELECT * FROM news WHERE date>'$startdate' AND date<'$enddate' ORDER BY ID DESC;");
}
	
else
{
	$result=$database->query("SELECT * FROM news WHERE volume>1000000 AND volume<25000000 ORDER BY ID DESC;");
}

while($data=$result->fetch())
{

$ID=$data['ID'];

if($data['data']!="")
	{$javascript="
	 
		 <script>
		// Set a callback to run when the Google Visualization API is loaded.
		google.setOnLoadCallback(drawChart);
		 
		function drawChart() {
		  var jsonData = $.ajax({
			  url: 'chartdata.php?ID=".$ID."',
			  dataType:'json',
			  async: false
			  }).responseText;
		
		
		
		  // Create our data table out of JSON data loaded from server.
		var data = new google.visualization.DataTable(jsonData);

		var options = {
		width: 1200, 
		height: 500,
		hAxis: {
            format: 'HH:mm',
          },
		vAxis:
		{
			viewWindow: {
				min: 0.95,
				max: 1.05
			}
		},	
		annotations: {
            style: 'line'
        },
		};
		  
		  // Instantiate and draw our chart, passing in some options.
		  var chart = new google.visualization.LineChart(document.getElementById('chart_div".$ID."'));
		  chart.draw(data, options);
		  chart.setSelection([{row: 38, column: 1}]);
		}
		
		</script>
		";
		echo $javascript;
	}
}
	?>
  </head>

  <body>
    <!--Div that will hold the column chart-->
	<?php
	
if(isset($_GET['date']))
{
	$result2=$database->query("SELECT * FROM news WHERE date>'$startdate' AND date<'$enddate' ORDER BY ID DESC;");
}

else
{
	$result2=$database->query("SELECT * FROM news WHERE volume>1000000 AND volume<25000000 ORDER BY ID DESC;");
}

	while($data=$result2->fetch())
{
	
	$ID=$data['ID'];
	if($data['data']!="")
	{
		$volume=$data['volume'];
		$volume=round($volume/1000000,2)."M";
		echo "<p>Stock : ".$data['stock']." - Volume : ".$volume." - Cat : ".$data['cat2']."</p>";
		echo "<div id='chart_div".$ID."'></div>";
	}
}
?>
  </body>
</html>