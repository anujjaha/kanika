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
<title>Thanks For Registration</title>
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
						  <img src="images/ThankyouRegistering.png"><br/>
						  <h3>Please check your email for the verification then only you are able to access the website</h3>
						  <a href="http://rrtechnosolutions.in/freelance/login.php" class="btn btn-primary" style="font-size:30px;font-weight:600;clear:both;margin:20px 0">Login / Signup</a>
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




