<?php require_once('Connections/rsClass.php'); ?>
<?php if(!isset($_session)){session_start();} ?>
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

$colname_sost = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_sost = $_SESSION['MM_Username'];
}
mysql_select_db($database_rsClass, $rsClass);
$query_sost = sprintf("SELECT member.uname, member.email, member.tel, member.addr, product.sid, product.name, product.price, product.img, `order`.qty, `order`.shopid FROM member, `order`, product WHERE uname = %s AND member.shopid = `order`.shopid AND product.sid = `order`.sid", GetSQLValueString($colname_sost, "text"));
$sost = mysql_query($query_sost, $rsClass) or die(mysql_error());
$row_sost = mysql_fetch_assoc($sost);
$totalRows_sost = mysql_num_rows($sost);
$stotal=0;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once('header.php'); ?>
</head>
<style type="text/css">
<!--
.style1 {
	font-size: 14px
}
.style2 {
	font-size: 14px;
	color: #993300;
}
.subtitle {
	font-size: 14px;
	color: #EF4E08;
	font-weight: bold;
	margin-top: 0px;
}
-->
</style>
<body>
	<?php require_once('navbar.php'); ?>
<p align="center" class="style1">&nbsp;</p>
<?php if ($totalRows_sost > 0) { // Show if recordset not empty ?>
  <p align="center" class="subtitle">目前您的訂單資料！</p>
  <h1>
    <?php // echo $query_sost; ?>
  </h1>
  <table class="table">
      <thead class="thead-dark">
    <tr>
      <th scope="col">訂單編號</th>
      <th scope="col">您的大名</th>
      <th scope="col">住址</th>
      <th scope="col">電話</th>
      <th scope="col">E-mail</th>
    </tr>
    </thead>
      <tbody>
    <tr>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_sost['shopid']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_sost['uname']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_sost['addr']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_sost['tel']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_sost['email']; ?></td>
    </tr>
  </table>
  <br />
  <table class="table">
      <thead class="thead-dark">
    <tr>
      <td align="center" bgcolor="#87C23C">商品編號</td>
      <td align="center" bgcolor="#87C23C">圖片</td>
      <td align="center" bgcolor="#87C23C">品名</td>
      <td align="center" bgcolor="#87C23C">價格</td>
      <td align="center" bgcolor="#87C23C">數量</td>
      <td align="center" bgcolor="#87C23C">小計</td>
      <td align="center" bgcolor="#87C23C">處理狀態</td>
    </tr>
           </thead>
	  <tbody>
    <?php do { ?>
      <tr>
        <td align="center" bgcolor="#FFFFFF"><?php echo $row_sost['sid']; ?></td>
        <td align="center" bgcolor="#FFFFFF"><img src="images/<?php echo $row_sost['img']; ?>.png" width="60" height="60" /></td>
        <td align="center" bgcolor="#FFFFFF"><?php echo $row_sost['name']; ?></td>
        <td align="center" bgcolor="#FFFFFF"><?php echo $row_sost['price']; ?>元</td>
        <td align="center" bgcolor="#FFFFFF"><label><?php echo $row_sost['qty']; ?></label></td>
        <td align="center" bgcolor="#FFFFFF"><?php echo $row_sost['price']*$row_sost['qty']; ?>元</td>
        <td align="center" bgcolor="#FFFFFF">處理中</td>
      </tr>
      <?php $stotal+=$row_sost['qty'] * $row_sost['price'];
	} while ($row_sost = mysql_fetch_assoc($sost)); ?>
    <tr>
      <td colspan="8" align="center" bgcolor="#FFFFFF">小計：<?php echo $stotal; ?></td>
    </tr>
    <tr>
      <td colspan="8" align="center" bgcolor="#FFFFFF">運費：30</td>
    </tr>
    <tr>
      <td colspan="8" align="center" bgcolor="#FFFFFF">總計：<?php echo $stotal+30; ?></td>
    </tr>
		  </tbody>
  </table>
  <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
<?php if ($totalRows_sost == 0) { // Show if recordset empty ?>
  <p align="center" class="mylink"><a href="product.php?cid=0">繼續挑選其他產品</a></p>
  <h1 align="center">目前沒有您的訂單資訊！！</h1>
  <?php } // Show if recordset empty ?>
	<?php require_once('subject.php'); ?>
	<?php require_once('footer.php'); ?>	 
<?php require_once('bootstraptJS.php'); ?>
</body>
</html>
<?php
mysql_free_result($sost);
?>
