<?php

include_once('Class.Mysql.Prosic.php');

class CajaProducto_Prosic extends Mysql_Prosic {

    function __construct() {
        parent::__construct();
    }

    function sqlInsert_Local($tabla, $fields, $values,$conexion) {
        $sql = "INSERT INTO " . $tabla . " (";

        for ($i = 0; $i < sizeof($fields); $i++) {
            if ($i != (sizeof($fields) - 1))
                $sql.= $fields[$i] . ",";
            else
                $sql.= $fields[$i] . ") VALUES (";
        }

        for ($i = 0; $i < sizeof($fields); $i++) {
            if ($i != (sizeof($fields) - 1))
                $sql.= $values[$i] . ",";
            else
                $sql.= $values[$i] . ");";
        }
        return mysql_query($sql, $conexion);
        //return $sql;
    }
    
    function sqlUpdate_Local($tabla, $fields, $values, $idkey, $valuekey,$conexion) {
        $sql = "UPDATE " . $tabla . " SET ";

        for ($i = 0; $i < sizeof($fields); $i++) {
            if ($i != (sizeof($fields) - 1)
            )
                $sql.= $fields[$i] . "=" . $values[$i] . ", ";
            else
                $sql.=$fields[$i] . "=" . $values[$i] . " WHERE " . $idkey . "=" . $valuekey;
        }

        return mysql_query($sql, $conexion);
        //return $sql;
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
    

    /**
     * Sistema Prosic
     * Funcion para realizar una consulta SQL
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2010
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
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

    function select_status_producto($etiqueta, $id, $defecto) {
        $retorna = ' <label>' . $etiqueta . '</label> ';

        $retorna.= '<select id="' . $id . '" name="' . $id . '" > ';

        $valores = array('AC' => 'Activado','DS' => 'Desactivado');
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
    
    
    
    public function get_producto($nombre_producto='', $limit='') {
        $sql = "select prosic_producto.*,prosic_categoria.nombre_categoria
                from dbprosic_cajasi.prosic_producto 
                inner join dbprosic_cajasi.prosic_categoria
                on(prosic_producto.id_categoria=prosic_categoria.id_categoria) ";
        $sql.= " where status_producto in('AC','DS') ";

        if ($nombre_producto != '') {
            $sql.=" and  nombre_producto like'%" . $nombre_producto . "%' ";
        }
        $sql . " order by nombre_producto";

        $sql.=$limit;
        mysql_select_db("dbprosic_cajasi");
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

    public function row_producto($id_producto) {
        $sql = "select prosic_producto.*,prosic_categoria.nombre_categoria
                from dbprosic_cajasi.prosic_producto 
                inner join dbprosic_cajasi.prosic_categoria
                on(prosic_producto.id_categoria=prosic_categoria.id_categoria) ";
        $sql.= " where id_producto=".$id_producto;               
        mysql_select_db("dbprosic_cajasi");
        $res = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($res);
        return $row;
    }

}

?>
