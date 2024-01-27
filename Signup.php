<?php
require('connection.php');
require('function.php');
$msg='';
if(isset($_POST['submit'])){
  $Username =get_safe_value($con,$_POST['username']);
  $Password =get_safe_value($con,$_POST['password']);
  $email = get_safe_value($con,$_POST['Email']);
  $sql="INSERT INTO admin_user (Username, email, Password) VALUES ('$Username','$email', '$Password')";
  $res = mysqli_query($con,$sql);
  if($res){
     header('location:login.php');
  }
  else{
    $msg="Plese Enter Valid Details";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
          <a class="nav-link" href="/CRUD/login.php">Already have an account?</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    <!-- form----- -->
    <div class="container-md position-absolute top-50 start-50 translate-middle bg-secondary border border-dange0 " style="width: 550px">
        <form method="post">
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">User Name</label>
            <input type="text" name="username"class="form-control" id="exampleInputName1" aria-describedby="emailHelp" required>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="Email"required>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password"required>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div>
          <button type="submit" class="btn btn-primary"name="submit">Submit</button>
        </form>
        </div>
      </div>
        <div class="alert alert-danger">
          <?php
          echo "$msg";
          ?>
</body>
</html>