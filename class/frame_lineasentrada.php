<?php




if($_GET['accion']=="grabar"){
	include ("conectar.php"); 
                $codfacturatmp=$_GET['codfacturatmp'];
                $codarticulo=$_GET['codarticulo'];
				$cantidad=$_GET['cantidad'];
				$precio=$_GET['precio'];
				$importe=$_GET['importe'];
				
				$sel_insert="INSERT INTO tem0012010 (tem0010004,tem0010000,tem0010005,tem0010006,tem0010007,tem0010009) VALUES ('$codfacturatmp','','$codarticulo','$cantidad','$precio','$importe')";
				$rs_insert=mysql_query($sel_insert);
				
				
echo "<input type='hidden' id='codfacturatmp' name='codfacturatmp' value=".$_GET['codfacturatmp'].">";
}

if($_GET['accion']=="elminar"){
	include ("conectar.php"); 
              $codfacturatmp=$_GET['codfacturatmp'];
				  $numlinea=$_GET['numlinea'];
	
				$sel_insert="DELETE FROM tem0012010 where tem0010000='$numlinea' and tem0010004='$codfacturatmp'";
				$rs_insert=mysql_query($sel_insert);

echo "<input type='hidden' id='codfacturatmp' name='codfacturatmp' value=".$_GET['codfacturatmp'].">";
}




include_once("../class/Class.Entrada.Prosic.php");
include_once '../function/function.php';

$obj = new Entrada_Prosic();
$result=$obj->consulta_producto_entrada_por_ida($codfacturatmp);
?>
    <?php echo $obj->hidden("id_p_e", $_SESSION['id_p_e']); ?>


<input type="hidden" id="id_p_e" value="<?php echo $_GET['iu'] ?>">


<table width="100%" class="tabla_gris">
        <caption>PRODUCTOS</caption>
        <thead>
            <tr>
                <th >ITEM</th>
                <th >ARTICULO</th>
                <th >DESCRIPCION</th>
                <th >CANTIDAD</th>
                <th >PRECIO</th>
                <th >IMPORTE</th>
<!--                <th >Costo</th>-->
                <th ></th>
                <th ></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row= mysql_fetch_assoc($result)){ ?>
                    <tr>
                        <td><?php echo $row['tem0010000']; ?></td>
                        <td><?php echo $row['tem0010005']; ?></td>
                        <td><?php echo $row['tab0090005']; ?></td>
                        <td align="right"><?php echo $row['tem0010006']; ?></td>
                        <td align="right"><?php echo $row['tem0010007']; ?></td>
                        <td align="right"><?php echo $row['tem0010009']; ?></td>
                        <td><a href='javascript:cargar_pagina("Almacen/frame_lineasentrada.php?numlinea=<?php echo $row['tem0010000'];?>","#contenedor_ingrediente")'><img src="images/edit.png" width=13 height=13 /></a></td>
                        <td><a href='javascript:cargar_pagina("Almacen/frame_lineasentrada.php?numlinea=<?php echo $row['tem0010000'];?>&codfacturatmp=<?php echo $row['tem0010004'];?>&accion=eliminar","#contenedor_ingrediente")'><img src="images/delete.gif" width=13 height=13 /></a></td>
                    </tr>
                    <?php } ?>
        </tbody>
    </table><br>