<?php

/**
* 
*/
class ZipXmlDataExtractor extends DataExtractor
{
	public function getDocuments(ImfxMessage &$imfxMessage)
	{
		//$documents = array();
		$zipArchive = new ZipArchive(); 

		if ($zipArchive->open($imfxMessage->getArchivePath())) {
			//var_dump($zipArchive);

			/* ищем список документов */
			$listFileName = $this->_extractStringValue($zipArchive, 'envelope.xml', 'DocListFile/FileName');
			if (!$listFileName) {
				if ($zipArchive->locateName('doclist.xml')) {
					$listFileName = 'doclist.xml';
				}
			}

			if ($listFileName) {
				return $this->_extractDocuments($zipArchive, $imfxMessage, $listFileName);

			} else {
				$imfxMessage->setError('Не обнаружен список документов!');	
			}								

			$zipArchive->close();
			
		} else {			
			$imfxMessage->setError('Не удалось открыть архив!');	
		}

		return array();
	}

	private function _extractStringValue(&$archive, $fileName, $xpath)
	{
		if ($fileData = $archive->getFromName($fileName)) {			
			$xmlElem = new SimpleXMLElement($fileData);			
			if ($nodes = $xmlElem->xpath('DocListFile/FileName')) {
				return (string) $nodes[0];
			}
			return FALSE;
		}
	}

	private function _extractDocuments(&$archive, &$imfxMessage, $listFileName)
	{
		$documents = array();

		if ($fileData = $archive->getFromName($listFileName)) {						
			
			$xmlElem = new SimpleXMLElement($fileData);		
			if ($docNodes = $xmlElem->xpath('Document')) {				
				foreach ($docNodes as $node) {
					
					$docCode = intval((string) $node->DocCode);
					$docClass = $docCode == ImfxDocument::DOC_TYPE_IMAGE ? 'ComplexImfxDocument' : 'ImfxDocument';					
					
					$document = new $docClass(
						$imfxMessage->getId(),
						$docCode, 
						sprintf('%s № %s', ImfxDocument::getDocTypeName($docCode), (string) $node->DocNumber), 
						(string) $node->FileName,
						$archive->getFromName((string) $node->FileName));								

					if ($docCode == ImfxDocument::DOC_TYPE_IMAGE) {
						
						$xmlElem = new SimpleXMLElement($document->getRawData());			
						if ($attNodes = $xmlElem->xpath('img_page')) {
							foreach ($attNodes as $node) {
								$attachment = new ImfxDocument(
									$imfxMessage->getId(),
									$docCode, 
									sprintf('Файл № %s', (string) $node->page_num), 
									(string) $node->page_file_name,
									base64_decode((string) $node->page_image));								

								$document->addAttachment($attachment);								
							}
						}						
					}

					/* сохраняем данные */									
					$document->save($this->_storage);
					$documents[] = $document;
				}
			} else {
				$imfxMessage->setError('Не удалось извлечь список документов!');	
			}	

		} else {
			$imfxMessage->setError('Не удалось открыть список документов!');	
		}

		return $documents;
	}
}