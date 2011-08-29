<?php


if($_POST==NULL) {	
	require_once('../core/smarty/libs/Smarty.class.php');
	$template = new Smarty();
	$template->template_dir = '../templates';
	$template->compile_dir = '../cache';

	$form = "<form id='theForm' action='setupConfig.php' method='post'><div class='formClass'><div class='label'><label for='name'>MySQL User Name</label></div><div class='input'><input type='text' name='name' required /></div></div><div class='formClass'><div class='label'><label for='pass'>MySQL Password</label></div><div class='input'><input type='password' name='pass' required ></div></div><div class='formClass'> <div class='label'><label for='DB'>Database Name</label></div><div class='input'><input type='text' name='DB' required /></div></div><div class='formClass'> <div class='label'><label for='host'>Host:Port</label></div> <div class='input'><input type='text' name='host' /></div></div><div class='formClass'> <div class='label'><label for='formPermission'>Who can insert data?</label></div> <div class='input'><select name='formPermission'><option value='2'>Public</option><option value='0'>Only Admin</option><option value='1'>Only Admin and sub-admins</option></select></div></div><div class='formClass'><div class='label'><label for='dataPermission'>Who can view data?</label></div><div class='input'><select name='dataPermission'><option value='2'>Public</option><option value='0'>Only Admin</option><option value='1'>Only Admin and sub-admins</option></select></div></div><input type='submit' value='Save'></form>";
	$template->assign('form',$form);
	$template->assign('header',"Setup tinyDB");
	$template->display('form.tpl');
	
}
else if(($_POST['name']!=NULL)&&($_POST['pass']!=NULL)&&($_POST['DB']!=NULL)&&($_POST['dataPermission']!=NULL)&&($_POST['formPermission']!=NULL)) {
	if($_POST['host']==NULL)
		$host = '127.0.0.1';
	else
		$host = $_POST['host'];


	$php = "<?php\n\t\$user = '".$_POST['name']."';\n\t\$password = '".$_POST['pass']."';\n\t\$host = '".$host."';\n\t\$db = '".$_POST['DB']."';\n\t\$dataPermit = ".$_POST['dataPermission'].";\n\t\$formPermit = ".$_POST['formPermission'].";\n?>";

	$fileHandle = fopen('../core/config.php', 'w') or die("Can't open file. Please enable write permission.");
	fwrite($fileHandle, $php);
	fclose($fileHandle);
	die("<script>window.location='./setupDB.php'</script>");
}

?>
