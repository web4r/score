<?php session_start() ?>
<?php 

    $_SESSION['id_user'] = null;
    $_SESSION['username'] = null;
    $_SESSION['id_jabatan'] = null;

    header("Location: index.php");

?>