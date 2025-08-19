$(function(){

    sidebar();   
    load_list();

    $('#enviar').click(function(){
        create_sucursal();
    });
  
});

function new_function(Id, isChecked) {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'cambio_de_status_region',
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

function lista_cambiar_estado(Id, isChecked) {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'cambio_de_status_sucursal',
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
            option: 'load_sucursal_list'
        }),
        dataType: "json",
        success: function (r) {
            if (r.error === '') {
                // Verifica si hay datos en la respuesta
                if (r.data && r.data.length > 0) {
                    // Recorre los datos y construye las filas de la tabla
                    $.each(r.data, function (index, sucursal) {
                        var row = $('<tr>');
                        row.append('<td>' + (sucursal.id) + '.</td>');
                        row.append('<td>' + decodeURI(escape(sucursal.nombre)) + '</td>');

                        // Crea el switch con el estado adecuado
                        var switchHtml = '<div class="form-group">' +
                            '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">' +
                            '<input type="checkbox" class="custom-control-input" id="customSwitch' + (sucursal.id) + '"';
                        
                        // Verifica el estado del rol (como cadena)
                        if (sucursal.status === '1') {
                            switchHtml += ' checked'; // Si status_rol es '1', enciende el switch
                        }

                        switchHtml += ' onclick="lista_cambiar_estado(' + sucursal.id + ', this.checked)"' + // Agrega el controlador de eventos click
                            '>' +
                            '<label class="custom-control-label" for="customSwitch' + sucursal.id + '"></label>' +
                            '</div>' +
                            '</div>';

                        row.append('<td>' + switchHtml + '</td>');
                        tableBody.append(row);
                    });
                } else {
                    // No se encontraron roles
                    tableBody.append('<tr><td colspan="3">No se encontraron regiones.</td></tr>');
                }
            } else {
                alert(r.error);
            }
        }
    });
}

function create_sucursal() {

    var nombre_sucursal = $('#nombre_sucursal');

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'crear_sucursal',
            nombre: $('#nombre_sucursal').val()
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                alert('Sucursal creada correctamente.');
                nombre_sucursal.val('');
                load_list();
            } else {
                alert('Error al crear la sucursal: ' + response.error);
            }
        }
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.manto_sucursal').parent().addClass( "active" );
}

