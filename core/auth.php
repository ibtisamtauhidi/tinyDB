<?php

	require('./config.php');
	$status = "";
	if($_GET['logout']=='yes') {
		if((setrawcookie("tinyDBauth-".$db,'0',time()-3600,'/'))&&(setrawcookie("tinyDBauth-id-".$db,'0',time()-3600,'/')))	
			$status = "You are logged out.<br /><br /><form id='theForm' action='auth.php' method='post'><div class='formClass'><div class='label'>
					<label for='id'>UserID</label></div><div class='input'><input type='text' name='id' required />
					</div></div><div class='formClass'><div class='label'><label for='pass'>Password</label></div><div 
					class='input'><input type='password' name='pass' required /></div></div><input type='submit' value='Login'>";
		else 
			$status = "Unable to reset cookie.";
	} else if($_COOKIE["tinyDBauth-".$db]=='pass') {
		$status="You are already logged in. <a href='./auth.php?logout=yes'>Logout</a>?";
	} else if(($_POST['id']==NULL)||($_POST['pass']==NULL)) {
		$status = 	"<form id='theForm' action='auth.php' method='post'><div class='formClass'><div class='label'>
					<label for='id'>UserID</label></div><div class='input'><input type='text' name='id' required />
					</div></div><div class='formClass'><div class='label'><label for='pass'>Password</label></div><div 
					class='input'><input type='password' name='pass' required /></div></div><input type='submit' value='Login'>";
	} else {
		$con=mysql_connect($host,$user,$password);
		if (!$con) {
			die('Couldn\'t connect to MySQL database.');
		}
		mysql_select_db($db,$con);
		$result=mysql_query("SELECT * FROM `userAccount` WHERE uid = '".$_POST['id']."'");
		while($row = mysql_fetch_array($result)) {
			if($row['pass']==hash("md5",$_POST['pass'])) {
				if(setrawcookie("tinyDBauth-".$db,"pass",time()+3600,'/')) {
					$status = "You are logged in. Go <a href='../'>back.</a>";
				} else {
					$status = "Oops!!! Unable to set cookie.";	
				}
				
				if($row['id']==1) {
					setrawcookie("tinyDBauth-id-".$db,'admin',time()+3600,'/');
				} else {
					setrawcookie("tinyDBauth-id-".$db,'user',time()+3600,'/');			
				}
				
			} else {
				$status = "Oops!!! Either the userID or the password is wrong.";
				break;
			}
		}
	}
	require_once('../core/smarty/libs/Smarty.class.php');
	$template = new Smarty();
	$template->template_dir = '../templates';
	$template->compile_dir = '../cache';
	$template->assign('form',$status);
	$template->assign('title',"tinyDB Login");
	$template->assign('header',"Login");
	$template->display('form.tpl');
?>
