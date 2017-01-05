<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Search Result</title>
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
	include('connection.php');
	$contr=@$_REQUEST["srcountry"];
	if($contr != '')
	{
		$contr = implode("','",$contr);
		
		//$disp .=" user_contrry like '%".$_REQUEST["srcountry"]."%' AND";
		$disp .=" user_contrry IN('".$contr."') AND";
		
		foreach($_REQUEST["srcountry"] as $contVal)
		{
			$pagingVal.='&srcountry[]='.$contVal;	
		}
		
		
		//$pagingVal.='&srcountry='.$_REQUEST["srcountry"][0];	
	}
	
	$num_rec_per_page='1';
		
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
	$start_from = ($page-1) * $num_rec_per_page; 
	$sql = "SELECT * FROM tbl_job_post where intJobPostUserId='".$_SESSION['user_id']."' LIMIT $start_from, $num_rec_per_page"; 
	$rs_result = mysql_query ($sql); //run the query
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
              <label>Search Result</label>
            </div>
			<form name="frmSearch" method="post" action="">
					
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
				while ($row = mysql_fetch_assoc($rs_result)) { 
			 ?> 
				<tr>
					<td><?php echo $row['intJobPostUserId']; ?></td>
					<td><?php echo $row['vchJobPostTitle']; ?></td>
					<td><?php echo $row['intJobPostUserId']; ?></td>
					<td><?php echo $row['intJobPostUserId']; ?></td> 					
				</tr>
			 <?php 
				}; 
			 ?>
			
			</tbody>
			</table>
			<?php 
				$sql = "SELECT * from tbl_job_post where intJobPostUserId='".$_SESSION['user_id']."'"; 
				$rs_result = mysql_query($sql); //run the query
				$total_records = mysql_num_rows($rs_result);  //count number of records
				$total_pages = ceil($total_records / $num_rec_per_page); 

				echo "<a href='view-searchresult.php?page=1'>".'|<'."</a> "; // Goto 1st page  

				for ($i=1; $i<=$total_pages; $i++) { 
							echo "<a href='view-searchresult.php?page=".$i."'>".$i."</a> "; 
				}; 
				echo "<a href='view-searchresult.php?page=$total_pages'>".'>|'."</a> "; // Goto last page
			?>
          </div>
        </div>
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
