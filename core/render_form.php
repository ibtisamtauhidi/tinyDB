<?php

require_once('./cookie.php');
checkCookie('form');
	

class renderForm {

	function render() {
		$form = "<form id='theForm' action='save_form.php' method='post'>";

		require('./config.php');
		$con=mysql_connect($host,$user,$password);
		if (!$con) {
			die('Couldn\'t connect to MySQL database.');
		}
		mysql_select_db($db,$con);
		$result=mysql_query("SELECT * FROM  `formConfig` WHERE parent = 0");
		while($row = mysql_fetch_array($result)) {
			$id = $row['id'];
			$type = $row['type'];
			$label = $row['label'];			
			$required = $row['required'];
			$config = $row['config'];
			if($type!='select') {	
				$form= $form."\n<div class='formClass'>";
				$form= $form."\n\t<div class='label'><label for='".$label."'>".$label."</label></div>";
				$form= $form."\n\t<div class='input'><input type='".$type."' name='".$label."'";
				if($required==1)
					$form= $form."required /></div>\n</div>";
				else
					$form= $form."></div>\n</div>";
			}
			else {
				$selectQuery = mysql_query("SELECT * FROM  `formConfig` WHERE parent =".$id);
				$form= $form. "\n<div class='formClass'>\n\t<div class='label'><label for='".$label."'>".$label."</label></div>";
				$form= $form. "\n\t<div class='input'>\n\t\t<select name='".$label."'>";
				while($options = mysql_fetch_array($selectQuery)) {
						$form= $form. "\n\t\t\t<option>".$options['label']."</option>";
				}
				$form= $form. "\n\t\t</select>\n\t</div>\n</div>";
			}
		
		}
		$form= $form. "\n";
		$form= $form. "<input type='submit' value='Save'>\n</form>";
		return $form;
	}
}
$rendered_form = new renderForm();
$rendered_form_string = $rendered_form->render();
