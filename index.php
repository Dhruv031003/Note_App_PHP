<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "CRUD_APP";
$insert = false;
$update = false;
$delete = false;

$conn = mysqli_connect($servername, $username, $password, $database);

if(isset($_GET['delete'])){
    $Sno=$_GET['delete'];
    $delete_query = "DELETE FROM `notes` WHERE `notes`.`s_no` = $Sno";
    $delete_req = mysqli_query($conn, $delete_query);
    $delete = "true";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['Sno'])){
        $Sno=$_POST['Sno'];
        $titleEdit = $_POST['titleEdit'];
        $descriptionEdit = $_POST['descriptionEdit'];
        $update_query = "UPDATE `notes` SET `title` = '$titleEdit', `description` = '$descriptionEdit' WHERE `notes`.`s_no` = '$Sno'";
        $update_req = mysqli_query($conn, $update_query);
        $update = "true";
    }
    else{
        $title = $_POST['title'];
        $description = $_POST['description'];
        $insert_query = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description');";
        $insert_req = mysqli_query($conn, $insert_query);
        $insert = "true";
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Launch demo modal
</button> -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php?update=true" method="POST">
                        <input type="hidden" name="Sno" id="Sno">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Title</label>
                            <input type="text" id="titleEdit" name="titleEdit" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Add note Description</label>
                            <textarea type="text" id="descriptionEdit" name="descriptionEdit" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CRUD App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About US</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <?php
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show m-0" role="alert"><strong>Note added Successfully!!!!</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
    if ($update) {
        echo '<div class="alert alert-success alert-dismissible fade show m-0" role="alert"><strong>Note updated Successfully!!!!</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
    if ($delete) {
        echo '<div class="alert alert-success alert-dismissible fade show m-0" role="alert"><strong>Note deleted Successfully!!!!</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
    ?>
    <main>
        <div class="container w-75 my-5">
            <h1>Add a Note Here</h1>
            <form action="index.php" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Add note Description</label>
                    <textarea type="text" name="description" class="form-control" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <div class="my-4">
                <table class="table my-3" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">S-No.</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "Select * from `notes`";
                        $result = mysqli_query($conn, $query);
                        $sno = 1;
                        while ($rows = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <th scope='row'>" . $sno . "</th>
                                <td>" . $rows['title'] . "</td>
                                <td>" . $rows['description'] . "</td>
                                <td><button type='button' class='edit btn btn-primary m-2' id=".$rows['s_no'].">Edit</button><button type='button' class='delete btn btn-primary m-2' id=d".$rows['s_no'].">Delete</button></td>
                                </tr>";
                            $sno++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText
                description = tr.getElementsByTagName("td")[1].innerText
                console.log(title, description)
                titleEdit.value = title
                descriptionEdit.value = description;
                Sno.value= e.target.id
                console.log(Sno)
                $('#editModal').modal('toggle')
            })
        })
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                Sno=e.target.id.substr(1,);
                if(confirm("Press a Button!")){
                    window.location=`index.php?delete=${Sno}`    
                }
                else{
                    console.log("no")
                }
            })
        })
    </script>
</body>

</html>