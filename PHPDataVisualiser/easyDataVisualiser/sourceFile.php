<?php

class SourceFile extends DataSource
{
	public $tags;
	
	function __construct($sName = "", $path="", $tags=NULL)
    {
		parent::__construct($sName, SourceType::ST_WEB, $path);
		$this->tags = $tags;
		
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
		echo("getSource() file");
	}

	
}

?>