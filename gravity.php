<h2>Gravity</h2>
<?php
// Get the URL of the current page
function curPageURL() {
 $pageURL = 'http';
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
$url = curPageURL();
// Define constants
$G = 6.67384 * pow(10,-11); //Gravitational constant
$m = 5.9736 * pow(10,24);   //Mass of the Earth
$r = 6371000;               //Radius of the Earth
$msmph = 2.23693629;        //1 m/s = 2.24 mph
//Find out if height is set (by form)
if (!isset($_GET["h"])) {
	//If height is not set, show the form
	echo "<form action=\".\" method=\"get\" novalidate=\"novalidate\"><input type=\"hidden\" name=\"p\" value=\"gravity\" /><label for=\"h\"><strong>Height above Earth's surface:</strong></label> <input type=\"number\" name=\"h\" id=\"h\" autofocus=\"autofocus\"  /> metres <input type=\"submit\" value=\"Go!\" /><br/><br/>Enter a positive number, in numeric digits. No spaces, commas, or exponents are accepted in your input, but decimal points are allowed. You can also use E notation, such as <kbd>12E3</kbd> for 12km.</form>";
	include 'footer.php';
	die();
}
//Check if height is numeric
if (!is_numeric($_GET["h"])) {
	die('<strong>Input must be in numeric digits</strong><br/>No spaces, commas, or exponents are accepted in your input, but decimal points are allowed. You can also use E notation, such as <kbd>12E3</kbd>3 for 12km.<br/><br/><a href="?p=gravity"><input type="button" value="Try again" /></a>');
} elseif ($_GET["h"] < 0) {
	die('<strong>Your input must be a positive number</strong><br/>No spaces, commas, or exponents are accepted in your input, but decimal points are allowed. You can also use E notation, such as <kbd>12E3</kbd> for 12km.<br/><br/><a href="?p=gravity"><input type="button" value="Try again" /></a>');
} else {
	$height = $_GET["h"];
}

$h = $r + $height;  //Radius of the Earth + Height
$a = $G * $m / pow($h,2);
echo "Acceleration due to gravity (<var>g</var>) at this height = <strong><abbr title=\"$a\">";
if (round($a,2) == 0) {
	echo $a;
} else {
	echo(round($a,2));
}
echo "</abbr> m s<sup>&minus;1</sup></strong><br/><br/>";
//Calculate t and v
$t = sqrt($height / (0.5 * $a));
$v = $a * $t;
$mph = $v * $msmph;
//Print to screen
echo "If you dropped a ball from a height of <strong>" . number_format($height) . "</strong> ";
if (number_format($height) == 1) {
  echo "metre ";
} else {
  echo "metres ";
}
echo "in a vacuum, it would take <strong>";
//Convert time to h:m:s
$seconds = $t % 60;
$time = ($t - $seconds) / 60;
$minutes = $time % 60;
$hours = ($time - $minutes) / 60;
$remainder = $t - $seconds;
$secondsout = round($seconds + $remainder);
//Check plurals
if (round($hours,2) > 0) {
	echo(number_format($hours));
	if (round($hours,2) == 1) {
	  echo " hour, ";
	} else {
	  echo " hours, ";
	}
}
if ($minutes > 0) {
	echo "$minutes";
	if (round($minutes,2) == 1) {
	  echo " minute and ";
	} else {
	  echo " minutes and ";
	}
}
echo "$secondsout";
if (round($seconds,2) == 1) {
  echo " second";
} else {
  echo " seconds";
}
//Print to screen
echo "</strong> (" . number_format($t,2) . "&nbsp;s) to reach the ground, and would hit the ground at a speed of <strong>" . number_format($v,2) . "</strong> metres per second (<strong>" . number_format($mph,2) . "</strong> miles per hour).<br/><br/><small>Note that these values are approximations, and are only accurate for heights and masses that are much smaller than the radius of the earth (<i>h << r</i>, <i>m << M</i>).</small><br/><br/>";
echo '<a href="?p=gravity"><input type="button" value="Use another number" /></a>';
?>