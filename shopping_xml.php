<?php require_once('Connections/rsClass.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
 
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;


  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rs = "-1";
if (isset($_GET['sid'])) {
  $colname_rs = $_GET['sid'];
}
mysql_select_db($database_rsClass, $rsClass);
$query_rs = sprintf("SELECT * FROM product WHERE cid = (SELECT cid FROM product WHERE sid = %s) ORDER BY (sid = %s) desc", GetSQLValueString($colname_rs, "text"),GetSQLValueString($colname_rs, "text"));
$rs = mysql_query($query_rs, $rsClass) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
?>
<?php
mysql_query('SET NAMES utf8');
	
header("Content-Type: text/xml");
echo("<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n");
echo("<root>\n");
do {
	echo("<row>\n");  
	foreach (array_keys($row_rs) as $item) {
    	echo ("<$item>"); 
        echo ("<![CDATA[".$row_rs["$item"])."]]>";
    	echo ("</$item>\n");
    }		
	echo("</row>\n");  
} while ($row_rs = mysql_fetch_assoc ($rs));
exit("</root>\n"); 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>

</body>
</html>
<?php
mysql_free_result($rs);
?>
