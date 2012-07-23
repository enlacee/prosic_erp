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

class Contabilidad_Prosic extends Mysql_Prosic {

    var $valor_afecto;
    var $valor_inafecto;
    var $valor_igv;
    var $valor_isc;
    var $valor_total;
    var $subdiario;
    var $id_moneda;
    var $codigo_moneda;
    var $tipo_cambio;
    var $id_comprobante;
    var $id_plan_contable;
    var $cuenta_plan_contable;
    var $cuenta_costo;
    var $nombre_cuenta_costo;
    var $cargo_haber;
    var $id_anexo;
    var $codigo_anexo;
    var $id_tipo_comprobante;
    var $codigo_tipo_comprobante;
    var $nro_comprobante;
    var $emision_comprobante;
    var $arreglo_isc;
    var $arreglo_igv;
    var $arreglo_inafecto;
    var $arreglo_afecto;
    var $arreglo_total;
    var $arreglo_ingreso_egreso;
    var $arreglo_banco;

    function cargar_data_plan_contable( $cuenta_plan='', $descripcion_plan='', $limit='') {
        $ord = " ORDER BY prosic_plan_contable.cuenta_plan_contable";
        $sql = "SELECT
				prosic_plan_contable.id_plan_contable
				, prosic_plan_contable.cuenta_plan_contable
				, prosic_plan_contable.descripcion_plan_contable
				, prosic_tipo_cuenta.codigo_tipo_cuenta
				, prosic_tipo_cuenta.nombre_tipo_cuenta
				, prosic_nivel_saldo.codigo_nivel_saldo
				, prosic_nivel_saldo.nombre_nivel_saldo
				, prosic_plan_contable.cargar_plan_contable
				, prosic_plan_contable.abonar_plan_contable
				, prosic_plan_contable.transferencia_plan_contable
				, prosic_plan_contable.status_plan_contable
				FROM
				prosic_tipo_cuenta
				INNER JOIN prosic_plan_contable 
				ON (prosic_tipo_cuenta.id_tipo_cuenta = prosic_plan_contable.id_tipo_cuenta)
				INNER JOIN prosic_nivel_saldo 
				ON (prosic_nivel_saldo.id_nivel_saldo = prosic_plan_contable.id_nivel_saldo)
                            WHERE 1=1 ";
        if ($cuenta_plan != ''
            )$sql.=" AND prosic_plan_contable.cuenta_plan_contable LIKE '" . $cuenta_plan . "%'";
        if ($descripcion_plan != ''
            )$sql.=" AND prosic_plan_contable.descripcion_plan_contable like'%" . $descripcion_plan . "%' ";
        if ($ord != ''
            )$sql.=$ord;
        if ($limit != ''
            )$sql.=$limit;

        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consultar_data_anexo($codigo='', $descripcion='', $limit='') {
        $ord = " ORDER BY prosic_anexo.descripcion_anexo";
		$sql = "SELECT prosic_anexo.id_anexo, prosic_anexo.codigo_anexo, prosic_anexo.descripcion_anexo, prosic_anexo.telefono_anexo, prosic_anexo.direccion_anexo, prosic_anexo.ncomercial_anexo
            FROM prosic_anexo WHERE 1=1 ";
				
	        if ($codigo != ''
            )$sql.=" AND prosic_anexo.codigo_anexo LIKE '" . $codigo . "%'";
        if ($descripcion != ''
            )$sql.=" AND prosic_anexo.descripcion_anexo like '%" . $descripcion . "%' ";
        if ($ord != ''
            )$sql.=$ord;
        if ($limit != ''
            )$sql.=$limit;			
			
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function cargar_data_medio_pago($codigo='', $descripcion='', $limit='') {
        $ord = " ORDER BY prosic_medio_pago.codigo_medio_pago";
		$sql = "SELECT prosic_medio_pago.id_medio_pago, prosic_medio_pago.codigo_medio_pago, prosic_medio_pago.nombre_medio_pago, prosic_medio_pago.status_medio_pago
            FROM prosic_medio_pago WHERE 1=1 ";
				
	        if ($codigo != ''
            )$sql.=" AND prosic_medio_pago.codigo_medio_pago LIKE '" . $codigo . "%'";
        if ($descripcion != ''
            )$sql.=" AND  prosic_medio_pago.nombre_medio_pago like '%" . $descripcion . "%' ";
        if ($ord != ''
            )$sql.=$ord;
        if ($limit != ''
            )$sql.=$limit;			
			
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function cargar_plan_contable_id($id) {
        $sql = "SELECT * FROM prosic_plan_contable WHERE id_plan_contable = " . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
	
    function cargar_anexo_id($id) {
        $sql = "SELECT * FROM prosic_anexo WHERE id_anexo = " . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function cargar_data_medio_pago_id($id) {
        $sql = "SELECT * FROM prosic_medio_pago WHERE id_medio_pago = " . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function insertar_plan_contable($fields, $values) {
        $retornar = $this->sqlInsert("prosic_plan_contable", $fields, $values);
        return $retornar;
    }

    function update_plan_contable($fields, $values, $id, $value) {
        $retornar = $this->sqlUpdate("prosic_plan_contable", $fields, $values, $id, $value);
        return $retornar;
    }
	

// codigo modificado x Oscar Alanya
    function insertar_anexo($fields, $values) {
        $retornar = $this->sqlInsert("prosic_anexo", $fields, $values);
        return $retornar;
    }

    function update_anexo($fields, $values, $id, $value) {
        $retornar = $this->sqlUpdate("prosic_anexo", $fields, $values, $id, $value);
        return $retornar;
    }
	
    function insertar_medio_pago($fields, $values) {
        $retornar = $this->sqlInsert("prosic_medio_pago", $fields, $values);
        return $retornar;
    }

    function update_medio_pago($fields, $values, $id, $value) {
        $retornar = $this->sqlUpdate("prosic_medio_pago", $fields, $values, $id, $value);
        return $retornar;
    }
	
	/**
     * Sistema Prosic
     * Function Insertar Registro de Compras
     * @package		Prosic
     * @author		Rommel Mercado
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
	 
    function insertar_registro_comprobante($fields, $values) {
        $retornar = $this->sqlInsert("prosic_comprobante", $fields, $values);
        return $retornar;
    }

    function update_registro_comprobante($fields, $values, $id, $value) {
        $retornar = $this->sqlUpdate("prosic_comprobante", $fields, $values, $id, $value);
        return $retornar;
    }	
	function cargar_operaciones_compras() {
        $sql = "SELECT * FROM prosic_operacion where id_operacion in(5,6,7,8)";
        return $sql;
    }

    function cargar_operaciones_ventas() {
        $sql = "SELECT * FROM prosic_operacion where id_operacion in(1,2,3,4)";
        return $sql;
    }

    /**
     * Sistema Prosic
     * Function para capturar el maximo del nro correlativo pasando los parametros
     * de SUBDIARIO-MES-A�O-LOCAL DE EMPRESA
     * @package		Prosic
     * @author		Rommel Mercado
     * @copyright	Copyright 2011
     * @license		Rommel Mercado
     * @since		Version 1.0
     * @filesource
     */
	 
    function get_correlativo_voucher($is, $im, $ia, $il) {
        $sql = "SELECT	MAX(correlativo) FROM prosic_correlativo WHERE id_subdiario=" . $is . " AND id_mes=" . $im . " AND id_anio = " . $ia . " AND id_local= " . $il;
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
        $retornar = $this->sqlInsert("prosic_correlativo", $fields, $values);
        return $retornar;
    }

    /**
     * Sistema Prosic
     * Function para Cargar los Registros de Compras por Id - Modificacion
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function cargar_data_registro_compra($nombre_anio='', $nombre_mes='', $nrocomprobante='', $limit='') {
        $ord = " ORDER BY prosic_comprobante.id_anio , prosic_comprobante.id_mes DESC,prosic_comprobante.codigo_comprobante*1000 desc";
        $sql = "SELECT
                prosic_comprobante.id_comprobante
                , prosic_comprobante.codigo_comprobante
                , prosic_comprobante.emision_comprobante
                , prosic_comprobante.total_comprobante
                , prosic_comprobante.status_comprobante
                , prosic_anexo.codigo_anexo
                , prosic_anexo.descripcion_anexo
                , prosic_subdiario.id_subdiario
                , prosic_subdiario.codigo_subdiario
                , prosic_subdiario.nombre_subdiario
                , prosic_anio.nombre_anio
                , prosic_mes.nombre_mes
                , prosic_tipo_comprobante.codigo_tipo_comprobante
                , prosic_tipo_comprobante.nombre_tipo_comprobante
                ,prosic_comprobante.nro_comprobante
                ,prosic_comprobante.serie_comprobante
                ,prosic_moneda.codigo_moneda
                FROM
                prosic_comprobante
                INNER JOIN prosic_anexo
                    ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
                INNER JOIN prosic_mes
                    ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
                INNER JOIN prosic_anio
                    ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
                INNER JOIN prosic_subdiario
                    ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
                INNER JOIN prosic_tipo_comprobante
                    ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
                INNER JOIN prosic_plan_contable
                    ON (prosic_comprobante.id_plan_contable = prosic_plan_contable.id_plan_contable)
                    INNER JOIN prosic_moneda
                    ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
                                    WHERE prosic_comprobante.id_subdiario=3 ";
        if ($nombre_anio != '')$sql.=" AND prosic_anio.nombre_anio='" . $nombre_anio . "'";
        if ($nombre_mes != '')$sql.=" AND prosic_mes.nombre_mes='" . $nombre_mes . "'";
        if ($nrocomprobante != '')$sql.=" AND prosic_comprobante.nro_comprobante like'%" . $nrocomprobante . "%' ";
        if ($ord != '')$sql.=$ord;
        if ($limit != '')$sql.=$limit;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    /**
     * Sistema Prosic
     * Function para Cargar los Registros de Ventas por Id - Modificacion
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function cargar_data_registro_venta($nombre_anio='', $nombre_mes='', $nrocomprobante='', $limit='') {
        $sql = "SELECT
    prosic_comprobante.id_comprobante
    , prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.status_comprobante
    , prosic_anexo.codigo_anexo
    , prosic_subdiario.id_subdiario
    , prosic_subdiario.codigo_subdiario
    , prosic_subdiario.nombre_subdiario
    , prosic_anio.nombre_anio
    , prosic_mes.nombre_mes
    , prosic_tipo_comprobante.codigo_tipo_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    ,prosic_comprobante.nro_comprobante
    ,prosic_moneda.codigo_moneda
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo
        ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_mes
        ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
    INNER JOIN prosic_anio
        ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
    INNER JOIN prosic_subdiario
        ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
    INNER JOIN prosic_tipo_comprobante
        ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
    INNER JOIN prosic_plan_contable
        ON (prosic_comprobante.id_plan_contable = prosic_plan_contable.id_plan_contable)
        INNER JOIN prosic_moneda
        ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
			WHERE prosic_comprobante.id_subdiario=2 ";
        if ($nombre_anio != ''
            )$sql.=" AND prosic_anio.nombre_anio='" . $nombre_anio . "'";
        if ($nombre_mes != ''
            )$sql.=" AND prosic_mes.nombre_mes='" . $nombre_mes . "'";
        if ($nrocomprobante != ''
            )$sql.=" AND prosic_comprobante.nro_comprobante like'%" . $nrocomprobante . "%' ";
        if ($limit != ''
            )$sql.=$limit;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    /**
     * Sistema Prosic
     * Function para Cargar los Registros de Ventas por Id - Modificacion
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function cargar_registro_venta_id($id) {
        return true;
    }
	
    /**
     * Sistema Prosic
     * Function para Cargar Cuenta de Gastos
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function cargar_cuenta_de_gastos($buscar='') {
        if($buscar==''){
            $sql = "SELECT id_plan_contable,cuenta_plan_contable,descripcion_plan_contable,cargar_plan_contable,abonar_plan_contable,transferencia_plan_contable FROM prosic_plan_contable WHERE cuenta_plan_contable LIKE '3%' OR cuenta_plan_contable LIKE '6%' ORDER BY cuenta_plan_contable";
        }else{
            $sql = "SELECT id_plan_contable,cuenta_plan_contable,descripcion_plan_contable,cargar_plan_contable,abonar_plan_contable,transferencia_plan_contable FROM prosic_plan_contable WHERE cuenta_plan_contable LIKE '".$buscar."%' ORDER BY cuenta_plan_contable";
        }
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    /**
     * Sistema Prosic
     * Function para Cargar Cuenta de Gastos
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function cargar_cuenta_de_costo() {
        $sql = "SELECT id_plan_contable,cuenta_plan_contable,descripcion_plan_contable,cargar_plan_contable,abonar_plan_contable,transferencia_plan_contable FROM prosic_plan_contable WHERE cuenta_plan_contable LIKE '9%' ORDER BY cuenta_plan_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    /**
     * Sistema Prosic
     * Function para Cargar Cuenta de Gastos
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function cargar_cuenta_de_ingreso() {
        $sql = "SELECT id_plan_contable,cuenta_plan_contable,descripcion_plan_contable,cargar_plan_contable,abonar_plan_contable,transferencia_plan_contable FROM prosic_plan_contable WHERE cuenta_plan_contable LIKE '7%' ORDER BY cuenta_plan_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    /**
     * Sistema Prosic
     * Function para Cargar Cuenta de Gastos
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function cargar_cuenta_banco($buscar='') {
        if($buscar==''){
            $sql = "SELECT id_plan_contable,cuenta_plan_contable,descripcion_plan_contable,cargar_plan_contable,abonar_plan_contable,transferencia_plan_contable FROM prosic_plan_contable ORDER BY cuenta_plan_contable";
        }else{
            $sql = "SELECT id_plan_contable,cuenta_plan_contable,descripcion_plan_contable,cargar_plan_contable,abonar_plan_contable,transferencia_plan_contable FROM prosic_plan_contable WHERE cuenta_plan_contable LIKE '".$buscar."%' ORDER BY cuenta_plan_contable";
        }
        
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
    /**
     * Sistema Prosic
     * Function para Cargar Cuenta de Gastos
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function buscar_cuenta_por_codigo($cuenta) {
        $sql = "SELECT id_plan_contable,descripcion_plan_contable FROM prosic_plan_contable WHERE cuenta_plan_contable = '" . $cuenta . "'";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    /**
     * Sistema Prosic
     * Function para Cargar Cuenta de Gastos
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function buscar_cuenta_por_id($id) {
        $sql = "SELECT cuenta_plan_contable,descripcion_plan_contable FROM prosic_plan_contable WHERE id_plan_contable = " . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_array($result);
        return $row;
    }

    /**
     * Sistema Prosic
     * Function para Cargar Cuenta de Gastos
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function insertar_detalle_comprobante($fields, $values) {
        $retornar = $this->sqlInsert("prosic_detalle_comprobante", $fields, $values);
        return $retornar;
    }

    /**
     * Sistema Prosic
     * Function para Consultar la Cabecera del Comprobante
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function consultar_comprobante_cabecera($id) {
        $sql = "SELECT
		     prosic_comprobante.id_comprobante
		    , prosic_comprobante.codigo_comprobante
		    , prosic_comprobante.emision_comprobante
		    , prosic_comprobante.afecto_comprobante
		    , prosic_comprobante.inafecto_comprobante
		    , prosic_comprobante.total_comprobante
		    , prosic_comprobante.igv_comprobante
		    , prosic_comprobante.isc_comprobante    
		    , prosic_comprobante.tipo_cambio_comprobante
		    , prosic_comprobante.id_anexo
		    , prosic_comprobante.id_tipo_comprobante
		    , prosic_comprobante.nro_comprobante
            , prosic_comprobante.serie_comprobante
		    , prosic_subdiario.id_subdiario
		    , prosic_subdiario.codigo_subdiario
		    , prosic_subdiario.nombre_subdiario
		    , prosic_moneda.id_moneda
		    , prosic_moneda.nombre_moneda
		    , prosic_moneda.codigo_moneda
		    , prosic_anio.nombre_anio
		    , prosic_mes.nombre_mes
            , prosic_anio.id_anio
		    , prosic_mes.id_mes
		    , prosic_anexo.codigo_anexo
		    , prosic_anexo.descripcion_anexo
		    , prosic_tipo_comprobante.codigo_tipo_comprobante
		    , prosic_tipo_comprobante.nombre_tipo_comprobante
		    , prosic_comprobante.id_plan_contable
		    , prosic_plan_contable.cuenta_plan_contable
		    , prosic_comprobante.cuenta_costo    
		    , prosic_comprobante.cargo_abono		    
		    , prosic_comprobante.cuenta_banco
		    , prosic_comprobante.c_a_cuenta_banco            
		    , prosic_comprobante.detalle_comprobante
			, prosic_banco.id_banco
			, prosic_comprobante.id_medio_pago
		FROM  prosic_comprobante
	    INNER JOIN prosic_mes		        ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
	    INNER JOIN prosic_anio		        ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
	    INNER JOIN prosic_subdiario	        ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
	    INNER JOIN prosic_moneda	        ON (prosic_comprobante.id_moneda = prosic_moneda.id_moneda)
	    INNER JOIN prosic_anexo		        ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
	    INNER JOIN prosic_tipo_comprobante  ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
	    LEFT JOIN prosic_plan_contable      ON (prosic_comprobante.id_plan_contable = prosic_plan_contable.id_plan_contable)
		LEFT JOIN  prosic_banco             ON (prosic_comprobante.cuenta_banco = prosic_banco.id_plan_contable)
		    WHERE prosic_comprobante.id_comprobante=" . $id . "";

		$result = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($result);

        $this->valor_afecto = $row['afecto_comprobante'];
        $this->valor_inafecto = $row['inafecto_comprobante'];
        $this->valor_isc = $row['isc_comprobante'];
        $this->valor_igv = $row['igv_comprobante'];
        $this->valor_total = $row['total_comprobante'];
        $this->subdiario = $row['id_subdiario'];
        $this->tipo_cambio = $row['tipo_cambio_comprobante'];
        $this->moneda = $row['id_moneda'];
        $this->codigo_moneda = $row['codigo_moneda'];

        if ($row['id_subdiario'] == 3 || $row['id_subdiario'] == 10) {
            $this->cuenta_costo = $row['cuenta_costo'];
            $row_costo = $this->buscar_cuenta_por_id($row['cuenta_costo']);
            $this->nombre_cuenta_costo = $row_costo[0];
        } elseif ($row['id_subdiario'] == 2) {
            $this->cuenta_costo = 0;
            $this->nombre_cuenta_costo = "";
        }
        $this->id_comprobante = $row['id_comprobante'];
        $this->id_anexo = $row['id_anexo'];
        $this->codigo_anexo = $row['codigo_anexo'];
        $this->id_tipo_comprobante = $row['id_tipo_comprobante'];
        $this->codigo_tipo_comprobante = $row['codigo_tipo_comprobante'];
        $this->nro_comprobante = $row['nro_comprobante'];
        $this->emision_comprobante = $row['emision_comprobante'];
        $this->detalle_comprobante = $row['detalle_comprobante'];
        $this->serie_comprobante = $row['serie_comprobante'];

        $l_afecto = 0; 
        $l_inafecto = 0;
        $l_isc = 0;
        $l_igv = 0;

        if(is_null($row['afecto_comprobante']))$l_afecto = 1;
        if(is_null($row['inafecto_comprobante']))$l_inafecto = 1;
        if(is_null($row['isc_comprobante']))$l_isc = 1;
        if(is_null($row['igv_comprobante']))$l_igv = 1;

        if($row['afecto_comprobante']==0.00)$l_afecto = 1;
        if($row['inafecto_comprobante']==0.00)$l_inafecto = 1;
        if($row['isc_comprobante']==0.00)$l_isc = 1;
        if($row['igv_comprobante']=="0.00")$l_igv = 1;

        if ($row['id_subdiario'] == 2) {//Subdiario de Ventas
            if ($l_isc == 0) {
                //cargar isc
                $result = $this->buscar_cuenta_por_codigo("40105");
                $row_cuenta = @mysql_fetch_array($result);
                $id_cuenta = $row_cuenta[0];
                $codigo_cuenta = "40105";
                $tipo = "A";
                $monto = $row['isc_comprobante'];
                $this->arreglo_isc = $this->cargar_sub_cuenta($id_cuenta, $codigo_cuenta, $tipo, $monto);
            }
            if ($l_igv == 0) {
                //cargar igv
                $codigo_cuenta = $this->consulta_cuenta_prosic_automatico(1);
                $result = $this->buscar_cuenta_por_codigo($codigo_cuenta);
                $row_cuenta = mysql_fetch_array($result);
                $id_cuenta = $row_cuenta[0];
                $tipo = "A";
                $monto = $row['igv_comprobante'];
                $this->arreglo_igv = $this->cargar_sub_cuenta($id_cuenta, $codigo_cuenta, $tipo, $monto);
            }
            if ($l_inafecto == 0) {
                //cargar inafecto
                $id_cuenta = $row['id_plan_contable'];
                $codigo_cuenta = $row['cuenta_plan_contable'];
                $tipo = "A";
                $monto = $row['inafecto_comprobante'];
                $this->arreglo_inafecto = $this->cargar_sub_cuenta($id_cuenta, $codigo_cuenta, $tipo, $monto);
            }
            if ($l_afecto == 0) {
                $this->arreglo_afecto = $this->cargar_sub_cuenta($row['id_plan_contable'], $row['cuenta_plan_contable'], "A", $row['afecto_comprobante']);
            }
            //cargando el Total
			if($row['id_moneda']==1){
                $codigo_cuenta = $this->consulta_cuenta_prosic_automatico(2);
			}else{
                $codigo_cuenta = $this->consulta_cuenta_prosic_automatico(3);
			}
            $result = $this->buscar_cuenta_por_codigo($codigo_cuenta);
            $row_cuenta = mysql_fetch_array($result);
            $id_cuenta = $row_cuenta[0];
            $tipo = "C";
            $monto = $row['total_comprobante'];
            $this->arreglo_total = $this->cargar_sub_cuenta($id_cuenta, $codigo_cuenta, $tipo, $monto);
        } elseif ($row['id_subdiario'] == 3) {//Subdiario de Compras
            if ($l_isc == 0) {
                //cargar isc
                $result = $this->buscar_cuenta_por_codigo("40105");
                $row_cuenta = mysql_fetch_array($result);
                $id_cuenta = $row_cuenta[0];
                $codigo_cuenta = "40105";
                $tipo = "C";
                $monto = $row['isc_comprobante'];
                $this->arreglo_isc = $this->cargar_sub_cuenta($id_cuenta, $codigo_cuenta, $tipo, $monto);
            }
            if ($l_igv == 0) {
                //cargar igv
                $codigo_cuenta = $this->consulta_cuenta_prosic_automatico(1);
                $result = $this->buscar_cuenta_por_codigo($codigo_cuenta);
                $row_cuenta = mysql_fetch_array($result);
                $id_cuenta = $row_cuenta[0];
                $tipo = "C";
                $monto = $row['igv_comprobante'];
                $this->arreglo_igv = $this->cargar_sub_cuenta($id_cuenta, $codigo_cuenta, $tipo, $monto);
            }
            if ($l_inafecto == 0) {
                //cargar inafecto
                $id_cuenta = $row['id_plan_contable'];
                $codigo_cuenta = $row['cuenta_plan_contable'];
                $tipo = "C";
                $monto = $row['inafecto_comprobante'];
                $this->arreglo_inafecto = $this->cargar_sub_cuenta($id_cuenta, $codigo_cuenta, $tipo, $monto);
           }
            if ($l_afecto == 0) {
               $this->arreglo_afecto = $this->cargar_sub_cuenta($row['id_plan_contable'], $row['cuenta_plan_contable'], "C", $row['afecto_comprobante']);
           }
            //cargando el Total
			if($row['id_moneda']==1){
                $codigo_cuenta = $this->consulta_cuenta_prosic_automatico(4);
			}else{
                $codigo_cuenta = $this->consulta_cuenta_prosic_automatico(5);
			}
            $result = $this->buscar_cuenta_por_codigo($codigo_cuenta);
            $row_cuenta = mysql_fetch_array($result);
            $id_cuenta = $row_cuenta[0];
            $tipo = "A";
            $monto = $row['total_comprobante'];
            $this->arreglo_total = $this->cargar_sub_cuenta($id_cuenta, $codigo_cuenta, $tipo, $monto);
        }## FIN DEL ELSE IF SUBDIARIO 3
        elseif ($row['id_subdiario'] == 8) {//Subdiario de BANCOS
            ##CARGADO LA CUENTA DE BANCOS
            $row_cuenta = $this->buscar_cuenta_por_id($row['cuenta_banco']);
            $id_cuenta = $row['cuenta_banco'];
            $codigo_cuenta = $row_cuenta[0];
            $tipo = $row['c_a_cuenta_banco'];
            $monto = $row['total_comprobante'];
            $this->arreglo_banco = $this->cargar_sub_cuenta($id_cuenta, $codigo_cuenta, $tipo, $monto);

            ##CARGADO LA CUENTA DE INGRESO EGRESOS
            $id_cuenta = $row['id_plan_contable'];
            $codigo_cuenta = $row['cuenta_plan_contable'];
            $tipo = $row['cargo_abono'];
            $monto = $row['total_comprobante'];
            $this->arreglo_ingreso_egreso = $this->cargar_sub_cuenta($id_cuenta, $codigo_cuenta, $tipo, $monto);
        }

        return $row;
    }
## FIN DE LA FUNCION

// Copyright: Oscar Alanya
function llenar_detalle_egreso($id_com){
	$sql = "SELECT 
	prosic_detalle_comprobante.id_comprobante
	, prosic_detalle_comprobante.tipo_digito
	, prosic_detalle_comprobante.id_plan_contable
	, prosic_plan_contable.cuenta_plan_contable
	, prosic_detalle_comprobante.cargar_abonar
	, prosic_detalle_comprobante.importe_soles
	, prosic_detalle_comprobante.importe_dolares
	, prosic_detalle_comprobante.id_anexo
	, prosic_anexo.codigo_anexo
	, prosic_detalle_comprobante.id_tipo_comprobante
	, prosic_tipo_comprobante.codigo_tipo_comprobante
	, prosic_detalle_comprobante.nro_doc_comprobante
	, prosic_detalle_comprobante.fecha_doc_comprobante
	, prosic_detalle_comprobante.id_moneda
	, prosic_moneda.codigo_moneda
	, prosic_comprobante.cuenta_costo
	, prosic_comprobante.detalle_comprobante
	, prosic_detalle_comprobante.ser_doc_comprobante
	FROM prosic_detalle_comprobante
	INNER JOIN prosic_comprobante ON ( prosic_detalle_comprobante.id_comprobante = prosic_comprobante.id_comprobante )
	INNER JOIN prosic_plan_contable ON ( prosic_detalle_comprobante.id_plan_contable = prosic_plan_contable.id_plan_contable)
	INNER JOIN prosic_anexo ON (prosic_detalle_comprobante.id_anexo = prosic_anexo.id_anexo )
	INNER JOIN prosic_tipo_comprobante ON (prosic_detalle_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante )
	INNER JOIN prosic_moneda ON (prosic_detalle_comprobante.id_moneda = prosic_moneda.id_moneda )
	WHERE prosic_detalle_comprobante.tipo_digito ='D'
	  AND prosic_comprobante.id_comprobante= " . $id_com ." ";
        $result = $this->Consulta_Mysql($sql);
        return $result;
}

//llenar_al_migrar

function get_codigo_tipo_comprobante($id){
$sql="SELECT codigo_tipo_comprobante FROM prosic_tipo_comprobante where id_tipo_comprobante = " . $id . " ";
$result = $this->Consulta_Mysql($sql);
return $result;
}

function get_id_anexo($cod){
$sql="SELECT prosic_anexo.id_anexo FROM prosic_anexo where prosic_anexo.codigo_anexo = " . $cod . " ";
$result = $this->Consulta_Mysql($sql);
return $result;
}

function get_id_cuenta($cuenta){
$sql="SELECT prosic_plan_contable.id_plan_contable FROM prosic_plan_contable where prosic_plan_contable.cuenta_plan_contable = " . $cuenta . " ";
$result = $this->Consulta_Mysql($sql);
return $result;
}

function llenar_al_migrar($codigo_anexo, $id_tipo_comprobante, $serie_comprobante, $nro_comprobante){
	$sql = "SELECT alm0012010.alm0010010
          , alm0012010.alm0010011
          , alm0012010.alm0010012
          , alm0012010.alm0010013
          , alm0012010.alm0010006
       FROM alm0012010
	  WHERE alm0012010.alm0010005= " . $codigo_anexo ." AND alm0012010.alm0010007= " . $id_tipo_comprobante . " AND alm0012010.alm0010008= " . $serie_comprobante ." AND alm0012010.alm0010009= " . $nro_comprobante . " ";
        $result = $this->Consulta_Mysql($sql);
        return $result;
}

function get_cuenta($num){
$sql="SELECT alm0020000
,alm0020001
,alm0020002
,alm0020003
,alm0020004
,alm0020005
,alm0020006
,alm0020007
,alm0020008
,alm0020009
,tab0090004 
,tab0090010 
,prosic_plan_contable.descripcion_plan_contable
FROM alm0022010 INNER JOIN tab0090000 ON (alm0022010.alm0020005=tab0090000.tab0090004) 
INNER JOIN prosic_plan_contable ON (tab0090000.tab0090010=prosic_plan_contable.cuenta_plan_contable)
WHERE alm0020004 = " . $num . " ORDER BY alm0020000 ASC";
$result = $this->Consulta_Mysql($sql);
return $result;
}

function get_tipo_cambio($fecha){
$sql = "SELECT venta_sunat from prosic_tipo_cambio where fecha_tipo_cambio = '".$fecha."'";
$result = $this->Consulta_Mysql($sql);
return $result;
}


    function cargar_sub_cuenta($id_cuenta, $codigo_cuenta, $tipo, $monto) {
        //Realizando el tipo de Cambio
        if ($this->moneda == 1) {
            $numero = $monto / $this->tipo_cambio;
            $importe_dolares = number_format($numero, 2, '.', '');
            $importe_soles = $monto;
        } elseif ($this->moneda == 2) {
            $importe_soles = $monto * $this->tipo_cambio;
            $importe_dolares = $monto;
        }
        $datos_enviar[] = $this->id_comprobante;
        $datos_enviar[] = "D";
        $datos_enviar[] = $id_cuenta;
        $datos_enviar[] = $codigo_cuenta;
        $datos_enviar[] = $tipo;
        $datos_enviar[] = $importe_soles;
        $datos_enviar[] = $importe_dolares;
        $datos_enviar[] = $this->id_anexo;
        $datos_enviar[] = $this->codigo_anexo;
        $datos_enviar[] = $this->id_tipo_comprobante;
        $datos_enviar[] = $this->codigo_tipo_comprobante;
        $datos_enviar[] = $this->nro_comprobante;
        $datos_enviar[] = $this->emision_comprobante;
        $datos_enviar[] = $this->moneda;
        $datos_enviar[] = $this->codigo_moneda;
        $datos_enviar[] = $this->cuenta_costo;
        $datos_enviar[] = $this->nombre_cuenta_costo;
        $datos_enviar[] = $this->detalle_comprobante;
        $datos_enviar[] = $this->serie_comprobante;

        return $datos_enviar;
    }

    /**
     * Sistema Prosic
     * Function para Consultar la Cabecera del Comprobante
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function consultar_comprobante_por_status($status, $id_subdiario, $where, $sort, $limit) {
        $sql = "SELECT
    prosic_comprobante.id_comprobante
    , prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.status_comprobante
    , prosic_anexo.codigo_anexo
    , prosic_subdiario.id_subdiario
    , prosic_subdiario.codigo_subdiario
    , prosic_subdiario.nombre_subdiario
    , prosic_anio.nombre_anio
    , prosic_mes.nombre_mes
    , prosic_tipo_comprobante.codigo_tipo_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    ,prosic_comprobante.nro_comprobante
    ,prosic_moneda.codigo_moneda
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo
        ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_mes
        ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
    INNER JOIN prosic_anio
        ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
    INNER JOIN prosic_subdiario
        ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
    INNER JOIN prosic_tipo_comprobante
        ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)    
        INNER JOIN prosic_moneda
        ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
	WHERE prosic_comprobante.status_comprobante ='" . $status . "' AND prosic_subdiario.id_subdiario=" . $id_subdiario . " $where $short $limit";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consultar_comprobante_por_periodo($id_subdiario, $anio, $mes, $where, $sort, $limit) {
        $sql = "SELECT
    prosic_comprobante.id_comprobante
    , prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.status_comprobante
    , prosic_anexo.codigo_anexo
    , prosic_subdiario.id_subdiario
    , prosic_subdiario.codigo_subdiario
    , prosic_subdiario.nombre_subdiario
    , prosic_anio.nombre_anio
    , prosic_mes.nombre_mes
    , prosic_tipo_comprobante.codigo_tipo_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    ,prosic_comprobante.nro_comprobante
    ,prosic_moneda.codigo_moneda
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo
        ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_mes
        ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
    INNER JOIN prosic_anio
        ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
    INNER JOIN prosic_subdiario
        ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
    INNER JOIN prosic_tipo_comprobante
        ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
    INNER JOIN prosic_plan_contable
        ON (prosic_comprobante.id_plan_contable = prosic_plan_contable.id_plan_contable)
        INNER JOIN prosic_moneda
        ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
        WHERE prosic_subdiario.id_subdiario=" . $id_subdiario . " AND
        prosic_comprobante.id_mes=" . $mes . " AND prosic_comprobante.id_anio=" . $anio . " $where $short $limit";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    /**
     * Sistema Prosic
     * Function para Actualizar el Status de Un Comprobante pasando el Id del Comprobante
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function actualizar_status_comprobante($id, $status) {
        $sql = "UPDATE prosic_comprobante set status_comprobante='" . $status . "' where id_comprobante = " . $id;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function cargar_data_tipo_cambio($where='', $short='', $limit='') {
        $ord = " ORDER BY prosic_tipo_cambio.fecha_tipo_cambio DESC";
        $sql = "SELECT
		    prosic_tipo_cambio.id_tipo_cambio
		    , prosic_anio.codigo_anio
		    , prosic_anio.nombre_anio
		    , prosic_mes.codigo_mes
		    , prosic_tipo_cambio.dia_tipo_cambio
		    , prosic_tipo_cambio.fecha_tipo_cambio
		    , prosic_tipo_cambio.compra_sunat
		    , prosic_tipo_cambio.venta_sunat
		    , prosic_tipo_cambio.compra_financiero
		    , prosic_tipo_cambio.venta_financiero
		    
		FROM
		    prosic_tipo_cambio
		    INNER JOIN prosic_anio 
		        ON (prosic_tipo_cambio.id_anio = prosic_anio.id_anio)
		    INNER JOIN prosic_mes 
		        ON (prosic_tipo_cambio.id_mes = prosic_mes.id_mes) $where $short ";
        if ($ord != ''
            )$sql.=$ord;
        if ($limit != ''
            )$sql.=$limit;

        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consultar_data_tipo_cambio($where, $short, $limit) {
        $sql = "SELECT
		    prosic_tipo_cambio.id_tipo_cambio
		    , prosic_anio.codigo_anio
		    , prosic_mes.codigo_mes
		    , prosic_tipo_cambio.dia_tipo_cambio
		    , prosic_tipo_cambio.fecha_tipo_cambio
		    , prosic_tipo_cambio.compra_sunat
		    , prosic_tipo_cambio.venta_sunat
		    , prosic_tipo_cambio.compra_financiero
		    , prosic_tipo_cambio.venta_financiero
		    
		FROM
		    prosic_tipo_cambio
		    INNER JOIN prosic_anio 
		        ON (prosic_tipo_cambio.id_anio = prosic_anio.id_anio)
		    INNER JOIN prosic_mes 
		        ON (prosic_tipo_cambio.id_mes = prosic_mes.id_mes) $where $short $limit";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    /**
     * Sistema Prosic
     * Function Insertar Registro de Compras
     * @package		Prosic
     * @author		Rommel Mercado
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function insertar_tipo_cambio($fields, $values) {
        $retornar = $this->sqlInsert("prosic_tipo_cambio", $fields, $values);
        return $retornar;
    }

    function update_tipo_cambio($fields, $values, $id, $value) {
        $retornar = $this->sqlUpdate("prosic_tipo_cambio", $fields, $values, $id, $value);
        return $retornar;
    }

    function cargar_tipo_cambio_id($id) {
        $sql = "SELECT * FROM prosic_tipo_cambio WHERE id_tipo_cambio = " . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    /**
     * Sistema Prosic
     * Function Imprimir la Cabecera del Comprobante para Reportes
     * @package		Prosic
     * @author		Rommel Mercado
     * @copyright	Copyright 2011
     * @license		Rommel Mercado
     * @since		Version 1.0
     * @filesource
     */
    function imprimir_cabecera_comprobante($id) {
        $sql = "SELECT
				    prosic_comprobante.id_comprobante
				    , prosic_comprobante.codigo_comprobante
				    , prosic_comprobante.emision_comprobante
				    , prosic_comprobante.serie_comprobante
				    , prosic_comprobante.nro_comprobante
				    , prosic_comprobante.total_comprobante
				    , prosic_comprobante.glosa_comprobante
					, prosic_comprobante.tipo_cambio_comprobante
				    , prosic_anexo.descripcion_anexo
				    , prosic_anexo.codigo_anexo
					, prosic_comprobante.id_moneda
				    , prosic_moneda.nombre_moneda
				    , prosic_tipo_comprobante.nombre_tipo_comprobante
					, prosic_tipo_comprobante.codigo_tipo_comprobante
				    , prosic_local.id_empresa
				    , prosic_empresa.nombre_empresa
				    , prosic_empresa.ruc_empresa
				    , prosic_local.direccion_local
					, prosic_comprobante.id_subdiario
					, prosic_subdiario.nombre_subdiario
					, prosic_banco.nombre_banco
					, prosic_banco.nro_cuenta_banco
			FROM  prosic_comprobante
			INNER JOIN prosic_anexo 			ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
			INNER JOIN prosic_moneda 			ON (prosic_comprobante.id_moneda = prosic_moneda.id_moneda)
			INNER JOIN prosic_tipo_comprobante 	ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
			INNER JOIN prosic_local 			ON (prosic_comprobante.id_local = prosic_local.id_local)
			INNER JOIN prosic_empresa 			ON (prosic_local.id_empresa = prosic_empresa.id_empresa)
			INNER JOIN prosic_subdiario			ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
			LEFT JOIN  prosic_banco             ON (prosic_comprobante.cuenta_banco = prosic_banco.id_plan_contable)
			WHERE prosic_comprobante.id_comprobante=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    /**
     * Sistema Prosic
     * Function Imprimir la Cabecera del Comprobante para Reportes
     * @package		Prosic
     * @author		Rommel Mercado
     * @copyright	Copyright 2011
     * @license		Rommel Mercado
     * @since		Version 1.0
     * @filesource
     */
    function imprimir_comprobante_detalle($id) {
        $sql = "SELECT
		      prosic_tipo_comprobante.nombre_tipo_comprobante
		    , prosic_tipo_comprobante.sunat_tipo_comprobante
		    , prosic_detalle_comprobante.ser_doc_comprobante
		    , prosic_detalle_comprobante.nro_doc_comprobante
		    , prosic_detalle_comprobante.fecha_doc_comprobante
		    , prosic_moneda.codigo_moneda
		    , prosic_plan_contable.cuenta_plan_contable
		    , prosic_plan_contable.descripcion_plan_contable
		    , prosic_detalle_comprobante.cargar_abonar
		    , prosic_detalle_comprobante.importe_dolares
		    , prosic_detalle_comprobante.importe_soles
				    , prosic_anexo.descripcion_anexo
				    , prosic_anexo.codigo_anexo
		FROM
		    prosic_detalle_comprobante
		    INNER JOIN prosic_plan_contable     ON (prosic_detalle_comprobante.id_plan_contable = prosic_plan_contable.id_plan_contable)
		    INNER JOIN prosic_tipo_comprobante 	ON (prosic_detalle_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
		    INNER JOIN prosic_moneda 			ON (prosic_detalle_comprobante.id_moneda = prosic_moneda.id_moneda)
			LEFT  JOIN prosic_anexo 			ON (prosic_detalle_comprobante.id_anexo = prosic_anexo.id_anexo)
		       WHERE prosic_detalle_comprobante.id_comprobante=" . $id." and prosic_detalle_comprobante.tipo_digito='D'  
			   ORDER BY cargar_abonar desc, cuenta_plan_contable, ser_doc_comprobante, nro_doc_comprobante";
        $result = $this->Consulta_Mysql($sql);
        $datos = array();
        while ($fila = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $datos[] = $fila;
        }
        return $datos;
    }

    /**
     * Sistema Prosic
     * Function Imprimir la Cabecera del Comprobante para Reportes
     * @package		Prosic
     * @author		Rommel Mercado
     * @copyright	Copyright 2011
     * @license		Rommel Mercado
     * @since		Version 1.0
     * @filesource
     */
    function consulta_datos_empresa($id) {
        $sql = "SELECT nombre_empresa,ruc_empresa FROM prosic_empresa WHERE id_empresa=" . $id;
        $sql = "SELECT nombre_empresa,ruc_empresa FROM prosic_empresa WHERE id_empresa=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_array($result);
        return $row;
    }

    function consulta_libro_mayor($w_anio, $w_mes, $w_anexo) {
        $sql = "SELECT
                    prosic_comprobante.id_anio
		    , prosic_comprobante.id_mes
		    , prosic_plan_contable.cuenta_plan_contable
		    , prosic_detalle_comprobante.cargar_abonar
		    , sum(prosic_detalle_comprobante.importe_dolares)
		    , sum(prosic_detalle_comprobante.importe_soles)
		FROM  prosic_detalle_comprobante
             INNER  JOIN prosic_comprobante   ON (prosic_detalle_comprobante.id_comprobante = prosic_comprobante.id_comprobante)
             INNER  JOIN prosic_plan_contable ON (prosic_detalle_comprobante.id_plan_contable = prosic_plan_contable.id_plan_contable) 
		WHERE NOT prosic_comprobante.id_subdiario=1";
    if ($w_anio != '')$sql.=" AND prosic_comprobante.id_anio=" . $w_anio;
    if ($w_mes != '')$sql.=" AND prosic_comprobante.id_mes=" . $w_mes;
    if ($w_anexo != '')$sql.=" AND prosic_comprobante.id_anexo='" . $w_anexo . "'";
    $sql.=" GROUP BY prosic_comprobante.id_anio, prosic_comprobante.id_mes, prosic_plan_contable.cuenta_plan_contable, prosic_detalle_comprobante.cargar_abonar";
    $result = $this->Consulta_Mysql($sql);
    return $result;
    }
    function consulta_libro_mayor_subdiario($w_anio, $w_mes, $w_anexo, $w_subdiario) {
        $sql = "SELECT
                    prosic_comprobante.id_anio
		    , prosic_comprobante.id_mes
		    , prosic_plan_contable.cuenta_plan_contable
		    , prosic_detalle_comprobante.cargar_abonar
		    , sum(prosic_detalle_comprobante.importe_dolares)
		    , sum(prosic_detalle_comprobante.importe_soles)
		FROM  prosic_detalle_comprobante
             INNER  JOIN prosic_comprobante   ON (prosic_detalle_comprobante.id_comprobante = prosic_comprobante.id_comprobante)
             INNER  JOIN prosic_plan_contable ON (prosic_detalle_comprobante.id_plan_contable = prosic_plan_contable.id_plan_contable)
		WHERE prosic_comprobante.id_subdiario=" . $w_subdiario;
			 if ($w_anio != '')$sql.=" AND prosic_comprobante.id_anio=" . $w_anio;
    if ($w_mes != '')$sql.=" AND prosic_comprobante.id_mes=" . $w_mes;
    if ($w_anexo != '')$sql.=" AND prosic_comprobante.id_anexo='" . $w_anexo . "'";
    $sql.=" GROUP BY prosic_comprobante.id_anio, prosic_comprobante.id_mes, prosic_plan_contable.cuenta_plan_contable, prosic_detalle_comprobante.cargar_abonar";
    $result = $this->Consulta_Mysql($sql);
    return $result;
    }

    function cargar_plan_mayor($w_anio='') {
        $sql = "SELECT prosic_plan_contable.cuenta_plan_contable
                  FROM prosic_plan_contable 
                 WHERE NOT prosic_plan_contable.cuenta_plan_contable in ( Select id_cuenta_contable from prosic_mayor ) ";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function cargar_plan_mayordolar($w_anio='') {
        $sql = "SELECT prosic_plan_contable.cuenta_plan_contable
                  FROM prosic_plan_contable 
                 WHERE NOT prosic_plan_contable.cuenta_plan_contable in ( Select id_cuenta_contable from prosic_mayor_dolares ) ";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    /**
     * Sistema Prosic
     * Function Imprimir Registro de Compras
     * @copyright	Copyright 2011
     * @license	Pedro Pacherres
     * @since		Version 1.0
     */
    function consulta_registro_compras_imprimir($w_anio, $w_mes, $w_anexo) {
    $sql = "SELECT
      prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.pago_comprobante
    , prosic_tipo_comprobante.sunat_tipo_comprobante
    , prosic_comprobante.serie_comprobante
    , prosic_comprobante.anio_dua_comprobante
    , prosic_comprobante.nro_comprobante
    , prosic_tipo_documento.sunat_tipo_documento
    , prosic_anexo.codigo_anexo
    , SUBSTRING(prosic_anexo.descripcion_anexo,1,20)
    , prosic_comprobante.afecto_comprobante
    , prosic_comprobante.inafecto_comprobante
    , prosic_comprobante.igv_comprobante
    , prosic_comprobante.total_comprobante 	
    , prosic_comprobante.id_operacion
    , prosic_comprobante.no_gravadas_igv
    , prosic_comprobante.inafecto_comprobante
    , prosic_comprobante.isc_comprobante
    , prosic_comprobante.otros_tributos
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.tipo_cambio_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    , prosic_comprobante.id_moneda
	, prosic_comprobante.referencia_fecha
	, prosic_comprobante.referencia_serie
	, prosic_comprobante.referencia_nro
	, prosic_comprobante.referecia_tipo_doc
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo             ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_tipo_comprobante  ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
    INNER JOIN prosic_tipo_documento    ON (prosic_anexo.id_tipo_documento = prosic_tipo_documento.id_tipo_documento)
    WHERE prosic_comprobante.id_subdiario=3";
    if ($w_anio != '')$sql.=" AND prosic_comprobante.id_anio=" . $w_anio;
    if ($w_mes != '')$sql.=" AND prosic_comprobante.id_mes=" . $w_mes;
    if ($w_anexo != '')$sql.=" AND prosic_comprobante.id_anexo='" . $w_anexo . "'";
    $sql.=" ORDER BY prosic_tipo_comprobante.sunat_tipo_comprobante,prosic_comprobante.codigo_comprobante";
    $result = $this->Consulta_Mysql($sql);
    return $result;
    }

  /**
     * Sistema Prosic
     * Function Imprimir Registro de Compras Perzonalizado
     * @copyright	Copyright 2011
     * @license	Oz
     * @since		Version 1.0
     */
    function consulta_personalizada_registro_compras_imprimir($w_anio, $w_mes, $w_anexo) {
    $sql = "SELECT
      prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.pago_comprobante
    , prosic_tipo_comprobante.sunat_tipo_comprobante
    , prosic_comprobante.serie_comprobante
    , prosic_comprobante.anio_dua_comprobante
    , prosic_comprobante.nro_comprobante
    , prosic_tipo_documento.sunat_tipo_documento
    , prosic_anexo.codigo_anexo
    , SUBSTRING(prosic_anexo.descripcion_anexo,1,20)
    , prosic_comprobante.afecto_comprobante
    , prosic_comprobante.inafecto_comprobante
    , prosic_comprobante.igv_comprobante
    , prosic_comprobante.total_comprobante 	
    , prosic_comprobante.id_operacion
    , prosic_comprobante.no_gravadas_igv
    , prosic_comprobante.inafecto_comprobante
    , prosic_comprobante.isc_comprobante
    , prosic_comprobante.otros_tributos
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.tipo_cambio_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    , prosic_comprobante.id_moneda
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo             ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_tipo_comprobante  ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
    INNER JOIN prosic_tipo_documento    ON (prosic_anexo.id_tipo_documento = prosic_tipo_documento.id_tipo_documento)
    WHERE prosic_comprobante.id_subdiario=3";
    if ($w_anio != '')$sql.=" AND prosic_comprobante.id_anio=" . $w_anio;
    if ($w_mes != '')$sql.=" AND prosic_comprobante.id_mes=" . $w_mes;
    if ($w_anexo != '')$sql.=" AND prosic_comprobante.id_anexo='" . $w_anexo . "'";
    $sql.=" ORDER BY CAST(prosic_comprobante.codigo_comprobante AS UNSIGNED),prosic_tipo_comprobante.sunat_tipo_comprobante";
    $result = $this->Consulta_Mysql($sql);
    return $result;
    }


    /**
     * Sistema Prosic
     * Function Imprimir la Cabecera del Comprobante para Reportes
     * @package		Prosic
     * @author		Rommel Mercado
     * @copyright	Copyright 2011
     * @license		Rommel Mercado
     * @since		Version 1.0
     * @filesource
     */

function consulta_registro_ventas_imprimir($w_anio, $w_mes, $w_anexo) {
     $sql = "SELECT
      prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.pago_comprobante
    , prosic_tipo_comprobante.sunat_tipo_comprobante
    , prosic_comprobante.serie_comprobante
    , prosic_comprobante.anio_dua_comprobante
    , prosic_comprobante.nro_comprobante
    , prosic_tipo_documento.sunat_tipo_documento
    , prosic_anexo.codigo_anexo
    , SUBSTRING(prosic_anexo.descripcion_anexo,1,20)
    , prosic_comprobante.afecto_comprobante
    , prosic_comprobante.inafecto_comprobante
    , prosic_comprobante.igv_comprobante
    , prosic_comprobante.total_comprobante 	
    , prosic_comprobante.id_operacion
    , prosic_comprobante.no_gravadas_igv
    , prosic_comprobante.inafecto_comprobante
    , prosic_comprobante.isc_comprobante
    , prosic_comprobante.otros_tributos
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.tipo_cambio_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    , prosic_comprobante.id_moneda
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo             ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_tipo_comprobante  ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
    INNER JOIN prosic_tipo_documento    ON (prosic_anexo.id_tipo_documento = prosic_tipo_documento.id_tipo_documento)
    WHERE prosic_comprobante.id_subdiario=2";
    if ($w_anio != '')$sql.=" AND prosic_comprobante.id_anio=" . $w_anio;
    if ($w_mes != '')$sql.=" AND prosic_comprobante.id_mes=" . $w_mes;
    if ($w_anexo != '')$sql.=" AND prosic_comprobante.id_anexo='" . $w_anexo . "'";
    $sql.=" ORDER BY prosic_tipo_comprobante.sunat_tipo_comprobante,CAST(prosic_comprobante.codigo_comprobante AS UNSIGNED)";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

function consulta_registro_ventas_local($w_anio, $w_mes, $tienda) {
	$w_anio=2000+$w_anio-1;

     $sql = "SELECT  status_mesa_pedido
    , prosic_caja.fecha_caja as emision_comprobante
    , prosic_caja.fecha_caja as pago_comprobante
    , prosic_tipo_comprobante.sunat_tipo_comprobante
    , prosic_mesa_pedido.nro_serie
    , '' as anio_dua_comprobante
    , prosic_mesa_pedido.nro_comprobante
    , prosic_tipo_comprobante.sunat_tipo_documento
    , if(status_mesa_pedido='FI',prosic_ruc.numero_ruc,'')
    , if(status_mesa_pedido='FI',SUBSTRING(prosic_ruc.razon_social_ruc,1,15),'*** ANULADO ***')
    , if(status_mesa_pedido='FI',( subtotal ),0) as afecto_comprobante
    , 0 as inafecto_comprobante
    , if(status_mesa_pedido='FI',igv,0)
    , if(status_mesa_pedido='FI',( subtotal + igv + servicio ),0) as total_comprobante 	
    , 1 as id_operacion
    , 0 as no_gravadas_igv
    , if(status_mesa_pedido='FI',servicio,0) as inafecto_comprobante
    , 0 as isc_comprobante
    , 0 as otros_tributos
    , if(status_mesa_pedido='FI',( subtotal + igv + servicio ),0) as total_comprobante1
    , 0 as tipo_cambio_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    , 1 as id_moneda
     FROM prosic_mesa_pedido
    INNER JOIN prosic_caja ON prosic_mesa_pedido.id_caja = prosic_caja.id_caja
    INNER JOIN prosic_tipo_comprobante ON prosic_mesa_pedido.id_tipo_comprobante  = prosic_tipo_comprobante.id_tipo_comprobante
     LEFT JOIN prosic_ruc ON prosic_ruc.id_ruc=prosic_mesa_pedido.id_ruc
    WHERE MONTH(fecha_caja)=" . $w_mes .
     " AND YEAR(fecha_caja)=" . $w_anio;
    //$sql.=" AND status_mesa_pedido='FI'
$sql.=" Order by prosic_caja.fecha_caja,prosic_tipo_comprobante.id_tipo_comprobante DESC,prosic_mesa_pedido.nro_comprobante";
        mysql_select_db($tienda);
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

function migra_registro_caja_local($w_fecha, $tienda) {
     $sql = "SELECT prosic_caja.fecha_caja, 
		sum(prosic_mesa_fraccionado.total),
		sum(prosic_mesa_fraccionado.contado),
		sum(prosic_mesa_fraccionado.propina),
		sum(prosic_mesa_fraccionado.monto_visa),
		sum(prosic_mesa_fraccionado.monto_mastercard),
		sum(prosic_mesa_fraccionado.monto_american),
		sum(prosic_mesa_fraccionado.monto_financieracrm),
		sum(prosic_mesa_fraccionado.monto_dinner),
		sum(prosic_mesa_fraccionado.propina_visa),
		sum(prosic_mesa_fraccionado.propina_mastercard),
		sum(prosic_mesa_fraccionado.propina_american),
		sum(prosic_mesa_fraccionado.propina_financieracrm),
		sum(prosic_mesa_fraccionado.propina_dinner),
		sum(prosic_mesa_pedido.subtotal),
		sum(prosic_mesa_pedido.descuento),
		sum(prosic_mesa_pedido.igv),
		sum(prosic_mesa_pedido.servicio)
		FROM prosic_caja 
		INNER JOIN prosic_mesa_fraccionado ON prosic_mesa_fraccionado.id_caja = prosic_caja.id_caja
		INNER JOIN prosic_mesa_pedido ON prosic_mesa_fraccionado.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido
		where prosic_mesa_fraccionado.status_fraccionado<>'AN'
        AND prosic_caja.fecha_caja = '" . $w_fecha . "'";
	$sql.=" GROUP BY prosic_caja.fecha_caja";
        mysql_select_db($tienda);
        $result = $this->Consulta_Mysql($sql);
        return $result;
}

function migra_registro_ventas_local($w_anio, $w_mes, $tienda) {
	$w_anio=2000+$w_anio-1;
     $sql = "SELECT prosic_caja.fecha_caja, 
			sum(prosic_caja.total_boletas+prosic_caja.total_facturas+prosic_caja.total_manual_factura+prosic_caja.total_manual_boleta),
			sum(prosic_caja.total_dolares),
			sum(prosic_caja.total_cambio)
			FROM prosic_caja
    		 where MONTH(prosic_caja.fecha_caja)=" . $w_mes .
           " AND prosic_caja.fecha_caja='2011-06-08'
            AND YEAR(prosic_caja.fecha_caja)=" . $w_anio;
  $sql.=" GROUP BY prosic_caja.fecha_caja";
        mysql_select_db($tienda);
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

function consulta_resumen_ventas_local($w_anio, $w_mes, $tienda) {
	$w_anio=2000+$w_anio-1;
        $sql = "SELECT  prosic_caja.fecha_caja as emision_comprobante,
		                prosic_tipo_comprobante.sunat_tipo_comprobante,
                        prosic_tipo_comprobante.nombre_tipo_comprobante,
                        prosic_mesa_pedido.nro_serie, 
                        min( nro_comprobante ) as nro_menor,
                        max( nro_comprobante ) as nro_mayor,
                        sum( if(status_mesa_pedido='FI',subtotal + descuento,0)) as subtotal,
                        sum( if(status_mesa_pedido='FI',descuento,0) ) as descuento,
                        sum( if(status_mesa_pedido='FI',subtotal,0) ) as basetotal,
                        sum( if(status_mesa_pedido='FI',servicio,0) ) as servicio,
                        sum( if(status_mesa_pedido='FI',igv,0) ) as igv,
                        sum( if(status_mesa_pedido='FI',subtotal + igv + servicio,0) ) as total
                   FROM prosic_mesa_pedido
                  INNER JOIN prosic_caja ON prosic_mesa_pedido.id_caja = prosic_caja.id_caja
                  INNER JOIN prosic_tipo_comprobante ON prosic_mesa_pedido.id_tipo_comprobante  = prosic_tipo_comprobante.id_tipo_comprobante
                  WHERE MONTH(fecha_caja)=" . $w_mes . " AND YEAR(fecha_caja)=" . $w_anio . "
                                    GROUP BY prosic_caja.fecha_caja,
		                prosic_tipo_comprobante.sunat_tipo_comprobante,
                        prosic_tipo_comprobante.nombre_tipo_comprobante,
                        prosic_mesa_pedido.nro_serie
ORDER BY prosic_tipo_comprobante.nombre_tipo_comprobante,prosic_caja.fecha_caja, prosic_mesa_pedido.nro_serie";
       mysql_select_db($tienda);
        $result = $this->Consulta_Mysql($sql);
       return $result;
    }
	
function migra_registro_manvta_local($w_anio, $w_mes, $tienda) {
	$w_anio=2000+$w_anio-1;
     $sql = "SELECT prosic_caja.fecha_caja,
		if(status_mesa_pedido='FI',298,2643) as id_anexo,
		nro_serie,
		nro_comprobante,
		if(status_mesa_pedido='FI',prosic_mesa_pedido.subtotal,0) as subtotal,
		if(status_mesa_pedido='FI',prosic_mesa_pedido.descuento,0) as descuento,
		if(status_mesa_pedido='FI',prosic_mesa_pedido.igv,0) as igv,
		if(status_mesa_pedido='FI',prosic_mesa_pedido.servicio,0) as servicio,
		if(status_mesa_pedido='FI',prosic_mesa_pedido.total,0) as total
		FROM prosic_caja 
		INNER JOIN prosic_mesa_fraccionado ON prosic_mesa_fraccionado.id_caja = prosic_caja.id_caja
		INNER JOIN prosic_mesa_pedido ON prosic_mesa_fraccionado.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido
                 WHERE MONTH(fecha_caja)=" . $w_mes . " AND YEAR(fecha_caja)=" . $w_anio . "";
         mysql_select_db($tienda);
        $result = $this->Consulta_Mysql($sql);
        return $result;
}
    /**
     * Function Capturar la descripcion del año
     * $id	: Codigo de año
     */
    function capturar_mes_por_id($id) {
        $sql = "SELECT nombre_anio FROM prosic_anio WHERE id_anio=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_array($result);
        $dato = $row[0];
        return $dato;
    }

    /**
     * Function Capturar la persona por un tipo de subdiario y moneda.
     * $id_subdiario	: Codigo de subdiario
     * $id_moneda		: Codigo de moneda
     */
    function buscar_comprobante_por_subdiario($id_subdiario, $id_moneda) {
        $sql = "SELECT
		
	    prosic_anexo.id_anexo
			    , prosic_anexo.codigo_anexo
			    , prosic_anexo.descripcion_anexo
			    , prosic_tipo_comprobante.id_tipo_comprobante
			    , prosic_comprobante.serie_comprobante
			    , prosic_comprobante.nro_comprobante
			    , prosic_comprobante.emision_comprobante
			    , prosic_comprobante.tipo_cambio_comprobante
			    , prosic_comprobante.total_comprobante
			    , prosic_comprobante.glosa_comprobante
			FROM  prosic_comprobante
		    INNER JOIN prosic_anexo 			        ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
			INNER JOIN prosic_tipo_comprobante 	        ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
			WHERE prosic_comprobante.status_comprobante='F' and prosic_comprobante.id_subdiario = " . $id_subdiario . " AND prosic_comprobante.id_moneda=" . $id_moneda;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    /**
     * Function Capturar la persona por un tipo de subdiario y moneda.
     * $id_subdiario	: Codigo de subdiario
     * $id_moneda		: Codigo de moneda
     */
    function buscar_comprobante_documento($id_cuenta, $id_anexo, $id_serie, $id_numero ) {
        $sql = "SELECT
					  prosic_plan_contable.id_plan_contable
					, prosic_plan_contable.cuenta_plan_contable
					, prosic_anexo.codigo_anexo
					, prosic_anexo.descripcion_anexo
					, prosic_detalle_comprobante.id_tipo_comprobante
					, prosic_detalle_comprobante.ser_doc_comprobante
					, prosic_detalle_comprobante.nro_doc_comprobante
					, prosic_moneda.id_moneda
					, prosic_detalle_comprobante.fecha_doc_comprobante
					, prosic_tipo_cambio.fecha_tipo_cambio
					, sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='A',1,-1)) as importe_soles
					, sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='A',1,-1)/prosic_tipo_cambio.compra_sunat) as importe_dolares
				FROM       prosic_detalle_comprobante
				INNER JOIN prosic_plan_contable    ON prosic_detalle_comprobante.id_plan_contable=prosic_plan_contable.id_plan_contable
				INNER JOIN prosic_anexo            ON prosic_detalle_comprobante.id_anexo = prosic_anexo.id_anexo
				INNER JOIN prosic_moneda           ON prosic_detalle_comprobante.id_moneda = prosic_moneda.id_moneda
				LEFT  JOIN prosic_tipo_cambio      ON prosic_detalle_comprobante.fecha_doc_comprobante=prosic_tipo_cambio.fecha_tipo_cambio
				WHERE 1=1 ";
				if ($id_cuenta != '')$sql.=" AND prosic_plan_contable.cuenta_plan_contable LIKE '%" . $id_cuenta . "%'";
    if ($id_anexo != '')$sql.=" AND prosic_anexo.codigo_anexo LIKE '%" . $id_anexo . "%'";
    if ($id_numero != '')$sql.=" AND prosic_detalle_comprobante.nro_doc_comprobante LIKE '%" . $id_numero . "%'";
			$sql.=" group by prosic_plan_contable.id_plan_contable
					, prosic_plan_contable.cuenta_plan_contable
					, prosic_anexo.codigo_anexo
					, prosic_anexo.descripcion_anexo
					, prosic_detalle_comprobante.id_tipo_comprobante
					, prosic_detalle_comprobante.ser_doc_comprobante
					, prosic_detalle_comprobante.nro_doc_comprobante
					, prosic_moneda.id_moneda
					, prosic_detalle_comprobante.fecha_doc_comprobante
					, prosic_tipo_cambio.fecha_tipo_cambio
					having importe_soles>0";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
    function buscar_comprobante_para_libro_caja($nro_comprobante, $serie_comprobante, $id_anexo) {
        $sql = "SELECT
 				`emision_comprobante`
				, `tipo_cambio_comprobante`
				, `total_comprobante`
				, `glosa_comprobante`
				, `id_comprobante`
		 		FROM prosic_comprobante
		 		WHERE serie_comprobante='" . $serie_comprobante . "' and nro_comprobante='" . $nro_comprobante . "' and id_anexo=" . $id_anexo;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function capturar_cta_para_libro_caja($id_comprobante, $cargo_abono) {
        $sql = "select
	       prosic_detalle_comprobante.id_plan_contable
	      ,prosic_plan_contable.cuenta_plan_contable
		from  prosic_detalle_comprobante
		inner join prosic_plan_contable    on prosic_detalle_comprobante.id_plan_contable =  prosic_plan_contable.id_plan_contable
		where id_comprobante  =  " . $id_comprobante . " and cargar_abonar='" . $cargo_abono . "';";
        $result = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_array($result);
        return $row;
    }

    function imprimir_libro_caja_por_periodo($anio, $mes, $len, $cuenta) {
        $sql = "SELECT
       `prosic_comprobante`.emision_comprobante
     , `prosic_comprobante`.id_subdiario
     , `prosic_comprobante`.`codigo_comprobante`
     ,  SubString(`prosic_detalle_comprobante`.`detalle_comprobante`,1,20)
     , `prosic_plan_contable`.`cuenta_plan_contable`
     ,  SubString(`prosic_plan_contable`.`descripcion_plan_contable`,1,20)
     , `prosic_detalle_comprobante`.`cargar_abonar`
     , `prosic_detalle_comprobante`.`importe_soles`
     , `prosic_detalle_comprobante`.tipo_digito
        FROM `prosic_detalle_comprobante`
        INNER JOIN `prosic_comprobante`   ON (`prosic_detalle_comprobante`.`id_comprobante` = `prosic_comprobante`.`id_comprobante`)
        INNER JOIN `prosic_plan_contable` ON (`prosic_detalle_comprobante`.`id_plan_contable` = `prosic_plan_contable`.`id_plan_contable`)
        INNER JOIN `prosic_subdiario`     ON (`prosic_comprobante`.`id_subdiario` = `prosic_subdiario`.`id_subdiario`)
        WHERE prosic_comprobante.id_anio=" . $anio . " AND prosic_comprobante.id_mes=" . $mes . "";
        $sql.=" AND SubString(prosic_plan_contable.cuenta_plan_contable,1," . $len . ")='" . $cuenta . "'";
        $sql.=" ORDER BY `prosic_comprobante`.emision_comprobante,prosic_comprobante.id_subdiario,prosic_comprobante.codigo_comprobante,`prosic_detalle_comprobante`.tipo_digito DESC,`prosic_detalle_comprobante`.`cargar_abonar` DESC,`prosic_plan_contable`.cuenta_plan_contable";

        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function imprimir_libro_banco_por_periodo($anio, $mes, $banco) {
        $sql = "SELECT
       prosic_comprobante.emision_comprobante
     , prosic_banco.id_banco
     , prosic_banco.nombre_banco
     , prosic_comprobante.id_subdiario
     , prosic_comprobante.codigo_comprobante
     , prosic_comprobante.id_medio_pago
     , SubString(prosic_comprobante.detalle_comprobante,1,40)
     , prosic_plan_contable.cuenta_plan_contable
     , SubString(prosic_plan_contable.descripcion_plan_contable,1,20)
     , prosic_detalle_comprobante.cargar_abonar
     , prosic_detalle_comprobante.importe_soles
     , prosic_detalle_comprobante.tipo_digito
     , prosic_anexo.descripcion_anexo
     , SubString(prosic_comprobante.serie_comprobante+prosic_comprobante.nro_comprobante+prosic_comprobante.detalle_comprobante,1,40)
     , prosic_detalle_comprobante.importe_dolares
	 , prosic_comprobante.tipo_cambio_comprobante
	 , prosic_banco.nro_cuenta_banco
         FROM prosic_detalle_comprobante
        INNER JOIN prosic_comprobante   ON (prosic_detalle_comprobante.id_comprobante = prosic_comprobante.id_comprobante)
        INNER JOIN prosic_plan_contable ON (prosic_detalle_comprobante.id_plan_contable = prosic_plan_contable.id_plan_contable)
        INNER JOIN prosic_subdiario     ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
        INNER JOIN prosic_banco         ON (prosic_detalle_comprobante.id_plan_contable = prosic_banco.id_plan_contable)
        INNER JOIN prosic_anexo         ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
        WHERE prosic_comprobante.id_anio=" . $anio . " AND prosic_comprobante.id_mes=" . $mes . "";
        $sql.=" AND prosic_banco.id_banco=" . $banco . "";
        $sql.=" ORDER BY prosic_comprobante.emision_comprobante,prosic_comprobante.id_subdiario,prosic_comprobante.codigo_comprobante,prosic_detalle_comprobante.tipo_digito DESC,prosic_detalle_comprobante.cargar_abonar DESC,prosic_plan_contable.cuenta_plan_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function imprimir_caja_saldo_por_periodo($id_mes) {
		switch($id_mes)
       {
        Case 0:  $t = "prosic_mayor.ca00,prosic_mayor.aa00";break;
        Case 1:  $t = "prosic_mayor.ca01,prosic_mayor.aa01";break;
        Case 2:  $t = "prosic_mayor.ca02,prosic_mayor.aa02";break;
        Case 3:  $t = "prosic_mayor.ca03,prosic_mayor.aa03";break;
        Case 4:  $t = "prosic_mayor.ca04,prosic_mayor.aa04";break;
        Case 5:  $t = "prosic_mayor.ca05,prosic_mayor.aa05";break;
        Case 6:  $t = "prosic_mayor.ca06,prosic_mayor.aa06";break;
        Case 7:  $t = "prosic_mayor.ca07,prosic_mayor.aa07";break;
        Case 8:  $t = "prosic_mayor.ca08,prosic_mayor.aa08";break;
        Case 9:  $t = "prosic_mayor.ca09,prosic_mayor.aa09";break;
        Case 10: $t = "prosic_mayor.ca10,prosic_mayor.aa10";break;
        Case 11: $t = "prosic_mayor.ca11,prosic_mayor.aa11";break;
        Case 12: $t = "prosic_mayor.ca12,prosic_mayor.aa12";break;
        Case 13: $t = "prosic_mayor.ca13,prosic_mayor.aa13";break;
        Case 14: $t = "prosic_mayor.ca14,prosic_mayor.aa14";break;
       }
		switch($id_mes)
       {
        Case 0:  $s = "prosic_mayor.ca00-prosic_mayor.aa00";break;
        Case 1:  $s = "prosic_mayor.ca01-prosic_mayor.aa01";break;
        Case 2:  $s = "prosic_mayor.ca02-prosic_mayor.aa02";break;
        Case 3:  $s = "prosic_mayor.ca03-prosic_mayor.aa03";break;
        Case 4:  $s = "prosic_mayor.ca04-prosic_mayor.aa04";break;
        Case 5:  $s = "prosic_mayor.ca05-prosic_mayor.aa05";break;
        Case 6:  $s = "prosic_mayor.ca06-prosic_mayor.aa06";break;
        Case 7:  $s = "prosic_mayor.ca07-prosic_mayor.aa07";break;
        Case 8:  $s = "prosic_mayor.ca08-prosic_mayor.aa08";break;
        Case 9:  $s = "prosic_mayor.ca09-prosic_mayor.aa09";break;
        Case 10: $s = "prosic_mayor.ca10-prosic_mayor.aa10";break;
        Case 11: $s = "prosic_mayor.ca11-prosic_mayor.aa11";break;
        Case 12: $s = "prosic_mayor.ca12-prosic_mayor.aa12";break;
        Case 13: $s = "prosic_mayor.ca13-prosic_mayor.aa13";break;
        Case 14: $s = "prosic_mayor.ca14-prosic_mayor.aa14";break;
       }
	   $sql = "SELECT prosic_mayor.id_cuenta_contable,
				SubString(prosic_plan_contable.descripcion_plan_contable,1,29),
				prosic_banco.id_entidad_financiera,
				prosic_banco.nro_cuenta_banco,
				prosic_banco.id_moneda," . $t . "
				FROM prosic_mayor 
				INNER JOIN prosic_plan_contable ON prosic_plan_contable.cuenta_plan_contable=prosic_mayor.id_cuenta_contable
				LEFT JOIN prosic_banco ON prosic_plan_contable.id_plan_contable=prosic_banco.id_plan_contable
				WHERE prosic_mayor.id_cuenta_contable LIKE '10%' 
				AND " . $s . "<>0
				order by prosic_mayor.id_cuenta_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }	
	
    function imprimir_libro_diario_por_periodo($w_anio, $w_mes) {
        $sql = "SELECT
       `prosic_comprobante`.emision_comprobante
     , `prosic_comprobante`.id_subdiario
     , `prosic_comprobante`.`codigo_comprobante`
     ,  SubString(`prosic_detalle_comprobante`.`detalle_comprobante`,1,20)
     , `prosic_plan_contable`.`cuenta_plan_contable`
     ,  SubString(`prosic_plan_contable`.`descripcion_plan_contable`,1,20)
     , `prosic_detalle_comprobante`.`cargar_abonar`
     , `prosic_detalle_comprobante`.`importe_soles`
     , `prosic_detalle_comprobante`.tipo_digito
        FROM `prosic_detalle_comprobante`
        INNER JOIN `prosic_comprobante`   ON (`prosic_detalle_comprobante`.`id_comprobante` = `prosic_comprobante`.`id_comprobante`)
        INNER JOIN `prosic_plan_contable` ON (`prosic_detalle_comprobante`.`id_plan_contable` = `prosic_plan_contable`.`id_plan_contable`)
        INNER JOIN `prosic_subdiario`     ON (`prosic_comprobante`.`id_subdiario` = `prosic_subdiario`.`id_subdiario`)
        WHERE prosic_comprobante.id_anio=" . $w_anio . " AND prosic_comprobante.id_mes=" . $w_mes . "";
        $sql.=" ORDER BY `prosic_comprobante`.emision_comprobante,prosic_comprobante.id_subdiario,prosic_comprobante.codigo_comprobante,`prosic_detalle_comprobante`.tipo_digito DESC,`prosic_detalle_comprobante`.`cargar_abonar` DESC,`prosic_plan_contable`.cuenta_plan_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function imprimir_libro_mayor_por_periodo($w_anio, $w_mes) {
        $sql = "SELECT
       prosic_comprobante.emision_comprobante
     , prosic_comprobante.id_subdiario
     , prosic_comprobante.codigo_comprobante
     , SubString(prosic_detalle_comprobante.detalle_comprobante,1,20)
     , prosic_plan_contable.cuenta_plan_contable
     , SubString(prosic_plan_contable.descripcion_plan_contable,1,20)
     , prosic_detalle_comprobante.cargar_abonar
     , prosic_detalle_comprobante.importe_soles
     , prosic_detalle_comprobante.tipo_digito
        FROM prosic_detalle_comprobante
        INNER JOIN prosic_comprobante   ON (prosic_detalle_comprobante.id_comprobante = prosic_comprobante.id_comprobante)
        INNER JOIN prosic_plan_contable ON (prosic_detalle_comprobante.id_plan_contable = prosic_plan_contable.id_plan_contable)
        INNER JOIN prosic_subdiario     ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
        WHERE prosic_comprobante.id_anio=" . $w_anio . " AND prosic_comprobante.id_mes=" . $w_mes . "";
        $sql.=" ORDER BY prosic_plan_contable.cuenta_plan_contable,prosic_comprobante.emision_comprobante,prosic_comprobante.id_subdiario,prosic_comprobante.codigo_comprobante,prosic_detalle_comprobante.tipo_digito DESC,prosic_detalle_comprobante.cargar_abonar DESC,prosic_plan_contable.cuenta_plan_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

   function imprimir_mayor_cuenta_por_periodo($w_anio, $w_mes, $w_cta) {
        $sql = "SELECT
       prosic_comprobante.emision_comprobante
     , prosic_comprobante.id_subdiario
     , prosic_comprobante.codigo_comprobante
     , SubString(prosic_detalle_comprobante.detalle_comprobante,1,40)
     , prosic_plan_contable.cuenta_plan_contable
     , SubString(prosic_plan_contable.descripcion_plan_contable,1,40)
     , prosic_detalle_comprobante.cargar_abonar
     , prosic_detalle_comprobante.importe_soles
     , prosic_detalle_comprobante.tipo_digito
     , prosic_detalle_comprobante.importe_dolares
	 , (select prosic_plan_contable.cuenta_plan_contable from prosic_plan_contable where id_plan_contable=prosic_comprobante.id_plan_contable)
     , prosic_anexo.codigo_anexo
     , SubString(prosic_anexo.descripcion_anexo,1,20)
	 , prosic_plan_contable.id_moneda
        FROM prosic_detalle_comprobante
        INNER JOIN prosic_comprobante   ON (prosic_detalle_comprobante.id_comprobante = prosic_comprobante.id_comprobante)
        INNER JOIN prosic_plan_contable ON (prosic_detalle_comprobante.id_plan_contable = prosic_plan_contable.id_plan_contable)
        INNER JOIN prosic_subdiario     ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
         LEFT JOIN prosic_anexo         ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
        WHERE prosic_comprobante.id_anio=" . $w_anio . " 
		  AND prosic_comprobante.id_mes=" . $w_mes . "
		  AND prosic_plan_contable.cuenta_plan_contable LIKE '" . $w_cta . "%'";
        $sql.=" ORDER BY prosic_plan_contable.cuenta_plan_contable,prosic_comprobante.emision_comprobante,prosic_comprobante.id_subdiario,prosic_comprobante.codigo_comprobante,prosic_detalle_comprobante.tipo_digito DESC,prosic_detalle_comprobante.cargar_abonar DESC,prosic_plan_contable.cuenta_plan_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function imprimir_inv_clientes($anio, $mes, $len, $cuenta) {
        $sql = "SELECT
       `prosic_comprobante`.emision_comprobante
     , `prosic_comprobante`.id_subdiario
     , `prosic_comprobante`.`codigo_comprobante`
     ,  SubString(`prosic_detalle_comprobante`.`detalle_comprobante`,1,20)
     , `prosic_plan_contable`.`cuenta_plan_contable`
     ,  `prosic_plan_contable`.`descripcion_plan_contable`
     , `prosic_detalle_comprobante`.`cargar_abonar`
     , `prosic_detalle_comprobante`.`importe_soles`
     , `prosic_detalle_comprobante`.tipo_digito
     , `prosic_anexo`.codigo_anexo
     , `prosic_anexo`.descripcion_anexo
     , `prosic_tipo_documento`.sunat_tipo_documento
     , `prosic_comprobante`.nro_comprobante
        FROM `prosic_detalle_comprobante`
        INNER JOIN `prosic_comprobante`   ON (`prosic_detalle_comprobante`.`id_comprobante` = `prosic_comprobante`.`id_comprobante`)
        INNER JOIN `prosic_plan_contable` ON (`prosic_detalle_comprobante`.`id_plan_contable` = `prosic_plan_contable`.`id_plan_contable`)
        INNER JOIN `prosic_subdiario`     ON (`prosic_comprobante`.`id_subdiario` = `prosic_subdiario`.`id_subdiario`)
        INNER JOIN `prosic_anexo`         ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
        INNER JOIN prosic_tipo_documento  ON (prosic_anexo.id_tipo_documento = prosic_tipo_documento.id_tipo_documento)
        WHERE prosic_comprobante.id_anio=" . $anio . " AND prosic_comprobante.id_mes<=" . $mes . "";
        $sql.=" AND SubString(prosic_plan_contable.cuenta_plan_contable,1," . $len . ")='" . $cuenta . "'";
        $sql.=" ORDER BY `prosic_plan_contable`.cuenta_plan_contable,`prosic_tipo_documento`.sunat_tipo_documento, `prosic_anexo`.codigo_anexo";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_comprobante_por_id($id) {
        $sql = "SELECT  * FROM prosic_comprobante WHERE id_comprobante=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function get_last_id($id, $sd) {
        $sql = "SELECT id_comprobante as total FROM prosic_comprobante WHERE codigo_comprobante='" . $id . "' AND id_subdiario=" . $sd;
        mysql_select_db("dbprosic");
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        $data = $row['total'];
        return $data;     
    }

    /**
     * Sistema Prosic
     * SECCION - LIBRO CAJA - funcion para capturar datos de comprobante por nro y serie de comprobante y id_anexo
     * @package		Prosic
     * @author		Rommel Mercado
     * @copyright	Copyright 2011
     * @license		Rommel Mercado
     * @since		Version 1.0
     * @filesource
     */
    function cargar_data_libro_banco($c_a_cuenta_banco, $limit, $nombre_mes='' , $cc='') {
	//$nombre_mes='DICIEMBRE';
        $sql = "SELECT
    prosic_comprobante.id_comprobante
    , prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.status_comprobante
    , prosic_anexo.codigo_anexo
    , prosic_subdiario.id_subdiario
    , prosic_subdiario.codigo_subdiario
    , prosic_subdiario.nombre_subdiario
    , prosic_anio.nombre_anio
    , prosic_mes.nombre_mes
    , prosic_tipo_comprobante.codigo_tipo_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    ,prosic_comprobante.nro_comprobante
    ,prosic_moneda.codigo_moneda
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo         	ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_mes           	ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
    INNER JOIN prosic_anio          	ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
    INNER JOIN prosic_subdiario     	ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
    INNER JOIN prosic_tipo_comprobante	ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
    INNER JOIN prosic_plan_contable       ON (prosic_comprobante.cuenta_banco = prosic_plan_contable.id_plan_contable)
    INNER JOIN prosic_moneda	       ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
    WHERE prosic_comprobante.id_subdiario=8 AND prosic_comprobante.c_a_cuenta_banco='" . $c_a_cuenta_banco . "' ";	
	if ($nombre_mes != '') $sql.= " AND prosic_mes.nombre_mes = '" . $nombre_mes . "' ";
	if ($cc != '') $sql.=" AND prosic_comprobante.codigo_comprobante = '" . $cc . "' ";
	$sql.=" ORDER BY MONTH(prosic_comprobante.emision_comprobante) DESC , prosic_comprobante.codigo_comprobante*10000 DESC";
	//$sql.=" ORDER BY prosic_comprobante.status_comprobante DESC, MONTH(prosic_comprobante.emision_comprobante), prosic_comprobante.emision_comprobante";
	if ($limit != '')$sql.=" " . $limit . " ";
    $result = $this->Consulta_Mysql($sql);
    return $result;
    }
	
    function cargar_caja_ingresos_soles($c_a_cuenta_banco, $limit, $nombre_mes='' , $cc='') {
	//$nombre_mes='DICIEMBRE';
        $sql = "SELECT
    prosic_comprobante.id_comprobante
    , prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.status_comprobante
    , prosic_anexo.codigo_anexo
    , prosic_subdiario.id_subdiario
    , prosic_subdiario.codigo_subdiario
    , prosic_subdiario.nombre_subdiario
    , prosic_anio.nombre_anio
    , prosic_mes.nombre_mes
    , prosic_tipo_comprobante.codigo_tipo_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    ,prosic_comprobante.nro_comprobante
    ,prosic_moneda.codigo_moneda
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo         	ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_mes           	ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
    INNER JOIN prosic_anio          	ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
    INNER JOIN prosic_subdiario     	ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
    INNER JOIN prosic_tipo_comprobante	ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
    INNER JOIN prosic_moneda	       ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
    WHERE prosic_comprobante.id_subdiario=4 ";	
	if ($nombre_mes != '') $sql.= " AND prosic_mes.nombre_mes = '" . $nombre_mes . "' ";
	if ($cc != '') $sql.=" AND prosic_comprobante.codigo_comprobante = '" . $cc . "' ";
	$sql.=" ORDER BY MONTH(prosic_comprobante.emision_comprobante) DESC , prosic_comprobante.codigo_comprobante*10000 DESC";
	if ($limit != '')$sql.=" " . $limit . " ";
    $result = $this->Consulta_Mysql($sql);
    return $result;
    }
	
    function cargar_caja_ingresos_dolar($c_a_cuenta_banco, $limit, $nombre_mes='' , $cc='') {
        $sql = "SELECT
    prosic_comprobante.id_comprobante
    , prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.status_comprobante
    , prosic_anexo.codigo_anexo
    , prosic_subdiario.id_subdiario
    , prosic_subdiario.codigo_subdiario
    , prosic_subdiario.nombre_subdiario
    , prosic_anio.nombre_anio
    , prosic_mes.nombre_mes
    , prosic_tipo_comprobante.codigo_tipo_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    ,prosic_comprobante.nro_comprobante
    ,prosic_moneda.codigo_moneda
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo         	ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_mes           	ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
    INNER JOIN prosic_anio          	ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
    INNER JOIN prosic_subdiario     	ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
    INNER JOIN prosic_tipo_comprobante	ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
    INNER JOIN prosic_moneda	       ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
    WHERE prosic_comprobante.id_subdiario=5 ";	
	if ($nombre_mes != '') $sql.= " AND prosic_mes.nombre_mes = '" . $nombre_mes . "' ";
	if ($cc != '') $sql.=" AND prosic_comprobante.codigo_comprobante = '" . $cc . "' ";
	$sql.=" ORDER BY MONTH(prosic_comprobante.emision_comprobante) DESC , prosic_comprobante.codigo_comprobante*10000 DESC";
	if ($limit != '')$sql.=" " . $limit . " ";
    $result = $this->Consulta_Mysql($sql);
    return $result;
    }

	 function cargar_caja_egresos_soles($c_a_cuenta_banco, $limit, $nombre_mes='' , $cc='') {
	//$nombre_mes='DICIEMBRE';
        $sql = "SELECT
    prosic_comprobante.id_comprobante
    , prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.status_comprobante
    , prosic_anexo.codigo_anexo
    , prosic_subdiario.id_subdiario
    , prosic_subdiario.codigo_subdiario
    , prosic_subdiario.nombre_subdiario
    , prosic_anio.nombre_anio
    , prosic_mes.nombre_mes
    , prosic_tipo_comprobante.codigo_tipo_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    ,prosic_comprobante.nro_comprobante
    ,prosic_moneda.codigo_moneda
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo         	ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_mes           	ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
    INNER JOIN prosic_anio          	ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
    INNER JOIN prosic_subdiario     	ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
    INNER JOIN prosic_tipo_comprobante	ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
    INNER JOIN prosic_moneda	       ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
    WHERE prosic_comprobante.id_subdiario=6 ";	
	if ($nombre_mes != '') $sql.= " AND prosic_mes.nombre_mes = '" . $nombre_mes . "' ";
	if ($cc != '') $sql.=" AND prosic_comprobante.codigo_comprobante = '" . $cc . "' ";
	$sql.=" ORDER BY MONTH(prosic_comprobante.emision_comprobante) DESC , prosic_comprobante.codigo_comprobante*10000 DESC";
	if ($limit != '')$sql.=" " . $limit . " ";
    $result = $this->Consulta_Mysql($sql);
    return $result;
    }

    function cargar_caja_egresos_dolar($c_a_cuenta_banco, $limit, $nombre_mes='' , $cc='') {
	//$nombre_mes='DICIEMBRE';
        $sql = "SELECT
    prosic_comprobante.id_comprobante
    , prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.status_comprobante
    , prosic_anexo.codigo_anexo
    , prosic_subdiario.id_subdiario
    , prosic_subdiario.codigo_subdiario
    , prosic_subdiario.nombre_subdiario
    , prosic_anio.nombre_anio
    , prosic_mes.nombre_mes
    , prosic_tipo_comprobante.codigo_tipo_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    ,prosic_comprobante.nro_comprobante
    ,prosic_moneda.codigo_moneda
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo         	ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_mes           	ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
    INNER JOIN prosic_anio          	ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
    INNER JOIN prosic_subdiario     	ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
    INNER JOIN prosic_tipo_comprobante	ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
    INNER JOIN prosic_moneda	       ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
    WHERE prosic_comprobante.id_subdiario=7 ";	
	if ($nombre_mes != '') $sql.= " AND prosic_mes.nombre_mes = '" . $nombre_mes . "' ";
	if ($cc != '') $sql.=" AND prosic_comprobante.codigo_comprobante = '" . $cc . "' ";
	$sql.=" ORDER BY MONTH(prosic_comprobante.emision_comprobante) DESC , prosic_comprobante.codigo_comprobante*10000 DESC";
	if ($limit != '')$sql.=" " . $limit . " ";
    $result = $this->Consulta_Mysql($sql);
    return $result;
    }
	
	
    function consultar_comprobante_cabecera_sin_detalle($id) {
        $sql = "SELECT
		     prosic_comprobante.id_comprobante
		    , prosic_comprobante.codigo_comprobante
		    , prosic_comprobante.emision_comprobante
		    , prosic_comprobante.afecto_comprobante
		    , prosic_comprobante.inafecto_comprobante
		    , prosic_comprobante.total_comprobante
		    , prosic_comprobante.igv_comprobante
		    , prosic_comprobante.isc_comprobante
		    , prosic_comprobante.tipo_cambio_comprobante
		    , prosic_comprobante.id_anexo
		    , prosic_comprobante.id_tipo_comprobante
		    , prosic_comprobante.nro_comprobante
                    , prosic_comprobante.serie_comprobante
		    , prosic_subdiario.id_subdiario
		    , prosic_subdiario.codigo_subdiario
		    , prosic_subdiario.nombre_subdiario
		    , prosic_moneda.id_moneda
		    , prosic_moneda.nombre_moneda
		    , prosic_moneda.codigo_moneda
		    , prosic_anio.nombre_anio
		    , prosic_mes.nombre_mes
                    , prosic_anio.id_anio
		    , prosic_mes.id_mes
		    , prosic_anexo.codigo_anexo
		    , prosic_anexo.descripcion_anexo
		    , prosic_tipo_comprobante.codigo_tipo_comprobante
		    , prosic_tipo_comprobante.nombre_tipo_comprobante
		    , prosic_comprobante.id_plan_contable
		    , prosic_comprobante.detalle_comprobante
			, prosic_banco.id_banco
			, prosic_comprobante.id_medio_pago
		FROM
		    prosic_comprobante
		    INNER JOIN prosic_mes
		        ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
		    INNER JOIN prosic_anio
		        ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
		    INNER JOIN prosic_subdiario
		        ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
		    INNER JOIN prosic_moneda
		        ON (prosic_comprobante.id_moneda = prosic_moneda.id_moneda)
		    INNER JOIN prosic_anexo
		        ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
		    INNER JOIN prosic_tipo_comprobante
		        ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)		    
			LEFT JOIN prosic_banco ON prosic_banco.id_plan_contable = prosic_comprobante.cuenta_banco 
		    WHERE prosic_comprobante.id_comprobante=" . $id . "";

        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

## FIN DE LA FUNCION

    function cargar_data_asiento_diario($nombre_mes='', $nrocomprobante='', $limit=''){
        $sql = "SELECT
    prosic_comprobante.id_comprobante
    , prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.status_comprobante
    , prosic_anexo.codigo_anexo
    , prosic_subdiario.id_subdiario
    , prosic_subdiario.codigo_subdiario
    , prosic_subdiario.nombre_subdiario
    , prosic_anio.nombre_anio
    , prosic_mes.nombre_mes
    , prosic_tipo_comprobante.codigo_tipo_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    ,prosic_comprobante.nro_comprobante
    ,prosic_moneda.codigo_moneda
	,prosic_comprobante.status_comprobante
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo
        ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_mes
        ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
    INNER JOIN prosic_anio
        ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
    INNER JOIN prosic_subdiario
        ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
    INNER JOIN prosic_tipo_comprobante
        ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
        INNER JOIN prosic_moneda
        ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
			WHERE  prosic_comprobante.id_subdiario=9";			
		if ($nombre_mes != '')$sql.=" AND prosic_mes.nombre_mes='" . $nombre_mes . "'";
        if ($nrocomprobante != '')$sql.=" AND prosic_comprobante.codigo_comprobante =" . $nrocomprobante . " ";

		$sql.=" ORDER BY prosic_comprobante.id_mes,CAST(prosic_comprobante.codigo_comprobante AS UNSIGNED)";
		if ($limit != '')$sql.=$limit;
		$result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function cargar_data_asiento_provisiones($nombre_mes='', $nrocomprobante='', $limit=''){
        $sql = "SELECT
				prosic_comprobante.id_comprobante
				, prosic_comprobante.codigo_comprobante
				, prosic_comprobante.emision_comprobante
				, prosic_comprobante.total_comprobante
				, prosic_comprobante.status_comprobante
				, prosic_anexo.codigo_anexo
				, prosic_subdiario.id_subdiario
				, prosic_subdiario.codigo_subdiario
				, prosic_subdiario.nombre_subdiario
				, prosic_anio.nombre_anio
				, prosic_mes.nombre_mes
				, prosic_tipo_comprobante.codigo_tipo_comprobante
				, prosic_tipo_comprobante.nombre_tipo_comprobante
				,prosic_comprobante.nro_comprobante
				,prosic_moneda.codigo_moneda
				,prosic_comprobante.status_comprobante
				FROM
				prosic_comprobante
				INNER JOIN prosic_anexo				ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
				INNER JOIN prosic_mes				ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
				INNER JOIN prosic_anio				ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
				INNER JOIN prosic_subdiario			ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
				INNER JOIN prosic_tipo_comprobante	ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
				INNER JOIN prosic_moneda			ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
				WHERE  prosic_comprobante.id_subdiario=10";			
		if ($nombre_mes != '')$sql.=" AND prosic_mes.nombre_mes='" . $nombre_mes . "'";
        if ($nrocomprobante != '')$sql.=" AND prosic_comprobante.codigo_comprobante =" . $nrocomprobante . " ";

		$sql.=" ORDER BY prosic_comprobante.id_mes,CAST(prosic_comprobante.codigo_comprobante AS UNSIGNED)";
		if ($limit != '')$sql.=$limit;
		$result = $this->Consulta_Mysql($sql);
        return $result;
    }

	
    function cargar_data_asiento_apertura() {
        $sql = "SELECT
    prosic_comprobante.id_comprobante
    , prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.status_comprobante
    , prosic_anexo.codigo_anexo
    , prosic_subdiario.id_subdiario
    , prosic_subdiario.codigo_subdiario
    , prosic_subdiario.nombre_subdiario
    , prosic_anio.nombre_anio
    , prosic_mes.nombre_mes
    , prosic_tipo_comprobante.codigo_tipo_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    ,prosic_comprobante.nro_comprobante
    ,prosic_moneda.codigo_moneda
	,prosic_comprobante.status_comprobante
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo
        ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_mes
        ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
    INNER JOIN prosic_anio
        ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
    INNER JOIN prosic_subdiario
        ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
    INNER JOIN prosic_tipo_comprobante
        ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
        INNER JOIN prosic_moneda
        ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
			WHERE  prosic_comprobante.id_subdiario=1";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function cargar_data_provisiones() {
        $sql = "SELECT
    prosic_comprobante.id_comprobante
    , prosic_comprobante.codigo_comprobante
    , prosic_comprobante.emision_comprobante
    , prosic_comprobante.total_comprobante
    , prosic_comprobante.status_comprobante
    , prosic_anexo.codigo_anexo
    , prosic_subdiario.id_subdiario
    , prosic_subdiario.codigo_subdiario
    , prosic_subdiario.nombre_subdiario
    , prosic_anio.nombre_anio
    , prosic_mes.nombre_mes
    , prosic_tipo_comprobante.codigo_tipo_comprobante
    , prosic_tipo_comprobante.nombre_tipo_comprobante
    ,prosic_comprobante.nro_comprobante
    ,prosic_moneda.codigo_moneda
    FROM
    prosic_comprobante
    INNER JOIN prosic_anexo
        ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
    INNER JOIN prosic_mes
        ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
    INNER JOIN prosic_anio
        ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
    INNER JOIN prosic_subdiario
        ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
    INNER JOIN prosic_tipo_comprobante
        ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
        INNER JOIN prosic_moneda
        ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
			WHERE prosic_comprobante.id_subdiario=10";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function cargar_comprobante_por_subdiario_moneda($id_subdiario, $id_moneda,$nombre_anio='',$nombre_mes='',$nrocomprobante='',$limit='') {
        $sql = "SELECT
		  prosic_comprobante.id_comprobante
              , prosic_comprobante.codigo_comprobante
		, prosic_subdiario.nombre_subdiario
		, prosic_anio.nombre_anio
		, prosic_mes.nombre_mes
		, prosic_comprobante.emision_comprobante
		, prosic_anexo.id_anexo
		, prosic_anexo.codigo_anexo
		, prosic_anexo.descripcion_anexo
		, prosic_tipo_comprobante.id_tipo_comprobante
              , prosic_tipo_comprobante.nombre_tipo_comprobante
		, prosic_comprobante.serie_comprobante
		, prosic_comprobante.nro_comprobante
		, prosic_comprobante.emision_comprobante
		, prosic_comprobante.total_comprobante
		, prosic_comprobante.glosa_comprobante
              , prosic_comprobante.status_comprobante
			FROM
			    prosic_comprobante
			    INNER JOIN prosic_anexo
			        ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
			    INNER JOIN prosic_tipo_comprobante
			        ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
		            INNER JOIN prosic_subdiario
				ON(prosic_comprobante.id_subdiario=prosic_subdiario.id_subdiario)
			    INNER JOIN prosic_anio
			    ON (prosic_comprobante.id_anio=prosic_anio.id_anio)
			    INNER JOIN prosic_mes
			    ON (prosic_comprobante.id_mes=prosic_mes.id_mes)
			    WHERE prosic_comprobante.id_subdiario = " . $id_subdiario . " AND prosic_comprobante.id_moneda=" . $id_moneda;
        if ($nombre_anio != '')
                $sql.=" AND prosic_anio.nombre_anio='" . $nombre_anio . "'";
        if ($nombre_mes != '')
                $sql.=" AND prosic_mes.nombre_mes='" . $nombre_mes . "'";
        if ($nrocomprobante != '')
                $sql.=" AND prosic_comprobante.nro_comprobante like'%" . $nrocomprobante . "%' ";
		$sql.=" ORDER BY prosic_comprobante.id_mes,CAST(prosic_comprobante.codigo_comprobante AS UNSIGNED)";
		if ($limit != '')
                $sql.=$limit;
        
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
    
    function consulta_comprobante_id($id_comprobante){
        $sql = "SELECT
		     prosic_comprobante.id_comprobante
		    , prosic_comprobante.codigo_comprobante
		    , prosic_comprobante.emision_comprobante
		    , prosic_comprobante.afecto_comprobante
		    , prosic_comprobante.inafecto_comprobante
		    , prosic_comprobante.total_comprobante
		    , prosic_comprobante.igv_comprobante
		    , prosic_comprobante.isc_comprobante    
		    , prosic_comprobante.tipo_cambio_comprobante
		    , prosic_comprobante.id_anexo
		    , prosic_comprobante.id_tipo_comprobante
                  , prosic_comprobante.serie_comprobante
                  , prosic_comprobante.pago_comprobante
		    , prosic_comprobante.nro_comprobante
		    , prosic_subdiario.id_subdiario
		    , prosic_subdiario.codigo_subdiario
		    , prosic_subdiario.nombre_subdiario
		    , prosic_moneda.id_moneda
		    , prosic_moneda.nombre_moneda
		    , prosic_moneda.codigo_moneda
                  , prosic_anio.id_anio
		    , prosic_anio.nombre_anio
                  , prosic_mes.id_mes
		    , prosic_mes.nombre_mes
		    , prosic_anexo.codigo_anexo
		    , prosic_anexo.descripcion_anexo
		    , prosic_tipo_comprobante.codigo_tipo_comprobante
		    , prosic_tipo_comprobante.nombre_tipo_comprobante
		    , prosic_comprobante.id_plan_contable
		    , prosic_plan_contable.cuenta_plan_contable
                  , prosic_plan_contable.descripcion_plan_contable
		    , prosic_comprobante.cuenta_costo    
		    , prosic_comprobante.cargo_abono		    
		    , prosic_comprobante.cuenta_banco
		    , prosic_comprobante.c_a_cuenta_banco
                  , prosic_comprobante.glosa_comprobante
                  , prosic_comprobante.detalle_comprobante
			, prosic_comprobante.status_comprobante
			, prosic_banco.id_banco
			, prosic_comprobante.id_medio_pago
		FROM
		    prosic_comprobante
		    INNER JOIN prosic_mes		        ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
		    INNER JOIN prosic_anio		        ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
		    INNER JOIN prosic_subdiario	        ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
		    INNER JOIN prosic_moneda	        ON (prosic_comprobante.id_moneda = prosic_moneda.id_moneda)
		    INNER JOIN prosic_anexo		        ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
		    INNER JOIN prosic_tipo_comprobante  ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
		    LEFT JOIN prosic_plan_contable      ON (prosic_comprobante.id_plan_contable = prosic_plan_contable.id_plan_contable)
		    LEFT JOIN prosic_banco			    ON (prosic_comprobante.cuenta_banco = prosic_banco.id_plan_contable)
		    WHERE prosic_comprobante.id_comprobante=" . $id_comprobante . "";

        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
    
    function eliminar_detalle_comprobante($id_comprobante){
        $sql1    =   " DELETE FROM prosic_detalle_comprobante WHERE id_comprobante=".$id_comprobante;
        $this->Consulta_Mysql($sql1);
        $sql2    =   " UPDATE prosic_comprobante SET status_comprobante='S' WHERE id_comprobante=".$id_comprobante;
        $this->Consulta_Mysql($sql2);
        return true;
    }

    function eliminar_comprobante($id_comprobante){
        $sql1    =   " DELETE FROM prosic_detalle_comprobante WHERE id_comprobante=".$id_comprobante;
        $this->Consulta_Mysql($sql1);
        $sql2    =   " DELETE FROM prosic_comprobante WHERE id_comprobante=".$id_comprobante;
        $this->Consulta_Mysql($sql2);
        return true;
    }

    function see_periodo($w_anio,$w_mes) {
       $return = "Mes de ";
       switch($w_mes) {
        Case 0:  $return.= "Enero (Apertura)";break;
        Case 1:  $return.= "Enero";break;
        Case 2:  $return.= "Febrero";break;
        Case 3:  $return.= "Marzo";break;
        Case 4:  $return.= "Abril";break;
        Case 5:  $return.= "Mayo";break;
        Case 6:  $return.= "Junio";break;
        Case 7:  $return.= "Julio";break;
        Case 8:  $return.= "Agosto";break;
        Case 9:  $return.= "Setiembre";break;
        Case 10: $return.= "Octubre";break;
        Case 11: $return.= "Noviembre";break;
        Case 12: $return.= "Diciembre";break;
        Case 13: $return.= "Diciembre (Ajustes)";break;
        Case 14: $return.= "Diciembre (Cierre)";break;
       }
       $return.= " - ";
	switch ($w_anio) {
		case 11: $return.="2010";break;
		case 12: $return.="2011";break;
		case 13: $return.="2012";break;
	}
	return $return;
    }

	function consultaReportePorMesTienda($tienda, $mes, $anio) {
        $sql = "SELECT
				DAY(fecha_caja) as dia,
			    SUM((IF(total_delivery IS NULL, 0,total_delivery))+(IF(total_mostrador IS NULL, 0,total_mostrador))+(IF(total_mesa IS NULL, 0,total_mesa))) AS total_general,
				SUM(gasto_delivery) AS gasto_delivery,
				SUM(gasto_personal) AS gasto_personal,
				SUM(consumo_contado) AS consumo_contado,
				SUM(consumo_credito) AS consumo_credito,
				SUM(gasto_planilla) AS gasto_planilla
				FROM prosic_caja
				WHERE MONTH(fecha_caja)=" . $mes . " AND YEAR(fecha_caja)=" . $anio . "
				GROUP BY fecha_caja ORDER BY fecha_caja";
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }



//------------------------- PROCEDIMIENTO DE BANCO
    function consulta_banco_por_id($id) {
        $sql = "SELECT id_banco,id_plan_contable FROM prosic_banco WHERE id_banco=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function consulta_balcomp_por_mes($id_mes) {
       switch($id_mes)
       {
        Case 0:  $t = "prosic_mayor.ca00,prosic_mayor.aa00,prosic_mayor.c01,prosic_mayor.a01,prosic_mayor.ca01,prosic_mayor.aa01";break;
        Case 1:  $t = "prosic_mayor.ca00,prosic_mayor.aa00,prosic_mayor.c01,prosic_mayor.a01,prosic_mayor.ca01,prosic_mayor.aa01";break;
        Case 2:  $t = "prosic_mayor.ca01,prosic_mayor.aa01,prosic_mayor.c02,prosic_mayor.a02,prosic_mayor.ca02,prosic_mayor.aa02";break;
        Case 3:  $t = "prosic_mayor.ca02,prosic_mayor.aa02,prosic_mayor.c03,prosic_mayor.a03,prosic_mayor.ca03,prosic_mayor.aa03";break;
        Case 4:  $t = "prosic_mayor.ca03,prosic_mayor.aa03,prosic_mayor.c04,prosic_mayor.a04,prosic_mayor.ca04,prosic_mayor.aa04";break;
        Case 5:  $t = "prosic_mayor.ca04,prosic_mayor.aa04,prosic_mayor.c05,prosic_mayor.a05,prosic_mayor.ca05,prosic_mayor.aa05";break;
        Case 6:  $t = "prosic_mayor.ca05,prosic_mayor.aa05,prosic_mayor.c06,prosic_mayor.a06,prosic_mayor.ca06,prosic_mayor.aa06";break;
        Case 7:  $t = "prosic_mayor.ca06,prosic_mayor.aa06,prosic_mayor.c07,prosic_mayor.a07,prosic_mayor.ca07,prosic_mayor.aa07";break;
        Case 8:  $t = "prosic_mayor.ca07,prosic_mayor.aa07,prosic_mayor.c08,prosic_mayor.a08,prosic_mayor.ca08,prosic_mayor.aa08";break;
        Case 9:  $t = "prosic_mayor.ca08,prosic_mayor.aa08,prosic_mayor.c09,prosic_mayor.a09,prosic_mayor.ca09,prosic_mayor.aa09";break;
        Case 10: $t = "prosic_mayor.ca09,prosic_mayor.aa09,prosic_mayor.c10,prosic_mayor.a10,prosic_mayor.ca10,prosic_mayor.aa10";break;
        Case 11: $t = "prosic_mayor.ca10,prosic_mayor.aa10,prosic_mayor.c11,prosic_mayor.a11,prosic_mayor.ca11,prosic_mayor.aa11";break;
        Case 12: $t = "prosic_mayor.ca11,prosic_mayor.aa11,prosic_mayor.c12,prosic_mayor.a12,prosic_mayor.ca12,prosic_mayor.aa12";break;
        Case 13: $t = "prosic_mayor.ca12,prosic_mayor.aa12,prosic_mayor.c13,prosic_mayor.a13,prosic_mayor.ca13,prosic_mayor.aa13";break;
        Case 14: $t = "prosic_mayor.ca13,prosic_mayor.aa13,prosic_mayor.c14,prosic_mayor.a14,prosic_mayor.ca14,prosic_mayor.aa14";break;
       }
       switch($id_mes)
       {
        Case 0:  $td = "prosic_mayor_dolares.ca00,prosic_mayor_dolares.aa00,prosic_mayor_dolares.c01,prosic_mayor_dolares.a01,prosic_mayor_dolares.ca01,prosic_mayor_dolares.aa01";break;
        Case 1:  $td = "prosic_mayor_dolares.ca00,prosic_mayor_dolares.aa00,prosic_mayor_dolares.c01,prosic_mayor_dolares.a01,prosic_mayor_dolares.ca01,prosic_mayor_dolares.aa01";break;
        Case 2:  $td = "prosic_mayor_dolares.ca01,prosic_mayor_dolares.aa01,prosic_mayor_dolares.c02,prosic_mayor_dolares.a02,prosic_mayor_dolares.ca02,prosic_mayor_dolares.aa02";break;
        Case 3:  $td = "prosic_mayor_dolares.ca02,prosic_mayor_dolares.aa02,prosic_mayor_dolares.c03,prosic_mayor_dolares.a03,prosic_mayor_dolares.ca03,prosic_mayor_dolares.aa03";break;
        Case 4:  $td = "prosic_mayor_dolares.ca03,prosic_mayor_dolares.aa03,prosic_mayor_dolares.c04,prosic_mayor_dolares.a04,prosic_mayor_dolares.ca04,prosic_mayor_dolares.aa04";break;
        Case 5:  $td = "prosic_mayor_dolares.ca04,prosic_mayor_dolares.aa04,prosic_mayor_dolares.c05,prosic_mayor_dolares.a05,prosic_mayor_dolares.ca05,prosic_mayor_dolares.aa05";break;
        Case 6:  $td = "prosic_mayor_dolares.ca05,prosic_mayor_dolares.aa05,prosic_mayor_dolares.c06,prosic_mayor_dolares.a06,prosic_mayor_dolares.ca06,prosic_mayor_dolares.aa06";break;
        Case 7:  $td = "prosic_mayor_dolares.ca06,prosic_mayor_dolares.aa06,prosic_mayor_dolares.c07,prosic_mayor_dolares.a07,prosic_mayor_dolares.ca07,prosic_mayor_dolares.aa07";break;
        Case 8:  $td = "prosic_mayor_dolares.ca07,prosic_mayor_dolares.aa07,prosic_mayor_dolares.c08,prosic_mayor_dolares.a08,prosic_mayor_dolares.ca08,prosic_mayor_dolares.aa08";break;
        Case 9:  $td = "prosic_mayor_dolares.ca08,prosic_mayor_dolares.aa08,prosic_mayor_dolares.c09,prosic_mayor_dolares.a09,prosic_mayor_dolares.ca09,prosic_mayor_dolares.aa09";break;
        Case 10: $td = "prosic_mayor_dolares.ca09,prosic_mayor_dolares.aa09,prosic_mayor_dolares.c10,prosic_mayor_dolares.a10,prosic_mayor_dolares.ca10,prosic_mayor_dolares.aa10";break;
        Case 11: $td = "prosic_mayor_dolares.ca10,prosic_mayor_dolares.aa10,prosic_mayor_dolares.c11,prosic_mayor_dolares.a11,prosic_mayor_dolares.ca11,prosic_mayor_dolares.aa11";break;
        Case 12: $td = "prosic_mayor_dolares.ca11,prosic_mayor_dolares.aa11,prosic_mayor_dolares.c12,prosic_mayor_dolares.a12,prosic_mayor_dolares.ca12,prosic_mayor_dolares.aa12";break;
        Case 13: $td = "prosic_mayor_dolares.ca12,prosic_mayor_dolares.aa12,prosic_mayor_dolares.c13,prosic_mayor_dolares.a13,prosic_mayor_dolares.ca13,prosic_mayor_dolares.aa13";break;
        Case 14: $td = "prosic_mayor_dolares.ca13,prosic_mayor_dolares.aa13,prosic_mayor_dolares.c14,prosic_mayor_dolares.a14,prosic_mayor_dolares.ca14,prosic_mayor_dolares.aa14";break;
       }
       switch($id_mes)
       {
        Case 0:  $u = "prosic_mayor.ca00+prosic_mayor.aa00";break;
        Case 1:  $u = "prosic_mayor.ca01+prosic_mayor.aa01";break;
        Case 2:  $u = "prosic_mayor.ca02+prosic_mayor.aa02";break;
        Case 3:  $u = "prosic_mayor.ca03+prosic_mayor.aa03";break;
        Case 4:  $u = "prosic_mayor.ca04+prosic_mayor.aa04";break;
        Case 5:  $u = "prosic_mayor.ca05+prosic_mayor.aa05";break;
        Case 6:  $u = "prosic_mayor.ca06+prosic_mayor.aa06";break;
        Case 7:  $u = "prosic_mayor.ca07+prosic_mayor.aa07";break;
        Case 8:  $u = "prosic_mayor.ca08+prosic_mayor.aa08";break;
        Case 9:  $u = "prosic_mayor.ca09+prosic_mayor.aa09";break;
        Case 10: $u = "prosic_mayor.ca10+prosic_mayor.aa10";break;
        Case 11: $u = "prosic_mayor.ca11+prosic_mayor.aa11";break;
        Case 12: $u = "prosic_mayor.ca12+prosic_mayor.aa12";break;
        Case 13: $u = "prosic_mayor.ca13+prosic_mayor.aa13";break;
        Case 14: $u = "prosic_mayor.ca14+prosic_mayor.aa14";break;
       }

        $sql = "SELECT prosic_mayor.id_cuenta_contable,SUBSTRING(prosic_plan_contable.descripcion_plan_contable,1,25)," . $t . ", prosic_plan_contable.id_tipo_cuenta, prosic_plan_contable.id_moneda, " . $td . "
                  FROM prosic_mayor
                 INNER JOIN prosic_plan_contable ON prosic_mayor.id_cuenta_contable = prosic_plan_contable.cuenta_plan_contable
				  LEFT JOIN prosic_mayor_dolares ON prosic_mayor.id_cuenta_contable = prosic_mayor_dolares.id_cuenta_contable 
                 WHERE " . $u . ">0
              ORDER BY prosic_mayor.id_cuenta_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

	   function consulta_balcta_por_mes($id_mes) {
       switch($id_mes)
       {
        Case 0:  $t = "ca00,aa00,c01,a01,ca01,aa01";break;
        Case 1:  $t = "ca00,aa00,c01,a01,ca01,aa01";break;
        Case 2:  $t = "ca00,aa00,c02,a02,ca02,aa02";break;
        Case 3:  $t = "ca00,aa00,c03,a03,ca03,aa03";break;
        Case 4:  $t = "ca00,aa00,c04,a04,ca04,aa04";break;
        Case 5:  $t = "ca00,aa00,c05,a05,ca05,aa05";break;
        Case 6:  $t = "ca00,aa00,c06,a06,ca06,aa06";break;
        Case 7:  $t = "ca00,aa00,c07,a07,ca07,aa07";break;
        Case 8:  $t = "ca00,aa00,c08,a08,ca08,aa08";break;
        Case 9:  $t = "ca00,aa00,c09,a09,ca09,aa09";break;
        Case 10: $t = "ca00,aa00,c10,a10,ca10,aa10";break;
        Case 11: $t = "ca00,aa00,c11,a11,ca11,aa11";break;
        Case 12: $t = "ca00,aa00,c12,a12,ca12,aa12";break;
        Case 13: $t = "ca00,aa00,c13,a13,ca13,aa13";break;
        Case 14: $t = "ca00,aa00,c14,a14,ca14,aa14";break;
       }
       switch($id_mes)
       {
        Case 0:  $u = "ca00+aa00";break;
        Case 1:  $u = "ca01+aa01";break;
        Case 2:  $u = "ca02+aa02";break;
        Case 3:  $u = "ca03+aa03";break;
        Case 4:  $u = "ca04+aa04";break;
        Case 5:  $u = "ca05+aa05";break;
        Case 6:  $u = "ca06+aa06";break;
        Case 7:  $u = "ca07+aa07";break;
        Case 8:  $u = "ca08+aa08";break;
        Case 9:  $u = "ca09+aa09";break;
        Case 10: $u = "ca10+aa10";break;
        Case 11: $u = "ca11+aa11";break;
        Case 12: $u = "ca12+aa12";break;
        Case 13: $u = "ca13+aa13";break;
        Case 14: $u = "ca14+aa14";break;
       }

        $sql = "SELECT id_cuenta_contable,SUBSTRING(descripcion_plan_contable,1,25)," . $t . ",prosic_plan_contable.id_tipo_cuenta
                  FROM prosic_mayor
                 INNER JOIN prosic_plan_contable ON prosic_mayor.id_cuenta_contable = prosic_plan_contable.cuenta_plan_contable
                 WHERE " . $u . ">0
              ORDER BY id_cuenta_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
    function consulta_si_cuenta($id_mes,$cuenta) {
       switch($id_mes)
       {
        Case 0:  $t = "ca00,aa00,c01,a01,ca01,aa01";break;
        Case 1:  $t = "ca00,aa00,c01,a01,ca01,aa01";break;
        Case 2:  $t = "ca01,aa01,c02,a02,ca03,aa02";break;
        Case 3:  $t = "ca02,aa02,c03,a03,ca03,aa03";break;
        Case 4:  $t = "ca03,aa03,c04,a04,ca04,aa04";break;
        Case 5:  $t = "ca04,aa04,c05,a05,ca05,aa05";break;
        Case 6:  $t = "ca05,aa05,c06,a06,ca06,aa06";break;
        Case 7:  $t = "ca06,aa06,c07,a07,ca07,aa07";break;
        Case 8:  $t = "ca07,aa07,c08,a08,ca08,aa08";break;
        Case 9:  $t = "ca08,aa08,c09,a09,ca09,aa09";break;
        Case 10: $t = "ca09,aa09,c10,a10,ca10,aa10";break;
        Case 11: $t = "ca10,aa10,c11,a11,ca11,aa11";break;
        Case 12: $t = "ca11,aa11,c12,a12,ca12,aa12";break;
        Case 13: $t = "ca12,aa12,c13,a13,ca13,aa13";break;
        Case 14: $t = "ca13,aa13,c14,a14,ca14,aa14";break;
       }
        $sql = "SELECT id_cuenta_contable,SUBSTRING(descripcion_plan_contable,1,25)," . $t . "
                  FROM prosic_mayor
                 INNER JOIN prosic_plan_contable ON prosic_mayor.id_cuenta_contable = prosic_plan_contable.cuenta_plan_contable
                 WHERE prosic_plan_contable.cuenta_plan_contable='" . $cuenta . "'
              ORDER BY id_cuenta_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_si_dolar($id_mes,$cuenta) {
       switch($id_mes)
       {
        Case 0:  $t = "ca00,aa00,c01,a01,ca01,aa01";break;
        Case 1:  $t = "ca00,aa00,c01,a01,ca01,aa01";break;
        Case 2:  $t = "ca01,aa01,c02,a02,ca03,aa02";break;
        Case 3:  $t = "ca02,aa02,c03,a03,ca03,aa03";break;
        Case 4:  $t = "ca03,aa03,c04,a04,ca04,aa04";break;
        Case 5:  $t = "ca04,aa04,c05,a05,ca05,aa05";break;
        Case 6:  $t = "ca05,aa05,c06,a06,ca06,aa06";break;
        Case 7:  $t = "ca06,aa06,c07,a07,ca07,aa07";break;
        Case 8:  $t = "ca07,aa07,c08,a08,ca08,aa08";break;
        Case 9:  $t = "ca08,aa08,c09,a09,ca09,aa09";break;
        Case 10: $t = "ca09,aa09,c10,a10,ca10,aa10";break;
        Case 11: $t = "ca10,aa10,c11,a11,ca11,aa11";break;
        Case 12: $t = "ca11,aa11,c12,a12,ca12,aa12";break;
        Case 13: $t = "ca12,aa12,c13,a13,ca13,aa13";break;
        Case 14: $t = "ca13,aa13,c14,a14,ca14,aa14";break;
       }
        $sql = "SELECT id_cuenta_contable,SUBSTRING(descripcion_plan_contable,1,25)," . $t . "
                  FROM prosic_mayor_dolares
                 INNER JOIN prosic_plan_contable ON prosic_mayor_dolares.id_cuenta_contable = prosic_plan_contable.cuenta_plan_contable
                 WHERE prosic_plan_contable.cuenta_plan_contable='" . $cuenta . "'
              ORDER BY id_cuenta_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
/**
     * Function para Consultar la cuenta automatica para la generacion de asiento de comprobante
     * $id_auto : numero de id de registro en la tabla prosic_automatico
     */
    function consulta_cuenta_prosic_automatico($id_auto) {
        $sql = "SELECT cuenta_automatico FROM prosic_automatico WHERE id_automatico = " . $id_auto;
        $result = $this->Consulta_Mysql($sql);
        $row_auto = mysql_fetch_array($result);
        $cta_auto = $row_auto[0];
        return $cta_auto;
    }
/**
* PROCEDMIENTOS PARA LA MIGRACION DEL ALMACEN A CONTABILIDAD
**/
	function llenar_migrar_almacen($id_com,$id_ope){
	$sql = "SELECT " . $id_com . " as id_comprobante
               , 'D' as tipo_digito
		, prosic_plan_contable.id_plan_contable
		, prosic_plan_contable.cuenta_plan_contable
		, 'C' as cargar_abonar
		, round( (alm0022010.alm0020009/1.18),2) as importe_soles
		, round(((alm0022010.alm0020009/prosic_tipo_cambio.venta_sunat)/1.18),2) as importe_dolares
		, prosic_anexo.id_anexo
		, alm0012010.alm0010005 as codigo_anexo
		, 1 as id_tipo_comprobante
		, '01' as codigo_tipo_comprobante
		, alm0012010.alm0010009 as nro_comprobante
		, alm0012010.alm0010010 as emision_comprobante
		, 1 as id_moneda
		, 'MN' codigo_moneda
		, '' as cuenta_costo
		, tab0090000.tab0090005 as detalle_comprobante
		, alm0012010.alm0010008 as serie_comprobante
        FROM alm0022010
        INNER JOIN alm0012010           ON alm0022010.alm0020004 = alm0012010.alm0010006
        LEFT JOIN tab0090000           ON alm0022010.ALM0020005 = tab0090000.tab0090004
		LEFT  JOIN prosic_plan_contable ON tab0090000.tab0090010 = prosic_plan_contable.cuenta_plan_contable
		LEFT JOIN prosic_anexo         ON alm0012010.alm0010005 = prosic_anexo.codigo_anexo
        LEFT JOIN prosic_tipo_cambio   ON alm0012010.alm0010010 = prosic_tipo_cambio.fecha_tipo_cambio
		WHERE alm0012010.alm0010006=" . $id_ope . " ";
        $result = $this->Consulta_Mysql($sql);
        return $result;
	}
/**
*  Funcion de reporte contabilidad/cuenta corriente 
**/
    function reporteCtaCte($mes_i, $mes_f, $anio, $cuenta, $ruc) {
	$sql ="SELECT prosic_plan_contable.cuenta_plan_contable,
       prosic_plan_contable.descripcion_plan_contable,
       prosic_anexo.codigo_anexo,
       prosic_anexo.descripcion_anexo,
       prosic_comprobante.emision_comprobante,
       prosic_comprobante.id_subdiario,
       prosic_comprobante.codigo_comprobante,
       prosic_tipo_comprobante.sunat_tipo_comprobante,
       prosic_tipo_comprobante.nombre_tipo_comprobante,
       prosic_detalle_comprobante.nro_doc_comprobante,
       prosic_detalle_comprobante.detalle_comprobante,
       prosic_detalle_comprobante.id_moneda,
       prosic_detalle_comprobante.cargar_abonar,
       prosic_detalle_comprobante.importe_soles/importe_dolares as divi,
       prosic_detalle_comprobante.importe_soles,
       prosic_detalle_comprobante.importe_dolares,
       prosic_comprobante.id_mes,
		prosic_comprobante.detalle_comprobante,
		prosic_tipo_comprobante.nombre_tipo_comprobante	
		from prosic_detalle_comprobante
		inner join prosic_comprobante 		on prosic_detalle_comprobante.id_comprobante=prosic_comprobante.id_comprobante
		inner join prosic_anexo 			on prosic_detalle_comprobante.id_anexo=prosic_anexo.id_anexo
		inner join prosic_plan_contable 	on prosic_detalle_comprobante.id_plan_contable =prosic_plan_contable.id_plan_contable
		inner join prosic_tipo_comprobante 	on prosic_tipo_comprobante.id_tipo_comprobante=prosic_detalle_comprobante.id_tipo_comprobante
WHERE ( id_mes BETWEEN " .$mes_i. " AND " .$mes_f. " ) AND cuenta_plan_contable LIKE '" .$cuenta. "%' AND codigo_anexo = " .$ruc. "
order by prosic_plan_contable.cuenta_plan_contable,prosic_anexo.codigo_anexo,prosic_comprobante.emision_comprobante,prosic_detalle_comprobante.cargar_abonar DESC";
        //AND YEAR(emision_comprobante)=" .$anio. " 
		mysql_select_db("dbprosic");
        $res = $this->Consulta_Mysql($sql);
        return $res;
	}
	
    function imprimir_efplan_bg( $anio, $id_mes, $cuenta, $signo) {
	if($signo=="+"){
	    switch($id_mes)
       {
        Case 0:  $t = "ca00-aa00";break;
        Case 1:  $t = "ca01-aa01";break;
        Case 2:  $t = "ca02-aa02";break;
        Case 3:  $t = "ca03-aa03";break;
        Case 4:  $t = "ca04-aa04";break;
        Case 5:  $t = "ca05-aa05";break;
        Case 6:  $t = "ca06-aa06";break;
        Case 7:  $t = "ca07-aa07";break;
        Case 8:  $t = "ca08-aa08";break;
        Case 9:  $t = "ca09-aa09";break;
        Case 10: $t = "ca10-aa10";break;
        Case 11: $t = "ca11-aa11";break;
        Case 12: $t = "ca12-aa12";break;
        Case 13: $t = "ca13-aa13";break;
        Case 14: $t = "ca14-aa14";break;
       }
	}else{
	    switch($id_mes)
       {
        Case 0:  $t = "aa00-ca00";break;
        Case 1:  $t = "aa01-ca01";break;
        Case 2:  $t = "aa02-ca02";break;
        Case 3:  $t = "aa03-ca03";break;
        Case 4:  $t = "aa04-ca04";break;
        Case 5:  $t = "aa05-ca05";break;
        Case 6:  $t = "aa06-ca06";break;
        Case 7:  $t = "aa07-ca07";break;
        Case 8:  $t = "aa08-ca08";break;
        Case 9:  $t = "aa09-ca09";break;
        Case 10: $t = "aa10-ca10";break;
        Case 11: $t = "aa11-ca11";break;
        Case 12: $t = "aa12-ca12";break;
        Case 13: $t = "aa13-ca13";break;
        Case 14: $t = "aa14-ca14";break;
       }
    }
        $sql = " SELECT COALESCE(" . $t . ",0) as total
                FROM prosic_mayor
            WHERE id_cuenta_contable='" .$cuenta. "'";
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        $data = $row['total'];
        return $data;     
	}

    function imprimir_efplan_car_abo( $anio, $id_mes, $cuenta, $signo) {
	if($signo=="+"){
	    switch($id_mes)
       {
        Case 0:  $t = "ca00";break;
        Case 1:  $t = "ca01";break;
        Case 2:  $t = "ca02";break;
        Case 3:  $t = "ca03";break;
        Case 4:  $t = "ca04";break;
        Case 5:  $t = "ca05";break;
        Case 6:  $t = "ca06";break;
        Case 7:  $t = "ca07";break;
        Case 8:  $t = "ca08";break;
        Case 9:  $t = "ca09";break;
        Case 10: $t = "ca10";break;
        Case 11: $t = "ca11";break;
        Case 12: $t = "ca12";break;
        Case 13: $t = "ca13";break;
        Case 14: $t = "ca14";break;
       }
	}else{
	    switch($id_mes)
       {
        Case 0:  $t = "aa00";break;
        Case 1:  $t = "aa01";break;
        Case 2:  $t = "aa02";break;
        Case 3:  $t = "aa03";break;
        Case 4:  $t = "aa04";break;
        Case 5:  $t = "aa05";break;
        Case 6:  $t = "aa06";break;
        Case 7:  $t = "aa07";break;
        Case 8:  $t = "aa08";break;
        Case 9:  $t = "aa09";break;
        Case 10: $t = "aa10";break;
        Case 11: $t = "aa11";break;
        Case 12: $t = "aa12";break;
        Case 13: $t = "aa13";break;
        Case 14: $t = "aa14";break;
       }
    }
        $sql = " SELECT COALESCE(" . $t . ",0) as total
                FROM prosic_mayor
            WHERE id_cuenta_contable='" .$cuenta. "'";
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        $data = $row['total'];
        return $data;     
	}

	function consis_comprobante( $id_anio, $id_mes){
		$sql =  "select id_comprobante,
				 id_subdiario,
				 id_anexo,
				 id_tipo_comprobante,
				 id_moneda,
				 id_forma_pago,
				 id_operacion,
				 id_local,
				 status_comprobante,
				 referecia_tipo_doc,
				 id_plan_contable,
				 codigo_comprobante,
				 serie_comprobante,
				 nro_comprobante
            from prosic_comprobante 
		   WHERE prosic_comprobante.id_anio=".$id_anio."
			 AND prosic_comprobante.id_mes=".$id_mes."
		ORDER BY prosic_comprobante.id_subdiario,prosic_comprobante.id_comprobante";
        $result = $this->Consulta_Mysql($sql);
        return $result;
	}

	function consis_detalle_comprobante( $compr ){
		$sql =  "select id_comprobante,
				 id_plan_contable,
				 id_tipo_comprobante,
				 id_moneda,
				 cargar_abonar,
				 importe_soles,
				 importe_dolares,
				 tipo_digito,
				 id_anexo
			FROM prosic_detalle_comprobante
		   WHERE prosic_detalle_comprobante.id_comprobante=" . $compr . "";
//		   WHERE prosic_detalle_comprobante.tipo_digito='D'
//		     AND prosic_detalle_comprobante.id_comprobante=".$compr."";
			$result = $this->Consulta_Mysql($sql);
        return $result;
	}
	
	function consis_subdiario( $vouch, $valor) {
        $sql="SELECT 1 FROM prosic_subdiario where id_subdiario=".$valor; 
        $res=mysql_query($sql); 
        $num=mysql_num_rows($res); 
       if($num==0){ 
			$data="NO EXISTE SUBDIARIO, EN TABLA PROSIC_SUBDIARIO=".$valor;
			$sql = "INSERT INTO temerror (nro_voucher,des_error) VALUES ('" . $vouch . "','" . $data . "')";
			$rs_act=mysql_query($sql);
		}
        return $sql;
	}

	function consis_anexo( $vouch, $valor) {
        $sql="SELECT 1 FROM prosic_anexo where id_anexo=".$valor; 
        $res=mysql_query($sql); 
        $num=mysql_num_rows($res); 
        if($num==0){ 
			$data="NO EXISTE RUC, EN TABLA PROSIC_ANEXO=".$valor;
			$sql = "INSERT INTO temerror (nro_voucher,des_error) VALUES ('" . $vouch . "','" . $data . "')";
			$rs_act=mysql_query($sql);
		}
        return "";
	}

	function consis_tipo_comprobante( $vouch, $valor) {
        $sql="SELECT 1 FROM prosic_tipo_comprobante where id_tipo_comprobante=".$valor; 
        $res=mysql_query($sql); 
        $num=mysql_num_rows($res); 
        if($num==0){ 
			$data="NO EXISTE TIPO DE DOCUMENTO, EN TABLA PROSIC_TIPO_COMPROBANTE=".$valor;
			$sql = "INSERT INTO temerror (nro_voucher,des_error) VALUES ('" . $vouch . "','" . $data . "')";
			$rs_act=mysql_query($sql);
		}
        return "";
	}

	function consis_moneda( $vouch, $valor) {
        $sql="SELECT 1 FROM prosic_moneda where id_moneda=".$valor; 
        $res=mysql_query($sql); 
        $num=mysql_num_rows($res); 
        if($num==0){ 
			$data="NO EXISTE MONEDA, EN TABLA PROSIC_MONEDA=".$valor;
			$sql = "INSERT INTO temerror (nro_voucher,des_error) VALUES ('" . $vouch . "','" . $data . "')";
			$rs_act=mysql_query($sql);
		}
        return "";
	}

	function consis_mensaje( $vouch, $valor) {
		$sql = "INSERT INTO temerror (nro_voucher,des_error) VALUES ('" . $vouch . "','" . $valor . "')";
		$rs_act=mysql_query($sql);
        return "";
	}

	function consis_plan_contable( $vouch, $valor) {
        $sql="SELECT 1 FROM prosic_plan_contable where id_plan_contable=".$valor; 
        $res=mysql_query($sql); 
        $num=mysql_num_rows($res); 
        if($num==0){ 
			$data="NO EXISTE CUENTA CONTABLE, EN TABLA PROSIC_PLAN_CONTABLE=".$valor;
			$sql = "INSERT INTO temerror (nro_voucher,des_error) VALUES ('" . $vouch . "','" . $data . "')";
			$rs_act=mysql_query($sql);
		}
        return "";
	}	

	function consis_error( ){
		$sql =  "select nro_voucher, des_error from temerror";
        $result = $this->Consulta_Mysql($sql);
        return $result;
	}

	function migra_consis($sql){
	    $sqlact=$sql;
        mysql_select_db("dbprosic");
		$rs_act=mysql_query($sqlact);
        return "";
	}

	function costo_plan_contable( $cuenta, $variacion, $valor) {
		$sql = "INSERT INTO temcosto ( cuenta_contable, cuenta_variacion, importe_soles) VALUES ('" . $cuenta . "','" . $variacion . "','" . $valor . "')";
		$rs_act=mysql_query($sql);
        return "";
	}	

	function migra_registro_costos_mercaderia($wcuenta) {
     $sql = "SELECT prosic_plan_contable.id_plan_contable as cuenta,
					variacion.id_plan_contable as variacion,
					temcosto.importe_soles
		FROM temcosto
		LEFT JOIN prosic_plan_contable ON prosic_plan_contable.cuenta_plan_contable = temcosto.cuenta_contable
		LEFT JOIN (Select id_plan_contable,cuenta_plan_contable from prosic_plan_contable ) variacion ON variacion.cuenta_plan_contable = temcosto.cuenta_variacion
		where Substr(temcosto.cuenta_contable,1,2) = '" . $wcuenta . "'";
        $result = $this->Consulta_Mysql($sql);
        return $result;
	}

		function migra_registro_costos_variacion($wcuenta) {
     $sql = "SELECT prosic_plan_contable.id_plan_contable as cuenta,
					variacion.id_plan_contable as variacion,
					temcosto.importe_soles
		FROM temcosto
		LEFT JOIN prosic_plan_contable ON prosic_plan_contable.cuenta_plan_contable = temcosto.cuenta_contable
		LEFT JOIN (Select id_plan_contable,cuenta_plan_contable from prosic_plan_contable ) variacion ON variacion.cuenta_plan_contable = temcosto.cuenta_variacion
		where Substr(temcosto.cuenta_variacion,1,2) = '" . $wcuenta . "'";
        $result = $this->Consulta_Mysql($sql);
        return $result;
	}

   function imprimir_bc_por_periodo($w_cta, $w_len) {
        $sql = " SELECT prosic_mayor.id_cuenta_contable,substring(prosic_plan_contable.descripcion_plan_contable,1,40),c01,c02,c03,c04,c05,c06,c07,c08,c09,c10,c11,c12,   
		                c01+c02+c03+c04+c05+c06+c07+c08+c09+c10+c11+c12 as total
                FROM prosic_mayor
			inner join prosic_plan_contable on prosic_mayor.id_cuenta_contable=prosic_plan_contable.cuenta_plan_contable
            WHERE substring(prosic_mayor.id_cuenta_contable,1," . $w_len . ")='" .$w_cta. "'
			  and Round(c01+c02+c03+c04+c05+c06+c07+c08+c09+c10+c11+c12,2)<>0.00
			ORDER BY prosic_mayor.id_cuenta_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;	
	}

    function imprimir_bc_var_periodo($w_cta, $w_len) {
        $sql = " SELECT prosic_mayor.id_cuenta_contable,substring(prosic_plan_contable.descripcion_plan_contable,1,40),
		                c01-a01,c02-a02,c03-a03,c04-a04,c05-a05,c06-a06,c07-a07,c08-a08,c09-a09,c10-a10,c11-a11,c12-a12,   
		                c01-a01+c02-a02+c03-a03+c04-a04+c05-a05+c06-a06+c07-a07+c08-a08+c09-a09+c10-a10+c11-a11+c12-a12 as total
                FROM prosic_mayor
			inner join prosic_plan_contable on prosic_mayor.id_cuenta_contable=prosic_plan_contable.cuenta_plan_contable
            WHERE substring(prosic_mayor.id_cuenta_contable,1," . $w_len . ")='" .$w_cta. "'
			  and Round(c01+a01+c02+a02+c03+a03+c04+a04+ca05+a05+c06+a06+c07+a07+c08+a08+c09+a09+c10+a10+c11+a11+c12+a12,2)<>0.00
			ORDER BY prosic_mayor.id_cuenta_contable";
        $result = $this->Consulta_Mysql($sql);
        return $result;	
	}
	
    function cargar_data_asiento_ajustes($nombre_mes='', $nrocomprobante='', $limit=''){
        $sql = "SELECT
				prosic_comprobante.id_comprobante
				, prosic_comprobante.codigo_comprobante
				, prosic_comprobante.emision_comprobante
				, prosic_comprobante.total_comprobante
				, prosic_comprobante.status_comprobante
				, prosic_anexo.codigo_anexo
				, prosic_subdiario.id_subdiario
				, prosic_subdiario.codigo_subdiario
				, prosic_subdiario.nombre_subdiario
				, prosic_anio.nombre_anio
				, prosic_mes.nombre_mes
				, prosic_tipo_comprobante.codigo_tipo_comprobante
				, prosic_tipo_comprobante.nombre_tipo_comprobante
				,prosic_comprobante.nro_comprobante
				,prosic_moneda.codigo_moneda
				,prosic_comprobante.status_comprobante
				FROM
				prosic_comprobante
				INNER JOIN prosic_anexo				ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
				INNER JOIN prosic_mes				ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
				INNER JOIN prosic_anio				ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
				INNER JOIN prosic_subdiario			ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
				INNER JOIN prosic_tipo_comprobante	ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
				INNER JOIN prosic_moneda			ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
				WHERE  prosic_comprobante.id_subdiario=11";			
		if ($nombre_mes != '')$sql.=" AND prosic_mes.nombre_mes='" . $nombre_mes . "'";
        if ($nrocomprobante != '')$sql.=" AND prosic_comprobante.codigo_comprobante =" . $nrocomprobante . " ";

		$sql.=" ORDER BY prosic_comprobante.id_mes,CAST(prosic_comprobante.codigo_comprobante AS UNSIGNED)";
		if ($limit != '')$sql.=$limit;
		$result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function cargar_data_asiento_cierre($nombre_mes='', $nrocomprobante='', $limit=''){
        $sql = "SELECT
				prosic_comprobante.id_comprobante
				, prosic_comprobante.codigo_comprobante
				, prosic_comprobante.emision_comprobante
				, prosic_comprobante.total_comprobante
				, prosic_comprobante.status_comprobante
				, prosic_anexo.codigo_anexo
				, prosic_subdiario.id_subdiario
				, prosic_subdiario.codigo_subdiario
				, prosic_subdiario.nombre_subdiario
				, prosic_anio.nombre_anio
				, prosic_mes.nombre_mes
				, prosic_tipo_comprobante.codigo_tipo_comprobante
				, prosic_tipo_comprobante.nombre_tipo_comprobante
				,prosic_comprobante.nro_comprobante
				,prosic_moneda.codigo_moneda
				,prosic_comprobante.status_comprobante
				FROM
				prosic_comprobante
				INNER JOIN prosic_anexo				ON (prosic_comprobante.id_anexo = prosic_anexo.id_anexo)
				INNER JOIN prosic_mes				ON (prosic_comprobante.id_mes = prosic_mes.id_mes)
				INNER JOIN prosic_anio				ON (prosic_comprobante.id_anio = prosic_anio.id_anio)
				INNER JOIN prosic_subdiario			ON (prosic_comprobante.id_subdiario = prosic_subdiario.id_subdiario)
				INNER JOIN prosic_tipo_comprobante	ON (prosic_comprobante.id_tipo_comprobante = prosic_tipo_comprobante.id_tipo_comprobante)
				INNER JOIN prosic_moneda			ON (prosic_comprobante.id_moneda= prosic_moneda.id_moneda)
				WHERE  prosic_comprobante.id_subdiario=12";			
		if ($nombre_mes != '')$sql.=" AND prosic_mes.nombre_mes='" . $nombre_mes . "'";
        if ($nrocomprobante != '')$sql.=" AND prosic_comprobante.codigo_comprobante =" . $nrocomprobante . " ";

		$sql.=" ORDER BY prosic_comprobante.id_mes,CAST(prosic_comprobante.codigo_comprobante AS UNSIGNED)";
		if ($limit != '')$sql.=$limit;
		$result = $this->Consulta_Mysql($sql);
        return $result;
    }
    /**
     * Function Capturar la persona por un tipo de subdiario y moneda.
     * $id_subdiario	: Codigo de subdiario
     * $id_moneda		: Codigo de moneda
	 * Operaciones de 
     */
    function buscar_comprobante_doc_venta($id_cuenta, $id_anexo, $id_serie, $id_numero ) {
        $sql = "SELECT
					  prosic_plan_contable.id_plan_contable
					, prosic_plan_contable.cuenta_plan_contable
					, prosic_anexo.codigo_anexo
					, prosic_anexo.descripcion_anexo
					, prosic_detalle_comprobante.id_tipo_comprobante
					, prosic_detalle_comprobante.ser_doc_comprobante
					, prosic_detalle_comprobante.nro_doc_comprobante
					, prosic_moneda.id_moneda
					, prosic_detalle_comprobante.fecha_doc_comprobante
					, prosic_tipo_cambio.fecha_tipo_cambio
					, sum(if(prosic_moneda.id_moneda=1,prosic_detalle_comprobante.importe_soles,prosic_detalle_comprobante.importe_dolares*prosic_tipo_cambio.venta_financiero)*if(prosic_detalle_comprobante.cargar_abonar='A',1,-1)) as importe_soles
					, sum(if(prosic_moneda.id_moneda=1,prosic_detalle_comprobante.importe_soles*prosic_tipo_cambio.venta_financiero,prosic_detalle_comprobante.importe_dolares)*if(prosic_detalle_comprobante.cargar_abonar='A',1,-1)) as importe_dolares
				FROM       prosic_detalle_comprobante
				INNER JOIN prosic_plan_contable    ON prosic_detalle_comprobante.id_plan_contable=prosic_plan_contable.id_plan_contable
				INNER JOIN prosic_anexo            ON prosic_detalle_comprobante.id_anexo = prosic_anexo.id_anexo
				INNER JOIN prosic_moneda           ON prosic_detalle_comprobante.id_moneda = prosic_moneda.id_moneda
				LEFT  JOIN prosic_tipo_cambio      ON prosic_detalle_comprobante.fecha_doc_comprobante=prosic_tipo_cambio.fecha_tipo_cambio
				WHERE 1=1 ";
				if ($id_cuenta != '')$sql.=" AND prosic_plan_contable.cuenta_plan_contable LIKE '%" . $id_cuenta . "%'";
    if ($id_anexo != '')$sql.=" AND prosic_anexo.codigo_anexo LIKE '%" . $id_anexo . "%'";
    if ($id_numero != '')$sql.=" AND prosic_detalle_comprobante.nro_doc_comprobante LIKE '%" . $id_numero . "%'";
			$sql.=" group by prosic_plan_contable.id_plan_contable
					, prosic_plan_contable.cuenta_plan_contable
					, prosic_anexo.codigo_anexo
					, prosic_anexo.descripcion_anexo
					, prosic_detalle_comprobante.id_tipo_comprobante
					, prosic_detalle_comprobante.ser_doc_comprobante
					, prosic_detalle_comprobante.nro_doc_comprobante
					, prosic_moneda.id_moneda
					, prosic_detalle_comprobante.fecha_doc_comprobante
					, prosic_tipo_cambio.fecha_tipo_cambio
					having importe_soles>0";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

   function list_mayor_sunatbc($codanio) {
  		$sql="select codigo_sunatbc,sidebe_sunatbc,sihaber_sunatbc,mvdebe_sunatbc,mvhaber_sunatbc,trdebe_sunatbc,trhaber_sunatbc
			from prosic_sunatbc
		   where prosic_sunatbc.id_anio=" . $codanio;
       $result = $this->Consulta_Mysql($sql);
        return $result;
    }
	
   function detsi_mayor_sunatbc($codanio, $codbg) {
  		$sql="select 
				prosic_plan_contable.codigo_sunatbc,sum(if(cargar_abonar='C',importe_soles,0)),sum(if(cargar_abonar='A',importe_soles,0))
			from prosic_detalle_comprobante
		   inner join prosic_comprobante   on prosic_comprobante.id_comprobante=prosic_detalle_comprobante.id_comprobante
		   inner join prosic_plan_contable on prosic_plan_contable.id_plan_contable= prosic_detalle_comprobante.id_plan_contable
		   where prosic_comprobante.id_anio=" . $codanio . "
			 and prosic_comprobante.id_subdiario=1
			 and codigo_sunatbc<>''
		   group by prosic_plan_contable.codigo_sunatbc";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

	function detmv_mayor_sunatbc($codanio, $codbg) {
  		$sql="select 
				prosic_plan_contable.codigo_sunatbc,sum(if(cargar_abonar='C',importe_soles,0)),sum(if(cargar_abonar='A',importe_soles,0))
			from prosic_detalle_comprobante
		   inner join prosic_comprobante   on prosic_comprobante.id_comprobante=prosic_detalle_comprobante.id_comprobante
		   inner join prosic_plan_contable on prosic_plan_contable.id_plan_contable= prosic_detalle_comprobante.id_plan_contable
		   where prosic_comprobante.id_anio=" . $codanio . "
			 and prosic_comprobante.id_subdiario<>1
			 and codigo_sunatbc<>''
		   group by prosic_plan_contable.codigo_sunatbc";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

}
?>