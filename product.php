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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "buy")) {
  $insertSQL = sprintf("INSERT INTO cart (sid, qty, ip) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['sid'], "text"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['ip'], "text"));

  mysql_select_db($database_rsClass, $rsClass);
  $Result1 = mysql_query($insertSQL, $rsClass) or die(mysql_error());

  $insertGoTo = "cart.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "buy")) {
  $insertSQL = sprintf("INSERT INTO cart (sid, qty, ip) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['sid'], "text"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['ip'], "text"));

  mysql_select_db($database_rsClass, $rsClass);
  $Result1 = mysql_query($insertSQL, $rsClass) or die(mysql_error());

  $insertGoTo = "cart.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rsproduct = "-1";
if (isset($_GET['cid'])) {
  $colname_rsproduct = $_GET['cid'];
}
mysql_select_db($database_rsClass, $rsClass);
$query_rsproduct = sprintf("SELECT * FROM product WHERE cid = %s ORDER BY sid ASC", GetSQLValueString($colname_rsproduct, "int"));
$rsproduct = mysql_query($query_rsproduct, $rsClass) or die(mysql_error());
$row_rsproduct = mysql_fetch_assoc($rsproduct);
$totalRows_rsproduct = mysql_num_rows($rsproduct);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
	<?php require_once('header.php'); ?>
<style type="text/css">
*{
	margin:0;
	padding:0;
}
#foodlist{
	display: flex;
	flex-direction: row;
	flex-wrap:wrap;
	align-content:flex-start;
	min-height: 730px;
	}

.food {
	text-align: center;
	flex-basis: 23%;
	margin-right: 2%;
}
	@media screen and (max-width: 900px) {
		.food {
	text-align: center;
	flex-basis: 46%;
	margin-right: 2%;
		
	}	
	}
.fimg {
	height: 200px;
	width: 100%;

	
}
.clear {
	clear: both;
}
.contents {
	height: auto;
	width: 100%;
}
	
</style>
</head>

<body style="padding-top: 0px">
<?php require_once('navbar.php'); ?>
<?php require_once('menu1.php'); ?>
<div id="foodlist" class="container-fluid">
	
 <?php do { ?>
	<div class="food">
      <form action="<?php echo $editFormAction; ?>" method="POST" name="buy">
        <div class="fimg animate"><a href="shopping.php?sid=<?php echo $row_rsproduct['sid']; ?>"><img src="images/<?php echo $row_rsproduct['img']; ?>.png" width="250px" height="200px"></a></div>
        
        <div class="contents"> 
          <a href="shopping.php?sid=<?php echo $row_rsproduct['sid']; ?>"><?php echo $row_rsproduct['name']; ?></a></div>
        <div class="contents"> <?php echo $row_rsproduct['price']; ?>元</div>
      </form>  
    </div>
	
    <?php } while ($row_rsproduct = mysql_fetch_assoc($rsproduct)); ?>
	
</div>
<?php require_once('subject.php'); ?>	
<?php require_once('footer.php'); ?>

</body>
</html>
<?php
mysql_free_result($rsproduct);
?>
