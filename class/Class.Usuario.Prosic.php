<?php

include_once('Class.Mysql.Prosic.php');

class Usuario_Prosic extends Mysql_Prosic {

    function cargar_data_usuarios() {
        $sql = "SELECT
			    prosic_usuario.id_usuario
			    , prosic_usuario.codigo_usuario
			    , prosic_usuario.nombre_usuario
				, prosic_usuario.status_usuario
				, prosic_usuario.email_usuario				
				, prosic_empresa.nombre_empresa
				, prosic_usuario.id_empresa
				, prosic_tipo_usuario.id_tipo_usuario
				, prosic_tipo_usuario.nombre_tipo_usuario
				FROM
				dbprosic.prosic_usuario
				INNER JOIN dbprosic.prosic_tipo_usuario 
					ON (prosic_usuario.id_tipo_usuario = prosic_tipo_usuario.id_tipo_usuario)
				INNER JOIN dbprosic.prosic_empresa 
					ON (prosic_usuario.id_empresa = prosic_empresa.id_empresa) ";
        $sql.=" WHERE status_usuario<>'E' ";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function consulta_usuario_por_id($id) {
        $sql = "select * from prosic_usuario where id_usuario=" . $id;
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        return $row;
    }

    function AgregarUsuario($campos, $datos) {
        $agregar = $this->sqlInsert("prosic_usuario", $campos, $datos);
        return $agregar;
    }

    function ModificarUsuario($campos, $datos, $id, $valor) {
        $modificar = $this->sqlUpdate("prosic_usuario", $campos, $datos, $id, $valor);
        return $modificar;
    }   

    function bloquear_usuario($idusuario) {
        $sql = "update prosic_usuario set status_usuario='N' where id_usuario=" . $idusuario;
        $this->Consulta_Mysql($sql);
        return "Usuario Bloqueado";
    }

    function desbloquear_usuario($idusuario) {
        $sql = "update prosic_usuario set status_usuario='A' where id_usuario=" . $idusuario;
        $this->Consulta_Mysql($sql);
        return "Usuario Desbloqueado";
    }
    function eliminar_usuario($idusuario) {
        $sql = "update prosic_usuario set status_usuario='E' where id_usuario=" . $idusuario;
        $this->Consulta_Mysql($sql);
        return "Usuario Desbloqueado";
    }

    function actualizar_password($email_usuario,$password){
        $sql = "update prosic_usuario set status_usuario='A', password_usuario='".$password."' where email_usuario='" . $email_usuario."'";
        $this->Consulta_Mysql($sql);
        return "Usuario Desbloqueado";
    }
}

?>