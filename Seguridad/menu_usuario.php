<script type="text/javascript">
    $(function() {
        $("#tree").treeview({
            collapsed: false,
            animated: "medium",
            control:"#sidetreecontrol",
            persist: "location"
        });
    })
		
</script>
<div id="sidetree">
    <div class="treeheader">
      <h2 align="center">SEGURIDAD</h2></div>
    <div id="sidetreecontrol"><a href="../?#">(-)Contraer </a> &nbsp;&nbsp;  <a href="../?#">(+) Expandir </a></div>
<br />
    <ul id="tree" class="mi_menu">
        <li><span><strong>Usuarios</strong></span>
            <ul>
                <li><a href="javascript:cargar_pagina('Seguridad/form_usuario.php','#CapaContenedorFormulario')">
                        Agregar Nuevo</a></li>

                <li><a href="javascript:cargar_pagina('Seguridad/tabla_usuario.php','#CapaContenedorFormulario')">
                        Lista</a></li>

                <li><a href="javascript:cargar_pagina('Seguridad/SeguridadDesbloquearForm.php','#CapaContenedorFormulario')">
                        Desbloquear</a></li>
            </ul>
        </li>
        <li><span><strong>Privilegios</strong></span>
            <ul>
                <li><a href="javascript:cargar_pagina('Seguridad/UsuarioNuevoForm.php','#CapaContenedorFormulario')">
                        Gestionar</a></li>                
            </ul>
        </li>
    </ul>
</div>
<script type="text/javascript">
$("a").click(function(){
    $.blockUI({ css: { 
           border: 'none', 
           padding: '15px', 
           backgroundColor: '#000', 
           '-webkit-border-radius': '10px', 
           '-moz-border-radius': '10px', 
           opacity: .5, 
           color: '#fff' 
       } }); 	 
       setTimeout($.unblockUI, 1000);	    
});
</script>