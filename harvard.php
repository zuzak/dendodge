<?php
if (!isset($_GET["type"])) {
	//If type is not set, show the form
	echo "<form action=\".\" method=\"get\" novalidate=\"novalidate\"><input type=\"hidden\" name=\"p\" value=\"harvard\" /><fieldset><legend>work</legend> <strong>Type of work:</strong> <input type=\"radio\" name=\"type\" id=\"book\" value=\"book\" checked=\"checked\" /> <label for=\"book\">Book</label> <input type=\"radio\" name=\"type\" id=\"journal\" value=\"journal\" /> <label for=\"journal\">Journal</label> <input type=\"radio\" name=\"type\" id=\"website\" value=\"website\" /> <label for=\"website\">Website</label><br/><label for=\"title\"><strong>Title:</strong></label> <input type=\"text\" name=\"title\" id=\"title\" class=\"required\" required=\"required\" placeholder=\"required\" size=\"106\" /><br/><label for=\"year\"><strong>Year of first publication:</strong></label> <input type=\"number\" name=\"year\" id=\"year\" class=\"required\" required=\"required\" placeholder=\"required\" /> <label for=\"pages\" class=\"labelwidth\"><strong>Page(s):</strong></label> <input type=\"text\" name=\"pages\" id=\"pages\" /> (e.g., \"3\" or \"6-10\")</fieldset><fieldset><legend>authors</legend><strong>Author 1:</strong> <input type=\"text\" name=\"fn\" id=\"fn\" class=\"required\" required=\"required\" placeholder=\"First name (required)\" /> <input type=\"text\" name=\"sn\" id=\"sn\" class=\"required\" required=\"required\" placeholder=\"Surname (required)\" /><br/><strong>Author 2:</strong> <input type=\"text\" name=\"fn2\" id=\"fn2\" placeholder=\"First name\" /> <input type=\"text\" name=\"sn2\" id=\"sn2\" placeholder=\"Surname\" /><br/><label for=\"threeauthors\">Check this box if the work has three or more authors:</label> <input type=\"checkbox\" name=\"threeauthors\" id=\"threeauthors\" value=\"1\" /></fieldset><br/><em>Fill in the one applicable fieldset below:</em><fieldset><legend>book</legend><label for=\"chapter\" class=\"labelwidth\">Chapter name:</label> <input type=\"text\" name=\"chapter\" id=\"chapter\" /> (e.g., \"Chapter One\" or \"The Boy Who Lived\")<br/><label for=\"place\" class=\"labelwidth\">Place of publication:</label> <input type=\"text\" name=\"place\" id=\"place\" /> (e.g., \"London\")<br/><label for=\"editor\" class=\"labelwidth\">Editor:</label> <input type=\"text\" name=\"editor\" id=\"editor\" /> (e.g., \"Doe, J\")<br/><label for=\"pub\" class=\"labelwidth\">Publisher:</label> <input type=\"text\" name=\"pub\" id=\"pub\" /> (e.g., \"Harvard University Press\")</fieldset><fieldset><legend>journal</legend><label for=\"journalname\" class=\"labelwidth\">Journal name:</label> <input type=\"text\" name=\"journalname\" id=\"journalname\" class=\"required\" placeholder=\"required\" /> (e.g., \"Nature\")<br/><label for=\"vol\" class=\"labelwidth\">Volume:</label> <input type=\"text\" name=\"vol\" id=\"vol\" /> (e.g., \"12\")<br/><label for=\"part\" class=\"labelwidth\">Part:</label> <input type=\"text\" name=\"part\" id=\"part\" /> (e.g., \"2\"; only used when a volume is specified)</fieldset><fieldset><legend>website</legend><label for=\"url\" class=\"labelwidth\">URL:</label> <input type=\"text\" name=\"url\" id=\"url\" class=\"required\" placeholder=\"required\" /> (e.g., \"http://dendodge.me?p=harvard\")<br/><label for=\"date\" class=\"labelwidth\">Date of most recent access:</label> <input type=\"date\" name=\"date\" id=\"date\" class=\"required\" placeholder=\"required\" value=\"" . date("d/m/Y") . "\" /> (e.g., \"" . date("d/m/Y") . "\")</fieldset><input type=\"submit\" value=\"Harvardize me!\" /></form>";
	include('footer.php');
	die();
}
//Variable definitions
$type= $_GET["type"];
if (isset($_GET["threeauthors"])) {
	$threeauthors = 1;
} else {
	$threeauthors = 0;
}
$surname = $_GET["sn"];
$firstname = $_GET["fn"];
$surname2 = $_GET["sn2"];
$firstname2 = $_GET["fn2"];
$year = $_GET["year"];
$chapter = $_GET["chapter"];
$editor = $_GET["editor"];
$title = $_GET["title"];
$place = $_GET["place"];
$publisher = $_GET["pub"];
$pages = $_GET["pages"];
$journal = $_GET["journalname"];
$volume = $_GET["vol"];
$part = $_GET["part"];
$url = $_GET["url"];
$accessdate = $_GET["date"];
//Bracketed "cite as" version (should be the same for everything)
echo "<strong>Cite as:</strong> ($surname";
if ($threeauthors == 1) {
	echo ", <i>et al.</i>";
} else if (!empty($surname2)) {
	echo " & $surname2";
}
echo ", $year";
if (!empty($pages)) {
	if (strpbrk($pages,"-") == FALSE) {
		echo ", p. ";
	} else {
		echo ", pp. ";
	}
	echo "$pages";
}
echo ")";

echo "<br/>";

echo "<strong>Bibliography entry:</strong> ";
//The bibliography entry starts here
//BOOK
if ($type == "book") {
	echo "$surname, " . substr($firstname,0,1) . "."; //Author 1 (required)
	if ($threeauthors == 1) {
		echo ", <i>et al.</i>"; //Display "et al." if there are three or more authors
	} else if (!empty($surname2)) {
			echo " & $surname2, " . substr($firstname2,0,1) . "."; //Else, if there are two authors, display Author 2's details
	}
	echo " ($year), "; //Publication year (required)
	if (!empty($chapter)) {
		echo "$chapter. "; //Display chapter name, if present
	}
	if (!empty($editor)) {
		echo "In: $editor. "; //Display editor name, if present
	}
	echo "<i>$title</i>. ";
	if (!empty($place)) {
		echo "$place"; //Display place of publication, if present
		if (!empty($publisher)) {
			echo ": $publisher."; //Display publisher, if present (if a place has been defined)
		} else {
			echo "."; //Or if there's no publisher, don't.
		}
	} else if (!empty($publisher)) {
		echo " $publisher."; //If there's a publisher but no place, display the publisher on its own
	}
}
//END BOOK
//JOURNAL
else if ($type == "journal") {
	echo "$surname, " . substr($firstname,0,1) . "."; //Author 1 (required)
	if ($threeauthors == 1) {
		echo ", <i>et al.</i>"; //Display "et al." if there are three or more authors
	} else if (!empty($surname2)) {
			echo " & $surname2, " . substr($firstname2,0,1) . "."; //Else, if there are two authors, display Author 2's details
	}
	echo " ($year), "; //Publication year (required)
	echo "$title. <i>$journal</i>. ";
	if (!empty($volume)) {
		echo "$volume";
		if (!empty($part)) {
			echo " ($part).";
		} else {
			echo ".";
		}
	}
}
//END JOURNAL
//WEBSITE
else if ($type == "website") {
	echo "$surname, " . substr($firstname,0,1) . "."; //Author 1 (required)
	if ($threeauthors == 1) {
		echo ", <i>et al.</i>"; //Display "et al." if there are three or more authors
	} else if (!empty($surname2)) {
			echo " & $surname2, " . substr($firstname2,0,1) . "."; //Else, if there are two authors, display Author 2's details
	}
	echo " ($year), <i>$title</i>. Available: $url. Last accessed " . date("j F Y",strtotime($accessdate)) . "."; //Everything is required, so just format & echo
}
//END WEBSITE
echo "<br/><br/><a href=\"?p=harvard\"><input type=\"button\" value=\"Harvardize something else!\" /></a>";
?>