<?php

	
	require_once('../core/smarty/libs/Smarty.class.php');
	$template = new Smarty();
	$template->template_dir = '../templates';
	$template->compile_dir = '../cache';

	$str = "Please delete the <em>setup</em> directory for security measures. The files in the folder are not secure and may harm the current setup. This won't proceed any further unless you delete the said directory.";

	$template->assign('form',$str);
	$template->assign('title',"Enter Data");
	$template->assign('header',"Enter Data");
	$template->display('form.tpl');
