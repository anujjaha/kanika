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
<style>
.open-bt {
  background-color: #449d44;
  color: #fff !important;
}

</style>
<body>
<div class="page">
<div id="wrapper">
  <!------------------>
  <div id="content">
  <!------------------>
  <?php include_once("includes/header-inner.php");?>
  <script src="ckeditor/ckeditor.js" type="text/javascript"></script>
  <?php 
/********** select tbl_user**********/
include('connection.php');
$Sql = "select * from tbl_job_post where  intJobPostId='".$_GET['project_id']."'";
$Result = mysql_query($Sql);
$Rows = mysql_fetch_array($Result);

/******** end here ********************/

if(isset($_POST['submit']))
{
	$deduct_percentage = '0.5';
	$deduct_tokens = '5';
	
	$Sql_tokendeduct = "select tbl_user.* from tbl_user where tbl_user.intUserID='".$_SESSION['user_id']."'";
	
	$Result_token_less = mysql_query($Sql_tokendeduct);
	$Rows_Deduct_less = mysql_fetch_array($Result_token_less);
	
	$deduction_amount= $Rows_Deduct_less['vchToken'] - $deduct_tokens;
	$rest_token_amount=$Rows_Deduct_less['tokenAmount'] - $deduct_tokens;
		
	$Sql_updateTokens = "Update tbl_user SET vchToken=$deduction_amount,tokenAmount=$rest_token_amount where tbl_user.intUserID='".$_SESSION['user_id']."'";
	$Update_User_Token = mysql_query($Sql_updateTokens);
	
	$currentdata = date('Y-m-d H:i:s');
	$SQl= "insert into tbl_job_post_bid set intUserId='".$_SESSION['user_id']."',intProjectId='".$_GET['project_id']."', vchBidPrice='".$_POST['bid_price']."',vchBidDeliverDay='".$_POST['bid_deliver_day']."',vchBidDate='".$currentdata."',QuestionsAboutProject='".addslashes($_POST['QuestionsAboutProject'])."',token_deduct='".$deduct_tokens."'";
	$result = mysql_query($SQl);
	/******* BID NOTIFICATION TO PROJECT USER START **********/
	$Sql_notification_project ="select tbl_user.*,tbl_job_post.*,tbl_job_post_bid.* from tbl_job_post_bid 
				Left join tbl_job_post on tbl_job_post.intJobPostId = tbl_job_post_bid.intProjectId
				Left join tbl_user on tbl_user.intUserID = tbl_job_post_bid.intUserId where intProjectId='".$_GET['project_id']."' AND tbl_user.intUserID='".$_SESSION['user_id']."'";
	
		$Update_notification_project = mysql_query($Sql_notification_project);
		$Result_Notification_project = mysql_fetch_array($Update_notification_project);
		//echo"<pre>";
		//print_r($Result_Notification_project);
		$Proj_usrID = $Result_Notification_project['intJobPostUserId'];
	$Sql_getuser_emailid ="select * from tbl_user where intUserID='".$Proj_usrID."'";
	$Update_getuser_emailid = mysql_query($Sql_getuser_emailid);
	$Result_getuser_emailid = mysql_fetch_array($Update_getuser_emailid);
	
	$User_FirstName= $Result_getuser_emailid['vchFirst_Name'];
	$User_emailid= $Result_getuser_emailid['vchEmail'];
	$Biddername= $Result_Notification_project['vchFirst_Name'];
		
	$BidOnProject= $Result_Notification_project['vchJobPostTitle'];
	
	$BidProjectDate=date('F j Y', strtotime($Result_Notification_project['vchBidDate']));
	$HirerUserto = $User_emailid;
     $subject = "New Bid Placed";
    $message = '<html>
				<head>
				<title> Notification New Project Bid On Your Project</title>
				</head>
				<body>
					<div style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
						<table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
						<tr>
							<td align="center" valign="top" style="padding:20px 0 20px 0">
								
								<table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #E0E0E0;">
									<tr style="background-color:#ee8b14;">
										<td valign="top" style="text-align:center;font-size:20px;font-weight:600;color:#fff;padding:10px 0;"> NOTICE! !  BID PLACED SUCCESSFULLY</td>
									</tr>
								
									<tr>
										<td valign="top" style="padding:15px;background:#f2f2f2;">
										<div style="padding:20px;background:#fff;float:left;width:94%">
											<div style="border-bottom:solid 1px #dd7300;padding:10px 0;float:left;">
												<div style="float:left;width:30%;">
													<img src="http://www.rrtechnosolutions.in/freelance/images/your-logo.png" width="80%" alt="your-logo">
												</div>
												<div style="float:right;width:50%;text-align:right">
													<b>Notification</b><br/>'.$BidProjectDate.';
												</div>
											</div>
											
											<div style="border-bottom:solid 1px #dd7300;padding:10px 0;float:left;width:100%">
												<p style="font-size:14px; line-height:16px; margin:0;font-weight:600;"><b>Hello '.$User_FirstName.' ,</b></p><br />
												
												<p style="font-size:14px; line-height:16px; margin:0;"><b>Dear USer Please Check there is a new bid is placed on your project.<br/> Details Below:- </b></p><br />
												
												<p style="font-size:14px; line-height:16px; margin:0;"><b>Bidder Name: '.$Biddername.' </b></p><br />
												
												<p style="font-size:14px; line-height:16px; margin:0;"><b>Project Name: '.$BidOnProject.' </b></p><br />
												
												
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
	/***** Notification Insertion Start ******/
	
	$Sql_Notification = "INSERT tbl_notifications SET notificationProjectId='".$_GET['project_id']."',notificationFrom='".$_SESSION['user_id']."',notificationTo='".$Proj_usrID."',notificationStatus='Bid Placed'";
	mysql_query($Sql_Notification);
	
	/***** Notification Insertion End ******/
	/******* BID NOTIFICATION TO PROJECT USER END **********/
	if($result)
	{
		$flag = 1;
	}
	$Sql_Bid_Deducted_Tokens = "Update tbl_job_post_bid SET ProjectBidStatus='1' where tbl_job_post_bid.intUserId='".$_SESSION['user_id']."'";
	$Update_Bid_Token = mysql_query($Sql_Bid_Deducted_Tokens);
}

$Sql_check = "select * from tbl_job_post_bid where intProjectId='".$_GET['project_id']."' AND  intUserId='".$_SESSION['user_id']."'";
$Result_check = mysql_query($Sql_check);
$total_count_place = mysql_num_rows($Result_check);

$Sql_check_count = "select * from tbl_job_post_bid where intProjectId='".$_GET['project_id']."' ";
$Result_check_count = mysql_query($Sql_check_count);
$total_count_check = mysql_num_rows($Result_check_count);

$Sql_check_skill = "select * from tbl_job_post_skill 
					Left join tbl_skill on tbl_skill.intSkillId = tbl_job_post_skill.intSkillID
					where intJobPostId='".$_GET['project_id']."'";
$Result_check_skill = mysql_query($Sql_check_skill);
$total_count_skill = mysql_num_rows($Result_check_skill);
/******** end here ********************/

$Sql_check_bid = "select tbl_job_post.*, tbl_user.*,tbl_job_post_bid.* from tbl_job_post_bid
				 Left Join 	tbl_job_post on tbl_job_post.intJobPostId = tbl_job_post_bid.intProjectId
				 Left Join 	tbl_user on tbl_user.intUserID = tbl_job_post_bid.intUserId
				where tbl_job_post_bid.intProjectId='".$_GET['project_id']."'";
$Result_check_bid= mysql_query($Sql_check_bid);
$total_count_bid = mysql_num_rows($Result_check_count);
?>
  <!---------------1----------->
  <div class="freelanceview">
    <div class="container">
      <div class="row">
        <!---------------->
        <div class="col-md-12">
         <?php include('left-side.php');?>
		 	  	 <form action="" method="post" id="my_form_bid" novalidate   enctype="multipart/form-data">

          <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="view_title">
              <div class="col-md-12">
			<div class="col-md-4">
              <label><?php if(isset($Rows['vchJobPostTitle']))  { echo $Rows['vchJobPostTitle'];} ?> </label>
			  </div>
			  <div class="col-md-8 alr-bt">
			  <?php if(isset($flag) && $flag==1) {  ?>
			  <div class="alert  alert-success"><strong>Success!</strong> Your bid has been placed successfully</div>
			  <?php } ?>
			  </div>
			  </div>
            <div class="view_desc1">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding0">
                 <div class="view_bids">
            <ul>
            <li> Bids </br> <b>(<?php echo $total_count_check ;?>/5)</b> </li>
           
            <li style="border:none;"> Project Budget (USD) </br> <b><?php if(isset($Rows['vchJobPostBudget']))  { 
			$exp_value= explode('-',$Rows['vchJobPostBudget']);
			echo '($'.$exp_value[0].'-'.'$'.$exp_value[1].')'; } ?></b></li>
            </ul>
            </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padding0 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 ">
                <div class="view_bids">
               <!--<label>6 Days , 15 hours left </label>-->
			   <?php if($total_count_check=='5') { ?>
            <p class="btn btn-success open-bt"> CLOSE </p>
			   <?php } else { ?><p class="btn btn-success open-bt"> OPEN </p> <?php }  ?>
            </div>
              </div>
            </div>
            
            <div class="view_desc" style="margin-top:1%;">
              <label>Project Description</label>
              <p><?php echo $Rows['vchJobPostDescription'];?></p>
            </div>
            <div class="view_desc" style="margin-top:1%;">
              <div class="col-lg-8 padding0">
                <label>Skills required</label>
                 <span> <?php 
				$aray =array();
				while($row_skill = mysql_fetch_array($Result_check_skill))
				{
					$aray[] = $row_skill['vchSkillName'];
				}
				echo implode(',',$aray);
				
				?> </span> </div>
              <div class="col-lg-4 padding0 text-right">
                <div class="bid_button">
                 <!---- <button type="button"  class="btn btn-primary bid-bt" rel="<?php echo $Rows['intJobPostId'];?>">Place Bid </button>-->
				 <?php  
				 if($total_count_check=='5') { 
				 } else{
				 if($total_count_place  > 0) { ?>
				
				 <?php } else { ?>
				  <input type="submit"  class="btn btn-primary bid-bt"  id="submit" name="submit" value="Place Bid" />
				 <?php } 
				 }
				 ?>
                </div>
              </div>
              <div class="col-lg-12 padding0 text-right">
                <p><b>Project Id:</b> <?php echo $_GET['project_id'];?></p>
              </div>
            </div>
		
	    <div class="view_desc1" style="margin-top:1%;">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding0">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0" style="margin-bottom:10px;"> <strong>Bid:</strong> </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padding0" >
                    <p>Paid to you:</p>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 padding0">
                    <table border="1">
                      <tr>
                        <td width="15%" style="padding:7px;text-align:center;font-size:14px;font-weight:600;background:#777;color:#fff;">$</td>
                        <td width="70%" style="padding:7px;text-align:center;font-size:14px;font-weight:600;">
						<input type="text" name="bid_price" id="bid_price" required="true"></td>
                        <td width="15%" style="padding:7px;text-align:center;font-size:14px;font-weight:600;background:#777;color:#fff;">USD</td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padding0 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 ">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0"  style="margin-bottom:10px;"> <strong>Deliver in:</strong> </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0">
                  <table border="1">
                    <tr>
                      <td width="70%" style="padding:7px;text-align:center;font-size:14px;font-weight:600;"><input type="text" name="bid_deliver_day" id="bid_deliver_day" required="true"></td>
                      <td width="30%" style="padding:7px;text-align:center;font-size:14px;font-weight:600;background:#777;color:#fff;">Days</td>
                    </tr>
                  </table>
				  
                </div>
              </div>
            </div>
			
	    <div class="view_desc" style="margin-top:1%;">
              <label>Proposal</label>
              			 <textarea rows="10" cols="100" name="QuestionsAboutProject" id="QuestionsAboutProject" required="true" placeholder="please enter job description"></textarea> 
				 <!-- <script type="text/javascript">CKEDITOR.replace( 'QuestionsAboutProject' );</script> -->
            </div>
			
			<div class="free_lance" style="display:none;">

            <table class="table table-bordered" id="no-more-tables">
              <tr class="plan-back">
                <th class="text-left tab-head" style="width:15%;">Biding</th>
				<th class="text-left tab-head">quotes</th>
                <th class="text-left tab-head"> Bid (USD)</th>
              </tr>
			  <?php while($Rows_bid = mysql_fetch_array($Result_check_bid))
					{
						//echo"<pre>";
						//print_r($Rows_bid);
			 ?>
              <tr>
                <td data-title="Freelancers Beeding" class="tab-plan-data text-left client_image">
                
				<img class="img-rounded" src="images/profile1.png" alt="profile_icon">
                  <p class="image_title"><?php echo $Rows_bid['vchFirst_Name'].' '.$Rows_bid['vchLast_Name'] ;?> </p>
                </td>
              
                <td data-title="Description" class="tab-plan-data text-left"> 
				<div class="main_ctnt">
				<div class="show">
				<p><?php echo substr($Rows_bid['QuestionsAboutProject'], 0, 200);?></p>
				
				<span class="morectnt">
				<span style="display: none;"><?php echo $Rows_bid['QuestionsAboutProject'];?></span>
				<a class="showmoretxt" href="">More</a>
				</span>
				</div>
				</div>

				<?php //echo $Rows_bid['QuestionsAboutProject'];?> </td>
                <td data-title="Bid (AUD)" class="tab-plan-data text-left"><strong> $ <?php echo $Rows_bid['vchBidPrice'];?></strong> </br>
                  In <?php echo $Rows_bid['vchBidDeliverDay'];?> days </td>
              </tr>
			<?php
				} 
			?>
            </table>
          </div>
          </div>
        </div>
		
		</form>
        <!----------------------->
        <!------------->
      </div>
    </div>
  </div>
  <!------------------------->
</div>


<!--------------->
<?php include_once("includes/footer.php");?>

<script type="text/javascript">
	$(document).ready(function(){
	/*$( "#token_id" ).click(function() 
		{
		var intRegex = /^\d+$/;
		//var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

		var str = $('#earn_token').val();
		
		if(str!='')
		{
			//if(intRegex.test(str) || floatRegex.test(str)) {
			if(intRegex.test(str)) {
			alert('I am a number');

			}else{
			alert('charter');
			}
		}
		else{
			
			$('#earn_token').css('border-color','red'); 
		}
		});*/
		  $( "#my_form_bid" ).submit(function( event ){ //on form submit       
        var proceed = true;
        //loop through each field and we simply change border color to red for invalid fields       
        $("#my_form_bid input[required=true], #my_form_bid textarea[required=true] ,#my_form_bid select[required=true],#my_form_bid radio[required=true],#my_form_bid file[required=true]").each(function(){
                $(this).css('border-color',''); 
                if(!$.trim($(this).val())){ //if this field is empty 
                    $(this).css('border-color','red'); //change border color to red   
                   proceed = false; //set do not proceed flag
                }
                //check invalid number
				var intRegex = /^\d+$/;
				var str = $('#bid_price').val();
				var bid_deliver_day = $('#bid_deliver_day').val();
				if(intRegex.test(str)) {
						//alert('I am a number');
						
				}
				else{
					//alert('charter');
					$(this).css('border-color','red'); 
					proceed = false;
			}
				if(intRegex.test(bid_deliver_day)) {
						//alert('I am a number');
						
				}
				else{
					//alert('charter');
					$(this).css('border-color','red'); 
					proceed = false;
			}				
							
				
        });
        
        if(proceed){ //if form is valid submit form
           
			return true;
			
			
        }
        event.preventDefault(); 
    });
		
		$("#my_form_bid input[required=true], #my_form_bid textarea[required=true]").keyup(function() { 
        $(this).css('border-color',''); 
        $("#result").slideUp();
    });
		$( "#closediv" ).click(function()
		{
		   $('#myModalBid').css('display','none');
		});

	});
	</script>
</div>
</div>
</body>
</html>
