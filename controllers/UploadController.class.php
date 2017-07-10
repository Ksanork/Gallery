<?php
    require_once 'Controller.class.php';
	require_once '../models/Gallery.class.php';
	require_once '../views/Viewer.class.php';
	
	class UploadController extends Controller {
		private $gallery;
		
		function __construct() {
			$this->handleRequest($_GET, $_POST, $_REQUEST);
			
			$this->user = new User();
			$this->gallery = new Gallery();
			$this->uploadFile($this->raw_post);
			
			//global $messenger;
			
			//echo "Wiadomość: " . $messenger->getMessage();
			
			$this->view = new Viewer();
			if($this->user->authenticate()) {
				$this->view->setHeader("../views/fragments/header-logged.php");
				$this->view->setContent('../views/fragments/upload-logged.php');
			}
			else {
				$this->view->setHeader("../views/fragments/header.php");
				$this->view->setContent('../views/fragments/upload.php');
			}
			
			$this->view->setFooter("../views/fragments/footer.php");
		}
	
		
		public function uploadFile($post) {
			global $messenger;
			
			if(	isset($post['watermark']) && 
		    	isset($post['author']) &&
				isset($post['title']) &&
				file_exists($_FILES['image']['tmp_name'])) {
					
					$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
					
					$this->gallery->setFile($_FILES['image']['tmp_name']);
					$this->gallery->set('title', $post['title']);
					$this->gallery->set('author', $post['author']);
					$this->gallery->set('ext', $ext);
					if(isset($_POST['private'])) 
						if($_POST['private'] == "true") $this->gallery->set('private', 'true');
						else $this->gallery->set('private', 'false');
					else $this->gallery->set('private', 'false');
					
					$code = $this->gallery->savePhoto((string) $post['watermark']);
					
					switch($code) {
						case 0:
							//$this->message = "Pomyślnie dodano plik";
							$messenger->addMessage("Pomyślnie dodano plik", MESSAGE_OK);
							break;
						case -1:
							//$this->message = "Problem -1";
							$messenger->addMessage("Wystąpił wewnętrzny problem", MESSAGE_ERROR);
							break;
						case -2:
							//$this->message = "Problem -2";
							$messenger->addMessage("Wystąpił wewnętrzny problem podczas wysyłania obrazu", MESSAGE_ERROR);
							break;
						case -3:
							//$this->message = "Nieprawidłowy format pliku";
							$messenger->addMessage("Nieprawidłowy format pliku", MESSAGE_ERROR);
							break;
						case -4:
							//$this->message = "Rozmiar pliku przekracza 1 MB";
							$messenger->addMessage("Rozmiar pliku przekracza 1 MB", MESSAGE_ERROR);
							break;
						default:
							$this->message = "Inny błąd";
							break;
					}
					
			}
			else return false;
		}
		
		public function display() {
			$this->view->render();
		}
	}
?>