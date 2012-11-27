<!DOCTYPE html>
<html lang="en">
<!-- header.php -->
	<head>
		<meta charset="UTF-8" />
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<link href="favicon.ico" rel="icon" type="image/png"/>
		<link rel="profile" href="http://microformats.org/profile/hcalendar"/>
		<?php
		$baseurl = dirname($_SERVER['PHP_SELF']);
		// Set the page's <title> element based on $title
		if ($title == "home") { // Special case for homepage
			echo "<title>dendodge</title>";
		} else {
			echo "<title>$title - dendodge</title>";
		}
		// Handy function to create navbar links with minimal coding
		function navlink($page,$title,$baseurl) {
			if ($title == "$page") {
				echo "<li><span class=\"currentpage\">$page</span></li>";
			} elseif ($page == "home") { // Special case for homepage
				echo "<li><a href=\"$baseurl\" rel=\"home\">$page</a></li>";
			} else {
				echo "<li><a href=\"?p=$page\">$page</a></li>";
			}
		}
		?>
		<!-- For Flattr -->
		<script type="text/javascript">
/* <![CDATA[ */
(function () {
	"use strict";
	/*jslint browser:true */
	var s = document.createElement('script'), t = document.getElementsByTagName('script')[0];
	s.type = 'text/javascript';
	s.async = true;
	s.src = 'http://api.flattr.com/js/0.6/load.js?mode=auto';
	t.parentNode.insertBefore(s, t);
}());
/* ]]> */
		</script>
	</head>
	<body>
		<div class="container">
		<div class="header"><header><h1>dendodge</h1></header></div>
		<div class="nav"></div>
		<div class="navlinks"><map name="navigation"><nav><ul class="navlinks">
		<?php
		// Create navbar using function defined above
		navlink("home",$title,$baseurl);
		navlink("about",$title,$baseurl);
		navlink("portfolio",$title,$baseurl);
		navlink("contact",$title,$baseurl);
		?>
		</ul></nav></map></div>
		<div class="content">
<!--Actual content starts here-->
