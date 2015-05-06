<?php 
	
	session_start();

	spl_autoload_register(function ($className) {        
        require_once 'classes' . DIRECTORY_SEPARATOR . $className . '.php';        
    });

	$reader = new ImfxReader();
	$reader->run();