<?php

include_once('Class.Mysql.Prosic.php');

class DerechoHabiente_Prosic extends Mysql_Prosic {
	
	    function CargarDataDerechoHabiente($where, $short, $limit) {
        $sql = "SELECT
			    plr0160000.plr0160000
				, plr0160000.plr0160004
				, plr0160000.plr0160005
			    , plr0160000.plr0160006
				FROM
				dbprosic.plr0160000 $where $short $limit;";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }
	
	function ConsultaArticuloId($id){
		$sql = "select * from tab0090000 where tab0090004=".$id;
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
	
	
	
	function AgregarArticulo($campos,$datos){
		$agregar = $this->sqlInsert("tab0090000",$campos,$datos);
		return "Datos Guardados";	
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