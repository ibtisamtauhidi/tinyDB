<?php


require_once('./cookie.php');
checkCookie('data');


class renderTable {

	function render() {
	
		require('./config.php');
		$con=mysql_connect($host,$user,$password);
		if (!$con) {
			die('Couldn\'t connect to MySQL database.');
		}
		mysql_select_db($db,$con);
		$result=mysql_query("SELECT label FROM  `formConfig` WHERE parent = 0");
		while($row = mysql_fetch_array($result)) {
			$keyArray[] = $row['label'];		
		}
		if(!$keyArray) die("Please setup form. Click <a href='../setup/'>here</a>.");
		$table = "<table><tr>";
		foreach($keyArray as $key) {
			$table = $table."<th>".$key."</th>";
		}
		$table = $table."<th>Date/Time</th><th></th>";
		$table = $table."</tr>";
		$result=mysql_query("SELECT * FROM  `savedForm`");
		while($row = mysql_fetch_array($result)) {
			$table = $table."<tr>";
			$id = $row['id'];
			$datetime = $row['datetime'];
			$xml = $row['formXML'];
			$time = new DateTime();
			$time->setTimestamp($datetime);
			
			
			$data = simplexml_load_string($xml);
			foreach ($keyArray as $key) {
				$done=0;
  				foreach ($data->node as $node) { 
      				if($key==$node->key) {
      					$table = $table."<th>".$node->value."</th>";
      					$done=1;
      				}
  				}
  				if($done==0) $table = $table."<th></th>";
  			}
			$table = $table."<th>".$time->format('d M Y | h:i:s a')."</th><th><a href='./delete.php?id=".$id."'><img src='../images/delete.png' 
					alt='Delete' /></a><a href='./edit.php?id=".$id."'><img src='../images/edit.png' alt='Edit' /></a></th>";
  			$table = $table."</tr>";
  		}
  		$table = $table."</table>";
		return $table;
	}		
}
$render_table = new renderTable();
$rendered_table = $render_table->render();
