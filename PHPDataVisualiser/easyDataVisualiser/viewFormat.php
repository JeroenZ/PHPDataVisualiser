<?php

class ViewFormat
{
	####
	#	a viewObject is used for describing the way data from a DataObject is shown
	#
	####

	public $indexName;		//use the index name (like "Date" or "0")
	public $valueName;		//The name of the value 
	public $indexMask;		//add a mask to the index. for example: d1 => day1	
		
	/////////////////////
	////// GETTERS //////
	
	
	function getIndexName()
	{
		return $this->indexName;
	}
	
	function getValueName()
	{
		return $this->valueName;
	}
	
	function getIndexMask()
	{
		return $this->indexMask;
	}
	
	////// END GETTERS //////
	/////////////////////////
	
	
	
	function __construct($sName = "", $sIndexName = "", $sValueName = "", $indexMask = NULL)
    {
		$this->name = $sName;
		$this->indexName = $sIndexName;
		$this->valueName = $sValueName;
		$this->indexMask = $indexMask;
    }

    function __destruct()
    {

    }
	
	

	
}

?>