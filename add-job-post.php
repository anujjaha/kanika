<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Add Job Post</title>

<?php include_once("includes/common-links.php");?>
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<style>
    .btn-file {
        position: relative;
        overflow: hidden;
		width:50%;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
</style>
</head>
<body>
<div class="page">
<div id="wrapper">
  <div id="content">
<?php include_once("includes/header-inner.php");?>
<link rel="stylesheet" href="http://harvesthq.github.io/chosen/chosen.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js" type="text/javascript"></script>
<?php 
include('connection.php');
if(isset($_POST['submit']))
{
	if(isset($_POST['work_type_fixed']) && $_POST['work_type_fixed']!='' )
	{
		$JobPostPrice = $_POST['work_type_fixed'];
	}
	else{
		$JobPostPrice = $_POST['work_type_hours'];
	}
	$currentdata = date('Y-m-d H:i:s');
	$vchExpiredDate = date('Y-m-d', strtotime("+7 days"));
		
	$insert="insert into tbl_job_post set vchJobPostTitle='".$_POST['jobtitle']."',intJobPostUserId='".$_SESSION['user_id']."',vchJobPostDescription='".addslashes($_POST['job_post_desc'])."',vchJobPostTokenMoney='".$_POST['job_Tokens']."',VchJobPostDate='".$currentdata."',vchJobWorkType='".$_POST['work_type']."',vchJobWorkSubType='".$_POST['sub_category']."',vchJobPostBudget='".$JobPostPrice."',vchJobPostPrice='".$JobPostPrice."',bidpricetype='".$_POST['jobprice']."',vchExpiredDate='".$vchExpiredDate."'";
	
	$result = mysql_query($insert);
	$last_id = mysql_insert_id();
	
	if($result)
	{
		$checkBox = $_POST['job_Skill'];
		for ($i=0; $i<sizeof($checkBox); $i++)
        {
            $query="INSERT INTO tbl_job_post_skill (intJobPostId,intSkillID) VALUES ('".$last_id."','" . $checkBox[$i] . "')";     
			mysql_query($query) or die (mysql_error() );
        }
		
		$multiZip = $_POST['job_zip_code'];
		$new_zip_id =  implode("','",$multiZip);
		
		
		for ($i=0; $i<sizeof($multiZip); $i++)
        {
            $MultiZipquery="INSERT INTO tbl_job_post_multizipcode (intProjectId,intUserId,intMultizipCode) VALUES ('".$last_id."','".$_SESSION['user_id']."','" . $multiZip[$i] . "')";     
			mysql_query($MultiZipquery) or die (mysql_error() );
        }
		
		$multipleAttachement = $_FILES["fileToUpload"]["name"];
		$multipleAttachementtemp = $_FILES["fileToUpload"]["tmp_name"];
		for ($j=0; $j<sizeof($multipleAttachement); $j++)
        {
			$target_dir = "upload-attachment/";
			$fileToUploadName = rand().time().'-'.$multipleAttachement[$j];
			$target_file = $target_dir . $fileToUploadName;
			move_uploaded_file($multipleAttachementtemp[$j], $target_file);
			
            $query="INSERT INTO tbl_attachments (intJobPostId,vchAttachmentName) VALUES ('".$last_id."','" . $fileToUploadName . "')";     
			mysql_query($query) or die (mysql_error() );
        }
		
		$Sql_Get_Zip_code ="SELECT * FROM tbl_user WHERE vchZip_Code IN ('".$new_zip_id."')";
		$Result_Zip_Code = mysql_query($Sql_Get_Zip_code);
		while($Row_Zip_Code = mysql_fetch_array($Result_Zip_Code))
		{
		   /*********** mail template for user *************/
			$HirerUserto = $Row_Zip_Code['vchEmail'];
			$subject = "New Job Posted";
			$message = '<html>
				<head>
				<title> Notification New Project POSTED</title>
				</head>
				<body>
					<div style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
						<table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
						<tr>
							<td align="center" valign="top" style="padding:20px 0 20px 0">
								
								<table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #E0E0E0;">
									<tr style="background-color:#ee8b14;">
										<td valign="top" style="text-align:center;font-size:20px;font-weight:600;color:#fff;padding:10px 0;"> Congratulations! '.$Row_Zip_Code['vchFirst_Name'].'</td>
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
												<p style="font-size:14px; line-height:16px; margin:0;font-weight:600;"><b>Hello  '.$Row_Zip_Code['vchFirst_Name'].',</b></p><br />
												
												<p style="font-size:14px; line-height:16px; margin:0;"><b>Project Name: '.$_POST['jobtitle'].' </b></p><br />
											
												
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
			/********** end here ****************************/
	}
	
	$flag = 1;
	}

}

$Sql_skill ="SELECT * FROM tbl_skill";
$Result_skill = mysql_query($Sql_skill);

?>

<div class="reg1">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
	  
	   <form action="" method="post" id="my_form" novalidate   enctype="multipart/form-data" onsubmit="return validateForm();">

        <div class="reg_border">
          <div class="col-lg-12">
            <div class="register">
              <h2> ADD JOB POST </h2>
			  <?php 
			 	if(isset($flag) && $flag == 1) 
			 	{  
			 ?>
				<div class="alert alert-success">
					Your job has been add successfully
			</div>
			<?php  } ?>
            </div>
          </div>
		</div>
		</div>

		<div class="col-md-12">
			<div class="row">
			   <div class="col-lg-6 confirm_line">
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	              <div class="confirm">
	                <label> What Type Of Work Do you require</label>
	              </div>
	            </div>
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
					<div class="confirm1">
						<select name="work_type"  onchange="resetSubCategories()"  id="work_type">
						<option value="0"> Select Category </option>
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
				<div class="col-lg-6 confirm_line">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					  <div class="confirm">
					    <label>Sub Category</label>
					  </div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
					  <div class="confirm1">
					    <select id="subCategories" name="sub_category">
					    	<option>Select Sub Category</option>
					    </select>
					  </div>
					</div>
				</div>
		  
	          	<div class="col-lg-6">
		            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		              <div class="confirm">
		                <label>Job Title *</label>
		              </div>
		            </div>
		            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		              <div class="confirm1">
		                <input name="jobtitle" id="jobtitle" type="text"  placeholder="please enter job title" required="required" />
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
	              	<div class="input_fields_wrap">
						<div>
							<div class="confirm1">
								<input name="job_zip_code[]" id="job_zip_code" type="text" placeholder="please enter job zip code"  required="true" />
							</div>
						</div>
						<button class="add_field_button">Add More</button>
					</div>
	              </div>
	            </div>
	          </div>
		  
			   <div class="col-lg-6 confirm_line">
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	              <div class="confirm">
	                <label>Skill</label>
	              </div>
	            </div>
	            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
	              <div class="confirm1">
					<select data-placeholder="please enter job skill" style="height: 80px;" class="chosen-select" multiple  name="job_Skill[]"  id="job_Skill" required="true">
						<?php 
							while($Row_skill = mysql_fetch_array($Result_skill))
							{
						?>
							<option value="<?php echo $Row_skill['intSkillId'];?>">
								<?php echo $Row_skill['vchSkillName'];?>
							</option>
						<?php } ?>
					</select>
					</div>
					<script type="text/javascript">
						$(function()
						{
							$(".chosen-select").chosen();
						});
					</script>
	              </div>
	            </div>
          
	          <div class="col-lg-6 confirm_line" style="display:none">
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	              <div class="confirm">
	                <label>Tokens</label>
	              </div>
	            </div>
	            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
	              <div class="confirm1">
	                <input name="job_Tokens" id="job_Tokens" type="text" placeholder="please enter job token required" required="true"  value="5" readonly />
	              </div>
	            </div>
	          </div>
		  	<div class="col-lg-6 confirm_line" >
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="confirm">
                <label> What budget do you have in mind ?</label>
              </div>
            </div>
           
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" id="dddd">
              	<input type="radio" name="jobprice" checked="checked"  value="Fixed Price" class="jobprice" id="SetFixedPrice" required="true" />Set Fixed Price
				<input type="radio" name="jobprice"  value="Hourly Rate" class="jobprice" id="SetAnHourlyRate"required="true" />Set An Hourly Rate
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"  id="SetFixedPrice_inner" style="display:none">
             	<input name="job_code_USD" id="job_code_USD" type="text"  value="USD" readonly />
				<input name="work_type_fixed"  id="work_type_fixed" type="text" placeholder="$ Enter Amount" />
            </div>
			
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"  id="SetAnHourlyRate_inner" style="display:none">
            	<input name="job_code_USD" id="job_code_USD" type="text"  value="USD" readonly />
				<input name="work_type_hours"  id="work_type_hours" type="text" placeholder="$ Enter Amount" />
            </div>
          </div>
		  </div>
		 </div>
		  <div class="col-lg-12 confirm_line">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
              <div class="confirm">
                <label> Job Description</label>
              </div>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
              <div class="confirm1">
                <textarea rows="10" cols="80" name="job_post_desc" id="job_post_desc" required="true" placeholder="please enter job description"></textarea> 
				<script type="text/javascript">
				 	CKEDITOR.replace( 'job_post_desc' );
				</script>
              </div>
            </div>
          </div>
		  	
		 	<div class="col-lg-6 confirm_line" style="display:block">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				  <div class="confirm">
					<label> Attachment File</label>
				  </div>
				</div>
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				  <div class="confirm1">
					    <span class="  open-bt">
								Browse <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
						</span>
				  </div>
            </div>
         	</div>
			<div class="col-lg-6 confirm_line">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				  <div class="confirm">
					<input name="submit" id="submit" type="submit" value="Post Job" class="btn btn-primary" />
				  </div>
				</div>
			  </div>
        </div>
		</form>
    </div>
    </div>
  
<?php
	include_once("includes/footer.php");
?>
</div>

<script type="text/javascript">
function resetSubCategories()
{
	var categoryId = jQuery("#work_type").val();

	if(categoryId == 0)
	{
		return true;
	}

	$.ajax({
		url: "ajax.php?requestType=getChildCategories",
		method: "GET",
		dataType: 'JSON',
		data: {
			'category_id': categoryId
		},
		success: function(data)
		{
			if(data.status == true)
			{	
				jQuery("#subCategories").empty();

				$.each(data.response, function(index, element)
				{
					jQuery("#subCategories").append("<option value=" +element.id+ "> " + element.title + "</option>");
				});
			}
		},
		error: function(data)
		{
			console.log("Error");
		}
	});
}

$(document).ready( function()
{
	$( "#my_form" ).submit(function( event )
	{
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
				
				
					var editor_val = CKEDITOR.instances.job_post_desc.document.getBody().getChild(0).getText() ;
					if(!$.trim(editor_val)){
						$('#cke_job_post_desc').css('border-color','red');
						proceed = false;
					}
						var isChecked = $("input[name=jobprice]:checked").val();
						if(!isChecked){
							 //alert('Nothing Selected');
							 $('[name="jobprice"]').css('outline','1px solid red');
							 $('[name="jobprice"]').focus();
							 proceed = false;
						 }else{
							 if(isChecked=='SetFixedPrice')
							 {
								var work_type_fixed = $('#work_type_fixed').val();
								//alert(work_type_hours);
								if (work_type_fixed=='')
								{
								$('#work_type_fixed').css('border-color','red');
								proceed = false;
								}
								 
							 }
							 if(isChecked=='SetAnHourlyRate')
							 {
								var work_type_hours = $('#work_type_hours').val();
								//alert(work_type_hours);
								if (work_type_hours=='')
								{
								$('#work_type_hours').css('border-color','red');
								proceed = false;
								}
								 
							 }
						 }
						var job_Skill = $('.chosen-select').val();
						//alert(job_Skill);
						
						if (job_Skill==null)
						{
							$('.chosen-choices').css('border-color','red');
							proceed = false;
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
	
	$('[name="jobprice"]').change(function() { 
       $('[name="jobprice"]').css('outline','');
        $("#result").slideUp();
    });

	$( ".jobprice" ).change(function() {
		var jobprice = $(this).val();
		//alert(jobprice);
		if(jobprice=='Fixed Price')
		{
			
			$('#SetFixedPrice_inner').css('display','block');
			$('#SetAnHourlyRate_inner').css('display','none');
			$('#work_type_hours').css('border-color','');
			return false;
		}else{
			
			$('#SetFixedPrice_inner').css('display','none');
			$('#SetAnHourlyRate_inner').css('display','block');
			$('#work_type_fixed').css('border-color','');
			return false;
		}
		
	});
});


function validateForm()
{
	if(jQuery("#jobtitle").val().length < 1 )
	{
		jQuery("#jobtitle").focus();	
		return false;
	}


	if(jQuery("#job_zip_code").val().length < 1 )
	{
		jQuery("#job_zip_code").focus();	
		return false;
	}
}
</script>

<script>
/*
$(document).ready(function() 
{
    var max_fields      = 5; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<br><div><input type="text" name="job_zip_code[]" id="job_zip_code"><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});*/
</script>