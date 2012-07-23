<?php

include_once('Class.Mysql.Prosic.php');

class InventarioInicial_Prosic extends Mysql_Prosic {
	
	    function CargarDataInventarioInicial($where, $short, $limit) {
        $sql = "SELECT
		
		        alm0052010.alm0050009
				,COUNT(alm0052010.alm0050002) as idinventario	
				,alm0052010.alm0050001
				,alm0052010.alm0050002
				,alm0052010.alm0050003			
		        ,alm0052010.alm0050004
				
				FROM
				dbprosic.alm0052010 GROUP BY alm0052010.alm0050003,alm0052010.alm0050004 $where $short $limit;";
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }
	   function consulta_inventarioinicial($nombre_anio='', $nombre_mes='',$limit='') {
			 $dql="GROUP BY alm0052010.alm0050003,alm0052010.alm0050004  ORDER BY alm0052010.alm0050000 ASC ";   
        $sql = "SELECT
		        alm0052010.alm0050009
				,COUNT(alm0052010.alm0050002) as idinventario	
				,alm0052010.alm0050000
				,alm0052010.alm0050001
				,alm0052010.alm0050002
			    ,alm0052010.alm0050003			
		        ,alm0052010.alm0050004 
                ,tab0100000.tab0100003 		
				FROM
			      dbprosic.alm0052010
                INNER JOIN
                 dbprosic.tab0100000
       ON (alm0052010.alm0050002 = tab0100000.tab0100002) WHERE 1=1 ";
	    if ($nombre_anio != ''
            )$sql.=" AND alm0052010.alm0050004='" . $nombre_anio . "'";
        if ($nombre_mes != ''
            )$sql.=" AND alm0052010.alm0050003='" . $nombre_mes . "' ";				
        if ($limit != ''
            )$sql.=$dql.$limit;
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
	
	
	function AgregarInventarioInicial($campos, $datos) {
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