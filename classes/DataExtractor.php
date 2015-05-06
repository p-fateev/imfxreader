<?php

/**
* 
*/
abstract class DataExtractor
{	
	//protected $_imfxMessage;
	protected $_storage;
	
	function __construct(IDataStorage $storage)
	{
		//$this->_imfxMessage = $imfxMessage;
		$this->_storage = $storage;
		
		$this->_storage->clear();
	}

	abstract public function getDocuments(ImfxMessage &$imfxMessage);
		
}