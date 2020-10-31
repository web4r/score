<?php include 'db.php'; ?>

<?php session_start() ?>
<?php 

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($conn,$username);
    $password = mysqli_real_escape_string($conn,$password);

    $query = "SELECT * FROM user WHERE username = '$username' ";
    $select_user_query = mysqli_query($conn,$query);
    if(!$select_user_query){
        die("QUERY FAILED " . mysqli_error($conn));
    }

    while($row = mysqli_fetch_array($select_user_query)){
         $db_user_id = $row['id_user'];
         $db_username = $row['username'];
         $db_user_password = $row['password'];
         $db_user_jabatan = $row['id_jabatan'];


    }
   

    if($password == $db_user_password){
        
        $_SESSION['id_user'] = $db_user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['id_jabatan'] = $db_user_jabatan;
      
        
        header("Location: data.php");
    }else {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="col-md-6">
        <form method="post">
        <div class="form-group">
            <label for="">Username</label>
            <input type="text" class="form-control" name="username">
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary btn-block" name="login" value="Login">
        </div>
        </form>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    
</body>
</html>