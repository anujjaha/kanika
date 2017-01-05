<?php
/**
 * Ajax.php
 * Run Ajax Calls
 */

// Include Database Connection
include('connection.php');

/*
 * Get Child Categories
 *
 */
function getChildCategories()
{
	$parentCategoryId = $_REQUEST['category_id'];

	$query 	= "SELECT * FROM child_categories WHERE status = 1 && category_id = '" .$parentCategoryId. "' ";
	$result = mysql_query($query);
	$categories = array();

	while($row = mysql_fetch_assoc($result))
	{
		$categories[] = array(
			'id' => $row['id'],
			'title' => $row['title']
		);
	}

	$successStatus  = getSuccessStatus();
	$response 		= array_merge($successStatus,array("response" => $categories));
	setResponse($response);
}	

/*
 * Get Success Status
 *
 */
function getSuccessStatus()
{
	return array('status' => true);
}

/*
 * Set Response
 *
 */
function setResponse($data)
{
	echo json_encode($data);
	die;
}

$requestType = $_REQUEST['requestType'];

if($requestType = 'getChildCategories')
{
	getChildCategories();
}
?>