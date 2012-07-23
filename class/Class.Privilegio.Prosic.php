<?php

include_once('Class.Mysql.Prosic.php');

class Privilegio_Prosic extends Mysql_Prosic {

    function CargarPrivilegiosUsuario($idusuario) {
        $sql = "SELECT * FROM prosic_acceso_modulo WHERE id_usuario=" . $idusuario;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function CargarModulos() {
        $sql = "SELECT * FROM prosic_modulo";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

}

?>