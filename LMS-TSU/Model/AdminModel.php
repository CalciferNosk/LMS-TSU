<?php


class AdminModel {

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
     public function getAuthAdmin($username){

        $sql = ("SELECT * FROM tbluserteacher where username = '{$username}'");
        
        return $this->database_connect($sql)->fetchAll(PDO::FETCH_ASSOC);
     }
     public function checkEnroll($data,$column){
        $sql = "SELECT count(*) as count_student FROM tbluserstudent WHERE {$column} = '{$data}'";
        
        return  $this->database_connect($sql)->fetchAll();

     }

     public function getEnroll(){
        $sql = ("SELECT 
                    a.id,
                    concat(a.FirstName,' ',SUBSTRING(a.MiddleName,1,1),'. ',a.LastName) as FullName,
                    a.Birthday,
                    a.EmailAddress,
                    a.Age,
                    concat(b.Street,'st. ',b.Barangay,' ',b.Municipality,' ',b.Country) as FullAddress,
                    b.Barangay,
                    b.Region,
                    c.Grade,
                    d.Section
                    
                FROM
                    tbluserstudent a
                LEFT JOIN 
                    address b on a.AddressId = b.id
                LEFT JOIN
                    tblsectioncategory d on a.SectionCategoryId  = d.id
                LEFT JOIN 
                    tblgradecategory c on a.GradeCategoryId = c.id
                    ");
      return  $this->database_connect($sql)->fetchAll();

     }
     public function addRecord($p){
        $password = 'default-'.$p['lname'];
        $date = date("Y-m-d",strtotime($p['bday']));
        $sql = "INSERT INTO `lms-tsu`.`tbluserstudent` (`StudentNumber`, `FirstName`, `MiddleName`, `LastName`, `Birthday`, `Password`, `AddressId`, `Age`, `GradeCategoryId`, `SectionCategoryId`)
                                                VALUES ({$p['studentnumber']},'{$p['fname']}','{$p['mname']}' ,'{$p['lname']}' ,'{$date}','$password',{$p['address']} ,{$p['age']} ,{$p['grade']},{$p['section']}  )
        ";
             $result =  $this->database_connect($sql);

            return 1;
     }

    
       
}

?>
