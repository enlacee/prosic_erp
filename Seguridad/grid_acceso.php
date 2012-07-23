<script>
    $(function() {
        $( "#tabsusuario" ).tabs();
    });

    $(".clase_realizar_operacion a").click(function(event){
        event.preventDefault();
        if(confirm("Confirma Realizar Operacion")){
            $("#CapaContenedorFormulario4").load($(this).attr('href'));
        }else{
            return false;
        }
    })

</script>
<?php include("../class/Class.Perfiles.Prosic.php"); ?>
<?php
$obj = new Perfiles_Prosic();
$result = $obj->cargar_acceso_modulo($_GET['id']);
$data = $obj->cargar_tipo_usuario_id($_GET['id']);
?>
<div class="demo" align="left">
    <div id="tabsusuario">
        <ul>
            <li><a href="#tabs-1">Accesos del Sistema</a></li>
        </ul>
        <br>
        <div id="tabs-1">
            <table class="tabla_gris" width="50%">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Tipo de Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $data['codigo_tipo_usuario'] ?></td>
                        <td><?php echo $data['nombre_tipo_usuario'] ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="div_opciones">
                <?php echo $obj->button_cancelar("Seguridad/grid_perfiles.php", "#CapaContenedorFormulario4") ?>
            </div>
            <div class="seperador"></div>
            <br>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabla_gris" id="tabla_grilla_pedido">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Privilegio</th>
                        <th scope="col">Acceso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysql_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['id_modulo'] ?></td>
                            <td><?php echo $row['codigo_modulo'] ?></td>
                            <td><?php echo $row['nombre_modulo'] ?></td>
                            <td><?php echo $row['privilegio_modulo'] ?></td>
                            <td class="clase_realizar_operacion">
                                <a href="Seguridad/bloquear_acceso.php?opcion=b&md=<?php echo $row['id_modulo'] ?>&tu=<?php echo $row['id_tipo_usuario'] ?>">
                                    <img src="images/bloquear.png" /> Denegado
                                </a>
                                <a href="Seguridad/bloquear_acceso.php?opcion=d&md=<?php echo $row['id_modulo'] ?>&tu=<?php echo $row['id_tipo_usuario'] ?>">
                                    <img src="images/desbloquear.png" /> Permitir
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>