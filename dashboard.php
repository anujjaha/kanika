<?php error_reporting(0);?>
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
<body onLoad="countdown(year,month,day,hour,minute); ">
<div class="page">
<div id="wrapper">
<div id="content">

<?php 
	include_once("includes/header-inner.php");
	include('connection.php');

if(isset($_GET['job_id']) and !empty($_GET['job_id']))
{
	$sqlQuery = "insert into tbl_job_post_hide set intUserID='".$_SESSION['user_id']."',IntJobPostID='".$_GET['job_id']."' ";
	$result_hide = mysql_query($sqlQuery);
	$url ="dashboard.php";
	?>
	<script>
		window.location.href="<?php echo $url; ?>";
	</script>

	
<?php }


$Sql = "select vchZip_Code,job_notification from tbl_user where  intUserID='".$_SESSION['user_id']."'";

$Result = mysql_query($Sql);
$Rows 	= mysql_fetch_array($Result);
$userNotificationTypes = $Rows['job_notification'];


if(isset($_REQUEST['submitsrch']) and !empty($_REQUEST['submitsrch']))
{

	$filterCategories 	= $_REQUEST['categoryFilter'];
	$childCategory 		= array();
	$parentCategory 	= array();
	$parentFilter 		= "";
	$childFilter  		= "";

	foreach ($filterCategories as $value) 
	{
		if(strlen($value) > 15)
		{
			$value = explode("-", $value);
			array_push($childCategory, $value[1]);
		}
		else
		{
			array_push($parentCategory, $value);
		}
	}

	if(count($childCategory))
	{
		$childFilter = implode(",", $childCategory);	
	}

	if(count($parentFilter))
	{
		$parentFilter = implode(",", $parentCategory);	
	}


	$contr=@$_REQUEST["catSearch"];
	$hourlyBudget=@$_REQUEST["hourlyBudget"];
	$fixedBudget=@$_REQUEST["fixedBudget"];
	$jobTitle=@$_REQUEST["jobTitle"];
	$jobSkills=@$_REQUEST["jobSkills"];


	if(!empty($childCategory) && !empty($parentCategory))
	{
		$disp = "SELECT tbl_category.*,tbl_job_post.*  FROM tbl_job_post 
				LEFT JOIN tbl_category on tbl_category.intCategoryID = tbl_job_post.vchJobWorkType 
				WHERE 
				vchJobPostZipCode='".$Rows['vchZip_Code']."'
				AND vchJobWorkType IN (" .$userNotificationTypes. ")
				AND intJobPostUserId !='".$_SESSION['user_id']."' 
				AND vchJobWorkType IN (" .$parentCategory. ")
				AND vchJobWorkSubType IN (" .$childCategory. ")
				";	
	}
	else if(!empty($parentCategory))
	{
		$disp = "SELECT tbl_category.*,tbl_job_post.*  FROM tbl_job_post 
				LEFT JOIN tbl_category on tbl_category.intCategoryID = tbl_job_post.vchJobWorkType 
				WHERE 
				vchJobPostZipCode='".$Rows['vchZip_Code']."'
				AND vchJobWorkType IN (" .$userNotificationTypes. ")
				AND intJobPostUserId !='".$_SESSION['user_id']."' 
				AND vchJobWorkType IN (" .$parentCategory. ")";	
	}
	else if(!empty($childCategory))
	{
		$disp = "SELECT tbl_category.*,tbl_job_post.*  FROM tbl_job_post 
				LEFT JOIN tbl_category on tbl_category.intCategoryID = tbl_job_post.vchJobWorkType 
				WHERE 
				vchJobPostZipCode='".$Rows['vchZip_Code']."'
				AND vchJobWorkType IN (" .$userNotificationTypes. ")
				AND intJobPostUserId !='".$_SESSION['user_id']."' 
				AND vchJobWorkSubType IN (" .$childCategory. ")";	
	}
	else
	{
		$disp = "SELECT tbl_category.*,tbl_job_post.*  FROM tbl_job_post 
				LEFT JOIN tbl_category on tbl_category.intCategoryID = tbl_job_post.vchJobWorkType 
				WHERE
				vchJobPostZipCode='".$Rows['vchZip_Code']."'
				AND intJobPostUserId !='".$_SESSION['user_id']."'";
	}


	$pagingVal = 'submitsrch=Go';

	if($jobTitle != '')
	{
			$disp .="	AND vchJobPostTitle like '%".$_REQUEST["jobTitle"]."%' ";
	}
		
	if($jobSkills != '')
	{
		$disp .="	AND vchJobSkill like '%".$_REQUEST["jobSkills"]."%' ";
	}

	if($hourlyBudget != '')
	{
		$disp .="	AND bidpricetype like '%".$_REQUEST["hourlyBudget"]."%' ";
	}
	
	if($fixedBudget != '')
	{
		$disp .="	AND  bidpricetype like '%".$_REQUEST["fixedBudget"]."%' ";
	}

	$Result_post_job=mysql_query($disp) ;
}
else
{
	$Sql_post_job = "select * from tbl_job_post_multizipcode where  intMultizipCode='".$Rows['vchZip_Code']."' 
		AND intUserId!='".$_SESSION['user_id']."' ORDER BY intZipcodeId DESC ";
		$Result_post_job = mysql_query($Sql_post_job);
}
?>
	
	<div class="dashboard">
		<div class="container">
			<div class="row">
				<?php include('left-side.php');?>
				
				<div class="col-lg-9">
					<div class="col-lg-12 text-left jobs-posted"> Most Recent Jobs Posted </div>
				
						<?php 
						$num_row = mysql_num_rows($Result_post_job);
						if($num_row > 0)
						{
						$count =1;
						while($Rows_post_jobs = mysql_fetch_array($Result_post_job))
						{ 
							if(isset($Rows_post_jobs['intJobPostId']))
							{
								$jobPostId = $Rows_post_jobs['intJobPostId'];
							}
							else if(isset($Rows_post_jobs['intProjectId']))
							{
								$jobPostId = $Rows_post_jobs['intProjectId'];
							}
							else
							{
								continue;
							}

							$SqlJob = "select * from tbl_job_post where vchJobWorkType IN (". $userNotificationTypes .") AND intJobPostId='".$jobPostId."' ORDER BY intJobPostId DESC";
							
							$ResultJob = mysql_query($SqlJob);
							$Rows_post_job = mysql_fetch_array($ResultJob);
							
							
							$Sql_post_hide = "select * from tbl_job_post_hide where IntJobPostID='".$Rows_post_job['intJobPostId']."' AND intUserID='".$_SESSION['user_id']."'";
							$Result_postHide = mysql_query($Sql_post_hide);
							$result_row = mysql_num_rows($Result_postHide);

							if($result_row >0)
							{
								
							}else{
								
								
							$Sql_post_check = "select * from tbl_job_post_bid where intProjectId='".$Rows_post_job['intJobPostId']."'";
							$Result_postCheck = mysql_query($Sql_post_check);
							$result_row_check = mysql_num_rows($Result_postCheck);
							if($result_row_check >0)
							{ ?>


								<div class="col-lg-12 dashnoard1">
								  <div class=" col-lg-9">
									<div class="dashnoard2">
									  <label> <?php echo $Rows_post_job['vchJobPostTitle'];?> </label>
									  <span>
									  <?php 
																if (strlen($Rows_post_job['vchJobPostDescription']) > 100)
																{
																echo substr($Rows_post_job['vchJobPostDescription'], 0, 100);

																}
																else
																{
																echo $Rows_post_job['vchJobPostDescription'];

																} ?>
									  </span>
									  <p> <?php echo date('Y-m-d', strtotime($Rows_post_job['VchJobPostDate'])); ?></p>
									</div>
								  </div>
								  <div class="col-lg-3 text-right">
									<div class=" right-buttons"> <a href="view.php?project_id=<?php echo $Rows_post_job['intJobPostId'];?>" id="" class="btn btn-warning">VIEW</a> <a class="btn btn-success" href="dashboard.php?job_id=<?php echo $Rows_post_job['intJobPostId']; ?>" onClick="return confirm('Are you sure you want to hide  it?');"><i class="fa fa-eye" aria-hidden="true"></i> </a> </div>
								  </div>
								</div>
						<?php }
							else{
								
								$currentdate=  date('Y-m-d');
								$currentdate= strtotime($currentdate);
								$ExpiredDate =  strtotime($Rows_post_job['vchExpiredDate']);
								if($ExpiredDate > $currentdate )
								{ ?>
									<div class="col-lg-12 dashnoard1">
								  <div class=" col-lg-9">
									<div class="dashnoard2">
									  <label> <?php echo $Rows_post_job['vchJobPostTitle'];?> </label>
									  <span>
									  <?php 
																if (strlen($Rows_post_job['vchJobPostDescription']) > 100)
																{
																echo substr($Rows_post_job['vchJobPostDescription'], 0, 100);

																}
																else
																{
																echo $Rows_post_job['vchJobPostDescription'];

																} ?>
									  </span>
									  <p> <?php echo date('Y-m-d', strtotime($Rows_post_job['VchJobPostDate'])); ?></p>
									</div>
								  </div>
								  <div class="col-lg-3 text-right">
									<div class=" right-buttons"> <a href="view.php?project_id=<?php echo $Rows_post_job['intJobPostId'];?>" id="" class="btn btn-warning">VIEW</a> <a class="btn btn-success" href="dashboard.php?job_id=<?php echo $Rows_post_job['intJobPostId']; ?>" onClick="return confirm('Are you sure you want to hide  it?');"><i class="fa fa-eye" aria-hidden="true"></i> </a> </div>
								  </div>
								</div>
							<?php 	} else
									{
											
											 
											
											
										 $Sql_post_delete = "delete from  tbl_job_post 
											
												where intJobPostId='".$Rows_post_job['intJobPostId']."'";
										$Result_postdelete = mysql_query($Sql_post_delete);
								}
							}	
								
							?>
						
						<?php
						}
						
						$count = $count+1;
						}
						} else {  ?>
							<div class="col-lg-12 dashnoard1">
							<h1>No Job Found</h1>
							</div>
							
						<?php }
						?>
				</div>

			</div>
	</div>
	</div>

 <div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close"  id="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Bidding Section</h4>
        </div>
        <div class="modal-body">
          <p id="data-time">You don't efficient token for this job. please purchase more token</p>
        </div>
        
      </div>
      
    </div>
  </div>
<!--------------->

</div>

<?php include_once("includes/footer.php");?>

</div>
</div>
<!------------>

<script type="text/javascript">
$(document).ready(function(){
   $( ".bid-bt-hide" ).click(function() 
	{
		
		var bid_bt_hide= $(this).attr('rel');
		var baseUrl = $("#base_url").val();
		alert(bid_bt_hide);
		return false;
		$.ajax({
		type: "POST",
		url: baseUrl+'/check-bid.php',
		data: {
			bid_bt :bid_bt
			
		},
		success: function(msg) 
		{
			if(msg==1)
			{
				$('#myModal').css('display','block');
			}
			
			return false;
		}

		});
	});
	
	$( "#close" ).click(function() {
	 $('#myModal').css('display','none');
	});
});
</script>
<!--------------------->
<!--------------->

</body>
</html>
