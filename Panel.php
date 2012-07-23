<!-- top lines for style -->
<div id="top_green"></div>
<div id="top_dark"></div>

<div id="wrapper">

    <!-- edit navigation items here -->
    <div id="nav">
        <ul>
            <li ><a href="#">Usuario</a></li>
            <li class="current"><a href="javascript:cargar_pagina('PanelModulos.php','#ContenidoCenter')">Modulos</a></li>            
      </ul>


        <div id="user_links">
                Empresa:  <?php echo $_SESSION['gNombreEmpresa']; ?>&nbsp; &nbsp;| &nbsp;
 				Usuario: <a href="#"><?php echo $_SESSION['gNombreUsuario']; ?></a>&nbsp; &nbsp;| &nbsp;
            	<a href="LoginClose.php">(Cerrar Session)</a>
        </div>
    </div>

    <div id="content">
        <div id="ContenidoCenter" align="center">            
		<?php include_once("PanelModulos.php"); ?>
        </div>
        </div></div>