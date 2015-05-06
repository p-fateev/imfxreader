<?php

/**
* 
*/
class HtmlDocumentView extends DocumentView
{
	
	public function render()
	{
		//var_dump($this->_documentData);
		//header('Content-Type: text/xml;');
		echo $this->_document->getRawData();
	}
}