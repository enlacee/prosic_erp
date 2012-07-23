<?php
session_start();
require_once("../../BL/BLEmpleado.php");

$usuario = $_POST["usuario"];
$clave = $_POST["clave"];

$msg = logear($_POST);

//echo "<br/>usuario: $usuario - clave: $clave";

?>
<input type="hidden" name="msg_ope" id="msg_ope" value="<?=$msg["R"];?>" size="2" />
<input type="hidden" name="msg_msg" id="msg_msg" value="<?=$msg["msg"];?>" size="8" />