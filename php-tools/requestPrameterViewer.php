<html>
	<title>Request Parameter Viewer</title>
	<body>
	<h1></h1>
	<?php 
	
	function arrayToTable($array,$title=""){
		echo "<table border='1' style='width:100%'>";
		echo "<tr><th style='width:30%'>$title: count:".count($array)."</th><th style='width:70%'></th></tr>";
		echo "<tr><td>Key</td><td>Value</td></tr>";
		foreach ($array as $key=>$val){
			echo "<tr><td>$key</td><td>$val</td></tr>";
		}
		echo "</table>";
	
	}
	
	arrayToTable($_GET,"GET");

	arrayToTable($_POST,"POST");
	
	
	?>
	</body>
</html>