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
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="http://www.jqueryscript.net/demo/jQuery-Plugin-For-Multiple-Select-With-Checkboxes-multi-select-js/style.css">
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
  <!------------------>
  <div id="content">
<!------------------>
<?php include_once("includes/header-inner.php");?>
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
	
	
	
	$target_dir = "upload-attachment/";
	$fileToUploadName = rand().time().'-'.$_FILES["fileToUpload"]["name"];
	$target_file = $target_dir . $fileToUploadName;
	move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
	
	 $insert="insert into tbl_job_post set vchJobPostTitle='".$_POST['jobtitle']."',intJobPostUserId='".$_SESSION['user_id']."',vchJobPostDescription='".addslashes($_POST['job_post_desc'])."',vchJobPostZipCode='".$_POST['job_zip_code']."',vchJobPostTokenMoney='".$_POST['job_Tokens']."',VchJobPostDate='".$currentdata."',vchJobWorkType='".$_POST['work_type']."',vchJobSkill='".$_POST['job_Skill']."',vchJobPostBudget='".$JobPostPrice."',vchJobPostPrice='".$JobPostPrice."',vchJobPostAttachment='".$_FILES["fileToUpload"]["name"]."'";
	
	$result = mysql_query($insert);
	if($result)
	{
		$flag = 1;
	}

}
?>
<!---------------1----------->
<div class="reg1">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
	  
	  
	 
	  
	  
	  <?php if(isset($flag) && $flag==1) {  ?>
	  <div class="alert alert-success">
  Your job has been add successfully
</div>
	  <?php  } ?>
	   <form action="" method="post" id="my_form1" novalidate   enctype="multipart/form-data">

        <div class="reg_border">
          <div class="col-lg-12">
            <div class="register">
              <h2> ADD JOB POST </h2>
            </div>
          </div>
		  
		   <div class="col-lg-6 confirm_line">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="confirm">
                <label> What Type Of Work Do you require</label>
              </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <div class="confirm1">
                <select name="work_type"  id="work_type" multiple >
				<option value="Websites IT & Software"> Websites IT & Software</option>
				<option value="Mobile"> Mobile</option>
				<option value="Design"> Design</option>
				<option value="Design"> Design</option>
				<option value="Data Entry"> Data Entry</option>
				</select>
              </div>
			  
			</div>
			
          </div>
		  
          <div class="col-lg-6 confirm_line">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="confirm">
                <label>Job Title</label>
              </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <div class="confirm1">
                <input name="jobtitle" id="jobtitle" type="text"  placeholder="please enter job title" required="true" />
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
                <input name="job_zip_code" id="job_zip_code" type="text" placeholder="please enter job zip code"  required="true" />
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
                <input name="job_Skill" id="job_Skill" type="text" placeholder="please enter job skill"  required="true" />
              </div>
            </div>
          </div>
		  
          <div class="col-lg-6 confirm_line" style="display:none">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="confirm">
                <label> Tokens</label>
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
              
			    
				<input type="radio" name="jobprice"  value="SetFixedPrice" class="jobprice" id="SetFixedPrice" >Set Fixed Price
				<input type="radio" name="jobprice"  value="SetAnHourlyRate" class="jobprice" id="SetAnHourlyRate">Set An Hourly Rate
			</div>
			 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"  id="SetFixedPrice_inner" style="display:none">
             
                <input name="job_code_USD" id="job_code_USD" type="text"  value="USD" readonly />
                <select name="work_type_fixed"  id="work_type_fixed">
				<option value="">select price</option>
					<option value="10-30">($10-30 USD)</option>
					<option value="250-750">($250-750 USD)</option>
				</select>
              
            </div>
			
			 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"  id="SetAnHourlyRate_inner" style="display:none">
             
                <input name="job_code_USD" id="job_code_USD" type="text"  value="USD" readonly />
                <select name="work_type_hours"  id="work_type_hours">
				<option value="">select hours</option>
					<option value="5-10">$5-10USD</option>
					<option value="10-15">$10- 15USD</option>
					<option value="15-20">$15- 20USD</option>
					<option value="20-25">$20- 25USD</option>
					
				</select>
              
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
				 <script type="text/javascript">CKEDITOR.replace( 'job_post_desc' );</script>
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
					    <span class="btn btn-default btn-file btn btn-success open-bt">
								Browse <input type="file" name="fileToUpload" id="fileToUpload">
						</span>
				  </div>
            </div>
          </div>
			  <div class="col-lg-6 confirm_line">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				  <div class="confirm">
					<!-- <button type="button" class="btn btn-primary">Continue Registration</button> -->
					<input name="submit" id="submit" type="submit" value="Post Job" class="btn btn-primary" />
				  </div>
				</div>
			  </div>
        </div>
		</form>
        <!-------------------->
        <!-------------------->
      </div>
    </div>
  </div>
</div>
<!--------------->
<?php include_once("includes/footer.php");?>
<!-------------------->
</div>
<!------------>
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
	
	$( ".jobprice" ).change(function() {
		var jobprice = $(this).val();
		//alert(jobprice);
		if(jobprice=='SetFixedPrice')
		{
			
			$('#SetFixedPrice_inner').css('display','block');
			$('#SetAnHourlyRate_inner').css('display','none');
			return false;
		}else{
			
			$('#SetFixedPrice_inner').css('display','none');
			$('#SetAnHourlyRate_inner').css('display','block');
			return false;
		}
		
	});
	
	/*$( "#SetAnHourlyRate" ).click(function() {
		$('#SetAnHourlyRate_inner').css('display','block');
		$('#SetFixedPrice_inner').css('display','none');
		return false;
	});*/
	
});
</script>

<script type="text/javascript" src="http://www.jqueryscript.net/demo/jQuery-Plugin-For-Multiple-Select-With-Checkboxes-multi-select-js/src/jquery.multi-select.js"></script>
    <script type="text/javascript">
    $(function(){
        $('#work_type').multiSelect();
    });
    </script>
    </script>
  
<!--------------------->
<!--------------->
</div>
</div>
</body>
</html>
