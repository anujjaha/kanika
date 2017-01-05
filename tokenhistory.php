<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Tokens List</title>
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
	$Sql_Token_list = "select * from tbl_token_history where intTokenUserId='".$_SESSION['user_id']."' order by intTokenId DESC ";
	$result_Token_list = mysql_query($Sql_Token_list);
	$num_TokensRows = mysql_num_rows($result_Token_list);
	?>
  <!---------------1----------->
  <div class="freelanceview">
    <div class="container">
      <div class="row">
        <!---------------->
        <div class="col-md-12">
          <?php include('left-side.php');?>
          <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:right">
				<a class="active btn btn-warning" href="#" data-toggle="modal" data-target="#myModaltoken">Buy Tokens </a> 
			</div>
            <div class="view_title">
              <label>Tokens History </label>
            </div>
			
			<table class="table table-bordered">
				<thead>
				<tr style="background:#dd7300;color:#fff;">
					<th>Sr. No</th>
					<th>Tokens Purchased</th>
					<th>Purchased On</th>
				</tr>
				</thead>
				<tbody>
					 <?php 
						$srno='1';
						if($num_TokensRows > 0)
						{
							
							while($row_Token_listdata = mysql_fetch_array($result_Token_list))
							{ 
								?>
								<tr>
									<td><?php echo $srno;?></td>
									<td><?php echo $row_Token_listdata['intTokenPurchased'];?> Tokens</td>
									<td><b><?php echo date('F-j, Y', strtotime($row_Token_listdata['tokenPurchasedon']));?></b><br/>
									<?php echo date('H:i:s', strtotime($row_Token_listdata['tokenPurchasedon'])); ?>
									</td>
								</tr>
								<?php 
								$srno = $srno+1;
							}
						} 
						else 
						{ ?>
							<tr>
								<td colspan="8" style="text-align:center;">No Found</td>
							</tr>
						<?php 
						} 
						?>
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
<!--------------->
<?php include_once("includes/footer.php");?>

</div>
</div>
</body>
</html>
