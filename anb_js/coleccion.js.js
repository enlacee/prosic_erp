


function imprimir(que) {
    var ventana = window.open('imprimir.html', '_blank', 'width=1,height=1,scrollbars=yes,status=no,resizable=no,screenx=200,screeny=200');
    var contenido = "<html><body onload='window.print();window.close();'>";
    contenido = contenido + document.getElementById(que).innerHTML + "</body></html>";
    ventana.document.open();
    ventana.document.write(contenido);
    ventana.document.close();
}