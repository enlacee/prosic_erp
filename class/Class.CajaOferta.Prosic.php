<?php

include_once('Class.Mysql.Prosic.php');

class CajaOferta_Prosic extends Mysql_Prosic {

    function __construct() {
        parent::__construct();
    }

    function sqlInsert_Query($tabla, $fields, $values) {
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
        //return mysql_query($sql);
        return $sql;
    }

    function sqlUpdate_Query($tabla, $fields, $values, $idkey, $valuekey) {
        $sql = "UPDATE " . $tabla . " SET ";

        for ($i = 0; $i < sizeof($fields); $i++) {
            if ($i != (sizeof($fields) - 1)
            )
                $sql.= $fields[$i] . "=" . $values[$i] . ", ";
            else
                $sql.=$fields[$i] . "=" . $values[$i] . " WHERE " . $idkey . "=" . $valuekey;
        }
        $sql.=";";
        //return mysql_query($sql);
        return $sql;
    }

    function sqlInsert_Local($tabla, $fields, $values, $conexion) {
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

    function sqlUpdate_Local($tabla, $fields, $values, $idkey, $valuekey, $conexion) {
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

        $valores = array('AC' => 'Activado', 'DS' => 'Desactivado');
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

    function selected_nombre_oferta($tabla, $id, $etiqueta, $defecto='', $newsql='', $status='') {

        $retorna = ' <label>' . $etiqueta . '</label> ';

        $retorna.= '<select id="' . $id . '" name="' . $id . '" > ';

        $sql = ($newsql == "") ? "SELECT * FROM " . $tabla . " where id_categoria=29" . $status : $newsql;

        $res = $this->Consulta_Mysql($sql);

        while ($row_select = mysql_fetch_array($res)) {
            if ($row_select[0] == $defecto)
                $selected = " selected='selected' ";
            else
                $selected = " ";

            $retorna.= "<option value='" . $row_select[0] . "' $selected>" . utf8_encode($row_select[1]) . "</option>";
        }

        $retorna.= '</select><br>';

        return $retorna;
    }

    public function get_producto($nombre_producto='', $limit='') {
        $sql = "SELECT prosic_producto.*,prosic_categoria.nombre_categoria
                FROM dbprosic_cajasi.prosic_producto 
                INNER JOIN dbprosic_cajasi.prosic_categoria
                ON(prosic_producto.id_categoria=prosic_categoria.id_categoria)
                WHERE  codigo_producto LIKE '91%' OR codigo_producto LIKE '92%' OR 
                codigo_producto  LIKE '93%' OR
                codigo_producto LIKE '94%' OR 
                codigo_producto LIKE '95%' ";

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
        $sql.= " where id_producto=" . $id_producto;
        mysql_select_db("dbprosic_cajasi");
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

    public function deleteProductoRelacion($db, $id_producto) {
        $sql = "DELETE FROM prosic_producto_relacion where codigo_producto='" . $id_producto . "'";
        mysql_select_db($db);
        $this->Consulta_Mysql($sql);
        return true;
    }
    
    public function deleteProductoRelacion_Local($db,$conexion, $id_producto) {
        $sql = "DELETE FROM prosic_producto_relacion where codigo_producto='" . $id_producto . "'";
        mysql_select_db($db);
        mysql_query($sql,$conexion);
        return true;
    }

    public function getProductoRelacion($codigo_producto) {
        $sql = " SELECT r.*,p.codigo_producto,p.precio_unitario_producto,(r.cantidad*p.precio_unitario_producto)AS subtotal,p.nombre_producto
            FROM prosic_producto_relacion r,prosic_producto p
            WHERE r.xid_producto=p.id_producto
            AND r.codigo_producto ='" . $codigo_producto . "'";

        mysql_select_db("dbprosic_cajasi");
        $result = $this->Consulta_Mysql($sql);
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getCategoriaRelacion($codigo_producto) {
        $sql = " SELECT r.*,c.nombre_categoria
            FROM prosic_producto_relacion r,prosic_categoria c
            WHERE r.id_categoria=c.id_categoria
            AND r.codigo_producto ='" . $codigo_producto . "'";

        mysql_select_db("dbprosic_cajasi");
        $result = $this->Consulta_Mysql($sql);
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    function Consulta_Mysql_Local($db, $sql) {
        mysql_select_db($db);
        $res = $this->Consulta_Mysql($sql);
        return $res;
    }

}

?>
