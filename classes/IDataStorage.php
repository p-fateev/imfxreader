<?php

interface IDataStorage 
{
	public function getDocument($messageId, $documentId);
	public function saveDocument(ImfxDocument $document);
	public function clear();
}