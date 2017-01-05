<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>View Job</title>
<?php include_once("includes/common-links.php");?>
<style>
.open-bt {
  background-color: #449d44;
  color: #fff !important;
}
@import url(http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
.form-group {
	text-align:left;
	}
fieldset, label {
	margin: 0;
	padding: 0;
	}


.rating {
	border: none;
	float: right;
}
.rating > input {
	display: none;
}
.rating > label:before {
	margin: 5px;
	font-size: 1.25em;
	font-family: FontAwesome;
	display: inline-block;
	content: "\f005";
}
.rating > .half:before {
	content: "\f089";
	position: absolute;
}
.rating > label {
	color: #ddd;
	float: right;
}
 .rating > input:checked ~ label,  .rating:not(:checked) > label:hover,  .rating:not(:checked) > label:hover ~ label {
color: #FFD700;
}
 .rating > input:checked + label:hover,  .rating > input:checked ~ label:hover,  .rating > label:hover ~ input:checked ~ label,  .rating > input:checked ~ label:hover ~ label {
color: #FFED85;
}


</style>
</head>
<body>
<div class="page">
  <div id="wrapper">
  <!------------------>
  <div id="content">
  <?php include_once("includes/header-inner.php");?>
  <?php 
/********** select tbl_user**********/
include('connection.php');
if(isset($_POST['reviewSubmit']))
{
	//echo"<pre>";
	//print_r($_POST);
	//die();
	$currentdata = date('Y-m-d H:i:s');
	$insertrating="insert into tbl_review_rating set ratingProjectId='".$_POST['PrjID']."',ratingIdFrom='".$_SESSION['user_id']."',ratingIdTo='".$_POST['ReviewTO']."',ratingIdEmailgivenTo='".$_POST['usrEmailID']."',reviewMsg='".$_POST['textmsg']."',starRating='".$_POST['start_value']."',ratinggiventime='".$currentdata."'";
	//die();
	$reultnew = mysql_query($insertrating);
	if($reultnew)
	{
		$flag=9;
	}
	
}
// $Sql_jobview = "select tbl_user.*,tbl_job_post.*,tbl_job_post_bid.* from tbl_job_post_bid Left join tbl_job_post on tbl_job_post.intJobPostId = tbl_job_post_bid.intProjectId Left join tbl_user on tbl_user.intUserID = tbl_job_post_bid.intUserId where intProjectId='".$_GET['jobid']."'";
//die();
$Sql_jobview = "select * from tbl_job_post where  intJobPostId='".$_GET['jobid']."' order by intJobPostId desc";
$Result_jobview = mysql_query($Sql_jobview);
$Rows_jobview = mysql_fetch_array($Result_jobview);

$clientName= $Rows_jobview['vchFirst_Name']. $Rows_jobview['vchLast_Name'];
$userid=$_SESSION['user_id'];
$jobpost_id = $_GET['jobid'];

$Sql_jobtypecat = "select * from tbl_category where intCategoryID ='".$Rows_jobview['vchJobWorkType']."'";
$Result_jobtypecat = mysql_query($Sql_jobtypecat);
$Rows_jobtypecat = mysql_fetch_array($Result_jobtypecat);

$Sql_attachview = "select * from tbl_attachments where intJobPostId='".$jobpost_id."' order by intJobPostId desc";
$Result_attachview = mysql_query($Sql_attachview);

$Sql_jobpost_id ="select tbl_user.*,tbl_job_post.* from tbl_job_post
Left join tbl_user on tbl_user.intUserID = tbl_job_post.intJobPostUserId where intJobPostId='".$jobpost_id."'";
$Result_jobtypecat1 = mysql_query($Sql_jobpost_id);
$Rows_jobtypecat1 = mysql_fetch_array($Result_jobtypecat1);
//die();
$emailTO = $Rows_jobtypecat1['vchEmail'];
$FromidTO = $Rows_jobtypecat1['intUserID'];

$Sql_Review = "select * from tbl_review_rating where ratingIdTo='".$_SESSION['user_id']."' AND ratingProjectId='".$_GET['jobid']."'";
$Result_Review = mysql_query($Sql_Review);

?>
  <!---------------1----------->
  <div class="freelanceview">
    <div class="container">
      <div class="row">
        <!---------------->
        <div class="col-md-12">
          <?php include('left-side.php');?>
          <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
		  <?php if($flag==9) { ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-success">
				<strong>Thanks!</strong> For Review.
				</div>
			</div>
			<?php } ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
				<div class="view_job">
					<p style="text-align:right;"><a href="#" class="btn btn-warning" data-toggle="modal" data-target="#myReview" > Review for Client </a></p>
					<label>Job Name : <?php echo $Rows_jobview['vchJobPostTitle'];?> </label>
					<h6>Posted On: <?php echo $Rows_jobview['VchJobPostDate'];?></h6>
					<p>What Type Of Work Do you require: <?php echo $Rows_jobtypecat['intCategoryName'];?> </p>
					<p>Budget Quoted: $ <?php echo $Rows_jobview['vchJobPostBudget'];?> </p>
					<p>Payment: <?php echo $Rows_jobview['bidpricetype']; ?></p>
					<!-- <p>Skills: <?php echo $Rows_jobview['vchJobSkill'];?></p>
					<p>Zip Code: <?php echo $Rows_jobview['vchJobPostZipCode'];?></p> -->
					<p>Job Description: <br/> <?php echo $Rows_jobview['vchJobPostDescription'];?></p>
					
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="view_job">
				
					<p>Attachments: <br/> 
						<?php while($Rows_attachview = mysql_fetch_array($Result_attachview))
							{ 
								$file = 'upload-attachment'.DIRECTORY_SEPARATOR.$Rows_attachview['vchAttachmentName'];
								
								if(file_exists($file))
								{
									
						?>
							<a href="upload-attachment\<?php echo $Rows_attachview['vchAttachmentName']; ?>" download style="text-decoration:none;" ><?php echo $Rows_attachview['vchAttachmentName'];?></a>
							<br/>
						<?php
						}
						} ?>
					</p>
				
				</div>
				</div>
			</div>
		   </div>
		</div>
        <!------------->
      </div>
    
  
  <!------------------------->
  </div>
 <!-- Modal -->
  <div class="modal fade" id="myReview" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
	  <form action="" method="POST"" method="POST" id="my_form_token" novalidate   enctype="multipart/form-data">

      <div class="modal-content">
        <div class="modal-header" style="background:#dd7300;color:#fff;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Your Review</b></h4>
        </div>
        <div class="modal-body">
          <label for="token">Give Review Point</label>
			<div class="form-group">
			<textarea class="form-control" id="textmsg" name="textmsg" required="true"></textarea>
			<br/>
			<label>Click on the stars from 1 to 5</label>
			<fieldset id='demo1' class="rating">
				<br/>
				<input class="stars" type="radio" id="star15" name="rating" value="5"/>
				<label class = "full" for="star15" title="Awesome - 5 stars"></label>
				<input class="stars" type="radio" id="star14" name="rating" value="4" />
				<label class = "full" for="star14" title="Pretty good - 4 stars"></label>
				<input class="stars" type="radio" id="star13" name="rating" value="3" />
				<label class = "full" for="star13" title="Meh - 3 stars"></label>
				<input class="stars" type="radio" id="star12" name="rating" value="2" />
				<label class = "full" for="star12" title="Kinda bad - 2 stars"></label>
				<input class="stars" type="radio" id="star11" name="rating" value="1" />
				<label class = "full" for="star11" title="Sucks big time - 1 star"></label>
				
            </fieldset>
			<br/>
			<input type="hidden" value="<?php echo $userid; ?>" name="ReviewFrom">
			<input type="hidden" value="<?php echo $jobpost_id; ?>" name="PrjID">
			<input type="hidden" value="<?php echo $emailTO; ?>" name="usrEmailID">
			<input type="hidden" value="<?php echo $FromidTO; ?>" name="ReviewTO">
			<input type="hidden" name="start_value" id="start_value" value="" />
						
			<input name="reviewSubmit" id="reviewSubmit" type="submit" class="btn btn-warning" value="Submit-Review">
			
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" style="background:#dd7300;color:#fff;" data-dismiss="modal">Close</button>
        </div>
      </div>
	  </form>
      </div>
    </div>
 
<!--------------->
<!--------------->
 </div>
</div>
<?php include_once("includes/footer.php");?>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready( function()

    {//simple validation at client's end
	
    $( "#my_form" ).submit(function( event ){ //on form submit       
        var proceed = true;
        //loop through each field and we simply change border color to red for invalid fields       
        $("#my_form input[required=true], #my_form textarea[required=true] ,#my_form select[required=true],#my_form radio[required=true]").each(function(){
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
$("#demo1 .stars").click(function () {
		var rate = $(this).val();
		var start_value = $('#start_value').val(rate);
		$(this).attr("checked");
		});
});
</script>

</body>
</html>
