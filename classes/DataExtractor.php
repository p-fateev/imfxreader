<?php

/**
* 
*/
abstract class DataExtractor
{

	protected $_imfxMessage;
	protected $_storage;
	
	function __construct(ImfxMessage &$imfxMessage)
	{
		$this->_imfxMessage = $imfxMessage;
		$this->_storage = new SessionDataStorage();
		$this->_storage->clear();
	}
		
}