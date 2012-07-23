<?php
session_start();
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";
*/
if (!isset($_SESSION['gIdUsuario'])) {
    header("location: acceso/login.php");
} else {
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>.:: Sistema Prosic ::.</title>
  
           
            <style> @import url("css/solapas.css"); </style>
            <style> @import url("css/acordeon.css"); </style>
            <style> @import url("css/head.css"); </style>
            <style> @import url("css/global.css"); </style>
            <style>
                body {
                    background-image: url("images/bk/fondoweb.jpg");
                    background-repeat: repeat-x;
                    background-position: center top;
                    margin-top: 0px;
                    margin-bottom: 0px;
                    margin-left: 0px;
                    margin-right: 0px;
                    padding-: 0;
                }

                .container
                {
                    width: ;
                    background-color: ;
                }

                .tab_container {
                    border: 1px solid #999;
                    border--top: none;
                    clear: both;
                    float: left;
                    width: 99%;
                    margin-left: 5px;
                    margin--right: 5px;
                    height: 99%;
                    background: #E8E8E8;
                    display: block;
                    -moz-border-radius-bottomright: 5px;
                    -khtml-border-radius-bottomright: 5px;
                    -webkit-border-bottom-right-radius: 5px;
                    -moz-border-radius-bottomleft: 5px;
                    -khtml-border-radius-bottomleft: 5px;
                    -webkit-border-bottom-left-radius: 5px;
                }

                .tab_content {
                    padding-top: 5px;
                    padding-right: 5px;
                    padding-bottom: 5px;
                    font-size: 12px;
                    /*	background-color: #E8E8E8;*/
                    background-color: #E8E8E8;
                    height: 622px;
                    border: 0px solid blue;
                    width: 99%;
                }

                .accordion {
                    width: 200px;
                    border-bottom: solid 1px #c4c4c4;
                    float: left;
                    margin: 5px;
                }

                .titacrd1  {
                    background-image:url("images/acord/titacord.jpg");
                    height:82px;
                    width:190px;
                }
                .Estilo2 {color: #FFFFFF}

                #div_view_register_cambio
                {
                    display: none;
                    position: absolute;
                    top: 40%;
                    width: 100%;
                    z-index:1;

                }
            </style>
            

            <link rel="stylesheet" type="text/css"	href="js/flexigrid/css/flexigrid/flexigrid.css" />
            <link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.9.custom.css"/>
            <link rel="stylesheet" type="text/css" href="css/style_form.css"/>
            <link rel="stylesheet" type="text/css" href="css/styletabla.css"/>
            <!--<script language="javascript" type="text/javascript" src="js/jquery.js"></script>-->
			<script language="javascript" type="text/javascript" src="anb_js/jquery-1.7_min.js"></script>
            <script language="javascript" type="text/javascript" src="js/function.js"></script>
            <script type="text/javascript" src="js/jquery-ui-1.8.9.custom.min.js"></script><!--
            <script src="js/jquery.ui.core.js"></script>
            <script src="js/jquery.ui.widget.js"></script>
            <script type="text/javascript" src="js/jquery.ui.tabs.js"></script>-->
            <script language="javascript" type="text/javascript" src="js/jquery.form.js"></script>
            <script type="text/javascript" src="js/jquery.validate.1.5.2.js"></script>
            <script type="text/javascript" src="js/flexigrid/flexigrid.js"></script>
			
            <script language="javascript" type="text/javascript">
                $(document).ready(function() {
                    //SOLAPAS
                    //--------------------------------------------------------------------
                    //Default Action
                    $(".tab_content").hide(); //Hide all content
                    $("ul.tabs li:first").addClass("active").show(); //Activate first tab
                    $(".tab_content:first").show(); //Show first tab content

                    //On Click Event
                    $("ul.tabs li").click(function() {
                        //alert("ayumi");
                        $("ul.tabs li").removeClass("active"); //Remove any "active" class
                        $(this).addClass("active"); //Add "active" class to selected tab
                        $(".tab_content").hide(); //Hide all tab content
                        var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
                        //alert(activeTab);
                        $(activeTab).show(); //Fade in the active content
                        //$(activeTab).show();
                        return false;
                    });
                    //--------------------------------------------------------------------

                    //ACORDEON
                    //-------------------------------------------------------------------
                    $(".accordion h3:first").addClass("active");
                    $(".accordion p:not(:first)").hide();
                    $(".accordion h3").click(function(){
                        $(this).next("p").slideToggle("slow")
                        .siblings("p:visible").slideUp("slow");
                        $(this).toggleClass("active");
                        $(this).siblings("h3").removeClass("active");
                    });
                    //-------------------------------------------------------------------
                });
            </script>
            <script>
                var tab_images = new Object;
                preloadImgs_tabs = function(v_imgs,path_imgs,n_tabs,ext){
                    for(i=1;i<=n_tabs;i++){
                        //OUT
                        //--------------------------------------
                        var img = new Image();
                        img.src = path_imgs+"tab_"+i+"_out."+ext;
                        v_imgs["tab_"+i+"_out"] = img;
                        //--------------------------------------
                        //OVER
                        //--------------------------------------
                        var img = new Image();
                        img.src = path_imgs+"tab_"+i+"_over."+ext;
                        v_imgs["tab_"+i+"_over"] = img;
                        //--------------------------------------

                    }
                }

                preloadImgs_tabs(tab_images,"images/tabs/",4,"gif");
                //alert(tab_images["tab_2_out"].src);
			
			

                crossover = function(img,estado){
                    id = img.id;
                    src = img.src;
                    title = img.title
                    //alert(src);
                    //obtenemos el estado actual del tab
                    //------------------------------------------
                    pos_barra = src.lastIndexOf("/");
                    pos_punto = src.lastIndexOf(".");
                    nombre_img = src.slice(pos_barra+1,pos_punto);
                    pos_linea = nombre_img.lastIndexOf("_");
                    estado_current = nombre_img.substr(pos_linea+1);
                    //alert(estado_current);
                    //------------------------------------------
                    switch(estado){
                        case "over":{
                                if(title == "I"){
                                    img.src = tab_images[id+"_"+estado].src;
                                }
                            }
                        case "out":{
                                if(title == "I"){
                                    img.src = tab_images[id+"_"+estado].src;
                                }
                            }
                    }
                }

                setEstado = function(imagen){
                    //asignamos "I" al title de todas las imagenes
                    //--------------------------------------------
                    for(i=1;i<=4;i++){
                        $("#tab_"+i).attr("title","I");
                    }
                    //--------------------------------------------
                    $(imagen).attr("title","A");
                    //cambiamos las imagenes de los demas tabs a out
                    //--------------------------------------------
                    for(i=1;i<=4;i++){
                        imagen = document.getElementById("tab_"+i);
                        crossover(imagen,"out");
                    }
                    //--------------------------------------------
                }
                recargar = function(){
                    //alert("recargando...");
                    document.location.reload();
                }
            </script>
        </head>
        <body>
            <table width="100%" height="495px" align="center" cellpadding="0" cellspacing="0" border="0">
                <td align="center" valign="top">
                    <div align="center" class="-container">
                        <table width="100%" align="center" border="0" height="40">
                            <tr>
                                <td colspan="3" bgcolor="">

                                    <div id="logo">
                                        <a href="index.php" style="text-decoration:none">
                                            <img src="images/bk/logo_c.png" height="30"
                                                 border="0" alt=".:: Open Space ::." title=".:: Open Space ::." /></a>
                                    </div>
                                    <div id="div_datos_usuario" class="header_logeo">
                                        Empresa:  <?php echo $_SESSION['gNombreEmpresa']; ?>&nbsp; &nbsp;| &nbsp;
             				Usuario: <?php echo $_SESSION['gNombreUsuario']; ?></a>&nbsp; &nbsp;| &nbsp;
                                    <a class="pSearch" href="acceso/LoginClose.php">(Cerrar Session)</a>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <ul class="tabs">
                        <li><a href="#tab1">
                                <img class="img_tab_ayu" id="tab_1" src="images/tabs/tab_1_over.gif" border="0"
                                     onmouseover="crossover(this,'over')"
                                     onmouseout="crossover(this,'out')"
                                     onclick="setEstado(this)"
                                     title="A" />
                            </a></li>
                        <?php if ($_SESSION['acceso_sistema'] == 'S') { ?>
                            <li><a href="#tab2">
                                    <img class="img_tab_ayu" id="tab_2" src="images/tabs/tab_2_out.gif" border="0"
                                         onmouseover="crossover(this,'over')"
                                         onmouseout="crossover(this,'out')"
                                         onclick="setEstado(this)"
                                         title="I" />
                                </a></li>
                        <?php } ?>
                        <?php if ($_SESSION['acceso_seguridad'] == 'S') { ?>
                            <li><a href="#tab4">
                                    <img class="img_tab_ayu" id="tab_4" src="images/tabs/tab_4_out.gif" border="0"
                                         onmouseover="crossover(this,'over')"
                                         onmouseout="crossover(this,'out')"
                                         onclick="setEstado(this)"
                                         title="I" />
                                </a></li>
                        <?php } ?>
                    </ul>

                    <div class="tab_container">

                        <div id="tab1" class="tab_content">

<?php include_once("tab_1.php"); ?>

                        </div>
<?php if ($_SESSION['acceso_sistema'] == 'S') { ?>
                            <div id="tab2" class="tab_content">

<?php include_once("tab_2.php"); ?>

                        </div>
<?php } ?>
                        <div id="tab3" class="tab_content">

<?php include_once("tab_3.php"); ?>

                        </div>
<?php if ($_SESSION['acceso_seguridad'] == 'S') { ?>
                            <div id="tab4" class="tab_content">

<?php include_once("tab_4.php"); ?>

                        </div>
<?php } ?>
                    </div>

                </div>
            </td>
        </table>
    </body>
</html>
<?php } ?>