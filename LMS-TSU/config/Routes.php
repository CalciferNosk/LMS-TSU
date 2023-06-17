<?php
#helper here
// include_once '../Helper/MainHelper.php';






#Routes
// include 'database/connect.php';
require_once '../Controller/MainController.php';
require_once '../Controller/AdminController.php';
	$main = new MainController();

	$admin = new AdminController();
	if(!isset($_GET['function'])){
		header('Location: ../Error/Login_Error.php');
	}
	
   switch ($_GET['function']) {
			case 'getRecord':
				  $main->getRecord();
				break;
			case'deleteRoom':
				  $main->deleteRoom();
				break;
			case'logout':
					$main->session_logout();
				  break;
			case'roomView':
					header('Location: ../View/RoomView.php');
				  break;
			case'login':
					$result = validate_login($_POST);
					$result_login['result'] =  $main->login();

					echo json_encode($result_login);
				break;
			case'AdminLogin':
					$result = $admin->adminLogin($_POST);

					echo json_encode( $result);
				break;
			case 'AdminView':
				header('Location: ../View/AdminView.php');
				break;
			case 'AddStudent':
				$result = $admin->addStudent($_POST);
				echo json_encode($result);
				break;
			
			default:
				header('Location: ../View/MainView.php');
				break;
		}	

 function validate_login($post){
		if(!isset($post['username'])){
			return false;
		}
		if(!isset($post['password'])){
			return false;
		}
		else{
			return true;
		}
}
?>
