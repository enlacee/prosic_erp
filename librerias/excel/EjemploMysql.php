<?php
include("excelwriter.inc.php");
$excel=new ExcelWriter("reg_compras.xls");
if ($excel==false) {
echo $excel->error;
}

//Escribimos la primera fila con las cabeceras
$myArr=array("Nombre Comercial","Direccion","CP","Localidad","Telefono","Email");
$excel->writeLine($myArr);

//REALIZAMOS LA CONSULTA
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "root";
$dbname = "dbprosic";

$db2 = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error());
mysql_select_db($dbname) or die("Error al conectar a la base de datos.");
$sql2 = "SELECT * FROM prosic_usuario";
$sql2 .= " ORDER BY id_usuario ASC ";
$result2 = mysql_query( $sql2) or die("No se puede ejecutar la consulta: ".mysql_error());

//Escribimos todos los registros de la base de datos
//en el fichero EXCEL
while($Rs2 = mysql_fetch_array($result2)) {
$myArr=array(
$Rs2['id_usuario'],
$Rs2['codigo_usuario'],
$Rs2['nombre_usuario'],
$Rs2['email_usuario'],
$Rs2['id_tipo_usuario'],
$Rs2['id_empresa']
);
$excel->writeLine($myArr);
//Otra forma es
//$excel->writeLine($Rs2);
//De este modo volcariamos todos los registros seleccionados
//Sin necesidad de colocarlos/filtrar previamente en $myArr
}
$excel->close();

//Abrimos el fichero excel que acabamos de crear
header("location: reg_compras.xls");
?>