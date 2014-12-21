<?php

FDefault();

// mysql.prcs.php

if ($savedbraw){

###################################
# $dbnm - DB name
# $tbnm - table name
# $mdf_0 - modified field
# $copy_0 - copy of oroginal for compare
###################################

$link = mysql_pconnect($sqkhost, $sqllogin, $sqlpswd);

if (!$link) {die('<b>MySQL connection error:</b> ' . mysql_error());}

mysql_select_db ( $dbnm ) or die ("Unable to select $dbnm");

###################################
# INSERT; UPDATE (modify); DELETE.
# $query = "INSERT INTO ".$tbnm." VALUES ('".$mdf_1."', '".$mdf_2."')"; // add new row
# $query = "UPDATE ".$tbnm." SET rating = 200 WHERE snum = ".$mrwn.";"; // modify one field of one row
# $query = "DELETE FROM ".$tbnm." WHERE snum = ".$mrwn."; // remove row
###################################

# INSERT INTO info VALUES ('1418631900', '12/15/2014', '1418631900', 'simple information');

$querydb = "SHOW COLUMNS FROM ".$tbnm;

$result = mysql_query($querydb); // take fields name of table

$i = 0; $newquery = ""; $firstrowname = "";

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {

if ($i == 0 && !$firstrowname){$firstrowname = $row[0];}

if ($_REQUEST[mdf_ . $i] != $_REQUEST[copy_ . $i]){

$master = $_REQUEST[mdf_ . $i];

$master = str_replace("|","&#124;",$master);
$master = str_replace("|",'',$master);
$master = str_replace("\"","&quot;",$master);
$master = str_replace("<","&lt;",$master);
$master = str_replace(">","&gt;",$master);
$master = str_replace("'","&apos;",$master);

//$master = htmlentities(urlencode($master));

$newquery .= $row[0] ." = '". $master ."', ";

}

$i++;

}

if ($newquery){



$newquery    = preg_replace("/\, $/",'', $newquery);
$mainquery  = "UPDATE ".$tbnm."";
$mainquery .= " SET ".$newquery;
$mainquery .= " WHERE ".$firstrowname." = ".$mrwn.";";

}

$sysmsg = $mainquery."<hr>";

$result = mysql_query ( $mainquery );

if ($result){$sysmsg .= "Row modify successfuly.";
} else {$sysmsg .= "Row modify error: ". mysql_error();}

mysql_close ($link);

}

##################################################
# add new line to table

if ($addnewline && $tbnm){

    $link = mysql_pconnect($sqkhost, $sqllogin, $sqlpswd);

    if (!$link) {die('<b>MySQL connection error:</b> ' . mysql_error());}

mysql_select_db ( $dbnm ) or die ("Unable to select $dbnm");

    $querydb = "SHOW COLUMNS FROM ".$tbnm;

$result = mysql_query($querydb); // take fields name of table

    $i = 0; $newquery = ""; $where = "";

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {

//if ($row[5] == 'auto_increment'){

    $where      .= "`". $row[0] . "`, ";;
    $newquery   .= "'". $_REQUEST[new_ . $i] ."', ";

    $i++;

}

$where    = preg_replace("/\, $/",'', $where);
$newquery = preg_replace("/\, $/",'', $newquery);

$mainquery = "INSERT INTO `".$tbnm."` (".$where.") VALUES (".$newquery.")"; // add new row

$sysmsg = $mainquery."<hr>";

$result = mysql_query ( $mainquery );

if ($result){$sysmsg .= "Add new line successfuly.";
} else {$sysmsg .= "Add new line error: ". mysql_error();}

mysql_close ($link);

}

##################################################
# remove line from table

if ($removeraw && $tbnm){

    $link = mysql_pconnect($sqkhost, $sqllogin, $sqlpswd);

    if (!$link) {die('<b>MySQL connection error:</b> ' . mysql_error());}

mysql_select_db ( $dbnm ) or die ("Unable to select $dbnm");

$querydb = "SHOW COLUMNS FROM ".$tbnm;

$result = mysql_query($querydb); // take fields name of table

$firstrowname = "";

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {

    if (!$firstrowname){$firstrowname = $row[0]; break;}

}

$mainquery = "DELETE FROM `".$tbnm."` WHERE ".$firstrowname." = '".$mrwn."';"; // add new row

$sysmsg = $mainquery."<hr>";

$result = mysql_query ( $mainquery );

if ($result){$sysmsg .= "Row removed successfuly.";
} else {$sysmsg .= "Row removed: ". mysql_error();}

mysql_close ($link);

}

?>