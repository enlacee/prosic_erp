<?php

include_once('Class.Mysql.Prosic.php');

class InventarioFinal_Prosic extends Mysql_Prosic {
	
	    function CargarDataInventarioFinal($where, $short, $limit) {
        $sql = "SELECT
		
		        alm0062010.alm0060008
				,COUNT(alm0062010.alm0060002) as idinventario	
				,alm0062010.alm0060001
				,alm0062010.alm0060002
				,alm0062010.alm0060003			
		        ,alm0062010.alm0060004
				
				FROM
				dbprosic.alm0062010 GROUP BY alm0062010.alm0060003,alm0062010.alm0060004 $where $short $limit;";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }
	
		    function consulta_inventariofinal($limit='') {
        $sql = "SELECT
		
		        alm0062010.alm0060008
				,COUNT(alm0062010.alm0060002) as idinventario	
				,alm0062010.alm0060001
				,alm0062010.alm0060002
				,alm0062010.alm0060003			
		        ,alm0062010.alm0060004
				FROM
				dbprosic.alm0062010 GROUP BY alm0062010.alm0060003,alm0062010.alm0060004 ORDER BY alm0062010.alm0060000".$limit;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
	
	function ConsultaInventarioInicialId($id){
		$sql = "select * from alm0012010 where alm0010006=".$id;
		$res = $this->Consulta_Mysql($sql);
		$row = mysql_fetch_assoc($res);
		return $row;
	}
	
	function CargarEmpresa($defecto){
		$sql = "select * from tab0080000";
		return $this->Dropdown_Sql($sql,"tab0080001","tab0080006",$defecto);	
	}		
	
	function CargarMes($defecto){
        $sql = "select * from tab0060000";
		return $this->Dropdown_Sql($sql,"tab0060001","tab0060002",$defecto);
	}
	
	function CargarAño($defecto){
        $sql = "select * from tab0240000";
		return $this->Dropdown_Sql($sql,"tab0240001","tab0240002",$defecto);
	}
	
		function CargarLocal($defecto){
        $sql = "select * from tab0280000";
		return $this->Dropdown_Sql($sql,"tab0280001","tab0280002",$defecto);
	}
	
	
	function AgregarInventarioFinal($campos, $datos) {
        $agregar = $this->sqlInsert("alm0012010", $campos, $datos);
        return $agregar;
    }
	
	function ModificarInventarioInicial($campos,$datos,$id,$valor){
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