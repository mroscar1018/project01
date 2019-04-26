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

$colname_rsproduct = "-1";
if (isset($_GET['shopid'])) {
  $colname_rsproduct = $_GET['shopid'];
}
mysql_select_db($database_rsClass, $rsClass);
$query_rsproduct = sprintf("SELECT product.name, product.price, product.img FROM `order`, product WHERE shopid = %s AND product.sid = order.sid", GetSQLValueString($colname_rsproduct, "int"));
$rsproduct = mysql_query($query_rsproduct, $rsClass) or die(mysql_error());
$row_rsproduct = mysql_fetch_assoc($rsproduct);

$colname_rsmember = "-1";
if (isset($_GET['shopid'])) {
  $colname_rsmember = $_GET['shopid'];
}
mysql_select_db($database_rsClass, $rsClass);
$query_rsmember = sprintf("SELECT * FROM member WHERE shopid = %s", GetSQLValueString($colname_rsmember, "int"));
$rsmember = mysql_query($query_rsmember, $rsClass) or die(mysql_error());
$row_rsmember = mysql_fetch_assoc($rsmember);
$totalRows_rsmember = mysql_num_rows($rsmember);

$colname_rsProduct = "-1";
if (isset($_GET['shopid'])) {
  $colname_rsProduct = $_GET['shopid'];
}
mysql_select_db($database_rsClass, $rsClass);
$query_rsProduct = sprintf("SELECT*, product.name, product.price, product.img FROM `order`, product WHERE shopid = %s AND product.sid = `order`.sid", GetSQLValueString($colname_rsProduct, "int"));
$rsProduct = mysql_query($query_rsProduct, $rsClass) or die(mysql_error());
$row_rsProduct = mysql_fetch_assoc($rsProduct);
$totalRows_rsProduct = mysql_num_rows($rsProduct);
$stotal=0;
?>
<!doctype html>
<html>
<head>
<?php require_once('header.php'); ?>
<style type="text/css">
#thanklist {
	width: 80%;
	min-height: 700px;
	margin-right: auto;
	margin-left: auto;
}
</style>
</head>

<body style="padding-top: 0px">
<?php require_once('navbar.php'); ?>
<div id="thanklist">
  <h2>感謝您的訂購 歡迎再次光臨</h2>
  <table class="table">
	<thead> 
	  <tr class="table-warning">
		<th scope="col">訂單號碼</th>
		<th scope="col">訂購日期</th>
		<th scope="col">用戶姓名</th>
		<th scope="col">地址</th>
		<th scope="col">電話</th>
		<th scope="col">E-mail</th>
	  	</tr>
		</thead> 
	<tbody>  
	  <tr>
		<td><?php echo $row_rsmember['shopid']; ?></td>
		<td><?php echo $row_rsmember['create_date']; ?></td>
		<td><?php echo $row_rsmember['uname']; ?></td>
		<td><?php echo $row_rsmember['addr']; ?></td>
		<td><?php echo $row_rsmember['tel']; ?></td>
		<td><?php echo $row_rsmember['email']; ?></td>
	  </tr>
		</tbody>
</table>
<hr>
<table class="table table-striped">
	<thead>  
		<tr>
			<th scope="col">訂單編號</th>
			<th scope="col">商品品名</th>
			<th scope="col">圖片</th>
			<th scope="col">價格</th>
			<th scope="col">數量</th>
			<th scope="col">小計</th>
		  </tr>
		</thead> 
	<tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsProduct['sid']; ?></td>
      <td><?php echo $row_rsProduct['name']; ?></td>
      <td><img src="images/<?php echo $row_rsProduct['img']; ?>.png" writh="70px" height="60px"></td>
      <td><?php echo $row_rsProduct['price']; ?></td>
      <td><?php echo $row_rsProduct['qty']; ?></td>
      <td><?php echo $row_rsProduct['price']*$row_rsProduct['qty']; ?></td>
    </tr>
    <?php $stotal+=$row_rsProduct['price']*$row_rsProduct['qty'];} while ($row_rsProduct = mysql_fetch_assoc($rsProduct)); ?>
  <tr class="table-warning">
    
    <td>小計:<?php echo $stotal; ?></td>
</tr>
  <tr class="table-warning">

    <td>運費:30</td>
  </tr>
  <tr class="table-warning">

    <td>總計:<?php echo $stotal+30; ?></td>
  </tr>
	</tbody>
</table>


  
</div>
	<?php require_once('subject.php'); ?>
	<?php require_once('footer.php'); ?>	 
<?php require_once('bootstraptJS.php'); ?>
</body>
</html>
<?php
mysql_free_result($rsmember);

mysql_free_result($rsProduct);
?>
