<?php

/**
 * Sistema Prosic
 * Clase de la Aplicacion PROSIC
 * @package		Prosic
 * @author		Pamela Fernandez Landio
 * @copyright	Copyright 2010
 * @license		Pamela Fernandez Landio
 * @since		Version 1.0
 * @filesource
 */
?>
<?php

class Mysql_Prosic {

    private $hostname_conexion = "localhost";
    private $database_conexion = "dbprosic";
    private $username_conexion = "root";
    private $password_conexion = "";
//    
//    private $hostname_conexion = "190.41.210.60:3306";
//    private $database_conexion = "dbprosic";
//    private $username_conexion = "root";
//    private $password_conexion = "p3dr02010";
    private $conexion;
    public $page = "";
    public $lastpage = "";
    public $numrows = "";

    /**
     * Sistema Prosic
     * Constructor Genera La conexion a la Base de Datos
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2010
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function __construct() {
        if (!($con = mysql_connect($this->hostname_conexion, $this->username_conexion, $this->password_conexion))) {

            echo"Error al conectar a la base de datos";

            exit();
        }
        if (!mysql_select_db($this->database_conexion, $con)) {

            echo "Error al seleccionar la base de datos";

            exit();
        }

        mysql_query ("SET NAMES 'utf8'");

        $this->conexion = $con;

        return true;
    }

    /**
     * Sistema Prosic
     * Funcion Para Desconectar la Base de Datos
     * @package		Prosic
     * @author		Pamela Fernandez Landio
     * @copyright	Copyright 2010
     * @license		Pamela Fernandez Lansio
     * @since		Version 1.0
     * @filesource
     */
    function mysql_desconectar() {

        mysql_close($this->conexion);
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
    function Consulta_Mysql($sql) {
        $res = mysql_query($sql, $this->conexion);

        return $res;
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
    function Todos_Registros($sql) {

        $res = mysql_query($sql, $this->conexion);

        $total_row = mysql_num_rows($res);

        return $total_row;
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
    function TotalRegistrosTabla($fname, $tname) {

        $sql = "SELECT count($fname) FROM $tname ";

        $result = $this->Consulta_Mysql($sql);

        while ($row = mysql_fetch_array($result)) {
            return $row[0];
        }
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
    function Dropdown_Sql($sql, $id, $value, $select='') {

        $res = $this->Consulta_Mysql($sql);

        while ($row = mysql_fetch_assoc($res)) {

            if ($row[$id] == $select)
                $selected = " selected='selected' ";
            else
                $selected=" ";

            echo "<option value='" . $row[$id] . "' $selected>" . $row[$value] . "</option>";
        }
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
    function Dropdown_Sql_Codigo($sql, $id, $value, $codigo, $select='') {

        $res = $this->Consulta_Mysql($sql);

        while ($row = mysql_fetch_assoc($res)) {

            if ($row[$id] == $select)
                $selected = " selected='selected' ";
            else
                $selected=" ";

            echo "<option value='" . $row[$id] . "' $selected>" . $row[$codigo] . "-" . $row[$value] . "</option>";
        }
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
    function sqlInsert($tabla, $fields, $values) {
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
        return mysql_query($sql, $this->conexion);
        //return $sql;
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
    function sqlUpdate($tabla, $fields, $values, $idkey, $valuekey) {
        $sql = "UPDATE " . $tabla . " SET ";

        for ($i = 0; $i < sizeof($fields); $i++) {
            if ($i != (sizeof($fields) - 1)
            )
                $sql.= $fields[$i] . "=" . $values[$i] . ", ";
            else
                $sql.=$fields[$i] . "=" . $values[$i] . " WHERE " . $idkey . "=" . $valuekey;
        }

        return mysql_query($sql, $this->conexion);
        //return $sql;
    }

    function sqlUpdate3($tabla, $fields, $values, $idkey, $valuekey) {
        $sql = "UPDATE " . $tabla . " SET ";
        $sql.= $fields . "=" . $values;
        $sql.=" WHERE " . $idkey . "=" . $valuekey;

        return mysql_query($sql, $this->conexion);
        // return $sql;
    }

    function sqlUpdate2($tabla, $fields, $values, $idkey1, $valuekey1, $idkey2, $valuekey2) {
        $sql = "UPDATE " . $tabla . " SET ";

        for ($i = 0; $i < sizeof($fields); $i++) {
            if ($i != (sizeof($fields) - 1)
            )
                $sql.= $fields[$i] . "=" . $values[$i] . ", ";
            else
                $sql.=$fields[$i] . "=" . $values[$i] . " WHERE " . $idkey1 . "=" . $valuekey1 . " AND " . $idkey2 . "=" . $valuekey2;
        }
        return mysql_query($sql, $this->conexion);

        //  return $sql;
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
    function cargar_campos_de_tabla($tabla) {
        $sql = "SELECT COLUMN_NAME FROM information_schema.COLUMNS
		WHERE TABLE_SCHEMA = 'dbprosic' AND TABLE_NAME = '" . $tabla . "'";

        $result = $this->Consulta_Mysql($sql);

        return $result;
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
    function textfield($etiqueta, $nombre, $defecto='', $atributos='') {
        $retorna = '<label>' . $etiqueta . '</label>';

        $retorna.= '<input type="text" name="' . $nombre . '" id="' . $nombre . '" value="' . $defecto . '" ' . $atributos . ' />';

        return $retorna;
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
    function textfield_id($etiqueta, $nombre, $defecto='', $atributos='') {
        $retorna = '<label>' . $etiqueta . '</label>';

        $retorna.= '<input type="text" name="' . $nombre . '" id="' . $nombre . '" readonly="readonly" value="' . $defecto . '" ' . $atributos . ' />';

        return $retorna;
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
    function textfield_readonly($nombre, $defecto='', $atributos='') {
        $retorna = '<input type="text" tabindex="-10000" name="' . $nombre . '" id="' . $nombre . '" readonly="readonly" value="' . $defecto . '" ' . $atributos . ' />';
        return $retorna;
    }

    function textarea($etiqueta, $nombre, $defecto='', $atributos='') {
        $retorna = '<label>' . $etiqueta . '</label>';
        $retorna.= '<textarea id="' . $nombre . '" name="' . $nombre . '" rows="1" cols="65" ' . $atributos . '>' . $defecto . '</textarea>';
        return $retorna;
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
    function selected($tabla, $id, $etiqueta, $defecto='', $newsql='', $status='', $extra='',$colvalue='',$coldescrip='') {

        $retorna = ' <label>' . $etiqueta . '</label> ';

        $retorna.= '<select id="' . $id . '" name="' . $id . '" ' . $extra . '> ';

        $sql = ($newsql == "") ? "SELECT * FROM " . $tabla . $status : $newsql;

        $res = $this->Consulta_Mysql($sql);

        while ($row_select = mysql_fetch_array($res)) {
            if ($row_select[0] == $defecto)
                $selected = " selected='selected' ";
            else
                $selected = " ";
			$sValue=($carvalue=="")? $row_select[0] : $row_select[$colvalue];
			$sText=($coldescrip=="")? $row_select[2] : $row_select[$coldescrip];

            $retorna.= "<option value='" . $sValue . "' $selected>" . utf8_encode($sText) . "</option>";
        }

        $retorna.= '</select><br>';

        return $retorna;
    }

    function selected_nombre($tabla, $id, $etiqueta, $defecto='', $newsql='', $status='') {

        $retorna = ' <label>' . $etiqueta . '</label> ';

        $retorna.= '<select id="' . $id . '" name="' . $id . '" > ';

        $sql = ($newsql == "") ? "SELECT * FROM " . $tabla . $status : $newsql;

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
    function selected_otro($tabla, $campo, $id, $etiqueta, $defecto, $newsql='', $status='') {

        $retorna = ' <label>' . $etiqueta . '</label> ';

        $retorna.= '<select id="' . $campo . '" name="' . $campo . '" > ';

        $sql = ($newsql == "") ? "SELECT * FROM " . $tabla . $status : $newsql;

        $res = $this->Consulta_Mysql($sql);

        while ($row_select = mysql_fetch_array($res)) {
            if ($row_select[0] == $defecto)
                $selected = " selected='selected' ";
            else
                $selected = " ";

            $retorna.= "<option value='" . $row_select[0] . "' $selected>" . $row_select[1] . "-" . utf8_encode($row_select[2]) . "</option>";
        }

        $retorna.= '</select><br>';

        return $retorna;
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
    function iniciar_form($nombre, $action) {
        $r = ' <form id="' . $nombre . '" name="' . $nombre . '" action="' . $action . '" method="post"> ';
        return $r;
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
    function cerrar_form() {
        $r = '</form>';
        return $r;
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
    function submit($valor='') {
        $etiqueta = ($valor == '') ? "Guardar" : $valor;
        $r = '<input id="btnguardar" name="btnguardar" type="submit" value="' . $etiqueta . '" class = "submit-go"/>';
        return $r;
    }

    function submit_button($valor='') {
        $etiqueta = ($valor == '') ? "Guardar" : $valor;
        $r = '<input id="btnguardar" name="btnguardar" type="button" value="' . $etiqueta . '" class = "submit-go"/>';
        return $r;
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
    function button_cancelar($ruta, $div, $texto='') {
        if ($texto == ''
        )
            $value = "Cancelar";else
            $value=$texto;
        $r = '<input id="btncancelar" name="btncancelar" type="button" value="' . $value . '" class = "submit-cancelar"
    onclick="cargar_pagina(\'' . $ruta . '\',\'' . $div . '\')" />';
        return $r;
    }

    function button_nuevo($ruta, $div) {
        $r = '<input id="btnnuevo" name="btnnuevo" type="button" value="Nuevo Registro" class = "submit-nuevo"
    onclick="cargar_pagina(\'' . $ruta . '\',\'' . $div . '\')" />';
        return $r;
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
    function crear_button($id, $valor) {
        $r = '<input id="' . $id . '" name="' . $id . '" type="button" value="' . $valor . '" class = "submit-search" />';
        return $r;
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
    function button_buscar($modal) {
        $r = '<a href="#" tabindex="-10000" onclick="javascript:modalshow(\'' . $modal . '\')" ><img src="images/search.png" alt="Buscar" /></a>';
        return $r;
    }

	    function button_show($modal) {
        $r = '<a href="#" tabindex="-10000" onclick="javascript:modalshow(\'' . $modal . '\')" ><img src="images/search.png" alt="Buscar" /></a>';
        return $r;
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
    function button_imagen($id, $imagen) {
        $r = '<a href="#" id=' . $id . ' tabindex="-10000" ><img src="images/' . $imagen . '" alt="Buscar" /></a>';
        return $r;
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
    function crear_button_nuevo($modal) {
        $r = '<a href="#"  tabindex="-10000" onclick="javascript:modalshow(\'' . $modal . '\')" ><img src="images/new_reg.gif" alt="Nuevo" /></a>';
        return $r;
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
    function hidden($nombre, $valor='') {
        $r = '  <input type="hidden" id="' . $nombre . '" name="' . $nombre . '" value="' . $valor . '" /> ';
        return $r;
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
    function iniciar_fieldset($texto, $atributos='') {
        $r = '<fieldset class="login" ' . $atributos . ' ><legend>' . $texto . '</legend>';
        return $r;
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
    function cerrar_fieldset() {
        $r = '</fieldset>';
        return $r;
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
    function select_status($etiqueta, $id, $defecto) {
        $retorna = ' <label>' . $etiqueta . '</label> ';

        $retorna.= '<select id="' . $id . '" name="' . $id . '" > ';

        $valores = array('D' => 'Desactivado', 'A' => 'Activado');
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
    function cargar_nombre_campo($tabla, $post) {
        $sql = "SELECT COLUMN_NAME,COLUMN_KEY FROM information_schema.COLUMNS
		WHERE TABLE_SCHEMA = 'dbprosic' AND TABLE_NAME = '" . $tabla . "'";

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
    function cargar_valor_post($tabla, $post) {
        $sql = "SELECT COLUMN_NAME,DATA_TYPE,COLUMN_KEY FROM information_schema.COLUMNS
		WHERE TABLE_SCHEMA = 'dbprosic' AND TABLE_NAME = '" . $tabla . "'";

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
    function get_ultimo_id($tabla, $id) {
        $sql = "SELECT MAX(" . $id . ") FROM " . $tabla;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $max_id = $row[0];
        return $max_id;
    }

    function paginacion_simple($result, $pagina) {
        if (isset($pagina)) {
            $page = $pagina;
        } else {
            $page = 1;
        }

        $num_rows = mysql_num_rows($result);
        $rows_per_page = 20;
        $lastpage = ceil($num_rows / $rows_per_page);
        $page = (int) $page;
        if ($page > $lastpage) {
            $page = $lastpage;
        }
        if ($page < 1) {
            $page = 1;
        }

//CREO LA SENTENCIA LIMIT PARA AÑADIR A LA CONSULTA QUE DEFINITIVA
        $limit = ' LIMIT ' . ($page - 1) * $rows_per_page . ',' . $rows_per_page;

        $this->page = $page;
        $this->lastpage = $lastpage;
        $this->numrows = $num_rows;
        return $limit;
    }

    function mostrar_paginacion($page, $lastpage) {

        if ($page == 1) {
            $next_pagina = 2;
            $last_pagina = 1;
        } else {
            $next_pagina = (int) $page + 1;
            $last_pagina = $page - 1;
        }

        $page_siguiente = $next_pagina;
        $page_anterior = $last_pagina;
        $page_primero = 1;
        $page_ultimo = $lastpage;

        //$primero = '<a href="javascript:cargar_pagina(\'' . $page_primero . '\',\'' . $div . '\')" ><span class="lnk_next">Primero</span></a>';
        //$siguiente = '<a href="javascript:cargar_pagina(\'' . $page_siguiente . '\',\'' . $div . '\')" ><span class="lnk_next">Siguiente</span></a>';
        //$anterior = '<a href="javascript:cargar_pagina(\'' . $page_anterior . '\',\'' . $div . '\')" ><span class="lnk_next">Anterior</span></a>';
        //$ultimo = '<a href="javascript:cargar_pagina(\'' . $page_ultimo . '\',\'' . $div . '\')" ><span class="lnk_next">Ultimo</span></a>';
        $primero = '<button id="btnprimero" name="btnprimero" value="' . $page_primero . '" >Primero</button>';
        $siguiente = '<button id="btnsiguiente" name="btnsiguiente" value="' . $page_siguiente . '" >Siguiente</button>';
        $anterior = '<button id="btnanterior" name="btnanterior" value="' . $page_anterior . '" >Anterior</button>';
        $ultimo = '<button id="btnultimo" name="btnultimo" value="' . $page_ultimo . '" >Ultimo</button>';

        echo $primero . $siguiente . $anterior . $ultimo;
    }

    function suma_ingredientes($id) {
        $sql = "  SELECT SUM(costo_ingrediente) AS suma
                    FROM
                        dbprosic.prosic_ingrediente
                        INNER JOIN prosic_p_e
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
    INNER JOIN prosic_ingrediente
        ON (prosic_p_e.id_p_e = prosic_ingrediente.id_p_e)
        WHERE prosic_p_e.id_p_e=" . $id . " AND prosic_ingrediente.id_producto=" . $prod;
        $result = $this->Consulta_Mysql($sql);
        $row = mysql_fetch_row($result);
        $cant = $row[0];
        return $cant;
    }

    function consulta_costo_ingrediente($prod) {
        $sql = "  SELECT
    prosic_ingrediente.costo_ingrediente
        FROM
  prosic_ingrediente WHERE
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

    function button_libros($modal) {
        $r = '<a href="#" tabindex="-10000" onclick="javascript:modalshow(\'' . $modal . '\')" ><img src="images/printer.png" alt="Imprimir" /></a>';
        return $r;
    }

    function cargar_valor_post_caja($db, $tabla, $post) {
        $valores_campos = explode("|", $post);
        $query = "SELECT COLUMN_NAME,DATA_TYPE,COLUMN_KEY FROM information_schema.COLUMNS
		WHERE TABLE_SCHEMA = '" . $db . "' AND TABLE_NAME = '" . $tabla . "'";
        $result = $this->Consulta_Mysql($query);
        $contador = 0;
        while ($row = mysql_fetch_assoc($result)) {
            if ($row['DATA_TYPE'] == 'int' || $row['DATA_TYPE'] == 'decimal') {
                if (!$valores_campos[$contador]) {
                    $valor = 0;
                } else {
                    $valor = $valores_campos[$contador];
                }
                $valor_name[$contador] = $valor;
                $contador++;
            } else {
                $valor_name[$contador] = "'" . $valores_campos[$contador] . "'";
                $contador++;
            }
        }
        $sql = "INSERT INTO " . $tabla . " VALUES (";
        for ($i = 0; $i < sizeof($valor_name); $i++) {
            if ($i != (sizeof($valor_name) - 1))
                $sql.= $valor_name[$i] . ",";
            else
                $sql.= $valor_name[$i] . ");";
        }                              
        mysql_select_db($db);        
        mysql_query($sql, $this->conexion);
        return $sql;
    }

}

?>
