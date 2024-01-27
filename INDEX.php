<?php
session_start();
require('connection.php');
require('function.php');
if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){
  $name = $_SESSION['ADMIN_USERNAME'];
  echo $name;
}
else {
  header('location:login.php');
}

$insert = false;
$update = false;
$delete = false;

if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $sql = "DELETE FROM NOTES WHERE sno = '$sno'";
    $result = mysqli_query($con, $sql);
    if($result){
    $delete = true;
}
  }

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['snoedit'])){
    $sno = $_POST['snoedit'];
    $title = $_POST["titleedit"];
    $desc =  $_POST["descedit"];

    $sql = "UPDATE NOTES SET title = '$title' , description = '$desc' WHERE NOTES .SNO = '$sno'";
    $result =  mysqli_query($con, $sql);
    if($result){
        $update=true;        
    }
    else{
      $err = mysqli_error($con);
      echo "$err";
    }
    }
    
    else{
        $title = $_POST["title"];
        $desc =  $_POST["desc"];
        $email = $_SESSION['EMAIL'];
        $sql = "Insert INTO NOTES(title , description, email ) VALUES ('$title','$desc', '$email')";
        if ($con->query($sql)){
            $insert=true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script type = "text/javascript" >
   function preventBack(){window.history.forward();}
    setTimeout("preventBack()", 0);
    window.onunload=function(){null};
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <title>CURD </title>

</head>
<body>

<!-- Button trigger modal -->
  

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Note </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="/CRUD/INDEX.php" method="post">
    <input type="hidden" name="snoedit" id = "snoedit" >
      <div class=" form-group mt-4 ms-4">
    <label for="titleedit" class="form-group">Note Title</label>
    <input type="text" class="form-control" name ="titleedit" id="titleedit" aria-describedby="emailHelp">
  </div>

  <div class="form-group mt-4 ms-4">
    <label for="descedit">Note Description</label>
    <textarea class="form-control" name="descedit" placeholder="Description" id="descedit"></textarea>
</div>

  <button type="submit" class="btn btn-primary position-left" >Edit Note</button>
 </form>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" method ="get">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">CRUD</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
        <button type="submit" class="logout btn btn-primary">Logout</button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php
        
        if ($insert){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Holy guacamole!</strong> Note Added Successfully!!!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
             }
        if($update){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Holy guacamole!</strong>Updation Done
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        if($delete){
          echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Holy guacamole!</strong>Deletion done
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
      }
?>
<div class="container mt-8" style="width: 700px">
    <h2 class="mt-4 ms-4">Add a Note <?php echo $name; ?></h2>
 <form action="/CRUD/INDEX.php" method="post">
  <div class=" form-group mt-4 ms-4">
    <label for="title" class="form-group">Note Title</label>
    <input type="text" class="form-control" name ="title" id="title" aria-describedby="emailHelp" required>
  </div>

  <div class="form-group mt-4 ms-4">
    <label for="desc">Note Description</label>
    <textarea class="form-control" name="desc" placeholder="Description" id="desc" required></textarea>
</div>

  <button type="submit" class="btn btn-primary mt-5 mx-5">Add Note</button>
 </form>
</div>

<div class ="container my-4" >
 <table class ="table" id="myTable">

    <thead>
        <tr>
            <th scop="col"> Sno</th>
            <th scop="col"> Title</th>
            <th scop="col"> Description</th>
            <th scop="col"> Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $email = $_SESSION['EMAIL'];
    $sql = "SELECT * FROM NOTES where email = '$email' ORDER BY SNO DESC";
    $result = mysqli_query($con, $sql);
    $sno=0;
    while($row = mysqli_fetch_assoc($result)){
        $sno +=1;
        echo "<tr>
        <th scope ='row'>" .$sno. "</th>
        <td>" .$row['title']."</td>
        <td>" .$row['description']. "</td>
        <td> <button class = 'edit btn btn-primary' id=".$row['sno'].">  Edit </button> <button class= 'delete btn btn-danger' id=d".$row['sno']." > Delete </button></th>
        </tr>";
    }

        ?>
    </tbody>
    
 </table>
</div>
<hr>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>
   
 
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) =>{
          element.addEventListener("click",(e)=>{
            console.log("edit " , );
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, description);
            titleedit.value = title; 
            descedit.value = description; 
            snoedit.value = e.target.id;
            console.log(e.target.id);
            // const editModalAlternative = new bootstrap.Modal('#editModal', options)    
            $("#editModal").modal('toggle');
        });
});


      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
      console.log("delete " , );  
      sno = e.target.id.substr(1,);
      console.log(sno );

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `/crud/index.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })

    logout = document.getElementsByClassName('logout');
    Array.from(logout).forEach((element) => {
      element.addEventListener("click", (e) => {
      console.log("logout" , );    
        if (confirm("Are you sure you want to Log out!")) {
          console.log("yes");
          window.location = `/crud/logout.php`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
    })
  })
    </script>
</script>
</body>
</html>