<?php
    class DBO {
    	//public $pk = 'id';
		protected $table;
		private $table_mysql;
		
		protected $fields = array('id' => null);
		//private $fields_mysql;
		protected $fields_constraints = array();
		protected $updated = array();
		
		protected $inserteds = false;
		protected $database;
		
		public function __construct($id = null) {
			global $controller;
			$this->database = $controller->getDatabaseHandle();
			//if(!is_null($id)) {
			//	$this->load($id);
			//}
		}
		
		public function get($var) {
			//if(array_key_exists($var, $this->fields)) {
				return $this->fields[$var];
			//}
			//else return null;
		}
		
		public function findOne($fields) {
			return $this->database->selectCollection($this->table)->findOne($fields);
		}
		
		public function find($fields) {
			return $this->database->selectCollection($this->table)->find($fields);
		}
		
		public function save() {
			if($this->inserted) return $this->update();
			else return $this->insert();
		}
		
		public function set($field, $value) {
		if (array_key_exists($field, $this->fields)) {
			if ($this->fields[$field] != $value) {
				// Throws an exception 
				$this->fields[$field] = $value;
				$this->updated[$field] = true;
				
			}
			return true;
		} else {
			return false;
		}
	}
		
		//jakaś walidacja
		public function setFields($fields) {
			$this->fields = $fields;
		}
		
		public function insert() {
			//$db = get_db();
			
			return $this->database->selectCollection($this->table)->insert($this->fields);
		}
		
		public function insertQuery($q) {
			//$db = get_db();
			
			return $this->database->selectCollection($this->table)->insert($q);
		}
    }
?>