<?php

	include('./setup/setupVerify.php');
	if($verify_install=='no') {
		echo "<script>window.location='./setup/setupConfig.php';</script>";
	}
	else {
		echo "<script>window.location='./core/insert.php';</script>";
	}
