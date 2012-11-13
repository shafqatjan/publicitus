<?php

class Paginate
{
	var $start = 1;
    var $limit = 10;
	var $num = 0;
	var $url = "";
	var $maxPages = 20;
	var $class = "tb_blue_td";
	var $numPages = 0;
	var $currentPage = 1;
     
	function __construct($limit, $num, $url, $maxPages)
	{
		$this->start = isset($_GET['start'])?intval($_GET['start']):1;
		
		if($this->start > intval($num))
			$this->start = 0;

		$this->limit = (int) $limit;
        $this->num = (int) $num;
        $this->url = $url;
        $this->maxPages = (int) $maxPages; //set to a default value of 20

        $this->interpretUrl();
        $this->calculate_numPages();
        $this->calculateCurrent();
     }

     function interpretUrl()
	 {
		$this->urlAppendString = "?"; 
		 
		if (strstr ($this->url, "?"))
			$this->urlAppendString = "&";
	}

	function calculate_numPages()
	{
		$this->numPages = ceil($this->num / $this->limit);
	}
	
	function calculateCurrent()
	{
		if ($this->start > $this->limit)
			$this->currentPage = ceil($this->start / $this->limit);
	}

	function getPreviousPage()
	{
		if ($this->currentPage > 1)
		{
			return "<a href='".$this->url.$this->urlAppendString."start=".
            ($this->start-$this->limit).
            "' title='Previous page'>&lt;</a>";
		}
	}

	function getNextPage()
	{
		if ($this->currentPage < $this->numPages)
		{
			return "<a href='".$this->url.$this->urlAppendString."start=".
            ($this->start+$this->limit).
            "' title='Next page'>&gt;</a>";
        }
	}

	function getFirstPage()
	{
		if ($this->currentPage > 1)
		{
			return "<a href='".$this->url.$this->urlAppendString."start=1' 
             title='First page'>&lt;&lt;</a>";
         }
	}

	function getLastPage()
	{
		if($this->currentPage < $this->numPages)
		{
			$start_val = (($this->num - fmod($this->num, $this->limit)) + 1);
			if ($start_val > $this->num)			
				$start_val = $start_val - $this->limit;
             
             return "<a href='".$this->url.$this->urlAppendString."start=".$start_val
             ."' title='Last page'>&gt;&gt;</a>";
		}

	}
	
	function getPaginationLinks()
	{
		$ar = array();
		$pageStart = 1;
		if(($this->currentPage-ceil($this->maxPages/2))>1)
			$pageStart =($this->currentPage-ceil($this->maxPages/2));
         
		 $pageEnd = $this->numPages;
		 if(($this->currentPage+ceil($this->maxPages/2))<$this->numPages)
		 	$pageEnd =($this->currentPage+ceil($this->maxPages/2));

         for ($i=$pageStart;$i<=$pageEnd;$i++)
		 	if ($i == $this->currentPage)
			 	$ar[$i] = "<span>".$i."</span>";
			else 
				$ar[$i] = "<a href='".$this->url.$this->urlAppendString."start=".((($i-1)*$this->limit)+1)."' title='Go to page ". $i ."'>".$i."</a>";
         
         return $ar;
	
	}

     function displayUl()
	 {
		 $first = $this->getFirstPage();
         $last = $this->getLastPage();
         $previous = $this->getPreviousPage();
         $next = $this->getNextPage();
         $arLinks = $this->getPaginationLinks();
         
		 $output = '';

         if (isset($first) && $first != '')
		 	$output .= ''.$first.'';

         if (isset($previous) && $previous != '')
		 	$output .= ''.$previous.'';

		while(list($i, $v) = each($arLinks))
			$output .= ''.$arLinks[$i].'';

         if (isset($next) && $next != '')
		 	$output .= ''.$next.'';

         if (isset($last) && $last != '')
		 	$output .= ''.$last.'';

         $output .= '';

         if(trim($output) == '<span>1</span>')
		 	$output = '';

		 return $output;         
	}
 
}

?>