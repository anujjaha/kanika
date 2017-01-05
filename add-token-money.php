<?php
include('connection.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body style="background: #ececec none repeat scroll 0 0;">

<div class="loader"></div>

<form name="frmProdPaypal" id="frmPaypal" action="https://sandbox.paypal.com/cgi-bin/webscr" method="post">
<!--<form name="frmProdPaypal" id="frmPaypal" action="" method="post">-->
<table align="center" >
<tr>
<td align="center">Redirecting to paypal please wait....</td>
</tr>
<tr>
<td><img src="images/page-loader.gif" ></td>
</tr>
</table>
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="chhavikamboj7597@gmail.com"> <!--billingdesk@rrtechnosolutions.com -->

<input type="hidden" name="amount" value="<?php echo $_POST['earn_token'];?>">
<input type="hidden" name="custom" value="<?php echo  $_POST['token_user_id'];?>">
<input type="hidden" value="Token Amount" name="item_name">
<input type="hidden" name="cancel_return" value="http://rrtechnosolutions.in/freelance/cancel.php">
<input type="hidden" name="return" value="http://rrtechnosolutions.in/freelance/success.php">
<input type="hidden" name="cbt" value="RETURN TO Freelance WEBSITE" />
<input type="hidden" name="rm" value="2">
<input type="hidden" name="currency_code" value="USD">
</form>
</body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	document.frmProdPaypal.submit();
	});
/*function submitform()
{
    
	
}*/
//window.onload = submitform;

//$(window).load(function() {
 //$(".loader").html("<img src='images/loading.gif'>");
 //document.frmProdPaypal.submit();
// window.onload = submitform();
//})
</script>
</html>





