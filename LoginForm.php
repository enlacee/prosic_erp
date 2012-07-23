<!-- top lines for style -->
<div id="top_green"></div>
<div id="top_dark"></div>

<div id="wrapper">

    <div id="content">

        <div id="LoginCenter">

            <!-- begin all content here -->
            <h1 class="dashboard">Sistema Prosic ERP</h1>

            <p>Bienvenido al Sistema</p>

            <div class="div_header">Iniciar Sesion</div>
            <div class="div_content" id="divcontent">

                <form id="FrmLogin" name="FrmLogin" action="LoginValidar.php" method="post">
                    <fieldset class="login">
                        <legend>Ingrese su Usuario</legend>
                        <div>
                            <label>Usuario</label>
                            <input type="text" name="email_usuario" id="email_usuario" class="input_myform short" />
                        </div>
                        <div>
                            <label>Password</label>
                            <input type="password"  name="password_usuario" id="password_usuario" class="input_myform short" />
                        </div>
                        <div>
                            <?php
                            include_once 'class/Class.Mysql.Prosic.php';
                            $obj = new Mysql_Prosic();
                            $tabla = "prosic_empresa";
                            $id = "id_empresa";
                            $etiqueta = "Empresa";
                            echo $obj->selected($tabla, $id, $etiqueta, "")
                            ?>
                        </div>
                    </fieldset>
                    <br>
                    <input id="btnguardar" name="btnguardar" type="submit" class="submit-go"" value="Ingresar al Sistema" />

                </form>

            </div>
            <div class="div_bottom"></div>


        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var options = {
            target:        '#contenidogeneral', // elemento destino que se actualizará
            beforeSubmit:  showRequest,  //  respuesta antes de llamarpre-submit callback
            success:       showResponse  //  respuesta después de llamar
        };
        $('#FrmLogin').ajaxForm(options);
    });

    $("#btnguardar").click(function(){
        $.blockUI({ css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            },message: '<h1>Validando Usuario y Cargando Librerias</h1>'});
        setTimeout($.unblockUI, 4000);
    });


    function showRequest(formData, jqForm) {
    }
    function showResponse(responseText, statusText)  {
    }
</script>