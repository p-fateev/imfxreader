<?php

interface IDataStorage 
{
	const SESSION_STORAGE = 1;
	const FILES_STORAGE = 2;	
	
	public function getDocument($messageId, $documentId);
	public function saveDocument(ImfxDocument $document);
	public function clear();
}