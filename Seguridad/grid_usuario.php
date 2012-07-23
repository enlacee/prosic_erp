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
<?php include("../class/Class.Usuario.Prosic.php"); ?>
<?php
$obj = new Usuario_Prosic();
$result = $obj->cargar_data_usuarios();
?>
<div class="demo" align="left">
    <div id="tabsusuario">
        <ul>
            <li><a href="#tabs-1">Usuarios del Sistema</a></li>
        </ul>
        <br>
        <div id="tabs-1">
            <div class="div_opciones">
                <?php echo $obj->button_nuevo("Seguridad/form_usuario.php", "#CapaContenedorFormulario4") ?>
            </div>
                <div class="seperador"></div>
                <br>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabla_gris" id="tabla_grilla_pedido">
                    <thead>
                        <tr>
                            <th scope="col">#</th>                            
                            <th scope="col">Nombres</th>
                            <th scope="col">Status</th>                            
                            <th scope="col">Tipo de Usuario</th>
                            <th scope="col">Email</th>                          
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysql_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $row['id_usuario'] ?></td>                                
                                <td><?php echo $row['nombre_usuario'] ?></td>
                                <td><?php echo $row['status_usuario'] ?></td>                                
                                <td><?php echo $row['nombre_tipo_usuario'] ?></td>                                
                                <td><?php echo $row['email_usuario'] ?></td>
                                <td class="clase_realizar_operacion">
                                    <a href="Seguridad/form_usuario.php?iu=<?php echo $row['id_usuario'] ?>" ><img src="images/edit.png" />Editar</a>
                                </td>
                                <td class="clase_realizar_operacion">
                                    <a href="Seguridad/eliminar_usuario.php?iu=<?php echo $row['id_usuario'] ?>" ><img src="images/cancelar.png" />Eliminar</a>
                                </td>
                                <td class="clase_realizar_operacion">
                                    <a href="Seguridad/bloquear_usuario.php?iu=<?php echo $row['id_usuario'] ?>"><img src="images/bloquear.png" />Bloquear</a>
                                </td>
                                <td class="clase_realizar_operacion">
                                    <a href="Seguridad/desbloquear_usuario.php?iu=<?php echo $row['id_usuario'] ?>"><img src="images/desbloquear.png" />Desbloquear</a>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>                    
                </table>      
        </div>
    </div>
</div>