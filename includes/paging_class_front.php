<?php
class PagedResults 
{
   /* These are defaults */
   var $TotalResults;
   var $CurrentPage = 1;
   var $PageVarName = "client_page";
  var $ResultsPerPage;
   var $LinksPerPage = 10;
   
   function PagedResults($pageno)
   {
		$this->ResultsPerPage = $pageno;
   }
   function InfoArray() 
   {
      $this->TotalPages = $this->getTotalPages();
      $this->CurrentPage = $this->getCurrentPage();
      $this->ResultArray = array(
                           "PREV_PAGE" => $this->getPrevPage(),
                           "NEXT_PAGE" => $this->getNextPage(),
                           "CURRENT_PAGE" => $this->CurrentPage,
                           "TOTAL_PAGES" => $this->TotalPages,
                           "TOTAL_RESULTS" => $this->TotalResults,
                           "PAGE_NUMBERS" => $this->getNumbers(),
                           "MYSQL_LIMIT1" => $this->getStartOffset(),
                           "MYSQL_LIMIT2" => $this->ResultsPerPage,
                           "START_OFFSET" => $this->getStartOffset(),
                           "END_OFFSET" => $this->getEndOffset(),
                           "RESULTS_PER_PAGE" => $this->ResultsPerPage,
						   
                           );
      return $this->ResultArray;
   }

   /* Start information functions */
   function getTotalPages() 
   {
      $result = "";
	  /* Make sure we don't devide by zero */
      if($this->TotalResults != 0 && $this->ResultsPerPage != 0) 
	  {
         $result = ceil($this->TotalResults / $this->ResultsPerPage);
      }
      /* If 0, make it 1 page */
      if(isset($result) && $result == 0) 
	  {
         return 1;
      } else 
	  {
         return $result;
      }
   }

   function getStartOffset() 
   {
      $offset = $this->ResultsPerPage * ($this->CurrentPage - 1);
      if($offset != 0) { $offset; }
      return $offset;
   }

   function getEndOffset() 
   {
      if($this->getStartOffset() > ($this->TotalResults - $this->ResultsPerPage)) 
	  {
         $offset = $this->TotalResults;
      } 
	  elseif($this->getStartOffset() != 0) 
	  {
         $offset = $this->getStartOffset() + $this->ResultsPerPage - 1;
      } 
	  else 
	  {
         $offset = $this->ResultsPerPage;
      }
      return $offset;
   }

   function getCurrentPage() {
      if(isset($_GET[$this->PageVarName])) {
         return $_GET[$this->PageVarName];
      } else {
         return $this->CurrentPage;
      }
   }

   function getPrevPage() {
      if($this->CurrentPage > 1) {
         return $this->CurrentPage - 1;
      } else {
         return false;
      }
   }

   function getNextPage() {
      if($this->CurrentPage < $this->TotalPages) {
         return $this->CurrentPage + 1;
      } else {
         return false;
      }
   }
   function getStartNumber() 
   {
      $links_per_page_half = $this->LinksPerPage / 2;
      /* See if curpage is less than half links per page */
      if($this->CurrentPage <= $links_per_page_half || $this->TotalPages <= $this->LinksPerPage) 
	  {
         return 1;
      /* See if curpage is greater than TotalPages minus Half links per page */
      } 
	  elseif($this->CurrentPage >= ($this->TotalPages - $links_per_page_half)) 
	  {
         return $this->TotalPages - $this->LinksPerPage + 1;
      } 
	  else 
	  {
         return $this->CurrentPage - $links_per_page_half;
      }
   }

   function getEndNumber() 
   {
      if($this->TotalPages < $this->LinksPerPage) 
	  {
         return $this->TotalPages;
      } 
	  else 
	  {
         return $this->getStartNumber() + $this->LinksPerPage - 1;
      }
   }

   function getNumbers() 
   {	$numbers="";
	  for($i=$this->getStartNumber(); $i<=$this->getEndNumber(); $i++) 
	  {
         $numbers[] = $i;
      }
      return $numbers;
   }
}
//class end


function table_query_count($sql)
{
	$query = mysql_query($sql);
	$data = mysql_affected_rows();
	return $data;
}

function getpagelist($current_page,$prev_page,$next_page,$total_page,$page_var_name)
{
	 $var_pagging='';
	 $location = BASENAME($_SERVER['PHP_SELF']);
	if($prev_page)
		 $var_pagging ='<a href="./'.$location.'?'.$page_var_name.'=1"><img src="../media/images/icn.first.gif" border="0" align="absmiddle" title="First page"></a>&nbsp;<a href="./'.$location.'?'.$page_var_name.'='.$prev_page.'"><img src="../media/images/icn.previous.gif" border="0" align="absmiddle" title="Previous page"></a>&nbsp;';
	elseif ($current_page < $total_page )
		  $var_pagging = " ";
	
	if($total_page > 1)
	{
		$var_pagging .= "<select name=showpagelocation onchange=\"document.location.href='./$location?client_page='+this.value\">";
		for($i=1;$i<=$total_page;$i++)
		{
			if($i == $current_page)
			{
				$var_pagging .= "<option value=$i selected='selected'>$i</option>";
			}
			else
			{
				$var_pagging .= "<option value=$i>$i</option>";
			}	
		}
		$var_pagging .= "</select>&nbsp;";
	}		
	if($next_page)
		 $var_pagging .='<a href="./'.$location.'?'.$page_var_name.'='.$next_page.'"><img src="../media/images/icn.next.gif" border="0" align="absmiddle" title="Next page"></a>&nbsp;<a href="./'.$location.'?'.$page_var_name.'='.$total_page.'"><img src="../media/images/icn.last.gif" border="0" align="absmiddle" title="Last page"></a>';
	elseif ($current_page < $total_page )
		 $var_pagging .='Next';

	
	return $var_pagging ;
}


function getlistFront($current_page,$prev_page,$next_page,$total_page,$page_var_name,$isParam,$condParam)
{
	 $var_pagging='';
	 $location = BASENAME($_SERVER['PHP_SELF']);
	 
	if($isParam=="yes")
	{
		if($prev_page)
			 $var_pagging ='<a href="./'.$location.'?'.$condParam.'&'.$page_var_name.'=1" class="first">First</a>&nbsp;<a href="./'.$location.'?'.$condParam.'&'.$page_var_name.'='.$prev_page.'" class="prev">Previous</a>&nbsp;';
		elseif ($current_page < $total_page )
			  $var_pagging = "First Previous&nbsp;&nbsp;";
	
	}
	else
	{
		if($prev_page)
			 $var_pagging ='<a href="./'.$location.'?'.$page_var_name.'=1" class="first">First</a>&nbsp;<a href="./'.$location.'?'.$page_var_name.'='.$prev_page.'" class="prev">Previous</a>&nbsp;';
		elseif ($current_page < $total_page )
			  $var_pagging = "First Previous&nbsp;&nbsp;";
	
	}
	
	if($total_page > 1)
	{
		if($isParam=="yes")
		{
		
			$var_pagging .= "<select class=fl name=showpagelocation onchange=\"document.location.href='./$location?$condParam&client_page='+this.value\" style=\"width:70px; background-color:#f2f2f2; border:1px solid #cccccc;\">";
			for($i=1;$i<=$total_page;$i++)
			{
				if($i == $current_page)
				{
					$var_pagging .= "<option value=$i selected='selected'>$i</option>";
				}
				else
				{
					$var_pagging .= "<option value=$i>$i</option>";
				}	
			}
			$var_pagging .= "</select>&nbsp;";
	
		}
		else
		{
			$var_pagging .= "<select class=fl name=showpagelocation onchange=\"document.location.href='./$location?client_page='+this.value\" style=\"width:70px; background-color:#f2f2f2; border:1px solid #cccccc;\">";
			for($i=1;$i<=$total_page;$i++)
			{
				if($i == $current_page)
				{
					$var_pagging .= "<option value=$i selected='selected'>$i</option>";
				}
				else
				{
					$var_pagging .= "<option value=$i>$i</option>";
				}	
			}
			$var_pagging .= "</select>&nbsp;";
		
		
		
		}
	
	}		

	if($isParam=="yes")
	{

	if($next_page)
		 $var_pagging .='<a href="./'.$location.'?'.$condParam.'&'.$page_var_name.'='.$next_page.'" class="next">Next</a>&nbsp;<a class="last" href="./'.$location.'?'.$condParam.'&'.$page_var_name.'='.$total_page.'">Last</a>';
	else
		 $var_pagging .='Next Last';		 
	/*elseif ($current_page < $total_page )
		 $var_pagging .='Next';*/

	}
	else
	{
		if($next_page)
		 $var_pagging .='<a href="./'.$location.'?'.$page_var_name.'='.$next_page.'" class="next">Next</a>&nbsp; <a class="last" href="./'.$location.'?'.$page_var_name.'='.$total_page.'">Last</a>';
	else
		 $var_pagging .='Next Last';		 
	/*elseif ($current_page < $total_page )
		 $var_pagging .='Next';*/
	
	
	}

	
	return $var_pagging ;
}




function getsubquerystring($param)
{
	$subquerysting = array();
	$querystring = explode('&',$_SERVER['QUERY_STRING']);
	foreach($querystring as $val)
	{
		$tempvar = explode('=',$val);
		if($tempvar[0] == $param)
			continue;
		else
			array_push($subquerysting,$val);
	}
	return implode('&',$subquerysting);
}
?> 
