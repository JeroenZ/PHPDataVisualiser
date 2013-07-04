<?php

class SourceType
{
	const ST_NONE 	= 0;
    const ST_WEB 	= 1;
    const ST_FILE 	= 2;
	const ST_ARRAY	= 3;
}


abstract class DataSource
{
	public $name;
	public $type;
	public $path;
	
	function __construct($sName = "", $stSourceType=SourceType::ST_NONE, $path="")
    {
		$this->name 	= $sName;
		$this->type 	= $stSourceType;
		$this->path	 	= $path;
    }

    function __destruct()
    {

    }
	
	
	##
	#	get the source data and add 
	#
	##
	abstract public function getSource($location=NULL);

	
}

?>