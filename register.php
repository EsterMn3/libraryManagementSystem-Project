<?php
require_once("DBConnection.php");
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM `user_list` where user_id = '{$_GET['id']}'");
    foreach($qry->fetch_assoc() as $k => $v){
        $$k = $v;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/script.js"></script>
    <style>
        html, body{
            height:100%;
        }
        body{
            background-image:url('./images/library.jpg') !important;
            background-size:cover;
            background-repeat:no-repeat;
            background-position:center center;
            color: white;
        }
        h1#sys_title {
            font-size: 6em;
            text-shadow: 3px 3px 10px #000000;
        }
        @media (max-with:700px){
            h1#sys_title {
                font-size: inherit !important;
            }
        }

    </style>
</head>
<body class="">
   <div class="bg-img">
      <div class="content">
        <header>Registration Form</header>
        <form action="" id="user-form">
          <input type="hidden" name="id" value="<?php echo isset($user_id) ? $user_id : '' ?>">
            <div class="form-group">
                <input type="text" style="font-family: 'Poppins', sans-serif; font-size: 16px;" name="fullname" id="fullname" required class="form-control form-control-sm rounded-0" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : '' ?>" placeholder="Full Name">
            </div>
            <div class="form-group">
                <input  type="text" name="username" id="username"  required class="form-control form-control-sm rounded-0" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" placeholder="Username">
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input type="password" style="font-family: 'Poppins', sans-serif; font-size: 16px;" name="password" id="new_password" class="form-control form-control-sm rounded-0" placeholder="Password">
                        <button class="btn btn-outline-secondary toggle-password" type="button">Show</button>
                </div>
            </div>

            <div class="form-group d-flex w-100 justify-content-center ">
                <button class="btn btn-lg btn-primary rounded-0 my-1" type="submit" name="register">Register</button>
            </div>

        </form>
      </div>
    </div>
</body>
</html>
<script>
    $(function(){
      $('.toggle-password').click(function(){
            var input = $(this).closest('.input-group').find('input');
            if(input.attr('type') === 'password'){
                input.attr('type', 'text');
                $(this).text('Hide');
            }else{
                input.attr('type', 'password');
                $(this).text('Show');
            }
        });
        $('#user-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove();
            var _this = $(this);
            var _el = $('<div>');
            _el.addClass('pop_msg');

            // Username length validation
            var username = $('#username').val().trim();
            if (username.length < 8) {
                _el.addClass('alert alert-danger');
                _el.text('Username must be 8 or more characters long.');
                _this.prepend(_el);
                _el.show('slow');
                return; // Prevent form submission if validation fails
            }

            $('#uni_modal button').attr('disabled', true);
            $('#uni_modal button[type="submit"]').text('submitting form...');
            $.ajax({
                url:'./Actions.php?a=save_user',
                method:'POST',
                data:$(this).serialize(),
                dataType:'JSON',
                error:function(xhr, status, error){
                    console.log(xhr.responseText); // Log the full error response from the server
                    _el.addClass('alert alert-danger');
                    _el.text("An error occurred. Please check the console for details."); // Display a generic error message
                    _this.prepend(_el);
                    _el.show('slow');
                    $('#uni_modal button').attr('disabled', false);
                    $('#uni_modal button[type="submit"]').text('Register'); // Change text back to "Register"
                },
                success:function(resp){
                    _el.addClass('alert'); // Add class for styling
                    if(resp.status == 'success'){
                        _el.addClass('alert-success');
                        var message = resp.msg + ". We will get you to the login page.";
                        _el.text(message);
                        _el.hide().prependTo(_this).show('slow');
                        $('#uni_modal button').attr('disabled', false);
                        $('#uni_modal button[type="submit"]').text('Register'); // Change text back to "Register"
                        setTimeout(function(){
                            window.location.href = "login.php"; // Redirect to the login page after a short delay
                        }, 3000); // 3000 milliseconds (3 seconds) delay before redirecting
                    }else{
                        _el.addClass('alert-danger');
                        _el.text(resp.msg);
                        _el.hide().prependTo(_this).show('slow');
                        $('#uni_modal button').attr('disabled', false);
                        $('#uni_modal button[type="submit"]').text('Register'); // Change text back to "Register"
                    }
                }
            });
        });
    });
</script>
