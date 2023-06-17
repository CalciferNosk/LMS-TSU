<?php
// session_start();
// echo $_SESSION['username_log'];

require_once '../layout/header.php';
require_once '../Controller/MainController.php';
if(!session_start()){
	session_start();
  }

if(!empty($_SESSION['username_admin'])){
	
	header('Location: ../config/Routes.php?function=AdminView');
}

if(isset($_SESSION['username_log'])){
    header('Location: ../config/Routes.php?function=roomView');
}

// $main = new MainController();
// $record = $main->getRecord();

?>
<style>
    .form-group{
        margin-bottom: 5px;
    }
</style>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="card mt-5 p-5">
            <h3>Admin Panel</h3>
            <form method="post" id="admin_login">
                <div class="form-group">
                    <input type="text" class="form-control" name="username"  placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="token" placeholder="Token" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="password" placeholder="Password" required>
                </div>
                <input type="submit" id="admin_btn" class="btn btn-primary" value="login">
            </form>
        </div>

    </div>
</div>
<?php require_once '../layout/footer.php'; ?>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script>
    $(document).ready(function(){
        $('#admin_login').on('submit',function(e){
            e.preventDefault();
            var formData = new FormData($('#admin_login').get(0));

            $.ajax({
                    url: '../config/Routes.php?function=AdminLogin',
                    method: "post",
                    contentType:false,
                    processData:false,
                    data:formData,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                      if(response == 'QWRtaW4='){
                        console.log('admin')
						location.href ='../config/Routes.php?function=AdminView';
					  }
                      else if( response == 'dGVhY2hlcg=='){
                        console.log('here')
                        location.href = '../config/Routes.php?function=roomView';
                      }
					  else if(response == 'error_token'){
						alert('Token Error');

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

    })
</script>