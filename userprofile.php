<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>User Profile</title>
<?php include_once("includes/common-links.php");?>
</head>
<body>
<div class="page">
<div id="wrapper">
  <!------------------>
  <div id="content" style="background:#f2f2f2;">
  <!------------------>
  <?php 
  ob_start();
  
  include_once("includes/header-inner.php"); 
  
	$userid=$_GET['id'];
	/**** User Details Only ********/
	
	
	/****** User & Skills Details Fetch Code by Rohit Start *******/
	$select_UserSkills="select tbl_user.*,tbl_skill.*,tbl_user_skill.* from tbl_user_skill
				Left join tbl_skill on tbl_skill.intSkillId = tbl_user_skill.intSkillID
				Left join tbl_user on tbl_user.intUserID = tbl_user_skill.intUserID	where tbl_user_skill.intUserID='".$_GET['id']."'";
	$result_UserSkills=mysql_query($select_UserSkills);
	$num_row_UserSkills = mysql_num_rows($result_UserSkills);
	
	$row_UserSkillsDetail=mysql_fetch_assoc($result_UserSkills);
	
	
	/****** User & Skills Details Fetch Code by Rohit End *******/
	
	/****** Rating Given TO Code by Rohit START *******/
	
	$select_UserReviews="select tbl_job_post.*,tbl_user.*,tbl_review_rating.* from tbl_review_rating
	Left join tbl_user on tbl_user.intUserID = tbl_review_rating.ratingIdFrom
	Left join tbl_job_post on tbl_job_post.intJobPostId = tbl_review_rating.ratingProjectId
	where tbl_review_rating.ratingIdTo='".$_GET['id']."' order by ratingId DESC";
	$result_UserReview = mysql_query($select_UserReviews);
	$num_row_UserReview = mysql_num_rows($result_UserReview);
	$result_indiReview = mysql_query($select_UserReviews);
	
	/** CALCULATE AVERAGE RATING **/
	$Rating = '0';
	$avgRate ='0';
	if ($num_row_UserReview > 0){
	while($row_UserReviews = mysql_fetch_assoc($result_UserReview))
	{
	//echo"<pre>";
	//print_r($row_UserReviews);
	$row_UserReviews['starRating'];
	$Rating = $Rating + $row_UserReviews['starRating'];
	}
	$avgRate = $Rating/$num_row_UserReview;
	}
	//die();
	
	/**** AVERAGE RATING FINISHED***/
	
	/****** Rating Given TO Code by Rohit END *******/
	?>
  <!---------------1----------->
	  
	<div class="reg1">
		<div class="container">
		  <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="pvbox">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-center">
					<div class="picbox">
						<img src="images/<?php echo $row_UserSkillsDetail['vchUserImage']; ?>">
					</div>
					<p><b>Zip: <?php echo $row_UserSkillsDetail['vchZip_Code']; ?></b></p>
					<p><b>City: <?php echo $row_UserSkillsDetail['vchCity']; ?>, <?php echo $row_UserSkillsDetail['vchCountry']; ?></b></p>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="Descbox">
						<h3><?php echo $row_UserSkillsDetail['vchFirst_Name']. $row_UserSkillsDetail['vchLast_Name']; ?></h3>
						<h4> <b>Skills : </b> 
							<?php 
								if($num_row_UserSkills > 0){
									
									while($row_UserSkills = mysql_fetch_assoc($result_UserSkills))
										{
											//echo"<pre>";
											//print_r($row_UserSkills);
											echo $row_UserSkills['vchSkillName'].','; 
										}
								}
								else{
									echo'N/A';
								}
							?>
						</h4>
						<p><b>About : </b> <?php echo $row_UserSkillsDetail['vchDescription']; ?></p>
					</div>
				</div>
				<?php
				
					if($avgRate>0){
					
					$totalcountReviews = $num_row_UserReview;
				?>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<div class="Reviewbox">
						<p>
							<span><?php echo $avgRate; ?></span> <img src="images/<?php echo round($avgRate); ?>.png">
						</p>
						<p><b><?php echo $totalcountReviews; ?></b> reviews</p>
					</div>
				</div>	
				<?php
				}
				else
				{
				?>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<div class="Reviewbox">
						<p>
							<span>N/A</span> <!-- <img src="images/<?php //echo round($avgRate); ?>.png"> -->
						</p>
						<p><b> 0 </b> reviews</p>
					</div>
				</div>
				<?php
				}
				
				?>
				
			</div>
			
			<div class="pvbox">
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderbottom-1">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<h3>Recent Reviews </h3>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
							<h3>View More Reviews</h3>
						</div>
					</div>
					<?php
					
						if($avgRate>0){
						while($row_IndiReviews = mysql_fetch_assoc($result_indiReview))
							{
								//echo"<pre>";
								//print_r($row_IndiReviews);
								//die();
					?>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderbottom-1">
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
									<img src="images/<?php echo $row_IndiReviews['vchUserImage']; ?>" class="padg" style="width:100%;">
								</div>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 padg">
								<p><b>Project: </b>
								<?php
									echo $row_IndiReviews['vchJobPostTitle'];
								?>
								</p>
								<p><b>Review By: </b>
								<?php
									echo $row_IndiReviews['vchFirst_Name'].' '. $row_IndiReviews['vchLast_Name'];
								?>
								</p>
								<p>
									<span><?php echo $row_IndiReviews['starRating'];?></span>
									<img src="images/<?php echo $row_IndiReviews['starRating'];?>.png">
								</p>
								<!-- <p><b>Price: $ </b>
								<?php
									//echo $row_IndiReviews['vchJobPostPrice'];
								?>
								</p> -->
								<p><b>Feedback: </b>
								<?php
									echo $row_IndiReviews['reviewMsg'];
								?>
								</p>
								
								</div>
							</div>
					<?php
						
						}
						
						} 
						else 
						{
					?>
					
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
							<h3 style="margin:10px 0;font-weight:600;">N/A Until Anyone Gives You rating on your Job</h3>
						</div>
					<?php
						}
					?>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				
				</div>
			</div>
		  </div>
		</div>
	</div>
	   
	  <!------------------------->
	 
  </div>
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

</body>
</html>
