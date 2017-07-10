<?php
    class Viewer {
    	protected $header = '';
		protected $footer = '';
		protected $content = '';
		
		protected $variables = array();
		
		public function setHeader($header) {
			$this->header = $header;
		}
		
		public function setContent($content) {
			$this->content = $content;
		}
		
		public function setFooter($footer) {
			$this->footer = $footer;
		}
		
		public function setVariable($key, $value) {
			$this->variables[$key] = $value;
		}
		
		private function renderMessage() {
			global $messenger;
			
			//echo "Wiadomość: " . $messenger->getMessage();
			if($messenger->isMessage()) {
				include '../views/fragments/messenger.php';
				$messenger->clear();
			}
				
		}
		
		public function render() {
			if(!empty($this->header)) include $this->header;
			if(!empty($this->content)) include $this->content;		
			$this->renderMessage();
			if(!empty($this->footer)) include $this->footer;
			
		}
    }
?>