<?php

/**
* 
*/
class ImfxReader
{
	public function run()
	{		
		//echo "<pre>";
		//var_dump($_POST);
		//var_dump($_FILES);		

		if (isset($_FILES['files'])) {

			$this->_renderHeader();		
			$this->_renderUploadForm();		
			$extractor = $this->getDataExtractor();

			for ($i=0; $i < count($_FILES['files']['name']); $i++) { 
				if ($_FILES['files']['error'][$i] == 0 and $_FILES['files']['size'][$i] > 0) {
					$message = new ImfxMessage(
						$_FILES['files']['name'][$i], 
						$_FILES['files']['tmp_name'][$i], 
						$extractor);
					$message->render();	
				}				
			}			

			//var_dump($_SESSION);

		} elseif (isset($_GET['msg']) and isset($_GET['doc'])) {
			$storage = $this->getDataStorage();
			if ($document = $storage->getDocument($_GET['msg'], $_GET['doc'])) {				
				
				$view = DocumentView::factory($document);
				$view->render();
				exit;
			} 

			
		} else {
			$this->_renderHeader();		
			$this->_renderUploadForm();			
		}

		$this->_renderFooter();	

		//echo "</pre>";
	}

	public function getDataStorage()
	{
		/* в зависимости от настроек создаем класс для промежуточного хранения данных */
		defined('STORAGE_TYPE') || define('STORAGE_TYPE', IDataStorage::SESSION_STORAGE);
		$storageClass = STORAGE_TYPE == IDataStorage::SESSION_STORAGE ? 'SessionDataStorage' : 'FilesDataStorage';
		return new $storageClass();
	}

	public function getDataExtractor()
	{
		return new ZipXmlDataExtractor($this->getDataStorage());
	}

	private function _renderUploadForm()
	{
		echo '<form method="post" enctype="multipart/form-data">
		<input name="files[]" type="file" multiple="multiple" accept=".imfx" />
		<input type="submit" value="Просмотреть" />
		</form>';		 
	}

	private function _renderHeader()
	{
		echo '<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Imfx Reader</title>
			<link rel="stylesheet" type="text/css" href="styles.css">
		</head>
		<body>';		
	}

	private function _renderFooter()
	{
		$echo = '</body>
		</html>';	
	}
}