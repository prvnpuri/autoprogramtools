<?php

header("X-Frame-Options: ALLOW-FROM http://xyz3.localdomain.com/");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("X-Powered-By: Undertow/1");
?>

<html>
	<head>
	 <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'none'">
	</head>
	<body>
		<iframe src="http://xyz1.localdomain.com:8080/banana-kras-dev/" style="width:100%;height:400px;">
			
		</iframe>
	</body>
</html>