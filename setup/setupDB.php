<?php

	require('../core/config.php');
	$con=mysql_connect($host,$user,$password);
	if (!$con) {
		die('Couldn\'t connect to MySQL database.');
	}
	mysql_query("CREATE DATABASE  `".$db."` ;");
	mysql_query("CREATE TABLE  `".$db."`.`formConfig` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , `type` VARCHAR( 15 ) NOT NULL , `label` VARCHAR( 30 ) NOT NULL , `parent` INT NOT NULL , `required` INT NOT NULL , `config` INT NOT NULL ) ENGINE = MYISAM ;");
	mysql_query("CREATE TABLE  `".$db."`.`savedForm` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , `datetime` VARCHAR( 40 ) NOT NULL , `formXML` VARCHAR( 2048 ) NOT NULL ) ENGINE = MYISAM ;");
	mysql_query("CREATE TABLE  `".$db."`.`userAccount` ( `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , `uid` VARCHAR( 15 ) NOT NULL , `pass` VARCHAR( 40 ) NOT NULL ) ENGINE = MYISAM ;");
	die("<script>window.location='./setupAdmin.php'</script>");
?>
