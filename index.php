<?php
        // $db = "smatodo";
        include "./components/_check_user_login.php";
        require "./components/_connectdb.php";
        
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
                $insert_sql = "INSERT INTO `smatodo` (`id`, `title`, `description`, `user`) VALUES (NULL, '$title', '$description', '$logged_username');";
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
            
            $show_sql = "SELECT * FROM `smatodo` WHERE `user` = '$logged_username';";
        $data = mysqli_query($con,$show_sql);
        $count = mysqli_num_rows($data); 


    $con->close();
?>

    <?php require "./components/_base_top_html.php"?>
    <?php require "./components/_navbar.php"?>
    <main>
        <div class="container mt-3">
            <h2 class="mb-4">Add Your ToDo Here</h2>
            <form action="index.php" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Title</label>
                    <input type="text" class="form-control" maxlength="150" name ="title" id="exampleFormControlInput1" placeholder="Coding">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea class="form-control" name="description" maxlength="500" id="exampleFormControlTextarea1" rows="3"></textarea>
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
    <?php require "./components/_base_bottom_html.php"?>