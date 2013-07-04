<?php
class CalculationType
{
	const CT_Undefined 		= 0;
	const CT_Multiply		= 1;
	const CT_Subtract		= 2;
	const CT_Sum			= 3;
	const CT_Divide			= 4;
	
}

##
#	The main function of this class is the ability to create a calculation with multiple DataObjects and still be able to use the result the same way as a normal DataObject
#
#	To use this class correctly first, the dataObjects should be attached to a DataCalculationObject with attachDataObjects() 
#	DataCalculationValueObjects will be created with the data of the DataObjects.
#	To fill the data within the DataCalculationObject, a arithmatic function should be called (multiply, subtract, sum, divide) 
#	After this the DataCalculationObject can be treated like an ordinary DataObject, and can also be used within another calculation.
##
class DataCalculationObject extends DataObject
{
	private $dataValueObjects;	//holds copies of given dataObjects
	public $calcType;
	public $value;
	public $indexMask;			//array useable for changing (a part of) the shown index to another name
	
	function __construct($sName, $data=NULL, $dataObjects=NULL, $value = NULL, $indexName = NULL, $valueName = NULL, $indexMask = NULL)
    {
		parent::__construct($sName, $data);
		
		
		$this->type 			= DataObjectType::DOT_Calculation;
		$this->dataValueObjects = array();
		$this->calcType			= CalculationType::CT_Undefined;	
		$this->value 			= $value;
		$this->indexMask		= $indexMask;
		$this->attachDataObjects($dataObjects, $indexName, $valueName);	
    }

    function __destruct()
    {

    }
	
	/////////////////////
	////// GETTERS //////
	
	function getDataValueObjects()
	{
		return $this->dataValueObjects;
	}
	
	////// END GETTERS //////
	/////////////////////////
	
	/////////////////////
	////// SETTERS //////
	
	function setIndexMask($indexMask = NULL)
	{
		$this->indexMask = $indexMask;
	}
	
	function setValue($value = 0)
	{
		$this->value = $value;
	}
	
	function setCalcType($calcType = CalculationType::CT_Undefined)
	{
		$this->calcType = $calcType;
	}
	
	////// END SETTERS //////
	/////////////////////////
	
	function calculate($calcType = 0)
	{
		
		if($calcType == 0)
			$calcType = $this->calcType;
			
		switch($calcType)
		{
			case CalculationType::CT_Multiply :
				$this->multiply();
				break;
			case CalculationType::CT_Subtract :
				$this->subtract();
				break;
			case CalculationType::CT_Sum :
				$this->sum();
				break;
			case CalculationType::CT_Divide :
				$this->divide();
				break;
			default:
				return false;
				break;
		}
		return true;
	}	
	
		
	##
	#	example of an indexMask: 
	#	$maskTable = array(
	#		"day1" => "d1", 
	#		"day2" => "d2",
	#		"day3" => "d3"
	#	);
	#	
	#
	##
	function maskIndex($dataObject = NULL, $indexMask = NULL)
	{
		unset($ret);
		if($indexMask == NULL)
			$indexMask = $this->indexMask;							//if available get mask

		foreach($dataObject as $key => $item)
		{
			if(isset($indexMask[$key]))
				$key = $indexMask[$key];							//set the masked index as the new index
			$ret[$key] = $item;				
		}
		return $ret;
	}
	
	function attachDataObjects($dataObjects, $indexName = NULL, $valueName = NULL)
	{
		//make copies of all given dataObjects and add them to dataValueObjects

		if($dataObjects == NULL)
			return false;
		
		if(is_array($dataObjects))		//when an array is given as input
		{		
			foreach($dataObjects as $dat)
			{				
				if($dat->getType() != DataObjectType::DOT_Calculation){
					$this->dataValueObjects[] = new DataCalculationValueObject($dat, $indexName, $valueName);
				}
				else{		//type == DOT_Calculation
					$this->dataValueObjects[] = $dat; 						//use a calculation in a new calculation
				}
			}
		}
		else							
		{
			$this->dataValueObjects[] = new DataCalculationValueObject($dataObjects, $indexName, $valueName);
		}		
	}
	
	function getFormattedDataValueObjects()
	{
		unset($ret);
		
		foreach($this->dataValueObjects as $valueObject)
		{			
			if($valueObject != NULL && $valueObject->getType() == DataObjectType::DOT_CalcValue)
			{
				$valObject = $valueObject->getFormattedData();
						
				if($valObject	!= NULL)	
				{
					$ret[] = $this->maskIndex($valObject);
				}
			}	
			else
			{
				$ret[] = $this->maskIndex($valueObject->getData());
			}	
		}
		return $ret;		
	}
	
	###
	#	Imput:
	#		$aDataObjects: 	array of type DataObject (or childs)
	#		$dValue: 		decimal value (optional)
	#	Description:
	#		First multiplies the aDataObjects with eachother on the corrensponding keys, after that, multiplies the values by dValue if not NULL
	# 	Note:
	#		The values will be multiplied from left to right (obj0 X obj1 X obj2 ... X dValue)
	#	TODO:
	#		add a variable to describe what to do with non-matching keys (show, don't show, alternative treatment etc. )
	#	returns, and sets the result to $this->data
	###
	function multiply($aDataObjects = NULL, $dValue = NULL)
	{
		$this->setCalcType(CalculationType::CT_Multiply);
		//example: price X quantity
		if($dValue != NULL && is_numeric($dValue)){
			$this->value = $dValue;		//save the new value 
		}
		else{
			$dValue = $this->value;		//use the current saved value
		}
			
		unset($ret);
		$formattedData = $this->getFormattedDataValueObjects();
		
		foreach($formattedData as $dataObj)
		{				
			if(!isset($ret))
			{	
				$ret = $dataObj;						//add the first value as reference
			}
			else
			{					
				foreach($dataObj as $key => $dat)		//loop through existing dataObjects
				{					
					if(!isset($ret[$key]))				//if index not found set 0 (x * 0 = 0)
						$ret[$key] = 0;
					else
						$ret[$key] *= ((float)$dat);	//multiply when found
				}	
				
				foreach($ret as $key => $dat)			//loop through ret: set a record to 0 if index is not not in current object 
				{						
					if(!isset($dataObj[$key]))
						$ret[$key] = 0;
				}					
			}	
		}				
		
		if($dValue != NULL && is_numeric($dValue))
		{
				foreach($ret as $key => $dat)
				{
					$ret[$key] *= ((float)$dValue);		//multiply all in ret with the value
					
				}	
		}
		$this->data = $ret;
		return $ret;			
	}
	
	###
	#	Imput:
	#		$aDataObjects: 	array of type DataObject (or childs)
	#		$dValue: 		decimal value (optional)
	#	Description:
	#		First subtract the aDataObjects from eachother on the corrensponding keys, after that, subtract with dValue if not NULL
	# 	Note:
	#		The values will be subtracted from left to right (obj0 - obj1 - obj2 ... - dValue)
	#	TODO:
	#		add a variable to describe what to do with non-matching keys (show, don't show, alternative treatment etc. 
	#	returns, and sets the result to $this->data
	###
	function subtract($aDataObjects = NULL, $dValue = NULL)
	{
		$this->setCalcType(CalculationType::CT_Subtract);
		//example: price - quantity
		if($dValue != NULL && is_numeric($dValue)){
			$this->value = $dValue;		//save the new value 
		}
		else{
			$dValue = $this->value;		//use the current saved value
		}
			
		unset($ret);
		$formattedData = $this->getFormattedDataValueObjects();
		
		foreach($formattedData as $dataObj)				//loop through existing dataObjects
		{
			if(!isset($ret))
			{	
				$ret = $dataObj;
			}
			else
			{					
				foreach($dataObj as $key => $dat)
				{
					if(!isset($ret[$key]))
						$ret[$key] = 0;					//if a key is not yet set: set to 0 before subtracting
					$ret[$key] -= ((float)$dat);
				}	
			}	
		}				
		
		if($dValue != NULL && is_numeric($dValue))
		{
				foreach($ret as $key => $dat)
				{
					$ret[$key] -= ((float)$dValue);		//subtract value from all in ret 
					
				}	
		}
		$this->data = $ret; 
		return $ret;
	}
	
	###
	#	Imput:
	#		$aDataObjects: 	array of type DataObject (or childs)
	#		$dValue: 		decimal value (optional)
	#	Description:
	#		First add the aDataObjects to eachother on the corrensponding keys, after that, add the dValue if not NULL
	# 	Note:
	#		The values will be added from left to right (obj0 + obj1 + obj2 ... + dValue)
	#	TODO:
	#		add a variable to describe what to do with non-matching keys (show, don't show, alternative treatment etc. 
	#	returns, and sets the result to $this->data
	###
	function sum($aDataObjects = NULL, $dValue = NULL)
	{
		$this->setCalcType(CalculationType::CT_Sum);
		if($dValue != NULL && is_numeric($dValue)){
			$this->value = $dValue;		//save the new value 
		}
		else{
			$dValue = $this->value;		//use the current saved value
		}
			
		unset($ret);
		$formattedData = $this->getFormattedDataValueObjects();
		
		foreach($formattedData as $dataObj)					//loop through existing dataObjects
		{
			if(!isset($ret))
			{	
				$ret = $dataObj;
			}
			else
			{					
				foreach($dataObj as $key => $dat)			
				{
					if(!isset($ret[$key]))
						$ret[$key] = 0;						//if a key is not yet set: set to 0 before adding
					$ret[$key] += ((float)$dat);
				}	
			}	
		}				
		
		if($dValue != NULL && is_numeric($dValue))
		{
				foreach($ret as $key => $dat)
				{
					$ret[$key] += ((float)$dValue);			//add value to all in ret			
				}	
		}
		$this->data = $ret;
		
		return $ret;
	}
	
	###
	#	Imput:
	#		$aDataObjects: 	array of type DataObject (or childs)
	#		$dValue: 		decimal value (optional)
	#	Description:
	#		First divides the aDataObjects from eachother on the corrensponding keys, after that, add divide with dValue if not NULL
	# 	Note:
	#		The values will be divided from left to right (obj0 / obj1 / obj2 ... / dValue)
	#	TODO:
	#		add a variable to describe what to do with non-matching keys (show, don't show, alternative treatment etc. 
	#		add division by zero to error list
	#	returns, and sets the result to $this->data
	###
	function divide($aDataObjects = NULL, $dValue = NULL)
	{
		$this->setCalcType(CalculationType::CT_Divide);
		if($dValue != NULL && is_numeric($dValue)){
			$this->value = $dValue;		//save the new value 
		}
		else{
			$dValue = $this->value;		//use the current saved value
		}
			
		unset($ret);
		$formattedData = $this->getFormattedDataValueObjects();
		
		foreach($formattedData as $dataObj)					//loop through existing dataObjects
		{
			if(!isset($ret))
			{	
				$ret = $dataObj;
			}
			else
			{					
				foreach($dataObj as $key => $dat)
				{
					//if(!isset($ret[$key]))
					//	$ret[$key] = 0;						//if 
						
					if((float)$dat != 0 && isset($ret[$key]))					//check on divide by 0 and if $ret[$key} exists
						$ret[$key] /= ((float)$dat);
					else
						$ret[$key] = 0;											//else set to 0
				}	
			}	
		}				
		
		if($dValue != NULL && is_numeric($dValue))
		{
				foreach($ret as $key => $dat)
				{
					if((float)$dValue != 0)					//check on division by 0
						$ret[$key] /= ((float)$dValue);	
					else
						$ret[$key] = 0;					
				}	
		}
		$this->data = $ret;
		
		return $ret;
	}
}

?>