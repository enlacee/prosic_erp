<?php

/**
 * Sistema Prosic
 * Clase del Modulo de Contabilidad PROSIC
 * @package		Prosic
 * @author		Rommel Mercado Rodriguez
 * @copyright	Copyright 2011
 * @license		Rommel Mercado Rodriguez
 * @since		Version 1.0
 * @filesource
 */
?>
<?php

include_once('Class.Mysql.Prosic.php');

class Tesoreria_Prosic extends Mysql_Prosic {

    public $nro_documento='';
    public $nro_serie='';

    function __construct() {
        parent::__construct();
    }

    function insertar_recibo_pago($fields, $values) {
        $retornar = $this->sqlInsert("prosic_tesoreria_documento", $fields, $values);
        return $retornar;
    }
    
    function insertar_detalle_fijo($fields, $values) {
        $retornar = $this->sqlInsert("prosic_tesoreria_fondo_detalle", $fields, $values);
        return $retornar;
    }

    function insertar_fondo_fijo($fields, $values) {
        $retornar = $this->sqlInsert("prosic_tesoreria_fondo_fijo", $fields, $values);
        return $retornar;
    }

    function get_fondo_fijo($limit='') {
        $sql = "select  * from prosic_tesoreria_fondo_fijo ";
        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function get_fondo_fijo_id($id_fondo_fijo) {
        $sql = "select  * from prosic_tesoreria_fondo_fijo where id_fondo_fijo=" . $id_fondo_fijo;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function get_recibo_pago($fecha_emision_documento='', $nombre_pago='', $limit='') {
        $sql = "SELECT *
	FROM prosic_tesoreria_documento where tipo_pago='R' ";

        if ($fecha_emision_documento != ''

            )$sql.=" AND fecha_emision_documento='" . $fecha_emision_documento . "'";
        if ($nombre_pago != ''

            )$sql.=" AND nombre_pago like'%" . $nombre_pago . "%' ";
        $sql.=" order by id_documento desc ";
        if ($limit != ''

            )$sql.=$limit;

        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function get_recibo_id($id){
        $sql    =   "SELECT  * FROM prosic_tesoreria_documento WHERE id_documento=".$id;
        $res    =   $this->Consulta_Mysql($sql);
        $row    = mysql_fetch_assoc($res);
        return $row;
    }
    function get_cheque_voucher($id){
        $sql    =   "SELECT prosic_tesoreria_documento.*,prosic_banco.nro_cuenta_banco,prosic_banco.nombre_banco FROM
                    prosic_tesoreria_documento
                    INNER JOIN prosic_banco
                    ON prosic_tesoreria_documento.id_banco=prosic_banco.id_banco
                    WHERE id_documento=".$id;
        $res    =   $this->Consulta_Mysql($sql);
        $row    = mysql_fetch_assoc($res);
        return $row;
    }
    function get_almacen_fondo($limit='') {
        $sql = "SELECT * FROM prosic_tesoreria_documento where tipo_pago='C' and
                    forma_pago='F' AND area_pago='A' ";
        $sql.=" order by id_documento desc";
        $sql.=$limit;

        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function get_almacen_cheque($limit='') {
        $sql = "SELECT * FROM prosic_tesoreria_documento where tipo_pago='C' and
                    forma_pago='H' AND area_pago='A' ";
        $sql.=" order by id_documento desc ";
        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function get_contabilidad_fondo($limit='') {
        $sql = "SELECT * FROM prosic_tesoreria_documento where tipo_pago='C' and
                    forma_pago='F' AND area_pago='C' ";
        $sql.=" order by id_documento desc";
        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function get_contabilidad_cheque($limit='') {
        $sql = "SELECT * FROM prosic_tesoreria_documento where tipo_pago='C' and
                    forma_pago='H' AND area_pago='C' ";
        $sql.=" order by id_documento desc";
        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function selected_fondo_fijo() {

        $retorna = ' <label>Fondo Fijo</label> ';

        $retorna.= '<select id="id_fondo_fijo" name="id_fondo_fijo" > ';
        $sql = "SELECT * FROM prosic_tesoreria_fondo_fijo WHERE status_fondo_fijo='AC' AND monto_saldo>0";
        $res = $this->Consulta_Mysql($sql);

        while ($row_select = mysql_fetch_array($res)) {
            if ($row_select[0] == $defecto)
                $selected = " selected='selected' ";
            else
                $selected = " ";

            $retorna.= "<option value='" . $row_select[0] . "' $selected>" . utf8_encode($row_select[1]) . ", Saldo: " . $row_select[7] . "</option>";
        }

        $retorna.= '</select><br>';

        return $retorna;
    }

    function get_comprobante_almacen_aprobar($limit='') {
        $sql = "SELECT  alm0010006 AS id_comprobante
                    ,	alm0010005 AS ruc
                    ,	tab0080006 AS proveedor
                    ,	alm0010009 AS nro_comprobante
                    ,	alm0010010 AS fecha
                    ,	alm0010018 AS moneda
                    ,	alm0010013 AS importe
                    FROM alm0012010
                    INNER JOIN tab0080000
                    ON (tab0080000.tab0080001=alm0012010.alm0010005)
                    WHERE alm0010003='01' AND alm0010023='N' ";
        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function aprobar_documento($id){
        $sql    =   "update alm0012010 set alm0010023='A' where alm0010006=".$id;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

     function pagar_documento($id){
        $sql    =   "update alm0012010 set alm0010023='P' where alm0010006=".$id;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

     function pagar_documento_contabilidad($id){
        $sql    =   "update prosic_comprobante set status_comprobante_cancelado='P' where id_comprobante=".$id;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }


    function selected_cuenta($tabla, $id, $etiqueta, $defecto='', $newsql='', $status='') {

        $retorna = ' <label>' . $etiqueta . '</label> ';

        $retorna.= '<select id="' . $id . '" name="' . $id . '" > ';

        $sql = ($newsql == "") ? "SELECT * FROM " . $tabla . $status : $newsql;

        $res = $this->Consulta_Mysql($sql);

        while ($row_select = mysql_fetch_array($res)) {
            if ($row_select[0] == $defecto)
                $selected = " selected='selected' ";
            else
                $selected = " ";

            $retorna.= "<option value='" . $row_select[0] . "' $selected>" . utf8_encode($row_select[2]).'- '.$row_select[3] . "</option>";
        }

        $retorna.= '</select><br>';

        return $retorna;
    }

    function get_correlativo_recibo(){
        $sql="SELECT nro_serie,nro_correlativo FROM
              prosic_tesoreria_correlativo
              WHERE tipo_documento='F'";
        $result=$this->Consulta_Mysql($sql);
        $row=mysql_fetch_assoc($result);
        $this->nro_documento=$row['nro_correlativo'];
        $this->nro_serie=$row['nro_serie'];        
    }
    function get_correlativo_cheque(){
        $sql="SELECT nro_serie,nro_correlativo FROM
              prosic_tesoreria_correlativo
              WHERE tipo_documento='H'";
        $result=$this->Consulta_Mysql($sql);
        $row=mysql_fetch_assoc($result);
        $this->nro_documento=$row['nro_correlativo'];
        $this->nro_serie=$row['nro_serie'];
    }
}
?>