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
               $.each(response.data, function(index,info){
                    var row = $('<tr>');
                    row.append('<td>'+info.nombre+'</td>');
                    row.append('<td>'+info.codigo+'</td>');
                    row.append('<td>'+info.tipo_de_solicitud+'</td>');
                    row.append('<td><a href="revisar.html?id='+info.id+'"><i class="fa-2x fas fa-pencil-alt"></i></a></td>');
                    row.append('</tr>');
                    table.append(row);
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
    $('.nav-link').find('i.fa-glasses').parent().addClass( "active" );
    load_documentos_revision();
}

