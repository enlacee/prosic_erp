<?php
include_once("../class/Class.Usuario.Prosic.php");

$objUsuario = new Usuario_Prosic();

$opcion = $_POST['opcion'];

$fields = $objUsuario->cargar_nombre_campo("prosic_usuario", $_POST);

$values = $objUsuario->cargar_valor_post("prosic_usuario", $_POST);

if ($opcion == "add") {

	$objUsuario->AgregarUsuario($fields, $values);
	$id_usuario	=	$objUsuario->get_ultimo_id("prosic_usuario", "id_usuario");

        
} else {
	$id = "id_usuario";

	$valor = $_POST['id_usuario'];

	$objUsuario->ModificarUsuario($fields, $values, $id, $valor);
}
?>
<script>cargar_pagina("Seguridad/grid_usuario.php","#CapaContenedorFormulario4");</script>