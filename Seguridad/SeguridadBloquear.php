<script>alert('Usuario Bloqueado')</script>
<?php 
include_once("../class/Class.Usuario.Prosic.php");
$objUsuario = new Usuario_Prosic();
$objUsuario->BloquearUsuario($_GET['iu']);
?>
<script>cargar_pagina("SeguridadUsuarioTabla.php","#CapaContenedorFormulario");</script>