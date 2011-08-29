<?php

function checkFormPermission() {
	require('./config.php');
	if($formPermit==0) {
		if(($_COOKIE['tinyDBauth-'.$db]!='pass')&&($_COOKIE['tinyDBauth-id-'.$db]!='admin')) {
			renderndie("You don't have permission to access this page. Click <a href='./auth.php'>here</a> to login.");
		}
	}
	else if($formPermit==1) {
		if($_COOKIE['tinyDBauth-'.$db]!='pass') {
			renderndie("You don't have permission to access this page. Click <a href='./auth.php'>here</a> to login.");
		}
	}
}
function checkDataPermission() {
	require('./config.php');
	if($dataPermit==0) {
		if(($_COOKIE['tinyDBauth-'.$db]!='pass')&&($_COOKIE['tinyDBauth-id-'.$db]!='admin')) {
			renderndie("You don't have permission to access this page. Click <a href='./auth.php'>here</a> to login.");
		}
	}
	else if($dataPermit==1) {
		if($_COOKIE['tinyDBauth-'.$db]!='pass') {
			renderndie("You don't have permission to access this page. Click <a href='./auth.php'>here</a> to login.");
		}
	}
}
function checkCookie($var) {
	if ($var=='data') checkDataPermission();
	else if ($var=='form') checkFormPermission();
	else if ($var=='all') {
		checkDataPermission();
		checkFormPermission();
	}
}
function renderndie($str) {

	require_once('./smarty/libs/Smarty.class.php');
	$template = new Smarty();
	$template->template_dir = '../templates';
	$template->compile_dir = '../cache';

	
	$template->assign('form',$str);
	$template->assign('title',"Enter Data");
	$template->assign('header',"Enter Data");
	$template->display('form.tpl');

}
