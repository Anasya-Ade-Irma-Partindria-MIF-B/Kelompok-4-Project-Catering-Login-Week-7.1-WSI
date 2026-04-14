<?php
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $q = mysqli_query($conn, 
        "SELECT * FROM users WHERE username='$username' AND password='$password'"
    );

    if(mysqli_num_rows($q) > 0){

        $data = mysqli_fetch_assoc($q);

        // SIMPAN SESSION
        $_SESSION['user'] = $data;

        // REDIRECT BERDASARKAN ROLE
        if($data['role_id'] == 1){
            header("Location: admin/dashboard.php");
        } else if($data['role_id'] == 2){
            header("Location: user/index.php");
        }

        exit;

    } else {
        // BALIK KE LOGIN + ERROR
        header("Location: login.php?error=1");
        exit;
    }
}
?>