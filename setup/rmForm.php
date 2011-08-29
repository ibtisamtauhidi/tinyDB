<?php

if(!$_GET['id']) {
	die("Parameter Error");
}
require('../core/config.php');
$con = mysql_connect($host,$user,$password);
if (!$con) {
	die('Couldn\'t connect to MySQL database.');
}

$sql = "DELETE FROM `".$db."`.`formConfig` WHERE `formConfig`.`id` = ".$_GET['id'];
$done = mysql_query($sql);

$sql = "DELETE FROM `".$db."`.`formConfig` WHERE `formConfig`.`parent` = ".$_GET['id'];
$done = mysql_query($sql);
echo "<script>window.location='./forms.php';</script>";
?>
