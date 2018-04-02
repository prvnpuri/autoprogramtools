<html>
<body>
	<?php

	if(!isset($_POST) ||count($_POST)==0 ){
		echo "Post request required.";
	}

	?>
	<table>

	<?php

		$posted=$_POST;

		foreach($posted as $k => $val) {
			echo "<tr><td>$k</td><td><input type='text' value='".html_entity_decode($val)."' </td></tr>";
		}
	
	?>	

	</table>
</body>
</html>