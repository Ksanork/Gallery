<?php
    require_once 'dbo.class.php';
	
	define('FONT_PATH', 'static/fonts/Candara.ttf');
    
    class Gallery extends DBO {
    	protected $table = "images";
		protected $fields = array(
			'title' => null,
			'author' => null,
			'ext' => null,
			'private' => null
		);
		protected $file = null;
		
		
		
		public function getFile() {
			return $this->file;
		}
		
		public function setFile($file) {
			$this->file = $file;
		}
		
		public function checkSize($file) {
			return (filesize($file) < pow(1024, 2));
		}
		
		public function checkExt($ext) {
			return ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg');
		}
		
		public function addWatermark($ext, $text, $path, $newpath) {
			if($ext == 'png') $im = imagecreatefrompng($path);
			else $im = imagecreatefromjpeg($path);
	
			//dodać jako stałą
			//$font = FONT_PATH;
	  		$size = 50;
			$padding = 15;
			
			$type_space = imagettfbbox($size, 0, FONT_PATH, $text);
			
			$image_width = abs($type_space[4] - $type_space[0]) + 2*$padding;
			$image_height = abs($type_space[5] - $type_space[1]) + 2*$padding;
			
			$stamp = imagecreatetruecolor($image_width, $image_height);
			
			imagettftext($stamp, $size, 0, $padding, $padding + $size, 0xFFFFFF, FONT_PATH, $text);
			$marge_right = 10;
			$marge_bottom = 10;
			$sx = imagesx($stamp);
			$sy = imagesy($stamp);
	
			imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);
			
			if($ext == 'png') imagepng($im, $newpath);
			else imagejpeg($im, $newpath);
			imagedestroy($im);
		}
		
		private function createThumnbnail($ext, $src, $dest, $newwidth, $newheight) {
			list($width, $height) = getimagesize($src);
			
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			if($ext == 'png') $source = imagecreatefrompng($src);
			else $source = imagecreatefromjpeg($src);
	
			// Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	
			// Output
			if($ext == 'png') imagepng($thumb, $dest);
			else imagejpeg($thumb, $dest);
			imagedestroy($thumb);
		}
		
		public function getPublicPhotos() {
			return $this->find(array("private" => 'false'));
		}
		
		public function getPrivatePhotosByAuthor($author) {
			return $this->find(array(
								'author' => $author,
								"private" => 'true')
					);
		}
		
		public function savePhoto($watermark) {
			if($this->checkSize($this->file)) {
				if($this->checkExt($this->fields['ext'])) {
					
					$result = $this->insert($this->fields);
					if($result!= null) {
						if(move_uploaded_file($this->file, 'images/'. $this->fields['_id'] . "-org." . $this->fields['ext'])) {
							$this->createThumnbnail(
								$this->fields['ext'], 
								'images/'. $this->fields['_id'] . "-org." . $this->fields['ext'], 
								'images/' . $this->fields['_id'] . "-thumb."  . $this->fields['ext'], 
								200, 125);
							
							$this->addWatermark(
								$this->fields['ext'], 
								$watermark, 
								'images/' . $this->fields['_id'] . "-org." . $this->fields['ext'],
								'images/' . $this->fields['_id'] . "." . $this->fields['ext']);
							
							return 0;
						}
						else return -2;		//problem z przeniesieniem obrazu
					}
					else return -1;			//problem z dodanie do bazy
				}
				else return -3;				//złe rozszerzenie
			}
			else return -4;					//zły rozmiar
		}
		
		
		//!!!!!!!!!!!!!!!!!!11
		public function addToFavourites($f, $global) {
			if(!isset($global)) 
				$global = array();
			
			foreach($f as $c){
		    		if(!in_array($c, $global))
						$global[] = $c;
			}

			return $global;
			//print_r($_SESSION['favourites']);
		}
		
		public function removeFromFavourites($f, $global) {
			if(isset($global))  {
				foreach($f as $c){
					$i = array_search($c, $global);
			    	unset($global[$i]);
				}
			}
			
			return $global;
		}
		
		public function getFavourites($fav) {
			$f = array();
			
			if(count($fav) > 0) {
				foreach ($fav as $s) {
					$query = array(
						'_id' => new MongoId($s)
					);
					
					$result = $this->findOne($query);
					//if($result) {
						$f[] = array(
							'_id' => $result['_id'],
							'author' => $result['author'],
							'title' => $result['title'],
							//'watermark' => $result['watermark'],
							'ext' => $result['ext'],
							'private' => $result['private']
						);
					//}
				}
			
			
			}
			return $f;
		}
		
		public function getByName($a) {
			$f = array();
			
			$regex = "/$a/i";
			$img = array(
				'private' => 'false',
				'title' => new MongoRegex($regex)
			);
			
			$result = $this->find($img);
			foreach ($result as $p) 
				$f[] = array(
					'_id' => new MongoId($p['_id']),
					'author' => $p['author'],
					'title' => $p['title'],
					'ext' => $p['ext']
				);
			
			return $f;
		}
		
		public function __construct($id = null) {
			parent::__construct($id);
			//Utilities::loadModel('Session');
			//$this->session = new Session();
		}
	
	}
?>