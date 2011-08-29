<?php

$form = "<table><tr><th>Name</th><th>Type</th><th>Required</th><th>Options</th><th>Delete</th><tr>";
require('../core/config.php');
$con=mysql_connect($host,$user,$password);
if (!$con) {
	die('Couldn\'t connect to MySQL database.');
}
mysql_select_db($db,$con);
$result=mysql_query("SELECT * FROM  `formConfig` WHERE parent = 0");
while($row = mysql_fetch_array($result)) {
	$id = $row['id'];
	$type = $row['type'];
	$label = $row['label'];			
	$required = $row['required'];
	$config = $row['config'];
	if($type!='select') {	
			$form = $form."<tr><th>".$label."</th><th>".$type."</th><th>".$required."</th><th></th><th><a href='./rmForm.php?id=".$id."'><img src='../images/delete.png' alt='Delete' /></a></th></tr>";
		}
	else {
		$selectQuery = mysql_query("SELECT * FROM  `formConfig` WHERE parent =".$id);
		$form = $form."<tr><th>".$label."</th><th>".$type."</th><th>".$required."</th><th><ul>";
		while($options = mysql_fetch_array($selectQuery)) {
						$form= $form. "<li>".$options['label']."</li>";
		}
		$form = $form."</ul></th><th><a href='./rmForm.php?id=".$id."'><img src='../images/delete.png' alt='Delete' /></a></th></tr>";
	}	
}
$form=$form."</table><br /><a href='./setupForm.php'><button>Add Form</button></a><a href='./finalize.php'><button>Next</button></a>";

require_once('../core/smarty/libs/Smarty.class.php');
$template = new Smarty();
$template->template_dir = '../templates';
$template->compile_dir = '../cache';
$template->assign('table',$form);
$template->assign('header',"Setup Form");
$template->display('table.tpl');

?>
