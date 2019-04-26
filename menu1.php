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

mysql_select_db($database_rsClass, $rsClass);
$query_Class = "SELECT * FROM `class` ORDER BY sort ASC";
$Class = mysql_query($query_Class, $rsClass) or die(mysql_error());
$row_Class = mysql_fetch_assoc($Class);
$totalRows_Class = mysql_num_rows($Class);
?>
<div id="Bcokntent">
  <div id="muemheader">
    <ul class="class row">
     <?php do { ?>
    
      <li class="col-md-3 col-6 mulist border" style="list-style-type:none;"><a class="animate nav-link" style="text-decoration:none;" href="product.php?cid=<?php echo $row_Class['cid']; ?>"><?php echo $row_Class['cname']; ?></a>
      </li>
      <?php } while ($row_Class = mysql_fetch_assoc($Class)); ?>
    </ul>

  </div>
</div>
<?php
mysql_free_result($Class);
?>