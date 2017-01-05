<?php 

include('connection.php');

if(isset($_POST['reset-submit']))
{

	$Sql = "select intUserID,AccountStatus,vchFirst_Name from tbl_user where vchEmail='".$_POST['User_email']."'";
	$Result = mysql_query($Sql);
	$Num_rows = mysql_num_rows($Result);
	$Rows = mysql_fetch_array($Result);
	if($Num_rows > 0)
	{

		$newpass= 	random_password();
		$Sql_update = "update  tbl_user set vchpassword='".md5($newpass)."' where vchEmail='".$_POST['User_email']."'";
		$Result_update = mysql_query($Sql_update);
		if($Result_update)
		{
			
			$HirerUserto = $_POST['User_email'];
			$subject = "New Password";
			$message = '<html>
				<head>
				<title> Notification About New Password </title>
				</head>
				<body>
					<div style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
						<table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
						<tr>
							<td align="center" valign="top" style="padding:20px 0 20px 0">
								
								<table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #E0E0E0;">
									<tr style="background-color:#ee8b14;">
										<td valign="top" style="text-align:center;font-size:20px;font-weight:600;color:#fff;padding:10px 0;"> Congratulations! '.$Rows['vchFirst_Name'].'</td>
									</tr>
								
									<tr>
										<td valign="top" style="padding:15px;background:#f2f2f2;">
										<div style="padding:20px;background:#fff;float:left;width:94%">
											<div style="border-bottom:solid 1px #dd7300;padding:10px 0;float:left;">
												<div style="float:left;width:30%;">
													<img src="http://www.rrtechnosolutions.in/freelance/images/your-logo.png" width="80%" alt="your-logo">
												</div>
												<div style="float:right;width:50%;text-align:right">
													<b>Notification</b><br/>'.date('Y-m-d').'
												</div>
											</div>
											
											<div style="border-bottom:solid 1px #dd7300;padding:10px 0;float:left;width:100%">
												<p style="font-size:14px; line-height:16px; margin:0;font-weight:600;"><b>Hello  '.$Rows['vchFirst_Name'].',</b></p><br />
												
												<p style="font-size:14px; line-height:16px; margin:0;"><b>New Password: '.$newpass.' </b></p><br />
											
												
											</div>
										
											
										</div>
										</td>
									</tr>
									<tr>
										<td bgcolor="#EAEAEA" align="center" style="background:#EAEAEA; text-align:center; padding:15px 0"><center><p style="font-size:12px; margin:0;">Thank you again From, <strong> Freelance Let Start Work.</strong></strong></p></center></td>
									</tr>
								</table>
							</td>
						</tr>
						</table>
					</div>
				</body>

				</html>';
				
				
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: rohit@rrtechnosolutions.in' . "\r\n";
	$sendmailprojecr =  mail($HirerUserto, $subject, $message, $headers);
			
		}
	$flag=1;
	}
	else{
		$flag=2;
	}
	
	}

function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
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

<title>Freelance</title>

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

<div class="login_details">

    <div class="container">

	<form action=""  name="form_login" method="post" id="my_form" novalidate >

      <div class="row">

        <div class="col-md-6 col-md-offset-3">

                <div class="col-lg-12">

				

                  <div class="register">

                    <h1 style="text-align:center;">Reset Your Password</h1>

                  </div>

                </div>

				

                <div class="col-lg-12">

				<?php if(isset($flag) && $flag=='2') { ?>

				<div class="alert alert-danger">

				<strong>Sorry </strong> Your account is not Valid.

				</div>

				<?php } ?>

				

				<?php if(isset($flag) && $flag=='1') { ?>

				<div class="alert alert-success">

				<strong>Successfully Mail Sent!. </strong> Check Your Inbox.

				</div>

				<?php } ?>

				

                  <div class="form-group login_bg">

                    <input type="text" name="User_email" id="User_email" tabindex="1" class="form-control" placeholder="Email" value="" required="true">

                  </div>

                  
                </div>

                <div class="col-lg-12">

                  <div class="form-group text-left" style="margin:0px;">

                    <div class="row">

                      <div class="col-sm-3">

                        <input type="submit" name="reset-submit" id="reset-submit" tabindex="4" class="form-control btn btn-primary" value="Submit">

                      </div>

                    </div>

                  </div>

                </div>

      </div>

    </div>

	

</form>	

  </div>

  </div>

  <!------------------------->

  </div>

  <!--------------->

  <?php include_once("includes/footer.php");?>

  

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script type="text/javascript">

$(document).ready( function()



    {//simple validation at client's end

	

    $( "#my_form" ).submit(function( event ){ //on form submit       

        var proceed = true;

        //loop through each field and we simply change border color to red for invalid fields       

        $("#my_form input[required=true], #my_form textarea[required=true] ,#my_form select[required=true],#my_form radio[required=true],#my_form file[required=true]").each(function(){

                $(this).css('border-color',''); 

                if(!$.trim($(this).val())){ //if this field is empty 

                    $(this).css('border-color','red'); //change border color to red   

                   proceed = false; //set do not proceed flag

                }

                //check invalid email

                var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 

                if($(this).attr("type")=="email" && !email_reg.test($.trim($(this).val()))){

                    $(this).css('border-color','red'); //change border color to red   

                    proceed = false; //set do not proceed flag            

                } 

				

							

				

        });

        

        if(proceed){ //if form is valid submit form

           

			return true;

			

			

        }

        event.preventDefault(); 

    });

    

     //reset previously set border colors and hide all message on .keyup()

    $("#my_form input[required=true], #my_form textarea[required=true]").keyup(function() { 

        $(this).css('border-color',''); 

        $("#result").slideUp();

    });

	

	

	

	

});

</script>

</div>

</div>

</body>

</html>

