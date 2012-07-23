


		<script language="javascript">

		$(function() {
		inicio();
		
});		
		function num1(e) {
    evt = e ? e : event;
    tcl = (window.Event) ? evt.which : evt.keyCode;
    if (tcl == 113)
    {
        document.getElementById("numero").focus();
    }
  
}		function num2(e) {
    evt = e ? e : event;
    tcl = (window.Event) ? evt.which : evt.keyCode;
    if (tcl == 113)
    {
         document.getElementById("vventa").focus();
    }
  
}
		
	function inicio(){
		document.formulario.codcliente.focus();
	
		} 
	

	
	function num700(e) {
    evt = e ? e : event;
    tcl = (window.Event) ? evt.which : evt.keyCode;
    if (tcl == 113)
    {
        abreVentana();
    }
 
}	
	function num {

	if(event.keyCode==13){return ventanaArticulos(); return false}

    }
 
}	
	function num900(e) {
    evt = e ? e : event;
    tcl = (window.Event) ? evt.which : evt.keyCode;
    if (tcl == 13)
    {
       document.formulario_lineas.codarticulo.focus();
    }
 
}	
		
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		var miPopup
		function abreVentana(){
			miPopup = window.open("Almacen/ver_clientesentrada.php","miwin","width=700,height=380,scrollbars=yes");
			miPopup.focus();
		}
		
		function ventanaArticulos(){
			var codigo=document.getElementById("codcliente").value;
			if (codigo=="") {
				alert ("Debe introducir el codigo del proveedor");
			} else {
				miPopup = window.open("Almacen/ver_articulosentrada.php","miwin","width=700,height=500,scrollbars=yes");
				miPopup.focus();
			}
		}
		
		function validarcliente(){
			var codigo=document.getElementById("codcliente").value;
			miPopup = window.open("comprobarcliente.php?codcliente="+codigo,"frame_datos","width=700,height=80,scrollbars=yes");
		}	
		
		function cancelar() {
			location.href="index.php";
		}
		
		function limpiarcaja() {
			document.getElementById("nombre").value="";
		}
		
		function actualizar_entrada()
			{
				var valorventa=parseFloat(document.getElementById("vventa").value);
				var valorigv=parseFloat(document.getElementById("vigv").value);
				valortotal=valorventa+valorigv;
				var original=parseFloat(valortotal);
				document.getElementById("vtotal").value=original;
			}
			
					function actualizar_importe()
			{
				var precio=document.getElementById("precio").value;
				var cantidad=document.getElementById("cantidad").value;
				total=precio*cantidad;
				var original=parseFloat(total);
				var result=Math.round(original*100)/100 ;
				document.getElementById("importe").value=result;
			}
	
			
					function validar3() 
			{
				actualizar_importe();
				if (document.getElementById("cantidad").value!="0") {
					
					validar() ;
					}
			}
		function validar() 
		
			{
			
		

			var precio= parseFloat(document.getElementById("precio").value);


			var id_p_e=$("#id_p_e").val();
	  $("#contenedor_ingrediente").load('Almacen/frame_lineasentrada.php?precio='+precio ,{id_p_e:id_p_e})
			
		}				
		
		</script>





<?php

include_once '../function/function.php';




include_once("../class/Class.Entrada.Prosic.php");

$obj = new Entrada_Prosic();

?>

<html>
<head>
	</head>
	<body  onLoad="inicio()">

<div class="div_header_center">REGISTRAR INGRESO</div>
<script>
    $(function() {
        $( "#tabs" ).tabs();
    });

</script>
<script type="text/javascript" src="Almacen/form_registro_entrada.js"></script>

<div class="demo" align="left">
    <div id="tabs">
      <ul>
          
           <li><a href="#tabs-1">Informacion Basica</a></li>           
        </ul>
        <div id="tabs-1">
                
            <?php echo $obj->iniciar_form("formulario", "Almacen/guardar_entrada.php"); ?>

              <?php echo $obj->submit(); ?>
            <?php echo $obj->button_cancelar("Almacen/grid_registro_entrada.php","#CapaContenedorFormulario"); ?>
          <br/>

 
  
 <?php if(isset($_GET['iu'])){

  $_SESSION['id_p_e'] = $_GET['iu']; 
 

$row = @$obj->ConsultaEntradaId($_GET['iu']);

		$opcion = "update";
		
	  
 }
 
 else 
 {
	 	$opcion = "add"; 
	   

	include ("conectar.php"); 
	


  $sel_entrada="SELECT * FROM `alm0012010` ORDER BY `alm0010006` DESC LIMIT 1";
  $rs_entrada=mysql_query($sel_entrada);
  $id=mysql_result($rs_entrada,0,"alm0010006");
  $id=$id+1;
	
	$fechahoy=date("Y-m-d");
	$sel_fact="INSERT INTO tem0022010 (tem0020000,tem0020001) VALUE ('','$fechahoy')";
$rs_fact=mysql_query($sel_fact);
$codfacturatmp=mysql_insert_id(); 	
   
 $_SESSION['id_p_e']=$codfacturatmp;
																		  
 }
 ?>

    <input type="hidden" id="id_p_e" value="<?php echo $_GET['iu'] ?>">
    
    
  <input type="hidden" id="opcion" name="opcion" value="<?php echo $opcion;?>" /> 
 
 
 <?php  echo $obj->iniciar_fieldset("Descripcion " . $entrada); ?>
 
 
 
 
 
 <table width="656" border="0">
   <tr>
     <td colspan="3" align="left"><p><?php echo $obj->selected("tab0100000", "tab0100002", "LOCAL", $row['alm0010002']); ?> </p></td>
   </tr>
   <tr>
     <td width="148" align="right">Cod. Proveedor</td>
     <td>
     
     
     
     <input name="codcliente" type="text" class="cajaPequena" id="codcliente" onClick="limpiarcaja()" size="15" maxlength="10" onKeyPress="if(event.keyCode==13){num(); return false}" value="<?php echo $row['alm0010005'] ?>">
     
     
     
         <img src="Almacen/img/ver.png" width="16" height="16" onClick="abreVentana()" title="Buscar cliente" onMouseOver="style.cursor=cursor"></td>
     <td><img src="Almacen/img/cliente.png" width="16" height="16" onClick="validarcliente()" title="Validar cliente" onMouseOver="style.cursor=cursor">
     
     
     
         <input name="nombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="80" readonly></td>
   </tr>
   <tr>
     <td colspan="3" align="left"><?php echo $obj->selected_nombre("tab0040000", "tab0040001", "DOCUMENTOS", $row['alm0010007']); ?></td>
   </tr>
   <tr>
     <td align="right">Nº Doc:</td>
     <td width="123">
     
     
     
     <input name="serie" type="text" class="cajaMinima" id="serie" value="<?php echo $row['alm0010008']; ?>" size="10" maxlength="6"  onKeyPress = "if(event.keyCode==13){ventanaArticulos(); return false}"/></td>
     <td width="371">
     
     
     <input name="numero" type="text" class="cajaPequena" id="numero" size="15" maxlength="15" value="<?php echo $row['alm0010009']; ?>" onKeyPress = "if(event.keyCode==13) {codarticulo.focus(); return false}" />
     
     
         <? $hoy=date("d/m/Y"); ?></td>
   </tr>
   <tr>
     <td align="right">Fecha Doc</td>
     <td colspan="2">
     
     
     <input name="fecha" type="text" class="cajaPequena" id="fecha" size="15" maxlength="10" value="<? echo $hoy?>">
     
     
     
     </td>
   </tr>
   <tr>
     <td align="right">Venta-IGV</td>
     <td colspan="2"><table width="438" height="27" border="0" align="left">
         <tr>
           <td>
           
       <input name="vventa" type="text" class="cajaTotales" id="vventa" onChange="actualizar_entrada()" value="<?php echo $row['alm0010011']; ?>" size="10" maxlength="10" align="right" onkeypress = "if(event.keyCode==13) {vigv.focus(); return false}" >
       
       
       </td>
           <td>
           
           <input name="vigv" type="text" class="cajaTotales" id="vigv" onChange="actualizar_entrada()"  size="12" maxlength="10" onKeyPress="if(event.keyCode==13) {vigv.focus(); return false}" value="<?php echo $row['alm0010012']; ?>">
           
           
           </td>
           <td>
           
           
           <input name="vtotal" type="text" class="cajaTotales" id="vtotal" size="10" maxlength="10" value="<?php echo $row['alm0010013']; ?>" readonly></td>
           <td><input id="codfacturatmp" name="codfacturatmp" value="<? echo $codfacturatmp?>" type="hidden">
           
           
               <input id="accion" name="accion" value="alta" type="hidden">
               
               
               </td>
         </tr>
     </table></td>
   </tr>
   <tr>
     <td colspan="3" align="left"><?php echo $obj->selected_nombre("tab0120000", "tab0120001", "Tipo de Movimiento", $row['alm0010003']); ?></td>
   </tr>
   <tr>
     <td colspan="3" align="left"><?php echo $obj->selected_nombre("tab0220000", "tab0220001", "Forma de Pago", $row['alm0010020']); ?></td>
   </tr>
 </table>

  <hr align="left" width="742">   


          


  			    <table width="653" border="0" align="left">
                  <tr>
                    <td colspan="4" align="left">Ingreso Articulos</td>
                  </tr>
                  <tr>
                    <td width="150" align="right">Articulo</td>
                    <td width="116"><input name="codarticulo" type="text" class="cajaMedia" id="codarticulo" size="15" maxlength="15" onKeyPress="return num800(event);"></td>
                    <td colspan="2"><img src="Almacen/img/ver.png" width="16" height="16" onClick="ventanaArticulos()" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                    <input name="descripcion" type="text" class="cajaMedia" id="descripcion" size="40" maxlength="30" readonly>
                    <input id="codfacturatmp" name="codfacturatmp" value="<? echo $codfacturatmp?>" type="hidden"></td>
                  </tr>
                  
                  <tr>
                    <td align="right">Precio</td>
                    <td><input name="precio" type="text" class="cajaPequena2" id="precio" style="text-align:right" onChange="actualizar_importe()" value="0" size="15" maxlength="10" onkeypress = "if(event.keyCode==13) {cantidad.focus(); return false}"></td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right">Cantidad</td>
                    <td><input name="cantidad" type="text" class="cajaMinima" id="cantidad" size="15" maxlength="15" value="0" onChange="actualizar_importe()" style="text-align:right" onKeyPress =  "if(event.keyCode==13) {validar3(); return false}" ></td>
                    <td width="44" align="right">Peso </td>
                    <td width="325"><input name="peso" type="text" class="cajaMinima" id="peso" size="15" maxlength="10" value="0" style="text-align:right" ></td>
                  </tr>
                  <tr>
                    <td align="right">Total</td>
                    <td><input name="importe" type="text" class="cajaPequena2" id="importe" size="15" maxlength="10" value="0" readonly style="text-align:right"></td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                </table>
                 
                    
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
       

         
         <div id="contenedor_ingrediente">

                <?php
                include 'frame_lineasentrada.php';
                ?>
            </div>
  
  
             
            <p>&nbsp;
               <?php echo $obj->cerrar_form(); ?>


            <?php echo $obj->cerrar_fieldset(); ?>

           
            <?php $obj->mysql_desconectar(); ?>

        </div>
    </div>
</div>
<script>

	
    $(function(){
        $("#FrmArticulo").validate({
            submitHandler: function(form) {
                if(confirm("¿Esta seguro en Guardar los datos?")){
                    $("#btnguardar").attr('disabled', 'disabled');
                    alert("Datos enviados Correctamente");
                    $(form).ajaxSubmit({
                        target: "#CapaContenedorFormulario"
                    });

                }else
                {
                    return false;
                }

            }
        });
    });   
</script>
</body>
</html>