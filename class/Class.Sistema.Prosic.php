<?php

include_once('Class.Mysql.Prosic.php');

class Sistema_Prosic extends Mysql_Prosic {

    function cargar_tabla_general() {
        $sql = "SELECT * FROM prosic_tabla_general WHERE status_tabla_general='A'";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function CargarTabla($tabla,$status,$limit='') {
        $sql = "select * from " . $tabla . " where ".$status."<>'E' ".$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function ConsultaTablaId($tabla, $idname, $id) {
        $sql = "select * from $tabla where $idname=" . $id;
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        return $row;
    }

    function AgregarDatoTabla($tabla, $campos, $datos) {
        $agregar = $this->sqlInsert($tabla, $campos, $datos);
        return "Datos Guardados";
    }

    function ModificarDatoTabla($tabla, $campos, $datos, $id, $valor) {
        $modificar = $this->sqlUpdate($tabla, $campos, $datos, $id, $valor);
        return "Datos Guardados";
    }

}

?>