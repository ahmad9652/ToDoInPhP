<?php 
    require "./components/_connectdb.php";
    $login = false;
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        // $find_user_sql = "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password';";
        $find_user_sql = "SELECT * FROM `users` WHERE `username` = '$username';";
        $result = mysqli_query($con,$find_user_sql);
        $num = mysqli_num_rows($result);
        if($num==1){
            while ($row_pass = mysqli_fetch_assoc($result)) {
              if (password_verify($password,$row_pass['password'])) {
                $login = true;
                session_start();
                $_SESSION["logedin"] = true;
                $_SESSION["username"] = $username;
                echo $_SESSION["username"];
                header("Location: index.php");
              }
              else{
                $insert_bool = true;
                $message_status = "danger";
                $message = "Invalid Credentials";
              }
              break;
            }
        }
        else{
          $insert_bool = true;
          $message_status = "danger";
          $message = "Invalid Credentials";
        }
        
    }
    
?>

<?php require "./components/_base_top_html.php"?>
<?php require "./components/_navbar.php"?>
<div class="container mt-3">
    <h1 class="">Login Here</h1>
    <form action="login.php" method="post">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">UserName</label>
          <input type="text" class="form-control" id="exampleInputEmail1" name="username" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php require "./components/_base_bottom_html.php"?>
