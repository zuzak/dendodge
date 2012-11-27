<?php
	// Use the URL's query string to determine which page to get and the contents of the <title> element
	if (!isset($_GET["p"])) {
		$title = "home";
	} else {
		$title = $_GET["p"];
	};
	// Include everything
	include 'header.php';
	include "$title.php";
	include 'footer.php';
?>