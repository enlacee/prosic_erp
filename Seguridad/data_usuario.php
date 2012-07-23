<?php

include("../class/Class.Usuario.Prosic.php");
include("../function/paginacion.php");

$obj = new Usuario_Prosic();

$result = $obj->cargar_data_usuarios($where, $sort, $limit);

$total = $obj->TotalRegistrosTabla("id_usuario", "prosic_usuario $where");

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/x-json");
$json = "";
$json .= "{\n";
$json .= "page: $page,\n";
$json .= "total: $total,\n";
$json .= "rows: [";
$rc = false;
while ($row = mysql_fetch_array($result)) {
    $id = $row['id_usuario'];
    if ($rc)
        $json .= ",";
    $json .= "\n{";
    $json .= "id:'" . $row['id_usuario'] . "',";
    $json .= "cell:['" . $row['id_usuario'] . "'";
    $json .= ",'" . addslashes($row['codigo_usuario']) . "'";
    $json .= ",'" . addslashes($row['nombre_usuario']) . "'";
    $json .= ",'" . addslashes($row['status_usuario']) . "'";
    $json .= ",'" . addslashes($row['nombre_empresa']) . "'";
    $json .= ",'" . addslashes($row['nombre_tipo_usuario']) . "'";
    $json .= ",'" . addslashes($row['email_usuario']) . "'";
    $json .= ",'<a href=\'javascript:cargar_pagina(\"Seguridad/form_usuario.php?iu=$id\",\"#CapaContenedorFormulario\")\'><img src=\"images/edit.gif\" /></a>'";
    $json .= ",'<a href=\'javascript:cargar_pagina(\"Seguridad/SeguridadBloquear.php?iu=$id\",\"#CapaContenedorFormulario\")\'><img src=\"images/cancelar.gif\" /></a>']";
    $json .= "}";
    $rc = true;
}
$json .= "]\n";
$json .= "}";
echo $json;
$obj->mysql_desconectar();
?>