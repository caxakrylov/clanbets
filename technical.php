<?php
	header('HTTP/1.0 503 Service Unavailable');
	header('Retry-After: 3600');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>This site is temporarily unavailable</title>
</head>
<body>
<h1>Sorry, the site is closed for engineering works.</h1>
<!-- Try waiting a few minutes and reloading. -->
</body>
</html>