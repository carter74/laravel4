<?

 require ("setup.inc.php");
 require ("mysql.lib.php");

$title_str = "Raspberry Pi - PHP server:";

##################################################################################
# HEADER

echo <<<Form

<!doctype html>
<html>
<head>
<title>$title_str</title>
</head>
<link rel="StyleSheet" href="$sts[extpath]/index.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<link rel="shortcut icon" href="/favicon.gif" type="image/gif">
<body class=rfont>

Form;

echo "<b>".$title_str."</b><hr><ul>";

echo "<li><a href=\"$sts[extpath]/mysql.php\" class=bigfont>MySQL.php</a>";
echo "<li><a href=\"$sts[extpath]/info.php\" class=bigfont>PHP info.php</a>";

echo "</ul>";

#####################
# End

echo <<<Form

<hr><b>end.</b></font>
</body></html>

Form;

?>