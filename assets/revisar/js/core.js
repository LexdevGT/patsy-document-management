$(function(){

    setTimeout(sidebar,600);  

    $('#summernote').summernote();

    load_basic_document_info();
    load_document();

    var new_btn = '<div class="note-btn-group btn-group note-view"><button type="button" class="note-btn btn btn-light btn-sm btn-fullscreen note-codeview-keep btn-print" tabindex="-1" title="" aria-label="Print" data-original-title="print"><i class="fa fa-print"></i></button></div>'
    $('.note-toolbar').append(new_btn);

    $('#revisado').click(function(){
        docto_revisado();
    });

    $('#rechazado').click(function(){
        $('#modal-rechazo').modal('show');
    });

    $('#btn-save-rechazo').click(function(){
        guardar_comentario_rechazo();
    });

    $('.btn-print').click(function(){
        downloadDocument();
    });
  
});

function new_function() {

    // Obtener el valor del parámetro 'id' de la URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    //console.log('ID: '+id);

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_select_usuarios'
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                /* CODE */
            } else {
                alert(response.error);
                window.location.replace('revision.html');
            }
        }
    });
}

function downloadDocument() {
    // Obtener el valor del parámetro 'id' de la URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'revisar_obtener_path_documento',
            id: id
        },
        dataType: 'json',
        success: function(response) {
            if (response.error === '') {
                downloadFile(response.path);
            } else {
                alert(response.error);
            }
        }
    });
}

function downloadFile(fileName) {
    console.log('Inicio de downloadFile con fileName:', fileName);
    // Ajusta la ruta del servicio PHP que manejará la descarga
    var downloadUrl = '../assets/all/php/download.php';
    console.log('URL de descarga:', downloadUrl);


    // Crear un formulario dinámico para realizar la descarga
    var form = $('<form>', {
        'action': downloadUrl,
        'method': 'POST',
        'target': '_blank' // Abre la descarga en una nueva ventana/tapa
    });

    // Agregar un campo oculto al formulario con el nombre del archivo
    form.append($('<input>', {
        'type': 'hidden',
        'name': 'fileName',
        'value': fileName
    }));

    // Agregar un campo oculto al formulario con el nombre del folder
    form.append($('<input>', {
        'type': 'hidden',
        'name': 'folderName',
        'value': 'newdocuments'
    }));

    // Adjuntar el formulario al cuerpo del documento y enviarlo
    form.appendTo('body').submit().remove();
}

function docto_revisado() {

    // Obtener el valor del parámetro 'id' de la URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    var solicitud = urlParams.get('s');

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cambio_estatus_documento',
            id,
            solicitud,
            status: 9
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                //write_history(response.rol);
                alert(response.message);
                
                window.location.replace('revision.html');
            } else {
                alert(response.error);
                window.location.replace('revision.html');
            }
        }
    });
}

function write_history(rol){
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    //alert('rol:'+rol);
    if (rol == 14){
        var observacion = 'Documento Aprobado y oficial!';
        var s = 10;
    }else{
        var observacion = 'Solicitud revisada';    
        var s = 9;
    }
    
 
    
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'history',
            observacion,
            id,
            status: s,
            solicitud: 'Aprobación dada',
            observacion
        }),
        dataType: "json",        
        success: function(r) {                                                   
            if(r.error == ''){
                alert(r.message);
                window.location.replace('revision.html');
            }else{
                alert(r.error);
                //window.location.replace('solicitud_documento_d_i.html');
            }
        }    
    });
}

function guardar_comentario_rechazo() {

    // Obtener el valor del parámetro 'id' de la URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    var comentario = $('#comentario_rechazo').val();

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'guardar_comentario_rechazo',
            id,
            comentario
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                //console.log(response.data);
                window.location.replace('revision.html');
            } else {
                alert(response.error);
            }
        }
    });
}

function load_document() {
//alert('revisando');
    // Obtener el valor del parámetro 'id' de la URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    //console.log('ID: '+id);

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_documento_word',
            id
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                //console.log(response.data);
                var word = $('#summernote');
                word.summernote('code',response.message);
                //var download_btn = '<div class="note-btn-group btn-group note-view"><button type="button" class="note-btn btn btn-light btn-sm " tabindex="-1" title="" aria-label="download" data-original-title="download"><i class="fa fa-cloud-download-alt"></i></button></div>';
                //$('.note-toolbar').append(download_btn);
            } else {
                alert(response.error);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('Error en la llamada AJAX: ', textStatus, errorThrown);
        }
    });
}

function load_footer() {

    // Obtener el valor del parámetro 'id' de la URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    //console.log('ID: '+id);

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_informacion_footer_documento',
            id
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                //console.log(response.data);
                var footer = $('#footer-revisar');
                $.each(response.data,function(index,info){
                    var row = '<tr>';
                    row += '<td>Nombre: '+info.elabora+'</td>';
                    row += '<td>Nombre: '+decodeURI(escape(info.revisa))+'</td>';
                    row += '<td>Nombre: '+info.aprueba+'</td>';
                    row += '</tr><tr>'
                    row += '<td>Fecha: '+info.fecha_elabora+'</td>';
                    row += '<td>Fecha: '+info.fecha_revisa+'</td>';
                    row += '<td>Fecha: '+info.fecha_aprueba+'</td>';
                    row += '</tr>'
                    footer.html(row);
                });
            } else {
                alert(response.error);
            }
        }
    });
}

function load_basic_document_info() {

    // Obtener el valor del parámetro 'id' de la URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    //console.log('ID: '+id);

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_informacion_basica_documento',
            id
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                //console.log(response.data);
                var informacion = $('#info-basica');
                $.each(response.data,function(index,info){
                    var row = '<b>Nombre del documento: </b> '+info.nombre+'<br>';
                    row += '<b>Proceso principal:</b> '+info.proceso_principal+'<br>';
                    row += '<b>Tipo de documento:</b> '+decodeURI(escape(info.tipo_de_documento))+'<br>';
                    row += '<b>Versión:</b> '+decodeURI(escape(info.version))+'<br>';
                    row += '<b>Código:</b> '+info.codigo+'<br>';
                    row += '<b>Alcance:</b> '+info.alcance+'<br>';
                    informacion.html(row);
                    $('#nombre-proyecto').html(info.nombre);
                });
                load_footer(id);
            } else {
                alert(response.error);
            }
        }
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.fa-glasses').parent().addClass( "active" );
}

