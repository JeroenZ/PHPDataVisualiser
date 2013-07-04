<?php 
require_once('view.php');
require_once('viewObject.php');
require_once('dataObject.php');
require_once('dataSource.php');
require_once('sourceFile.php');
require_once('sourceWeb.php');
require_once('dataCalculationObject.php');
require_once('dataCalculationValueObject.php');
require_once('viewFormat.php');

class EasyDataVisualiser
{
	public $dataObjects;			//DataObject array
	public $dataSources;			//DataSource array 
	public $views;				//View array

	function __construct()
    {}

    function __destruct()
    {}
		
	
	
	function createDataObject($sName, $data=NULL, $format="")
	{
		$newDataObject = new DataObject($sName, $data, $format);			//create a new DataObject object
		
		$this->dataObjects[] = $newDataObject;															//add the created DataObject object to the array views
		return $newDataObject;
	}	
	
	function createDataSource($sName, $stSourceType=SourceType::ST_NONE, $sPath="")
	{
		$newDataSource = new DataSource($sName, $stSourceType, $sPath);			//create a new DataSource object
		
		$this->dataSources[] = $newDataSource;															//add the created DataObject object to the array views
		return $newDataSource;
	}	
	
	function createView($sName, $sTitle="", $vtType = ViewType::VT_NONE, $aViewObjects=NULL)
	{
		$newView = new View($sName, $sTitle, $vtType, $aViewObjects);		//create a new View object
		
		$this->views[] = $newView;									//add the created View object to the array views
		return $newView;
	}	
}

?>