<?php

include_once('Class.Mysql.Prosic.php');

class Proveedor_Prosic extends Mysql_Prosic {

	function consulta_proveedor2($where,$short,$limit){
		$sql = "SELECT
			         tab0080000.tab0080001
			       , tab0080000.tab0080002		
				, tab0080000.tab0080006
				, tab0080000.tab0080007
				, tab0080000.tab0080011
				, tab0270000.tab0270001
				, tab0270000.tab0270002 as tipopersona
				FROM
				dbprosic.tab0080000
				INNER JOIN dbprosic.tab0270000 
					ON (tab0080000.tab0080002 = tab0270000.tab0270001) $where $short $limit;";
		$res = $this->Consulta_Mysql($sql);
		return $res;
	}
	
	function consulta_proveedor($limit=''){
		$sql = "SELECT
			    tab0080000.tab0080001
			    , tab0080000.tab0080002		
				, tab0080000.tab0080006
				, tab0080000.tab0080007
				, tab0080000.tab0080011
                            , tab0080000.tab0080017
                            , tab0080000.tab0080018
                            , tab0080000.tab0080019   
                            , tab0080000.tab0080020
				, tab0270000.tab0270001
				, tab0270000.tab0270002 as tipopersona
				FROM
				dbprosic.tab0080000
				INNER JOIN dbprosic.tab0270000 
					ON (tab0080000.tab0080002 = tab0270000.tab0270001) ".$limit;

		$result = $this->Consulta_Mysql($sql);
		return $result;
	}

    function cargar_data_registro_proveedor($ruc='', $razonsocial='', $limit='') {
        $dql=" ORDER BY tab0080000.tab0080006"; 
        $sql = "SELECT
                              tab0080000.tab0080001
			       , tab0080000.tab0080002		
				, tab0080000.tab0080006
				, tab0080000.tab0080007
				, tab0080000.tab0080011
                            , tab0080000.tab0080015
                            , tab0080000.tab0080016
                            , tab0080000.tab0080020
				, tab0270000.tab0270001
				, tab0270000.tab0270002 as tipopersona
				FROM
                           dbprosic.tab0080000
				INNER JOIN dbprosic.tab0270000 
			ON (tab0080000.tab0080002 = tab0270000.tab0270001) WHERE 1=1 ";

        if ($ruc != ''
            )$sql.=" AND tab0080000.tab0080001 like'" . $ruc . "%' ";
        if ($razonsocial != ''
            )$sql.=" AND tab0080000.tab0080006 like'" . $razonsocial . "%' ";
       if ($dql != ''
             ) $sql.=$dql;
        if ($limit != ''
             ) $sql.=" " . $limit . " ";

        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
	
     function consulta_articulo_x_proveedor($id) {
        $sql = "select DISTINCT tab0090000.tab0090004,tab0090000.tab0090005
                from dbprosic.alm0012010
                inner join dbprosic.alm0022010 on alm0022010.alm0020004 = alm0012010.alm0010006
                inner join dbprosic.tab0090000 on tab0090000.tab0090004 = alm0022010.alm0020005
                where alm0012010.alm0010018=1 and alm0012010.alm0010005=" . $id;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

	function ConsultaProveedorId($id){
		$sql = "select * from tab0080000 where tab0080001=".$id;
		$res = $this->Consulta_Mysql($sql);
		$row = mysql_fetch_assoc($res);
		return $row;
	}
	
	function CargarTipoPersona($defecto){
        $sql = "select * from tab0270000";
		return $this->Dropdown_Sql($sql,"tab0270001","tab0270002",$defecto);
	}
	
	function AgregarProveedor($campos,$datos){
		$agregar = $this->sqlInsert("tab0080000",$campos,$datos);
		return $agregar;	
	}
	
	function ModificarProveedor($campos,$datos,$id,$valor){
		$modificar = $this->sqlUpdate("tab0080000",$campos,$datos,$id,$valor);
		return "Datos Guardados";
	}
	
	function CargarProveedorBloqueados(){
		$sql = "select * from tab0080000 where tab0080014='0'";
		return $this->Dropdown_Sql($sql,"tab0080001","tab0080006","");		
	}
	
	function BloquearProveedor($idusuario){
		$sql = "update tab0080000 set tab0080014='0' where tab0080001=".$idusuario;
		$this->Consulta_Mysql($sql);
		return "Proveedor Bloqueado";
	}
	
	function DesbloquearProveedor($idusuario){
		$sql = "update tab0080000 set tab0080014='1' where tab0080001=".$idusuario;
		$this->Consulta_Mysql($sql);
		return "Proveedor Desbloqueado";
	}	
}
?>