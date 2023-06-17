<?php
// session_start();
// echo $_SESSION['username_log'];

require_once '../layout/header.php';
require_once '../Controller/MainController.php';
if(!session_start()){
	session_start();
  }

if(!empty($_SESSION['username_log'])){
	
	echo 'here';
	header('Location: ../config/Routes.php?function=roomView');
}
$main = new MainController();
// $record = $main->getRecord();

?>

<div class="container">
	<div class="row d-flex justify-content-center mt-5">
		<div class="card-lg shadow-lg p-4 mt-5"  style="width: 24rem;">
			<h1 align="center">LEARNING MANAGEMENT SYSTEM</h1>
			<form id="login_Account" action="" method="POST">
				<div class="form-group mb-2">
					<input type="text" name="student_number" class="form-control" id="student_number" placeholder="Student Number" required></input>
				</div>
				<div class="form-group mb-2">
					<input type="text" name="birthday" class="form-control" id="birthday" placeholder="Birthday" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" required/>
				</div>
				<div class="form-group mb-2">
					<input type="password" name="password" class="form-control" id="password" placeholder="password" required></input>
				</div>
				<span><input type="checkbox" id="show-password" >&nbsp;<label for="show-password">Show Password</label></span>
				<br>
				<input type="submit" class="btn btn-primary" id="Login" value="Login"></input>
		</form>
		</div>


	</div>
</div>
<?php require_once '../layout/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	$(document).ready(function() {
		$('#show-password').on('click',function(){
			if($('#show-password').is(':checked') == true){
				$('#password').attr('type','text')
				}
			else{
					$('#password').attr('type','password')
				}
		})
		$('#login_Account').on('submit',function(e){
			e.preventDefault();
			// var formData = new FormData($("#login_Acount").get(0));
			var Student_number = $('#student_number').val();
			var birthday = $('#birthday').val();
			var password = $('#password').val();
			if(birthday == ''){

				alert('Please Enter Your BirthDay!')
				return false;
			}
			$.ajax({
                    url: '../config/Routes.php?function=login',
                    method: "post",
                    data:
					{
						Student_number:Student_number,
						birthday:birthday,
						password:password
					},
                    dataType: "json",
                    success: function(response) {

						console.log(response)
                      if(response.result == 1){
						location.href = '../config/Routes.php?function=roomView';
							
					  }
					  else if(response.result == 10){
						alert('Account Not Found');

					  }
					  else if(response.result == 11){
						alert('Invalid Student Number');

					  }

						else{
						alert('Credential Error!');
					  }
                    }, //endsucesss
                });
		})
	
		

		$('#add-room').on('click', function() {
			$('#room').prepend(`
					<div class="card room-class m-3 p-3">
						<input class="form-control m-1" type="" name="" placeholder="name of room" required/>
						<input  class="form-control m-1"type="" name="" placeholder="no. of max student"required>
						<input  class="form-control m-1"type="" name="" required/>
					</div>
				`)

		})
	})
</script>
</body>

</html>