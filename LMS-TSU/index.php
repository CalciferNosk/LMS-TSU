<?php


switch (isset($_GET['location'])) {
	case 'store-data':
			header('Location:config/Routes.php/store-data');
		break;
	case 'delete-room':
			header('Location:config/Routes.php?function=deleteRoom');
		break;
	
	default:
			header('Location:View/MainView.php');
		break;
}
?>