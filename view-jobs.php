<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>View Jobs</title>
<?php include_once("includes/common-links.php");?>
</head>
<style>
.open-bt {
  background-color: #449d44;
  color: #fff !important;
}

</style>
<style>
#toys-grid {margin-bottom:30px;}
#toys-grid .txt-heading{background-color: #D3F5B8;}
#toys-grid table{width:100%;background-color:#F0F0F0;}
#toys-grid table td{background-color:#FFFFFF;}

.demoInputBox {padding: 10px;border: #F0F0F0 1px solid;border-radius: 4px;margin:0px 5px}
.btnSearch{padding: 10px;border: #F0F0F0 1px solid;border-radius: 4px;margin:0px 5px;}
.perpage-link{padding: 5px 10px;border: #C8EEFD 2px solid;border-radius: 4px;margin:0px 5px;background:#FFF;cursor:pointer;}
.current-page{padding: 5px 10px;border: #C8EEFD 2px solid;border-radius: 4px;margin:0px 5px;background:#C8EEFD;}
.btnEditAction{background-color:#2FC332;padding:2px 5px;color:#FFF;text-decoration:none;}
.btnDeleteAction{background-color:#D60202;padding:2px 5px;color:#FFF;text-decoration:none;}
#btnAddAction{background-color:#09F;border:0;padding:5px 10px;color:#FFF;text-decoration:none;}
#frmToy {border-top:#F0F0F0 2px solid;background:#FAF8F8;padding:10px;}
#frmToy div{margin-bottom: 15px}
#frmToy div label{margin-left: 5px}
.error{background-color: #FF6600;border:#AA4502 1px solid;padding: 5px 10px;color: #FFFFFF;border-radius:4px;}
.info{font-size:.8em;color: #FF6600;letter-spacing:2px;padding-left:5px;}
h2{background:#CCCCCC;padding:10px;}
</style>
<body>
<div class="page">
  <div id="wrapper">
  <!------------------>
  <div id="content">
  <?php include_once("includes/header-inner.php");?>
  <?php 
/********** select tbl_user**********/
include('connection.php');


/**************** function of paging **************/
function perpage($count, $per_page = '10',$href) {
		$output = '';
		$paging_id = "link_perpage_box";
		if(!isset($_POST["page"])) $_POST["page"] = 1;
		if($per_page != 0)
		$pages  = ceil($count/$per_page);
		if($pages>1) {
			
			if(($_POST["page"]-3)>0) {
				if($_POST["page"] == 1)
					$output = $output . '<span id=1 class="current-page">1</span>';
				else				
					$output = $output . '<input type="submit" name="page" class="perpage-link" value="1" />';
			}
			if(($_POST["page"]-3)>1) {
					$output = $output . '...';
			}
			
			for($i=($_POST["page"]-2); $i<=($_POST["page"]+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($_POST["page"] == $i)
					$output = $output . '<span id='.$i.' class="current-page" >'.$i.'</span>';
				else				
					$output = $output . '<input type="submit" name="page" class="perpage-link" value="' . $i . '" />';
			}
			
			if(($pages-($_POST["page"]+2))>1) {
				$output = $output . '...';
			}
			if(($pages-($_POST["page"]+2))>0) {
				if($_POST["page"] == $pages)
					$output = $output . '<span id=' . ($pages) .' class="current-page">' . ($pages) .'</span>';
				else				
					$output = $output . '<input type="submit" name="page" class="perpage-link" value="' . $pages . '" />';
			}
			
		}
		return $output;
	}
	
	function showperpage($sql, $per_page = 10, $href) {
		//global $wpdb;
		//$result = $wpdb->get_results($sql);
		//$count  = $wpdb->num_rows;
		$result  = mysql_query($sql);
		$count   = mysql_num_rows($result);
		
		$perpage = perpage($count, $per_page,$href);
		return $perpage;
	}


//$Sql = "select * from tbl_job_post where  intJobPostUserId='".$_SESSION['user_id']."' order by 	intJobPostId desc";
//$Result = mysql_query($Sql);



	$name = "";
	$code = "";
	
	$queryCondition = "";
	if(!empty($_POST["search"])) {
		foreach($_POST["search"] as $k=>$v){
			if(!empty($v)) {

				$queryCases = array("name","code");
				if(in_array($k,$queryCases)) {
					if(!empty($queryCondition)) {
						$queryCondition .= " ";
					} else {
						$queryCondition .= "  ";
					}
				}
				
				switch($k) {
					case "name":
						$name = $v;
						$queryCondition .= " AND vchJobPostTitle LIKE '%" . $v . "%'";
						break;
					case "code":
						$code = $v;
						$queryCondition .= "AND vchJobPostZipCode LIKE '%" . $v . "%'";
						break;
				}
			}
		}
	}
	$orderby = " ORDER BY intBidId desc"; 
	//
	$sql = "select tbl_user.*,tbl_job_post.*,tbl_job_post_bid.* from tbl_job_post_bid 
				Left join tbl_job_post on tbl_job_post.intJobPostId = tbl_job_post_bid.intProjectId
				Left join tbl_user on tbl_user.intUserID = tbl_job_post_bid.intUserId where tbl_job_post_bid.intUserId='".$_SESSION['user_id']."' AND intBidViewStatus='1'" . $queryCondition;
	$href = 'index.php';					
		
	$perPage = 10; 
	$page = 1;
	if(isset($_POST['page'])){
		$page = $_POST['page'];
	}
	$start = ($page-1)*$perPage;
	if($start < 0) $start = 0;
		
	 $query =  $sql . $orderby .  " limit " . $start . "," . $perPage; 

	
	//$result = $db_handle->runQuery($query);
	//$result = $wpdb->get_results($query);
	$result = runQuery($query);
	
	if(!empty($result)) {
		$result["perpage"] = showperpage($sql, $perPage, $href);
	}
	function runQuery($query) {
		
		$result = mysql_query($query);
		
		while($row=mysql_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}

/******** end here ********************/


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
              <label>Jobs Information </label>
            </div>
			 <form name="frmSearch" method="post" action="">
			<div class="search-box">
			<p><input type="text" placeholder="Project Title" name="search[name]" class="demoInputBox" value="<?php echo $name; ?>"	/><input type="text" placeholder="Zip Code" name="search[code]" class="demoInputBox" value="<?php echo $code; ?>"	/><input type="submit" name="go" class="btnSearch" value="Search"></p>
			</div>
			<table class="table table-bordered">
			<thead>
			<tr>
			<th>Project Id</th>
			<th>Project Title</th>
			<th>Zip Code</th>
			<th>Action</th>
			</tr>
			</thead>
			<tbody>
			 <?php 
			if(count($result) > 0)
			{
				foreach($result as $k=>$v)
				{ 
					if(is_numeric($k)) 
					{
						
					?>
					<tr>
						<td><?php echo $result[$k]['intProjectId'];?></td>
						<td><a href="view-job-view.php?jobid=<?php echo $result[$k]['intProjectId']; ?>">
						
						<?php 
						
						echo $result[$k]['vchJobPostTitle'];?></a></td>
						<td><?php //echo $result[$k]['vchJobPostZipCode'];
						
						$sql_Zip = "select * from tbl_job_post_multizipcode where intProjectId='".$result[$k]['intJobPostId']."'";
						$Result_Zip_Code = mysql_query($sql_Zip);
						$arr = array();
						while($Row_Zip_Code = mysql_fetch_array($Result_Zip_Code))
						{
							$arr[]  = $Row_Zip_Code['intMultizipCode'];
						}
						echo $new_zip_id =  implode(",",$arr);
						?>
						</td>
						<td><a class="btn btn-success open-bt" href="view-job-view.php?jobid=<?php echo $result[$k]['intProjectId']; ?>"> View </a> </td>
					</tr>
					<?php 
					} 
				}
			} 
			else 
			{ ?>
	  <tr><td colspan="8" style="text-align:center;">No Found</td></tr>
	  <?php } ?>
	<?php 
	if(isset($result["perpage"])) {
					?>
					<tr>
					<td colspan="10" align=right> <?php echo $result["perpage"]; ?></td>
					</tr>
					<?php } ?>
			
			</tbody>
			</table>
			</form>
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
