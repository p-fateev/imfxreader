<?php

/**
* 
*/
class ComplexImfxDocument extends ImfxDocument
{	
	private $_attachments;

	public function save(IDataStorage &$storage)
	{		
		if (isset($this->_attachments) and is_array($this->_attachments)) {
			foreach ($this->_attachments as $attachment) {
				$storage->saveDocument($attachment);				
			}
		}
	}

	public function addAttachment($document)
	{
		$this->_attachments[] = $document;
	}

	public function getAttachments()
	{
		return $this->_attachments;
	}	
}