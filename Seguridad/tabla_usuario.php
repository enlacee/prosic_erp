<div class="div_header_center">LISTA DE USUARIOS</div>
<br />
<table id="TablaUsuarios" style="display:none"></table>
<script type="text/javascript">

    $("#TablaUsuarios").flexigrid
    (
    {
        url: 'Seguridad/data_usuario.php',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'id_usuario', width : 40, sortable : true, align: 'center'},
            {display: 'Codigo', name : 'codigo_usuario', width : 40, sortable : true, align: 'left'},			
            {display: 'Usuario', name : 'nombre_usuario', width : 120, sortable : true, align: 'left'},
            {display: 'Status', name : 'status_usuario', width : 30, sortable : true, align: 'left'},			
            {display: 'Empresa', name : 'nombre_empresa', width : 80, sortable : true, align: 'left'},
            {display: 'Tipo Usuario', name : 'nombre_tipo_usuario', width : 80, sortable : true, align: 'left'},
            {display: 'Email', name : 'email_usuario', width : 120, sortable : true, align: 'right'},
            {display: '', width : 10, sortable : true, align: 'center'},
            {display: '', width : 10, sortable : true, align: 'center'}			
        ],

        searchitems : [
            {display: 'Id', name : 'id_usuario'},
            {display: 'Usuario', name : 'nombre_usuario', isdefault: true}
        ],
			
        sortname: "id_usuario",
        sortorder: "asc",
        usepager: true,
        title: 'Usuarios del Sistema',
        useRp: true,
        rp: 10,
        showTableToggleBtn: true,
        width: 750,
        height: 240
    }
);	
</script>
