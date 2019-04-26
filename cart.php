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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
 //修改更新檔為多筆更新
	$countNum=count($_POST['odlist_qty']);
	for($i=0;$i<$countNum;$i++){
		$odlist_qty=$_POST['odlist_qty'][$i];
		$cartid=$_POST['cartid'][$i];
  $updateSQL = sprintf("UPDATE cart SET qty=%s WHERE cartid=%s",
                       GetSQLValueString($odlist_qty, "int"),
                       GetSQLValueString($cartid, "int"));

  mysql_select_db($database_rsCalss, $rsClass);
  $Result1 = mysql_query($updateSQL, $rsClass) or die(mysql_error());
	}	

  $updateGoTo = "cart.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rscart = "-1";
if (isset($_SERVER['REMOTE_ADDR'])) {
  $colname_rscart = $_SERVER['REMOTE_ADDR'];
}
mysql_select_db($database_rsClass, $rsClass);
$query_rscart = sprintf("SELECT *, product.name, product.price, product.img FROM cart, product  WHERE ip = %s  AND cart.sid = product.sid ORDER BY cart.ordtime DESC", GetSQLValueString($colname_rscart, "text"));
$rscart = mysql_query($query_rscart, $rsClass) or die(mysql_error());
$row_rscart = mysql_fetch_assoc($rscart);
$totalRows_rscart = mysql_num_rows($rscart);
$stotal=0;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
<?php require_once('header.php'); ?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link href="css/abc.css" rel="stylesheet" type="text/css">
	<link href="css/animation.css" rel="stylesheet" type="text/css">
	<link href="css/footer.css" rel="stylesheet" type="text/css">
	<style type="text/css">
	.clearboth {
    clear: both;
}
		
		#bbb{
			min-height: 200px;
		}
    </style>
		
	
    <script type="text/javascript">
	
function btn_confirmLink(message,url) {
	if(message == "" || url=="") {
		document.MM_returnValue =false;
		return ;	
	}
	if(confirm(message)){
		window.location=url;
	}else {
		document.MM_returnValue =false;	
	}
}
    </script>
    </head>
    <body style="padding-top: 0px">
<?php require_once('navbar.php'); ?>
		
<div class="container-fluid">
      <div class="row">
    <div class="meallist col-md-12">
          <div class="cart_title">
        <div class="cart_title_container">
              <h1>餐點</h1>
            </div>
      </div>
		
          <form name="form" class="food" action="<?php echo $editFormAction; ?>" method="POST">
        <div class="meallist_content">
              <table class="meallist_table ">
            <thead class="col-md-12" style="background-color:burlywood">
                <td class="item col-md-2">圖片</td>
                  <td class="item col-md-2">品名</td>
                  <td class="item col-md-2"> 價格</td>
                  <td class="item col-md-2"> 數量</td>
                  <td class="item col-md-2"> 小計</td>
                  <td class="item col-md-2">取消</td>
                    </thead>
				  <?php if ($totalRows_rscart > 0) { ?>
                    <tbody>
                  <?php do { ?>
                  
                <tr>
                  <td ><img src="images/<?php echo $row_rscart['img']; ?>.png" writh="70px" height="60px"></td>
                  <td><?php echo $row_rscart['name']; ?></td>
                  <td><?php echo $row_rscart['price']; ?></td>
                  <td><input name="odlist_qty[]" id="odlist_qty[]" type="text" value="<?php echo $row_rscart['qty']; ?>" size="3" maxlength="3" >
                    <input name="cartid[]" type="hidden" id="cartid[]" value="<?php echo $row_rscart['cartid']; ?>">
                  </td>
                  <td><?php echo $row_rscart['price']*$row_rscart['qty']; ?></td>
                  <td><input type="button" name="button" id="button" value="取消" onclick="btn_confirmLink('確定刪除本資料?','shopcart_del1.php?cartid=<?php echo $row_rscart['cartid']; ?>');return document.MM_returnValue"
>
                  </td>
                </tr>
                 
                <?php $stotal+=$row_rscart['price']*$row_rscart['qty'];} while ($row_rscart = mysql_fetch_assoc($rscart)); ?>
                </tbody>
				  <?php } // Show if recordset not empty ?>
          </table>
            </div>
        <div class="cart_content">
              <div class="action_button"> 
				  <a class="btn btn-primary bstyle" href="javascript:;" onclick="history.back()">回上一頁</a>
				  <a href="javascript:;" onclick="window.location.href='product.php?cid=0';" class="btn btn-primary bstyle">繼續點餐</a>
				  <a onclick="btn_confirmLink('確定清空購物車資料?','shopcart_del.php');return document.MM_returnValue;">
                	<button type="button" id="click1" class="btn btn-primary bstyle">清除餐點</button>
                	</a> 
                 <a><button class="btn btn-primary bstyle" type="submit" name="button4" id="button4">更新購物車</button></a>  
            </div>
            </div>
			  <div id="bbb"></div> 
        <div class="total" >
              <div class="total_info">
            <div class="cart_state">
                  <table class="cart_total">
                <tbody>
                      <tr>
                    <td>小計</td>
                    <td><?php echo $stotal; ?></td>
                  </tr>
                      <tr>
                    <td>運送</td>
                    <td>30</td>
                  </tr>
                      <tr>
                    <td>總金額</td>
                    <td><?php echo $stotal+30; ?></td>
                  </tr>
                    </tbody>
              </table>
                </div>
          </div>
              <div class="pay">
            <div class="pay_button"> <a onclick="btn_confirmLink('請確定數量與總計金額？','checkout.php');return document.MM_returnValue;">
              <button type="button" id="click1" class="btn btn-pay_button">結帳</button>
              </a> 
                  
                  <!--
     <script type="text/javascript">
     function toGreen()
     {
         var oDiv = document.getElementById('click3')
        oDiv.className='click';
     }
     </script>
--> 
                </div>
          </div>
            </div>
        <input type="hidden" name="MM_update" value="form">
      </form>
		 
          <div class="clearboth"></div>
		<?php if ($totalRows_rscart == 0) { // Show if recordset empty ?>
          <div class="cart_not"> 親愛的顧客，您尚未點餐 </div>
		 <?php } // Show if recordset empty ?>
        </div>
  </div>
	
    </div>
	<?php require_once('subject.php'); ?>
	<?php require_once('footer.php'); ?>	 
	
</body>
</html>
<?php
mysql_free_result($rscart);
?>
