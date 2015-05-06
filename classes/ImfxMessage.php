<?php

/**
* 
*/
class ImfxMessage
{
	private $_id;
	private $_fileName;	
	private $_archivePath;	
	private $_extractor;
	private $_documents;
	private $_errors;	

	function __construct($fileName, $archivePath, DataExtractor $extractor)
	{		
		$this->_fileName = $fileName;
		$this->_id = md5($fileName);
		$this->_archivePath = $archivePath;

		$this->_extractor = $extractor;
		$this->_documents = $this->_extractor->getDocuments($this);		
	}	

	public function getId()
	{
		return $this->_id;
	}

	public function setError($error)
	{
		$this->_errors[] = $error;
	}

	public function getArchivePath()
	{
		return $this->_archivePath;
	}

	public function render()
	{
		$html = '<dl>
		<dt>' . $this->_fileName . '</dt>
		<dd>';

		if (isset($this->_errors)) {
			$html .= '<ul class="errors">';			

			foreach ($this->_errors as $error) {
				$html .= '<li>' . $error . '</li>';			
			}

			$html .= '</ul>';			
		}

		if (count($this->_documents) > 0) {
			$html .= '<ul>';			

			foreach ($this->_documents as $document) {				

				if ($document->getCode() == ImfxDocument::DOC_TYPE_IMAGE) {

					$html .= sprintf('<li>%s<ul>', $document);							
					$attachments = $document->getAttachments();
					foreach ($attachments as $attachment) {
						$html .= sprintf('<li><a href="?msg=%s&doc=%s" target="_blank">%s</a></li>', 
							$this->_id,
							$attachment->getId(),
							$attachment);														
					}

					$html .= '</ul></li>';
				} else {
					$html .= sprintf('<li><a href="?msg=%s&doc=%s" target="_blank">%s</a></li>', 
						$this->_id,
						$document->getId(),
						$document);								
				}

				
			}

			$html .= '</ul>';			
		}

		$html .= '			
		</dd>
		</dl>';

		echo $html;

	}
}