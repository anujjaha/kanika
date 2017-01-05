<?php 
include('connection.php');
session_start();
if($_SESSION['user_id']=='')
{
	header('location:index.php');
	exit();
}
if(isset($_SESSION['user_id']) &&  $_SESSION['user_id']!='')
{
	$Sql = "select vchFirst_Name,vchLast_Name,vchUserImage,vchToken from tbl_user where intUserID='".$_SESSION['user_id']."'";
	$result = mysql_query($Sql);
	$row_data = mysql_fetch_array($result);
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<div class="main-header1">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <div class="logo">
            <label>Your</label>
            <span>Logo</span> </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
          <nav class="navbar navbar-inverse" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li> <a class="active" href="dashboard.php">Home</a> </li>
                <li> <a class="active" href="">Projects</a>
				<ul class="hides">
				   <li><a href="add-job-post.php">Add New Job</a></li>
				   <li><a href="view-jobs.php">View Job</a></li>
				   <li><a href="view-projects.php">View Project</a></li>
				</ul>				
				</li>
                <li>
					<a href="tokenhistory.php"> Tokens </a>
				</li>
                <li> 
					<a href="chatlist.php" title="Messages-List">
						<i class="fa fa-envelope"> 
							<span class="badge">
								<?php
								$Sql_msgcount = "select intProjectId FROM tbl_project_chatmsgs where chatmsgTo='".$_SESSION['user_id']."'";
								
								$result_msgcount = mysql_query($Sql_msgcount);
								echo $row_msgcount = mysql_num_rows($result_msgcount);
							?>
							</span>
						</i>
					</a> 
				</li>
				<li> 
					<a href="notifications.php" title="Notifications">
						<i class="fa fa-bell">
						<span class="badge">
							<?php
								$Sql_notificount = "select notificationID FROM tbl_notifications where notificationTo='".$_SESSION['user_id']."' AND stats='unread'";
								$result_notificount = mysql_query($Sql_notificount);
								echo $row_notificount = mysql_num_rows($result_notificount);
							?>
						</span>
						</i>
					</a> 
				</li>
				
              </ul>
            </div>
            <!-- /.navbar-collapse -->
          </nav>
        </div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12  text-left">
          <div class="welcome"><b>Welcome:</b> 
          <?php echo $row_data['vchFirst_Name'].' '.$row_data['vchLast_Name']; ?>
          <img  class="img-rounded" src="images/<?php echo $row_data['vchUserImage'];?>" alt="profile_icon" title="<?php echo $row_data['vchFirst_Name'].' '.$row_data['vchLast_Name']; ?>" />
          </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 text-right padding0">
          <div class="profile">
            <ul>
              <li><a href="">Profile</a>
                <ul class="hides">
                  <li><a href="#">Tokens: <?php echo number_format((float)$row_data['vchToken'], 2, '.', '');?></a></li>
                  <li><a href="edit_user.php?id=<?php echo $_SESSION['user_id'];?>">Edit Profile</a></li>
				  <li><a href="userprofile.php?id=<?php echo $_SESSION['user_id'];?>">View Profile</a></li>
                  <li><a href="logout.php?action=logout">Log out</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        
        
        <input type="hidden" name="base_url" id="base_url" value="http://rrtechnosolutions.in/freelance" />
      </div>
    </div>
  </div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="myModaltoken" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
	  	   <form action="add-token-money.php" method="post" id="my_form_token" novalidate   enctype="multipart/form-data">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Buy Token</b></h4>
        </div>
        <div class="modal-body">
          <p>1 Token = 1 USD Dollar</p>
			<div class="form-group">
			<label for="token">Token</label>
			<input type="text" class="form-control" id="earn_token" name="earn_token" style="width:50%;" required="true">
			<input type="hidden" class="form-control" id="token_user_id" name="token_user_id" value="<?php echo $_SESSION['user_id'];?>" />
			  
			</div>
			 <input name="submit" id="submit" type="submit" class="btn btn-default" id="token_id" value="Add Token">
			
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
	  </form>
      
    </div>
  </div>
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
		  $( "#my_form_token" ).submit(function( event ){ //on form submit       
        var proceed = true;
        //loop through each field and we simply change border color to red for invalid fields       
        $("#my_form_token input[required=true], #my_form_token textarea[required=true] ,#my_form_token select[required=true],#my_form_token radio[required=true],#my_form_token file[required=true]").each(function(){
                $(this).css('border-color',''); 
                if(!$.trim($(this).val())){ //if this field is empty 
                    $(this).css('border-color','red'); //change border color to red   
                   proceed = false; //set do not proceed flag
                }
                //check invalid number
				var intRegex = /^\d+$/;
				var str = $('#earn_token').val();
				if(intRegex.test(str)) {
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
		
		$("#my_form_token input[required=true], #my_form_token textarea[required=true]").keyup(function() { 
        $(this).css('border-color',''); 
        $("#result").slideUp();
    });
		

	});
	</script>
