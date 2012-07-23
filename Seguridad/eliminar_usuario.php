<?php
include_once("../class/Class.Usuario.Prosic.php");
$objUsuario = new Usuario_Prosic();
$id_usuario =   $_GET['iu'];
$objUsuario->eliminar_usuario($id_usuario);
?>
<script>cargar_pagina("Seguridad/grid_usuario.php","#CapaContenedorFormulario4");</script>