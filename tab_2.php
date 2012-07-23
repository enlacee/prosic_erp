<table width="100%" height="410px" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center" valign="top" width="210px">

            <div class="accordion">
                <div class="titamant">&nbsp;</div>
                <h3 class="text_blanco" style="color:#FFFFFF">Sistema</h3>
                <p>
                    <?php
                    include_once("class/Class.Sistema.Prosic.php");

                    $objTablas = new Sistema_Prosic();

                    $res = $objTablas->cargar_tabla_general();

                    while ($row = mysql_fetch_assoc($res)) {
                    ?>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Sistema/grid_general.php?tbl=<?php echo $row['nombre_tabla_general']; ?>','#CapaContenedorFormulario2')">
                            <?php echo $row['descripcion_tabla_general'] ?></a>
                    </span><br/>

                    <?php } ?>
                </p>
            </div>
        </td>
        <td align="center" valign="top">
            <div id="CapaContenedorFormulario2" style="overflow:scroll; height:410px;"></div>
        </td>
</table>
