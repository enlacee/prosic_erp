<table width="100%" border="0" align="center"
       cellpadding="0" cellspacing="0">
    <!--
    <tr>
            <td align="left" class="titulo_3" colspan="2">

	INGRESO DE USUARIOS

	</td>
    </tr>
    -->
    <tr>
        <td align="center" valign="top"><div
                style="float: center; border: 0px solid blue;vertical-align: middle; width: 100%;">
                <form name="frm_login" id="frm_login" method="POST" action="login_nuevo.php">
                    <table width="97%" border="0" align="left" bgcolor="white" >
                        <tr>
                            <td colspan="2" align="center">
                                <div id="div_msg_login"></div></td>
                        </tr>
                        <tr>
                            <td width="50%" rowspan="6" align="center"><img src="../images/icons/candado_2.jpg" width="170" height="170" /></td>
                            <td width="50%" align="left" style="font-size:18px; color:#990000;"><strong>USUARIO</strong></td>
                        </tr>
                        <tr>
                            <td align="left"> Usuario:&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left">




                                <input name="email_usuario" id="email_usuario" class="txtnick" value="<?php echo $_GET['email_usuario'] ?>" size="30" style="width:88%;"/>            </td>
                        </tr>
                        <tr>
                            <td align="left">Contrase&ntilde;a:&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left">
                                <input name="password_usuario" id="password_usuario" type="password" class="txtpass" size="30"  style="width:88%;" />
                            </td>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                            <td align="right"></td>
                            <td align="right"><input type="submit" value="Ingresar" /></td>
                        </tr>
                    </table>
                </form>
            </div>

        </td>
    </tr>
</table>
