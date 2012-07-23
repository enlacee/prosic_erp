<?php

include_once('Class.Mysql.Prosic.php');

class Trabajador_Prosic extends Mysql_Prosic {
	
	    function CargarDataTrabajadores($where, $short, $limit) {
        $sql = "SELECT
			    plr0030000.plr0030000
				, plr0030000.plr0030001
				, plr0030000.plr0030002
				, plr0030000.plr0030003
			    , plr0030000.plr0030004
				, plr0030000.plr0030005
				, plr0030000.plr0030006				
			    , plr0030000.plr0030007
			    , plr0030000.plr0030008				
			    , plr0030000.plr0030009
				, plr0030000.plr0030014				
			    , plr0030000.plr0030015
				, plr0030000.plr0030016			
			    , plr0030000.plr0030017
				, plr0030000.plr0030018
				, plr0100000.plr0100001
				, plr0100000.plr0100002
				 
				FROM
				dbprosic.plr0030000
				INNER JOIN dbprosic.plr0100000 
					ON (plr0030000.plr0030002 = plr0100000.plr0100001) $where $short $limit;";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }
	
	  function CargarDataTrabajadorPlanilla($where, $short, $limit) {
        $sql = "SELECT
		         plr0320000.plr0320000
				, plr0320000.plr0320001
				, plr0320000.plr0320002
				, plr0320000.plr0320003
				, plr0320000.plr0320018
				, plr0320000.plr0320019
			    , plr0030000.plr0030000
				, plr0030000.plr0030001
				, plr0030000.plr0030002
				, plr0030000.plr0030003
			    , plr0030000.plr0030004
				, plr0030000.plr0030005
				, plr0030000.plr0030006				
			    , plr0030000.plr0030007
			    , plr0030000.plr0030008				
			    , plr0030000.plr0030009
				, plr0030000.plr0030014				
			    , plr0030000.plr0030015
				, plr0030000.plr0030016			
			    , plr0030000.plr0030017
				, plr0030000.plr0030018
				, plr0100000.plr0100001
				, plr0100000.plr0100002
				 
				FROM
				dbprosic.plr0320000
				INNER JOIN dbprosic.plr0030000 
					ON (plr0320000.plr0320003 = plr0030000.plr0030003)
		        INNER JOIN dbprosic.plr0100000 
					ON (plr0030000.plr0030002 = plr0100000.plr0100001)  $where AND plr0030000.plr0030014=1 $short $limit;";
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