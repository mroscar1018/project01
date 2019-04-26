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
 $all_qty=$_POST['qty'];
$selectSQL=sprintf("SELECT * FROM CART WHERE sid=%s ",GetSQLValueString($_POST['sid'], "int"));
mysql_select_db($database_rsClass, $rsClass);
$Result1 = mysql_query($selectSQL, $rsClass) or die(mysql_error());
$totalRows_cart= mysql_num_rows($Result1);
if($totalRows_cart>0){
	
	$row_cart = mysql_fetch_assoc($Result1);
	$all_qty=$row_cart['qty']+$_POST['qty'];
	if($all_qty > 100){
		$all_qty=100;
		$errcode="1";
		}
	$insertSQL = sprintf("UPDATE `s10718b-p04`.`cart` SET `qty` = '%s' WHERE `cart`.`cartid` = %s;",GetSQLValueString($all_qty, "int"),GetSQLValueString($row_cart['cartid'], "int"));		
}else {
	$insertSQL = sprintf("INSERT INTO cart (sid, qty, ip) VALUES (%s, %s, %s)",GetSQLValueString($_POST['sid'], "int"),GetSQLValueString($all_qty, "int"),GetSQLValueString($_POST['ip'], "text"));

	}
  $Result1 = mysql_query($insertSQL, $rsClass) or die(mysql_error());


  $insertGoTo = "cart.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

?>
<!DOCTYPE html>
<html xmlns:spry="http://ns.adobe.com/spry">
<!doctype html>
<html>
<head>
<?php require_once('header.php'); ?>
	<link href="shoping.css" rel="stylesheet" type="text/css">
	<script src="SpryAssets/xpath.js" type="text/javascript"></script>
	<script src="SpryAssets/SpryData.js" type="text/javascript"></script>
	<script type="text/javascript">
	var ds1 = new Spry.Data.XMLDataSet("shopping_xml.php?sid=<?php echo $_GET['sid']; ?>", "root/row");
	</script>
  </head>
  <body>
  	<!-- body code goes here -->
<?php require_once('navbar.php'); ?>
  
	<div id="Bshop">
  <div id="Shoping">
	  <h2>商品明細</h2>
    <div spry:detailregion="ds1">
      <div id="shops">
        <form action="<?php echo $editFormAction; ?><?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="buy" target="_self" id="buy" onsubmit="YY_checkform('buy','qty','#1_20','1','請輸入數量1~20件');return document.MM_returnValue">
          <div id="Simg" class="shadow-sm p-3 mb-5 bg-white rounded"><img src="images/{img}.png" width="450px" height="400px"></div>
          <div class="shop_content">
            <table class="table" border="0">
              <tr>
                <td width="35%">品名</td>
                <td width="65%">{name}</td>
              </tr>
              <tr>
                <td>價格</td>
                <td>{price} 元</td>
              </tr>
              <tr>
                <td>購買數量</td>
                <td><input name="qty" type="text" class="type11" id="qty" value="1" size="5" />
                  碗</td>
              </tr>
            </table>
          </div>
          <div class="shop_content">
            <table width="100%" border="0" class="text-center trpadding">
			 <tr>
              <td><input class="btn btn-danger" name="tobuy" type="submit" value="加入購物車" target="_self" >
            	</td>
				 </tr>
					<td></td>
					</tr>
					<tr>
						<td>
						  <a class="btn btn-danger" href="javascript:;" onclick="history.go(-1)">回上一頁</a>
						</td>
					</tr>
			  </table>
          </div>
			<input name="sid" type="hidden" id="sid" value="{sid}">
            <input name="ip" type="hidden" id="ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
          <input type="hidden" name="MM_insert" value="buy">
        </form>
      </div>
    </div>
  </div>
	<div class="clearboth" style="height: 30px;"></div>
<div class="shoppingtitle">
		<h2>相關產品</h2>
		</div>	
	<div class="otherlist">
		<div id="otherthing row">
		  <div spry:region="ds1">
			<div spry:repeat="ds1" spry:setrow="ds1">
			  <div class="Otherthings animate">
				<table width="100%" border="0">
				  <tr>
					<td><img src="images/{img}.png" width="250px" height="200px" class="img-thumbnail"></td>
				  </tr>
					<tr>
					<td>{name}</td>
				  </tr>
				  <tr>
					<td>{price} 元</td>
				  </tr>
				</table>
			  </div>
			</div>
		  </div>
		</div>
	</div>
	  
</div>
	<div class="clear"></div>
<?php require_once('subject.php'); ?>
<?php require_once('footer.php'); ?>	

  </body>
</html>