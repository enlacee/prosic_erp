<?php

$html_btn_close = "off";

if(isset($cfgPermiso["eliminar"]) && !empty($cfgPermiso["eliminar"]) && $cfgPermiso["eliminar"] == "off"){
	//echo "hay eliminar";
	$html_btn_close = "on";
}
if(isset($cfgPermiso["aprobar"]) && !empty($cfgPermiso["aprobar"]) && $cfgPermiso["aprobar"] == "off"){
	//echo "hay aprobar";
	$html_btn_close = "on";
}
if(isset($cfgPermiso["copiar"]) && !empty($cfgPermiso["copiar"]) && $cfgPermiso["copiar"] == "off"){
	//echo "hay aprobar";
	$html_btn_close = "on";
}

?>
<script>
open_permisoAcceso = function(){

	$("#div_back").show();
	
	$("#div_permiso_acceso").animate({"top": "+=20px", "opacity": "toggle"}, 500);
}

close_permisoAcceso = function(){

	$("#div_back").hide();
	$("#div_permiso_acceso").animate({"top": "+=20px", "opacity": "toggle"}, 500);
	$("#div_permiso_acceso").animate({"top": "-=40px"}, 1);
}

</script>
<br clear="all" />
<div id="div_permiso_acceso" align="center" >
	<table width="485" border="0" cellpadding="0"  cellspacing="0" align="center">
<tr>
        	<td align="right" valign="bottom" >
                <div id="barra_cerrar_aplicacion">
                    <img src="../../images/icons/close.png" alt="Cerrar" title="Cerrar" border="0" onclick="close_permisoAcceso();" class="manito" />
                </div>
        	</td>
		   </tr>
    	</table>
  <table align="center" width="450px" cellpadding="1" cellspacing="1" border="0" class="borde_1" bgcolor="white" style="border:#CCCCCC solid 5px; ">

	<tr>
	    <th colspan="2" align="left">
        	<div id="div_title_find_insumo" class="head_find_popup">
        		<img src="../../images/icons/images_configuracion/mini/perfiles.jpg" align="absmiddle" />
				MENSAJE DEL SISTEMA		
				<?
				//echo "<br/>btn_close: ".$html_btn_close;
				?>	
            </div>        </th>
	</tr>
	<tr>
		<td colspan="2">
		
			<table width="100%" align="center" bgcolor="white">
			<tr>
			  <td align="center">
			    <div class="msg_permiso">
			      <table width="138" border="0">
                  <tr>
                    <td width="128"><img src="../../images/icons/denegado.png" alt="Denegado" width="128" height="128" longdesc="Denegado el Ingreso" /></td>
                    </tr>
                  <tr>
                    <td align="center" class="color_rojo">ACCESO DENEGADO </td>
                    </tr>
                </table>
				</div>			  </td>
			</tr>	
			<?
			//if($html_btn_close == "on"){
			?>
<!--			<tr>		
				<td align="right">				
				<input type="button" onclick="close_permisoAcceso();" value="Cerrar" />				</td>
			</tr>-->
			
			<?
			//}
			?>
			</table>		</td>
	</tr>	
	</table>
</div>
