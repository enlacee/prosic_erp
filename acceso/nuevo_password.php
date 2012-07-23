<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>.:: Sistema Prosic ::.</title>
        <style> @import url("../css/head.css"); </style>
        <style> @import url("../css/global.css"); </style>
        <style> @import url("../css/borde.css"); </style>
        <style> @import url("../css/tooltip.css"); </style>
        <script language="javascript" type="text/javascript" src="js/jquery.js"></script>
        <script language="javascript" type="text/javascript" src="js/function.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.9.custom.min.js"></script>
        <script src="js/jquery.ui.core.js"></script>
        <script src="js/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="js/jquery.ui.tabs.js"></script>
        <script language="javascript" type="text/javascript" src="js/jquery.form.js"></script>
        <script type="text/javascript" src="js/jquery.validate.1.5.2.js"></script>
        <script type="text/javascript" src="js/flexigrid/flexigrid.js"></script>
        <style>

            body {
                background-image: url("../images/bk/fondoweb_intranet.jpg");
                background-repeat: repeat-x;
                background-position: center top;
                margin-top: 0px;
                margin-bottom: 0px;
                margin-left: 0px;
                margin-right: 0px;
                padding-: 0;
            }

            #div_head_login
            {
                height: 120px;
                border: 0px solid red;
            }

            #div_body_login
            {
                height: 270px;
                border: 0px solid red;
            }

            .div_pie
            {
                background-image: url("../images/bk/bk2.jpg");
                background-repeat: repeat-x;
                background-position: center bottom;
                background-color: #e0e0df;
                font-family:  Arial, Helvetica, sans-serif;
                font-weight: normal;
                height: 50px;
                width: 100%;
                border: 0px double blue;
                text-align: center;
            }

            #div_msg_login
            {
                height: 20px;
                border: 0px solid red;
            }

            #div_msg_login
            {
                padding-top: 5px;
                font-weight: bold;
            }

        </style>
        <style>
            .container {width: 32%; height: 230px; margin: 5px auto; border: 0px solid blue; margin-top:60px;}

            ul.tabs {
                font-family: Arial, Helvetica, sans-serif;
                font-weight: normal;
                font-size: 11px;
                margin: 0;
                margin-left: 0px;
                padding: 0;
                float: left;
                list-style: none;
                height: 25px;
                border-bottom: 0px solid lime;
                border-left: 0px solid #999;
                border: 0px solid blue;
                width: 100%;
            }

            ul.tabs li a:hover {
                background: #b81716;
            }

            /* -- TITULO ACTIVO -- */
            html ul.tabs li.active, html ul.tabs li.active a:hover  {
                background: #6F0000;
                color: #ffffff;
                border-bottom: 0px solid #fff;
            }

            /* --  TITULO DE LAS SOLAPAS  -- */
            ul.tabs li {
                font-family: Arial, Helvetica, sans-serif;
                font-weight: normal;
                font-size: 11px;
                float: left;
                margin: 0;
                padding: 0px;
                height: 26px;
                line-height: 26px;
                border: 1px solid #999;
                border-bottom: 0px;
                margin-bottom: -1px;
                background: #D88D99;
                overflow: hidden;
                position: relative;
                background-color: #141414;
            }

            ul.tabs li a {
                font-family: Arial, Helvetica, sans-serif;
                font-weight: bold;
                font-size: 11px;
                text-decoration: none;
                color: #ffffff;
                display: block;
                padding: 0px 7px;
                margin-left: 1px;
                border: 0px solid #fff;
                outline: none;
            }

            .tab_container {
                border: 0px solid #999;
                border--top: none;
                clear: both;
                float: left;
                width: 100%;
                height: 100%;
                background: white;
                padding-bottom: 15px;
                -moz-border-radius-bottomright: 5px;
                -khtml-border-radius-bottomright: 5px;
                -webkit-border-bottom-right-radius: 5px;
                -moz-border-radius-bottomleft: 5px;
                -khtml-border-radius-bottomleft: 5px;
                -webkit-border-bottom-left-radius: 5px;
            }

            .tab_content {

                font-size: 11px;
                background-color: white;
                height-: 98%;
            }
        </style>
    </head>

    <body>

        <div id="div_head_login">
            <table width="100%" align="center" border="0">
                <tr>
                    <td colspan="3" bgcolor="">

                        <div id="logo" style="margin-left: 12px;"><img src="../images/bk/logo_c.png" width="312" height="70" /></div>
                        <div id="logo2" style="margin-right: 80px; margin-top:28px; float:right; width369px; height:21px"><img src="../images/bk/t_sistemagestion.png" width="369" height="21" /></div>
                    </td>
                </tr>
            </table>
        </div>
        <div id="div_body_login">

            <div class="container">

                <ul class="tabs">
                    <li><a href="#tab1">REACTIVAR CUENTA - NUEVO PASSWORD</a></li>
                </ul>
                <div id="loading">
                    <img src="../images/ajax/ajax-loader.gif" border="0" />
                </div>
                <?php
                if ($_GET['r'] == 'e') {
                    echo '<p class="alert">
                    <span style="color:white">Error! Usuario Bloqueado - Comuniquese con el Administrador.
                    </span></p>';
                }
                ?>
                <div class="tab_container">
                    <div id="tab1" class="tab_content" align="center">
                        <?php include_once("view_login_new.php"); ?>
                    </div>
                </div>
            </div>


            <div id="div_result" align="center"> </div>

        </div>

        <div align="center" style=" background-color:#121212; padding:0; color:#FFFFFF;position:float; margin:auto; width:32%; height:40px;"><br />
            &nbsp;&nbsp;&nbsp;            Copyright  2011 PROSIC. - Todos los derechos reservados</div></div>

        <!--<div class="div_pie">Copyright  2010 Open Space. Todos los derechos reservados</div>-->

    </body>
</html>
