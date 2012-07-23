<?php
require_once("../../BL/BLGlobal.php");
require_once("../../Utilitarios/ayu_valida.php");
include_once("../../librerias/PHPMailer_v5.1/class.phpmailer.php");

$ayu_val = new Ayu_Valida();

$destinatario = $_POST["email"];
//echo "<br/>destinatario: $destinatario";

$msg = array();
$msg["R"] = "failed";
$msg["msg"] = "Error al enviar la Contraseña";
if(isset($destinatario) && !empty($destinatario)){
	$V_email = $ayu_val->check_email_address($destinatario);
	if($V_email){
		//VERIFICAMOS QUE EL EMAIL DEL DESTINATARIO EXISTA EN LA BASE DE DATOS
		//--------------------------------------------------------------------
		$email = getCampo("empleadocanal","numero","numero",$destinatario);
		//echo "<br/>email: $email";
		//--------------------------------------------------------------------		
		if($destinatario == $email){
			//OBTENIENDO EL USUARIO Y CONTRASEÑA
			//----------------------------------------------------------------
			$id_empl = getCampo("empleadocanal","id_empl","numero",$destinatario);
			if($id_empl){
				$where = "id_empl = ".addslashes($id_empl);
				$R_cuenta = getCamposWhere("empleado","usuario,contrasena",$where);
				$usuario = $R_cuenta["usuario"];
				$clave = $R_cuenta["contrasena"];
			}
			//echo "<br/>usuario: $usuario - clave: $clave";
			//----------------------------------------------------------------
			$remitente = "soporte@openspace.com.pe";
			$nombre_remitente = ".:: Open Space ::.";
			$body_msg = "Datos de Acceso<br/>".
						"<br/>".
						"Usuario: $usuario <br/>".
						"Contraseña: $clave <br/>".
						"<br/>";					
			
			$mail = new PHPMailer(); 
			$mail->From = $remitente; 
			$mail->FromName = $nombre_remitente; 
			$mail->Subject = utf8_encode("Datos de tu Cuenta"); 
			$mail->CharSet  = "utf-8";
			$mail->AddAddress($destinatario,$destinatario);  
			$mail->WordWrap = 50; 
			$mail->IsHTML(true); 
			$body = $body_msg;
			$mail->Body = $body;  
			$RS = $mail->Send();
			
			if($RS){   	
				$msg["R"] = "ok";
				$msg["msg"] = "";
			}
		}
	}
	else{
		$msg["msg"] = "El E-mail es invalido";
	}
}	
?>
<input type="hidden" name="msg_ope" id="msg_ope" value="<?=$msg["R"];?>" size="2" />
<input type="hidden" name="msg_msg" id="msg_msg" value="<?=$msg["msg"];?>" size="8" />