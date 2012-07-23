<?php

include_once('Class.Mysql.Prosic.php');

class Entrada_Prosic extends Mysql_Prosic {
	
	    function CargarDataEntradas($where, $short, $limit) {
                    $sql = "SELECT
			         alm0012010.alm0010005
		              , alm0012010.alm0010002
				, alm0012010.alm0010003
				, alm0012010.alm0010004				
				, alm0012010.alm0010006
				, alm0012010.alm0010009	
				, alm0012010.alm0010013			
				FROM
				dbprosic.alm0012010 $where $short $limit;";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

function cargar_data_registro_entrada($codigo='', $descripcion='', $documento='', $proveedor='', $limit='') {
   $dql = " ORDER BY alm0012010.alm0010006 DESC";  
   $sql = "SELECT alm0012010.alm0010006
		  , alm0012010.alm0010004
		  , alm0012010.alm0010009	
		  , alm0012010.alm0010013	
                , tab0040000.tab0040002	
		  , tab0080000.tab0080006	
             FROM alm0012010 
       INNER JOIN tab0080000 ON (alm0012010.alm0010005 = tab0080000.tab0080001)
       INNER JOIN tab0040000 ON (alm0012010.alm0010007 = tab0040000.tab0040001)
            WHERE alm0012010.alm0010018=1 ";
        if ($codigo != ''
            )$sql.=" AND YEAR(alm0012010.alm0010004)='" . $codigo . "'";
        if ($descripcion != ''
            )$sql.=" AND MONTH(alm0012010.alm0010004)='" . $descripcion . "'";
        if ($documento != ''
            )$sql.=" AND alm0012010.alm0010009 like '" . $documento . "%'";			
        if ($proveedor != ''
            )$sql.=" AND tab0080000.tab0080006 like '" . utf8_decode($proveedor) . "%'";					
        if ($dql != ''
            )$sql.=$dql;
        if ($limit != ''
            )$sql.=" " . $limit . " ";
			
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    	function consulta_entrada($limit='') {
		  $sql = "SELECT
			         alm0012010.alm0010005
			       , alm0012010.alm0010002
				, alm0012010.alm0010003
				, alm0012010.alm0010004				
				, alm0012010.alm0010006
				, alm0012010.alm0010009	
				, alm0012010.alm0010013			
				FROM
				dbprosic.alm0012010 ".$limit;
	        $result = $this->Consulta_Mysql($sql);
       	 return $result;
    	}

	function ConsultaEntradaId($id){
		$sql = "select * from alm0012010 where alm0010006=".$id;
		$res = $this->Consulta_Mysql($sql);
		$row = mysql_fetch_assoc($res);
		return $row;
	}
	
	function CargarProveedor($defecto){
		$sql = "select * from tab0080000";
		return $this->Dropdown_Sql($sql,"tab0080001","tab0080006",$defecto);	
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

function consulta_producto_entrada_por_id($id) {
        $sql = "SELECT
                       alm0022010.alm0020000		
                      ,alm0022010.alm0020006
                      ,alm0022010.alm0020007
                      ,alm0022010.alm0020009
		        ,tab0090000.tab0090004
			 ,tab0090000.tab0090005
FROM
    dbprosic.alm0022010
	inner join dbprosic.tab0090000 
	 ON (alm0022010.alm0020005 = tab0090000.tab0090004)
    WHERE alm0022010.alm0020004=" . $id;
        $result = $this->Consulta_Mysql($sql);
        return $result;
}
	
	function consulta_producto_entrada_por_ida($id) {
        $sql = "SELECT
                       tem0012010.tem0010000
                      ,tem0012010.tem0010004		
                      ,tem0012010.tem0010006
                      ,tem0012010.tem0010007
                      ,tem0012010.tem0010009
					  ,tem0012010.tem0010005
                      ,tem0012010.tem0010011
					  ,tem0012010.tem0010012
		        ,tab0090000.tab0090004
		        ,tab0090000.tab0090005
	FROM
	    dbprosic.tem0012010
		inner join dbprosic.tab0090000 
		 ON (tem0012010.tem0010005 = tab0090000.tab0090004)
	    WHERE tem0012010.tem0010004=" . $id;
	        $result = $this->Consulta_Mysql($sql);
	        return $result;
	}

	function consulta_producto_entrada_suma($id) {
        $sql = "SELECT sum(tem0012010.tem0010007) as sum0010007
                      ,sum(tem0012010.tem0010009) as sum0010009
                      ,sum(tem0012010.tem0010011) as sum0010011
					  ,sum(tem0012010.tem0010012) as sum0010012
				FROM
					dbprosic.tem0012010 WHERE tem0012010.tem0010004=" . $id;
	        $result = $this->Consulta_Mysql($sql);
	        return $result;
	}

	function AgregarEntrada($campos, $datos) {
       	$agregar = $this->sqlInsert("alm0012010", $campos, $datos);
        	return $agregar;
	}
	
	function ModificarEntrada($campos,$datos,$id,$valor){
		$modificar = $this->sqlUpdate("alm0012010",$campos,$datos,$id,$valor);
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