<?php 

//echo"<pre>";
//print_r($_POST);

?>
<?php  
	include('connection.php');
	$decodeVerificationId = $_GET['verificationid']; 
	$decodeId = base64_decode($decodeVerificationId);
	//echo $decodeId;
	//die();
	if ($decodeId)
	{
		$update="update tbl_user set AccountStatus='1' where intUserID=$decodeId";
		$result=mysql_query($update);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Payment Failure</title>
<?php include_once("includes/common-links.php");?>
</head>
<body>
<div class="page">
	<div id="wrapper">
	  <!------------------>
	  <div id="content">
	  <!------------------>
	  <?php include_once("includes/header1.php");?>
	  <!---------------1----------->
			<div class="reg1">
				<div class="container">
				  <div class="row">
					<div class="col-lg-12" style="padding:10px 0">
						<center>
							<img src="images/failure.jpg"><br/>
							<h3> Uh-Oh! We Were Unable to Process Your Payment. </h3>
							<p>Sorry, your payment has been failed. </p>
							<p><a href="index.php" class="btn btn-warning">Please try again.</a></p>
						</center>
					</div>
				  </div>
				</div>
			</div>
	   </div>
  <!--------------->
  <?php include_once("includes/footer.php");?>

	</div>
</div>
</body>
</html>




<!DOCTYPE html>
<html <?php language_attributes(); ?> >
 <head>
  <meta charset="utf-8" />
  <title><?php wp_title(''); ?></title>
  <?php wp_head(); ?>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body <?php body_class(""); ?>>
  <?php echo do_shortcode('[header]'); ?>
  
  <div class="content" id="content">
	<div class="col-md-12">
		<div class="col-md-2"></div>
		<div class="col-md-8">
		<?php echo do_shortcode('[page_content]');?></div>
		<div class="col-md-2"></div>
	</div>
	  
  </div>
 <?php echo do_shortcode('[footer]'); ?>
  <?php wp_footer(); ?>
 </body>
</html>



