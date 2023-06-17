<?php
if(!session_start()){
	session_start();
  }

if(!empty($_SESSION['username_log'])){
	
	header('Location: ../config/Routes.php?function=roomView');
}
elseif(empty($_SESSION['username_log'])){
	
	header('Location: ../config/Routes.php?function=logout');
}
else{
	header('Location: ../Error/Login_Error.php');
}

?>