<?php 
if(isset($_GET['action']) && $_GET['action']=='logout')
{
	session_start() ;
    session_destroy();
	header('location:index.php');
}
?>