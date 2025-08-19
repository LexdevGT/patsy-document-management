$(function(){
    setTimeout(sidebar,600);

    $('.form-control-navbar').keyup(function(){
        var search = $(this).val();
        load_search_control_cambios(search);
        //alert(search);
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

function load_search_control_cambios(search) {
    var s = search;
    var table = $('#document_list');
    table.empty();

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_lista_control_cambios',
            busqueda: s
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
               $.each(response.data, function(index,info){
                    var row = $('<tr>');
                    row.append('<td>'+info.codigo+'</td>');
                    row.append('<td>'+info.observacion+'</td>');
                    row.append('<td>'+decodeURI(escape(info.estado_solicitado))+'</td>');
                    row.append('<td>'+info.fecha_hora_solicitud+'</td>');
                    row.append('<td>'+decodeURI(escape(info.solicitante))+'</td>');
                    row.append('<td>'+decodeURI(escape(info.aprueba))+'</td>');
                    row.append('</tr>');
                    table.append(row);
                    //console.log(row);
               });

            } else {
                alert(response.error);
            }
        }
    });
}

function load_documentos_control_cambios() {
    
    var table = $('#document_list');
    table.empty();

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_lista_control_cambios'
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
               $.each(response.data, function(index,info){
                    var row = $('<tr>');
                    row.append('<td>'+info.codigo+'</td>');
                    row.append('<td>'+info.observacion+'</td>');
                    row.append('<td>'+decodeURI(escape(info.estado_solicitado))+'</td>');
                    row.append('<td>'+info.fecha_hora_solicitud+'</td>');
                    //row.append('<td>'+decodeURI(escape(info.solicitante))+'</td>');
                    row.append('<td>'+info.solicitante+'</td>');
                    row.append('<td>'+info.aprueba+'</td>');
                    row.append('</tr>');
                    table.append(row);
                    //console.log(row);
               });

            } else {
                alert(response.error);
            }
        }
    });
}

function sidebar(){
    //alert('tratando de poner active fa-glasses');
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.fa-retweet').parent().addClass( "active" );
    load_documentos_control_cambios();
}

