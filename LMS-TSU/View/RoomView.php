<?php

require_once '../layout/header.php';
require_once '../Controller/MainController.php';
if(!session_start()){
	session_start();
  }
if(empty($_SESSION['username_log'])){
	
	header('Location: ../config/Routes.php?function=logout');
}

$room = new MainController();
$roomView = $room->getRecord();

?>
<link href='https://fonts.googleapis.com/css?family=Gruppo' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Nova Flat' rel='stylesheet'>
<style>
    .add-room:hover{
            background-color: #8080803d;
            color:#212529;

    }
    span{
        font-family: 'Nova Flat';font-size: 16px;
}
.card-color{

    background-color: #212529;
    color:white;
    cursor: pointer;
}
    
</style>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">LMS</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Assignment</span> </a>
                        <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Ass#1</span> </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Calendar</span></a>
                    </li>
                    <li>
                        <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                            <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">feature</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">feature</span> </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 1</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 2</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 3</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 4</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">feature</span> </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1"><?php echo $_SESSION['FirstName_log']?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../config/Routes.php?function=logout">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col py-3" id="home-content">
            <h4 for="">Rooms</h4>
            <?php
            if((int)$roomView['Creator'] == 1):
            ?>
            <div >
                <a  class="btn btn-success">Create New Room</a>
            </div>
            <?php endif; ?>
           <div class="row m-4">
            <?php foreach($roomView["record"] as $key => $dataview):?>
            <div class="card-color  card m-1 col-md-2 add-room shadow-lg p-2">
                <span align="center"><?php echo $dataview['Subject']?></span><hr color="white">
                <span style="font-size: 11px;">Teacher:<?php echo $dataview['Teacher']?></span>
                <span style="font-size: 11px;">Created:<?php echo $dataview['CreatedDate']?></span>
                <span style="font-size: 11px;">Teacher:<?php echo $dataview['Teacher']?></span>
            </div>
            <?php endforeach; ?>
           
           </div>
        </div>
    </div>
    <div class="col py-3" id="assignment-content" hidden>
    </div>
    <div class="col py-3" id hidden>
    </div>
</div>
<?php require_once '../layout/footer.php';?> 