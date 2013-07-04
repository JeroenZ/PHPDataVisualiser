<?php

class DataObjectType
{
	const DOT_DataObject 	= 0;
    const DOT_DataSource 	= 1;
    const DOT_Calculation 	= 2;	
	const DOT_CalcValue 	= 3;	
}

class DataObject
{
	public $type;
	public $name;
	public $data;			//array to store the data in
	public $format;

	function __construct($sName, $data=NULL, $format="")
    {
		$this->name 		= $sName;
		$this->data			= $data;
		$this->format		= $format;
		$this->type 		= DataObjectType::DOT_DataObject;		//Standard tpye is DOT_DataObject
    }

    function __destruct()
    {

    }
	
	/////////////////////
	////// GETTERS //////
	
	function getName()
	{
		return $this->name;
	}
	
	function getData()
	{
		return $this->data;
	}
	
	function getType()
	{
		return $this->type;
	}
	
	////// END GETTERS //////
	/////////////////////////
	
	
	/////////////////////
	////// SETTERS //////
	
	
	
	////// END SETTERS //////
	/////////////////////////
	function fillDataFromSource($targetSource = NULL)
	{
		if($targetSource == NULL)
		{
			if($this->dataSource != NULL)
				$targetSource = $this->dataSource;
			else
				return NULL;
		}
		
			
		//todo: fill data
		
		return $this->data;
			
	}
	
	

	
}

?>