<?php 
include_once("../class/Class.Usuario.Prosic.php");
?>
 <form id="FrmUsuario" name="FrmUsuario" action="SeguridadDesbloquear.php" method="post">
        <label>Empresa</label>
        <select id="idusuario" name="idusuario" class="short" >
        <option value="0">Seleccione</option>
            <?php
			$objUsuario = new Usuario_Prosic();
			$objUsuario->CargarUsuarioBloqueados();
			$objUsuario->mysql_desconectar();
			?>   	                            
        </select>
    
    <p><input id="btnguardar" name="btnguardar" type="submit" class="submit-go" value="Submit" /></p>
</form>
<script>
    $(document).ready(function() {
        var options = {
            target:        '#CapaContenedorFormulario', // elemento destino que se actualizará
            beforeSubmit:  showRequest,  //  respuesta antes de llamarpre-submit callback
            success:       showResponse  //  respuesta después de llamar
        };
        $('#FrmUsuario').ajaxForm(options);
    });

    function showRequest(formData, jqForm) {
    }
    function showResponse(responseText, statusText)  {
    }
</script>