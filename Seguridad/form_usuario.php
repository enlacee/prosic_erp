<script>
    $(function(){
        $("#FrmUsuario").validate({
            submitHandler: function(form) {
                if(confirm("¿Esta seguro en Guardar los datos?")){
                    $("#btnguardar").attr('disabled', 'disabled');
                    alert("Datos enviados Correctamente");
                    $(form).ajaxSubmit({
                        target: "#CapaContenedorFormulario4"
                    });

                }else
                {
                    return false;
                }

            }
        });
        $( "#tabsusuario" ).tabs();        
    });
</script>
<div class="demo" align="left">
    <div id="tabsusuario">
        <ul>
            <li><a href="#tabs-1">REGISTRO DE USUARIOS</a></li>
        </ul>
        <br>
        <div id="tabs-1">             
            <br />
            <?php include_once("../class/Class.Usuario.Prosic.php"); ?>
            <?php $objUsuario = new Usuario_Prosic(); ?>
            <?php $row = @$objUsuario->consulta_usuario_por_id($_GET['iu']); ?>
            <?php echo $objUsuario->iniciar_form("FrmUsuario", "Seguridad/save_usuario.php"); ?>
            <?php echo $objUsuario->submit(); ?>            
            <?php echo $objUsuario->button_cancelar("Seguridad/grid_usuario.php", "#CapaContenedorFormulario4"); ?>
            <div class="seperador"></div>
            <br>
            <?php echo $objUsuario->iniciar_fieldset("Registro de Usuarios"); ?>            
            <?php if (isset($_GET['iu'])) { ?>
                <div>
                <?php echo $objUsuario->textfield_id("ID Usuario", "id_usuario", $row['id_usuario']); ?>
                </div>
                <?php echo $objUsuario->hidden("opcion", "update"); ?>
                <?php echo $objUsuario->hidden("status_usuario", $row['status_usuario']); ?>
            <?php
            } else {
                echo $objUsuario->hidden("opcion", "add");
                echo $objUsuario->hidden("status_usuario", "B");
            }
            ?>
            <div class="seperador"></div>
            <br>
            <div><?php echo $objUsuario->textfield("Codigo", "codigo_usuario", $row['codigo_usuario'], ' class = "required" '); ?></div>
            <div class="seperador"></div>
            <br>
            <div><?php echo $objUsuario->textfield("Nombre", "nombre_usuario", $row['nombre_usuario'], ' class = "required" size="50"');?></div>
            <div class="seperador"></div>
            <br>
            <div><?php echo $objUsuario->textfield("Email", "email_usuario", $row['email_usuario'], ' class = "required email" size="50" '); ?></div>
            <div class="seperador"></div>
            <br>
            <div><?php echo $objUsuario->selected("prosic_tipo_usuario", "id_tipo_usuario", "Tipo Usuario", $row['id_tipo_usuario'],''," where status_tipo_usuario<>'E' "); ?></div>
            <div class="seperador"></div>
            <br>
            <div><?php echo $objUsuario->selected("prosic_empresa", "id_empresa", "Empresa", $row['id_empresa']); ?></div>
            <div class="seperador"></div>
            <br>            
            <?php echo $objUsuario->cerrar_fieldset(); ?>
            <?php echo $objUsuario->cerrar_form(); ?>
<?php $objUsuario->mysql_desconectar(); ?>
        </div>
    </div>
</div>