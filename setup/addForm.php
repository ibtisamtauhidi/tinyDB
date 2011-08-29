<?php

class formSetup {

	var $name,$type,$id,$required,$config;
	var $options;
	
	function addForm($name,$type,$required,$config) {
		$this->name = $name;
		$this->type = $type;
		$this->required = $required;
		$this->config = $config;
	}
	
	function addOption($value) {
		$this->options[]=$value;
	}
	
	
	function commit() {
		require('../core/config.php');
		$con=mysql_connect($host,$user,$password);
		if (!$con) {
			die('Couldn\'t connect to MySQL database.');
		}
		mysql_select_db($db,$con);


		if($this->type!=NULL) {
			$sql = "INSERT INTO formConfig (id,type,label,parent,required,config) VALUES (NULL,
				   '".$this->type."','".$this->name."',0,".$this->required.",".$this->config.")";
			$done = mysql_query($sql);
		}

		$result=mysql_query("SELECT id FROM  `formConfig` ORDER BY  `formConfig`.`id` DESC LIMIT 1");
		
		while($row = mysql_fetch_array($result)) {
			$this->id = $row['id'];
		}
				
		if($this->type=='select') {
			$i = $this->id+1;
			foreach ($this->options as $current) {
				$sql = "INSERT INTO formConfig (id,type,label,parent,required,config) VALUES (NULL,'OPTION','".$current."',".$this->id.",0,0)";
				$done = mysql_query($sql);
				$i+=1;
			}
		}
	}
}
?>
