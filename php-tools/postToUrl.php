<?php
$data["term"]="data";
$url="url";
$method="POST"; // post or get
?>
<html>
	<head>
	Post Custom data
	</head>
	<body>
		<form method="<?php echo $method; ?>"  action='<?php echo $url; ?>' >
			<table>
				<?php 
					foreach($data as $k => $val){
						echo "<tr>";
						echo "<td>$k</td>";
						echo "<td><input type='text' name='$k' value='$val' /></td>";
						echo "</tr>";
					}
				?>
			</table>
			<input type="submit"/>
		</form>
	</body>
</html>