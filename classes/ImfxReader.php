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

			for ($i=0; $i < count($_FILES['files']['name']); $i++) { 
				if ($_FILES['files']['error'][$i] == 0 and $_FILES['files']['size'][$i] > 0) {
					$msg = new ImfxMessage($_FILES['files']['name'][$i], $_FILES['files']['tmp_name'][$i]);
					$msg->render();	
				}				
			}			


			//var_dump($_SESSION);

		} elseif (isset($_GET['msg']) and isset($_GET['doc'])) {
			$storage = new SessionDataStorage();
			if ($data = $storage->getDocument($_GET['msg'], $_GET['doc'])) {
				//var_dump($document);
				//$data['document']->render();	
				$view = DocumentView::factory($data);
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