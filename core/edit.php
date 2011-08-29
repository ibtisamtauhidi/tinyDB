<?php

	require_once('./cookie.php');
	checkCookie('form');

	$str="";
	if($_GET['id']==NULL) {
		$str = "Parameter Error";
	}
	else if(($_GET['id']!=NULL)&&($_POST==NULL)) {
		require('./config.php');
		$con=mysql_connect($host,$user,$password);
		if (!$con) {
			die('Couldn\'t connect to MySQL database.');
		}
		mysql_select_db($db,$con);
		$result=mysql_query("SELECT id,formXML FROM `savedForm` WHERE id =".$_GET['id']);
		while($row = mysql_fetch_array($result)) {
			$id = $row['id'];
			$xml = $row['formXML'];			
			$str = "<form method='post' action='edit.php?id=".$id."'>";			
			$data = simplexml_load_string($xml);
  			foreach ($data->node as $node) { 
      			$str = $str."\n<div class='formClass'>\n\t<div class='label'><label for='".$node->key."'>".$node->key."</label></div>\n\t<div class='input'>\n\t\t\n\t<input type='text' name='".$node->key."' value='".$node->value."' /></div></div>";
  			} 			
  		}
		$str = $str. "<input type='submit' value='Save'>\n</form>";
	}
	else {
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
		$sql = "UPDATE savedForm set datetime = ".$time.", formXML = \"" .$xml."\" WHERE id=".$_GET['id'];
		if(mysql_query($sql))
			$str = $sql. "Form Saved. Go <a href='./view.php'>back</a>.";
		else
			$str = "Oops!!! Couldn't save form. Database error.";
	}




	require_once('./smarty/libs/Smarty.class.php');
	$template = new Smarty();
	$template->template_dir = '../templates';
	$template->compile_dir = '../cache';

	$template->assign('form',$str);
	$template->assign('title',"Delete Entry");
	$template->assign('header',"Delete Entry");
	$template->display('form.tpl');
