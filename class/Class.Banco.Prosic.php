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

class Banco_Prosic extends Mysql_Prosic {

    function consultar_data_banco($where, $sort, $limit) {
        $sql = "SELECT
            prosic_empresa.nombre_empresa
            , prosic_banco.id_banco
            , prosic_banco.codigo_banco
            , prosic_banco.nombre_banco
            , prosic_banco.nro_cuenta_banco
            , prosic_banco.status_banco
            , prosic_banco.id_plan_contable
            , prosic_empresa.nombre_empresa
            , prosic_tipo_cuenta_banco.nombre_cuenta_banco
            , prosic_plan_contable.descripcion_plan_contable
            FROM
                prosic_banco
            INNER JOIN prosic_empresa            ON (prosic_banco.id_empresa = prosic_empresa.id_empresa)
            INNER JOIN prosic_plan_contable      ON (prosic_banco.id_plan_contable = prosic_plan_contable.id_plan_contable)
            INNER JOIN prosic_tipo_cuenta_banco  ON (prosic_banco.id_tipo_cuenta_banco = prosic_tipo_cuenta_banco.id_tipo_cuenta_banco) $where $sort $limit";
        $return = $this->Consulta_Mysql($sql);
        return $return;
    }

    function consulta_data_banco_id($id){
        $sql    =   "SELECT * FROM prosic_banco where id_banco = ".$id;
        $result = $this->Consulta_Mysql($sql);
        $row    = mysql_fetch_assoc($result);
        return $row;
    }

    function insertar_banco($fields,$values){
        $result = $this->sqlInsert("prosic_banco", $fields, $values);
        return $result;
    }

    function update_banco($fields,$values,$idkey,$valuekey){
        $result = $this->sqlUpdate("prosic_banco", $fields, $values, $idkey, $valuekey);
        return $result;
    }
}
?>
