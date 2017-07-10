<?php
    require_once 'Controller.class.php';
	require_once '../models/Gallery.class.php';
	require_once '../views/Viewer.class.php';
	
	class GalleryController extends Controller {
		private $gallery;
			
		function __construct() {
			$this->handleRequest($_GET, $_POST, $_REQUEST);
			
			$this->user = new User();
			$this->gallery = new Gallery();
			$this->loadFavourites($this->raw_post);
			
			$this->view = new Viewer();
			if($this->user->authenticate()) {
				$this->view->setHeader("../views/fragments/header-logged.php");
				$this->view->setContent('../views/fragments/' . $_GET['action'] . '-logged.php');
				
				$this->view->setVariable('privategallery', $this->gallery->getPrivatePhotosByAuthor($this->user->get('login')));
			}
			else {
				$this->view->setHeader("../views/fragments/header.php");
				$this->view->setContent('../views/fragments/' . $_GET['action'] . '.php');
			}
			
			$this->view->setFooter("../views/fragments/footer.php");
			
			if($_GET['action'] == '/search') $this->view->setContent('../views/fragments/' . $_GET['action'] . '.php');
			
			$this->view->setVariable('publicgallery', $this->gallery->getPublicPhotos());
			$this->view->setVariable('favouritegallery', $this->gallery->getFavourites($this->user->get('favourites')));
			
			$this->loadSearch($this->raw_post);
		}
		
		protected function loadFavourites($post) {
			if(isset($post['check_img'])) {
				$result = $this->gallery->addToFavourites($post['check_img'], $this->user->get('favourites'));
				$this->user->set('favourites', $result);
				$_SESSION['favourites'] = $result;
			} 
			
			if(isset($post['rem_img'])) {
				$result = $this->gallery->removeFromFavourites($post['rem_img'], $this->user->get('favourites'));
				$this->user->set('favourites', $result);
				$_SESSION['favourites'] = $result;
			}
				
		}
		
		public function loadSearch($post) {
			if(isset($post['query'])) {
				if(!empty($post['query'])) {
					$this->view->setVariable('search', $this->gallery->getByName((string) $post['query']));
					
					$this->view->setHeader('');
					$this->view->setContent('../views/fragments/search-content.php');
					$this->view->setFooter('');
				}
				
			}
		}
		
		public function display() {
			$this->view->render();
		}
	}
?>