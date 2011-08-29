<?php

	require_once('./cookie.php');
	checkCookie('data');
	
	require_once('./smarty/libs/Smarty.class.php');
	$template = new Smarty();
	$template->template_dir = '../templates';
	$template->compile_dir = '../cache';

	require('./render_data.php');
	
	$template->assign('table',$rendered_table);
	$template->assign('header',"View Database");
	$template->display('table.tpl');
?>
