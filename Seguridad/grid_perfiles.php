<script>
    $(function() {
        $( "#tabsusuario" ).tabs();
    });

    $(".clase_realizar_operacion a").click(function(event){
        event.preventDefault();
        $("#CapaContenedorFormulario4").load($(this).attr('href'));

    })

</script>
<?php include("../class/Class.Perfiles.Prosic.php"); ?>
<?php
$obj = new Perfiles_Prosic();
$result = $obj->cargar_tipo_usuario();
?>
<div class="demo" align="left">
    <div id="tabsusuario">
        <ul>
            <li><a href="#tabs-1">Perfiles de Usuario</a></li>           
        </ul>
        <br>
        <div id="tabs-1">
            <div class="seperador"></div>
            <br>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabla_gris" id="tabla_grilla_pedido">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Tipo Usuario</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysql_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['id_tipo_usuario'] ?></td>
                            <td><?php echo $row['codigo_tipo_usuario'] ?></td>
                            <td><?php echo $row['nombre_tipo_usuario'] ?></td>
                            <td class="clase_realizar_operacion"><a href="Seguridad/grid_acceso.php?id=<?php echo $row['id_tipo_usuario'] ?>">
                                    <img src="images/options-edit.gif" />
                                </a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>