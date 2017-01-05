<?php 
include('connection.php');

session_start();
$currentdata = date('Y-m-d H:i:s');
/********* update date in tbl_user*******/
if(isset($_POST['payment_gross']) && (isset($_POST['custom']) &&  $_SESSION['user_id']==$_POST['custom']))
{
	$Sql = "select vchToken from tbl_user where intUserID='".$_POST['custom']."'";
	$result_select = mysql_query($Sql);
	$row_data = mysql_fetch_array($result_select);
	$tokenAmount = $row_data['vchToken'] + $_POST['payment_gross'];
	
	$update_query ="update tbl_user set vchToken='".$tokenAmount."',tokenAmount='".$tokenAmount."' where intUserID='".$_POST['custom']."'";
	$Result = mysql_query($update_query);
	$insert_TokensHistory = "insert into tbl_token_history set 	intTokenPurchased='".$_POST['payment_gross']."',intTokenUserId='".$_SESSION['user_id']."', tokenPurchasedon='".$currentdata."'";
	mysql_query($insert_TokensHistory);
	
header('location:dashboard.php');
}
?>