<?php
    require_once 'dbo.class.php';
	require_once 'Session.class.php';
    
    class User extends DBO {
    	protected $table = "users";
		protected $fields = array(
			'login' => null,
			//'email' => null,
			'favourites' => null
		);
		
		protected $session;
    
		public function authenticate() {
			if ($this->session->load()) {
					//echo "jest";
					return true;
				//if ($userid = $this->session->get('user')) {
					//if ($this->load($userid)) {
					//	return true;
					//} else {
						// handle corrupted session record returning an invalid userid
					//}
				//} else {
					// handle anonymous session
				//}
			} else {
				//new session
			}
		}
		
		public function addUser() {
				$f = array(
					'id' => null,
					'login' => (string) $_POST['login'],
					'password' => (string) $_POST['password']
				);
				
				$code = $this->checkUser($f);
				if($code) {
					$this->session->setUser($code, $f['login']);
					
					
					$this->fields['login'] = $f['login'];
					return 0;
				}
				else return -1;
		}
		
		public function checkUser($f) {
			$query = array(
				'login' => $f['login']
			);
			
			$result = $this->findOne($query);
			if($result) {
				if(password_verify($f['password'], $result['password'])) 
					return $result['_id'];
			}
			
			return false;
		}
		
		public function registerUser($f) {
			if($f['password1'] === $f['password2']) {
    			$query = [
					'login' => (string) $f['login']
				];
				
				//$db = get_db();
				$result = $this->findOne($query);
				
				//print_r($result);
				
				if($result == null) {
					$query = array(
						'login' => (string) $f['login'],
						'password' => password_hash((string) $f['password1'], PASSWORD_DEFAULT),
						'email' => (string) $f['email']
					);
					
					if($this->insertQuery($query) != null) return 0;
					//save_user(null, $query);
				}
				else return -1;		//login już istnieje
    		}
			else return -2;			//hasła się nie zgadzają
			
			return -3;
		}
		
		public function __construct($id = null) {
			parent::__construct($id);
			
			//jeśli sesja istnieje to pobieranie usera z sesji
			
			//Utilities::loadModel('Session');
			$this->session = new Session();
			if($this->authenticate()) {
				//echo 'jest';
				$this->fields = $this->session->getSessionFields();
			}
		}
	
	}
?>