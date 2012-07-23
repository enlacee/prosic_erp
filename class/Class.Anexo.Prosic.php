<?php

/**
 * Description of Class 
 * clase Anexo , manejo de proveedores
 * @author Oscar Alanya
 */
 
include_once('Class.Mysql.Prosic.php');

class Anexo_Prosic extends Mysql_Prosic {

    function consultar_data_anexo($codigo='', $descripcion='', $limit='') {
        $ord = " ORDER BY prosic_anexo.descripcion_anexo";
		$sql = "SELECT prosic_anexo.id_anexo, prosic_anexo.codigo_anexo, prosic_anexo.descripcion_anexo, prosic_anexo.telefono_anexo
            FROM prosic_anexo WHERE 1=1";
				
	        if ($codigo_anexo != ''
            )$sql.=" AND prosic_anexo.codigo_anexo LIKE '" . $codigo . "%'";
        if ($descripcion_anexo != ''
            )$sql.=" AND prosic_anexo.descripcion_anexo like '%" . $descripcion . "%' ";
        if ($ord != ''
            )$sql.=$ord;
        if ($limit != ''
            )$sql.=$limit;			
			
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }


    function consulta_data_banco_id($id){
        $sql    =   "SELECT * FROM prosic_banco where id_banco = ".$id;
        $result = $this->Consulta_Mysql($sql);
        $row    = mysql_fetch_assoc($result);
        return $row;
    }

    function insertar_banco($fields,$values){
        $result = $this->sqlInsert("prosic_banco", $fields, $values);
        return $result;
    }

    function update_banco($fields,$values,$idkey,$valuekey){
        $result = $this->sqlUpdate("prosic_banco", $fields, $values, $idkey, $valuekey);
        return $result;
    }
}
?>
