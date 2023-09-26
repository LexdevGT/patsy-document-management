$(function(){

    sidebar();    
    load_region_select();
    load_sucursal_select();
    load_roles_select();
    load_list();

    $('#enviar').click(function(){
        create_user();
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
            option: 'cambio_de_status_usuario',
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
            option: 'load_user_list'
        }),
        dataType: "json",
        success: function (r) {
            if (r.error === '') {
                
                // Verifica si hay datos en la respuesta
                if (r.data && r.data.length > 0) {
                
                    // Recorre los datos y construye las filas de la tabla
                    $.each(r.data, function (index, usuario) {
                        var row = $('<tr>');
                        row.append('<td>' + (usuario.id) + '.</td>');
                        row.append('<td>' + usuario.nombre + ' ' + usuario.apellido + '</td>');
                        row.append('<td>' + usuario.email + '</td>');

                        // Crea el switch con el estado adecuado
                        var switchHtml = '<div class="form-group">' +
                            '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">' +
                            '<input type="checkbox" class="custom-control-input" id="customSwitch' + (usuario.id) + '"';
                        
                        // Verifica el estado del usuario (como cadena)
                        if (usuario.status === '1') {
                            switchHtml += ' checked'; // Si status_rol es '1', enciende el switch
                        }

                        switchHtml += ' onclick="lista_cambiar_estado(' + usuario.id + ', this.checked)"' + // Agrega el controlador de eventos click
                            '>' +
                            '<label class="custom-control-label" for="customSwitch' + usuario.id + '"></label>' +
                            '</div>' +
                            '</div>';

                        row.append('<td>' + switchHtml + '</td>');
                        tableBody.append(row);
                    });
                } else {
                    // No se encontraron roles
                    tableBody.append('<tr><td colspan="3">No se encontraron usuarios en la base de datos.</td></tr>');
                }
            } else {
                alert(r.error);
            }
        }
    });
}


function create_user() {

    var nombre      = $('#nombre');
    var apellido    = $('#apellido');
    var email       = $('#email');
    var foto        = $('#foto');
    var region      = $('#select_region');
    var sucursal    = $('#select_sucursal');
    var rol         = $('#select_rol');
    var status      = $('#select_estatus');
    var pass1       = $('#pass1');
    var pass2       = $('#pass2');
    var firma       = $('#firma');

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'crear_usuario',
            nombre: nombre.val(),
            apellido: apellido.val(),
            email: email.val(),
            foto: foto.val(),
            region: region.val(),
            sucursal: sucursal.val(),
            rol: rol.val(),
            status: status.val(),
            pass1: pass1.val(),
            pass2: pass2.val(),
            firma: firma.val()
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                alert('Usuario creado correctamente.');
                nombre.val('');
                apellido.val('');
                email.val('');
                foto.val('');
                load_region_select();
                load_sucursal_select();
                load_roles_select();
                pass1.val('');
                pass2.val('');
                firma.val('');
                load_list();
            } else {
                alert('Error al crear el usuario: ' + response.error);
            }
        }
    });
}

function load_roles_select() {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'cargar_select_roles'
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                //alert('Estado actualizado correctamente.');
                $('#select_rol').empty();
                $('#select_rol').html(response.html);
            } else {
                alert(response.error);
            }
        }
    });
}

function load_sucursal_select() {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'cargar_select_sucursal'
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                //alert('Estado actualizado correctamente.');
                $('#select_sucursal').empty();
                $('#select_sucursal').html(response.html);
            } else {
                alert(response.error);
            }
        }
    });
}

function load_region_select() {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'cargar_select_region'
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                //alert('Estado actualizado correctamente.');
                $('#select_region').empty();
                $('#select_region').html(response.html);
            } else {
                alert(response.error);
            }
        }
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.manto_usuarios').parent().addClass( "active" );
}

