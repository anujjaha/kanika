<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Chat List</title>
<?php include_once("includes/common-links.php");?>
</head>
<body>
<div class="page">
<div id="wrapper">
  <!------------------>
  <div id="content">
<?php 
include_once("includes/header-inner.php");
$project_id = $_GET['project_id'];
/********** select tbl_user**********/
include('connection.php');
$Sql_msgcount = "select * from tbl_project_chatmsgs where intProjectId='".$_GET['project_id']."' AND  chatmsgFrom='".$_SESSION['user_id']."'  group by chatmsgTo";
//echo $Sql_msgcount = "select * from tbl_project_chatmsgs where intProjectId='".$_GET['project_id']."' AND (chatmsgTo='".$_SESSION['user_id']."' OR chatmsgFrom='".$_SESSION['user_id']."') group by chatmsgTo ";


$Result_msgcount = mysql_query($Sql_msgcount);
$num_msgrow = mysql_num_rows($Result_msgcount);

if(isset($_POST['chatSubmit']))
{
	$currentdata = date('Y-m-d H:i:s');
	$insert="insert into tbl_project_chatmsgs set intProjectId='".$_POST['PrjID']."',chatmsgFrom='".$_POST['FrmusrID']."',chatmsgTo='".$_POST['TousrID']."',chatmsg='".$_POST['textmsg']."',msgTime='".$currentdata."'";
	mysql_query($insert);
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
              <label>Messages Information </label>
            </div>
			<div class="search-box">
			</div>
			<table class="table table-bordered">
			<thead>
			<tr>
			<th>Sr. No</th>
			<th>Chat With</th>
			<th class="text-center">Action</th>
			</tr>
			</thead>
			<tbody>
			<?php 
			$srno='1';
			if(count($num_msgrow) > 0)
			{
				while($ResultMsgrow_new = mysql_fetch_array($Result_msgcount))
				{ 
				?>
					<tr>
						<td><?php echo $srno; ?></td>
						<td>
						<?php 
							$Sql_msgcount_user = "select * from tbl_user where intUserID='".$ResultMsgrow_new['chatmsgTo']."'";
							$Result_msgcount_user = mysql_query($Sql_msgcount_user);
							$Result_msgcount_user_count = mysql_fetch_array($Result_msgcount_user);
						?>
						<p><a href="#" data-toggle="modal" data-target="#myview_<?php echo $ResultMsgrow_new['intChatID'];?>"><?php echo $Result_msgcount_user_count['vchFirst_Name']?></a></p>	
									
									<div class="modal fade" id="myview_<?php echo $ResultMsgrow_new['intChatID'];?>" role="dialog">
							<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><b>Chat Messages with Bidder</b></h4>
							</div>
							<div class="modal-body">
							<p>
								<?php 
								$Sql_chats = "select * from tbl_project_chatmsgs where intProjectId='".$ResultMsgrow_new['intProjectId']."' AND  (chatmsgTo='".$_SESSION['user_id']."' AND chatmsgFrom='". $ResultMsgrow_new['chatmsgTo']."') OR  (chatmsgTo='".$ResultMsgrow_new['chatmsgTo']."' AND chatmsgFrom='".$_SESSION['user_id'] ."') order by intChatID DESC";
								
								
								//echo $UpdateTbl ="update tbl_project_chatmsgs set stats='1' where intProjectId='".$ResultMsgrow_new['intProjectId']."' AND  chatmsgTo='".$ResultMsgrow_new['chatmsgTo']."' AND chatmsgFrom='". $_SESSION['user_id']."'";
								
								//$result_table = mysql_query($UpdateTbl);
							
								$Chats_count = mysql_query($Sql_chats);
								$Chat_rows = mysql_num_rows($Chats_count);	
								if(count($Chat_rows) > 0)
								{
									while($ResultChatrow_new = mysql_fetch_array($Chats_count))
									{
										$Sql_msgcount_user = "select * from tbl_user where intUserID='".$ResultChatrow_new['chatmsgFrom']."'";
										$Result_msgcount_user = mysql_query($Sql_msgcount_user);
										$Result_msgcount_user_count = mysql_fetch_array($Result_msgcount_user);
								?>
								<p>
									<?php echo $Result_msgcount_user_count['vchFirst_Name']?>: <?php echo $ResultChatrow_new['chatmsg']?>
								</p>	
								<?php	
									}
									}
								?>
							</p>
							<div class="form-group">
							</div>
							</div>
							<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							</div>
							</div>
						</div>
									
									
								<?php	//}
								$srno = $srno+1;
								//} 
								
								?>
								
								</td>
						<td width="25%" align="center"><a href="#" class="btn btn-warning" data-toggle="modal" data-target="#myreply_<?php echo $ResultMsgrow_new['intChatID'];?>"><i class="fa fa-eye" style="color:#fff;"> Reply </i></a>
						<div class="modal fade" id="myreply_<?php echo $ResultMsgrow_new['intChatID'];?>" role="dialog">
							<div class="modal-dialog">

							<!-- Modal content-->
								<form action="" method="POST" id="my_form_token" novalidate   enctype="multipart/form-data">

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

								<input type="hidden" value="<?php echo $_SESSION['user_id']; ?>" name="FrmusrID">
								
								<input type="hidden" value="<?php echo $ResultMsgrow_new['chatmsgTo']; ?>" name="TousrID">

								<input type="hidden" value="<?php echo $ResultMsgrow_new['intProjectId'];?>" name="PrjID">
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
						
						
						
						</td>
					</tr>
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
<!-- Modal -->
<!--------------->
<?php include_once("includes/footer.php");?>

</div>
</div>
</body>
</html>
