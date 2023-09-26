$(function(){

    sidebar();   
    load_region_list();

    $('#enviar').click(function(){
        create_region();
    });
  
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

function load_region_list() {

    // Obtén la referencia a la tabla
    var tableBody = $('#manto_region_table_region');

    // Limpia cualquier contenido previo en la tabla
    tableBody.empty();

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'load_region_list'
        }),
        dataType: "json",
        success: function (r) {
            if (r.error === '') {
                // Verifica si hay datos en la respuesta
                if (r.data && r.data.length > 0) {
                    // Recorre los datos y construye las filas de la tabla
                    $.each(r.data, function (index, region) {
                        var row = $('<tr>');
                        row.append('<td>' + (region.id) + '.</td>');
                        row.append('<td>' + region.nombre + '</td>');

                        // Crea el switch con el estado adecuado
                        var switchHtml = '<div class="form-group">' +
                            '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">' +
                            '<input type="checkbox" class="custom-control-input" id="customSwitch' + (region.id) + '"';
                        
                        // Verifica el estado del rol (como cadena)
                        if (region.status === '1') {
                            switchHtml += ' checked'; // Si status_rol es '1', enciende el switch
                        }

                        switchHtml += ' onclick="lista_cambiar_estado(' + region.id + ', this.checked)"' + // Agrega el controlador de eventos click
                            '>' +
                            '<label class="custom-control-label" for="customSwitch' + region.id + '"></label>' +
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

function create_region() {

    var nombre_region = $('#nombre_region');

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'crear_region',
            nombre_region: $('#nombre_region').val()
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                alert('Región creada correctamente.');
                nombre_region.val('');
                load_region_list();
            } else {
                alert('Error al crear la región: ' + response.error);
            }
        }
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.manto_region').parent().addClass( "active" );
}

