<?php

class ViewObject
{
	####
	#	a viewObject is used for describing the way data from a DataObject is shown
	#
	####

	public $name;
	public $title;
	public $dataObject;
	public $style;
	public $format;			//ViewFormat
	
	/////////////////////
	////// GETTERS //////
	
	function getTitle()
	{
		return $this->title;
	}
	
	////// END GETTERS //////
	/////////////////////////
	
	function __construct($sName = "", $sTitle = "", $dDataObject = NULL, $format = NULL, $style = "")
    {
		$this->name 		= $sName;
		$this->title 		= $sTitle;
		$this->dataObject 	= $dDataObject;
		$this->format 		= $format;
		$this->style 		= $style;
		
    }

    function __destruct()
    {

    }
	
	##
	# creates and returns an array with all the formatted data from the dataObject 
	#
	##	
	function getFormattedData()
	{		
		$indexName = NULL;			//the field name that should be used as the index, for example: "date" for showing a date as index.
		$valueName = NULL;			//the field name that should be used for the value 

		if($this->dataObject != NULL)
		{
			$data = $this->dataObject->getData();
			
			if($data != NULL)
			{
				if($this->format != NULL){
					$indexName = $this->format->getIndexName();
					$valueName = $this->format->getValueName();
				}

				unset($ret);
				foreach($data as $key => $dat)
				{
					
					if(is_array($dat) && ($indexName != NULL || $indexName != ""))	//an index value is set
					{
						if($valueName == NULL || $valueName == "")					//if no valueName is given, take the first element
							$ret[$dat[$indexName]] = current($dat); 
						else
							$ret[$dat[$indexName]] = $dat[$valueName]; 
					}
					else if(is_array($dat))											//no index value is set, use standard 0, 1, 2 etc.
					{
						if($valueName == NULL || $valueName == "")					//if no valueName is given, take the first element
							$ret[$key] = current($dat); 
						else
							$ret[$key] = $dat[$valueName]; 
					}
					else
					{
						$ret[$key] = $dat; 												//the array is not multidimensional
					}
				
				}
				
				return $this->maskIndex($ret);
				
			}
		}
		return NULL;
			
	}
	function getFormattedData1()
	{		
		$indexName = NULL;			//the field name that should be used as the index, for example: "date" for showing a date as index.
		$valueName = NULL;			//the field name that should be used for the value 

		if($this->dataObject != NULL)
		{
			$data = $this->dataObject->getData();
			if($data != NULL)
			{
				if($this->format != NULL){
					$indexName = $this->format->getIndexName();
					$valueName = $this->format->getValueName();
				}

				unset($ret);
				foreach($data as $dat)
				{
					if(is_array($dat) && ($indexName != NULL || $indexName != ""))	//an index value is set
					{
						if($valueName == NULL || $valueName == "")					//if no valueName is given, take the first element
							$ret[$dat[$indexName]] = current($dat); 
						else
							$ret[$dat[$indexName]] = $dat[$valueName]; 
					}
					else if(is_array($dat))											//no index value is set, use standard 0, 1, 2 etc.
					{
						if($valueName == NULL || $valueName == "")					//if no valueName is given, take the first element
							$ret[] = current($dat); 
						else
							$ret[] = $dat[$valueName]; 
					}
					else
						$ret[] = $dat; 												//the array is not multidimensional
				
				}
				return $ret;
				
			}
		}
		return NULL;
			
	}
	
	##
	#	example of an indexMask: 
	#	$maskTable = array(
	#		"day1" => "d1", 
	#		"day2" => "d2",
	#		"day3" => "d3"
	#	);
	##
	function maskIndex($dataObject = NULL)
	{
		unset($ret);
		if($this->format != NULL){
			$indexMask = $this->format->getIndexMask();				//if available: get mask
		}
		foreach($dataObject as $key => $item)
		{
			if(isset($indexMask[$key]))
				$key = $indexMask[$key];							//set the masked index as the new index
			$ret[$key] = $item;				
		}
		return $ret;
	}
	

	
}

?>