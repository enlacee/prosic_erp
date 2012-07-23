<?php
session_start();
include_once("../../BL/BLGlobal.php");

if(isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])){
	$id_empl = $_SESSION["id_usuario"];
	$id_perfil = $_SESSION["id_perfil"];
	$nombre_usuario = getCampo("empleado","concat(nombres,', ',apell_pat,' ',apell_mat)","id_empl",$id_empl);
	$nombre_perfil = getCampo("perfil","nombre","id_perfil",$id_perfil);
}

?>
<div class="header_logeop2">
	<a class="header_menu_logout" href="javascript: cerrar_session();">Cerrar Sesi&oacute;n</a>
	<br/>
	<a class="header_menu_ayuda" href="#">
	<img src="images/usos/iconayuda.png" width="14" height="14" border="0" alt="" title="" />
	Ayuda	</a><br />
  <br />
	
</div>
<div class="header_linea_1"></div>
<div class="header_logeop1">
	<label class="session" align="left">

		Bienvenido a Intranet 		
		<br/>
		<span class="sessionnom">
		<?=$nombre_usuario;?>(<?=$nombre_perfil;?>)
		</span>
				
	</label>
	<br /><br />
</div>
