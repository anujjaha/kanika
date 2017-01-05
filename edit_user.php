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
  <div id="content" style="background:#f2f2f2;margin:0!important;">
  <!------------------>
  <?php 
  ob_start();
  
  include_once("includes/header-inner.php"); 
  
  $userid=$_GET['id'];
  $select="select * from tbl_user where intUserID='".$_GET['id']."'";

  $result=mysql_query($select);
  $row=mysql_fetch_assoc($result);
  

if(isset($_POST['submit']))
{
	if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
	{
		
		$file_name = $_FILES['image']['name'];
		$upload_path='images/'.$file_name;
		move_uploaded_file($_FILES['image']['tmp_name'],$upload_path);
	}
	else
	{
	  $file_name = $_POST['oldimage'];
	}

$notifyMe = '';
if(isset($_POST['notifiyme']))
{
  $notifyMe = implode(",", $_POST['notifiyme']);
}


if(isset($_POST['Password']) && $_POST['Password']!='')
	{
		$update="update tbl_user set vchFirst_Name='".$_POST['firstname']."',job_notification='".$notifyMe."',vchLast_Name='".$_POST['lastname']."',vchZip_Code='".$_POST['zipcode']."',vchDescription='".$_POST['Aboutyou']."',vchStreet='".$_POST['street']."',vchCity='".$_POST['city']."',vchState='".$_POST['state']."',vchPhone_Number='".$_POST['PhoneNo']."',vchpassword='".md5($_POST['Password'])."',vchUserImage='".$file_name."' where intUserID='".$_GET['id']."'";
		$result=mysql_query($update);
		header('location:dashboard.php');
	}
	else
	{
		$update="update tbl_user set vchFirst_Name='".$_POST['firstname']."',job_notification='".$notifyMe."',vchLast_Name='".$_POST['lastname']."',vchZip_Code='".$_POST['zipcode']."',vchDescription='".addslashes($_POST['Aboutyou'])."',vchStreet='".$_POST['street']."',vchCity='".$_POST['city']."',vchState='".$_POST['state']."',vchPhone_Number='".$_POST['PhoneNo']."',vchUserImage='".$file_name."' where intUserID='".$_GET['id']."'";
		$result=mysql_query($update);
		header('location:dashboard.php');
	}


}
   ?>
  <!---------------1----------->
  <form action="" method="post" id="my_form" novalidate   enctype="multipart/form-data">
<div class="reg1">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
  <div class="reg_border">
  <div class="col-lg-12">
          <div class="register">
            <h2> UPDATE PROFILE </h2>
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
              <input name="firstname" id="firstname" type="text" required="true" value="<?php echo $row['vchFirst_Name'];?>"/>
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
              <input name="lastname" id="lastname" type="text" required="true"  value="<?php echo $row['vchLast_Name'];?>"/>
            </div>
          </div>
        </div>
		<div class="col-lg-6 confirm_line">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="confirm">
              <label> Zip Code</label>
            </div>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="confirm1">
              <input name="zipcode" id="zipcode" type="text" value="<?php echo $row['vchZip_Code'];?>"/>
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
              <input name="street" id="street" type="text" required="true" value="<?php echo $row['vchStreet'];?>" />
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
              <input name="city" id="city" type="text" required="true" value="<?php echo $row['vchCity'];?>" />
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
              <input name="state" id="state" type="text" required="true" value="<?php echo $row['vchState'];?>" />
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
              <input name="PhoneNo" id="PhoneNo" type="text" value="<?php echo $row['vchPhone_Number'];?>" />
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
              <input name="Password" id="Password" type="Password"  value=""/>
            </div>
          </div>
        </div>
		
		<div class="col-lg-12 confirm_line">
			<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
				<div class="confirm">
					<label>About Yourself</label>
				</div>
			</div>
			<div class="col-lg-10 col-md-8 col-sm-8 col-xs-12">
				<div class="confirm1">
					<textarea name="Aboutyou" id="Aboutyou" style="width:100%;height:100px;"><?php echo stripslashes($row['vchDescription']);?></textarea>
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
              <select name="notifiyme[]" id="notifiyme" multiple class="form-control" style="height: 80px;">
              <?php
                $jobNotification = array();
                
                if(isset($row['job_notification']))
                {
                  $jobNotification = explode(",", $row['job_notification']);
                }
                
                $Sql_category = "select * from tbl_category";
                $Result_category = mysql_query($Sql_category);
                while($row_category = mysql_fetch_array($Result_category))
                { 
                  $selected = "";

                  if(in_array( $row_category['intCategoryID'], $jobNotification))
                  {
                    $selected = "selected='selected'";
                  }
              ?>
                <option name="catSearch" <?php echo $selected;?> class="catSearch"value="<?php echo $row_category['intCategoryID']; ?>">
                  <?php echo $row_category['intCategoryName'];?>
                </option>
              <?php 
                } 
              ?>
              </select>
            </div>
            </div>
          </div>

  <div class="col-lg-6 confirm_line">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="confirm">
              <label>Image</label>
            </div>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="confirm1">
              <input name="image" id="image" type="file"  />
                  <input name="oldimage" id="oldimage" type="hidden"  value="<?php echo $row['vchUserImage'];?>"/>
            </div>
          </div>
        </div>
	
				
    
	
	 <div class="col-lg-6 confirm_line">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="confirm">
       <!-- <button type="button" class="btn btn-primary">Continue Registration</button> -->
       <input name="submit" id="submit" type="submit" value="save changes" class="btn btn-primary" />
            </div>
          </div>
          </div>
        </div>
        <!-------------------->
        <!-------------------->
      </div>
    </div>
        </div>
    </div>
   
  <!------------------------->
  </form>
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
