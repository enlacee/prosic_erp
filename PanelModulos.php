<?php session_start(); ?>
<!-- begin all content here -->
<br />

<div class="div_header_center2">SISTEMA PROSIC - MODULOS</div>
<div class="div_content_center"><?php
include_once("class/Class.Privilegio.Prosic.php");
include_once("function/function.php");

$objPrivilegio = new Privilegio_Prosic();

$res = $objPrivilegio->CargarPrivilegiosUsuario($_SESSION['gIdUsuario']);

$i = 0;

while ($row = mysql_fetch_assoc($res)) {

	$array_modulo[$i] 		= 	$row['id_modulo'];

	$array_privilegio[$i] 	= 	$row['privilegio_modulo'];

	$i++;
}

$resModulo 	= 	$objPrivilegio->CargarModulos();

$j = 0;

while ($row = mysql_fetch_assoc($resModulo)) {

	$array_id_modulo[$j]      = 	$row['id_modulo'];

	$array_nombre_modulo[$j]  = 	$row['nombre_modulo'];

	$array_imagen_modulo[$j]  = 	$row['imagen_modulo'];

	$array_link_modulo[$j]    = 	$row['link_modulo'];

	$j++;
}
?> <?php

$contador = 0;
echo '<table align="center" cellspacing="2" width="634">';

for ($i = 0; $i < 3; $i++) {
	echo "<tr class='tr_mytable'>";
	for ($j = 0; $j < 4; $j++) {

		$var_privilegio = BuscarIdModulo($array_modulo, $array_privilegio, $array_id_modulo[$contador]);

		if ($var_privilegio == "NO" || $var_privilegio == "")
		{
			$imagen = "bloqueado.png";
			$inicio = "";
			$fin = "";
		}
		else
		{
			$imagen = $array_imagen_modulo[$contador];
			$inicio = "<a href='javascript:cargar_pagina(\"".$array_link_modulo[$contador];
			$inicio.= "\",\"#ContenidoCenter\")'>";
			$fin = '</a>';
		}

		echo '<td width="200" align="center" class="td_mytable">
						     ' . $inicio . '<img src="images/' . $imagen . '" width="48" height="48" />' . $fin . '
                         	    <p>' . $array_nombre_modulo[$contador] . '</td>';

		$contador++;
	}
	echo "<tr>";
}
echo "</table>";
?></div>
<br class="clear" />
<script type="text/javascript">
$("a").click(function(){
    $.blockUI({ css: { 
           border: 'none', 
           padding: '15px', 
           backgroundColor: '#000', 
           '-webkit-border-radius': '10px', 
           '-moz-border-radius': '10px', 
           opacity: .5, 
           color: '#fff' 
       } }); 	 
       setTimeout($.unblockUI, 1000);	    
});
</script>