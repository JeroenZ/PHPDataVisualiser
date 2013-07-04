<?php

require_once("easyDataVisualiser/easyDataVisualiser.php");

$myArr1 = array(
				"day1" => array("t" => "45","v" => "1"), 
				"day2" => array("t" => "34","v" => "2"),
				"day3" => array("t" => "25","v" => "3")
				);
				
$myArr2 = array(
				"day1" => array("s" => "2","v" => "5"), 
				"day2" => array("s" => "3","v" => "1"),
				"day3" => array("s" => "4","v" => "3")
				);		
$myArr3 = array(
				array("day" => "day1","r" => "2"), 
				array("day" => "day2","r" => "2"),
				array("day" => "day3","r" => "2")
				);		
				
$myArr4 = array(
				"d1" => array("s" => "2","v" => "7"), 
				"d2" => array("s" => "3","v" => "6"),
				"d3" => array("s" => "4","v" => "3")
				);
				
$indexMask = array(
				"d1" => "day1", 
				"d2" => "day2",
				"d3" => "day3"
				);

$indexMask2 = array(
				"day1" => "1 okt", 
				"day2" => "2 okt",
				"day3" => "3 okt"
				);



//createViewObjectWithSingleDataObject($myArr1, $indexMask2);
//createViewObjectWithMultipleDataObjects($myArr1, $myArr2, $myArr3);
createViewObjectWithSimpleCalculation($myArr1, $myArr2);
//createViewObjectWithMultipleCalculations($myArr1, $myArr2, $myArr4, $indexMask);


function createViewObjectWithSingleDataObject($myArr1, $indexMask2)
{
	echo('raw array: $myArr1 <br>');
	print_r($myArr1);
	echo("<hr>");
	$edv 	= new EasyDataVisualiser();								//create library object
	
	$do 	= $edv->createDataObject("test Name", $myArr1);			//create dataObject from array
	$view 	= $edv->createView("testViewName", "TestViewTitle");	//create view object
	
	$view->addNewViewObject("view object 1", "t as value", $do, new ViewFormat("formatName1", "", "t"));	//create viewObject from dataObject
	//$view->addNewViewObject("view object 2", "v as value", $do, new ViewFormat("formatName2", "", "v"));	//create viewObject from dataObject
	$view->addNewViewObject("view object 2", "v as value", $do, new ViewFormat("formatName2", "", "v", $indexMask2 ));	//create viewObject from dataObject with a mask
	echo('created view array<br>');
	print_r($view->createArray());	

}

function createViewObjectWithMultipleDataObjects($myArr1, $myArr2, $myArr3)
{
	echo('raw array: $myArr1 <br>');
	print_r($myArr1);
	echo('<hr>raw array: $myArr2 <br>');
	print_r($myArr2);
	echo('<hr>raw array: $myArr3 <br>');
	print_r($myArr3);
	$edv 	= new EasyDataVisualiser();								//create library object
	
	$do1 	= $edv->createDataObject("test obj 1", $myArr1);			//create dataObject from array
	$do2 	= $edv->createDataObject("test obj 2", $myArr2);			//create dataObject from array
	$do3 	= $edv->createDataObject("test obj 3", $myArr3);			//create dataObject from array
	$view 	= $edv->createView("testViewName", "TestViewTitle");	//create view object
	
	$view->addNewViewObject("view object 1", "arr1", $do1, new ViewFormat("formatName1", "", "v"));	//create viewObject from dataObject
	$view->addNewViewObject("view object 2", "arr2", $do2, new ViewFormat("formatName2", "", "v"));	//create viewObject from dataObject
	$view->addNewViewObject("view object 3", "arr3", $do3, new ViewFormat("formatName3", "day", "r"));	//create viewObject from dataObject
	echo('<hr>created view array<br>');
	print_r($view->createArray());	

}

function createViewObjectWithSimpleCalculation($myArr1, $myArr2)
{
	echo('raw array: $myArr1 <br>');
	print_r($myArr1);
	echo('<hr>raw array: $myArr2 <br>');
	print_r($myArr2);

	$edv 	= new EasyDataVisualiser();								//create library object
	
	$do1 	= $edv->createDataObject("test obj 1", $myArr1);			//create dataObject from array
	$do2 	= $edv->createDataObject("test obj 2", $myArr2);			//create dataObject from array
	
	$view 	= $edv->createView("testViewName", "TestViewTitle");	//create view object

	$calcObj = new DataCalculationObject("simple sum", NULL, array($do1, $do2), 2, NULL, "v");	
	//$calcObj = new DataCalculationObject("simple sum", NULL, array($do1, $do2), 2, NULL, "v");		//add 2
	$calcObj->sum();
	//$calcObj->divide();
	//$calcObj->subtract();
	//$calcObj->multiply();
	
	$view->addNewViewObject("view object 1", "arr1", $do1, new ViewFormat("formatName1", "", "v"));	//create viewObject from dataObject
	$view->addNewViewObject("view object 2", "arr2", $do2, new ViewFormat("formatName2", "", "v"));	//create viewObject from dataObject
	$view->addNewViewObject("view object 3", "calcObj", $calcObj, new ViewFormat("formatName2", "", ""));	//create viewObject from dataObject

	echo('<hr>created view array<br>');
	print_r($view->createArray());	

}

function createViewObjectWithMultipleCalculations($myArr1, $myArr2, $myArr4, $indexMask)
{
	echo('raw array: $myArr1 <br>');
	print_r($myArr1);
	echo('<hr>raw array: $myArr2 <br>');
	print_r($myArr2);
	echo('<hr>raw array: $myArr4 <br>');
	print_r($myArr4);
	echo('<hr>raw array: $indexMask <br>');
	print_r($indexMask);

	$edv 	= new EasyDataVisualiser();								//create library object
	
	$do1 	= $edv->createDataObject("test obj 1", $myArr1);			//create dataObject from array
	$do2 	= $edv->createDataObject("test obj 2", $myArr2);			//create dataObject from array
	$do4 	= $edv->createDataObject("test obj 4", $myArr4);			//create dataObject from array
	
	$view 	= $edv->createView("testViewName", "TestViewTitle");	//create view object

	$calcObj = new DataCalculationObject("simple sum", NULL, array($do1, $do2), NULL, NULL, "v");	
	$calcObj->sum();																				//sum of do1 and do2
	
	$calcObj1 = new DataCalculationObject("multiply with sdo1");	
	$calcObj1->attachDataObjects(array($do4), NULL, "v");			
	$calcObj1->attachDataObjects(array($calcObj));
	$calcObj1->setIndexMask($indexMask);							//mask the index (d1 => day1 etc.)
	//$calcObj1->setValue(2);											//multiply with 2
	
	//multiply 	do4 with calcObject : (do1 + do2) * do4
	
	//method 1 call arithmatic function
	$calcObj1->multiply();											
	
	//method 2 call the calculate() function with the calculationType
	//$calcObj1->calculate(CalculationType::CT_Multiply);
	
	//method 3 set calculationType and call calculate()
	//$calcObj1->setCalcType(CalculationType::CT_Multiply);
	//$calcObj1->calculate();
	
	$view->addNewViewObject("view object 1", "arr1", $do1, new ViewFormat("formatName1", "", "v"));	//create viewObject from dataObject
	$view->addNewViewObject("view object 2", "arr2", $do2, new ViewFormat("formatName2", "", "v"));	//create viewObject from dataObject
	$view->addNewViewObject("calcObject", "calc", $calcObj);										//create viewObject from calcObj
	$view->addNewViewObject("view object 4", "arr4", $do4, new ViewFormat("formatName4", "", "v"));	//create viewObject from dataObject
	$view->addNewViewObject("calcObject1", "calcObj1", $calcObj1);									//create viewObject from calcObj1

	echo('<hr>created view array<br>');
	print_r($view->createArray());	

}

?>