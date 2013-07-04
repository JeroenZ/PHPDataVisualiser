<?php

##
#	Use DOM for object retrieval
#
#
##
class SourceWeb extends DataSource
{
	public $wrapperTag;				//the tag that wraps around the content

	function __construct($sName = "", $path="", $wrapperTag=NULL)
    {
		parent::__construct($sName, SourceType::ST_WEB, $path);
		$this->wrapperTag = $wrapperTag;		
    }

    function __destruct()
    {

    }
	
	
	##
	#	get the source data and add 
	#
	##
	public function getSource($location=NULL)
	{
		//use a wrapper table
		
		$simple = file_get_contents($this->path);
	
		
		
		
		//create array
		
		if($wrapperTag != NULL || $wrapperTag != "")
			$this->getWrapperTag($vals);
		else
			$this->data = $vals;	

		//var_dump($array);
		//echo($html);
	}
	
	##
	#	loop through parsed data and create an array
	#
	##
	
	//create array
	function createXMLArray()
	{
		$simple = '<?xml version="1.0"?>
		<data>
		  <day1>
			  <name>Station 1</name>
			  <a>10</a>
			  <b>11</b>
			  <c>17</c>
		  </day1>
		  <day2>
			  <name>Station 1</name>
			  <a>15</a>
			  <b>15</b>
			  <c>11</c>
		  </day2>
		</data>';		
		//$simple = "<para><note>simple note</note></para>";
		$parser = xml_parser_create();
		xml_parse_into_struct($parser, $simple, $vals, $index);
		xml_parser_free($parser);
		//echo "Index array\n";
		//print_r($index);
		//echo "\nVals array\n";
		//print_r($vals);
		
		
		
		//var_dump($vals);
	}
	
	function tag2Array(&$data)
	{
		$levelArray = array("test1","test2","test3");
		$ret = NULL;
		
		while($data->next())
		{
			$retArr = array();
			$currentLevel = 0;
			foreach($levelArray as $lvlArr)
			{
				$retArray = $ret;
				//$ret[][$lvlArr] = 
			}
			
			//type == "open"		: go to higher level
			//type == "close"		: go to lower level
			//type == "complete"	: use "tag" as the index, use "value" as value
			//type == "cdata"		: discard
			
		}
		
		return $ret;
	}
	
	##
	#	loop through elements recursively
	#	if key == $wrapperTag add to $data
	#
	##
	function getWrapperTag($data)
	{
		foreach($data as $key => $dat)
		{
			if($key == $wrapperTag)
			{			
				$this->data = $dat;
				return true;		//exit function
			}
			
			if($this->getWrapperTag($dat) == true)	//continue down the tree
				return true;		//exit function
		}
		
	}
	
}

?>