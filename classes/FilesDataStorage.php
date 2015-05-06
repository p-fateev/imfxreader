<?php

/**
* 
*/
class FilesDataStorage implements IDataStorage
{	
	const STORAGE_DIR = 'tmp_unzip';

	public function getDocument($messageId, $documentId)
	{	
		$filePath = self::STORAGE_DIR . DIRECTORY_SEPARATOR . session_id() 
			. DIRECTORY_SEPARATOR . $messageId . DIRECTORY_SEPARATOR . $documentId . '.dat';	
		
		if (file_exists($filePath)) {
			return unserialize(file_get_contents($filePath));
		}
		
		return FALSE;
	}

	public function saveDocument(ImfxDocument $document)
	{		
		$saveDirectory = self::STORAGE_DIR . DIRECTORY_SEPARATOR . session_id() 
			. DIRECTORY_SEPARATOR . $document->getMessageId();

		if (!is_dir($saveDirectory)) {
			mkdir($saveDirectory, 600, true);
		}

		if (is_dir($saveDirectory)) {
			file_put_contents($saveDirectory . DIRECTORY_SEPARATOR . $document->getId(). '.dat', serialize($document));
		}		
	}

	public function clear()
	{
		$directory = self::STORAGE_DIR . DIRECTORY_SEPARATOR . session_id();
		if (is_dir($directory)) {
			$this->_deleteDirectory($directory);
		}		
	}

	private function _deleteDirectory($directory) { 
		//echo $directory, '<br />';
		$files = array_diff(scandir($directory), array('.', '..')); 
		foreach ($files as $file) { 
			(is_dir("$directory/$file")) ? $this->_deleteDirectory("$directory/$file") : unlink("$directory/$file"); 
		} 		
		return rmdir($directory); 
	} 
}