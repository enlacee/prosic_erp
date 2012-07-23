<?php
include("../class/Class.Usuario.Prosic.php");
$obj    =   new Usuario_Prosic();
$email_usuario      =   $_POST['email_usuario'];
$password_usuario   =   $_POST['password_usuario'];
$obj->actualizar_password($email_usuario, md5($password_usuario));
header("Location: login.php");
?>