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
?>
<?php 
/********** select tbl_user**********/
include('connection.php');
$Sql_msgcount = "select * from tbl_project_chatmsgs where tbl_project_chatmsgs.chatmsgTo='".$_SESSION['user_id']."' group by intProjectId";
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
			<th>Project Title</th>
			<!-- <th>Count Message </th> -->
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
					//echo"<pre>";
					//print_r($ResultMsgrow_new);
					?>
					<tr>
						<td><?php echo $srno;?></td>
						<td>
							<!-- <a href="#" data-toggle="modal" data-target="#myview_<?php echo $ResultMsgrow_new['intChatID'];?>"> -->
							<a href="chatlist-view.php?project_id=<?php echo $ResultMsgrow_new['intProjectId'];?>">	
								<?php //echo $ResultMsgrow_new['intProjectId'];
								
								$Sql_msgcount_user11 = "select * from tbl_job_post where intJobPostId='".$ResultMsgrow_new['intProjectId']."'";
										$Result_msgcount_user11 = mysql_query($Sql_msgcount_user11);
										$Result_msgcount_user_count11 = mysql_fetch_array($Result_msgcount_user11);
										echo $Result_msgcount_user_count11['vchJobPostTitle'];
								?></a>
								
								
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
								$Sql_chats = "select * from tbl_project_chatmsgs where intProjectId='".$ResultMsgrow_new['intProjectId']."' AND  (chatmsgTo='".$ResultMsgrow_new['chatmsgTo']."' OR chatmsgFrom='".$ResultMsgrow_new['chatmsgTo']."') order by intChatID DESC";
								$Chats_count = mysql_query($Sql_chats);
								$Chat_rows = mysql_num_rows($Chats_count);		
								
								if(count($Chat_rows) > 0)
								{
									while($ResultChatrow_new = mysql_fetch_array($Chats_count))
									{
										//echo"<pre>";
										//print_r($ResultChatrow_new); 
										//die();
										//$ResultChatrow_new['chatmsgFrom'];
										$Sql_msgcount_user = "select * from tbl_user where intUserID='".$ResultChatrow_new['chatmsgFrom']."'";
										$Result_msgcount_user = mysql_query($Sql_msgcount_user);
										$Result_msgcount_user_count = mysql_fetch_array($Result_msgcount_user);
										?>
										
									<p><?php echo $Result_msgcount_user_count['vchFirst_Name']?>: <?php echo $ResultChatrow_new['chatmsg']?></p>	
								<?php	}
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

						</td>
						<!-- <td><?php //echo $ResultMsgrow_new['chatmsg'];  <?php
								//$Sql_chats1 = "select * from tbl_project_chatmsgs where intProjectId='".$ResultMsgrow_new['intProjectId']."' AND  (chatmsgTo='".$ResultMsgrow_new['chatmsgTo']."' OR chatmsgFrom='".$ResultMsgrow_new['chatmsgTo']."') order by intChatID DESC";
								//$Chats_count1 = mysql_query($Sql_chats1);
								//echo $Chat_rows1 = mysql_num_rows($Chats_count1);		
								
								//if(count($Chat_rows1) > 0)
								//{
									// $replay_user =array();
									//while($ResultChatrow_new1 = mysql_fetch_array($Chats_count1))
									//{
										//echo"<pre>";
										//print_r($ResultChatrow_new1); 
								
										
										//$replay_user[] = $ResultChatrow_new1['chatmsgFrom'];
										
										
									//	?>
										
										
								<?php //	}
								// }
								
								?>  </td> -->
						<td class="text-center">
							<!-- <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#myreply">Reply <i class="fa fa-reply" style="color:#333;"></i></a> -->
							<a href="chatlist-view.php?project_id=<?php echo $ResultMsgrow_new['intProjectId'];?>" class="btn btn-warning" ><i class="fa fa-eye" style="color:#fff;"></i></a>
							<div class="modal fade" id="myreply" role="dialog">
							<div class="modal-dialog">

							<!-- Modal content -->
							<!--	<form action="" method="POST" id="my_form_token" novalidate   enctype="multipart/form-data">

								<div class="modal-content">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title"><b>Chat with Bidder</b></h4>
								</div>
								<div class="modal-body">
								<p></p>
								<div class="form-group">
								<label for="token">Send Your Message</label>
								<?php
							//$Sql_getids = "select * from tbl_job_post where intJobPostId='".$ResultMsgrow_new['intProjectId']."'";
								//$Chats_getcount = mysql_query($Sql_getids);
								//$Chat_getrows = mysql_num_rows($Chats_getcount);
								//$Chat_getrows_result = mysql_fetch_array($Chats_getcount);
								//$Chat_getrows_result['intJobPostUserId'];
								
								//echo"<pre>";
								//print_r($replay_user);
								//$a=array("a"=>"red","b"=>"green","c"=>"red");
								//print_r(array_unique($replay_user));
								
								//$a1 = array_unique($replay_user);
								//$a2 = array($_SESSION['user_id']);
								
								//$result = array_diff($a1, $a2);   
								 
								
								?>

								<textarea class="form-control" id="textmsg" name="textmsg" required="true"></textarea>

								<input type="hidden" value="<?php //echo $_SESSION['user_id']; ?>" name="FrmusrID">
								
								<input type="hidden" value="<?php //echo $result[0]; ?>" name="TousrID">

								<input type="hidden" value="<?php //echo $ResultMsgrow_new['intProjectId'];?>" name="PrjID">
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
					</tr> -->
					<?php 
					//$srno = $srno+1;
					
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
<!-- Modal -->
  
<!--------------->
<!--------------->
<?php include_once("includes/footer.php");?>

</div>
</div>
</body>
</html>
