<?php

/**
* 
*/
class DocumentView
{
	protected $_document;

	function __construct($document)
	{
		$this->_document = $document;
	}

	static public function factory($document)
	{
		switch ($document->getCode()) {
			case 10:
				return new HtmlDocumentView($document);				
			
			case 43:
			case 80:
				return new BinaryDocumentView($document);							
		}

		return new XmlDocumentView($document);

	}
}