<?php

include_once('Class.Mysql.Prosic.php');

class Gerencia_Prosic extends Mysql_Prosic {

    public function consultaReporteDiarioFechaTienda($tienda, $fecha) {
        $sql = "SELECT 	
				id_turno,
				total_delivery,
				total_mostrador,
				total_mesa,
				total_soles,
				total_tarjeta, 
				total_boletas,
				total_facturas,
				total_manual_boleta,
				total_manual_factura,
				total_dolares,
				total_cambio,
				total_propina,
				gasto_delivery,
				gasto_personal,
				consumo_contado,
				consumo_credito,
				gasto_planilla
				FROM
				prosic_caja 
				WHERE fecha_caja='" . $fecha . "'
				ORDER BY id_turno;";
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }

    public function consultaReportePorMesTienda($tienda, $mes, $anio) {
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


/* reporte diario gerencia - para anio anterior - oz */

    public function consultaAnioPasadoDiario($fechap) {
        $sql = "SELECT
				am_pueblolibre,
			        pm_pueblolibre,
				am_sanisidro,
				pm_sanisidro,
				am_sanborja,
				pm_sanborja,
				am_miraflores,
				pm_miraflores
				FROM caja_local WHERE fecha_local = '" .$fechap. "' ";
        mysql_select_db("dbprosic_server_caja");
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }


    public function consultaAnioPasadoMes($mes, $anio, $dia) {
        $sql = "SELECT			
				SUM(am_pueblolibre) as am_pueblolibre,
			       SUM(pm_pueblolibre) as pm_pueblolibre,
				SUM(am_sanisidro) as am_sanisidro,
				SUM(pm_sanisidro) as pm_sanisidro,
				SUM(am_sanborja) as am_sanborja,
				SUM(pm_sanborja) as pm_sanborja,
				SUM(am_miraflores) as am_miraflores,
				SUM(pm_miraflores) as pm_miraflores
				FROM caja_local WHERE MONTH(fecha_local) = '".$mes."' AND YEAR(fecha_local)='".$anio."'  AND day(fecha_local)<='".$dia."'";
        mysql_select_db("dbprosic_server_caja");
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

/* reporte diario gerencia - para anio anterior - oz */

    public function consultaAcumuladoMes($tienda, $mes, $anio, $fecha_caja) {
        $sql = "SELECT
			SUM((IF(total_delivery IS NULL, 0,total_delivery))+(IF(total_mostrador IS NULL, 0,total_mostrador))+(IF(total_mesa IS NULL, 0,total_mesa))) AS total_acumulado
			FROM prosic_caja
			WHERE MONTH(fecha_caja)=" . $mes . " AND YEAR(fecha_caja)=" . $anio . " and fecha_caja<='" . $fecha_caja . "'
			GROUP BY MONTH(fecha_caja) ORDER BY fecha_caja";
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        $data = $row['total_acumulado'];
        return $data;
    }

    public function consultaReportePorMesVta($tienda, $mes, $anio) {
        $sql = "SELECT  prosic_tipo_comprobante.id_tipo_comprobante,
                        prosic_tipo_comprobante.nombre_tipo_comprobante,
                        prosic_mesa_pedido.nro_serie, 
                        min( nro_comprobante ) as nro_menor,
                        max( nro_comprobante ) as nro_mayor,
                        sum( subtotal + descuento) as subtotal,
                        sum( descuento ) as descuento,
                        sum( subtotal ) as basetotal,
                        sum( servicio ) as servicio,
                        sum( igv ) as igv,
                        sum( subtotal + descuento + igv + servicio ) as total
                   FROM prosic_mesa_pedido
                  INNER JOIN prosic_caja ON prosic_mesa_pedido.id_caja = prosic_caja.id_caja
                  INNER JOIN prosic_tipo_comprobante ON prosic_mesa_pedido.id_tipo_comprobante  = prosic_tipo_comprobante.id_tipo_comprobante
                  WHERE MONTH(fecha_caja)=" . $mes . " AND YEAR(fecha_caja)=" . $anio . "
                    AND status_mesa_pedido='FI'
                  GROUP BY prosic_tipo_comprobante.id_tipo_comprobante, prosic_tipo_comprobante.nombre_tipo_comprobante ,prosic_mesa_pedido.nro_serie";
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    public function consultaReportePorAlmVta($tienda, $mes, $anio) {
        $sql =  "SELECT prosic_producto.id_producto,prosic_producto.nombre_producto,sum(detalle_mesa_pedido.cantidad) as sumcan
		     FROM prosic_producto
		    inner join detalle_mesa_pedido on prosic_producto.id_producto = detalle_mesa_pedido.id_producto
		    inner join prosic_mesa_pedido  on detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido
		    inner join prosic_caja         on prosic_mesa_pedido.id_caja = prosic_caja.id_caja 
		    WHERE prosic_producto.id_producto in (280, 281 ,282 ,279 ,289 ,285 ,290 ,286 ,291 ,284 ,283 ,287 )
                    AND detalle_mesa_pedido.status_detalle='AC'
                    AND MONTH(fecha_caja)=" . $mes . " AND YEAR(fecha_caja)=" . $anio . "
                    AND status_mesa_pedido='FI'
                  group by prosic_producto.id_producto,prosic_producto.nombre_producto
                  order by prosic_producto.nombre_producto";
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    public function reporteCtaCte($mes_i, $mes_f, $anio, $cuenta, $ruc) {
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
	inner join prosic_comprobante on 
	prosic_detalle_comprobante.id_comprobante=prosic_comprobante.id_comprobante
	inner join prosic_anexo on prosic_detalle_comprobante.id_anexo=prosic_anexo.id_anexo
	inner join prosic_plan_contable on prosic_detalle_comprobante.id_plan_contable =prosic_plan_contable.id_plan_contable
	inner join prosic_tipo_comprobante on 
	prosic_tipo_comprobante.id_tipo_comprobante=prosic_detalle_comprobante.id_tipo_comprobante
WHERE ( id_mes BETWEEN " .$mes_i. " AND " .$mes_f. " ) AND cuenta_plan_contable LIKE '" .$cuenta. "%' AND codigo_anexo = '" .$ruc. "'
order by prosic_plan_contable.cuenta_plan_contable,prosic_anexo.codigo_anexo,prosic_comprobante.emision_comprobante,prosic_detalle_comprobante.cargar_abonar DESC";
        /*mysql_select_db("dbprosic");*/
		//AND YEAR(emision_comprobante)=" .$anio. " 
        $res = $this->Consulta_Mysql($sql);
        return $res;
}

public function reporteCtaCte_sinruc($mes_i, $mes_f, $anio, $cuenta) {
	$sql ="SELECT prosic_plan_contable.cuenta_plan_contable,
       prosic_plan_contable.descripcion_plan_contable,
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
	prosic_tipo_comprobante.nombre_tipo_comprobante,	
       prosic_anexo.codigo_anexo,
       prosic_anexo.descripcion_anexo,
	   prosic_detalle_comprobante.ser_doc_comprobante
	   from prosic_detalle_comprobante
	inner join prosic_comprobante on 
	prosic_detalle_comprobante.id_comprobante=prosic_comprobante.id_comprobante
	inner join prosic_anexo on prosic_detalle_comprobante.id_anexo=prosic_anexo.id_anexo
	inner join prosic_plan_contable on prosic_detalle_comprobante.id_plan_contable =prosic_plan_contable.id_plan_contable
	inner join prosic_tipo_comprobante on 
	prosic_tipo_comprobante.id_tipo_comprobante=prosic_detalle_comprobante.id_tipo_comprobante
WHERE ( id_mes BETWEEN " .$mes_i. " AND " .$mes_f. " ) AND cuenta_plan_contable LIKE '" .$cuenta. "%'
order by prosic_plan_contable.cuenta_plan_contable,prosic_comprobante.emision_comprobante,prosic_detalle_comprobante.cargar_abonar DESC";
        /*mysql_select_db("dbprosic");*/
		//AND YEAR(emision_comprobante)=" .$anio. " A
        $res = $this->Consulta_Mysql($sql);
        return $res;
}

    public function MovCtaCtependiente($mes_i, $mes_f, $anio, $cuenta, $ruc) {
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
	inner join prosic_comprobante      on prosic_detalle_comprobante.id_comprobante=prosic_comprobante.id_comprobante
	inner join prosic_anexo            on prosic_detalle_comprobante.id_anexo=prosic_anexo.id_anexo
	inner join prosic_plan_contable    on prosic_detalle_comprobante.id_plan_contable =prosic_plan_contable.id_plan_contable
	inner join prosic_tipo_comprobante on prosic_tipo_comprobante.id_tipo_comprobante=prosic_detalle_comprobante.id_tipo_comprobante
      WHERE ( id_mes BETWEEN " .$mes_i. " AND " .$mes_f. " ) 
		AND cuenta_plan_contable LIKE '" .$cuenta. "%' 
		AND codigo_anexo = '" .$ruc. "'
   order by prosic_plan_contable.cuenta_plan_contable,
            prosic_anexo.codigo_anexo, 
			prosic_detalle_comprobante.nro_doc_comprobante,
			prosic_comprobante.emision_comprobante,
			prosic_detalle_comprobante.cargar_abonar DESC";
//AND YEAR(emision_comprobante)=" .$anio. " 
        $res = $this->Consulta_Mysql($sql);
        return $res;
}

    public function reporteCtaCte_pendiente($mes_i, $mes_f, $anio, $cuenta, $ruc) {
        $sql = "SELECT
       prosic_plan_contable.id_plan_contable , 
       prosic_plan_contable.cuenta_plan_contable , 
       prosic_anexo.codigo_anexo , 
       prosic_anexo.descripcion_anexo , 
       prosic_detalle_comprobante.id_tipo_comprobante , 
       prosic_detalle_comprobante.ser_doc_comprobante , 
       prosic_detalle_comprobante.nro_doc_comprobante , 
       prosic_moneda.id_moneda,
sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='C',1,0)) as cargo_soles,
sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='C',1,0)/prosic_tipo_cambio.compra_sunat) as cargo_dolares,
sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='A',1,0)) as abono_soles,
sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='A',1,0)/prosic_tipo_cambio.compra_sunat) as abono_dolares
				FROM       prosic_detalle_comprobante
				INNER JOIN prosic_comprobante      ON prosic_detalle_comprobante.id_comprobante = prosic_comprobante.id_comprobante
				INNER JOIN prosic_plan_contable    ON prosic_detalle_comprobante.id_plan_contable=prosic_plan_contable.id_plan_contable
				INNER JOIN prosic_anexo            ON prosic_detalle_comprobante.id_anexo = prosic_anexo.id_anexo
				INNER JOIN prosic_moneda           ON prosic_detalle_comprobante.id_moneda = prosic_moneda.id_moneda
				LEFT  JOIN prosic_tipo_cambio      ON prosic_detalle_comprobante.fecha_doc_comprobante=prosic_tipo_cambio.fecha_tipo_cambio
				WHERE ( prosic_comprobante.id_mes BETWEEN " .$mes_i. " AND " .$mes_f. " ) 
			 AND cuenta_plan_contable LIKE '" .$cuenta. "%'
             AND codigo_anexo = '" .$ruc. "'
			 group by prosic_plan_contable.id_plan_contable , 
       prosic_plan_contable.cuenta_plan_contable , 
       prosic_anexo.codigo_anexo , 
       prosic_anexo.descripcion_anexo , 
       prosic_detalle_comprobante.id_tipo_comprobante , 
       prosic_detalle_comprobante.ser_doc_comprobante , 
       prosic_detalle_comprobante.nro_doc_comprobante , 
       prosic_moneda.id_moneda 
			order by fecha_doc_comprobante,ser_doc_comprobante,nro_doc_comprobante";
//             AND YEAR(emision_comprobante)=" .$anio. " 

			$res = $this->Consulta_Mysql($sql);
        return $res;

}

    public function reporteCtaCte_MovPendiente($mes_i, $mes_f, $anio, $cuenta, $ruc) {
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
	prosic_tipo_comprobante.nombre_tipo_comprobante	,
	   prosic_detalle_comprobante.ser_doc_comprobante
 	from prosic_detalle_comprobante
	inner join prosic_comprobante      on prosic_detalle_comprobante.id_comprobante=prosic_comprobante.id_comprobante
	inner join prosic_anexo            on prosic_detalle_comprobante.id_anexo=prosic_anexo.id_anexo
	inner join prosic_plan_contable    on prosic_detalle_comprobante.id_plan_contable =prosic_plan_contable.id_plan_contable
	inner join prosic_tipo_comprobante on prosic_tipo_comprobante.id_tipo_comprobante=prosic_detalle_comprobante.id_tipo_comprobante
inner join (SELECT
       prosic_plan_contable.id_plan_contable , 
       prosic_plan_contable.cuenta_plan_contable , 
       prosic_anexo.codigo_anexo , 
       prosic_anexo.descripcion_anexo , 
       prosic_detalle_comprobante.id_tipo_comprobante , 
       prosic_detalle_comprobante.ser_doc_comprobante , 
       prosic_detalle_comprobante.nro_doc_comprobante , 
       prosic_moneda.id_moneda,
sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='C',1,0)) as cargo_soles,
sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='C',1,0)/prosic_tipo_cambio.compra_sunat) as cargo_dolares,
sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='A',1,0)) as abono_soles,
sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='A',1,0)/prosic_tipo_cambio.compra_sunat) as abono_dolares
				FROM       prosic_detalle_comprobante
				INNER JOIN prosic_comprobante      ON prosic_detalle_comprobante.id_comprobante = prosic_comprobante.id_comprobante
				INNER JOIN prosic_plan_contable    ON prosic_detalle_comprobante.id_plan_contable=prosic_plan_contable.id_plan_contable
				INNER JOIN prosic_anexo            ON prosic_detalle_comprobante.id_anexo = prosic_anexo.id_anexo
				INNER JOIN prosic_moneda           ON prosic_detalle_comprobante.id_moneda = prosic_moneda.id_moneda
				LEFT  JOIN prosic_tipo_cambio      ON prosic_detalle_comprobante.fecha_doc_comprobante=prosic_tipo_cambio.fecha_tipo_cambio
				WHERE ( prosic_comprobante.id_mes BETWEEN " .$mes_i. " AND " .$mes_f. " ) 
			 AND prosic_plan_contable.cuenta_plan_contable LIKE '" .$cuenta. "%'
             AND prosic_anexo.codigo_anexo = '" .$ruc. "'
			 group by prosic_plan_contable.id_plan_contable , 
       prosic_plan_contable.cuenta_plan_contable , 
       prosic_anexo.codigo_anexo , 
       prosic_anexo.descripcion_anexo , 
       prosic_detalle_comprobante.id_tipo_comprobante , 
       prosic_detalle_comprobante.ser_doc_comprobante , 
       prosic_detalle_comprobante.nro_doc_comprobante , 
       prosic_moneda.id_moneda ) prosic_movimiento on 
       prosic_movimiento.id_plan_contable  =prosic_plan_contable.id_plan_contable  
       AND prosic_movimiento.cuenta_plan_contable =prosic_plan_contable.cuenta_plan_contable 
       AND prosic_movimiento.codigo_anexo =prosic_anexo.codigo_anexo 
       AND prosic_movimiento.descripcion_anexo =prosic_anexo.descripcion_anexo 
       AND prosic_movimiento.id_tipo_comprobante =prosic_detalle_comprobante.id_tipo_comprobante 
       AND prosic_movimiento.ser_doc_comprobante =prosic_detalle_comprobante.ser_doc_comprobante 
       AND prosic_movimiento.nro_doc_comprobante =prosic_detalle_comprobante.nro_doc_comprobante 
       AND prosic_movimiento.id_moneda=prosic_detalle_comprobante.id_moneda
	WHERE ( prosic_comprobante.id_mes BETWEEN " .$mes_i. " AND " .$mes_f. " ) 
	  AND YEAR(prosic_comprobante.emision_comprobante)=" .$anio. " 
	  AND prosic_plan_contable.cuenta_plan_contable LIKE '" .$cuenta. "%' 
	  AND prosic_anexo.codigo_anexo = '" .$ruc. "'
      AND prosic_movimiento.cargo_soles<>prosic_movimiento.abono_soles
	order by prosic_plan_contable.cuenta_plan_contable,
	         prosic_anexo.codigo_anexo,
			 prosic_comprobante.emision_comprobante,
			 prosic_detalle_comprobante.cargar_abonar DESC";
//             AND YEAR(prosic_comprobante.emision_comprobante)=" .$anio. " 

			 $res = $this->Consulta_Mysql($sql);
        return $res;
}

    public function reporteCtaCte_cabezera($mes_i, $mes_f, $anio, $cuenta){
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
		prosic_tipo_comprobante.nombre_tipo_comprobante	,
		prosic_detalle_comprobante.ser_doc_comprobante
 	from prosic_detalle_comprobante
	inner join prosic_comprobante 		on prosic_detalle_comprobante.id_comprobante=prosic_comprobante.id_comprobante
	inner join prosic_anexo 			on prosic_detalle_comprobante.id_anexo=prosic_anexo.id_anexo
	inner join prosic_plan_contable 	on prosic_detalle_comprobante.id_plan_contable =prosic_plan_contable.id_plan_contable
	inner join prosic_tipo_comprobante 	on prosic_tipo_comprobante.id_tipo_comprobante=prosic_detalle_comprobante.id_tipo_comprobante
WHERE ( id_mes BETWEEN " .$mes_i. " AND " .$mes_f. " ) AND cuenta_plan_contable LIKE '" .$cuenta. "%' 
order by prosic_plan_contable.cuenta_plan_contable,prosic_anexo.codigo_anexo,prosic_comprobante.emision_comprobante,prosic_detalle_comprobante.cargar_abonar DESC";
        /*mysql_select_db("dbprosic");*/
		//AND YEAR(emision_comprobante)=" .$anio. " 
        $res = $this->Consulta_Mysql($sql);
        return $res;
}

    public function reporteCtaCte_pendruc($mes_i, $mes_f, $anio, $cuenta){
	
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
		prosic_tipo_comprobante.nombre_tipo_comprobante	,
		prosic_detalle_comprobante.ser_doc_comprobante
 	from prosic_detalle_comprobante
	inner join prosic_comprobante 		on prosic_detalle_comprobante.id_comprobante=prosic_comprobante.id_comprobante
	inner join prosic_anexo 		on prosic_detalle_comprobante.id_anexo=prosic_anexo.id_anexo
	inner join prosic_plan_contable 	on prosic_detalle_comprobante.id_plan_contable =prosic_plan_contable.id_plan_contable
	inner join prosic_tipo_comprobante 	on prosic_tipo_comprobante.id_tipo_comprobante=prosic_detalle_comprobante.id_tipo_comprobante
	
inner join (SELECT prosic_plan_contable.id_plan_contable , 
       prosic_anexo.codigo_anexo , 
       prosic_detalle_comprobante.id_tipo_comprobante , 
       prosic_detalle_comprobante.ser_doc_comprobante , 
       prosic_detalle_comprobante.nro_doc_comprobante , 
sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='C',1,0)) as cargo_soles,
sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='C',1,0)/prosic_tipo_cambio.compra_sunat) as cargo_dolares,
sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='A',1,0)) as abono_soles,
sum(prosic_detalle_comprobante.importe_soles*if(prosic_detalle_comprobante.cargar_abonar='A',1,0)/prosic_tipo_cambio.compra_sunat) as abono_dolares
				FROM       prosic_detalle_comprobante
				INNER JOIN prosic_comprobante      ON prosic_detalle_comprobante.id_comprobante = prosic_comprobante.id_comprobante
				INNER JOIN prosic_plan_contable    ON prosic_detalle_comprobante.id_plan_contable=prosic_plan_contable.id_plan_contable
				INNER JOIN prosic_anexo            ON prosic_detalle_comprobante.id_anexo = prosic_anexo.id_anexo
				LEFT  JOIN prosic_tipo_cambio      ON prosic_detalle_comprobante.fecha_doc_comprobante=prosic_tipo_cambio.fecha_tipo_cambio
				WHERE ( prosic_comprobante.id_mes BETWEEN " .$mes_i. " AND " .$mes_f. " ) 
			 AND prosic_plan_contable.cuenta_plan_contable LIKE '" .$cuenta. "%'
			 group by prosic_plan_contable.id_plan_contable , 
       prosic_anexo.codigo_anexo , 
       prosic_detalle_comprobante.id_tipo_comprobante , 
       prosic_detalle_comprobante.ser_doc_comprobante , 
       prosic_detalle_comprobante.nro_doc_comprobante) prosic_movimiento on 
       prosic_movimiento.id_plan_contable  =prosic_plan_contable.id_plan_contable  
       AND prosic_movimiento.codigo_anexo =prosic_anexo.codigo_anexo 
       AND prosic_movimiento.id_tipo_comprobante =prosic_detalle_comprobante.id_tipo_comprobante 
       AND prosic_movimiento.ser_doc_comprobante =prosic_detalle_comprobante.ser_doc_comprobante 
       AND prosic_movimiento.nro_doc_comprobante =prosic_detalle_comprobante.nro_doc_comprobante 
	
WHERE ( id_mes BETWEEN " .$mes_i. " AND " .$mes_f. " ) 
  AND prosic_plan_contable.cuenta_plan_contable LIKE '" . $cuenta . "%' 
  AND Round( ( Round(cargo_soles,2) - Round(abono_soles,2) ), 2) <> 0.00
 ORDER BY prosic_plan_contable.cuenta_plan_contable,prosic_anexo.codigo_anexo,prosic_comprobante.emision_comprobante,prosic_detalle_comprobante.cargar_abonar DESC";
//             AND YEAR(prosic_comprobante.emision_comprobante)=" .$anio. " 
   //AND YEAR(emision_comprobante)=" .$anio. " 
        /*mysql_select_db("dbprosic");*/
        $res = $this->Consulta_Mysql($sql);
        return $res;
//        return $sql;
}

public function reporteCtaCte_cabezera_tipo($mes_i, $mes_f, $anio, $cuenta, $id_tc){
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
	prosic_tipo_comprobante.nombre_tipo_comprobante	,
		prosic_detalle_comprobante.ser_doc_comprobante
 	from prosic_detalle_comprobante
	inner join prosic_comprobante on 
	prosic_detalle_comprobante.id_comprobante=prosic_comprobante.id_comprobante
	inner join prosic_anexo on prosic_detalle_comprobante.id_anexo=prosic_anexo.id_anexo
	inner join prosic_plan_contable on prosic_detalle_comprobante.id_plan_contable =prosic_plan_contable.id_plan_contable
	inner join prosic_tipo_comprobante on 
	prosic_tipo_comprobante.id_tipo_comprobante=prosic_detalle_comprobante.id_tipo_comprobante
WHERE ( id_mes BETWEEN " .$mes_i. " AND " .$mes_f. " ) AND cuenta_plan_contable LIKE '" .$cuenta. "%' AND prosic_comprobante.id_tipo_comprobante=" .$id_tc. "
order by prosic_plan_contable.cuenta_plan_contable,prosic_comprobante.emision_comprobante,prosic_detalle_comprobante.nro_doc_comprobante,prosic_detalle_comprobante.cargar_abonar DESC"; 
/*order by prosic_plan_contable.cuenta_plan_contable,prosic_anexo.codigo_anexo,prosic_comprobante.emision_comprobante,prosic_detalle_comprobante.cargar_abonar DESC"; */
 /*       mysql_select_db("dbprosic"); */
 //AND YEAR(emision_comprobante)=" .$anio. " 
        $res = $this->Consulta_Mysql($sql);
        return $res;
}



    public function consultaConsContado($tienda, $mes, $anio) {
        $sql =  "SELECT COALESCE(sum(tota_dscto),0) as sumtot FROM caja_gasto_personal WHERE fecha_caja='" . $anio ."' and id_local=" . $mes ." and tipo_pago=1";
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }

    public function consultaConsCredito($tienda, $mes, $anio) {
        $sql =  "SELECT nombre_personal,nombre_local,fecha_caja,total,tota_dscto FROM caja_gasto_personal WHERE fecha_caja='" . $anio ."' and tipo_pago=2 ORDER BY nombre_local,nombre_personal";
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }

    function get_vale($limit=''){
	mysql_select_db("dbprosic");

        $sql = "select  * from dbprosic.prosic_caja_vale ";
        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }
    function row_vale($idvale){
	mysql_select_db("dbprosic");

        $sql = "select  * from dbprosic.prosic_caja_vale where idvale=".$idvale;        
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        return $row;
    }
    
      function get_canje($limit='') {
	mysql_select_db("dbprosic");

        $sql = "select  * from dbprosic.prosic_caja_canje";
        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }
    function row_canje($idcanje){
	mysql_select_db("dbprosic");

        $sql = "select  * from dbprosic.prosic_caja_canje where idcanje=".$idcanje;        
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        return $row;
    }
  function getCajaTurnoDia($tienda,$fecha_caja) {
        $sql = "SELECT
                prosic_caja.*,
                prosic_cajero.nombre_cajero,
                prosic_cajero.nombre_corto,
                prosic_caja_turno.nombre,
                prosic_local.nombre_local
                FROM prosic_caja
                INNER JOIN prosic_cajero
                ON (prosic_caja.id_cajero = prosic_cajero.id_cajero)
                INNER JOIN prosic_caja_turno
                ON (prosic_caja.id_turno = prosic_caja_turno.id_turno)
                INNER JOIN prosic_local
                ON (prosic_caja.id_local = prosic_local.id_local)
                WHERE prosic_caja.fecha_caja = '".$fecha_caja."' AND prosic_caja.id_turno=1;";
        
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }
	
  function getNombreTurnoNoche($tienda,$fecha_caja) {
        $sql = "SELECT
				prosic_caja.*,
                prosic_cajero.nombre_cajero,
                prosic_cajero.nombre_corto,
                prosic_caja_turno.nombre,
                prosic_local.nombre_local
                FROM prosic_caja
                INNER JOIN prosic_cajero
                ON (prosic_caja.id_cajero = prosic_cajero.id_cajero)
                INNER JOIN prosic_caja_turno
                ON (prosic_caja.id_turno = prosic_caja_turno.id_turno)
                INNER JOIN prosic_local
                ON (prosic_caja.id_local = prosic_local.id_local)
                WHERE prosic_caja.fecha_caja = '".$fecha_caja."' AND prosic_caja.id_turno=3;";
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }
    
    function getCajaTurnoNoche($tienda,$fecha_caja) {
        $sql = "SELECT
				prosic_caja.*,
                prosic_cajero.nombre_cajero,
                prosic_cajero.nombre_corto,
                prosic_caja_turno.nombre,
                prosic_local.nombre_local
                FROM prosic_caja
                INNER JOIN prosic_cajero
                ON (prosic_caja.id_cajero = prosic_cajero.id_cajero)
                INNER JOIN prosic_caja_turno
                ON (prosic_caja.id_turno = prosic_caja_turno.id_turno)
                INNER JOIN prosic_local
                ON (prosic_caja.id_local = prosic_local.id_local)
                WHERE prosic_caja.fecha_caja = '".$fecha_caja."' AND prosic_caja.id_turno=3;";
        
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }
    
    function getCajaTurnoTotales($tienda,$id_caja){
        $sql = "SELECT                  
                SUM(monto_visa)AS subtotal_1,SUM(propina_visa)AS totalp_1,SUM(monto_visa)+SUM(propina_visa)AS total_1
                ,SUM(monto_mastercard)AS subtotal_2,SUM(propina_mastercard)AS totalp_2,SUM(monto_mastercard)+SUM(propina_mastercard)AS total_2
                ,SUM(monto_american)AS subtotal_3,SUM(propina_american)AS totalp_3,SUM(monto_american)+SUM(propina_american)AS total_3
                ,SUM(monto_financieracrm)AS subtotal_4,SUM(propina_financieracrm)AS totalp_4,SUM(monto_financieracrm)+SUM(propina_financieracrm)AS total_4
                ,SUM(monto_dinner)AS subtotal_5,SUM(propina_dinner)AS totalp_5,SUM(monto_dinner)+SUM(propina_dinner)AS total_5
                FROM
                prosic_mesa_fraccionado
                WHERE id_caja=".$id_caja." AND status_fraccionado IN('AC','TE');";
        
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function getConsumoPersonal($id_local,$fecha_caja,$tipo_pago){
         $sql = "SELECT SUM(tota_dscto)AS total 
                FROM caja_gasto_personal
                WHERE id_local=".$id_local." AND fecha_caja='".$fecha_caja."' AND tipo_pago=".$tipo_pago;
        mysql_select_db("dbprosic_server_caja");
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        $data = $row['total'];
        mysql_free_result($res);
        return $data;        
    }
  
    function getListaConsumoPersonal($id_local,$fecha_caja,$tipo_pago) {
        $sql = "SELECT nombre_personal,tota_dscto
                FROM caja_gasto_personal
                WHERE id_local=".$id_local." AND fecha_caja='".$fecha_caja."' AND tipo_pago=".$tipo_pago;
        mysql_select_db("dbprosic_server_caja");
        $res = $this->Consulta_Mysql($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }

    function getCajaPedido($tienda,$fecha_caja) {
        $sql = "SELECT prosic_categoria.id_categoria,
	       prosic_categoria.nombre_categoria,
	       prosic_producto.codigo_producto,
	       prosic_producto.nombre_producto,
	       deli.deli,
	       most.most,
	       mesa.mesa,
	       tota.tota
	  FROM prosic_producto
	 inner join prosic_categoria on prosic_categoria.id_categoria=prosic_producto.id_categoria
	  left join (select detalle_mesa_pedido.id_producto,sum(detalle_mesa_pedido.cantidad) as deli
	               from detalle_mesa_pedido
	              inner join prosic_mesa_pedido on prosic_mesa_pedido.id_mesa_pedido=detalle_mesa_pedido.id_mesa_pedido
	              inner join prosic_caja on prosic_caja.id_caja=prosic_mesa_pedido.id_caja
	              where prosic_caja.fecha_caja='".$fecha_caja."' and prosic_mesa_pedido.id_tipo_pedido=2
	              group by detalle_mesa_pedido.id_producto) deli
	ON deli.id_producto=prosic_producto.id_producto
	  left join (select detalle_mesa_pedido.id_producto,sum(detalle_mesa_pedido.cantidad) as most
	               from detalle_mesa_pedido
	              inner join prosic_mesa_pedido on prosic_mesa_pedido.id_mesa_pedido=detalle_mesa_pedido.id_mesa_pedido
	              inner join prosic_caja on prosic_caja.id_caja=prosic_mesa_pedido.id_caja
	              where prosic_caja.fecha_caja='".$fecha_caja."' and prosic_mesa_pedido.id_tipo_pedido=3
	              group by detalle_mesa_pedido.id_producto) most
	ON most.id_producto=prosic_producto.id_producto
	  left join (select detalle_mesa_pedido.id_producto,sum(detalle_mesa_pedido.cantidad) as mesa
	               from detalle_mesa_pedido
	              inner join prosic_mesa_pedido on prosic_mesa_pedido.id_mesa_pedido=detalle_mesa_pedido.id_mesa_pedido
	              inner join prosic_caja on prosic_caja.id_caja=prosic_mesa_pedido.id_caja
	              where prosic_caja.fecha_caja='".$fecha_caja."' and prosic_mesa_pedido.id_tipo_pedido=1
	              group by detalle_mesa_pedido.id_producto) mesa
	ON mesa.id_producto=prosic_producto.id_producto
	  left join (select detalle_mesa_pedido.id_producto,sum(detalle_mesa_pedido.cantidad) as tota
	               from detalle_mesa_pedido
	              inner join prosic_mesa_pedido on prosic_mesa_pedido.id_mesa_pedido=detalle_mesa_pedido.id_mesa_pedido
	              inner join prosic_caja on prosic_caja.id_caja=prosic_mesa_pedido.id_caja
	              where prosic_caja.fecha_caja='".$fecha_caja."'
	              group by detalle_mesa_pedido.id_producto) tota
	ON tota.id_producto=prosic_producto.id_producto
	WHERE tota.tota >0
	order by prosic_categoria.id_categoria,prosic_producto.nombre_producto";
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }
        
    function getListaProductosTienda($tienda,$filtro_caja,$codloc){
        $sql = "SELECT d.id_producto,p.codigo_producto,p.nombre_producto,SUM(IF(d.cantidad IS NULL,0,d.cantidad)+IF(g.cantidad IS NULL,0,g.cantidad))AS cantidad FROM detalle_mesa_pedido d
                INNER JOIN prosic_producto p
                ON (p.id_producto=d.id_producto)
                INNER JOIN prosic_mesa_pedido m
                ON(d.id_mesa_pedido=m.id_mesa_pedido)
                INNER JOIN prosic_caja c
                ON (c.id_caja=m.id_caja)
            LEFT JOIN (select dbprosic_server_caja.caja_gasto_personal.fecha_caja,
                              dbprosic_server_caja.caja_gasto_personal.id_local,
                              dbprosic_server_caja.caja_gasto_detalle.id_producto,
                              COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) as cantidad
                         from dbprosic_server_caja.caja_gasto_detalle
                        inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
                        where dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
                     group by dbprosic_server_caja.caja_gasto_personal.fecha_caja,
                              dbprosic_server_caja.caja_gasto_personal.id_local,
                              dbprosic_server_caja.caja_gasto_detalle.id_producto) g
                ON (g.id_producto=p.id_producto)
                WHERE c.fecha_caja='".$filtro_caja."' AND d.status_detalle NOT IN('AN') AND p.codigo_producto<='9100' OR p.codigo_producto>='9599'
                GROUP BY d.id_producto
                ORDER BY p.nombre_producto";        
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }
	
    function getListaProductosTiendaFechas($tienda,$filtro_caja,$filtro_caja_final,$codloc){
        $sql = "SELECT d.id_producto,p.codigo_producto,p.nombre_producto,SUM(IF(d.cantidad IS NULL,0,d.cantidad)+IF(g.cantidad IS NULL,0,g.cantidad))AS cantidad FROM detalle_mesa_pedido d
                INNER JOIN prosic_producto p
                ON (p.id_producto=d.id_producto)
                INNER JOIN prosic_mesa_pedido m
                ON(d.id_mesa_pedido=m.id_mesa_pedido)
                INNER JOIN prosic_caja c
                ON (c.id_caja=m.id_caja)
            LEFT JOIN (select dbprosic_server_caja.caja_gasto_personal.fecha_caja,
                              dbprosic_server_caja.caja_gasto_personal.id_local,
                              dbprosic_server_caja.caja_gasto_detalle.id_producto,
                              COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) as cantidad
                         from dbprosic_server_caja.caja_gasto_detalle
                        inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
                        where dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
                     group by dbprosic_server_caja.caja_gasto_personal.fecha_caja,
                              dbprosic_server_caja.caja_gasto_personal.id_local,
                              dbprosic_server_caja.caja_gasto_detalle.id_producto) g
                ON (g.id_producto=p.id_producto)
                WHERE (c.fecha_caja BETWEEN '".$filtro_caja."' AND '".$filtro_caja_final."' ) AND d.status_detalle NOT IN('AN') AND p.codigo_producto<='9100' OR p.codigo_producto>='9599'
                GROUP BY d.id_producto
                ORDER BY p.nombre_producto";        
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $data[] = $row;
        }
		
        return $data;
    }

//PARA PRODUCTOS VENDIDOS EN CAJA
    function get_pgrande($tienda,$filtro_caja,$codloc) {
        $sql = "
            SELECT COALESCE(SUM(IF(prosic_categoria.id_categoria=6,detalle_mesa_pedido.cantidad,detalle_mesa_pedido.cantidad*0.5)),0) AS cantidad
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
            WHERE prosic_caja.fecha_caja='".$filtro_caja."'
			  AND prosic_categoria.id_categoria IN(6,7) AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_ppersonal($tienda,$filtro_caja,$codloc) {
        $sql = "
            SELECT COALESCE(SUM(IF(prosic_categoria.id_categoria=4,detalle_mesa_pedido.cantidad,detalle_mesa_pedido.cantidad*0.5)),0) AS cantidad
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
            WHERE prosic_caja.fecha_caja='".$filtro_caja."' 
			  AND prosic_categoria.id_categoria IN(4,5) AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_pfamiliar($tienda,$filtro_caja,$codloc) {
        $sql = "
            SELECT COALESCE(SUM(IF(prosic_categoria.id_categoria=8,detalle_mesa_pedido.cantidad,detalle_mesa_pedido.cantidad*0.5)),0) AS cantidad
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
            WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_categoria.id_categoria IN(8,9) AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_gmediana($tienda,$filtro_caja,$codloc) {
        $sql = "
            SELECT  COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
            WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN('8102','8106') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')
            GROUP BY  prosic_producto.id_categoria";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_ggrande($tienda,$filtro_caja,$codloc) {
        $sql = "SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                     WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND  prosic_producto.codigo_producto IN('8101','8108','8110') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')
                     GROUP BY  prosic_producto.id_categoria";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_asado($tienda,$filtro_caja,$codloc) {
        $sql= " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                    WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN('2007','2023','2029','2004','2041','2008','2052') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_lcarne($tienda,$filtro_caja,$codloc) {
        $sql = "SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                    WHERE prosic_caja.fecha_caja='".$filtro_caja."' 
					AND prosic_producto.codigo_producto IN('2001') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_lalcachofa($tienda,$filtro_caja,$codloc) {
        $sql = "SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                     WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN('2016') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_caneloni($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(IF(prosic_producto.id_categoria=11,detalle_mesa_pedido.cantidad*3,detalle_mesa_pedido.cantidad)),0) AS cantidad
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
            WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('2009','2030') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_canealcachofa($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(IF(prosic_producto.id_categoria=11,detalle_mesa_pedido.cantidad*3,detalle_mesa_pedido.cantidad)),0) AS cantidad
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('2010') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_triquesos($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN('2030') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_quesos($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN('2040','2043','2048','2046','2058','2047','2059') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_pollo($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                   WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('1504','1510','9045','9049') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_albondiga($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('2012','9050') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_gnochi($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('2035','2036','2038','2040','2044','2045','2049') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function get_panzotti($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
             FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('2033','2034','2037','2041','2048') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }
    
     function get_pan($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('1501','1502') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_salsapesto($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('2013','2020','2022','2029','2049','2060') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_chipollo($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
             FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                  WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('1503') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_primavera($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('2039') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_bruscheta($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('1506') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_gasbotella($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('8102','8106','8103','8109','1003','1007','1008','1013','1006') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_cerveza($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('8104') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_sangria($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) as cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('7101') 
                      AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_sangriamedia($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0)/26*14 as cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('7102') 
                   AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_sangriacopa($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0)/7 as cantidad    
             FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                    WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('7103') 
                      AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_sangriabote($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0)/4*3 as cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                    WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('7104') 
                      AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_fondgrande($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                    WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('7001') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_fondchico($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                     WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('7002') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_vino($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('7007') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_casigrande($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('7004') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_casichico($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                    WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('7005') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_tacarose($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('7003') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function get_tacatinto($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
            FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('7010') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

	function get_cafe($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
             FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('8001','8002','8003','8004','8005','8009') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }
	
     function get_casamarquez($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(detalle_mesa_pedido.cantidad),0) AS cantidad    
             FROM  detalle_mesa_pedido
            INNER JOIN prosic_producto                 ON (detalle_mesa_pedido.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_mesa_pedido              ON (detalle_mesa_pedido.id_mesa_pedido = prosic_mesa_pedido.id_mesa_pedido)
            INNER JOIN prosic_categoria                ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            INNER JOIN prosic_caja                     ON (prosic_mesa_pedido.id_caja = prosic_caja.id_caja)        
                 WHERE prosic_caja.fecha_caja='".$filtro_caja."' AND prosic_producto.codigo_producto IN ('7006') AND detalle_mesa_pedido.status_detalle NOT IN ('AN','EL')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }
	//
	//PARA LAS CANTIDADES DE CONSUMO
	//
    function con_pgrande($tienda,$filtro_caja,$codloc) {
        $sql = "
            SELECT COALESCE(SUM(IF(prosic_categoria.id_categoria=6,dbprosic_server_caja.caja_gasto_detalle.cantidad,dbprosic_server_caja.caja_gasto_detalle.cantidad*0.5)),0) AS cantidad
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_categoria.id_categoria IN(6,7)";
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_ppersonal($tienda,$filtro_caja,$codloc) {
        $sql = "
            SELECT COALESCE(SUM(IF(prosic_categoria.id_categoria=4,dbprosic_server_caja.caja_gasto_detalle.cantidad,dbprosic_server_caja.caja_gasto_detalle.cantidad*0.5)),0) AS cantidad
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
              AND prosic_categoria.id_categoria IN(4,5)";
        mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_pfamiliar($tienda,$filtro_caja,$codloc) {
        $sql = "
            SELECT COALESCE(SUM(IF(prosic_categoria.id_categoria=8,dbprosic_server_caja.caja_gasto_detalle.cantidad,dbprosic_server_caja.caja_gasto_detalle.cantidad*0.5)),0) AS cantidad
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
              AND prosic_categoria.id_categoria IN(8,9)";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_gmediana($tienda,$filtro_caja,$codloc) {
        $sql = "
            SELECT  COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
              AND prosic_producto.codigo_producto IN('8102','8106')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_ggrande($tienda,$filtro_caja,$codloc) {
        $sql = "SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
              AND  prosic_producto.codigo_producto IN ('8101','8108','8110')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_asado($tienda,$filtro_caja,$codloc) {
        $sql= " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
              AND prosic_producto.codigo_producto IN('2007','2023','2029','2004','2041','2008','2052')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_lcarne($tienda,$filtro_caja,$codloc) {
        $sql = "SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
              AND prosic_producto.codigo_producto IN('2001')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_lalcachofa($tienda,$filtro_caja,$codloc) {
        $sql = "SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
              AND prosic_producto.codigo_producto IN('2016')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_caneloni($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(IF(prosic_producto.id_categoria=11,dbprosic_server_caja.caja_gasto_detalle.cantidad*3,dbprosic_server_caja.caja_gasto_detalle.cantidad)),0) AS cantidad
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
              AND prosic_producto.codigo_producto IN ('2009','2030')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_canealcachofa($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(IF(prosic_producto.id_categoria=11,dbprosic_server_caja.caja_gasto_detalle.cantidad*3,dbprosic_server_caja.caja_gasto_detalle.cantidad)),0) AS cantidad
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
              AND prosic_producto.codigo_producto IN ('2010')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_triquesos($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
              AND prosic_producto.codigo_producto IN('2030')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_quesos($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN('2040','2043','2048','2046','2058','2047','2059')";
			  mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_pollo($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('1504','1510','9045','9049')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_albondiga($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('2012','9050')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_gnochi($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('2035','2036','2038','2040','2044','2045','2049')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

    function con_panzotti($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('2033','2034','2037','2041','2048')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }
    
     function con_pan($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('1501','1502')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_salsapesto($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('2013','2020','2022','2029','2049','2060')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_chipollo($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('1503')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_primavera($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('2039')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_bruscheta($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('1506')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_gasbotella($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('8102','8106','8103','1003','1007','1008','1013','1006')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_cerveza($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('8104')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_sangria($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) as cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
              AND prosic_producto.codigo_producto IN ('7101')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_sangriamedia($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0)/26*14 as cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. " 
			  AND prosic_producto.codigo_producto IN ('7102')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_sangriacopa($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0)/7 as cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('7103')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_sangriabote($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0)/4*3 as cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('7104')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_fondgrande($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('7001')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_fondchico($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('7002')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_vino($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('7007')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_casigrande($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('7004')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_casichico($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('7005')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_tacarose($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('7003')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

     function con_tacatinto($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('7010')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }

	function con_cafe($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('8001','8002','8003','8004','8005','8009')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }
	
     function con_casamarquez($tienda,$filtro_caja,$codloc) {
        $sql = " SELECT COALESCE(SUM(dbprosic_server_caja.caja_gasto_detalle.cantidad),0) AS cantidad    
            FROM dbprosic_server_caja.caja_gasto_detalle
            inner join dbprosic_server_caja.caja_gasto_personal on dbprosic_server_caja.caja_gasto_personal.idcaja_gasto_personal=dbprosic_server_caja.caja_gasto_detalle.idcaja_gasto_personal
            INNER JOIN prosic_producto           ON (dbprosic_server_caja.caja_gasto_detalle.id_producto = prosic_producto.id_producto)
            INNER JOIN prosic_categoria          ON (prosic_producto.id_categoria = prosic_categoria.id_categoria)
            WHERE dbprosic_server_caja.caja_gasto_personal.fecha_caja='".$filtro_caja."' 
			  AND dbprosic_server_caja.caja_gasto_personal.id_local=" .$codloc. "
			  AND prosic_producto.codigo_producto IN ('7006')";
       mysql_select_db($tienda);
        $res = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($res);
        return $row;
    }
	
	function limpiaTemp104($db){
	$sql="DELETE FROM tem1042010";
	mysql_select_db($db);
	$this->Consulta_Mysql($sql);
	$sql="insert into dbprosic.tem1042010(tem1042010.codigo_producto,tem1042010.nombre_producto) select p.codigo_producto, p.nombre_producto from dbprosic_cajasi.prosic_producto as p where p.codigo_producto <='9100' or p.codigo_producto>='9599'";
	$this->Consulta_Mysql($sql);
	return true;
	}
	
	function actualizaCantidadSi($can_si,$cod){
$sql="update tem1042010 set cantidad_si=".$can_si." where codigo_producto='".$cod."' ";
	mysql_select_db("dbprosic");
	$this->Consulta_Mysql($sql);
	return true;
}

	function actualizaCantidadMi($can_mi,$cod){
$sql="update tem1042010 set cantidad_mi=".$can_mi." where codigo_producto='".$cod."' ";
	mysql_select_db("dbprosic");
	$this->Consulta_Mysql($sql);
	return true;
}
	function actualizaCantidadSb($can_sb,$cod){
$sql="update tem1042010 set cantidad_sb=".$can_sb." where codigo_producto='".$cod."' ";
	mysql_select_db("dbprosic");
	$this->Consulta_Mysql($sql);
	return true;
}
	function actualizaCantidadPl($can_pl,$cod){
	$sql="update tem1042010 set cantidad_pl=".$can_pl." where codigo_producto='".$cod."' ";
	mysql_select_db("dbprosic");
	$this->Consulta_Mysql($sql);
	return true;
}
	function productosFechas(){
	$sql="SELECT * FROM tem1042010 where (cantidad_si<>'null' or cantidad_mi<>'null' or cantidad_sb<>'null' or cantidad_pl<>'null')";
	mysql_select_db("dbprosic");
	$res = $this->Consulta_Mysql($sql);
    return $res;
}


	
}

?>