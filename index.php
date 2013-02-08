<?php
	// Use the URL's query string to determine which page to get and the contents of the <title> element
	if (!isset($_GET["p"])) {
		$title = "home";
		include 'header.php';
		include "$title.php";
		include 'footer.php';
	} else {
		$title = $_GET["p"];
		//Does the requested page exist?
		if (file_exists("$title.php")) {
			// If so, include everything
			include 'header.php';
			include "$title.php";
			include 'footer.php';
		} else {
			//Else, return a 404
			header('HTTP/1.0 404 Not Found');
			$title = "404 - Not Found";
			include 'header.php';
			include '404.php';
			include 'footer.php';
		};
	};
?>