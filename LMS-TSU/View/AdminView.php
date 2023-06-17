<?php
// session_start();
// echo $_SESSION['username_log'];

require_once '../layout/header.php';
require_once '../Controller/AdminController.php';
require_once '../Controller/MainController.php';
if(!session_start()){
	session_start();
  }

if(empty($_SESSION['username_admin'])){
	
	echo 'here';
	header('Location: ../config/Routes.php?function=logout');
}

$admin = new AdminController();
$main = new MainController();


$allStudent = $admin->getAllStudentEnroll();
$address = $main->getAddress();
$grade = $main->getGrade();
$res = $main->getSection();
$section = json_encode($res);



// var_dump('<pre>',$allStudent);die;
// foreach($allStudent as $key =>  $record){
//     echo $record['id'];
// }
// die;
// echo base64_encode('Admin');
?>
<style>
table{

   width: 100%;
    overflow: scroll;
}
.form-group{
    margin: 5px;
}
table.dataTable td {
  font-size: 1em;
}
table.dataTable tr.dtrg-level-0 td {
  font-size: 1.1em;
}
</style>

<a class="btn btn-danger" href="../config/Routes.php?function=logout">Sign out</a>
<h3 align="center">Admin Panel</h3>
<div class="container-fluid">
<div class="row">
    <div class="card shadow-lg col-md-7 p-3 m-3">
        <h2>Students Data</h2>
    <table id="Student_table" class="display cell-border hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>FullName</th>
            <th>BirthDay</th>
            <th>Adress</th>
            <th>Email Address</th>
            <th>Age</th>
            <th>Region</th>
            <th>Grade</th>
            <th>Section</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($allStudent as $key =>  $record) :?>
        <tr class="tr-row"  data-id="<?php echo $record['id']; ?>" style="width:100%">
            <td><?php echo $record['id']; ?></td>
            <td><?php echo $record['FullName']; ?></td>
            <td><?php echo $record['Birthday']; ?></td>
            <td data-Adress="<?php echo $record['FullAdress']; ?>"><?php echo $record['Barangay']; ?></td>
            <td><?php echo $record['EmailAddress']; ?></td>
            <td><?php echo $record['Age']; ?></td>
            <td><?php echo $record['Region']; ?></td>
            <td><?php echo $record['Grade']; ?></td>
            <td><?php echo $record['Section']; ?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
    </div>
    <div class="card shadow-lg col-sm-4 m-3 p-3 " >
        <h3>Enroll Student</h3>
            <form  id="enroll_student" action="">
            <div class="form-group">
                    <input class="form-control" type="number"  name="studentnumber" placeholder="Studen Number">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="fname" placeholder="First Name">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="mname" placeholder="Middle Name">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="lname" placeholder="Last Name" >
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="bday" placeholder="Birthday" id="bday" onfocus="(this.type='date')" onblur="(this.type='text')">
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" name="age" placeholder="Age" id="age" style="pointer-events: none;background-color:#e7e7e791">
                </div>
                <div class="form-group">
                    <select class="form-control" name="address" id="address" >
                        <option value="">Select Address</option>
                        <?php foreach( $address as $key => $add):?>
                        <option value="<?php echo $add['id'] ?>"><?php echo $add['Location'] ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <select   class="form-control" name="grade" id="grade">
                    <option value="">Select Grade</option>
                        <?php foreach( $grade as $key => $grade):?>
                            <option value="<?php echo $grade['id'] ?>"><?php echo $grade['Grade'] ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <select   class="form-control" name="section" id="section" >
                        <option color="gray" value="">Select Grade First</option>
                     
                        
                    </select>
                </div>
                <input class="btn btn-success" type="submit" value="Register Student">
            </form>
    </div>
</div>

</div>

<?php  require_once '../layout/footer.php'; ?>

<script>
    $(document).ready(function() {
     var section_data = <?php echo $section ?>
       
    $('#grade').select2();
    $('#address').select2();
    $('#grade').on('change',function(){   
        var value = $(this).val();
        var opt = `<option value="">Select Section</option>`;
        $.each(section_data, function(k,v){
            
            if(value == v.GradeCategoryId){
               
                opt += `<option value="${v.id}">${v.Section}</option>`
            }
            $('#section').html(opt)

        })
    })
    $('#bday').on('focus',function(){
        $('#age').attr('Placeholder','Calculating Age....')
    })
    $('#bday').on('blur',function(){
        var enteredDate = $(this).val();
        var years = new Date(new Date() - new Date(enteredDate)).getFullYear() - 1970;
        $('#age').attr('Placeholder','Age')
       $('#age').val(years)
    })
    $('#enroll_student').on('submit',function(e){
        e.preventDefault();
        var formData = new FormData($(this).get(0));
        

        if($('#section').val() == ''){
            alert('check section')
            return false;
        }
        if($('#grade').val() == 0){
            alert('check Grade')
            return false;
        }
        $.ajax({
                    url: '../config/Routes.php?function=AddStudent',
                    method: "post",
                    contentType:false,
                    processData:false,
                    data:formData,
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        if(response == 'exist'){
                            alert('This Student Number Already Enrolled!')
                        }
                        else if(response == 'success'){
                            alert('success')
                        }
                        else if(response == 'error'){
                            aler('input error please check.')
                        }
                        else if(response == 'error_student'){
                            alert('invalid Student Number!')
                        }
                    }, //endsucesss
                });

    })


});
    $(document).ready(function () {
        // $('select').selec2();
    let table = $('#Student_table').DataTable( {responsive: true,pageLength : 5});


  
    
});
    // let table = new DataTable('#Student_table');
    
</script>
