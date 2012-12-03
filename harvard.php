<h2>Harvard Citation Generator</h2>
<?php
if (!isset($_GET["type"])) {
	//If type is not set, show the form
	echo "<form action=\".\" method=\"get\"><input type=\"hidden\" name=\"p\" value=\"harvard\" /><fieldset><legend>Work</legend> <strong>Type of work:</strong> (required) <input type=\"radio\" name=\"type\" id=\"book\" value=\"book\" data-targets=\"boxBook\" /> <label for=\"book\">Book</label> <input type=\"radio\" name=\"type\" id=\"journal\" value=\"journal\" data-targets=\"boxJournal\" /> <label for=\"journal\">Journal</label> <input type=\"radio\" name=\"type\" id=\"website\" value=\"website\" data-targets=\"boxWebsite\" /> <label for=\"website\">Website</label><br/><label for=\"title\"><strong>Title:</strong></label> <input type=\"text\" name=\"title\" id=\"title\" class=\"required\" required=\"required\" placeholder=\"required\" size=\"106\" /><br/><label for=\"year\"><strong>Year of first publication:</strong></label> <input type=\"number\" name=\"year\" id=\"year\" class=\"required\" required=\"required\" placeholder=\"required\" /></fieldset><fieldset><legend>Authors</legend><strong>Author 1:</strong> <input type=\"text\" name=\"fn\" id=\"fn\" class=\"required\" required=\"required\" placeholder=\"First name (required)\" /> <input type=\"text\" name=\"sn\" id=\"sn\" class=\"required\" required=\"required\" placeholder=\"Surname (required)\" /><br/><strong>Author 2:</strong> <input type=\"text\" name=\"fn2\" id=\"fn2\" placeholder=\"First name\" /> <input type=\"text\" name=\"sn2\" id=\"sn2\" placeholder=\"Surname\" /><br/><label for=\"threeauthors\">Check this box if the work has three or more authors:</label> <input type=\"checkbox\" name=\"threeauthors\" id=\"threeauthors\" value=\"1\" /></fieldset><fieldset id=\"boxBook\"><legend>Book</legend><label for=\"bookpages\" class=\"labelwidth\">Page(s):</label> <input type=\"text\" name=\"pages\" id=\"bookpages\" /> (e.g., <q>3</q> or <q>6-10</q>)<br/><label for=\"chapter\" class=\"labelwidth\">Chapter name:</label> <input type=\"text\" name=\"chapter\" id=\"chapter\" /> (e.g., <q>Chapter One\" or \"The Boy Who Lived</q>)<br/><label for=\"place\" class=\"labelwidth\">Place of publication:</label> <input type=\"text\" name=\"place\" id=\"place\" /> (e.g., <q>London</q>)<br/><label for=\"editor\" class=\"labelwidth\">Editor:</label> <input type=\"text\" name=\"editor\" id=\"editor\" /> (e.g., <q>Doe, J</q>)<br/><label for=\"pub\" class=\"labelwidth\">Publisher:</label> <input type=\"text\" name=\"pub\" id=\"pub\" /> (e.g., <q>Harvard University Press</q>)</fieldset><fieldset id=\"boxJournal\"><legend>Journal</legend><label for=\"journalname\" class=\"labelwidth\">Journal name:</label> <input type=\"text\" name=\"journalname\" id=\"journalname\" class=\"required\" placeholder=\"required\" /> (e.g., <q>Nature</q>)<br/><label for=\"vol\" class=\"labelwidth\">Volume:</label> <input type=\"text\" name=\"vol\" id=\"vol\" /> (e.g., <q>12</q>)<br/><label for=\"part\" class=\"labelwidth\">Part:</label> <input type=\"text\" name=\"part\" id=\"part\" /> (e.g., <q>2</q>; only used when a volume is specified)<br/><label for=\"journalpages\" class=\"labelwidth\">Page(s):</label> <input type=\"text\" name=\"pages\" id=\"journalpages\" /> (e.g., <q>3</q> or <q>6-10</q>)</fieldset><fieldset id=\"boxWebsite\"><legend>Website</legend><label for=\"url\" class=\"labelwidth\">URL:</label> <input type=\"text\" name=\"url\" id=\"url\" class=\"required\" placeholder=\"required\" /> (e.g., <q>http://dendodge.me?p=harvard</q>)<br/><label for=\"date\" class=\"labelwidth\">Date of most recent access:</label> <input type=\"date\" name=\"date\" id=\"date\" class=\"required\" value=\"" . date("Y-m-d") . "\" /> (e.g., <q>" . date("d/m/Y") . "</q>)</fieldset><input type=\"submit\" value=\"Harvardize me!\" /></form>";
	echo "<script type=\"text/javascript\">
$('#boxBook, #boxJournal, #boxWebsite').hide();

$('input:radio[name=\"type\"]').change(function() {
    var id = $(this).attr('data-targets'); // or: $(this).data('targets');
    $('fieldset[id^=\"box\"]').hide(300);
    $('#' + id).show(300);
});
</script>";
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
echo "<br/><br/><form action=\".\" method=\"get\"><input type=\"hidden\" name=\"p\" value=\"harvard\" /><input type=\"submit\" value=\"Harvardize something else!\"></form>";
?>