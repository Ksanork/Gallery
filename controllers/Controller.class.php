<?php
    class Controller {
    	protected $raw_get;
		protected $raw_post;
		protected $raw_request;
		protected $raw_headers;
		
		//protected $variables;
		protected $message = null;
		protected $view = null;
		
		public function handleRequest($get, $post = null, $request = null) {
			$this->raw_get = $get;
			$this->raw_post = (is_null($post)) ? array() : $post;
			$this->raw_request = (is_null($request)) ? array() : $request;
		}
	
		public function display() {
			$this->controller->display();
		}
	
    }
?>