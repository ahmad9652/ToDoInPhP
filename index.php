<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "smatodo";
    $insert_bool = false;
    $con = mysqli_connect($server,$username,$password,$db);
    if (!$con) {
        die("Connection to this db is failed due to ".mysqli_connect_error());
    }
    else{
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            // echo $sno;
            $delete_sql = "DELETE FROM `smatodo` WHERE `smatodo`.`id` ='$id';";
            $result = mysqli_query($con,$delete_sql);
            if ($result) {
                $insert_bool = true;
                $message_status = "success";
                $message = "Your ToDo Deleted SuccessFully";
            }
            else{
                $insert_bool=false;
                $message_status = "error";
                $message="Something Went Wrong";
            }
            // header("Location: http://localhost/smatodo/index.php");
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["snoEdit"])) {
                $sno = $_POST["snoEdit"];
                $title = $_POST['titleEdit'];
                $description = $_POST['descriptionEdit'];
                $update_sql = "UPDATE `smatodo` SET `title` = '$title', `description` = '$description' WHERE `smatodo`.`id` = '$sno';";
                $result = mysqli_query($con,$update_sql);
                if ($result) {
                    $insert_bool = true;
                    $message_status = "success";
                    $message = "Your ToDo Updated SuccessFully";
                }
                else{
                    $insert_bool=false;
                    $message_status = "error";
                    $message="Something Went Wrong";
                }
            }
            else {
                
                $title = $_POST['title'];
                $description = $_POST['description'];
                $insert_sql = "INSERT INTO `smatodo` (`id`, `title`, `description`) VALUES (NULL, '$title', '$description');";
                $result = mysqli_query($con,$insert_sql);
                if ($result) {
                    $insert_bool = true;
                    $message_status = "success";
                    $message = "Your ToDo Saved SuccessFully";
                }
                else{
                    $insert_bool=false;
                    $message_status = "error";
                    $message="Something Went Wrong";
                }
            }
        }
            
            $show_sql = "SELECT * FROM `smatodo`";
        $data = mysqli_query($con,$show_sql);
        $count = mysqli_num_rows($data); 
    }


    $con->close();
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SMA-ToDo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/4e605f925c.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <header>
        <nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">SMA-ToDo</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                    </li> -->
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
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
    </header>
    <main>
        <div class="container mt-3">
            <h2 class="mb-4">Add Your ToDo Here</h2>
            <form action="index.php" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Title</label>
                    <input type="text" class="form-control" name ="title" id="exampleFormControlInput1" placeholder="Coding">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <button class="btn btn-outline-success">Save</button>
            </form>

            <h4 class="mt-4 mb-3">Your ToDo List:</h4>

            <table class="table table-stripped mb-4" >
                <thead class="text-success fs-5">
                    <tr>
                        <th scope="col" class="col-md-1">S.No</th>
                        <th scope="col" class="col-md-3">Title</th>
                        <th scope="col" class="col-md-6">Description</th>
                        <th scope="col" class="col-md-2 text-center">Edit / Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($count>0) {
                            $i = 1;
                            while ($rows = mysqli_fetch_assoc($data)) {
                                $id = $rows["id"];
                                echo "<tr>
                                    <td>".$i++."</td>
                                    <td>".$rows["title"]."</td>
                                    <td>".$rows["description"]."</td>
                                    <td class='text-center'>
                                        <i class='edit fa-solid fa-pen-to-square fa-xl mx-1' id='.$id.'></i> /
                                        <i class='fa-solid fa-trash fa-xl mx-1 delete' id='d.$id.'></i>
                                    </td>
                                </tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="editModal" name="editModal"tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="index.php" method="post">
                    <div class="modal-body">
                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="mb-3">
                                <label for="titleEdit" class="form-label">Title</label>
                                <input type="text" class="form-control" name ="titleEdit" id="titleEdit" placeholder="Coding">
                            </div>
                            <div class="mb-3">
                                <label for="descriptionEdit" class="form-label">Description</label>
                                <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" rows="3"></textarea>
                            </div>
                    </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="container mt-5">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <div class="col-md-4 d-flex align-items-center">
                
                <span class="mb-3 mb-md-0 text-muted fs-4">© 2023 SMA-ToDo, Inc</span>
                </div>

                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                    <i class="ms-3 fa-brands fa-github fa-xl"></i>
                    <i class="ms-3 fa-brands fa-linkedin-in fa-xl"></i>
                    <i class="ms-3 fa-brands fa-medium fa-xl"></i>
                </ul>
            </footer>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element)=>{
            element.addEventListener("click",(e)=>{
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName('td')[1].innerText;
                description = tr.getElementsByTagName('td')[2].innerText;
                console.log(title,description);
                // titleEdit = document.getElementById("titleEdit");
                // descriptionEdit = document.getElementById("descriptionEdit");
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id;
                console.log(snoEdit);
                $('#editModal').modal("toggle");
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element)=>{
            element.addEventListener("click",(e)=>{
                sno = e.target.id;
                sno = sno.substr(2,sno.length-3);
                console.log(sno);
                if(confirm("Are you sure you want to delete your ToDo")){
                    window.location = `index.php?delete=${sno}`;

                }
            })
        })
    </script>
  </body>
</html>