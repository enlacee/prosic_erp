<?php
session_start();

//ELIMINANDO LAS VARIABLES DE SESSION
//-----------------------------------------------------------
unset($_SESSION["usuario"],$_SESSION["id_usuario"]);
//-----------------------------------------------------------

session_destroy();

?>