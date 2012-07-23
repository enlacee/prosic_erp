/**
 * Sistema Prosic Formulario de Registro de Ventas
 *
 * @package Prosic
 * @author Pamela Fernandez Landio
 * @copyright Copyright 2011
 * @license Pamela Fernandez Lansio
 * @since Version 1.0
 * @filesource
 */
function cargar_pagina(pagina, div_tabla){
$(div_tabla).html("<p class='loading'></p>");
    $(div_tabla).load(pagina);
}

function inicioEnvio(div_tabla){
    $(div_tabla).html('<img src="images/loader.gif" style="top:50%;left:50%; position: relative;">');
}

function capturaGet(name){
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var tmpURL = window.location.href;
    var results = regex.exec(tmpURL);
    if (results == null) 
        return "";
    else 
        return results[1];
}

function inicioEnvioparametro(capa){
    $(capa).html('<img src="images/loader.gif" style="top:150px;left:50%; position: absolute;">');
}

function showEndTasks(pagina){
    $("#divendtasks").show("slow", function(){
        $("#divendtasks").load(pagina);
    });
}

function changeContacto(){
    var cadena = $("#cbocontacto").attr('value');
    var nombres = cadena.split("-");
    $("#contacto").attr('value', nombres[1]);
    $("#telefono").attr('value', nombres[0]);
}

function modalshow(pag){
    window.open(pag, "Modal", ' width=500, height=300 , top=300,left=200 ,scrollbars=YES');
}

function modalshow2(pag){
    window.open(pag, "Modal", ' width=650, height=250 , top=300,left=200 ,scrollbars=YES');
}
function modalshowVariable(pag,width,height){
window.open(pag, "Modal", ' width='+width+', height='+height+' , top=120,left=200 ,scrollbars=YES');
} 

function modal_imprimir(pag){
    window.open(pag, "Modal", ' width=850, height=400 , top=200 ,scrollbars=YES');
}

function return_modal(id, code, name){
    window.opener.document.FrmUsuario.id_anexo.value = id;
    window.opener.document.FrmUsuario.codigo_proveedor.value = code;
    window.opener.document.FrmUsuario.nombre_proveedor.value = name;
    window.opener.document.FrmUsuario.codigo_proveedor.focus();
    self.close();
}

/**
 * Sistema Prosic Formulario de Registro de Ventas
 *
 * @package Prosic
 * @author Pamela Fernandez Landio
 * @copyright Copyright 2011
 * @license Pamela Fernandez Lansio
 * @since Version 1.0
 * @filesource
 */
function return_modal_cuenta_gasto(id, code, name){
    window.opener.document.FrmUsuario.id_plan_contable.value = id;
    window.opener.document.FrmUsuario.codigo_cuenta_gasto.value = code;
    window.opener.document.FrmUsuario.desc_cuenta.value = name;
    window.opener.document.FrmUsuario.codigo_cuenta_gasto.focus();
    self.close();
}

function return_modal_cuenta_banco(id, code, name){
    window.opener.document.FrmUsuario.id_plan_contable.value = id;
    window.opener.document.FrmUsuario.codigo_cuenta_banco.value = code;
    window.opener.document.FrmUsuario.desc_cuenta.value = name;
    window.opener.document.FrmUsuario.codigo_cuenta_banco.focus();
    self.close();
}

function return_modal_cuenta_cargar(id, code, name){
    window.opener.document.FrmUsuario.cargar_plan_contable.value = id;
    window.opener.document.FrmUsuario.cuenta_cargar.value = code;
    window.opener.document.FrmUsuario.desc_cargar.value = name;
    window.opener.document.FrmUsuario.cuenta_cargar.focus();
    self.close();
}

function return_modal_cuenta_abonar(id, code, name){
    window.opener.document.FrmUsuario.abonar_plan_contable.value = id;
    window.opener.document.FrmUsuario.cuenta_abonar.value = code;
    window.opener.document.FrmUsuario.desc_abonar.value = name;
    window.opener.document.FrmUsuario.cuenta_abonar.focus();
    self.close();
}

function return_modal_producto_elaborado(id, code, name,cant,n){
    window.opener.document.FrmUsuario.id_p_e.value = id;
    window.opener.document.FrmUsuario.cod_p_e.value = code;
    window.opener.document.FrmUsuario.nombre_p_e.value = name;
    window.opener.document.FrmUsuario.cantidad.value = cant;
    window.opener.document.FrmUsuario.abrevia.value = n;
    window.opener.document.FrmUsuario.cod_p_e.focus();
    self.close();
}

function return_modal_producto_terminado(id, code, name,precio){
    window.opener.document.FrmUsuario.id_producto.value = id;
    window.opener.document.FrmUsuario.cod_producto.value = code;
    window.opener.document.FrmUsuario.nombre_producto.value = name;
    window.opener.document.FrmUsuario.precio_unitario_producto.value = precio;
    window.opener.document.FrmUsuario.cantidad_producto.focus();
    self.close();
}

function return_modal_producto(cod,nom){
    window.opener.document.FrmUsuario.id_producto.value = cod;
    window.opener.document.FrmUsuario.cod_producto.value = cod;
    window.opener.document.FrmUsuario.nombre_producto.value = nom;
    window.opener.document.FrmUsuario.cantidad_ingrediente.focus();
    self.close();
}
function return_modal_producto_t(cod,nom){
    window.opener.document.FrmUsuario.id_p_t.value = cod;
    window.opener.document.FrmUsuario.cod_p_t.value = cod;
    window.opener.document.FrmUsuario.nombre_p_t.value = nom;
    window.opener.document.FrmUsuario.cantidad_ingrediente_p_t.focus();
    self.close();
}



/**
 * Sistema Prosic Formulario de Registro de Ventas
 *
 * @package Prosic
 * @author Pamela Fernandez Landio
 * @copyright Copyright 2011
 * @license Pamela Fernandez Lansio
 * @since Version 1.0
 * @filesource
 */
function return_modal_cuenta_costo(id, code, name){
    window.opener.document.FrmUsuario.cuenta_costo.value = id;
    window.opener.document.FrmUsuario.codigo_cuenta_costo.value = code;
    window.opener.document.FrmUsuario.desc_costo.value = name;
    window.opener.document.FrmUsuario.codigo_cuenta_costo.focus();
    self.close();
}

/**
 * Sistema Prosic Formulario de Registro de Ventas
 *
 * @package Prosic
 * @author Pamela Fernandez Landio
 * @copyright Copyright 2011
 * @license Pamela Fernandez Lansio
 * @since Version 1.0
 * @filesource
 */
function return_modal_cuenta_ingreso(id, code, name){
    window.opener.document.FrmUsuario.id_plan_contable.value = id;
    window.opener.document.FrmUsuario.codigo_cuenta_ingreso.value = code;
    window.opener.document.FrmUsuario.desc_ingreso.value = name;
    window.opener.document.FrmUsuario.codigo_cuenta_ingreso.focus();
    self.close();
}

/**
 * Sistema Prosic Formulario de Registro de Ventas
 *
 * @package Prosic
 * @author Pamela Fernandez Landio
 * @copyright Copyright 2011
 * @license Pamela Fernandez Lansio
 * @since Version 1.0
 * @filesource
 */
function return_modal_cuenta(id, code, name){
    window.opener.document.FrmUsuario.id_plan_contable.value = id;
    window.opener.document.FrmUsuario.cuenta_plan_contable.value = code;
    window.opener.document.FrmUsuario.descripcion_plan_contable.value = name;
    window.opener.document.FrmUsuario.cuenta_plan_contable.focus();
    self.close();
}

/**
 * Sistema Prosic Formulario de Registro de Ventas
 *
 * @package Prosic
 * @author Pamela Fernandez Landio
 * @copyright Copyright 2011
 * @license Pamela Fernandez Lansio
 * @since Version 1.0
 * @filesource
 */
function return_modal_cuenta_activo(id, code, name){
    window.opener.document.FrmUsuario.id_plan_contable.value = id;
    window.opener.document.FrmUsuario.codigo_cuenta_activo.value = code;
    window.opener.document.FrmUsuario.desc_cuenta_activo.value = name;
    window.opener.document.FrmUsuario.codigo_cuenta_activo.focus();
    self.close();
}
function return_modal_cuenta_60(id, code, name){
    window.opener.document.FrmArticulo.id_plan_contable.value = id;
    window.opener.document.FrmArticulo.codigo_cuenta_activo.value = code;
    window.opener.document.FrmArticulo.desc_cuenta_activo.value = name;
    window.opener.document.FrmArticulo.codigo_cuenta_activo.focus();
    self.close();
}

/**
 * Sistema Prosic Formulario de Registro de Ventas
 *
 * @package Prosic
 * @author Pamela Fernandez Landio
 * @copyright Copyright 2011
 * @license Pamela Fernandez Lansio
 * @since Version 1.0
 * @filesource
 */
function return_modal_cuenta_provision(id, code, name){
    window.opener.document.FrmUsuario.cuenta_provision.value = id;
    window.opener.document.FrmUsuario.codigo_cuenta_provision.value = code;
    window.opener.document.FrmUsuario.desc_cuenta_provision.value = name;
    window.opener.document.FrmUsuario.codigo_cuenta_provision.focus();
    self.close();
}
function return_modal_cuenta_2(id, code, name){
    window.opener.document.FrmArticulo.cuenta_provision.value = id;
    window.opener.document.FrmArticulo.codigo_cuenta_provision.value = code;
    window.opener.document.FrmArticulo.desc_cuenta_provision.value = name;
    window.opener.document.FrmArticulo.codigo_cuenta_provision.focus();
    self.close();
}


/**
 * Sistema Prosic Formulario de Registro de Ventas
 *
 * @package Prosic
 * @author Pamela Fernandez Landio
 * @copyright Copyright 2011
 * @license Pamela Fernandez Lansio
 * @since Version 1.0
 * @filesource
 */
function return_modal_cuenta_depreciacion(id, code, name){
    window.opener.document.FrmUsuario.cuenta_depreciacion.value = id;
    window.opener.document.FrmUsuario.codigo_cuenta_depreciacion.value = code;
    window.opener.document.FrmUsuario.desc_cuenta_depreciacion.value = name;
    window.opener.document.FrmUsuario.codigo_cuenta_depreciacion.focus();
    self.close();
}

function return_modal_cuenta_61(id, code, name){
	parent.window.close();


}
/**
 * Sistema Prosic Formulario de Registro de Ventas
 *
 * @package Prosic
 * @author Pamela Fernandez Landio
 * @copyright Copyright 2011
 * @license Pamela Fernandez Lansio
 * @since Version 1.0
 * @filesource
 */
function decimal_con_dos(n){
    ans = n * 1000
    ans = Math.round(ans / 10) + ""
    while (ans.length < 3) {
        ans = "0" + ans
    }
    len = ans.length
    ans = ans.substring(0, len - 2) + "." + ans.substring(len - 2, len)
    return ans
}

function dar_formato_de_fecha_texto(id_cajatexto){
    $("#" + id_cajatexto).keyup(function(){
    
        var valor = $("#" + id_cajatexto).val();
        var nuevo = "";
        if (valor.length == 4) {
            nuevo = valor + "-";
            $("#" + id_cajatexto).val(nuevo);
        }
        if (valor.length == 7) {
            nuevo = valor + "-";
            $("#" + id_cajatexto).val(nuevo);
        }
    })
}

function return_modal_comprobante(ia, ca, da, it, sc, nc, ec, tc, tt){
    window.opener.document.FrmUsuario.id_anexo.value = ia;
    window.opener.document.FrmUsuario.codigo_proveedor.value = ca;
    window.opener.document.FrmUsuario.nombre_proveedor.value = da;
    window.opener.document.FrmUsuario.id_tipo_comprobante.value= it;
	window.opener.document.FrmUsuario.serie_comprobante.value= sc;
	window.opener.document.FrmUsuario.nro_comprobante.value= nc;
	window.opener.document.FrmUsuario.emision_comprobante.value= ec;
	window.opener.document.FrmUsuario.tipo_cambio_comprobante.value= tc;
	window.opener.document.FrmUsuario.total_comprobante.value= tt;	
	//window.opener.document.FrmUsuario.nro_comprobante.focus();		
    self.close();
}

function return_modal_documento(ipc, ia, ca, it, sc, nc, is, fc, id){
	var ca = "C";
    window.opener.document.FrmUsuario.id_plan_contable.value = ipc;
	window.opener.document.FrmUsuario.cuenta_plan_contable.value=ia;
    window.opener.document.FrmUsuario.id_tipo_comprobante.value= it;
	window.opener.document.FrmUsuario.ser_doc_comprobante.value= sc;
	window.opener.document.FrmUsuario.nro_doc_comprobante.value= nc;
	window.opener.document.FrmUsuario.importe_soles.value= is;
	window.opener.document.FrmUsuario.importe_dolares.value= decimal_con_dos(id);
    window.opener.document.FrmUsuario.cargar_abonar.value= ca;
    window.opener.document.FrmUsuario.fecha_doc_comprobante.value= fc;
    window.opener.document.FrmUsuario.ser_doc_comprobante.focus();
    self.close();
}