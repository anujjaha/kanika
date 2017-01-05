<?php 
include('connection.php');

if(isset($_POST['submit']))
{

$userName = $notifyMe = '';
if(isset($_POST['notifiyme']))
{
	$notifyMe = implode(",", $_POST['notifiyme']);
}

if(isset($_POST['username']))
{
	$userName = $_POST['username'];
}

$SQl ="select *  from tbl_user where  vchEmail='".$_POST['Email']."'";
$Result  = mysql_query($SQl);
$row_n = mysql_num_rows($Result);
if($row_n > 0)
{
	$flag=77;
}
else{
	$currentdata = date('Y-m-d H:i:s');
$defaultimg="defaultprofilepic.png";
$insert="insert into tbl_user set vchFirst_Name='".$_POST['firstname']."',vchLast_Name='".$_POST['lastname']."',vchEmail='".$_POST['Email']."',vchCountry='".$_POST['country']."',vchZip_Code='".$_POST['Zip']."',vchStreet='".$_POST['Street']."',vchCity='".$_POST['City']."',vchState='".$_POST['State']."',vchPhone_Number='".$_POST['PhoneNo']."',vchUser_Name='".$userName."',vchpassword='".md5($_POST['Password'])."',vchDate='".$currentdata."',job_notification='".$notifyMe."',vchUserImage='".$defaultimg."'";

$result = mysql_query($insert);
$last_id = mysql_insert_id();
if($result)
{
	$checkBox = $_POST['job_Skill'];
		for ($i=0; $i<sizeof($checkBox); $i++)
        {
            $query="INSERT INTO tbl_user_skill (intUserId,intSkillID) VALUES ('".$last_id."','" . $checkBox[$i] . "')";     
			mysql_query($query) or die (mysql_error() );
        }
		
	
	
	$verificationId = base64_encode($last_id);
	
	$link ="http://rrtechnosolutions.in/freelance/thanks.php?verificationid=".$verificationId;
	
	session_start();
	$_SESSION['user_id'] = $last_id;
	
	$emailto = $_POST['Email'];
    $to = $emailto;
    $subject = "Verification Link Please Verify";
    $message = '<html>
				<head>
				<title>Verification Mail</title>
				</head>
				<body>
					<div style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
						<table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
						<tr>
							<td align="center" valign="top" style="padding:20px 0 20px 0">
								
								<table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #E0E0E0;">
									<tr style="background-color:#ee8b14;">
										<td valign="top"><img src="http://rrtechnosolutions.in/freelance/images/profile1.png" alt="Logo" style="margin-bottom:10px;" border="0"/></td>
									</tr>
								
									<tr>
										<td valign="top">
											<p style="font-size:14px; line-height:16px; margin:0;font-weight:bold;">Hello '.$_POST['firstname'].' '.$_POST['lastname'].',</p><br />
											
											<p> <img src="http://rrtechnosolutions.in/freelance/images/thnx.jpg" alt="Logo" width="40%"></p>
											

											<p style="font-size:14px; line-height:16px; margin:0;">For Registering with Freelance, you must verify your account: <b> <br/><br/> <a href="'.$link.'">Please Click Here To Verify </a> </b> </p> <br />        
											<p style="font-size:14px; line-height:16px; margin:0;">We are excited to have you with us!</p><br />
										</td>
									</tr>
									<tr>
										<td bgcolor="#EAEAEA" align="center" style="background:#EAEAEA; text-align:center;"><center><p style="font-size:12px; margin:0;">Thank you again From, <strong> Freelance to being with us.</strong></strong></p></center></td>
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
	// More headers
	//$headers .= 'From: <webmaster@example.com>' . "\r\n";
    
	$headers .= 'From: rohit@rrtechnosolutions.in' . "\r\n";

   $sendmail =  mail($to, $subject, $message, $headers);

    //echo 'Email Sent Check Your Mail Box For Verification & Click to Verify.';
	if($sendmail)
	{
		 $msg= 2;
	}
	header('location:thanks-registration.php');
	exit();
}
}

}
$Sql_skill ="SELECT * FROM tbl_skill";
	$Result_skill = mysql_query($Sql_skill);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Freelance - Registration</title>
<?php include_once("includes/common-links.php");?>
</head>
<body>
<div class="page">
<div id="wrapper">
  <!------------------>
  <div id="content">
  <!------------------>
  <?php include_once("includes/header1.php");?>
	<link rel="stylesheet" href="http://harvesthq.github.io/chosen/chosen.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
	<script src="http://harvesthq.github.io/chosen/chosen.jquery.js" type="text/javascript"></script>
  <!---------------1----------->
  <form action="" method="post" id="my_form" novalidate   enctype="multipart/form-data">
	<div class="reg1">
	
		
	
		<div class="container">
		  <div class="row">
		  
			<div class="col-lg-12">
			  <div class="reg_border">
					<div class="col-lg-12">
					
					  <div class="register">
					  
						<h2> REGISTRATION </h2>
						<?php if(isset($flag) && $flag==77) {  ?>
		<div class="alert alert-danger">
			Email Already Exists ! Please Use Alternate Email.
		</div>
	  <?php  } ?>
					  </div>
					</div>
					<div class="col-lg-6 confirm_line">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="confirm">
						  <label>First Name</label>
						</div>
					  </div>
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<div class="confirm1">
						  <input name="firstname" id="firstname" type="text" required="true"  placeholder="please enter first name"/>
						</div>
					  </div>
					</div>
					<div class="col-lg-6 confirm_line">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="confirm">
						  <label> Last Name</label>
						</div>
					  </div>
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<div class="confirm1">
						  <input name="lastname" id="lastname" type="text" required="true"  placeholder="please enter last name" />
						</div>
					  </div>
					</div>
					<div class="col-lg-6 confirm_line">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="confirm">
						  <label>Email</label>
						</div>
					  </div>
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<div class="confirm1">
						  <input name="Email" id="Email" type="text" required="true"  placeholder="please enter email" />
						</div>
					  </div>
					</div>
					<div class="col-lg-6 confirm_line">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="confirm">
						  <label>Street</label>
						</div>
					  </div>
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<div class="confirm1">
						  <input name="Street" id="Street" type="text" required="true"  placeholder="please enter street" />
						</div>
					  </div>
					</div>			
					<div class="col-lg-6 confirm_line">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="confirm">
						  <label>City</label>
						</div>
					  </div>
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<div class="confirm1">
						  <input name="City" id="City" type="text" required="true"  placeholder="please enter city" />
						</div>
					  </div>
					</div>
					<div class="col-lg-6 confirm_line">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="confirm">
						  <label>State</label>
						</div>
					  </div>
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<div class="confirm1">
						  <input name="State" id="State" type="text" required="true"  placeholder="please enter state" />
						</div>
					  </div>
					</div>
					<div class="col-lg-6 confirm_line">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="confirm">
						  <label>Country</label>
						</div>
					  </div>
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<div class="confirm1">
						  <select name="country" required="true">
							<option value="usa">Usa</option>
							<option value="Australia">Australia</option>
							<option value="Canada">Canada</option>
							<option value="Thailand">Thailand</option>
						  </select>
						</div>
					  </div>
					</div>
					<div class="col-lg-6 confirm_line">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="confirm">
						  <label>Skills</label>
						</div>
					  </div>
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<div class="confirm1">
						  <select data-placeholder="please enter job skill" class="chosen-select" multiple  name="job_Skill[]"  id="job_Skill" required="true">
								<?php while($Row_skill = mysql_fetch_array($Result_skill)) { ?>
									<option value="<?php echo $Row_skill['intSkillId'];?>"> <?php echo $Row_skill['vchSkillName'];?> </option>
								<?php }?>
								</select>
								<script type="text/javascript">
								$(function(){
								$(".chosen-select").chosen();
								});
								</script>
						</div>
					  </div>
					</div>
					<div class="col-lg-6 confirm_line">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="confirm">
						  <label>Phone No</label>
						</div>
					  </div>
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<div class="confirm1">
						  <input name="PhoneNo" id="PhoneNo" type="text" required="true" placeholder="please enter phone no " />
						</div>
					  </div>
					</div>
					<div class="col-lg-6 confirm_line">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="confirm">
						  <label>Password</label>
						</div>
					  </div>
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<div class="confirm1">
						  <input name="Password" id="Password" type="Password" required="true"  placeholder="please enter password"/>
						</div>
					  </div>
					</div>
					<div class="col-lg-6 confirm_line">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="confirm">
						  <label>Zip</label>
						</div>
					  </div>
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<div class="confirm1">
						  <input name="Zip" id="Zip" type="text"  required="true"  placeholder="please enter zip code" />
						</div>
					  </div>
					</div>
					
					<div class="col-lg-6 confirm_line">
					  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="confirm">
						  <label>Notify me When Job Posted in Categories: </label>
						</div>
					  </div>
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<div class="confirm1">
							<select name="notifiyme[]" id="notifiyme" multiple>
							<?php
								$Sql_category = "select * from tbl_category";
								$Result_category = mysql_query($Sql_category);
								while($row_category = mysql_fetch_array($Result_category))
								{ 
							?>
								<option name="catSearch" class="catSearch"value="<?php echo $row_category['intCategoryID']; ?>">
									<?php echo $row_category['intCategoryName'];?>
								</option>
							<?php 
								} 
							?>
							</select>
						</div>
					  </div>
					</div>
					

					<div class="col-lg-12 confirm_line">
					  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
						<div class="confirm">
							<!-- <button type="button" class="btn btn-primary">Continue Registration</button> -->
							<input name="submit" id="submit" type="submit" value="Continue Registration" class="btn btn-primary" />
						</div>
					  </div>
					  </div>
					<!-------------------->
			  </div>
			</div>
		  </div>
		</div>
	   
	  <!------------------------->
	</div>
  </form>
  <!--------------->
  </div>
  <?php include_once("includes/footer.php");?>

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
</body>
</html>
