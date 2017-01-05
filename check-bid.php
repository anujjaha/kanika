<?php 
include('connection.php');
session_start();
if(isset($_POST['bid_bt']) && $_POST['bid_bt']!='')
{
$Sql = "select vchToken from tbl_user where  intUserID='".$_SESSION['user_id']."'";
$Result = mysql_query($Sql);
$Rows = mysql_fetch_array($Result);
$Rows['vchToken'];

$Sql_post_job = "select vchJobPostTokenMoney from tbl_job_post where  intJobPostId='".$_POST['bid_bt']."'";
$Result_post_job = mysql_query($Sql_post_job);
$Rows_post_job = mysql_fetch_array($Result_post_job);
$Rows_post_job['vchJobPostTokenMoney'];
if($Rows['vchToken'] <  $Rows_post_job['vchJobPostTokenMoney'])
{
	echo 1;
	die();
}
else
{
	$Sql_check = "select * from tbl_job_post_bid where intProjectId='".$_POST['bid_bt']."' AND 
	intUserID='".$_SESSION['user_id']."'";
	$Result_check = mysql_query($Sql_check);
	$total_count_place = mysql_num_rows($Result_check);
	if($total_count_place > 0)
	{
		echo 2;
		die();
	}
	else
	{
		echo 3;
		die();
	}
}

}
/*if(isset($_POST['bid_bt_id']) && $_POST['bid_bt_id']!='')
{
	

}*/
?>