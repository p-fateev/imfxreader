<?php 
	
	session_start();

	spl_autoload_register(function ($className) {        
        require_once 'classes' . DIRECTORY_SEPARATOR . $className . '.php';        
    });

	/* конфигурация */
	define('STORAGE_TYPE', IDataStorage::FILES_STORAGE);

	$reader = new ImfxReader();
	$reader->run();