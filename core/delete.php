<?php


	require_once('./cookie.php');
	checkCookie('form');

	$str="";
	if($_GET['id']==NULL) {
		$str = "Parameter Error";
	}
	else if(($_GET['id']!=NULL)&&($_GET['confirm']=='true')) {
		require('./config.php');
		$con=mysql_connect($host,$user,$password);
		if (!$con) {
			die('Couldn\'t connect to MySQL database.');
		}

		mysql_select_db($db,$con);
		$sql = "DELETE FROM savedForm WHERE id = ".$_GET['id'];
		
		if(mysql_query($sql)) $str = "Entry Deleted. Go <a href='./view.php'>back</a>?";
		else $str = "Error";
	}
	else {
	$str = "<div id='delMsg'>Delete Entry?</div><div id'delForm><a href='./delete.php?confirm=true&id=".$_GET['id']."'>
			<button value='Yes'>Yes</button><a href = './view.php'><button value='No'>No</button></div>";
	}

	require_once('./smarty/libs/Smarty.class.php');
	$template = new Smarty();
	$template->template_dir = '../templates';
	$template->compile_dir = '../cache';

	$template->assign('form',$str);
	$template->assign('title',"Delete Entry");
	$template->assign('header',"Delete Entry");
	$template->display('form.tpl');
