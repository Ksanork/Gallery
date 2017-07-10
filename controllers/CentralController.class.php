<?php
	require_once 'Controller.class.php';
	require_once '../models/User.class.php';

    class CentralController extends Controller {
    	protected $controller;
		protected $user;
		
		public function handleRequest($get, $post = null, $request = null) {
			parent::handleRequest($get, $post, $request);
			
			$this->loadUser();
			$this->loadController();
		}
		
		protected function loadController() {
			global $controllers;
			
			$key = '/upload';
			if(isset($this->raw_get['action']) && isset($controllers[$this->raw_get['action']])) 
				$key = $this->raw_get['action'];
		
			$path = '../controllers/' . $controllers[$key]['filename'] . '.class.php';
			
			include $path;
			$this->controller = new $controllers[$key]['class'];
			return true;
		}
		
		protected function loadUser() {
			$this->user = new User();
			$this->user->authenticate();
		}
		
		public function getDatabaseHandle() {
			$mongo = new MongoClient(
		        "mongodb://localhost:27017/",
		        [
		            'username' => 'wai_web',
		            'password' => 'w@i_w3b',
		            'db' => 'wai',
		        ]);
		
		    $db = $mongo->wai;
			//$db->images->remove();
		
		    return $db;
		}
    }
?>