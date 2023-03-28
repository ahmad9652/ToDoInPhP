
        <nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">SMA-ToDo</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                    </li> -->
                </ul>
                <form class="d-flex m-0" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <?php 
                if (!$login) {   
                    echo '<ul class="navbar-nav mx-1 mb-2 mb-lg-0">
                    <li class="nav-item mx-1">
                    <a href="login.php" class="btn btn-outline-success">Login</a>
                    </li>
                    <li class="nav-item mx-1">
                    <a href="signup.php" class="btn btn-outline-danger">Sign Up</a>
                    </li>    
                    </ul>';
                }
                else {
                    echo '<ul class="navbar-nav ml-auto ">
                    <li class="nav-item dropdown-center dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      '.$logged_username.'
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item " href="logout.php">Logout</a></li>
                    </ul>
                  </li></ul>';
                }
                ?>
                </div>
            </div>
        </nav>
        <?php
        if ($insert_bool) {
            echo '<div class="alert alert-'.$message_status.' alert-dismissible fade show" role="alert">
            <strong>'.$message_status.'!</strong> '.$message.'.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        // else{
        //     echo '<div class="alert alert-error alert-dismissible fade show" role="alert">
        //     <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        //   </div>';
        // }
        ?>
