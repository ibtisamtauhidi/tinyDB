<?php


$str = "";
if($_GET['type']==NULL) {
	$str = "<form id='theForm' action='setupForm.php' method='get'><div class='formClass'><div class='label'><label for='type'>Select type :</label></div><div class='input'><select name='type'><option>text</option><option>password</option><option>url</option><option>email</option><option>date</option><option>datetime</option>	<option>number</option><option>select</option></select></div></div><input type='submit' value='Next'>";
}
else if(($_GET['type']!='select')&&($_POST['name']==NULL)) {
	$str = "<form id='theForm' action='setupForm.php?type=".$_GET['type']."' method='post'><div class='formClass'><div class='label'>
			<label for='name'>Name</label></div><div class='input'><input type='text' name='name'required />
			</div></div><div class='formClass'><div class='label'><label for='reqd'>Required ?</label></div><div 
			class='input'><input type='checkbox' name='reqd' /></div></div><input type='submit' value='Save'>";
}
else if(($_GET['type']=='select')&&($_POST['name']==NULL)&&($_POST['options']==NULL)) {
	$str = "<form id='theForm' action='setupForm.php?type=".$_GET['type']."' method='post'><div class='formClass'><div class='label'>
			<label for='name'>Name</label></div><div class='input'><input type='text' name='name'required />
			</div></div><div class='formClass'><div class='label'><label for='reqd'>Required ?</label></div><div 
			class='input'><input type='checkbox' name='reqd' /></div></div><div class='formClass'><div class='label'><label for='opt'>Options (seperate by commas)
			</label></div><div class='input'><input type='text' name='opt' /></div></div><input type='submit' value='Save'>";
}

else if(($_GET['type']!='select')&&(($_GET['type']=='text')||($_GET['type']=='password')||($_GET['type']=='checkbox')||($_GET['type']=='email')||($_GET['type']=='url')||($_GET['type']=='date')||($_GET['type']=='datetime')||($_GET['type']=='number'))&&($_POST['name']!=NULL)) {

	$type=$_GET['type'];
	$name=$_POST['name'];

	if($_POST['reqd']!=NULL)
		$reqd = 1;
	else
		$reqd = 0;

	require('./addForm.php');
	
	$b = new formSetup;
	$b->addForm($name,$type,$reqd,0);
	$b->commit();
	
	$str = "<script>window.location='./forms.php';</script>";
}
else if(($_GET['type']=='select')&&($_POST['name']!=NULL)&&($_POST['opt']!=NULL)) {

	$type=$_GET['type'];
	$name=$_POST['name'];

	if($_POST['reqd']!=NULL) 
		$reqd = 1;
	else 
		$reqd = 0;

	$opt = explode(",",$_POST['opt']);

	require('./addForm.php');

	$b = new formSetup;
	$b->addForm($name,$type,$reqd,0);

	foreach ($opt as $curr) {
		$b->addOption($curr);
	}
	$b->commit();
	$str = "<script>window.location='./forms.php';</script>";
}

require_once('../core/smarty/libs/Smarty.class.php');
$template = new Smarty();
$template->template_dir = '../templates';
$template->compile_dir = '../cache';
$template->assign('form',$str);
$template->assign('header',"Setup tinyDB");
$template->display('form.tpl');

?>
