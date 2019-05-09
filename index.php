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
$query_rsClass = "SELECT * FROM `class` ORDER BY sort ASC";
$rsClass = mysql_query($query_rsClass, $rsClass) or die(mysql_error());
$row_rsClass = mysql_fetch_assoc($rsClass);
$totalRows_rsClass = mysql_num_rows($rsClass);
?>
<!DOCTYPE html>
<html lang="zh-tw">
  <head>
    <meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <title>蔣好的味道</title>
    <!-- Bootstrap -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">  
	<link href="css/header.css" rel="stylesheet" type="text/css">
	<link href="css/abc.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="list2.CSS" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
  <style>
  
  </style>
  <link href="css/animation.css" rel="stylesheet" type="text/css">
  <script type="text/javascript">
		var Mybody = document.getElementsByTagName('body'), lastScrollY = 350;
		window.addEventListener("scroll", function() {
		  var st = this.scrollY;
		  // 判斷是向上捲動，而且捲軸超過 300px
		  if (st > lastScrollY) {
			Mybody[0].classList.add("hideUp");
		  } else {
			Mybody[0].classList.remove("hideUp");
		  }
		  // lastScrollY = st;
		});
		</script>
  </head>
  <body>
  	<!-- body code goes here -->
<?php require_once('navbar01.php'); ?>
  <div class="container-fluid">
	  <div class="row">

	      <div class="background photo1 col-12 paddingh" >
			  <div id="header">
    				<div id="Blogo" class="scale-up-center"><a href="#"><img id="logoP" src="images/logo.png" width="200" hight="100" alt="logo1"></a></div>
   				</div>
			</div>
    </div>
  </div>
  <div class="container-fluid">
    <div id="menu1" >
			<nav class="headMainNav">
			  <ul class="mNav row">
				<li class="col-4 col-md-2 navm tracking-in-contract"><a href="aboutus.php">關於我們</a></li>
				<li class="col-4 col-md-2 navm tracking-in-contract"><a href="product.php?cid=0">好味菜單</a></li>
				<li class="col-4 col-md-2 navm tracking-in-contract"><a href="https://www.facebook.com/pages/category/Restaurant/%E8%94%A3%E5%A5%BD%E7%9A%84%E5%91%B3%E9%81%93-320575941851148/">FB粉絲專頁</a></li>
				<li class="col-4 col-md-2 navm tracking-in-contract"><a href="cart.php">訂單查詢</a></li>
				<li class="col-4 col-md-2 navm tracking-in-contract"><a href="login99.php" data-toggle="modal" data-target=".bd-example-modal-sm">會員登入</a></li>
				<li class="col-4 col-md-2 navm noborder tracking-in-contract" ><a href="#" data-toggle="modal" data-target="#myModal1" >意見回饋</a></li>
			  </ul>
			</nav>
	</div>
	  </div>
  <div class="container-fluid">
    <div class="row">
	  <div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel" style="background-color: grey">
		  <ol class="carousel-indicators">
		    <li data-target="#carouselExampleIndicators1" data-slide-to="0" class="active"></li>
		    <li data-target="#carouselExampleIndicators1" data-slide-to="1"></li>
		    <li data-target="#carouselExampleIndicators1" data-slide-to="2"></li>
	    </ol>
		  <div class="carousel-inner" role="listbox">
		    <div class="carousel-item active"> <img class="d-block mx-auto" src="images/1972c5ed45a5153173a1ee2ddbbdc7f2.jpg" alt="First slide">
		      <div class="carousel-caption">
	          </div>
	        </div>
		    <div class="carousel-item"> <img class="d-block mx-auto" src="images/13c34d49-85e9-4c6f-9afa-7e6ea03e6d8a.jpg" alt="Second slide">
		      <div class="carousel-caption">
	          </div>
	        </div>
		    <div class="carousel-item"> <img class="d-block mx-auto" src="images/DSCF8597.jpg" alt="Third slide">
		      <div class="carousel-caption">
	          </div>
	        </div>
	    </div>
		  <a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleIndicators1" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
    </div>
  </div>
  <div class="container-fluid">
	<div class="row">
		<div class="col-xl-12 clear"><div class="menutitle"><h2>好味菜單</h2></div></div>
    </div>
  </div>

  <div class="container">
			<div id="sectioneat">
			  <?php do { ?>
		      <div class="eatsphoto">
			      <img src="images\<?php echo $row_rsClass['img']; ?>.jpg" alt="粥" width="100%">
			      <a href="product.php?cid=<?php echo $row_rsClass['cid']; ?>" target="_self"><div class="overlay">
			        <div class="eattext"><?php echo $row_rsClass['cname']; ?></div>
		        </div></a>
	          </div>
			    <?php } while ($row_rsClass = mysql_fetch_assoc($rsClass)); ?>
					
  </div></div>
	    <div class="container-fluid">
			<div class="row">
				<div class="col-xl-12 clear"><div class="menutitle"><h2>關於我們</h2></div></div>
			</div>
  		</div>
  <div class="container-fluid">

			  <div id="uscontent">
				<div id="usphoto">
							<div id="usimgout">
								<div id="usimg"><img src="images/photo22.JPG" alt=""></div>
								<div id="usP2" class="usimg2"><img src="images/train.jpg" alt=""></div>
								<div id="usP3" class="usimg2"><img src="images/photo22.JPG" alt=""></div>
							</div>
				</div>
				<div id="ustest" class="col-7">
							<h2>蔣好的味道</h2><br>
							<p>
								座落在新竹的鐵道旁,堅持傳統的菜色,伴隨新時代的氣息
							</p>
					
					<p>,喧鬧的市區裡,難得的寧靜天地,講究的好手藝</p>
					<p>是我們的店名'蔣好的味道'的由來</p>
				</div>

			  </div>
	</div>


 <div class="container-fluid">


  <!-- The Modal -->
  <div class="modal fade pb-5" id="myModal1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content mt-5">
      
    	<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <?php require_once('test00.html'); ?>
        </div>
   
      </div>
    </div>
  </div>s
  
</div>


  <div id="footer" class="container-fluid background photo3">
    <div class="row">
      <div class="col-xl-12 footerb" align="center">
		   <br>
			  <p>Copyright © <a class="alink" href="index.php" target="_top">蔣好的味道</a>&nbsp; &nbsp;&nbsp; &nbsp;<a class="alink" href="https://www.facebook.com/%E8%94%A3%E5%A5%BD%E7%9A%84%E5%91%B3%E9%81%93-320575941851148/" target="_blank">粉絲專頁</a></p>
			  <br>
			  <p>TEL:03-545-8866 </p>
			  <br>
			  <p>ADD:300新竹市東區鐵道路一段28巷81號</p>
	  </div>
	</div>
</div>
  </body>
</html>
<?php
mysql_free_result($rsClass);
?>
