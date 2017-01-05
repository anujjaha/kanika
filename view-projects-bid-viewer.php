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
<body>
<div class="page">
  <div id="wrapper">
  <!------------------>
  <div id="content">
<?php 
include_once("includes/header-inner.php");
/********** select tbl_user**********/
include('connection.php');
/******** end here ********************/
$user_id = $_GET['user_id'];
$jobpost_id = $_GET['jobpost_id'];

if(isset($_POST['chatSubmit']))
{
	$currentdata = date('Y-m-d H:i:s');
	$insert="insert into tbl_project_chatmsgs set intProjectId='".$_POST['PrjID']."',chatmsgFrom='".$_SESSION['user_id']."',chatmsgTo='".$_POST['usrID']."',chatmsg='".$_POST['textmsg']."',msgTime='".$currentdata."'";
	$reultnew = mysql_query($insert);
	if($reultnew)
	{
		$flag=5;
	}
	
}

if(isset($_POST['reviewSubmit']))
{
	$currentdata = date('Y-m-d H:i:s');
	 $insertrating="insert into tbl_review_rating set ratingProjectId='".$_POST['PrjID']."',ratingIdFrom='".$_SESSION['user_id']."',ratingIdTo='".$_POST['usrID']."',ratingIdEmailgivenTo='".$_POST['usrEmailID']."',reviewMsg='".$_POST['textmsg']."',starRating='".$_POST['start_value']."',ratinggiventime='".$currentdata."'";
	//die();
	$ratingresult = mysql_query($insertrating);
	/***** Notification Insertion Start ******/
	
	$Sql_Notification = "INSERT into tbl_notifications SET notificationProjectId='".$_POST['PrjID']."',notificationFrom='".$_SESSION['user_id']."',notificationTo='".$_POST['usrID']."',notificationStatus='Rating Given'";
	mysql_query($Sql_Notification);
	
	$Sql_Update_ProjectCompleted = "Update tbl_job_post_bid SET intProjectCompleted='1' where intProjectId='".$_POST['PrjID']."' AND  intUserId='".$_POST['usrID']."'";
	mysql_query($Sql_Update_ProjectCompleted);
	
	/***** Notification Insertion End ******/
	if($ratingresult)
	{
		$flag=7;
	}
}
/***** Rohit Code End *******/
/********* create new function *********************/
$sqlQueryBiddetectStatus = "select * from tbl_job_post_bid where intUserID='".$_GET['user_id']."' AND intProjectId='".$jobpost_id."' AND ProjectBidStatus='1' AND intBidViewStatus='0'";

$ResultBiddetectStatus = mysql_query($sqlQueryBiddetectStatus);
$num_row_BiddetectStatus = mysql_num_rows($ResultBiddetectStatus);

if($num_row_BiddetectStatus > 0)
{
	 $sqlQuery = "update tbl_job_post_bid set intBidViewStatus='1' ,token_Bidview_deduction='0.5' where intProjectId='".$jobpost_id."' AND intUserID='".$_GET['user_id']."' AND  ProjectBidStatus='1'";
	
	mysql_query($sqlQuery);
	$flag = 1;
}

/********** end here **************************/



$Sql_post_job = "select tbl_user.*,tbl_job_post.*,tbl_job_post_bid.* from tbl_job_post_bid Left join tbl_job_post on tbl_job_post.intJobPostId = tbl_job_post_bid.intProjectId
Left join tbl_user on tbl_user.intUserID = tbl_job_post_bid.intUserId where intProjectId='".$_GET['jobpost_id']."' AND tbl_job_post_bid.intUserId='".$_GET['user_id']."'";

$Result_post_job = mysql_query($Sql_post_job);
$num_row = mysql_num_rows($Result_post_job);

if(!empty($_GET['jobpost_id']) and base64_decode(@$_GET['bid'])=="accept")
{
	
	
	$sqlQuery = "update tbl_job_post_bid set intBidAcceptStatus='2' where intProjectId='".$jobpost_id."'";
	mysql_query($sqlQuery);
	
	$sqlQuery = "update tbl_job_post_bid set intBidAcceptStatus='1' where intProjectId='".$jobpost_id."' and intUserID='".$_GET['user_id']."'";
	mysql_query($sqlQuery);
	
	
	
	$sqlQuery = "select intBidAcceptStatus from tbl_job_post_bid where intUserID='".$_GET['user_id']."'";
	$BidAcceptStatus = mysql_query($sqlQuery);
	
	$Rows_BidStat = mysql_fetch_array($BidAcceptStatus);
	
	$sqlQuery = "select tbl_user.* from tbl_user where tbl_user.intUserID='".$_GET['user_id']."'";
	$BidTokenless = mysql_query($sqlQuery);
	
	
	/************ harsh code*************/
	$sqlQueryrefunds = "select  * from tbl_job_post_bid where intProjectId='".$jobpost_id."' AND intBidAcceptStatus='2'";
	$BidTokenRefunds = mysql_query($sqlQueryrefunds);
	
	while($row_refund_value= mysql_fetch_array($BidTokenRefunds))
	{
		//$row_refund_value['intUserId'];
		/********refund other user ***********/
		/*$sqlQueryupdateBId = "update tbl_job_post_bid set token_deduct='0.5' where intProjectId='".$jobpost_id."' AND intBidAcceptStatus='2' AND intUserId='".$row_refund_value['intUserId']."'";
		$resultBID = mysql_query($sqlQueryupdateBId);*/
	
if($row_refund_value['intBidAcceptStatus']==2){
		/***** Notification Insertion START ******/
	
		$Sql_DeclineNotification = "INSERT into tbl_notifications SET notificationProjectId='".$row_refund_value['intProjectId']."',notificationFrom='".$_SESSION['user_id']."',notificationTo='".$row_refund_value['intUserId']."',notificationStatus='You get decline for this job'";
		mysql_query($Sql_DeclineNotification);
		/***** Notification Insertion END ******/
	}
	
	if($row_refund_value['intBidViewStatus']==0 && $row_refund_value['ProjectBidStatus']==1 && $row_refund_value['intBidAcceptStatus']==2)
	{
		
		$sqlQueryUSerINfo = "select * from tbl_user where intUserID='".$row_refund_value['intUserId']."'";
		$BidTokenRefund_data = mysql_query($sqlQueryUSerINfo);
		while($userinforefunsd = mysql_fetch_array($BidTokenRefund_data))
		{
		$vchToken= $userinforefunsd['vchToken'];
		$tokenAmount= $userinforefunsd['tokenAmount'];
		$toyt = 5;
			if($vchToken > 0)
			{
				$newvchToken = $userinforefunsd['vchToken'] + $toyt ;
			}
			else
			{
				$newvchToken =  $toyt ;
			}
			if($tokenAmount > 0)
			{
				$newtokenAmount = $userinforefunsd['tokenAmount'] + $toyt ;
			}
			else
			{
				$newtokenAmount =  $toyt ;
			}
			$sqlQueryupdateBIduser = "update tbl_user set vchToken='".$newvchToken."' ,tokenAmount='".$newtokenAmount."' where   intUserID='".$row_refund_value['intUserId']."'";
		  $resultBIDuser = mysql_query($sqlQueryupdateBIduser);
		}
	}
		
	if($row_refund_value['intBidViewStatus']==1 && $row_refund_value['ProjectBidStatus']==1 && $row_refund_value['intBidAcceptStatus']==2)
	{
		
		$sqlQueryUSerINfo = "select * from tbl_user where intUserID='".$row_refund_value['intUserId']."'";
		$BidTokenRefund_data = mysql_query($sqlQueryUSerINfo);
		while($userinforefunsd = mysql_fetch_array($BidTokenRefund_data))
		{
			
		
			
		$vchToken= $userinforefunsd['vchToken'];
		$tokenAmount= $userinforefunsd['tokenAmount'];
		$toyt = 4.5;
			if($vchToken > 0)
			{
				
				$newvchToken = $userinforefunsd['vchToken'] + $toyt ;
			}
			else
			{
				$newvchToken =  $toyt ;
			}
			
			if($tokenAmount > 0)
			{
				 
				$newtokenAmount = $userinforefunsd['tokenAmount'] + $toyt ;
			}
			else
			{
				$newtokenAmount =  $toyt ;
			}
			
			$sqlQueryupdateBIduser = "update tbl_user set vchToken='".$newvchToken."' ,tokenAmount='".$newtokenAmount."' where   intUserID='".$row_refund_value['intUserId']."'";
		  $resultBIDuser = mysql_query($sqlQueryupdateBIduser);
		}
	}
		/****** end here ******************/
	}

	/******** end here ****************/
	
	if($Rows_BidStat['intBidAcceptStatus']==1)
	{
		
		$sqlQueryupdateBIduser = "update tbl_job_post_bid set token_Bidview_deduction='5' where intProjectId='".$jobpost_id."' AND intBidAcceptStatus='1' AND ProjectBidStatus='1'";
		$resultBIDuser = mysql_query($sqlQueryupdateBIduser);
		
		$Sql_notification_project ="select tbl_user.*,tbl_job_post.*,tbl_job_post_bid.* from tbl_job_post_bid 
				Left join tbl_job_post on tbl_job_post.intJobPostId = tbl_job_post_bid.intProjectId
				Left join tbl_user on tbl_user.intUserID = tbl_job_post_bid.intUserId where intProjectId='".$jobpost_id."' AND intBidAcceptStatus='1'";
	
		$Update_notification_project = mysql_query($Sql_notification_project);
		$Result_Notification_project = mysql_fetch_array($Update_notification_project);
		
		
		
		/*********** end here **********************/
	$Proj_usrID = $Result_Notification_project['intJobPostUserId'];
	$Sql_getuser_emailid ="select * from tbl_user where intUserID='".$Proj_usrID."'";
	$Update_getuser_emailid = mysql_query($Sql_getuser_emailid);
	$Result_getuser_emailid = mysql_fetch_array($Update_getuser_emailid);
	
	$User_emailid= $Result_getuser_emailid['vchEmail'];
	$User_FirstName= $Result_getuser_emailid['vchFirst_Name'];
	$User_Contactno= $Result_getuser_emailid['vchPhone_Number'];
	
	$Proj_Title = $Result_Notification_project['vchJobPostTitle'];
	$Proj_Descrip = $Result_Notification_project['vchJobPostDescription'];
	$Proj_BidDate = date('F j Y', strtotime($Result_Notification_project['vchBidDate']));
	
	$Proj_Jobpost_Budget = $Result_Notification_project['vchJobPostBudget'];
	$Proj_PostPrice = $Result_Notification_project['vchJobPostPrice'];
	$Proj_bidPaymentType = $Result_Notification_project['bidpricetype'];
	$Proj_ZipCode = $Result_Notification_project['vchJobPostZipCode'];
	$Proj_puserid = $Result_Notification_project['intUserId'];
	
	$Proj_AssignTo = $Result_Notification_project['vchFirst_Name'];
	$Proj_AssignEmail = $Result_Notification_project['vchEmail'];
	$Proj_AssignContact = $Result_Notification_project['vchPhone_Number'];
	$emailto = $User_emailid;
	
    $HirerUserto = $emailto;
    $subject = "Freelancer Job Accepted";
    $message = '<html>
				<head>
				<title> Notification Project Accepted</title>
				</head>
				<body>
					<div style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
						<table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
						<tr>
							<td align="center" valign="top" style="padding:20px 0 20px 0">
								
								<table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #E0E0E0;">
									<tr style="background-color:#ee8b14;">
										<td valign="top" style="text-align:center;font-size:20px;font-weight:600;color:#fff;padding:10px 0;"> Congratulations! '.$User_FirstName.' </td>
									</tr>
								
									<tr>
										<td valign="top" style="padding:15px;background:#f2f2f2;">
										<div style="padding:20px;background:#fff;float:left;width:94%">
											<div style="border-bottom:solid 1px #dd7300;padding:10px 0;float:left;">
												<div style="float:left;width:30%;">
													<img src="http://www.rrtechnosolutions.in/freelance/images/your-logo.png" width="80%" alt="your-logo">
												</div>
												<div style="float:right;width:50%;text-align:right">
													<b>Notification</b><br/>'.$Proj_BidDate.';
												</div>
											</div>
											
											<div style="border-bottom:solid 1px #dd7300;padding:10px 0;float:left;width:100%">
												<p style="font-size:14px; line-height:16px; margin:0;font-weight:600;"><b>Hello  '.$User_FirstName.',</b></p><br />
												
												<p style="font-size:14px; line-height:16px; margin:0;"><b>Project Name: '.$Proj_Title.' </b></p><br />
											
												<p style="font-size:14px; line-height:16px; margin:0;"><b> Project Link: <a href="http://rrtechnosolutions.in/freelance/view-projects-bid-viewer.php?user_id='.$Proj_puserid.'&jobpost_id=1">Click to Redirect PRoject</a> </p> <br/>
											
												<p style="font-size:14px; line-height:16px; margin:0;"><b>Project Assigned To: '.$Proj_AssignTo.' </b> </p> <br />
											        
												<p style="font-size:14px; line-height:16px; margin:0;"><b>Project User Email: '.$Proj_AssignEmail.' </b></p><br />
											
												<p style="font-size:14px; line-height:16px; margin:0;"><b>Project User Contact: '.$Proj_AssignContact.' </b></p><br />
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
		
	/*********** end here **********************/
	
    $Hiredto = $Proj_AssignEmail;
    $subjectuser = "You are hired from Freelance";
    $messageuser = '<html>
				<head>
				<title> Notification Project Accepted</title>
				</head>
				<body>
					<div style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
						<table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
						<tr>
							<td align="center" valign="top" style="padding:20px 0 20px 0">
								
								<table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #E0E0E0;">
									<tr style="background-color:#ee8b14;">
										<td valign="top" style="text-align:center;font-size:20px;font-weight:600;color:#fff;padding:10px 0;"> Congratulations! '.$Proj_AssignTo.' </td>
									</tr>
								
									<tr>
										<td valign="top" style="padding:15px;background:#f2f2f2;">
										<div style="padding:20px;background:#fff;float:left;width:94%">
											<div style="border-bottom:solid 1px #dd7300;padding:10px 0;float:left;">
												<div style="float:left;width:30%;">
													<img src="http://www.rrtechnosolutions.in/freelance/images/your-logo.png" width="80%" alt="your-logo">
												</div>
												<div style="float:right;width:50%;text-align:right">
													<b>Notification</b><br/>'.$Proj_BidDate.';
												</div>
											</div>
											
											<div style="border-bottom:solid 1px #dd7300;padding:10px 0;margin:10px 0;float:left;width:100%">
											<p style="font-size:14px;line-height:16px; margin:0;font-weight:600;"><b>Hello '.$Proj_AssignTo.' </b></p><br />
											
											<p style="font-size:14px; line-height:16px; margin:0;"><b>Your Bid is Accepted By: <span style="color:#dd7300;">'.$User_FirstName.'</span> & hired for his New-Project.</b></p><br />
											
											<p style="font-size:14px; line-height:16px; margin:0;"><b>Project Name: '.$Proj_Title.' </b></p><br />
											
											<p style="font-size:14px; line-height:16px; margin:0;"><b> Project Link: <a href="http://rrtechnosolutions.in/freelance/view-projects-bid-viewer.php?user_id='.$Proj_puserid.'&jobpost_id=1">Click to Redirect PRoject</a> </p> <br/>
											
											<p style="font-size:14px; line-height:16px; margin:0;"><b>Hired By:  '.$User_FirstName.'</b> </p> <br />
											        
											<p style="font-size:14px; line-height:16px; margin:0;"><b>Hired Client Email-id: '.$User_emailid.' </b></p><br />
											
											<p style="font-size:14px; line-height:16px; margin:0;"><b>Hired Client Contact : '.$User_Contactno.' </b></p><br />
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

	$headersuser = "MIME-Version: 1.0" . "\r\n";
	$headersuser .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headersuser .= 'From: rohit@rrtechnosolutions.in' . "\r\n";
    $sendmailuser =  mail($Hiredto, $subjectuser, $messageuser, $headersuser);
	}

	echo '<script>document.location.href="view-projects-bid-viewer.php?user_id='.$_GET['user_id'].'&jobpost_id='.$_GET['jobpost_id'].'&viewbid_status=1"</script>';
}
?>
  <!---------------1----------->
  <div class="freelanceview">
    <div class="container">
      <div class="row">
        <!---------------->
        <div class="col-md-12">
          <?php include('left-side.php');?>
          <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="view_title">
              <label>Project View Bid</label>
			  
            </div>
			<?php if($flag==5) { ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-success">
				<strong>Success!</strong> message sent.
				</div>
			</div>
			<?php } ?>
			<?php if($flag==7) { ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-success">
				<strong>Thanks!</strong> For Review.
				</div>
			</div>
			<?php } ?>
<?php
if($num_row > 0)
{
$Rows_post_job = mysql_fetch_array($Result_post_job)

?>

	<div class="col-lg-12 dashnoard1">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bidderview">
       	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-left"> 
			<a href="view-projects-bid.php?project_id=<?php echo $Rows_post_job['intJobPostId'];?>" style="margin-bottom: 10px;"><i class="fa fa-arrow-left"> </i> </a> 
		</div>
    	<div class="col-lg-8 col-md-2 col-sm-8 col-xs-7 text-center"> 	
			<label> <a href="view-job-view.php?jobid=<?php echo $Rows_post_job['intJobPostId'];?>"><?php echo $Rows_post_job['vchJobPostTitle'];?> </a></label> 
		</div>
    	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 text-right"> 
        	<?php if($Rows_post_job['intBidAcceptStatus']==0){ ?>
                <a href="view-projects-bid-viewer.php?user_id=<?php echo $Rows_post_job['intUserId'];?>&jobpost_id=<?php echo $Rows_post_job['intJobPostId'];?>&viewbid_status=1&bid=<?php echo base64_encode('accept') ?>" onClick="return confirm('Are you sure you want to accept bid?')"  style="margin-bottom: 10px;">  HIRE </a>
                <?php } else if ($Rows_post_job['intBidAcceptStatus']==1){ ?>
                <a  style="margin-bottom: 10px;">HIRED</a>
                <?php } else { ?>
                <a  style="margin-bottom: 10px;">Already Hired</a>
            <?php } ?>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center biddingamt">	
    	$<?php echo $Rows_post_job['vchBidPrice'];?> Total Price
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right biddingamt">	
    	<?php if(($Rows_post_job['intBidAcceptStatus']==0) && ($Rows_post_job['intProjectCompleted']==0)){ ?>
		<span>Project Status: Not Hired</span>
		
		<?php } else if (($Rows_post_job['intBidAcceptStatus']==1) && ($Rows_post_job['intProjectCompleted']==0)){ ?>
		<span>Project Status: In Progress</span>
		<br/>
		<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#myReview"> Mark As Completed </a>
		
		<?php } else if (($Rows_post_job['intBidAcceptStatus']==1) && ($Rows_post_job['intProjectCompleted']==1)){ ?>
		
		<div class="btn btn-warning"> Project: Completed </div>
		
		<?php } else { ?>
		<span>Project Status: N/A</span>
		<?php } ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">	
        	<p style="padding:10px 0;">
			<center>
				<a href="userprofile.php?id=<?php echo $Rows_post_job['intUserId'];?>" target="_blank">
        		<img src="images/<?php echo $Rows_post_job['vchUserImage']; ?>" alt="Business-women1" style="width:120px;height:120px;padding:5px;border-radius:50%;border:solid 1px #333;">
				</a>
			</center>
			</p>
			<p style="padding:10px 0;">
				<a href="userprofile.php?id=<?php echo $Rows_post_job['intUserId'];?>" target="_blank" class="btn btn-warning" style="width:100%;"> View-Profile</a>
			</p>
        </div>
        
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">	
     		<div class="dashnoard3">
            	<p>
            		<a href="userprofile.php?id=<?php echo $Rows_post_job['intUserId'];?>" target="_blank">
	            		<b><?php echo $Rows_post_job['vchFirst_Name'].' '.$Rows_post_job['vchLast_Name'] ;?></b>
	            	</a>
            	</p>
                <p><b>Proposal: </b></p>
                <span style="text-align:justify;">
                <?php 
                    echo $Rows_post_job['QuestionsAboutProject'];
				?>
                </span>
                <p> <b>Deliver in : </b><?php echo $Rows_post_job['vchBidDeliverDay'];?> days</p>
            </div>   
        </div>
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#myChat" style="float:right;">Reply</a>
		</div>
	
	<!--
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center biddingamt">	
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">	
        	Attachments:
        </div>
       
         <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 text-left">
			<?php 
			//$Sql_post_attchement = "select * from tbl_attachments where intJobPostId='".$_GET['jobpost_id']."'";
			//$Result_post_attachement = mysql_query($Sql_post_attchement);
			?>
			<?php 
			//while($row_attachment = mysql_fetch_array($Result_post_attachement))
			//{ ?>
				<a href="<?php //echo $row_attachment['vchAttachmentName']; ?>" download style="text-decoration:none;" ><?php //echo $row_attachment['vchAttachmentName'];?></a>
				<br/>
			<?php //} ?> 
		</div>
-->
    </div>
	</div>
<?php
}
?>
<!-- Modal -->
  <div class="modal fade" id="myReview" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
	  <form action="http://rrtechnosolutions.in/freelance/view-projects-bid-viewer.php?user_id=<?php echo $_GET['user_id'];?>&jobpost_id=<?php echo $_GET['jobpost_id'];?>&viewbid_status=1" method="POST"" method="POST" id="my_form_token" novalidate   enctype="multipart/form-data">

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
			
			<label style="float:left;">Click on the stars from 1 to 5 </label>
			<fieldset id='demo1' class="rating">
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
				<br/> 
            </fieldset>
			
			<br/>
			<input type="hidden" value="<?php echo $user_id; ?>" name="usrID">
			<input type="hidden" value="<?php echo $jobpost_id; ?>" name="PrjID">
			<input type="hidden" value="<?php echo $usr_EmailID; ?>" name="usrEmailID">
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
  </div>
<!--------------->
          </div>
		  <!-- Modal -->
  <div class="modal fade" id="myChat" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
	  <form action="http://rrtechnosolutions.in/freelance/view-projects-bid-viewer.php?user_id=<?php echo $_GET['user_id'];?>&jobpost_id=<?php echo $_GET['jobpost_id'];?>&viewbid_status=1" method="POST" id="my_form_token" novalidate   enctype="multipart/form-data">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Chat with Bidder</b></h4>
        </div>
        <div class="modal-body">
          <p></p>
			<div class="form-group">
			<label for="token">Send Your Message</label>
			
			<textarea class="form-control" id="textmsg" name="textmsg" required="true"></textarea>
			
			<input type="hidden" value="<?php echo $user_id; ?>" name="usrID">

			<input type="hidden" value="<?php echo $jobpost_id; ?>" name="PrjID">

			<br/>
			<input name="chatSubmit" id="chatSubmit" type="submit" class="btn btn-warning" value="Submit">
			
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
	  </form>
      
    </div>
  </div>
  </div>
<!--------------->
        </div>
        <!----------------------->
        <!------------->
      </div>
    </div>
 </div>
  <!------------------------->
</div>

<?php include_once("includes/footer.php");?>

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
 </div>
</div>
</body>
</html>