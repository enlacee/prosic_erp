<?php

include_once('Class.Mysql.Prosic.php');

class Articulo_Prosic extends Mysql_Prosic {
	


    function consulta_producto2($limit='') {
        $sql = "SELECT
    tab0090000.tab0090001
    , tab0090000.tab0090002
    , tab0240000.tab0240001
    , tab0240000.tab0240002
    , tab0090000.tab0090004
    , tab0090000.tab0090005
    , tab0090000.tab0090006
    , tab0090000.tab0090007
    , tab0090000.tab0090008
    , tab0090000.tab0090009
FROM
    dbprosic.tab0090000
    INNER JOIN dbprosic.tab0240000
        ON (tab0090000.tab0090003 = tab0240000.tab0240001)
        WHERE tab0240000.tab0240001 IN(02,09) ".$limit." ORDER BY tab0090000.tab0090004";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }


    function cargar_data_registro_articulo($codigo='', $descripcion='', $limit='') { 
        $dql=" ORDER BY tab0090000.tab0090005"; 
 
        $sql = "SELECT
			    tab0090000.tab0090002
			    , tab0090000.tab0090003
				, tab0090000.tab0090004
				, tab0090000.tab0090005				
				, tab0030000.tab0030002
				, tab0090000.tab0090001
                            , tab0090000.tab0090010
				, tab0060000.tab0060001
				, tab0060000.tab0060002 as existencia
				, tab0240000.tab0240001
				, tab0240000.tab0240002
				FROM
				dbprosic.tab0090000
				INNER JOIN dbprosic.tab0060000 
					ON (tab0090000.tab0090002 = tab0060000.tab0060001)
				INNER JOIN dbprosic.tab0030000 
					ON (tab0090000.tab0090001 = tab0030000.tab0030001) 
				INNER JOIN dbprosic.tab0240000 
					ON (tab0090000.tab0090003 = tab0240000.tab0240001) WHERE 1=1 ";
        if ($codigo != ''
            )$sql.=" AND tab0090000.tab0090002 like'" . $codigo . "%' ";
        if ($descripcion != ''
            )$sql.=" AND tab0090000.tab0090005 like'" . $descripcion . "%' ";
        if ($dql != ''
             ) $sql.=$dql;
        if ($limit != ''
             ) $sql.=" " . $limit . " ";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

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
           )$sql.=$dql.$limit;

        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

	
	
	    function buscar_cuenta_por_id($id) {
        $sql = "SELECT cuenta_plan_contable,descripcion_plan_contable FROM prosic_plan_contable WHERE cuenta_plan_contable=".$id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_array($result);
        return $row;
    }
	
	
     function consulta_proveedor_x_articulo($id) {
        $sql = "select DISTINCT tab0080000.tab0080001,tab0080000.tab0080006,tab0080000.tab0080011
                  from alm0022010
                 inner join alm0012010 on alm0012010.alm0010006 = alm0022010.alm0020004
                 inner join tab0080000 on tab0080000.tab0080001 = alm0012010.alm0010005
                 where alm0012010.alm0010018=1 and alm0022010.alm0020005=".$id;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }



	function ConsultaArticuloId($id){
		$sql = "select * from tab0090000 where tab0090004=".$id;
		$res = $this->Consulta_Mysql($sql);
		$row = mysql_fetch_assoc($res);
		return $row;
	}
	
	function CargarEmpresa($defecto){
		$sql = "select * from tab0030000";
		return $this->Dropdown_Sql($sql,"tab0030001","tab0030002",$defecto);	
	}		
	
	function CargarExistencia($defecto){
        $sql = "select * from tab0060000";
		return $this->Dropdown_Sql($sql,"tab0060001","tab0060002",$defecto);
	}
	
	function CargarSubexistencia($defecto){
        $sql = "select * from tab0240000";
		return $this->Dropdown_Sql($sql,"tab0240001","tab0240002",$defecto);
	}
	
		function CargarInafecto($defecto){
        $sql = "select * from tab0280000";
		return $this->Dropdown_Sql($sql,"tab0280001","tab0280002",$defecto);
	}
	
			function CargarUmedida($defecto){
        $sql = "select * from tab0070000";
		return $this->Dropdown_Sql($sql,"tab0070001","tab0070002",$defecto);
	}
	
	
	
	function AgregarArticulo($campos, $datos) {
        $agregar = $this->sqlInsert("tab0090000", $campos, $datos);
        return $agregar;
    }
	
	function ModificarArticulo($campos,$datos,$id,$valor){
		$modificar = $this->sqlUpdate("tab0090000",$campos,$datos,$id,$valor);
		return "Datos Guardados";
	}
	
	function CargarArticuloBloqueados(){
		$sql = "select * from tab0090000 where tab0090009='0'";
		return $this->Dropdown_Sql($sql,"tab0090004","tab0090005","");		
	}
	
	function BloquearArticulo($idarticulo){
		$sql = "update tab0090000 set tab0090009='0' where tab0090004=".$idarticulo;
		$this->Consulta_Mysql($sql);
		return "Articulo Bloqueado";
	}
	
	function DesbloquearArticulo($idarticulo){
		$sql = "update tab0090000 set tab0090009='1' where tab0090004=".$idarticulo;
		$this->Consulta_Mysql($sql);
		return "Articulo Desbloqueado";
	}	
}
?>