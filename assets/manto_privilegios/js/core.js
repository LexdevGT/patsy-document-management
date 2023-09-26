$(function(){

    sidebar();   
    load_roles_select();

    $('#select_rol').change(function(){
        load_privileges();
    });

    $('#enviar').click(function(){
        save_data();
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

function save_data() {
    var selectedPrivileges = [];
    $("input[type='checkbox']:checked").each(function () {
        selectedPrivileges.push($(this).attr('id'));
    });
    
    var rol = $('#select_rol').val();

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'guardar_privilegios',
            rol_id: rol,
            privilegios: selectedPrivileges
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                alert('privilegios actualizados correctamente.');
            } else {
                alert('Error al actualizar los privilegios: ' + response.error);            
            }
        }
    });
}

function load_privileges() {
    var id_rol = $('#select_rol').val();
    var privileges_html_left = '';
    var privileges_html_right = '';
    var privileges_container = $('#privileges_checkboxes');
    var conteo = 0;

    //alert('iniciando a cargar');

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'cargar_privilegios',
            id_rol
        },
        dataType: "json",
        success: function (response) {
            //console.log(response);
            //console.log(response.data);
            //console.log(response.data.length);
            if (response.error === '') {
                //alert('llego sin errores');
                /*if (response.data && response.data.length > 0) {*/
                if (response.data) {
                    var halfLength = Math.ceil(response.data.length / 1.9); // Calcula la mitad de los elementos
                    
                    privileges_html_left += '<div class="col-sm-6">';
                    privileges_html_right += '<div class="col-sm-6">';
                    
                    $.each(response.data, function (index, p) {
                        //console.log('privilegio: ' + p.id_privilegio + ' Nombre: ' + p.nombre_privilegio + ' check: ' + p.chequed);
                        
                        var privilegeHtml = '<div class="custom-control custom-checkbox">' +
                            '<input class="custom-control-input" type="checkbox" id="'+p.id_privilegio+'" data-path="'+p.path+'"';

                        if (p.chequed == 1) {
                            privilegeHtml += 'checked>';
                        } else {
                            privilegeHtml += '>';
                        }

                        privilegeHtml += '<label for="'+p.id_privilegio+'" class="custom-control-label">' + p.nombre_privilegio + '</label>' +
                            '</div>';

                        // Distribuye los privilegios en función del índice
                        if (index < halfLength) {
                            if(conteo == 0 && p.path.includes("manto")){
                                privileges_html_left +='<h2>Mantenimiento</h2>'
                                conteo = conteo + 1;
                            }
                            privileges_html_left += privilegeHtml;
                        } else {
                            if(conteo == 0 && p.path.includes("manto")){
                                privileges_html_right +='<h2>Mantenimiento</h2>'
                                conteo = conteo + 1;
                            }
                            privileges_html_right += privilegeHtml;
                        }
                    });

                    privileges_html_left += '</div>';
                    privileges_html_right += '</div>';

                    privileges_container.empty();
                    privileges_container.append(privileges_html_left);
                    privileges_container.append(privileges_html_right);
                } else {
                    privileges_container.empty();
                    privileges_container.append('<h2>La tabla de privilegios tiene problemas</h2>');
                }
            } else {
                alert(response.error);
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
                $('#privileges_checkboxes').empty();
                $('#select_rol').html(response.html);
            } else {
                alert(response.error);
            }
        }
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.manto_privilegios').parent().addClass( "active" );
}

