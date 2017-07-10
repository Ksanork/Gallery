<?php
   session_start();
   require_once 'dbo.class.php';
   
	class Session extends DBO {
		public $pk = 'session';
	
		protected $session;
		
		protected $table;
		
		public function __construct() {
			global $_SESSION;
			parent::__construct();
			
			if(!isset($_SESSION['favourites'])) $_SESSION['favourites'] = array();
			$this->session = $_SESSION;
		}
		
		public function getSessionFields() {
			return array(
				'login' => $_SESSION['user'],
				'favourites' => $_SESSION['favourites']
			);
		}
		
		public function setUser($id, $user) {
			$_SESSION['user'] = $user;
			$_SESSION['user_id'] = session_id();
			
		}
		
		public function load() {
			if(isset($_COOKIE[session_name()]) && isset($_SESSION['user_id'])) {
				if($_SESSION['user_id'] == $_COOKIE[session_name()]) 
					return true;
			}
			
			return false;
		}
   }
?>