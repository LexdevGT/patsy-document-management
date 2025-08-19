$(function(){

    sidebar();   
    load_list();

    $('#enviar').click(function(){
        create_departamento();
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
            option: 'cambio_de_status_departamento',
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
            option: 'load_departamento_list'
        }),
        dataType: "json",
        success: function (r) {
            if (r.error === '') {
                // Verifica si hay datos en la respuesta
                if (r.data && r.data.length > 0) {
                    // Recorre los datos y construye las filas de la tabla
                    $.each(r.data, function (index, departamento) {
                        var row = $('<tr>');
                        row.append('<td>' + (departamento.id) + '.</td>');
                        row.append('<td>' + decodeURI(escape(departamento.nombre)) + '</td>');

                        // Crea el switch con el estado adecuado
                        var switchHtml = '<div class="form-group">' +
                            '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">' +
                            '<input type="checkbox" class="custom-control-input" id="customSwitch' + (departamento.id) + '"';
                        
                        // Verifica el estado del rol (como cadena)
                        if (departamento.status === '1') {
                            switchHtml += ' checked'; // Si status_rol es '1', enciende el switch
                        }

                        switchHtml += ' onclick="lista_cambiar_estado(' + departamento.id + ', this.checked)"' + // Agrega el controlador de eventos click
                            '>' +
                            '<label class="custom-control-label" for="customSwitch' + departamento.id + '"></label>' +
                            '</div>' +
                            '</div>';

                        row.append('<td>' + switchHtml + '</td>');
                        tableBody.append(row);
                    });
                } else {
                    // No se encontraron roles
                    tableBody.append('<tr><td colspan="3">No se encontraron departamentos.</td></tr>');
                }
            } else {
                alert(r.error);
            }
        }
    });
}

function create_departamento() {

    var nombre_departamento = $('#nombre_departamento');

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'crear_departamento',
            nombre: $('#nombre_departamento').val()
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                alert('Departamento creado correctamente.');
                nombre_departamento.val('');
                load_list();
            } else {
                alert('Error al crear el departamento: ' + response.error);
            }
        }
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.manto_departamento').parent().addClass( "active" );
}

