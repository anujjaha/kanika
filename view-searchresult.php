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
	include_once("includes/paging_class_front.php");
	
	$advSearchArray = array();
if(isset($_REQUEST['submitsrch']) and !empty($_REQUEST['submitsrch']))
{
$contr=@$_REQUEST["catSearch"];
$hourlyBudget=@$_REQUEST["hourlyBudget"];
$fixedBudget=@$_REQUEST["fixedBudget"];
$jobTitle=@$_REQUEST["jobTitle"];
$jobSkills=@$_REQUEST["jobSkills"];

$disp = "select tbl_category.*,tbl_job_post.*  from  tbl_job_post left join tbl_category on tbl_category.intCategoryID = tbl_job_post.vchJobWorkType where";

	$pagingVal = 'submitsrch=Go';
if($contr != '')
	{
		$contr = implode("','",$contr);
		
		$disp .=" intCategoryID IN('".$contr."')  OR";
		
		foreach($_REQUEST["catSearch"] as $contVal)
		{
			$pagingVal.='&catSearch[]='.$contVal;	
		}

	}
if($jobTitle != '')
	{
		$disp .="	vchJobPostTitle like '%".$_REQUEST["jobTitle"]."%'  OR";
		$pagingVal.='&srname='.$jobTitle;
	}
	
if($jobSkills != '')
	{
		$disp .="	vchJobSkill like '%".$_REQUEST["jobSkills"]."%'  OR";
		$pagingVal.='&srskill='.$jobSkills;
	}

if($hourlyBudget != '')
	{
		$disp .="	bidpricetype like '%".$_REQUEST["hourlyBudget"]."%'  OR";
		$pagingVal.='&srtypehourly='.$hourlyBudget;
	}
	
if($fixedBudget != '')
	{
		$disp .="	bidpricetype like '%".$_REQUEST["fixedBudget"]."%'  OR";
		$pagingVal.='&srtypefixed='.$fixedBudget;
	}
	
   $disp1= (substr($disp,0,-3));
	
	
	
	if(!isset($_REQUEST['pagesVal']) and empty($_REQUEST['pagesVal'])){
		
		$pageValue = 10;
	}	
	else {
		$pageValue = $_REQUEST['pagesVal'];
	}	
	
	$paging = new PagedResults($pageValue);
	$paging->TotalResults = table_query_count($disp1);
	$InfoArray = $paging->InfoArray();
	$disp1.=" LIMIT ".$InfoArray["MYSQL_LIMIT1"].", ".$InfoArray["MYSQL_LIMIT2"];
	$PageVarName = 'client_page';
	$pageDisplay = getlistFront($InfoArray["CURRENT_PAGE"],$InfoArray["PREV_PAGE"],$InfoArray["NEXT_PAGE"],$InfoArray["TOTAL_PAGES"],$PageVarName,'yes',$pagingVal);	
	$currentPage = $InfoArray["CURRENT_PAGE"];
	$totalPagesAp = $InfoArray["TOTAL_PAGES"];
	// Paging code ends //
	
	$result=mysql_query($disp1) or die("query failed".mysql_error()); 
	while($rowResults = mysql_fetch_assoc($result))
		array_push($advSearchArray,$rowResults);
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
                if(sizeof($advSearchArray)>0) 
                {
                     $incValue = 1;
					 for($a=0; $a<sizeof($advSearchArray); $a++)
					 {
				?>
                
                <tr>
                    <td> <?php echo $incValue; ?></td>
                    <td> <?php echo $advSearchArray[$a]['vchJobPostTitle'];  ?></td> 
                    <td> <?php echo $advSearchArray[$a]['vchJobPostZipCode'];  ?></td>
                    <td> <a class='btn btn-success' href='view-jobs-viewer.php?jobid=<?php echo $advSearchArray[$a]['intJobPostId'];  ?>'> VIEW </a> </td>
                </tr>
               <?php
			   		$incValue++; 	  
					}        
                }
				else
				{
					echo "<tr><td colspan='12'>No Record(s) Available.</td></tr>";
				}
            ?>
		
			
			</tbody>
            <tr>
		 
         </tr>
			</table>
			<?php if(@$totalPagesAp>1) { ?>
                <div class="paging" style="text-align:center;">
                    <span class="nav"><?php echo $pageDisplay; ?></span>
                </div>
			<?php } ?>
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
