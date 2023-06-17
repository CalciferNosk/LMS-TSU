<?php


class MainModel {

 	function __construct(){

            // $this->tableName = $tableName;
       //      $this->db = $this->database_connect();
     }
     public function database_connect($sql){
         
       $servername = "localhost";
       $username = "root";
       $password = "root";
       $dbname = "lms-tsu";
       
       try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $stmt = $conn->prepare($sql);
              $stmt->execute();
             
              // set the resulting array to associative
              $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
              return $stmt;
              
       } catch(PDOException $e) {
              echo "Error: " . $e->getMessage();
       }
       $conn = null;
      
     }

     public function getWorkGroupAccess($user){

       $sql = "SELECT * FROM tblworkgroupaccess where UserId = {$user} ";
       $getWorkGroupAccess = $this->database_connect($sql)->fetchAll(PDO::FETCH_ASSOC);

       return $getWorkGroupAccess;

     }

     public function getRoomByStudentEnroll($user){

       $sql = "SELECT 
                     a.id,
                     upper(b.`Subject`) as `Subject`,
                     b.SubjectCode,
                     a.CreatedDate,
                     CONCAT(c.LastName,', ',c.FirstName,' ',SUBSTRING(c.MiddleName, 1, 1),'.') as Student,
                     CONCAT(d.LastName,', ',d.FirstName,' ',SUBSTRING(d.MiddleName, 1, 1),'.') as Teacher
              FROM 
                     tblroom as a
              LEFT JOIN 
                     tblsubject as b on a.SubjectId = b.id
              LEFT JOIN 
                     tbluserstudent as c on a.UserStudentId = c.id
              LEFT JOIN 
                     tbluserteacher as d on a.UserTeacherId =d.id
              WHERE 
                     a.UserTeacherId = {$user} ";

       $getRoomByStudentEnroll = $this->database_connect($sql)->fetchAll();


       return $getRoomByStudentEnroll;
     }

     public function getRoomByStudentEnrollByUser($user){

       $sql = "SELECT 
                     a.id,
                     upper(b.`Subject`) as `Subject`,
                     b.SubjectCode,
                     a.CreatedDate,
                     CONCAT(c.LastName,', ',c.FirstName,' ',SUBSTRING(c.MiddleName, 1, 1),'.') as Student,
                     CONCAT(d.LastName,', ',d.FirstName,' ',SUBSTRING(d.MiddleName, 1, 1),'.') as Teacher
              FROM 
                     tblroom as a
              LEFT JOIN 
                     tblsubject as b on a.SubjectId = b.id
              LEFT JOIN 
                     tbluserstudent as c on a.UserStudentId = c.id
              LEFT JOIN 
                     tbluserteacher as d on a.UserTeacherId =d.id
              WHERE 
              UserStudentId = {$user}";
       $getRoomByStudentEnrollByUser = $this->database_connect($sql)->fetchAll();
       
       return $getRoomByStudentEnrollByUser;
     }
     

       public function getAuth($post){

       $sql = "SELECT * FROM tbluserstudent WHERE StudentNumber = {$post['Student_number']}";
       return $this->database_connect($sql)->fetchAll(PDO::FETCH_ASSOC);
   

       }
       public function getAllAddress(){

              $sql = "SELECT 
                            id,
                     concat(Street,'st. ',Barangay,' ',Municipality,' ',City,Country) as `Location`
                     FROM 
                            `address`
                     WHERE 
                            ActiveStatus = 1";

              return $this->database_connect($sql)->fetchAll();

       }
       public function getAllGrade(){
              $sql = "SELECT 
                            *
                     FROM
                            tblgradecategory
                     WHERE 
                            ActiveStatus = 1";
               return $this->database_connect($sql)->fetchAll();

       }
       public function getAllSection(){
              $sql = " SELECT
                      id,
                      Section,
                      GradeCategoryId
                     FROM
                     tblsectioncategory
                     WHERE
                            ActiveStatus = 1";
               return $this->database_connect($sql)->fetchAll();

       }
       
}

?>
