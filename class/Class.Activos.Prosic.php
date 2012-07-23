<?php

include_once('Class.Mysql.Prosic.php');

class Activos_Prosic extends Mysql_Prosic {

    function cargar_data_activo($nombre_anio,$nombre_mes,$descripcion_activo,$limit) {
        $sql = "SELECT
				prosic_activo.id_activo
				, prosic_activo.codigo_activo
				, prosic_activo.nombre_activo
				, prosic_activo.descripcion_activo
				, prosic_activo.valor_activo
				, prosic_activo.fecha_activo
				, prosic_activo.status_activo
				, prosic_anio.nombre_anio
				, prosic_mes.nombre_mes
                                , prosic_mes.codigo_mes
                                , prosic_activo.documento_activo
                                ,prosic_activo.valor_activo_soles
				,prosic_moneda.codigo_moneda
				FROM
					dbprosic.prosic_anio
					INNER JOIN dbprosic.prosic_activo
						ON (prosic_anio.id_anio = prosic_activo.id_anio)
					INNER JOIN dbprosic.prosic_mes
						ON (prosic_mes.id_mes = prosic_activo.id_mes)
					INNER JOIN prosic_moneda
						ON (prosic_activo.id_moneda=prosic_moneda.id_moneda)
                        WHERE prosic_activo.status_activo='A' ";
        if($nombre_anio!='')$sql.=" AND prosic_anio.nombre_anio='".$nombre_anio."'";
        if($nombre_mes!='')$sql.=" AND prosic_mes.nombre_mes='".$nombre_mes."'";
        if($descripcion_activo!='')$sql.=" AND prosic_activo.descripcion_activo like'%".$descripcion_activo."%' ";
        $sql.=" order by prosic_activo.id_activo desc";
        if($limit!='')$sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function cargar_activo_id($id) {
        $sql = "SELECT
            prosic_activo.id_activo
            , prosic_activo.codigo_activo
            , prosic_activo.nombre_activo
            , prosic_activo.descripcion_activo
            , prosic_activo.color_activo
            , prosic_activo.marca_activo
            , prosic_activo.motor_activo
            , prosic_activo.placa_activo
            , prosic_activo.modelo_activo
            , prosic_activo.serie_activo
            , prosic_activo.chasis_activo
            , prosic_activo.dimension_activo
            , prosic_activo.fabricacion_activo
            , prosic_activo.documento_activo
            , prosic_activo.valor_activo
            , prosic_activo.fecha_activo
            , prosic_activo.vencimiento_activo
            , prosic_activo.porcentaje_activo
            , prosic_activo.status_activo
            , prosic_activo.id_tipo_activo
            , prosic_activo.id_clase_activo
            , prosic_activo.id_grupo_activo
            , prosic_activo.id_estado_activo
            , prosic_activo.id_familia_activo
            , prosic_activo.id_anio
            , prosic_activo.id_mes
            , prosic_activo.id_tipo_bien
            , prosic_activo.id_tipo_valor
            , prosic_activo.id_tipo_material
            , prosic_activo.id_situacion_activo
            , prosic_activo.id_anexo
            , prosic_activo.id_plan_contable
            , prosic_activo.id_forma_adquisicion
            , prosic_activo.id_local
            , prosic_activo.id_usuario
            , prosic_activo.id_area_empresa
            , prosic_activo.id_moneda
            , prosic_activo.cuenta_provision
            , prosic_activo.cuenta_depreciacion
            , prosic_anexo.descripcion_anexo
            , prosic_anexo.codigo_anexo
            , prosic_plan_contable.cuenta_plan_contable
            , prosic_plan_contable.descripcion_plan_contable
            , prosic_activo.tipo_cambio
            , prosic_activo.valor_activo_soles
        FROM
            prosic_activo
            INNER JOIN prosic_anexo
                ON (prosic_activo.id_anexo = prosic_anexo.id_anexo)
            INNER JOIN prosic_plan_contable
                ON (prosic_activo.id_plan_contable = prosic_plan_contable.id_plan_contable)
        WHERE prosic_activo.id_activo =" . $id;
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        return $row;
    }

    function insertar_activo($campos, $datos) {
        $agregar = $this->sqlInsert("prosic_activo", $campos, $datos);
        return $agregar;
    }

    function actualizar_activo($campos, $datos, $id, $valor) {
        $modificar = $this->sqlUpdate("prosic_activo", $campos, $datos, $id, $valor);
        return $modificar;
    }

    /**
     * Sistema Prosic
     * Function para Cargar Cuenta de Activos
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function cargar_cuenta_de_activos() {
        $sql = "SELECT * FROM prosic_plan_contable WHERE cuenta_plan_contable LIKE '33%' ORDER BY cuenta_plan_contable";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function cargar_cuenta_de_60() {
        $sql = "SELECT * FROM prosic_plan_contable WHERE cuenta_plan_contable LIKE '60%' ORDER BY cuenta_plan_contable";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function cargar_cuenta_de_2() {
        $sql = "SELECT * FROM prosic_plan_contable WHERE cuenta_plan_contable LIKE '2%' ORDER BY cuenta_plan_contable";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    function cargar_cuenta_de_61() {
        $sql = "SELECT * FROM prosic_plan_contable WHERE cuenta_plan_contable LIKE '61%' ORDER BY cuenta_plan_contable";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    /**
     * Sistema Prosic
     * Function para Cargar Cuenta de Activos
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function cargar_cuenta_de_provisiones() {
        $sql = "SELECT * FROM prosic_plan_contable WHERE cuenta_plan_contable LIKE '68%' ORDER BY cuenta_plan_contable";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    /**
     * Sistema Prosic
     * Function para Cargar Cuenta de Activos
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2011
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function cargar_cuenta_de_depreciacion() {
        $sql = "SELECT * FROM prosic_plan_contable WHERE cuenta_plan_contable LIKE '39%' ORDER BY cuenta_plan_contable";
        $res = $this->Consulta_Mysql($sql);
        return $res;
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
    
    function consulta_data_activos_formato(){
    	$sql ="SELECT
				codigo_activo
				,cuenta_depreciacion
				,descripcion_activo
				,marca_activo
				,modelo_activo
				,serie_activo
				,valor_activo
				,adquisicion_adicional
				,mejoras
				,retiros
				,otros_ajustes
				,valor_historico
				,ajuste_inflacion
				,valor_ajustado
				,fecha_activo
				,fecha_uso
				,metodo_aplicado
				,doc_autorizacion
				,porcentaje_activo
				,depreciacion_anterior
				,depreciacion_ejercicio
				,depreciacion_retiro
				,depreciacion_otros
				,depreciacion_acumulada
				,inflacion_depreciacion
				,depreciacion_inflacion
					FROM prosic_activo";
    	$result = $this->Consulta_Mysql($sql);
    	return $result;
    }
    
    function consulta_datos_empresa($id) {
    	$sql	=	"SELECT nombre_empresa,ruc_empresa FROM prosic_empresa WHERE id_empresa=".$id;
    	$result	=	$this->Consulta_Mysql($sql);
    	$row	= 	mysql_fetch_array($result);
    	return $row;
    }

    function copiar_activo($id_activo){
        $sql="INSERT INTO prosic_activo
            (documento_activo, fecha_activo,porcentaje_activo,status_activo,id_tipo_activo
            ,id_clase_activo,id_grupo_activo, id_estado_activo,id_familia_activo,id_anio,
            id_mes,id_tipo_bien,id_tipo_valor,id_tipo_material,id_situacion_activo,
            id_anexo,id_plan_contable,id_forma_adquisicion,id_local,id_usuario,id_area_empresa,id_moneda,tipo_cambio)
            SELECT documento_activo, fecha_activo,porcentaje_activo,status_activo,id_tipo_activo
            ,id_clase_activo,id_grupo_activo, id_estado_activo,id_familia_activo,id_anio,
            id_mes,id_tipo_bien,id_tipo_valor,id_tipo_material,id_situacion_activo,
            id_anexo,id_plan_contable,id_forma_adquisicion,id_local,id_usuario,id_area_empresa,id_moneda,tipo_cambio
            FROM prosic_activo WHERE prosic_activo.id_activo=".$id_activo;
        $this->Consulta_Mysql($sql);
        $id_activo=$this->get_ultimo_id("prosic_activo", "id_activo");
        return $id_activo;
    }
}
?>