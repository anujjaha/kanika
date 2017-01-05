<?php
include_once("db/connection.php");
include_once("include/common-functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Payment Failure</title>
<?php include_once( "include/common-css.php"); ?>
</head>
<body>
<div class="page">
  <!------------------------>
  <?php include_once("include/header.php"); ?>
  <!------------------------------>
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner"> <img src="images/banner/profile-banner.jpg" alt="banner img">
    <div class="aa-catg-head-banner-area">
      <div class="container">
        <div class="aa-catg-head-banner-content">
          <h2> Payment Failure </h2>
          <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active"> Payment Failure </li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <!-- / catg header banner section -->
  <div class="about">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <div class="about_cont"> 
		 <h3> Payment failrue </h3>
        <p>Sorry, your payment has been failed. Please try again.</p>
        
        </div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <?php include_once("include/sidebar.php"); ?>
        </div>
      </div>
    </div>
  </div>
  <!-------------------------------------->
  <?php include_once("include/footer.php"); ?>
  <!-------------------------------->
</div>
<!-- jQuery library -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
<!-- To Slider JS -->
<script src="js/sequence.js"></script>
<script src="js/sequence-theme.modern-slide-in.js"></script>
<!-- Custom js -->
<script src="js/custom.js"></script>
</body>
</html>

