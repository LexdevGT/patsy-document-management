$(function(){
    setTimeout(sidebar,500);
    //sidebar();   

    $('#salir').click(function(){
        window.location.replace('dashboard.html');
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

function procesado(id) {
    //alert('documento procesado!');
    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'procesar_documento',
            id
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                alert(response.message);
                location.reload();
            } else {
                alert(response.error);
            }
        }
    });
}

function confirmarProcesado(id,nombre) {
    // Muestra una ventana de confirmación antes de procesar el documento
    var confirmacion = confirm('¿Estas seguro que ya no necesitas ver este documento: '+nombre+' en la lista por procesar?');
    if (confirmacion) {
        procesado(id);
    }
}

function load_documentos_revision() {
    
    var table = $('#document_list');
    table.empty();

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_lista_documentos'
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                if(response.data.length > 0){
                    $.each(response.data, function(index,info){
                    var row = $('<tr>');
                        row.append('<td><a href="revisar.html?id='+info.id+'&s='+info.id_solicitud+'">'+info.nombre+'</a></td>');
                        row.append('<td>'+info.codigo+'</td>');
                        row.append('<td>'+decodeURI(escape(info.tipo_de_solicitud))+'</td>');
                        //row.append('<td><a href="revisar.html?id='+info.id+'&s='+info.id_solicitud+'"><i class="fa-2x fas fa-pencil-alt"></i></a><i class="fa-2x fas fa-check-circle ml-2 text-success" onclick="confirmarProcesado(' + info.id + ', \'' + info.nombre + '\')"></i></td>');
                        row.append('<td><a href="revisar.html?id='+info.id+'&s='+info.id_solicitud+'"><i class="fa-2x fas fa-pencil-alt"></i></a></td>');
                        row.append('</tr>');
                        table.append(row);
                        //console.log(row);
                   });
                }
               

            } else {
                alert(response.error);
            }
        }
    });
}

function sidebar(){
    //alert('tratando de poner active fa-glasses');
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.fa-glasses').parent().addClass( "active" );
    load_documentos_revision();
}

