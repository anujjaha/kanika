<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Notification List</title>
<?php include_once("includes/common-links.php");?>
</head>
<body>
<div class="page">
<div id="wrapper">
  <!------------------>
  <div id="content">
<?php 
include_once("includes/header-inner.php");
?>
<?php 
/********** select tbl_user**********/
include('connection.php');
 $Sql_notify = "select tbl_job_post.*,tbl_notifications.* from tbl_notifications 
				
				Left join tbl_job_post on tbl_job_post.intJobPostId = tbl_notifications.notificationProjectId 
				where tbl_notifications.notificationTo='".$_SESSION['user_id']."'";
				
	$Noticount = mysql_query($Sql_notify);
	$Notirow = mysql_num_rows($Noticount);		
if(isset($_GET['id']) && $_GET['id'])
{
	
	$SQlupdaten= "update tbl_notifications set stats='read' where notificationID='".$_GET['id']."'";
	$Resultupdaetn = mysql_query($SQlupdaten);
	//header('location:notifications.php');
	?>
	<script>
		window.location.href="notifications.php";
	</script>
<?php 
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
              <label>Notification List </label>
            </div>
			<div class="search-box">
			</div>
			<?php 
				if(count($Notirow) > 0)
				{
					while($ResultMsgrow_new = mysql_fetch_array($Noticount))
					{ 
						?>
						<?php //echo $ResultMsgrow_new['notificationFrom'];
							$Sql_notify_user = "select  * from tbl_user where intUserID='".$ResultMsgrow_new['notificationFrom']."'";
							$Noticount_user = mysql_query($Sql_notify_user);
							$ResultMsgrow_new_user = mysql_fetch_array($Noticount_user);
							//echo"<pre>";
							//print_r($ResultMsgrow_new_user);
							?>
						<div class="col-lg-12 dashnoard1">
							<div class=" col-lg-12">
							<div class="dashnoard2">
								<div class=" col-lg-3">
									<a href="notifications.php?id=<?php echo  $ResultMsgrow_new['notificationID'];?>"><img style="width:80px;height:80px;border-radius:5px;" class="img-circle" src="images/<?php echo $ResultMsgrow_new_user['vchUserImage'];?>"></a>
								</div>
								<div class=" col-lg-9">
									<label><?php echo $ResultMsgrow_new['vchJobPostTitle'];?></label>
									<p><?php echo $ResultMsgrow_new_user['vchFirst_Name'].' '.$ResultMsgrow_new_user['vchLast_Name']; ?></p>
									<p><b><?php echo $ResultMsgrow_new['notificationStatus']; ?></b></p>
								</div>
							</div>
							</div>
							
						</div>
						
							
							
							
						<?php 
					}
				} 
			else 
			{ ?>
	  <tr><td colspan="8" style="text-align:center;">No Found</td></tr>
	  <?php } ?>
			</tbody>
			</table>
			</div>
        </div>
        <!----------------------->
        <!------------->
      </div>
    </div>
  </div>
  <!------------------------->
</div>
 <div class="modal " id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close"  id="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Bidding Section</h4>
        </div>
        <div class="modal-body">
          <p id="data-time">You have not efficient token for this job. please add more token</p>
        </div>
        
      </div>
      
    </div>
  </div>
<!--------------->
<?php include_once("includes/footer.php");?>

<script type="text/javascript">
$(document).ready(function(){
   $( ".bid-bt" ).click(function() 
	{
		
		var bid_bt= $(this).attr('rel');
		var project_id= $('#project_id').val();
		var baseUrl = $("#base_url").val();
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
			}else{
				window.location.href = "view-bid.php?project_id="+project_id;
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
</div>
</div>
</body>
</html>
