<?php
	include('connection.php');
?>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="view_title1">
        <label>Search By Category :-</label>
    </div>
    <div class="search_category">
	<form name="categorySearch" method="GET" action="dashboard.php">
		<?php
			$html = '';
			$Sql_category 		= "select * from tbl_category";
			$Result_category 	= mysql_query($Sql_category);
			while($row_category = mysql_fetch_array($Result_category))
			{ 
				$html .= '<option value="' .$row_category['intCategoryID']. '">' .$row_category['intCategoryName']. '</option>';

				$subCategory = "select * from child_categories";
				$subResult = mysql_query($subCategory);
				while($subRowResult = mysql_fetch_array($subResult))
				{
					$html .= '<option value="childCategories-' .$subRowResult['id']. '"> ---' .$subRowResult['title']. '</option>';					
				}
			} 
		?>
		<select name="categoryFilter[]" class="form-control" multiple="multiple" style="height: 300px;">
			<?php echo $html;?>
		</select>
		<hr>

		<div class="design1">
			<input type="checkbox" name="hourlyBudget" value="Hourly"> <label>Hourly </label>
		</div>
        <div class="design1">
			<input type="checkbox" name="fixedBudget" value="Fixed Price"> <label>Fixed Price </label>
        </div>
		<hr>
		<div class="design1">
			<input type="text" name="jobTitle" placeholder="Job Title..." class="jobs">
		</div>
		<div class="design1">
			<input type="text" name="jobSkills" placeholder="Skills..." class="jobs">
		</div>
		<div class="design1">
        <input type="submit" name="submitsrch" value="Go" class="btn btn-primary" />
			<!--<button type="submit" name="catSearch" class="btn btn-primary">Go</button>-->
		</div>
		</form>
    </div>
</div>