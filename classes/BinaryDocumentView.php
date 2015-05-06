<?php

/**
* 
*/
class BinaryDocumentView extends DocumentView
{	
	public function render()
	{		
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . $this->_document->getFileName() . '"');
		echo $this->_document->getRawData();
	}
}