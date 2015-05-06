<?php

/**
* 
*/
class SessionDataStorage implements IDataStorage
{	
	public function getDocument($messageId, $documentId)
	{		
		if(isset($_SESSION['IMFX_STORAGE'][$messageId][$documentId])) {			
			return unserialize($_SESSION['IMFX_STORAGE'][$messageId][$documentId]);
		}
		return FALSE;
	}

	public function saveDocument(ImfxDocument $document)
	{
		$_SESSION['IMFX_STORAGE'][$document->getMessageId()][$document->getId()] = serialize($document);
	}

	public function clear()
	{
		unset($_SESSION['IMFX_STORAGE']);
	}
}