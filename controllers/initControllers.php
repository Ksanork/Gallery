<?php
	require_once '../views/Messenger.class.php';
	
	define("MESSAGE_OK", "good");
	define("MESSAGE_ERROR", "bad");

    //global $messenger;
	$messenger = new Messenger();
	//$GLOBALS['messenger'] = new Messenger();

	$controllers = array(
		'/upload' => array(
			'class' => 'UploadController',
			'filename' => 'UploadController'
		),
		'/login' => array(
			'class' => 'LoginController',
			'filename' => 'LoginController'
		),
		'/registration' => array(
			'class' => 'LoginController',
			'filename' => 'LoginController'
		),
		'/gallery' => array(
			'class' => 'GalleryController',
			'filename' => 'GalleryController'
		),
		'/favourites' => array(
			'class' => 'GalleryController',
			'filename' => 'GalleryController'
		),
		'/search' => array(
			'class' => 'GalleryController',
			'filename' => 'GalleryController'
		)
	);
?>