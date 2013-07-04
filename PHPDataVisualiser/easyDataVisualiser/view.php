<?php

class ViewType
{
	const VT_NONE 		= 0;
    const VT_ARRAY 		= 1;
    const VT_TABLE 		= 2;
	const VT_DOT_DIA	= 3;
	const VT_LINE_DIA	= 4;
}

class View
{
	public $name;
	public $title;
	public $type;				//the type of the current view
	public $viewObjects;		//array with viewObjects
	
	function __construct($sName, $sTitle="", $vtType = ViewType::VT_NONE, $aViewObjects=NULL)
    {
		$this->name 		= $sName;
		$this->title 		= $sTitle;
		$this->type			= $vtType;
		$this->viewObjects 	= $aViewObjects;
    }

    function __destruct()
    {
		
    }
	
	function createXML()
	{
		
	}
	
	function createExcel()
	{
	
	}
	
	function createArray()
	{
		//for each ViewObject, 
		unset($ret);

		foreach($this->viewObjects as $viewObject)
		{
			
			$title = $viewObject->getTitle();
			//if($title != NULL || $title != "")
			$ret[][$title] = $viewObject->getFormattedData();
		}
		return $ret;
	}
	
	function addViewObject($vViewObject)
	{
		$this->viewObjects[] = $vViewObject;		//add the given viewObject to the viewObjects array
	}
	
	function addNewViewObject($sName = "", $sTitle = "", $dDataObject = NULL, $format = NULL, $style = "")
	{
		$newViewObject = new ViewObject($sName, $sTitle, $dDataObject, $format, $style);
		$this->addViewObject($newViewObject);				//add the newly created viewObject to the viewObjects array
	}
	
	function saveView()
	{
	
	}
	

	
}

?>