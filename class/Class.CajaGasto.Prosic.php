<?php

include_once('Class.Mysql_Caja.Prosic.php');

class CajaGasto_Prosic extends Mysql_Caja_Prosic {

    function __construct() {
        parent::__construct();
    }

    public function get_personal($like='', $limit='') {
        $sql = "select  plr0030000,plr0030003,plr0030004,plr0030005,plr0030006,plr0030029 from dbprosic_planilla.plr0030000 ";

        if ($like != '') {
            $sql.=" where plr0030004 like'%" . $like . "%' or plr0030005 like'%" . $like . "%' or plr0030006 like'%" . $like . "%' ";
        }

        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    public function row_personal($id) {
        $sql = "select  plr0030000,plr0030003,plr0030004,plr0030005,plr0030006,plr0030029 from dbprosic_planilla.plr0030000 
				where plr0030000=" . $id;
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        return $row;
    }

    public function buscar_producto_codigo($db, $codigo_producto) {
        $sql = "SELECT * FROM prosic_producto WHERE codigo_producto='" . $codigo_producto . "'";
        mysql_select_db($db);
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        return $row;
    }
    
    public function get_gasto_personal($id_local='',$like='',$limit='') {
        $sql = "select  * from dbprosic_server_caja.caja_gasto_personal";        
        $sql.= " where id_local in(".$id_local.")";
        
        if ($like != '') {
            $sql.=" and  nombre_personal like'%" . $like . "%' ";
        }
        $sql." order by idcaja_gasto_personal desc";

        $sql.=$limit;
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }
  
   public function get_detalle_gasto($id_gasto){   
   $sql = "SELECT prosic_producto.nombre_producto, caja_gasto_detalle.idcaja_gasto_personal, caja_gasto_detalle.cantidad, caja_gasto_detalle.precio, caja_gasto_detalle.total FROM caja_gasto_detalle 
INNER JOIN caja_gasto_personal 
ON (caja_gasto_detalle.idcaja_gasto_personal=caja_gasto_personal.idcaja_gasto_personal)
INNER JOIN dbprosic_cajasi.prosic_producto ON (caja_gasto_detalle.codigo_producto = prosic_producto.codigo_producto ) 
WHERE caja_gasto_detalle.idcaja_gasto_personal=" .$id_gasto. " ";
	$res = $this->Consulta_Mysql($sql);
	return $res;   
   }

}

?>
