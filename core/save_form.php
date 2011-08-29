<?php

require_once('./cookie.php');
checkCookie('form');


if(!$_POST) {
	die("Parameter Error");
}
$xmlTop = "<?xml version='1.0'?><data>";
$xmlBottom= "</data>";
$xml = "";
foreach($_POST as $key=>$value) {
	$xml = $xml."<node><key>".$key."</key><value>".$value."</value></node>";
}
$xml= $xmlTop.$xml.$xmlBottom;
require('./config.php');
$con=mysql_connect($host,$user,$password);
if (!$con) {
	die('Couldn\'t connect to MySQL database.');
}

mysql_select_db($db,$con);
$time = time();
$sql = "INSERT INTO savedForm (id,datetime,formXML) VALUES (NULL,".$time.",\"".$xml."\")";
if(mysql_query($sql)) {
	require_once('./smarty/libs/Smarty.class.php');
	$template = new Smarty();
	$template->template_dir = '../templates';
	$template->compile_dir = '../cache';

	
	$template->assign('form',"Form saved.<br /><a href='./view.php'>View Database.</a>");
	$template->assign('title',"Enter Data");
	$template->assign('header',"Enter Data");
	$template->display('form.tpl');
}
else
	die("Error");
?>
