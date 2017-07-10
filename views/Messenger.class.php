<?php
   	class Messenger {
   		private $message = null;
		private $flag = 'bad';			//czy wiadomość dobra czy zła
		
		public function isMessage() {
			if(isset($_SESSION['message']))
				return !empty($_SESSION['message']);
			else return false;
		}
		
		public function addMessage($message, $flag) {
			$this->message = $message;
			$this->flag = $flag;
			
			$_SESSION['message'] = $message;
			$_SESSION['message_flag'] = $flag;
		}
		
		public function getMessage() {
			//return $this->message;
			return $_SESSION['message'];
		}
		
		public function getFlag() {
			//return $this->flag;
			return $_SESSION['message_flag'];
		}
		
		public function clear() {
			$_SESSION['message'] = '';
			//unset($_SESSION['message_flag']);
		}
   	}
?>