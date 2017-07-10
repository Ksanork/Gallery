<?php
    require_once 'Controller.class.php';
	require_once '../views/Viewer.class.php';
	
	class LoginController extends Controller {
		
		
		function __construct() {
			$this->handleRequest($_GET, $_POST, $_REQUEST);
			
			$this->user = new User();
			if($this->user->authenticate()) {
				session_destroy();
				
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 4200,
					$params["path"], $params["domain"], $params["secure"], $params["httponly"]
				);
				
				global $messenger;
				$messenger->addMessage("Pomyślnie wylogowano", MESSAGE_OK);
				//$this->message = "Pomyślnie wylogowano";
			}
			$this->auth($this->raw_post);
			$this->register($this->raw_post);
			
			$this->view = new Viewer();
			$this->view->setHeader("../views/fragments/header.php");
			$this->view->setContent('../views/fragments/' . $_GET['action'] .'.php');
			$this->view->setFooter("../views/fragments/footer.php");
		}
		
		public function register($post) {
			global $messenger;
			
			if(isset($post['login']) && 
			   isset($post['password1']) &&
			   isset($post['password2']) &&
			   isset($post['email'])) {
					if($post['login'] != '' && 
					   $post['password1'] != '' &&
					   $post['password2'] != '' &&
					   $post['email'] != '') {
					   		
						$code = $this->user->registerUser($post);
						
								
						switch($code) {
							case 0:
								//$this->message = "Pomyślnie zarejestrowano";
								$messenger->addMessage("Pomyślnie zarejestrowano", MESSAGE_OK);
								break;
							case -1:
								//$this->message = "Podany login już istnieje";
								$messenger->addMessage("Podany login już istnieje", MESSAGE_ERROR);
								break;
							case -2:
								//$this->message = "Hasła się nie zgadzają";
								$messenger->addMessage("Hasła się nie zgadzają", MESSAGE_ERROR);
								break;
							default:
								//$this->message = "Inny błąd";
								$messenger->addMessage("Inny błąd", MESSAGE_ERROR);
								break;
						}
					   }
					   else $messenger->addMessage("Musisz wypełnić wszystkie pola", MESSAGE_ERROR);
			   }
			   
		}
		
		public function auth($post) {
			global $messenger;
			
			if(isset($post['login']) && isset($post['password'])) {
				if(!empty($post['login']) && !empty($post['password'])) {
					$code = $this->user->addUser();
					
					//echo 'Problem...';
					
					switch($code) {
						case 0:
							$messenger->addMessage("Pomyślnie zalogowano", MESSAGE_OK);
							header("Location: upload");
							exit;
							//Location()
							//$this->message = "Pomyślnie zalogowano";
							break;
						case -1:
							$messenger->addMessage("Nieprawidłowy login lub hasło", MESSAGE_ERROR);
							//$this->message = "Nieprawidłowy login lub hasło";
							break;
						case -2:
							$messenger->addMessage("Wypełnij wszystkie pola", MESSAGE_ERROR);
							//$this->message = "Wypełnij wszystkie pola";
							break;
						default:
							$messenger->addMessage("Inny błąd", MESSAGE_ERROR);
							//$this->message = "Inny błąd";
							break;
					}
				}
				else $messenger->addMessage("Wypełnij wszystkie pola", MESSAGE_ERROR);
				
					
			}
			else return false;
		}
		
		public function display() {
			$this->view->render();
		}
	}
?>