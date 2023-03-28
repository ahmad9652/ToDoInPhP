<?php
    require "./components/_connectdb.php";
    $login = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST['email'];
        $confirmpassword = $_POST["confirmpassword"];
        $exist = false;
        $exist_sql = "SELECT * FROM `users` WHERE `username` = '$username';";
        $exist_rows =mysqli_num_rows(mysqli_query($con,$exist_sql));
        if ($exist_rows >=1) {
            $exist = true;
            $insert_bool = true;
            $message_status = "danger";
            $message = "try different username";
        } 
        else if (($password == $confirmpassword) && $exist==false) {
            $hash = password_hash($password , PASSWORD_DEFAULT);
            $insert_user_sql = "INSERT INTO `users` (`sno`, `firstname`, `lastname`, `username`, `email`, `password`) VALUES (NULL, '$firstname', '$lastname', '$username', '$email', '$hash');";  
            $result = mysqli_query($con,$insert_user_sql);
            if ($result) {
                $insert_bool = true;
                $message_status = "success";
                $message = "You are Successfully added";
            }
            else{
                $insert_bool = true;
                $message_status = "error";
                $message = "we are unable to signup with you ";

            }
        }
        else{
            $insert_bool = true;
            $message_status = "danger";
            $message = "Password and Confirm  password should be same";
        }
        
        
    }
?>
<?php 
    require "./components/_base_top_html.php";
    require "./components/_navbar.php";
?>
<div class="container mt-3">
    <h1 class="mb-3">SignUp Here</h1>
    <form class="row g-3" action="signup.php" method="post">
    <div class="col-md-4">
        <label for="validationDefault01" class="form-label">First name</label>
        <input type="text" class="form-control" maxlength="50" id="validationDefault01" name="firstname" placeholder="Mohd" required>
    </div>
    <div class="col-md-4">
        <label for="validationDefault02" class="form-label">Last name</label>
        <input type="text" class="form-control"  maxlength="50" id="validationDefault02" placeholder="Ahmad" name="lastname" required>
    </div>
    <div class="col-md-4">
        <label for="validationDefaultUsername" class="form-label">Username</label>
        <div class="input-group">
        <span class="input-group-text" id="inputGroupPrepend2">@</span>
        <input type="text" class="form-control" maxlength="50" id="validationDefaultUsername" placeholder="mohdahmad" name="username" aria-describedby="inputGroupPrepend2" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" maxlength="100" id="exampleInputEmail1" name="email" placeholder="mohdahmad@gmail.com" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3 col-md-6">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" maxlength="250" name="password" id="exampleInputPassword1">
    </div>
    <div class="mb-3 col-md-6">
        <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" maxlength="250" name="confirmpassword" id="exampleInputPassword2">
    </div>
    <div class="col-12">
        <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
        <label class="form-check-label" for="invalidCheck2">
            Agree to terms and conditions
        </label>
        </div>
    </div>
    <div class="col-12">
        <button class="btn btn-outline-success" type="submit">SignUp</button>
    </div>
    </form>
</div>



<?php require "./components/_base_bottom_html.php"?>