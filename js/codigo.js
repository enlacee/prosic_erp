// Documento JavaScript
function llamarasincrono2 (url, id_contenedor, that)
{
	var pick = that.options[that.selectedIndex].value;
    var pagina_requerida = false;
    if (window.XMLHttpRequest)
    {
        // Si es Mozilla, Safari etc
        pagina_requerida = new XMLHttpRequest ();
    } else if (window.ActiveXObject)
    {
        // pero si es IE
        try 
        {
            pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            // en caso que sea una versión antigua
            try
            {
                pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP");
            }
            catch (e)
            {
            }
        }
    } 
    else
    return false;
    pagina_requerida.onreadystatechange = function ()
    {
        // función de respuesta
        cargarpagina2 (pagina_requerida, id_contenedor);
    }
	var a=url+pick;
    pagina_requerida.open ('GET', a , true); // asignamos los métodos open y send
    pagina_requerida.send (null);
}
// todo es correcto y ha llegado el momento de poner la información requerida
// en su sitio en la pagina xhtml
function cargarpagina2 (pagina_requerida, id_contenedor)
{
    if(pagina_requerida.readyState==1){
        document.getElementById (id_contenedor).innerHTML = "<br />";
    }
    else{
    if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
        document.getElementById (id_contenedor).innerHTML = pagina_requerida.responseText;
	}
}