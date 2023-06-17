<?php
// require_once'../config/database.php';
require_once'../Model/AdminModel.php';

  class AdminController extends AdminModel {   

        function __construct(){
            // parent::__construct("MainModel");
        	$this->admin_m = new AdminModel();
          // $this->db = $this->main_m->database_connect();
            
        }

       
        public function adminLogin($post){
            $token = date('md');
            if($post['token'] == $token){
                
               $result =  $this->admin_m->getAuthAdmin($post['username']);
               if($result == []){

                return 10;#Account NOt FOUND
              }
                if($result[0]['Password'] == $post['password']){
                    session_start();
                      
                        $_SESSION['password_log']     = base64_encode($result[0]['Password']);
                        $_SESSION['FirstName_log']    = $result[0]['FirstName'];
                        $_SESSION['MiddleName_log']   = $result[0]['MiddleName'];
                        $_SESSION['LastName_log']     = $result[0]['LastName'];
                        $_SESSION['AddressId_log']    = $result[0]['AddressId'];
                        $_SESSION['EmailAddress_log'] = $result[0]['EmailAddress'];
                        $_SESSION['EnrollDate_log']   = $result[0]['HiredDate'];
                        $_SESSION['ActiveStatus_log'] = $result[0]['ActiveStatus'];

                        
                    if($result[0]['AdminStatus'] == 1){
                      
                        $_SESSION['username_admin'] = $result[0]['username'];
                        
                        return base64_encode('Admin');
                    }
                    else {
                        $_SESSION['username_log'] = $result[0]['username'];
                        $_SESSION['Status'] = 1;
                        return base64_encode('teacher');
                    }
                   
                }

            }
            else{
                return 'error_token';
            }
        } 
        public function getAllStudentEnroll(){
           return $this->admin_m->getEnroll();
        }
        public function addStudent($post){
            if((int)$post['studentnumber'] == 0){
                return 'error_student';
            }
            $lenght = strlen($post['studentnumber']);
            if($lenght < 7 || $lenght > 7){
                return 'error_student';
            }
            $count = $this->admin_m->checkEnroll($post['studentnumber'],'StudentNumber');
            // var_dump($count);die;
            if((int)$count[0]['count_student'] != 0){
                return 'exist';
            }else{

                $result =  $this->admin_m->addRecord($post);
                return $result == 1 ? 'success':'error';
            }



           
        }
   }
