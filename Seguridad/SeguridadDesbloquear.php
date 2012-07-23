<script>alert('Usuario Desbloqueado')</script>
<?php 
include_once("../class/Class.Usuario.Prosic.php");
$objUsuario = new Usuario_Prosic();
$objUsuario->DesbloquearUsuario($_POST['idusuario']);
?>
<script>cargar_pagina("SeguridadUsuarioTabla.php","#CapaContenedorFormulario");</script>