$(function(){

    setTimeout(sidebar,500);  

    load_basic_document_info();

    $('#summernote').summernote();
    var new_btn = '<div class="note-btn-group btn-group note-view"><button type="button" class="note-btn btn btn-light btn-sm btn-fullscreen note-codeview-keep" tabindex="-1" title="" aria-label="Print" data-original-title="print"><i class="fa fa-print"></i></button><button type="button" class="note-btn btn btn-light btn-sm btn-codeview note-codeview-keep" tabindex="-1" title="" aria-label="download" data-original-title="download"><i class="fa fa-cloud-download-alt"></i></button></div>'
    $('.note-toolbar').append(new_btn);

    $('#revisado').click(function(){
        window.location.replace('revision.html');
    });

    $('#rechazado').click(function(){
        $('#modal-rechazo').modal('show');
    });
  
});

function new_function() {

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
            }
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
                    row += '<td>Nombre: '+info.revisa+'</td>';
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
                    row += '<b>Tipo de documento:</b> '+info.tipo_de_documento+'<br>';
                    row += '<b>Versión:</b> '+info.version+'<br>';
                    row += '<b>Código:</b> '+info.codigo+'<br>';
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

