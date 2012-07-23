<?php include("../class/Class.Perfiles.Prosic.php"); ?>
<?php
$obj = new Perfiles_Prosic();
$opcion             =       $_GET['opcion'];
$id_tipo_usuario    =       $_GET['tu'];
$id_modulo          =       $_GET['md'];

if($opcion=='b'){
    $obj->actualizar_acceso_modulo($id_tipo_usuario, $id_modulo, "N");
}elseif($opcion=='d'){
    $obj->actualizar_acceso_modulo($id_tipo_usuario, $id_modulo, "S");
}
$pagina =   "Seguridad/grid_acceso.php?id=".$id_tipo_usuario;
?>
<script>cargar_pagina("<?php echo $pagina;?>","#CapaContenedorFormulario4");</script>