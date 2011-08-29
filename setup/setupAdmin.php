<?php

	require_once('../core/smarty/libs/Smarty.class.php');
	$template = new Smarty();
	$template->template_dir = '../templates';
	$template->compile_dir = '../cache';


	if(($_POST['id']==NULL)||($_POST['pass1']==NULL)||($_POST['pass1']!=$_POST['pass2'])) {
			$form = "<form id='theForm' action='setupAdmin.php' method='post'><div class='formClass'><div class='label'>
					<label for='id'>UserID</label></div><div class='input'><input type='text' name='id'required />
					</div></div><div class='formClass'><div class='label'><label for='pass1'>Password</label></div><div
					 class='input'><input type='password' name='pass1'required /></div></div><div class='formClass'><div
					  class='label'><label for='pass2'>Confirm Pass</label></div><div class='input'><input type='password' 
					  name='pass2'required /></div></div><input type='submit' value='Save'>";
			$template->assign('form',$form);
			$template->assign('title',"Setup tinyDB");
			$template->assign('header',"Setup Admin");
			$template->display('form.tpl');
	}
	else 
	{
		require('../core/config.php');
		$con=mysql_connect($host,$user,$password);
		if (!$con) {
			die('Couldn\'t connect to MySQL database.');
		}
		mysql_select_db($db,$con);
		$sql = "INSERT INTO userAccount (id,uid,pass) VALUES (1,'".$_POST['id']."','".hash("md5",$_POST['pass1'])."')";
		if(mysql_query($sql)) {
			die("<script>window.location='./forms.php';</script>");
		}
	}
?>
