<?php
session_start();

if (!isset($_SESSION['gIdUsuario'])) {

    header("location: acceso/login.php");
} else {
    ?>
    <!doctype html>
    <html lang="es">
        <head>
            <meta charset="utf-8"/>
            <meta name="viewport" content="width = device-width, initial-scale=1, maximum-scale=1"/>
            <title>.:: Sistema Prosic ::.</title>
 <link rel="stylesheet" type="text/css"	href="css/main.css" />
            <style>

            </style>

            <link rel="stylesheet" href="anb_themes/base/jquery.ui.all.css">		




            <link rel="stylesheet" type="text/css" media="screen" href="anb_css/ui.jqgrid.css" />
            

        <!-- 		<script src="anb_js/jquery-1.7_min.js" type="text/javascript"></script>-->

            <script language="javascript" type="text/javascript" src="js/jquery.js"></script>
            <script src="anb_ui/jquery-ui-1.8.16.custom.js" type="text/javascript"></script>

            <script src="anb_js/grid.locale-es.js" type="text/javascript"></script>  
            <script src="anb_js/jquery.jqGrid.min.js" type="text/javascript"></script>
            <script src="anb_js/jquery.jqGrid.src.js" type="text/javascript"></script>
            <script src="anb_js/src/grid.subgrid.js" type="text/javascript"></script>
            <!--    <script src="anb_js/src/grid.common.js" type="text/javascript"></script>   		
                <script src="anb_js/src/grid.postext.js" type="text/javascript"></script>
            -->	
            <!-- -->
            <script src="sunat_planilla/view/js/misfunciones_sunat.js" type="text/javascript"></script>			
            <script src="sunat_planilla/view/js/misgrid_sunat.js" type="text/javascript"></script>
            <!-- -->
            
            
            <script src="sunat_planilla/view-plame/js/misgrid.js" type="text/javascript"></script>


            <script language="javascript" type="text/javascript" src="js/function.js"></script>
            <script language="javascript" type="text/javascript" src="js/jquery.form.js"></script>
            <script type="text/javascript" src="js/jquery.validate.1.5.2.js"></script>

            <script language="javascript" type="text/javascript">
                $(document).ready(function() {
                    //COMBO BOX
                    //$(".chzn-select").chosen();
        				
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
        <body class="" >
        



<div align="center" id="contenedor">



<div id="cabecera" style="display:inline-block" >

<!--<div>
--><div id="logo">   
     <a href="index.php" style="text-decoration:none">
<img src="images/bk/logo_c.png" alt=".:: Open Space ::." width="79" height="52"
border="0" title=".:: Open Space ::." /></a>                             
</div>
<!--</div>-->


<nav>
                                    <ul>
                                    <li>
                                    </li>
                                    
                                    
                                    <li> Empresa:  <?php echo $_SESSION['gNombreEmpresa']; ?></li>
                                    
                                    <li>Usuario: <?php echo $_SESSION['gNombreUsuario']; ?></li>
                                    
                                    <li><a class="pSearch" href="acceso/LoginClose.php">(Cerrar Session)</a></li>
                                    
                                    </ul>
                                    
                                    
                                    
   </nav>                                 
                                    
                                    
                                    
                                    
                                    
                                    
      
   </div>   
      
      

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








        </body>
    </html>
<?php } ?>