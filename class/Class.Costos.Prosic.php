<?php
/**
 * Sistema Prosic
 * Clase del Modulo de Contabilidad PROSIC
 * @package		Prosic
 * @author		Rommel Mercado Rodriguez
 * @copyright	Copyright 2011
 * @license		Rommel Mercado Rodriguez
 * @since		Version 1.0
 * @filesource
 */
?>
<?php

include_once('Class.Mysql.Prosic.php');

class Costos_Prosic extends Mysql_Prosic {
    function imprimir_inventario_final($sigmes, $sigperiodo) {
        $sql = "Select almacen.alm0050005,
		almacen.alm0050006,
		almacen.alm0050008,
		tab0090000.tab0090005,
		tab0090000.tab0090010,
		prosic_plan_contable.descripcion_plan_contable,
		tab0090000.tab0090011,
		tab0090000.tab0090012
                  from tab0090000
				 inner join (Select alm0050003,alm0050004,alm0050005,alm0050006,alm0050008 from alm0052010 
				       UNION Select alm0050003,alm0050004,alm0050005,alm0050006,alm0050008 from alm1052010) almacen
                                                 on tab0090000.tab0090004=almacen.alm0050005 
				 inner join prosic_plan_contable on tab0090000.tab0090010=prosic_plan_contable.cuenta_plan_contable
			     where almacen.alm0050003='" . $sigmes . "' 
			       AND almacen.alm0050004='" . $sigperiodo . "'
				   AND tab0090000.tab0090010 LIKE '60%'
				   and almacen.alm0050006<>0 
				 ORDER BY tab0090000.tab0090010";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function determinacion_costo_consi($sigmes, $sigperiodo) {
	$sql = "Select tab0090000.tab0090004, tab0090000.tab0090005,tab0090000.tab0090010, tab0090000.tab0090011, tab0090000.tab0090012
			from tab0090000 
			inner join (Select alm0050003,alm0050004,alm0050005,alm0050006,alm0050008 from alm0052010
						UNION 
						Select alm0050003,alm0050004,alm0050005,alm0050006,alm0050008 from alm1052010) 
									almacen on tab0090000.tab0090004=almacen.alm0050005 
			left join prosic_plan_contable on tab0090000.tab0090011=prosic_plan_contable.cuenta_plan_contable 
			where almacen.alm0050003='" . $sigmes . "'  
			AND almacen.alm0050004='" . $sigperiodo . "' 
			and almacen.alm0050006<>0 
			and (tab0090000.tab0090010 is null or tab0090000.tab0090011 is null or tab0090000.tab0090012 is null 
			 or not tab0090000.tab0090010 in (Select cuenta_plan_contable from prosic_plan_contable)
			 or not tab0090000.tab0090011 in (Select cuenta_plan_contable from prosic_plan_contable))
			ORDER BY tab0090000.tab0090004, tab0090000.tab0090005";
        $result = $this->Consulta_Mysql($sql);
		return $result;
    }

    function determinacion_costo_final($sigmes, $sigperiodo) {
		$sql = "Select tab0090000.tab0090011,
				prosic_plan_contable.descripcion_plan_contable,
				sum(almacen.alm0050006*almacen.alm0050008) as total,
				(select p.cuenta_plan_contable from prosic_plan_contable p 
				where p.cuenta_plan_contable=left(prosic_plan_contable.cuenta_plan_contable,3)) as cod_cuenta_p ,
				(select p.descripcion_plan_contable from prosic_plan_contable p 
				where p.cuenta_plan_contable=left(prosic_plan_contable.cuenta_plan_contable,3)) as des_cuenta_p , tab0090000.tab0090012
				from tab0090000 
				 inner join (Select alm0050003,alm0050004,alm0050005,alm0050006,alm0050008 from alm0052010
				 		UNION 
							 Select alm0050003,alm0050004,alm0050005,alm0050006,alm0050008 from alm1052010) 
				   almacen on tab0090000.tab0090004=almacen.alm0050005 
         		 left join prosic_plan_contable on tab0090000.tab0090011=prosic_plan_contable.cuenta_plan_contable 
		where almacen.alm0050003='" . $sigmes . "'  
		AND almacen.alm0050004='" . $sigperiodo . "' 
		AND tab0090000.tab0090010 LIKE '60%' 
		group by tab0090000.tab0090011
		ORDER BY cod_cuenta_p, tab0090000.tab0090010  ";
        $result = $this->Consulta_Mysql($sql);
		return $result;
//		and almacen.alm0050006<>0 

		}
	
	function determinacion_costo_inicial($sigmes, $sigperiodo,$codsubcuentaant) {
		$sql = "Select COALESCE(sum(almacen.alm0050006*almacen.alm0050008),0) as total  
		from tab0090000 
		inner join (
		Select alm0050003,alm0050004,alm0050005,alm0050006,alm0050008 
		from alm0052010 
		UNION 
		Select alm0050003,alm0050004,alm0050005,alm0050006,alm0050008 
		from alm1052010
		) almacen 
		on tab0090000.tab0090004=almacen.alm0050005 
		inner join prosic_plan_contable 
		on tab0090000.tab0090011=prosic_plan_contable.cuenta_plan_contable 
		where almacen.alm0050003='" . $sigmes . "' 
		AND almacen.alm0050004='" . $sigperiodo . "' 
		AND tab0090000.tab0090010 LIKE '60%' 
		and tab0090000.tab0090011='".$codsubcuentaant."'";
        $result = $this->Consulta_Mysql($sql);
		return $result;
//		and almacen.alm0050006<>0 

		}
	
	function determinacion_compras_mes($mes, $periodo,$codsubcuenta) {
	$sql = "SELECT tab9.tab0090011,
			sum(almacen.alm0020006*almacen.alm0020011) as total 
			FROM tab0090000 tab9
			inner join (Select alm0010004,alm0010018,alm0020005,alm0020006,alm0020011 from alm0022010 inner join alm0012010 on alm0010006=alm0020004
						UNION
						Select alm0010004,alm0010018,alm0020005,alm0020006,alm0020011 from alm1022010 inner join alm1012010 on alm0010006=alm0020004) almacen
					on almacen.alm0020005=tab9.tab0090004
			where almacen.alm0010018='1'
			and year(almacen.alm0010004)=" . $periodo . "
			and month(almacen.alm0010004)=" . $mes . "
			and tab9.tab0090011='".$codsubcuenta."' 
			AND tab9.tab0090010 LIKE '60%' 		
			group by tab0090011";
			$result = $this->Consulta_Mysql($sql);
		return $result ;
    }

	function determinacion_compras_contable($mes, $periodo,$codsubcuenta) {
		switch ($mes) {
        case 1:$resta='c01-a01';break;
        case 2:$resta='c02-a02';break;
        case 3:$resta='c03-a03';break;
        case 4:$resta='c04-a04';break;
        case 5:$resta='c05-a05';break;
        case 6:$resta='c06-a06';break;
        case 7:$resta='c07-a07';break;
        case 8:$resta='c08-a08';break;
        case 9:$resta='c09-a09';break;
        case 10:$resta='c10-a10';break;
        case 11:$resta='c11-a11';break;
        case 12:$resta='c12-a12';break;
    }
	$sql = "SELECT prosic_mayor.id_cuenta_contable,
			(" . $resta . ") as total 
			FROM prosic_mayor
			where prosic_mayor.id_cuenta_contable='".$codsubcuenta."'";
			$result = $this->Consulta_Mysql($sql);
		return $result ;
    }

	function determinacion_inicial_contable($sigmes, $sigperiodo,$codsubcuentaant) {
		switch ($sigmes) {
        case 1:$resta='ca00-aa00';break;
        case 2:$resta='ca01-aa01';break;
        case 3:$resta='ca02-aa02';break;
        case 4:$resta='ca03-aa03';break;
        case 5:$resta='ca04-aa04';break;
        case 6:$resta='ca05-aa05';break;
        case 7:$resta='ca06-aa06';break;
        case 8:$resta='ca07-aa07';break;
        case 9:$resta='ca08-aa08';break;
        case 10:$resta='ca09-aa09';break;
        case 11:$resta='ca10-aa10';break;
        case 12:$resta='ca11-aa11';break;
    }
	$sql = "SELECT prosic_mayor.id_cuenta_contable,
			(" . $resta . ") as total 
			FROM prosic_mayor
			where prosic_mayor.id_cuenta_contable='".$codsubcuenta."'";
			$result = $this->Consulta_Mysql($sql);
		return $result ;
	}
	
	function see_periodo($w_anio,$w_mes) {
       $return = "Mes de ";
       switch($w_mes) {
        Case 0:  $return.= "Enero (Apertura)";break;
        Case 1:  $return.= "Enero";break;
        Case 2:  $return.= "Febrero";break;
        Case 3:  $return.= "Marzo";break;
        Case 4:  $return.= "Abril";break;
        Case 5:  $return.= "Mayo";break;
        Case 6:  $return.= "Junio";break;
        Case 7:  $return.= "Julio";break;
        Case 8:  $return.= "Agosto";break;
        Case 9:  $return.= "Setiembre";break;
        Case 10: $return.= "Octubre";break;
        Case 11: $return.= "Noviembre";break;
        Case 12: $return.= "Diciembre";break;
        Case 13: $return.= "Diciembre (Ajustes)";break;
        Case 14: $return.= "Diciembre (Cierre)";break;
       }
       $return.= " - ";
	switch ($w_anio) {
		case 11: $return.="2010";break;
		case 12: $return.="2011";break;
		case 13: $return.="2012";break;
	}
	return $return;
    }
	
	
	public function get_costos($nombre_costo='', $limit='') {
        $sql = "select *
                from prosic_reg_costo" ;

        if ($nombre_costo != '') {
            $sql.=" where  descripcion_reg_costo like '%" . $nombre_costo . "%' ";
        }
        $sql . " order by id_reg_costo";

        $sql.=$limit;
        mysql_select_db("dbprosic");
        $res = $this->Consulta_Mysql($sql);
        return $res;
		
    }
	
	public function row_costo($id_producto) {
        $sql = "select *
                from prosic_reg_costo";
        $sql.= " where id_reg_costo=".$id_producto;               
        mysql_select_db("dbprosic");
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        return $row;
    }
	
	function select_status_costo($etiqueta, $id, $defecto) {
        $retorna = ' <label>' . $etiqueta . '</label> ';

        $retorna.= '<select id="' . $id . '" name="' . $id . '" > ';

        $valores = array('A' => 'Activado','D' => 'Desactivado');
        foreach ($valores as $key => $valor) {
            if ($key == $defecto
            )
                $selected = " selected= selected";
            else
                $selected="";

            $retorna.= "<option value=" . $key . " " . $selected . ">" . $valor . "</option>";
        }
        $retorna.= '</select><br>';

        return $retorna;
    }
	
	function cargar_nombre_campo_bd($bd, $tabla, $post) {
        $sql = "SELECT COLUMN_NAME,COLUMN_KEY FROM information_schema.COLUMNS
		WHERE TABLE_SCHEMA = '" . $bd . "' AND TABLE_NAME = '" . $tabla . "'";

        $result = $this->Consulta_Mysql($sql);

        $contador = 0;
        while ($row = mysql_fetch_assoc($result)) {
            if ($post[$row['COLUMN_NAME']]) {
                if ($row['COLUMN_KEY'] != 'PRI') {
                    $column_name[$contador] = $row['COLUMN_NAME'];
                    $contador++;
                }
            }
        }

        return $column_name;
    } 
	
	
	function cargar_valor_post_bd($bd, $tabla, $post) {
        $sql = "SELECT COLUMN_NAME,DATA_TYPE,COLUMN_KEY FROM information_schema.COLUMNS
		WHERE TABLE_SCHEMA = '" . $bd . "' AND TABLE_NAME = '" . $tabla . "'";

        $result = $this->Consulta_Mysql($sql);

        $contador = 0;
        while ($row = mysql_fetch_assoc($result)) {
            if ($post[$row['COLUMN_NAME']]) {
                if ($row['COLUMN_KEY'] != 'PRI') {
                    if ($row['DATA_TYPE'] == 'int') {
                        $valor_name[$contador] = $post[$row['COLUMN_NAME']];
                        $contador++;
                    } else {
                        $valor_name[$contador] = "'" . $post[$row['COLUMN_NAME']] . "'";
                        $contador++;
                    }
                }
            }
        }
        return $valor_name;
    }

    function determinacion_cuenta_final($sigmes, $sigperiodo) {
		$sql = "Select tab0090000.tab0090011,
				tab0090000.tab0090004 , tab0090000.tab0090005,
				prosic_plan_contable.descripcion_plan_contable,
				sum(almacen.alm0050006*almacen.alm0050008) as total,
				(select p.cuenta_plan_contable from prosic_plan_contable p 
				where p.cuenta_plan_contable=left(prosic_plan_contable.cuenta_plan_contable,3)) as cod_cuenta_p ,
				(select p.descripcion_plan_contable from prosic_plan_contable p 
				where p.cuenta_plan_contable=left(prosic_plan_contable.cuenta_plan_contable,3)) as des_cuenta_p 
				from tab0090000 
				 inner join (Select alm0050003,alm0050004,alm0050005,alm0050006,alm0050008 from alm0052010
				 		UNION 
				Select alm0050003,alm0050004,alm0050005,alm0050006,alm0050008 
				from alm1052010) 
				   almacen on tab0090000.tab0090004=almacen.alm0050005 
         		 left join prosic_plan_contable on tab0090000.tab0090011=prosic_plan_contable.cuenta_plan_contable 
		where almacen.alm0050003='" . $sigmes . "'  
		AND almacen.alm0050004='" . $sigperiodo . "' 
		AND tab0090000.tab0090010 LIKE '60%' 
		and tab0090000.tab0090011='252403'
		group by tab0090000.tab0090011, tab0090000.tab0090004 , tab0090000.tab0090005
		ORDER BY cod_cuenta_p, tab0090000.tab0090010  ";
        $result = $this->Consulta_Mysql($sql);
		return $result;
    }

	function determinacion_cuenta_inicial($sigmes, $sigperiodo,$codsubcuentaant) {
		$sql = "Select COALESCE(sum(almacen.alm0050006*almacen.alm0050008),0) as total  
		from tab0090000 
		inner join (
		Select alm0050003,alm0050004,alm0050005,alm0050006,alm0050008 
		from alm0052010 
		UNION 
		Select alm0050003,alm0050004,alm0050005,alm0050006,alm0050008 
		from alm1052010
		) almacen 
		on tab0090000.tab0090004=almacen.alm0050005 
		inner join prosic_plan_contable 
		on tab0090000.tab0090011=prosic_plan_contable.cuenta_plan_contable 
		where almacen.alm0050003='" . $sigmes . "' 
		AND almacen.alm0050004='" . $sigperiodo . "' 
		AND tab0090000.tab0090010 LIKE '60%' 
		and almacen.alm0050006<>0 
		and tab0090000.tab0090011='252403'
		and tab0090000.tab0090004='".$codsubcuentaant."'";

        $result = $this->Consulta_Mysql($sql);
		return $result;
    }
	
	function determinacion_cuenta_mes($mes, $periodo,$codsubcuenta) {
	$sql = "SELECT tab9.tab0090004,
			sum(almacen.alm0020006*almacen.alm0020011) as total 
			FROM tab0090000 tab9
			inner join (Select alm0010004,alm0010018,alm0020005,alm0020006,alm0020011 from alm0022010 inner join alm0012010 on alm0010006=alm0020004
						UNION
						Select alm0010004,alm0010018,alm0020005,alm0020006,alm0020011 from alm1022010 inner join alm1012010 on alm0010006=alm0020004) almacen
					on almacen.alm0020005=tab9.tab0090004
			where almacen.alm0010018='1'
			and year(almacen.alm0010004)=" . $periodo . "
			and month(almacen.alm0010004)=" . $mes . "
			and tab9.tab0090011='252403'
			and tab9.tab0090004='" . $codsubcuenta . "' 
			group by tab0090004";
			$result = $this->Consulta_Mysql($sql);
		return $result ;
    }
	
}
?>