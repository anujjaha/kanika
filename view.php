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
  <?php 
/********** select tbl_user**********/
include('connection.php');

$Sql_check = "select * from tbl_job_post_bid where intProjectId='".$_GET['project_id']."' AND  intUserId='".$_SESSION['user_id']."'";
$Result_check = mysql_query($Sql_check);
$total_count_place = mysql_num_rows($Result_check);

$Sql = "select * from tbl_job_post where  intJobPostId='".$_GET['project_id']."'";
$Result = mysql_query($Sql);
$Rows = mysql_fetch_array($Result);

/******** end here ********************/
$Sql_check_count = "select * from tbl_job_post_bid where intProjectId='".$_GET['project_id']."'";
$Result_check_count = mysql_query($Sql_check_count);
$total_count_check = mysql_num_rows($Result_check_count);
$total_count_check_row = mysql_fetch_array($Result_check_count);

/******** end here ********************/
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
          <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="view_title">
<h5>You Need Atleast 5 Tokens to bid project</h5>
			<div class="col-md-12">
			<div class="col-md-4">
              <label><?php if(isset($Rows['vchJobPostTitle']))  { echo $Rows['vchJobPostTitle'];} ?> </label>
			  </div>
			  <div class="col-md-8 alr-bt">
			  
				
			  </div>
			  </div>
            </div>
            <div class="view_desc1"><input type="hidden" name="base_url" id="base_url" value="http://rrtechnosolutions.in/freelance" />
             <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 padding0">
            <div class="view_bids">
            <ul>
            <li> Bids </br> <b>(<?php echo $total_count_check ;?>/5)</b> </li>
            <li style="border:none;"> Project Budget (USD) </br> <b><?php if(isset($Rows['vchJobPostBudget']) && $Rows['vchJobPostBudget']!=''){ 
			$exp_value= explode('-',$Rows['vchJobPostBudget']);
			echo '($'.$exp_value[0].'-'.'$'.$exp_value[1].')'; } ?></b></li>
            </ul>
            </div>
            </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 padding0 col-lg-offset-4 col-md-offset-4 ">
            <div class="view_bids">
               <!--<label>6 Days , 15 hours left </label>-->
			   <?php 
			   if($total_count_check_row['intBidAcceptStatus']==1)
			   { ?>
				   
				   <p class="btn btn-success open-bt"> CLOSE </p>
			<?php    }
			else
			{ 
				 if($total_count_check >=5) { ?>
            <p class="btn btn-success open-bt"> CLOSE </p>
			   <?php } else { ?><p class="btn btn-success open-bt"> OPEN </p> <?php } 
			 }
			   
			  ?>
            </div>
            </div>
             </div>
            <div class="view_desc"  style="margin-top:1%;">
              <label>Project Description</label>
              <p><?php echo $Rows['vchJobPostDescription'];?></p>
              <input type="hidden" id="project_id" name="project_id" value="<?php echo $Rows['intJobPostId'];?>" />
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
<h6>You Need Atleast 5 Tokens to bid project</h6>
                <div class="bid_button">
				<?php 
				if($total_count_check_row['intBidAcceptStatus']==1)
				{ ?>
					 <button type="button"  class="btn btn-primary active">Complete Bid</button>
			<?php	}else{
					if($total_count_check >=5) { ?>
				 <button type="button"  class="btn btn-primary active">Complete Bid</button>
				<?php } else {  ?>
                  <button type="button"  id="bid-bt" class="btn btn-primary bid-bt" rel="<?php echo $Rows['intJobPostId'];?>">Bid on this Project</button>
				<?php } 
				}
				?>
                </div>
              </div>
              <div class="col-lg-12 padding0 text-right">
                <p><b>Project Id:</b> <?php echo $_GET['project_id'];?></p>
              </div>
            </div>
			 <div class="free_lance" style="display: none;">
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
          <p id="data-time">You have not efficient token for this job. please purchase more token</p>
        </div>
        
      </div>
      
    </div>
  </div>
<!--------------->
<?php include_once("includes/footer.php");?>
<script>
$(function() {
var showTotalChar = 200, showChar = "More", hideChar = "Less";
$('.show').each(function() {
var content = $(this).text();
if (content.length > showTotalChar) {
var con = content.substr(0, showTotalChar);
var hcon = content.substr(showTotalChar, content.length - showTotalChar);
var txt= con +  '<span class="dots">...</span><span class="morectnt"><span>' + hcon + '</span>&nbsp;&nbsp;<a href="" class="showmoretxt">' + showChar + '</a></span>';
//$(this).html(txt);
}
});
$(".showmoretxt").click(function() {
if ($(this).hasClass("sample")) {
$(this).removeClass("sample");
$(this).text(showChar);
} else {
$(this).addClass("sample");
$(this).text(hideChar);
}
$(this).parent().prev().toggle();
$(this).prev().toggle();
return false;
});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
	
	
	$('.showmoretxt').on('click', function()  {
	
               $('.home-button').css('padding-bottom','10%');
					
    });

 $('.sample').on('click', function()  {
	
               $('.home-button').css('padding-bottom','0%');
					
    });
	
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
			}
			else if(msg==2)
			{
				//$('#myModal').css('display','block');
				$('.alr-bt').html('<div class="alert alert-info"><strong>Notice!</strong> you already have a successful bid on this Project</div>');
			}
			else{
				window.location.href = "view-bid.php?project_id="+project_id;
			}
			
			return false;
		}

		});
	});
	
	
	/*$( "#bid-bt" ).click(function() 
	{
		
		var bid_bt= $(this).attr('rel');
		
		var project_id= $('#project_id').val();
		var baseUrl = $("#base_url").val();
		$.ajax({
		type: "POST",
		url: baseUrl+'/check-bid.php',
		data: {
			bid_bt_id :project_id
			
			
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
	});*/
	
	$( "#close" ).click(function() {
	 $('#myModal').css('display','none');
	});
});
</script>
</div>
</div>
</body>
</html>
