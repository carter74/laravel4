<?php

 require ("setup.inc.php");
 require ("mysql.lib.php");

##################################################################################
#
#   My personal engine to work with MySQL tables
#   gvozdevmax@gmail.com
#   version: 1.1.32 (12.21.2014)
#
##################################################################################
# get request

$dbnm       = $_REQUEST['dbnm'];
$tbnm       = $_REQUEST['tbnm'];
$editrow    = $_REQUEST['editrow'];
$savedbraw  = $_REQUEST['savedbraw'];
$addnewline = $_REQUEST['addnewline'];
$removeraw  = $_REQUEST['removeraw'];
$mrwn       = $_REQUEST['mrwn'];
$rwcc       = $_REQUEST['rwcc'];
$flcc       = $_REQUEST['flcc'];

##################################################################################
# Requests processing

 require ("mysql.prcs.php");

##################################################################################
# HEADER

echo <<<Form

<!doctype html>
<html>
<head>
<title>end.</title>
</head>
<link rel="StyleSheet" href="$sts[extpath]/index.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<link rel="shortcut icon" href="$sts[extpath]/favicon.gif" type="image/gif">
<body class=rfont>

Form;

##################################################################################

$titul = "MySQL";

echo "<font class=rfont>";

if ($sysmsg){echo "<b>System:</b> $sysmsg<hr>";}

$link = mysql_connect($sqkhost, $sqllogin, $sqlpswd);

if (!$link) {
    die('<b>MySQL connection error:</b> ' . mysql_error());
}

echo "<a href=\"$sts[extpath]/index.php\"><b>Index</b></a> / ";

echo "<a href=\"$sts[extpath]/mysql.php\"><b>MySQL</b></a> / ";

echo '<b>MySQL connected successfuly</b>';

$charset = mysql_client_encoding($link);

echo " / <b>Code page of DB:</b> $charset<hr>";

    $status = explode('  ', mysql_stat($link));

//    print_r($status);
//    echo "<hr>";

    for ($i = 0; $i <= count($status)-1; $i++){

//    if($i % 2 == 1){printf("<b>%s</b> ", $status[$i]);} else {printf("%s; ", $status[$i]);}

    $strrep = preg_replace("/(.*?)\:(.*?)/i", "<b>\\1:</b> \\2", $status[$i]);
    printf("%s; ", $strrep);

    }

echo "<hr><b>Registered DBs</b>:<br>";

$db_list = mysql_list_dbs($link);

while ($row = mysql_fetch_object($db_list)) {

    $sqldbname = $row->Database;

    if ($dbnm && $dbnm == $sqldbname){

    echo "<a href=\"". $sts[extpath] ."/mysql.php?dbnm=". $sqldbname ."\"><b>". $sqldbname ."</b></a><br>\n";

    } else {

    echo "<a href=\"". $sts[extpath] ."/mysql.php?dbnm=". $sqldbname ."\">". $sqldbname ."</a><br>\n";

    }

}

mysql_close($link);

######################################################################

if (!$dbnm){

$textrequest = stripslashes($textrequest);

    echo "<hr>";
    echo "<div style=\"background: #eeeeee; padding: 4px;\">";
    echo "<form action=\"$sts[extpath]/mysql.php\" method=\"POST\" accept-charset=\"windows-1251\">";
    echo "<b>Make direct request to MySQL:</b> ";
    echo "<input type=\"text\" name=\"textrequest\" size=\"50\" value=\"$textrequest\" class=rfont> ";
    echo "<input type=submit name=\"sendreqdb\" value=\"send request >\"></form>";

if ($sendreqdb){

echo "<b>request:</b> ".$textrequest."<br>";

$link = mysql_pconnect($sqkhost, $sqllogin, $sqlpswd);

if (!$link) {die('<b>MySQL connection error:</b> ' . mysql_error());}

$result = mysql_query($textrequest);

if ($result){

echo "<hr><b>Result:</b> ".$result."<br>";

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
    for ($i = 0; $i < count($row); $i++){
        printf("%s - ", iconv("UTF-8", "WINDOWS-1251", $row[$i]));
    }
    echo "<br>";
}

} else {

    echo "<hr>MySQL request error: ". mysql_error();

}

mysql_free_result($result);

mysql_close($link);

echo "</div>";

}

######################################################################

} elseif ($dbnm){

if (!mysql_pconnect($sqkhost, $sqllogin, $sqlpswd)) {
    echo '<b>MySQL connection error.</b>'. mysql_error();;
    exit;
}

$sql = "SHOW TABLES FROM ".$dbnm;
$result = mysql_query($sql);

if (!$result) {
    echo "DB error. Can't read table list.\n";
    echo 'Error MySQL: ' . mysql_error();
    exit;
}

echo "<hr><b>TABLEs:</b><br>";

while ($row = mysql_fetch_row($result)) {

    if ($tbnm && $tbnm == $row[0]){

    echo "<a href=\"". $sts[extpath] ."/mysql.php?dbnm=$dbnm&tbnm=". $row[0] ."\"><b>".$row[0] ."</b></a><br>\n";

    } else {

    echo "<a href=\"". $sts[extpath] ."/mysql.php?dbnm=$dbnm&tbnm=". $row[0] ."\">".$row[0] ."</a><br>\n";

    }

}

mysql_free_result($result);

#####################

$textrequest = stripslashes($textrequest);

    echo "<hr>";
    echo "<div style=\"background: #eeeeee; padding: 4px;\">";
    echo "<form action=\"$sts[extpath]/mysql.php\" method=\"POST\" accept-charset=\"windows-1251\">";
    echo "<input type=hidden name=dbnm value=\"$dbnm\">\n";
    echo "<input type=hidden name=tbnm value=\"$tbnm\">\n";
    echo "<b>Make request to DB ($dbnm -> $tbnm):</b> ";
    echo "<input type=\"text\" name=\"textrequest\" size=\"50\" value=\"$textrequest\" class=rfont> ";
    echo "<input type=submit name=\"sendreqdb\" value=\"send request >\"></form>";

if ($sendreqdb){

echo "<b>request:</b> ".$textrequest."<br>";

$link = mysql_pconnect($sqkhost, $sqllogin, $sqlpswd);

if (!$link) {die('<b>MySQL connection error:</b> ' . mysql_error());}

if ($dbnm){mysql_select_db($dbnm) or die ("Unable to open $dbnm");}

$result = mysql_query($textrequest);

if ($result){

echo "<hr><b>Result:</b> ".$result."<br>";

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
    for ($i = 0; $i < count($row); $i++){
        printf("%s - ", iconv("UTF-8", "WINDOWS-1251", $row[$i]));
    }
    echo "<br>";
}

} else {

    echo "<hr>MySQL request error:". mysql_error();

}

mysql_free_result($result);

mysql_close($link);

}

    echo "</div>";

### SHOW TABLE  #####

if ($tbnm){

echo "<hr><b>Table content:</b> $tbnm<br>";

$link = mysql_connect($sqkhost, $sqllogin, $sqlpswd);

if (!$link) {
    die('<b>MySQL connection error:</b> ' . mysql_error());
}

@mysql_select_db($dbnm);

echo "<table class=rfont>";

$querydb = "SHOW COLUMNS FROM ".$tbnm;

echo "<b>query:</b> ".$querydb."<br>";

$result = mysql_query ( $querydb ); // show fields name of table

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
    echo "<tr><td></td>\n";
    for ($i = 0; $i < count($row); $i++){
        printf("<td>%s</td>\n", iconv("UTF-8", "WINDOWS-1251", $row[$i]));
    }
    echo "</tr>\n";
}

$querydb = 'SELECT * FROM '.$tbnm;

echo "<b>query:</b> ".$querydb."<br>";

$result = mysql_query( $querydb ) or die ( "Invalid query" );

echo "<b>rows:</b> ". mysql_num_rows($result) ." / ";
echo "<b>fields:</b> ". mysql_num_fields($result) ."<hr>";

//echo "<ul style=\"margin-left:15px;margin-bottom:0px;margin-top:3px;padding:0px;\" type=square>";

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {

    echo "<tr bgcolor=#eeeeee>\n";

if ($row[0] && $editrow != $row[0]){

    echo "<td></td>";

    for ($i = 0; $i < count($row); $i++){

    printf("<td>%s</td>\n", iconv("UTF-8", "WINDOWS-1251", $row[$i]));

    }

    echo "<td>[<a href=\"". $sts[extpath] ."/mysql.php?dbnm=$dbnm&tbnm=$tbnm&editrow=". $row[0] ."\">";
    echo "edit</a>]</td>\n";

} elseif ($row[0] && $editrow == $row[0]){

    echo "<tr style=\"background: #eeeeee; padding: 4px;\">";
    echo "<td><a name=\"". $row[0] ."\">\n";
    echo "<form action=\"$sts[extpath]/mysql.php\" method=\"POST\" accept-charset=\"windows-1251\">";
    echo "<input type=hidden name=mrwn value=\"". $row[0] ."\">\n";
    echo "<input type=hidden name=dbnm value=\"$dbnm\">\n";
    echo "<input type=hidden name=tbnm value=\"$tbnm\">\n";
    echo "<input type=hidden name=rwcc value=\"". mysql_num_rows($result) ."\">\n";
    echo "<input type=hidden name=flcc value=\"". mysql_num_fields($result) ."\">\n";

    for ($i = 0; $i < count($row); $i++){

    $master = str_replace("\"","&quot;", iconv("UTF-8", "WINDOWS-1251", $row[$i]));

    $master = str_replace("<","&lt;",$master);
    $master = str_replace(">","&gt;",$master);

//    $master = htmlentities(urlencode($master));

    echo "<input type=hidden name=\"copy_$i\" value=\"". $master ."\">\n";

    }


    echo "</td>\n";

    for ($i = 0; $i < count($row); $i++){

    echo "<td><input type=\"text\" name=\"mdf_$i\" size=\"". strlen($row[$i]) ."\" value=\"". iconv("UTF-8", "WINDOWS-1251", $row[$i]) ."\" class=rfont></td>\n";

    }

    echo "<td><input type=submit name=\"savedbraw\" value=\"save...\"> ";
    echo "<input type=submit name=\"removeraw\" value=\"remove\" onClick=\"if (!confirm('$frmstr[r_u_sure]')) return false; else return correctA(this);\"></form></td>\n";

}

echo "</tr>\n";

}

#############################################################
# add new line

    echo "<tr style=\"background: #cccccc; padding: 4px;\">";
    echo "<td><a name=\"". $row[0] ."\">\n";
    echo "<div style=\"background: #eeeeee; padding: 4px;\">";
    echo "<form action=\"$sts[extpath]/mysql.php\" method=\"POST\" accept-charset=\"windows-1251\">";
    echo "<input type=hidden name=dbnm value=\"$dbnm\">\n";
    echo "<input type=hidden name=tbnm value=\"$tbnm\">\n";
    echo "<input type=hidden name=rwcc value=\"". mysql_num_rows($result) ."\">\n";
    echo "<input type=hidden name=flcc value=\"". mysql_num_fields($result) ."\">\n";
    echo "</td>";

$querydb = "SHOW COLUMNS FROM ".$tbnm;

$result = mysql_query($querydb); // take fields name of table

$i = 0; while ($row = mysql_fetch_array($result, MYSQL_NUM)) {

echo "<td>". $row[0] .":<br><input type=\"text\" name=\"new_$i\" size=\"". strlen($row[$i])."\" value=\"\" class=rfont></td>\n";

$i++;}

    echo "<td><br><input type=submit name=\"addnewline\" value=\"[+] add new line\"></form></div></td>\n";

#############################################################

echo "</table>";

mysql_free_result($result);

mysql_close($link);

} // if table name

} // if db name

#####################
# End

echo <<<Form

<hr><b>end.</b></font>
</body></html>

Form;

?>