<?php
	require '../controllers/initControllers.php';
    require '../controllers/CentralController.class.php';

	global $controller;
	$controller = new CentralController();
	$controller->handleRequest($_GET, $_POST, $_REQUEST);
	$controller->display();
?>