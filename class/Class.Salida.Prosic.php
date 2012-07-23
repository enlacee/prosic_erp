<?php

include_once('Class.Mysql.Prosic.php');

class Salida_Prosic extends Mysql_Prosic {
	
	    function CargarDataSalidas($where, $short, $limit) {
        $sql = "SELECT
			    alm0012010.alm0010001
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
	
	
		    function consulta_salida($limit='') {
        $sql = "SELECT
			    alm0012010.alm0010001
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
	
    function cargar_data_registro_salida($codigo='', $descripcion='', $documento='', $destino='', $limit='') {
          $dql = " ORDER BY alm0012010.alm0010006 DESC";   
          $sql = "SELECT
			         alm0012010.alm0010002
				, alm0012010.alm0010003
				, alm0012010.alm0010004
                            , alm0012010.alm0010005				
				, alm0012010.alm0010006
                            , alm0012010.alm0010007
				, alm0012010.alm0010009
	                     , alm0012010.alm0010010
				, alm0012010.alm0010013
                            , alm0012010.alm0010019
                            , alm0012010.alm0010018
                            , tab0230000.tab0230001
                            , tab0230000.tab0230002
                            , tab0040000.tab0040001
                            , tab0040000.tab0040002
				FROM
				dbprosic.alm0012010
                                   LEFT JOIN
                             dbprosic.tab0040000
       ON (alm0012010.alm0010007 = tab0040000.tab0040001)
                                    LEFT JOIN
                             dbprosic.tab0230000
        ON (alm0012010.alm0010019 = tab0230000.tab0230001) WHERE 1=1 AND alm0012010.alm0010018=2 ";
        if ($codigo != ''
            )$sql.=" AND YEAR(alm0012010.alm0010004)='" . $codigo . "'";
        if ($documento != ''
            )$sql.=" AND MONTH(alm0012010.alm0010004)='" . $documento . "'";
	 if ($descripcion != ''
            )$sql.=" AND alm0012010.alm0010009 like'" . $descripcion . "%'";
        if ($destino != ''
            )$sql.=" AND alm0012010.alm0010019='" . $destino . "' ";
        if ($dql != ''
            )$sql.=$dql;
        if ($limit != ''
            )$sql.=" " . $limit . " ";

        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
	
		function ConsultaSalidaId($id){
		$sql = "select * from alm0012010 where alm0010006=".$id;
		$res = $this->Consulta_Mysql($sql);
		$row = mysql_fetch_assoc($res);
		return $row;
	}
	//add 24-04
	function getSalidaById($id,$tabla){
		$sql = "select * from ".$tabla." where alm0010006=".$id;
		$res = $this->Consulta_Mysql($sql);
		$row = mysql_fetch_assoc($res);
		return $row;
	}
	//hasta aquii
	   function consulta_producto_salida_por_id($id) {
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
	



    function consulta_producto_salida_por_ida($id) {
        $sql = "SELECT
                       tem0012010.tem0010000
                      ,tem0012010.tem0010004
		        ,tem0012010.tem0010005
                      ,tem0012010.tem0010006
                      ,tem0012010.tem0010007
                      ,tem0012010.tem0010009
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
	
	//add 24/04
	    function getProductsById($id,$tabla) {
        $sql = "SELECT
                       tem001.tem0010000
                      ,tem001.tem0010004
		        ,tem001.tem0010005
                      ,tem001.tem0010006
                      ,tem001.tem0010007
                      ,tem001.tem0010009
		        ,tab0090000.tab0090004
		        ,tab0090000.tab0090005
		FROM
	   	dbprosic.".$tabla."  tem001
		inner join dbprosic.tab0090000 
	 		ON (tem001.tem0010005 = tab0090000.tab0090004)
		WHERE tem001.tem0010004=" . $id;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
	
	
	function consulta_salida_por_nro($serie,$numero) {
		$sql = "SELECT
			         alm0010006,alm0010008,alm0010009		
				FROM
					alm0012010
				WHERE  alm0010009=".$numero."AND alm0010008=".$serie;
		$result = $this->Consulta_Mysql($sql);
		$row= mysql_fetch_assoc($result);
	    return $row['alm0010006'];
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
	
	
	
	function AgregarSalida($campos, $datos) {
        $agregar = $this->sqlInsert("alm0012010", $campos, $datos);
        return $agregar;
    }
	
	function ModificarSalida($campos,$datos,$id,$valor){
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