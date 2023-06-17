<?php
// require_once'../config/database.php';
require_once'../Model/MainModel.php';

  class MainController extends MainModel {   

        function __construct(){
            // parent::__construct("MainModel");
        	$this->main_m = new MainModel();
          // $this->db = $this->main_m->database_connect();
            
        }

        
        public function getRecord(){

          if($_SESSION['Status'] == 1){
            
            $data['record']  = $this->main_m->getRoomByStudentEnroll($_SESSION['username_log']);
            $data['Editor']  = 1;
            $data['Creator']  =  1;

          }else{

          $result_access = $this->main_m->getWorkGroupAccess((int)$_SESSION['username_log']);

          foreach($result_access as $key => $access){

            $data['record']  = $access['Viewer'] == 1 ?  $this->main_m->getRoomByStudentEnrollByUser($_SESSION['username_log']) : [];
            $data['Editor']  =  $access['Editor'];
            $data['Creator']  =  $access['Creator'];

          }
        }

        	return $data;
        }

        public function deleteRoom(){

        	var_dump('this function for deleteRoom');die;
        }

      

        public function login(){
          
          if((int)$_POST['Student_number']  == 0){
           
            return 11;#Invalid StudentNumber
          }
          else{
            $result = $this->main_m->getAuth($_POST);
            if($result == []){

              return 10;#Account NOt FOUND
            }
            $data =  $result[0];

            if((int)$data['Password'] == (int)$_POST['password']){
              
                if($data['StudentNumber'] == $_POST['Student_number'] && $data['Birthday'] == $_POST['birthday']){
                  
                  #session here
                  session_start();
                  $_SESSION['username_log'] = $data['StudentNumber'];
                  $_SESSION['password_log'] = base64_encode($data['Password']);
                  $_SESSION['FirstName_log'] = $data['FirstName'];
                  $_SESSION['MiddleName_log'] = $data['MiddleName'];
                  $_SESSION['LastName_log'] = $data['LastName'];
                  $_SESSION['Birthday_log'] = $data['Birthday'];
                  $_SESSION['AddressId_log'] = $data['AddressId'];
                  $_SESSION['GradeCategoryId_log'] = $data['GradeCategoryId'];
                  $_SESSION['SectionCategoryId_log'] = $data['SectionCategoryId'];
                  $_SESSION['EmailAddress_log'] = $data['EmailAddress'];
                  $_SESSION['EnrollDate_log'] = $data['EnrollDate'];
                  $_SESSION['ActiveStatus_log'] = $data['ActiveStatus'];
                  $_SESSION['Status'] = 0;
                return 1;
                }
                else{
                  return 0;
                }
            }
            else{
              return 0;
            }
          }
        
        }

        public function session_logout(){
          session_start();
          if(isset($_SESSION)){
            session_destroy();
        }
          header('Location: ../View/MainView.php');
        }
        public function getAddress(){

          return $this->main_m->getAllAddress();
        }
        public function getGrade(){
          return $this->main_m->getAllGrade();

        }
        public function getSection(){
          return $this->main_m->getAllSection();

        }
   }
