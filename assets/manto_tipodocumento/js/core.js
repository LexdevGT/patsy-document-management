$(function(){

    sidebar();   

    $('#enviar').click(function(){
        create_tipo_docto();
    });
    
    load_list();  
});

function new_function(){
    
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/php/services.php",
        data: ({
            option: 'security'                   
        }),
        dataType: "json",        
        success: function(r) {                                                   
            if(r.error == ''){
                /* No code */
            }else{
                alert(r.error);
                window.location.replace('../dashboard.html');
            }
        }    
    });
}

function lista_cambiar_estado(Id, isChecked) {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'cambio_de_status_tipo_docto',
            id: Id,
            nuevo_estado: isChecked ? 1 : 0
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                alert('Estado actualizado correctamente.');
            } else {
                alert('Error al actualizar el estado: ' + response.error);
            }
        }
    });
}

function load_list() {

    // Obtén la referencia a la tabla
    var tableBody = $('#cuerpo_tabla');

    // Limpia cualquier contenido previo en la tabla
    tableBody.empty();

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'load_tipo_docto_list'
        }),
        dataType: "json",
        success: function (r) {
            if (r.error === '') {
                // Verifica si hay datos en la respuesta
                if (r.data && r.data.length > 0) {
                    // Recorre los datos y construye las filas de la tabla
                    $.each(r.data, function (index, tipo_docto) {
                        var row = $('<tr>');
                        row.append('<td>' + (tipo_docto.id) + '.</td>');
                        row.append('<td>' + decodeURI(escape(tipo_docto.nombre)) + '</td>');
                        row.append('<td>' + decodeURI(escape(tipo_docto.siglas)) + '</td>');
                        // Crea el switch con el estado adecuado
                        var switchHtml = '<div class="form-group">' +
                            '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">' +
                            '<input type="checkbox" class="custom-control-input" id="customSwitch' + (tipo_docto.id) + '"';
                        
                        // Verifica el estado del rol (como cadena)
                        if (tipo_docto.status === '1') {
                            switchHtml += ' checked'; // Si status_rol es '1', enciende el switch
                        }

                        switchHtml += ' onclick="lista_cambiar_estado(' + tipo_docto.id + ', this.checked)"' + // Agrega el controlador de eventos click
                            '>' +
                            '<label class="custom-control-label" for="customSwitch' + tipo_docto.id + '"></label>' +
                            '</div>' +
                            '</div>';

                        row.append('<td>' + switchHtml + '</td>');
                        tableBody.append(row);
                    });
                } else {
                    // No se encontraron roles
                    tableBody.append('<tr><td colspan="3">No se encontraron tipos de documentos.</td></tr>');
                }
            } else {
                alert(r.error);
            }
        },
        beforeSend: function(xhr) {
            xhr.overrideMimeType('text/html;charset=ISO-8859-1');
        }
    });
}

function create_tipo_docto() {

    var nombre_tipo_docto   = $('#tipo_documento');
    var siglas              = $('#siglas'); 

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'crear_tipo_docto',
            nombre: nombre_tipo_docto.val(),
            siglas: siglas.val()
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                alert('Tipo de documento creado correctamente.');
                nombre_tipo_docto.val('');
                siglas.val('');
                load_list();
            } else {
                alert('Error al crear el tipo de documento: ' + response.error);
            }
        }
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.manto_tipodocumento').parent().addClass( "active" );
}

