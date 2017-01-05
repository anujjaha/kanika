<?php 
include('connection.php');
if(isset($_POST['login-submit']))
{
	$Sql = "select intUserID,AccountStatus,job_notification from tbl_user where vchEmail='".$_POST['User_email']."' AND vchpassword='".md5($_POST['passd'])."'";
	$Result = mysql_query($Sql);
	$Rows = mysql_fetch_array($Result);
	$Num_rows = mysql_num_rows($Result);
	if($Num_rows > 0)
		{
			if($Rows['AccountStatus']=='1')
			{
				session_start();
        $_SESSION['user_id'] = $Rows['intUserID'];
        $_SESSION['user_job_notification'] = $Rows['job_notification'];
				header('location:dashboard.php');
			}	
			else 
			{
				$flag =2;
			}
			
		}
		else
		{
			$flag =1;
			
		}
	

	
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
                    <h1 style="text-align:center;">Sign in </h1>
                  </div>
                </div>
				
                <div class="col-lg-12">
				<?php if(isset($flag) && $flag=='2') { ?>
				<div class="alert alert-danger">
				<strong>Sorry </strong> Your account is not Activated.
				</div>
				<?php } ?>
				
				<?php if(isset($flag) && $flag=='1') { ?>
				<div class="alert alert-danger">
				<strong>Invaild </strong>Username and Password not correct.
				</div>
				<?php } ?>
				
                  <div class="form-group login_bg">
                    <input type="text" name="User_email" id="User_email" tabindex="1" class="form-control" placeholder="Email" value="" required="true">
                  </div>
                  <div class="form-group login_bg">
                    <input type="password" name="passd" id="passd" tabindex="2" class="form-control" placeholder="Password" required="true" >
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group text-left">
                    <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                    <label for="remember"> Remember Me</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group text-right">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="text-right"> <a href="registration.php" class="newuser">New User?</a> | <a href="reset.php" class="">Reset Password?</a> </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group text-left" style="margin:0px;">
                    <div class="row">
                      <div class="col-sm-3">
                        <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-primary" value="Log In">
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
