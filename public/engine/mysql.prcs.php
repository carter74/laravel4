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

if ($_REQUEST[mdf_ . $i] != $_REQUEST[copy_ . $i]){$newquery .= " SET ". $row[0] ." = '". $_REQUEST[mdf_ . $i] ."' ";}

$i++;

}

if ($newquery){

$newquery    = preg_replace("/\, $/",'', $newquery);
$mainquery  = "UPDATE ".$tbnm."";
$mainquery .= $newquery;
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

/*

INSERT INTO posts ('id', 'title', 'body', 'slug', 'enabled', 'created_at', 'updated_at') VALUES ('', 'Title 456', 'New cinema presents', '', '', '', '')

list($th[date],$th[time],$th[filename],$th[username],$th[userid],$th[rt],$th[mtype],$th[subj],
     $th[cl],$th[hd],$th[msglim],$th[imp],$th[comt],$th[community],$th[mode],$th[access],
     $th[flooder],$th[accdeny]) = explode("|", $thrline);

list($subj, $hsubj) = explode("\0", $subj); // check for hide elements

list($hvt, $hvc, $hrg, $ryear, $vin) = explode("/", $hsubj);

23 поля

date VARCHAR(10),
time VARCHAR(10),
trid BIGINT(16),
username VARCHAR(16),
userid BIGINT(16),
mtype CHAR(1),
subj VARCHAR(256),
msglimit INT(8),
ontop BOOLEAN,
closed BOOLEAN,
hided BOOLEAN,
important BOOLEAN,
comtime VARCHAR(10),
toptime VARCHAR(10),
community SMALLINT,
mode VARCHAR(8),
access VARCHAR(12),
flooder CHAR(1),
accessdeny VARCHAR(256),

mototype TINYINT,
motoclass TINYINT,
model VARCHAR(64)
ccm TINYINT,
year SMALLINT,
price INT(16),
located TINYINT,

CREATE TABLE pet (name VARCHAR(20), owner VARCHAR(20), species VARCHAR(20), sex CHAR(1), birth DATE, death DATE);

CREATE TABLE info (id BIGINT(16), date DATE, tmstmp BIGINT(16), subj VARCHAR(1024));

*/

?>