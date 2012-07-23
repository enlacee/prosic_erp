<?php

include_once('Class.Mysql_Caja.Prosic.php');

class Caja_Prosic extends Mysql_Caja_Prosic {

    function __construct() {
        parent::__construct();
    }

    function selected_banco($tabla, $id, $etiqueta, $defecto='', $newsql='', $status='', $extra='') {

        $retorna = ' <label>' . $etiqueta . '</label> ';

        $retorna.= '<select id="' . $id . '" name="' . $id . '" ' . $extra . '> ';

        $sql = ($newsql == "") ? "SELECT * FROM " . $tabla . $status : $newsql;

        $res = $this->Consulta_Mysql($sql);

        while ($row_select = mysql_fetch_array($res)) {
            if ($row_select[0] == $defecto)
                $selected = " selected='selected' ";
            else
                $selected = " ";

            $retorna.= "<option value='" . $row_select[0] . "' $selected>" . utf8_encode($row_select[2]) . ' CUENTA:' . utf8_encode($row_select[3]) . "</option>";
        }

        $retorna.= '</select><br>';

        return $retorna;
    }

    function get_deposito_si($limit='') {
        $sql = "SELECT
                caja_deposito.*,
                caja_turno.nombre_turno,
                prosic_banco.nombre_banco,
                prosic_banco.nro_cuenta_banco
                FROM
                dbprosic_server_caja.caja_deposito
                INNER JOIN dbprosic_server_caja.caja_turno 
                ON (caja_deposito.id_turno = caja_turno.id_turno)
                INNER JOIN dbprosic.prosic_banco
                on(dbprosic.prosic_banco.id_banco=dbprosic_server_caja.caja_deposito.id_banco)
                where caja_deposito.id_local=1";
        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function get_deposito_mi($limit='') {
        $sql = "SELECT
                caja_deposito.*,
                caja_turno.nombre_turno,
                prosic_banco.nombre_banco,
                prosic_banco.nro_cuenta_banco
                FROM
                dbprosic_server_caja.caja_deposito
                INNER JOIN dbprosic_server_caja.caja_turno 
                ON (caja_deposito.id_turno = caja_turno.id_turno)
                INNER JOIN dbprosic.prosic_banco
                on(dbprosic.prosic_banco.id_banco=dbprosic_server_caja.caja_deposito.id_banco)
                where caja_deposito.id_local=2";
        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function get_deposito_sb($limit='') {
        $sql = "SELECT
                caja_deposito.*,
                caja_turno.nombre_turno,
                prosic_banco.nombre_banco,
                prosic_banco.nro_cuenta_banco
                FROM
                dbprosic_server_caja.caja_deposito
                INNER JOIN dbprosic_server_caja.caja_turno 
                ON (caja_deposito.id_turno = caja_turno.id_turno)
                INNER JOIN dbprosic.prosic_banco
                on(dbprosic.prosic_banco.id_banco=dbprosic_server_caja.caja_deposito.id_banco)
                where caja_deposito.id_local=3";
        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function get_deposito_pl($limit='') {
        $sql = "SELECT
                caja_deposito.*,
                caja_turno.nombre_turno,
                prosic_banco.nombre_banco,
                prosic_banco.nro_cuenta_banco
                FROM
                dbprosic_server_caja.caja_deposito
                INNER JOIN dbprosic_server_caja.caja_turno 
                ON (caja_deposito.id_turno = caja_turno.id_turno)
                INNER JOIN dbprosic.prosic_banco
                on(dbprosic.prosic_banco.id_banco=dbprosic_server_caja.caja_deposito.id_banco)
                where caja_deposito.id_local=4";
        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }
    
        function get_deposito($limit='') {
        $sql = "SELECT
                caja_deposito.*,
                caja_turno.nombre_turno,
                prosic_banco.nombre_banco,
                prosic_banco.nro_cuenta_banco
                FROM
                dbprosic_server_caja.caja_deposito
                INNER JOIN dbprosic_server_caja.caja_turno  ON (caja_deposito.id_turno = caja_turno.id_turno)
                INNER JOIN dbprosic.prosic_banco            on (dbprosic.prosic_banco.id_banco=dbprosic_server_caja.caja_deposito.id_banco)
				order by status_deposito, fecha_deposito";
        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }
    
    function row_deposito($id){
        $sql = "SELECT
                  caja_deposito.*,
                  caja_turno.nombre_turno,
                  prosic_banco.id_plan_contable,
                  prosic_banco.id_subdiario,
                  prosic_banco.nro_cuenta_banco,
                  prosic_tipo_cambio.compra_sunat
                FROM dbprosic_server_caja.caja_deposito
                LEFT JOIN dbprosic_server_caja.caja_turno ON (caja_deposito.id_turno = caja_turno.id_turno)
                LEFT JOIN dbprosic.prosic_banco           ON (dbprosic.prosic_banco.id_banco = dbprosic_server_caja.caja_deposito.id_banco)
                LEFT JOIN dbprosic.prosic_plan_contable   ON (dbprosic.prosic_plan_contable.id_plan_contable = dbprosic.prosic_banco.id_plan_contable)
                LEFT JOIN dbprosic.prosic_tipo_cambio     ON (dbprosic.prosic_tipo_cambio.fecha_tipo_cambio = dbprosic_server_caja.caja_deposito.fecha_deposito)  
                WHERE caja_deposito.idcaja_deposito=".$id;
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        return $row;
    }

	function get_correlativo_voucher($is, $im, $ia, $il) {
        $sql = "SELECT	MAX(correlativo) FROM dbprosic.prosic_correlativo WHERE id_subdiario=" . $is . " AND id_mes=" . $im . " AND id_anio = " . $ia . " AND id_local= " . $il;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_array($result);
        $id = $row[0];
        if ($id == "") {
            return 0;
        } else {
            return $id;
        }
    }

	function insertar_correlativo_voucher($fields, $values) {
        $retornar = $this->sqlInsert("dbprosic.prosic_correlativo", $fields, $values);
        return $retornar;
    }
	
}

?>
