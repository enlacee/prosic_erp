<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Class
 *
 * @author USER
 */

include_once('Class.Mysql.Prosic.php');
class Perfiles_Prosic extends Mysql_Prosic {
    function  __construct() {
        parent::__construct();
    }

    function cargar_tipo_usuario(){
        $sql    =   "SELECT * FROM prosic_tipo_usuario where status_tipo_usuario<>'E'";
        $result = $this->Consulta_Mysql($sql);        
        return $result;
    }

    function cargar_tipo_usuario_id($id_tipo_usuario){
        $sql    =   "SELECT * FROM prosic_tipo_usuario where status_tipo_usuario<>'E' ";
        $sql.=   " and id_tipo_usuario=".$id_tipo_usuario;        
        $result = $this->Consulta_Mysql($sql);
        $row    = mysql_fetch_assoc($result);
        return $row;
    }

    function cargar_acceso_modulo($id_tipo_usuario){
        $sql    =   "SELECT
	prosic_acceso_modulo.id_tipo_usuario
    , prosic_modulo.codigo_modulo
    , prosic_modulo.nombre_modulo
    , prosic_acceso_modulo.id_tipo_usuario
    , prosic_acceso_modulo.id_modulo
    , prosic_acceso_modulo.privilegio_modulo
FROM
    dbprosic.prosic_acceso_modulo
    INNER JOIN dbprosic.prosic_modulo
        ON (prosic_acceso_modulo.id_modulo = prosic_modulo.id_modulo)
    INNER JOIN dbprosic.prosic_tipo_usuario
        ON (prosic_acceso_modulo.id_tipo_usuario = prosic_tipo_usuario.id_tipo_usuario)
 WHERE status_acceso_modulo<>'E' AND prosic_acceso_modulo.id_tipo_usuario=".$id_tipo_usuario;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function actualizar_acceso_modulo($id_tipo_usuario,$id_modulo,$permiso){
        $sql    =   "update prosic_acceso_modulo set privilegio_modulo='".$permiso."' where id_tipo_usuario=".$id_tipo_usuario." and id_modulo=".$id_modulo;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
}
?>
