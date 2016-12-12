<?php
$data["term"]="Cromogenia-Units, S.A. ";
$url="https://localhost/polymer-development/Polyajax/consigneeMaster";
$method="POST";
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