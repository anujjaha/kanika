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
<?php 
include_once("includes/header-inner.php");
/********** select tbl_user**********/
include('connection.php');

/******** end here ********************/

$Sql_post_job = "select tbl_user.*,tbl_job_post.*,tbl_job_post_bid.* from tbl_job_post_bid 
				Left join tbl_job_post on tbl_job_post.intJobPostId = tbl_job_post_bid.intProjectId
				Left join tbl_user on tbl_user.intUserID = tbl_job_post_bid.intUserId
where  intProjectId='".$_GET['project_id']."' order by intProjectId  desc";

$Result_post_job = mysql_query($Sql_post_job);
$Result_post_job_new = mysql_query($Sql_post_job);
$num_row = mysql_num_rows($Result_post_job);
$ResultPostData_new = mysql_fetch_array($Result_post_job_new);

//echo"<pre>";
//print_r($ResultPostData);
//die();
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
              <label>Project Bid List</label>
            </div>
            
            <div class="col-lg-12 dashnoard1">

            <?php 
				if($num_row > 0)
				{
					
				?>
				<label> 
                	<a href="view-job-view.php?jobid=<?php echo $ResultPostData_new['intProjectId']; ?>"><?php echo $ResultPostData_new['vchJobPostTitle']; ?> </a>
                </label>
                <p class="prbid"> Created on <?php echo date('Y-m-d', strtotime($ResultPostData_new['VchJobPostDate'])); ?></p>
                <?php
				while($ResultPostData = mysql_fetch_array($Result_post_job))
				{ 
				
				
				
				?>
                	<div class="col-lg-2">
                        <div class="dashnoard2">
                            <!--<p> <?php //echo $Rows_post_job['vchFirst_Name'].' '.$Rows_post_job['vchLast_Name'] ;?></p>-->
                            <a href="view-projects-bid-viewer.php?user_id=<?php echo $ResultPostData['intUserId'];?>&jobpost_id=<?php echo $ResultPostData['intJobPostId'];?>&viewbid_status=<?php echo $ResultPostData['intBidViewStatus'];?>" style="	text-decoration:none;">
                            <img src="images/<?php echo $ResultPostData['vchUserImage']; ?>">
                            <p class="text-center padding-top-bottom bidusertxt" > <?php echo $ResultPostData['vchFirst_Name'].' '.$ResultPostData['vchLast_Name'] ;?></p></a>
                        </div>
                    </div>
				<?php
				
				} 
				
				?>
                <div class="col-lg-12">
	                
                </div>
					</div>
                <?php } else {  ?>
					<div class="col-lg-12 dashnoard1">
					<h1>No Bid Found</h1>
					</div>
					
				<?php }	?>
          </div>
        </div>
        <!----------------------->
        <!------------->
      </div>
    </div>
  </div>
  <!------------------------->
</div>

<!--------------->
<?php include_once("includes/footer.php");?>
</div>
</div>
</body>
</html>
