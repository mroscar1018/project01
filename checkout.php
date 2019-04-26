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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO member (uname, email, pw1, tel, addr) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['pw1'], "text"),
                       GetSQLValueString($_POST['tel'], "text"),
                       GetSQLValueString($_POST['addr'], "text"));

  mysql_select_db($database_rsClass, $rsClass);
  $Result1 = mysql_query($insertSQL, $rsClass) or die(mysql_error());
   //手動加入購物車資訊程式 by 20190107
  $insertSQL="select shopid from member where email='".$_POST['email']."'"; //取得使用者購買編號
  $Result1 = mysql_query($insertSQL, $rsClass) or die(mysql_error());
  $data=mysql_fetch_assoc($Result1);
  $shopid=$data['shopid'];
  
  //將購物車資料寫入訂單資料表 by 20180107
  $countNum=count($_POST['sid']);
	for($i=0;$i<$countNum;$i++){
		$sid=$_POST['sid'][$i];
		$qty=$_POST['qty'][$i];

   $insertSQL="INSERT INTO `order` (`sid`, `shopid`, `qty`) VALUES ('".$sid."', '".$shopid."', '".$qty."')"; //寫入訂單資料表
   $Result1 = mysql_query($insertSQL, $rsClass) or die(mysql_error());
	}

	// 刪除原購物車資料 by 20190107
	$insertSQL="DELETE FROM `cart` WHERE `cart`.`ip` = '".$_SERVER['REMOTE_ADDR']."'"; //清空購物車
    $Result1 = mysql_query($insertSQL, $rsClass) or die(mysql_error());

  $insertGoTo = "thank.php?shopid=".$shopid;
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rscart = "-1";
if (isset($_SERVER['REMOTE_ADDR'])) {
  $colname_rscart = $_SERVER['REMOTE_ADDR'];
}
mysql_select_db($database_rsClass, $rsClass);
$query_rscart = sprintf("SELECT *,product.name, product.price, product.img FROM cart, product WHERE ip = %s AND product.sid = cart.sid ORDER BY ordtime DESC", GetSQLValueString($colname_rscart, "text"));
$rscart = mysql_query($query_rscart, $rsClass) or die(mysql_error());
$row_rscart = mysql_fetch_assoc($rscart);
$totalRows_rscart = mysql_num_rows($rscart);
$stotal=0;
?>
<!doctype html>
<html>
 <head>
    <?php require_once('header.php'); ?>
<style type="text/css">
	#Cout{
		min-height: 900px;
	}
	
#cartlist {
	width: 80%;
	margin-right: auto;
	margin-left: auto;
}
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>
<?php require_once('navbar.php'); ?>	
<div id="Cout"class="container">
   <div class="row">
	    <div class="col-xl-12 text-center">
		  <h1>訂購人資料</h1>
			<p>清輸入相關資料</p>
		  </div>
	   		</div>
<div class="row">
<div class="col-12">
  <form name="form" action="<?php echo $editFormAction; ?>" method="POST">
<div class="form-group row">
    <lable class="col-2" for="uname">姓名:</lable>
    <div class="col-10">  
	<span id="sprytextfield1">
      <input class="form-control" type="text" name="uname" id="uname" placeholder="*請輸入姓名">
      <span class="textfieldRequiredMsg">請輸入姓名</span>
	</span>
		</div>
	</div>
 <div class="row form-group">
    <lable class="col-2" for="email">電子郵件:</lable>
     <div class="col-10"> 
	 <span id="sprytextfield2">
      <input class="form-control" type="email" name="email" id="email" placeholder="*請輸入emai帳號">
      <span class="textfieldRequiredMsg">請輸入email</span></span>
  </div></div>
 <div class="row form-group">
    <lable class="col-2" for="pw1">密碼:</lable>
     <div class="col-10"> 
	 <span id="sprytextfield3">
      <input class="form-control" name="pw1" id="pw1" type="password" placeholder="*請輸入密碼">
      <span class="textfieldRequiredMsg">請輸入密碼</span></span>
		 </div>
  </div>
 <div class="row form-group">
    <lable class="col-2" for="pw2">確認密碼:</lable>
     <div class="col-10">
	 <span id="sprytextfield4">
      <input class="form-control" name="pw2" id="pw2" type="password" placeholder="*再次確認密碼">
      <span class="textfieldRequiredMsg">請輸入正確的密碼</span></span>
  </div> </div>
 <div class="row form-group">
    <lable class="col-2" for="tel">電話:</lable>
      <div class="col-10">
	 <span id="sprytextfield5">
      <input class="form-control" type="text" name="tel" id="tel" placeholder="*請輸入連絡電話">
      <span class="textfieldRequiredMsg">輸入電話號碼</span></span>
  </div></div>
 <div class="row form-group">
    <lable class="col-2" for="addr">地址:</lable>
     <div class="col-10"> 
	 <span id="sprytextfield6">
      <input class="form-control" type="text" name="addr" id="addr" placeholder="*請輸入郵件地址">
      <span class="textfieldRequiredMsg">請輸入郵件地址</span></span>
  </div>
	 </div>
	

<hr>
<table class="table table-striped" width="100%">
  <thead>
	<tr>
    <th scope="col">商品編號</td>
    <th scope="col">商品名稱</td>
    <th scope="col">圖片</td>
    <th scope="col">價格</td>
    <th scope="col">數量</td>
    <th scope="col">小計</td>
  </tr>
	  </thead>
	<tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rscart['sid']; ?>
        <input name="sid[]" type="hidden" id="sid[]" value="<?php echo $row_rscart['sid']; ?>"></td>
      <th scope="row"><?php echo $row_rscart['name']; ?></td>
      <td><img src="images/<?php echo $row_rscart['img']; ?>.png" writh="70px" height="60px"></td>
      <td><?php echo $row_rscart['price']; ?></td>
      <td><?php echo $row_rscart['qty']; ?>
        <input name="qty[]" type="hidden" id="qty[]" value="<?php echo $row_rscart['qty']; ?>"></td>
      <td><?php echo $row_rscart['price'] * $row_rscart['qty']; ?></td>
    </tr>
    <?php $stotal+=$row_rscart['price'] * $row_rscart['qty'];} while ($row_rscart = mysql_fetch_assoc($rscart)); ?>
  <tr>
    <td>小計:<?php echo $stotal; ?></td>
  
  </tr>
  <tr>
    <td>運費:30</td>
 
  </tr>
  <tr>
    <td>總計:<?php echo $stotal+30; ?></td>

  </tr>
 </tbody>
</table>
<input class="btn btn-danger" type="submit" value="送出訂單">
<a href="javascript:;" onclick="window.location.href='cart.php';" class="btn btn-danger">回上一頁</a>
<input type="hidden" name="MM_insert" value="form">

  </form>
	</div>
	</div>
	 
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
</script>
<?php require_once('subject.php'); ?>
<?php require_once('footer.php'); ?>
</body>
</html>
<?php
mysql_free_result($rscart);
?>
