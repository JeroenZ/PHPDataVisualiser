<?php

class DataCalculationValueObject extends DataObject
{
	public $dataObject;		//the data object this object is a copy of
	public $indexName;		//the field name that should be used as the index, for example: "date" for showing a date as index.
	public $valueName;		//the field name that should be used for the value 
	
	function __construct($dataObject, $indexName = NULL, $valueName = NULL)
    {		
		parent::__construct($dataObject->getName(), $dataObject->getData());
		$this->dataObject = $dataObject;
		$this->type 		= DataObjectType::DOT_CalcValue;	
		$this->indexName	= $indexName;
		$this->valueName	= $valueName;	

    }
	
	function getIndexName()
	{
		return $this->indexName;
	}
	
	function getValueName()
	{
		return $this->valueName;
	}

    function __destruct()
    {

    }
	
	function update()
	{
	
	}
	
	function getFormattedData()
	{		
	
		if($this->dataObject != NULL)
		{
			$data = $this->getData();
			
			if($data != NULL)
			{
				unset($ret);
				foreach($data as $key => $dat)
				{
					
					if(is_array($dat) && ($this->indexName != NULL || $this->indexName != ""))	//an index value is set
					{
						if($this->valueName == NULL || $this->valueName == "")					//if no valueName is given, take the first element
							$ret[$dat[$this->indexName]] = current($dat); 
						else
							$ret[$dat[$this->indexName]] = $dat[$this->valueName]; 
					}
					else if(is_array($dat))														//no index value is set, use standard 0, 1, 2 etc.
					{
						if($this->valueName == NULL || $this->valueName == "")					//if no valueName is given, take the first element
							$ret[$key] = current($dat); 
						else
							$ret[$key] = $dat[$this->valueName]; 
					}
					else
					{
						$ret[$key] = $dat; 												//the array is not multidimensional
					}
				
				}
				return $ret;
				
			}
		}
		return NULL;
			
	}
	
	
}

?>