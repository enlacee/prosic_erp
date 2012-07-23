<?php

include_once('Class.Mysql.Prosic.php');

class Produccion_Prosic extends Mysql_Prosic {

     function selected1($tabla, $id, $etiqueta, $defecto='', $newsql='') {

        $retorna = ' <label>' . $etiqueta . '</label> ';

        $retorna.= '<select id="' . $id . '" name="' . $id . '" > ' . '<option value=0 ' . $selected . '>[TODOS LOS REGISTROS]</option>';

        $sql = ($newsql == "") ? "SELECT * FROM " . $tabla : $newsql;

        $res = $this->Consulta_Mysql($sql);

        while ($row_select = mysql_fetch_array($res)) {
            if ($row_select[0] == $defecto)
                $selected = " selected='selected' ";
            else
                $selected = " ";

            $retorna.= "<option value='" . $row_select[0] . "' $selected>" .$row_select[2] . "</option>";
        }

        $retorna.= '</select><br>';

        return $retorna;
    }
    function consulta_producto($limit='') {
        $sql = "SELECT
    tab0090000.tab0090001
    , tab0090000.tab0090002
    , tab0240000.tab0240001
    , tab0240000.tab0240002
    , tab0090000.tab0090004
    , tab0090000.tab0090005
    , tab0090000.tab0090006
    , tab0090000.tab0090007
    , tab0090000.tab0090008
    , tab0090000.tab0090009
FROM
    dbprosic.tab0090000
    INNER JOIN dbprosic.tab0240000
        ON (tab0090000.tab0090003 = tab0240000.tab0240001)
        WHERE tab0240000.tab0240001 IN(02,09)";
        $sql.=$limit;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

     function cargar_campos_producto_tab() {
        $sql = "SELECT
     tab0240000.tab0240001
    , tab0240000.tab0240002
    , tab0090000.tab0090004
    , tab0090000.tab0090005
    , tab0090000.tab0090008
FROM
    dbprosic.tab0090000
    INNER JOIN dbprosic.tab0240000
        ON (tab0090000.tab0090003 = tab0240000.tab0240001)
        WHERE tab0240000.tab0240001 IN(02,09)";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_hoja() {
        $sql = "SELECT
    `prosic_hoja_produccion`.`id_hoja_produccion`
    , `prosic_hoja_produccion`.`cod_hoja_produccion`
    , `prosic_p_e`.`id_p_e`
    , prosic_p_e.cod_p_e
    , `prosic_p_e`.`nombre_p_e`
    , `prosic_p_e`.nombre_unidad_medida
    , `prosic_hoja_produccion`.`cantidad_e_hoja_produccion`
    , `prosic_hoja_produccion`.`cantidad_r_hoja_produccion`
    , `prosic_hoja_produccion`.`costo_e_hoja_produccion`
    , `prosic_hoja_produccion`.`costo_r_hoja_produccion`
    , `prosic_hoja_produccion`.`fecha_crea_hoja_produccion`
    , `prosic_hoja_produccion`.`status_hoja_produccion`
    , `prosic_hoja_produccion`.`id_operacion`
FROM
    `dbprosic`.`prosic_p_e`
    INNER JOIN `dbprosic`.`prosic_hoja_produccion`
        ON (`prosic_p_e`.`id_p_e` = `prosic_hoja_produccion`.`id_p_e`) ORDER BY fecha_crea_hoja_produccion  DESC;";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_hoja_venta() {
        $sql = "SELECT
    prosic_hoja_venta.id_hoja_venta
    , prosic_hoja_venta.cod_hoja_venta
    , prosic_producto.id_producto
    , prosic_producto.codigo_producto
    , prosic_producto.nombre_producto
    , prosic_hoja_venta.cantidad_hoja_venta
    , prosic_hoja_venta.costo_hoja_venta
    , prosic_hoja_venta.fecha_crea_hoja_venta
    , prosic_hoja_venta.status_hoja_venta
    , prosic_hoja_venta.id_operacion
    , prosic_hoja_venta.id_local
FROM
    dbprosic.prosic_producto
    INNER JOIN dbprosic.prosic_hoja_venta
        ON (prosic_producto.id_producto = prosic_hoja_venta.id_producto)
        ORDER BY prosic_hoja_venta.fecha_crea_hoja_venta DESC;";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_hoja_x_producto($id) {
        $sql = "SELECT
    prosic_hoja_produccion.id_hoja_produccion
    , prosic_hoja_produccion.cod_hoja_produccion
    , prosic_p_e.id_p_e
    , prosic_p_e.cod_p_e
    , prosic_p_e.nombre_p_e
    , `prosic_p_e`.nombre_unidad_medida
    , prosic_hoja_produccion.cantidad_e_hoja_produccion
    , prosic_hoja_produccion.cantidad_r_hoja_produccion
    , prosic_hoja_produccion.costo_e_hoja_produccion
    , prosic_hoja_produccion.costo_r_hoja_produccion
    , prosic_hoja_produccion.fecha_crea_hoja_produccion
    , prosic_hoja_produccion.status_hoja_produccion
FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE prosic_p_e.id_p_e=" . $id . " ORDER BY fecha_crea_hoja_produccion  DESC";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_hoja_x_fecha($fecha_inicial, $fecha_final) {
        $sql = "SELECT
    prosic_hoja_produccion.id_hoja_produccion
    , prosic_hoja_produccion.cod_hoja_produccion
    , prosic_p_e.id_p_e
    , prosic_p_e.nombre_p_e
    , prosic_p_e.cod_p_e
    , `prosic_p_e`.nombre_unidad_medida
    , prosic_hoja_produccion.cantidad_e_hoja_produccion
    , prosic_hoja_produccion.cantidad_r_hoja_produccion
    , prosic_hoja_produccion.costo_e_hoja_produccion
    , prosic_hoja_produccion.costo_r_hoja_produccion
    , prosic_hoja_produccion.fecha_crea_hoja_produccion
    , prosic_hoja_produccion.status_hoja_produccion
FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE  fecha_crea_hoja_produccion BETWEEN '" . $fecha_inicial . "' AND '" . $fecha_final . "' ORDER BY fecha_crea_hoja_produccion  DESC";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_hoja_x_fecha_y_producto($id, $fecha_inicial, $fecha_final) {
        $sql = "SELECT
    prosic_hoja_produccion.id_hoja_produccion
    , prosic_hoja_produccion.cod_hoja_produccion
    , prosic_p_e.id_p_e
    , prosic_p_e.cod_p_e
    , prosic_p_e.nombre_p_e
    , `prosic_p_e`.nombre_unidad_medida
    , prosic_hoja_produccion.cantidad_e_hoja_produccion
    , prosic_hoja_produccion.cantidad_r_hoja_produccion
    , prosic_hoja_produccion.costo_e_hoja_produccion
    , prosic_hoja_produccion.costo_r_hoja_produccion
    , prosic_hoja_produccion.fecha_crea_hoja_produccion
    , prosic_hoja_produccion.status_hoja_produccion
FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE prosic_p_e.id_p_e=" . $id . " AND fecha_crea_hoja_produccion BETWEEN '" . $fecha_inicial . "' AND '" . $fecha_final . "' ORDER BY fecha_crea_hoja_produccion  DESC";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_producto_por_id($id) {
        $sql = "SELECT
    prosic_producto.id_producto
    , prosic_producto.cod_producto
    , prosic_tipo_producto.nombre_tipo_producto
    , prosic_producto.nombre_producto
    , prosic_producto.descripcion_producto
    , prosic_unidad_medida.abrevia_unidad_medida
    , prosic_producto.precio_unitario_producto
    , prosic_producto.fecha_producto
    , prosic_producto.status_producto
    , prosic_unidad_medida.id_unidad_medida
    , prosic_tipo_producto.id_tipo_producto
FROM
    dbprosic.prosic_producto
    INNER JOIN dbprosic.prosic_unidad_medida
        ON (prosic_producto.id_unidad_medida = prosic_unidad_medida.id_unidad_medida)
    INNER JOIN dbprosic.prosic_tipo_producto
        ON (prosic_producto.id_tipo_producto = prosic_tipo_producto.id_tipo_producto)
    WHERE id_producto=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($result);
        return $row;
    }

    function consulta_producto_elaborado_por_id($id) {
        $sql = "SELECT
    prosic_p_e.id_p_e
    , prosic_p_e.cod_p_e
    , prosic_p_e.nombre_p_e
    , prosic_p_e.descripcion_p_e
    , prosic_p_e.costo_p_e
    , prosic_p_e.cantidad_p_e
    ,prosic_p_e.id_unidad_medida
    , prosic_p_e.cantidad_p_e
    ,prosic_p_e.nombre_unidad_medida
FROM
    dbprosic.prosic_p_e
    WHERE prosic_p_e.id_p_e=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($result);
        return $row;
    }
//ADD 25/04
    function getProductoFormulaById($id) {
        $sql = "SELECT * FROM  dbprosic.formula_producto
    WHERE id_producto=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($result);
        return $row;
    }
//END
       function consulta_producto_terminado_por_id($id) {
        $sql = "SELECT
    prosic_producto.id_producto
    , prosic_categoria.id_categoria
    , prosic_categoria.nombre_categoria
    , prosic_producto.codigo_producto
    , prosic_producto.nombre_producto
    , prosic_producto.descripcion_producto
    , prosic_producto.precio_unitario_producto
FROM
    dbprosic.prosic_categoria
    INNER JOIN dbprosic.prosic_producto
        ON (prosic_categoria.id_categoria = prosic_producto.id_categoria)
        WHERE id_producto=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($result);
        return $row;
    }

//    function consulta_existe_ingrediente($id,$prod) {
//        $sql = "SELECT
//    prosic_ingrediente.cantidad_ingrediente
//        FROM
//    dbprosic.prosic_p_e
//    INNER JOIN dbprosic.prosic_ingrediente
//        ON (prosic_p_e.id_p_e = prosic_ingrediente.id_p_e)
//    INNER JOIN dbprosic.prosic_producto
//        ON (prosic_ingrediente.id_producto = prosic_producto.id_producto)
//    INNER JOIN dbprosic.prosic_unidad_medida
//        ON (prosic_producto.id_unidad_medida = prosic_unidad_medida.id_unidad_medida)
//        WHERE prosic_p_e.id_p_e=". $id ." AND prosic_producto.id_producto=". $prod ;
//        $result = $this->Consulta_Mysql($sql);
//        $row = mysql_fetch_assoc($result);
//        return $row;
//    }

    function consulta_ingrediente_x_p_e($id) {
        $sql = "SELECT
    prosic_ingrediente.id_ingrediente
    , prosic_ingrediente.id_producto
    , prosic_ingrediente.nombre_producto
    , prosic_ingrediente.cantidad_ingrediente
    , prosic_ingrediente.costo_ingrediente
    , prosic_p_e.id_p_e
    , prosic_p_e.nombre_p_e
    , `prosic_p_e`.nombre_unidad_medida
FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_ingrediente
        ON (prosic_p_e.id_p_e = prosic_ingrediente.id_p_e)
        WHERE prosic_p_e.id_p_e=" . $id;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
//add 25/04
    function getIngredienteByIdProducto($id) {
        $sql = "SELECT
    det.id_producto id	,
	det.id_articulo id_art	,
	tab009.tab0090005 nombre,
	det.cantidad_articulo cantidad
	
FROM
    dbprosic.formula_detalle det
    INNER JOIN dbprosic.tab0090000 tab009
        ON (det.id_articulo = tab009.tab0090004)
        WHERE det.id_producto=" . $id;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

//end
     function consulta_ingrediente_x_p_t($id) {
        $sql = "SELECT
    prosic_ingrediente_p_t.id_ingrediente_p_t
    , prosic_ingrediente_p_t.id_p_t
    , prosic_ingrediente_p_t.nombre_p_t
    , prosic_ingrediente_p_t.cantidad_ingrediente_p_t
    , prosic_ingrediente_p_t.costo_ingrediente_p_t
    , prosic_producto.id_producto
    , prosic_producto.codigo_producto
    , prosic_producto.nombre_producto
FROM
    dbprosic.prosic_producto
    INNER JOIN dbprosic.prosic_ingrediente_p_t
        ON (prosic_producto.id_producto = prosic_ingrediente_p_t.id_producto)
        WHERE prosic_producto.id_producto=" . $id;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
    function consulta_ingrediente_x_producto($id) {
        $sql = "SELECT
    prosic_ingrediente_p_t.id_ingrediente_p_t
    , prosic_ingrediente_p_t.id_p_t
    , prosic_ingrediente_p_t.nombre_p_t
    , prosic_ingrediente_p_t.cantidad_ingrediente_p_t
    , prosic_ingrediente_p_t.costo_ingrediente_p_t
    , prosic_producto.id_producto
    , prosic_ingrediente_p_t.nombre_p_t
FROM
    dbprosic.prosic_producto
    INNER JOIN dbprosic.prosic_ingrediente_p_t
        ON (prosic_producto.id_producto = prosic_ingrediente_p_t.id_producto)
        WHERE prosic_producto.id_producto=" . $id;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_proveedor_x_articulo($id) {
        $sql = "SELECT

				 alm0022010.alm0020004
				, alm0022010.alm0020005 as codigo
				, alm0022010.alm0020006 as cantidad
				, alm0022010.alm0020007 as precio	
				, alm0012010.alm0010005 as proveedor
                            , alm0012010.alm0010006

    dbprosic.alm0022010
    INNER JOIN dbprosic.alm0012010
        ON ( alm0022010.alm0020004 = alm0012010.alm0010006)
        WHERE alm0022010.alm0020005=" . $id;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_articulo_x_proveedor($id) {
        $sql = "SELECT
				 alm0012010.alm0010005 as proveedor
                            , alm0012010.alm0010006
				, alm0022010.alm0020004
				, alm0022010.alm0020005 as codigo
				, alm0022010.alm0020006 as cantidad
				, alm0022010.alm0020007 as precio	

    FROM dbprosic.alm0012010
    INNER JOIN dbprosic.alm0022010
        ON ( alm0012010.alm0010006 = alm0022010.alm0020004 )
        WHERE alm0012010.alm0010005 =" . $id;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_ingrediente($id) {
        $sql = "SELECT
    prosic_ingrediente.id_ingrediente
    , prosic_ingrediente.id_producto
    , prosic_ingrediente.nombre_producto
    , prosic_ingrediente.cantidad_ingrediente
    , prosic_ingrediente.costo_ingrediente
FROM dbprosic.prosic_ingrediente
        WHERE  id_ingrediente=" . $id;
       $result = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($result);
        return $row;
    }
    function consulta_ingrediente_p_t($id) {
        $sql = "SELECT
    id_ingrediente_p_t
    , id_p_t
    , cantidad_ingrediente_p_t
    , id_producto
    , nombre_p_t
FROM
    dbprosic.prosic_ingrediente_p_t
    WHERE id_ingrediente_p_t=" . $id;
       $result = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($result);
        return $row;
    }
    

    function consulta_ingrediente_x_cantidad($id) {
        $sql = "SELECT
    prosic_ingrediente.id_ingrediente
    , prosic_producto.id_producto
    , prosic_producto.nombre_producto
    , prosic_ingrediente.cantidad_ingrediente
    , prosic_unidad_medida.id_unidad_medida
    , prosic_unidad_medida.abrevia_unidad_medida
    , prosic_producto.precio_unitario_producto
    , prosic_p_e.id_p_e
    , prosic_p_e.nombre_p_e
    , prosic_p_e.nombre_unidad_medida
FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_ingrediente
        ON (prosic_p_e.id_p_e = prosic_ingrediente.id_p_e)
    INNER JOIN dbprosic.prosic_producto
        ON (prosic_ingrediente.id_producto = prosic_producto.id_producto)
    INNER JOIN dbprosic.prosic_unidad_medida
        ON (prosic_producto.id_unidad_medida = prosic_unidad_medida.id_unidad_medida);
        WHERE prosic_p_e.id_p_e=" . $id;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_producto_elaborado($limit='') {
        $sql = "SELECT
    prosic_p_e.id_p_e
    , prosic_p_e.cod_p_e
    , prosic_p_e.nombre_p_e
    , prosic_p_e.costo_p_e
    , prosic_p_e.cantidad_p_e
    , prosic_p_e.id_unidad_medida
    , prosic_p_e.nombre_unidad_medida
FROM
    dbprosic.prosic_p_e  order by prosic_p_e.nombre_p_e asc";
        $sql.=$limit;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }
	//add 25/04
    function getProductosFormula($limit='') {
        $sql = "SELECT * FROM
    dbprosic.formula_producto order by id_producto asc";
        $sql.=$limit;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }	
	
	
	
	//end
    function consulta_producto_terminado($limit='') {
    $sql = "SELECT
    prosic_producto.id_producto
    , prosic_categoria.id_categoria
    , prosic_categoria.nombre_categoria
    , prosic_producto.codigo_producto
    , prosic_producto.nombre_producto
    , prosic_producto.descripcion_producto
    , prosic_producto.precio_unitario_producto
FROM
    dbprosic.prosic_categoria
    INNER JOIN dbprosic.prosic_producto
        ON (prosic_categoria.id_categoria = prosic_producto.id_categoria)
        WHERE prosic_categoria.id_categoria NOT IN (28,29) order by prosic_categoria.id_categoria,prosic_producto.nombre_producto asc";
        $sql.=$limit;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function cargar_campos_producto_elaborado() {
        $sql = "SELECT
                 prosic_p_e.id_p_e
                 , prosic_p_e.cod_p_e
                 , prosic_p_e.nombre_p_e
                 , prosic_p_e.cantidad_p_e
                 , prosic_p_e.id_unidad_medida
                 , `prosic_p_e`.nombre_unidad_medida
                 FROM
                 dbprosic.prosic_p_e;
                 ";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function cargar_campos_producto_terminado() {
        $sql = "SELECT
      id_producto
    , codigo_producto
    , nombre_producto
    ,precio_unitario_producto
FROM
    dbprosic.prosic_producto
    WHERE id_categoria NOT IN (28,29);
                 ";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function cargar_campos_producto() {
        $sql = "    SELECT
                    prosic_producto.id_producto
                    , prosic_producto.cod_producto
                    , prosic_producto.nombre_producto
                    , prosic_producto.precio_unitario_producto
                    , prosic_unidad_medida.abrevia_unidad_medida
                FROM
                    dbprosic.prosic_producto
                    INNER JOIN dbprosic.prosic_unidad_medida
                        ON (prosic_producto.id_unidad_medida = prosic_unidad_medida.id_unidad_medida)
                        WHERE precio_unitario_producto!=0;";
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function insertar_producto_elaborado($fields, $values) {
        $retornar = $this->sqlInsert("prosic_producto", $fields, $values);
        return $retornar;
    }

    function insertar_ingrediente($fields, $values) {
        $retornar = $this->sqlInsert("prosic_ingrediente", $fields, $values);
        return $retornar;
    }
    function insertar_ingrediente_p_t($fields, $values) {
        $retornar = $this->sqlInsert("prosic_ingrediente_p_t", $fields, $values);
        return $retornar;
    }

    function insertar_movimiento($fields, $values) {
        $retornar = $this->sqlInsert("alm0012010", $fields, $values);
        return $retornar;
    }

    function insertar__detalle_movimiento($fields, $values) {
        $retornar = $this->sqlInsert("alm0022010", $fields, $values);
        return $retornar;
    }

    function update_producto_elaborado($fields, $values, $id, $value) {
        $retornar = $this->sqlUpdate("prosic_producto", $fields, $values, $id, $value);
        return $retornar;
    }

    function update_ingrediente($fields, $values, $id1, $value1, $id2, $value2) {
        $retornar = $this->sqlUpdate2("prosic_ingrediente", $fields, $values, $id1, $value1, $id2, $value2);
        return $retornar;
    }
      function update_ingrediente_p_t($fields, $values, $id1, $value1, $id2, $value2) {
        $retornar = $this->sqlUpdate2("prosic_ingrediente_p_t", $fields, $values, $id1, $value1, $id2, $value2);
        return $retornar;
    }

    function delete_ingrediente($id1, $value1, $id2, $value2) {
        $retornar = $this->sqlDelete("prosic_ingrediente", $id1, $value1, $id2, $value2);
        return $retornar;
    }
    function delete_ingrediente_p_t($id1, $value1, $id2, $value2) {
        $retornar = $this->sqlDelete("prosic_ingrediente_p_t", $id1, $value1, $id2, $value2);
        return $retornar;
    }

    function consulta_hoja_produccion($id_hoja_produccion) {
        $sql = "SELECT
      prosic_hoja_produccion.id_hoja_produccion
    , prosic_hoja_produccion.cod_hoja_produccion
    , prosic_hoja_produccion.fecha_crea_hoja_produccion
    , prosic_p_e.id_p_e
    , prosic_p_e.cod_p_e
    , prosic_p_e.nombre_p_e
    , prosic_p_e.nombre_unidad_medida
    , prosic_hoja_produccion.cantidad_e_hoja_produccion
    , prosic_hoja_produccion.cantidad_r_hoja_produccion
    , prosic_hoja_produccion.costo_e_hoja_produccion
    , prosic_hoja_produccion.costo_r_hoja_produccion
    , prosic_hoja_produccion.fecha_crea_hoja_produccion
    , prosic_hoja_produccion.status_hoja_produccion
    , prosic_p_e.cantidad_p_e
    , prosic_p_e.id_unidad_medida
FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_hoja_produccion.id_p_e = prosic_p_e.id_p_e)
        WHERE id_hoja_produccion=" . $id_hoja_produccion;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        return $row;
    }



    function consulta_hoja_venta_x_id($id_hoja_venta) {
        $sql = "SELECT
    prosic_hoja_venta.id_hoja_venta
    , prosic_hoja_venta.cod_hoja_venta
    , prosic_producto.id_producto
    , prosic_producto.codigo_producto
    , prosic_producto.nombre_producto
    , prosic_hoja_venta.cantidad_hoja_venta
    , prosic_hoja_venta.costo_hoja_venta
    , prosic_hoja_venta.fecha_crea_hoja_venta
    , prosic_hoja_venta.status_hoja_venta
    , prosic_hoja_venta.id_operacion
    , prosic_hoja_venta.id_local
FROM
    dbprosic.prosic_hoja_venta
    INNER JOIN dbprosic.prosic_producto 
        ON (prosic_hoja_venta.id_producto = prosic_producto.id_producto)
        WHERE prosic_hoja_venta.id_hoja_venta=" . $id_hoja_venta;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function consulta_detalle_hoja($id_hoja_produccion) {
        $sql = "SELECT
    `prosic_detalle_hoja`.`id_detalle_hoja`
    , `prosic_detalle_hoja`.`id_ingrediente`
    , `prosic_detalle_hoja`.`cantidad_estima_detalle_hoja`
    , `prosic_detalle_hoja`.`cantidad_real_detalle_hoja`
    , `prosic_detalle_hoja`.`costo_estima_detalle_hoja`
    , `prosic_detalle_hoja`.`costo_real_detalle_hoja`
    , `prosic_ingrediente`.`nombre_producto`
    , `prosic_p_e`.`cantidad_p_e`
    , `prosic_ingrediente`.`cantidad_ingrediente`
    , `prosic_p_e`.`id_unidad_medida`
    , `prosic_ingrediente`.`costo_ingrediente`
    , `prosic_detalle_hoja`.`id_det_mov`
FROM
    `dbprosic`.`prosic_hoja_produccion`
    INNER JOIN `dbprosic`.`prosic_detalle_hoja`
        ON (`prosic_hoja_produccion`.`id_hoja_produccion` = `prosic_detalle_hoja`.`id_hoja_produccion`)
    INNER JOIN `dbprosic`.`prosic_ingrediente`
        ON (`prosic_detalle_hoja`.`id_ingrediente` = `prosic_ingrediente`.`id_ingrediente`)
    INNER JOIN `dbprosic`.`prosic_p_e`
        ON (`prosic_ingrediente`.`id_p_e` = `prosic_p_e`.`id_p_e`)
                  WHERE prosic_detalle_hoja.id_hoja_produccion=" . $id_hoja_produccion;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function consulta_detalle_hoja_venta($id_hoja_venta) {
        $sql = "SELECT
    prosic_detalle_hoja_venta.id_detalle_hoja_venta
    , prosic_ingrediente_p_t.id_ingrediente_p_t
    , prosic_ingrediente_p_t.id_p_t
    , prosic_detalle_hoja_venta.cantidad_detalle_hoja_venta
    , prosic_ingrediente_p_t.nombre_p_t
    , prosic_detalle_hoja_venta.id_det_mov
FROM
    dbprosic.prosic_hoja_venta
    INNER JOIN dbprosic.prosic_detalle_hoja_venta
        ON (prosic_hoja_venta.id_hoja_venta = prosic_detalle_hoja_venta.id_hoja_venta)
    INNER JOIN dbprosic.prosic_ingrediente_p_t
        ON (prosic_ingrediente_p_t.id_ingrediente_p_t = prosic_detalle_hoja_venta.id_ingrediente_p_t)
    INNER JOIN dbprosic.prosic_producto
        ON (prosic_producto.id_producto = prosic_ingrediente_p_t.id_producto)
        WHERE prosic_hoja_venta.id_hoja_venta=" . $id_hoja_venta;
        $result = $this->Consulta_Mysql($sql);
        return $result;
    }

    function get_codigo($ultimo, $inicial) {

        if ($ultimo != null) {
            $longitud = strlen($ultimo);
            $parte_numero = substr($ultimo, 1);
            $parte_numero_num = substr($ultimo, 1) + 1;
            $longitud_parte_letra = strlen($parte_numero_num);
            $parte_letra = substr($ultimo, 0, 1);
            $longitud_parte_numero = strlen($parte_letra);
            $cantidad_ceros = $longitud - $longitud_parte_letra - $longitud_parte_numero;
            $ceros = $parte_letra;
            for ($i = 0; $i < $cantidad_ceros; $i++) {
                $ceros = $ceros . "0";
            }
            $codigo_final = $ceros . $parte_numero_num;
        } else {
            $codigo_final = $inicial . "0000001";
        }
        return $codigo_final;
    }

      function get_ultimo_id($tabla, $id) {
        $sql = "SELECT MAX(" . $id . ") FROM " . $tabla;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $max_id = $row[0];
        return $max_id;
    }

    function suma_ingredientes($id) {
        $sql = "  SELECT SUM(costo_ingrediente) AS suma
                    FROM
                        dbprosic.prosic_ingrediente
                        INNER JOIN dbprosic.prosic_p_e
                        ON (prosic_ingrediente.id_p_e = prosic_p_e.id_p_e)
                    WHERE prosic_p_e.id_p_e=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $sum_id = $row[0];
        return $sum_id;
    }

    function consulta_existe_ingrediente($id, $prod) {
        $sql = "  SELECT
    prosic_ingrediente.cantidad_ingrediente
        FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_ingrediente
        ON (prosic_p_e.id_p_e = prosic_ingrediente.id_p_e)
        WHERE prosic_p_e.id_p_e=" . $id . " AND prosic_ingrediente.id_producto=" . $prod;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cant = $row[0];
        return $cant;
    }
	//add 25/04
	    function getCantidadAnt($id, $id_art) {
        $sql = "  SELECT cantidad_articulo 
        FROM dbprosic.formula_detalles 
        WHERE id_producto= " . $id . " AND id_articulo= " . $id_art;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cant = $row[0];
        return $cant;
    }
	
	// end add
     function consulta_existe_ingrediente_p_t($id, $prod) {
        $sql = "  SELECT
   cantidad_ingrediente_p_t
        FROM
    prosic_producto
    INNER JOIN prosic_ingrediente_p_t
        ON (prosic_producto.id_producto = prosic_ingrediente_p_t.id_producto)
        WHERE prosic_producto.id_producto=" . $id . " AND prosic_ingrediente_p_t.id_p_t=" . $prod;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cant = $row[0];
        return $cant;
    }


    function consulta_costo_ingrediente($prod) {
        $sql = "  SELECT
    prosic_ingrediente.costo_ingrediente
        FROM
  dbprosic.prosic_ingrediente WHERE
       prosic_ingrediente.id_producto=" . $prod;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cost = $row[0];
        return $cost;
    }
 function consulta_get_nombre_medida($id) {
        $sql = "  SELECT tab0240002 FROM tab0240000 WHERE tab0240001=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $medida = $row[0];
        return $medida;
    }

    function get_ce_hoja_x_producto($id){
    $sql = "SELECT SUM(cantidad_e_hoja_produccion)AS cantidad_e FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE prosic_p_e.id_p_e=" .$id . " ORDER BY fecha_crea_hoja_produccion  DESC";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $ce = $row[0];
        return $ce;
}
function get_cr_hoja_x_producto($id){
    $sql = "SELECT SUM(cantidad_r_hoja_produccion)AS cantidad_r FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE prosic_p_e.id_p_e=" .$id . " ORDER BY fecha_crea_hoja_produccion  DESC";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cr = $row[0];
        return $cr;
}

function get_nombre_p_e($id){
    $sql = "  SELECT nombre_p_e FROM prosic_p_e WHERE id_p_e=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_row($result);
        $nombre = $row[0];
        return $nombre;

}
function get_cod_p_e($id){
    $sql = "  SELECT cod_p_e FROM prosic_p_e WHERE id_p_e=" . $id;
        $result = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_row($result);
        $cod = $row[0];
        return $cod;

}

 function get_ce_hoja_x_producto_x_fecha($id,$fecha1,$fecha2){
    $sql = "SELECT SUM(cantidad_e_hoja_produccion)AS cantidad_e FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE prosic_p_e.id_p_e=".$id ." AND  fecha_crea_hoja_produccion  BETWEEN '".$fehca1."' AND '".$fecha2."'";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $ce = $row[0];
        return $ce;
}
 function get_cr_hoja_x_producto_x_fecha($id,$fecha1,$fecha2){
    $sql = "SELECT SUM(cantidad_r_hoja_produccion)AS cantidad_r FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE prosic_p_e.id_p_e=".$id ." AND  fecha_crea_hoja_produccion  BETWEEN '".$fehca1."' AND '".$fecha2."'";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cr = $row[0];
        return $cr;
}
function get_ce_hoja_x_fecha($fecha1,$fecha2){
    $sql = "SELECT SUM(cantidad_e_hoja_produccion)AS cantidad_e FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE fecha_crea_hoja_produccion  BETWEEN '".$fehca1."' AND '".$fecha2."'";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $ce = $row[0];
        return $ce;
}
function get_cr_hoja_x_fecha($fecha1,$fecha2){
    $sql = "SELECT SUM(cantidad_r_hoja_produccion)AS cantidad_r FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE fecha_crea_hoja_produccion  BETWEEN '".$fehca1."' AND '".$fecha2."'";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cr = $row[0];
        return $cr;
}
function get_ce_hoja(){
    $sql = "SELECT SUM(cantidad_e_hoja_produccion) AS ce FROM prosic_hoja_produccion";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $ce = $row[0];
        return $ce;
}
function get_cr_hoja(){
    $sql = "SELECT SUM(cantidad_r_hoja_produccion) AS cr FROM prosic_hoja_produccion";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cr = $row[0];
        return $cr;
}

 function get_coe_hoja_x_producto_x_fecha($id,$fecha1,$fecha2){
    $sql = "SELECT SUM(costo_e_hoja_produccion)AS coe FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE prosic_p_e.id_p_e=".$id ." AND  fecha_crea_hoja_produccion  BETWEEN '".$fehca1."' AND '".$fecha2."'";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $coe = $row[0];
        return $coe;
}
 function get_cor_hoja_x_producto_x_fecha($id,$fecha1,$fecha2){
    $sql = "SELECT SUM(costo_r_hoja_produccion)AS cor FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE prosic_p_e.id_p_e=".$id ." AND  fecha_crea_hoja_produccion  BETWEEN '".$fehca1."' AND '".$fecha2."'";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cor = $row[0];
        return $cor;
}
function get_coe_hoja_x_fecha($fecha1,$fecha2){
    $sql = "SELECT SUM(costo_e_hoja_produccion)AS coe FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE fecha_crea_hoja_produccion  BETWEEN '".$fehca1."' AND '".$fecha2."'";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $coe = $row[0];
        return $coe;
}
function get_cor_hoja_x_fecha($fecha1,$fecha2){
    $sql = "SELECT SUM(costo_r_hoja_produccion) AS cor FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE fecha_crea_hoja_produccion  BETWEEN '".$fehca1."' AND '".$fecha2."'";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cor = $row[0];
        return $cor;
}
function get_coe_hoja(){
    $sql = "SELECT SUM(costo_e_hoja_produccion) AS coe FROM prosic_hoja_produccion";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $coe = $row[0];
        return $coe;
}
function get_cor_hoja(){
    $sql = "SELECT SUM(costo_r_hoja_produccion) AS cor FROM prosic_hoja_produccion";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cor = $row[0];
        return $cor;
}
function get_coe_hoja_x_producto($id){
    $sql = "SELECT SUM(costo_e_hoja_produccion)AS coe FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE prosic_p_e.id_p_e=" .$id . " ORDER BY fecha_crea_hoja_produccion  DESC";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $coe = $row[0];
        return $coe;
}
function get_cor_hoja_x_producto($id){
    $sql = "SELECT SUM(costo_r_hoja_produccion)AS cor FROM
    dbprosic.prosic_p_e
    INNER JOIN dbprosic.prosic_hoja_produccion
        ON (prosic_p_e.id_p_e = prosic_hoja_produccion.id_p_e)
        WHERE prosic_p_e.id_p_e=" .$id . " ORDER BY fecha_crea_hoja_produccion  DESC";
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cor = $row[0];
        return $cor;
}

    function selected_local($tabla, $id, $etiqueta, $defecto='', $newsql='', $status='') {

        $retorna = ' <label>' . $etiqueta . '</label> ';

        $retorna.= '<select id="' . $id . '" name="' . $id . '" > ';

        $sql = ($newsql == "") ? "SELECT * FROM " . $tabla . $status : $newsql;

        $res = $this->Consulta_Mysql($sql);

        while ($row_select = mysql_fetch_array($res)) {
            if ($row_select[0] == $defecto)
                $selected = " selected='selected' ";
            else
                $selected = " ";

            $retorna.= "<option value='" . $row_select[1] . "' $selected>" . utf8_encode($row_select[2]) . "</option>";
        }

        $retorna.= '</select><br>';

        return $retorna;
    }

       function consulta_existe_fecha_producto_hoja_venta($fecha_crea_hoja_venta,$id_producto,$id_local) {
        $sql = "  SELECT
    id_hoja_venta
    , id_producto
    , cod_hoja_venta
    , cantidad_hoja_venta
    , fecha_crea_hoja_venta
    , id_local
    , id_hoja_venta
    , id_producto
    , cod_hoja_venta
    , cantidad_hoja_venta
    , costo_hoja_venta
    , fecha_crea_hoja_venta
    , status_hoja_venta
    , id_operacion
    , id_local
FROM
    dbprosic.prosic_hoja_venta
                  WHERE fecha_crea_hoja_venta='".$fecha_crea_hoja_venta."'
                  AND id_producto=".$id_producto." AND id_local='".$id_local."'";
        $result = $this->Consulta_Mysql($sql);
        $row = @mysql_fetch_assoc($result);
        return $row;
    }

    function consulta_cantidad_detalle_hoja($id) {
        $sql = "  SELECT
    cantidad_detalle_hoja_venta
FROM
    dbprosic.prosic_detalle_hoja_venta
WHERE id_hoja_venta=".$id;
      $result = $this->Consulta_Mysql($sql);
        return $result;
    }
}
?>
