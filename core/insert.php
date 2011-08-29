<?php

	require_once('./cookie.php');
	checkCookie('form');
	
	require_once('./smarty/libs/Smarty.class.php');
	$template = new Smarty();
	$template->template_dir = '../templates';
	$template->compile_dir = '../cache';

	require('./render_form.php');
	
	$template->assign('form',$rendered_form_string);
	$template->assign('title',"Enter Data");
	$template->assign('header',"Enter Data");
	$template->display('form.tpl');
