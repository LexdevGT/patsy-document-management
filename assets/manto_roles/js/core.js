$(function(){

    sidebar();   
    load_roles_list();

    $('#crear_rol').click(function(){
        create_rol();
    });
  
});

function new_function(roleId, isChecked) {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'cambio_de_status',
            rol_id: roleId,
            nuevo_estado: isChecked ? 1 : 0 // Convierte isChecked en 1 (encendido) o 0 (apagado)
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

function create_rol() {

    var nombre_rol = $('#manto_roles_input_nombre');

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'crear_rol',
            nombre_rol: $('#manto_roles_input_nombre').val()
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                alert('Rol creado correctamente.');
                nombre_rol.val('');
                load_roles_list();
            } else {
                alert('Error al crear el rol: ' + response.error);
            }
        }
    });
}

function lista_roles_cambiar_estado(roleId, isChecked) {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'cambio_de_status',
            rol_id: roleId,
            nuevo_estado: isChecked ? 1 : 0 // Convierte isChecked en 1 (encendido) o 0 (apagado)
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

function load_roles_list() {

    // Obtén la referencia a la tabla
    var tableBody = $('#manto_roles_table_roles');

    // Limpia cualquier contenido previo en la tabla
    tableBody.empty();

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'load_roles_list'
        }),
        dataType: "json",
        success: function (r) {
            if (r.error === '') {
                // Verifica si hay datos en la respuesta
                if (r.data && r.data.length > 0) {
                    // Recorre los datos y construye las filas de la tabla
                    $.each(r.data, function (index, role) {
                        var row = $('<tr>');
                        row.append('<td>' + (index + 1) + '.</td>');
                        row.append('<td>' + role.nombre_rol + '</td>');

                        // Crea el switch con el estado adecuado
                        var switchHtml = '<div class="form-group">' +
                            '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">' +
                            '<input type="checkbox" class="custom-control-input" id="customSwitch' + (index + 1) + '"';
                        
                        // Verifica el estado del rol (como cadena)
                        if (role.status_rol === '1') {
                            switchHtml += ' checked'; // Si status_rol es '1', enciende el switch
                        }

                        switchHtml += ' onclick="lista_roles_cambiar_estado(' + role.id_rol + ', this.checked)"' + // Agrega el controlador de eventos click
                            '>' +
                            '<label class="custom-control-label" for="customSwitch' + (index + 1) + '"></label>' +
                            '</div>' +
                            '</div>';

                        row.append('<td>' + switchHtml + '</td>');
                        tableBody.append(row);
                    });
                } else {
                    // No se encontraron roles
                    tableBody.append('<tr><td colspan="3">No se encontraron roles.</td></tr>');
                }
            } else {
                alert(r.error);
                window.location.replace('../dashboard.html');
            }
        }
    });
}





function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.manto_roles').parent().addClass( "active" );
}

