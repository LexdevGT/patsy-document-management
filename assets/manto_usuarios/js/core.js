$(function(){

    sidebar();    
    load_departamento_select();
    load_roles_select();
    load_list();

    $('#enviar').click(function(){
        create_user();
    });

    $('#modificar').click(function(){
        modificar_usuario();
    });

    $(document).on('click', '.editar-usuario', function (event) {
        event.preventDefault();
        var userId = $(this).data('id');
        var inputs = new Array('nombre','apellido','email');
        var selects = new Array('sucursal_id','rol_id','status');
       
        // Hacer una solicitud AJAX para obtener los datos del usuario específico
        $.ajax({
            type: "POST",
            url: "../assets/all/php/services.php",
            data: {
                option: 'obtener_datos',
                id: userId,
                selects,
                inputs,
                tabla:'users'
            },
            dataType: "json",
            success: function (r) {
                if (r.error === '') {
                    // Recorre los datos y construye la información
                    $.each(r.message, function (index, data) {
                        //console.log(index);
                        if (index == 'nombre') {
                            $('#nombre').val(data);
                        }
                        if (index == 'apellido') {
                            $('#apellido').val(data);
                        }
                        if (index == 'email') {
                            $('#email').val(data);
                        }
                        if (index == 'sucursal_id') {
                            var sucursal_id = data;
                            fill_select(sucursal_id,'select_departamento','sucursal');
                        }
                        if (index == 'rol_id') {
                            var rol_id = data;
                            fill_select(rol_id,'select_rol','roles');
                        }
                    });
                    $('#pass1').val('');
                    $('#pass2').val('');
                    $('#email').prop("disabled",true);
                    $('#select_estatus').prop("disabled",true);
                    $('#firma').prop("disabled",true);
                    $('#foto').prop("disabled",true);
                    $('#modificar').show();
                    $('#enviar').hide();

                } else {
                    alert('Error al obtener los datos del usuario: ' + response.error);
                }
            }
        });
    });
  
});

function new_function(){
    
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'security'                   
        }),
        dataType: "json",        
        success: function(r) {                                                   
            if(r.error == ''){
                /* No code */
            }else{
                alert(r.error);
                window.location.replace('dashboard.html');
            }
        }    
    });
}

function modificar_usuario(){
    
    var nombre = $('#nombre').val();
    var apellido = $('#apellido').val();
    var select_departamento = $('#select_departamento').val();
    var select_rol = $('#select_rol').val();
    var pass1 = $('#pass1').val();
    var pass2 = $('#pass2').val();
    var email = $('#email').val();

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'modificar_usuario',
            nombre,
            apellido,
            select_departamento,
            select_rol,
            pass1,
            pass2,
            email
        }),
        dataType: "json",        
        success: function(r) {                                                   
            if(r.error == ''){
                alert(r.message);
                window.location.reload();
            }else{
                alert(r.error);
                window.location.replace('dashboard.html');
            }
        }    
    });
}

function fill_select(search,html_id,table){
    
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'datos_select',
            buscar: search,
            html_id,
            tabla:table                   
        }),
        dataType: "json",        
        success: function(r) {                                                   
            if(r.error == ''){
                $('#'+html_id).empty();
                $('#'+html_id).html(r.message);
            }else{
                alert(r.error);
                window.location.replace('dashboard.html');
            }
        }    
    });
}

function upload_user_firma(email){
    //alert('haciendo upload de la photo');
    var form_data = new FormData();                  
    var totalfiles = document.getElementById('firma').files.length;
    var e = email;
//alert(e);
       for (var index = 0; index < totalfiles; index++) {
          form_data.append("firma[]", document.getElementById('firma').files[index]);
       }
       form_data.append("email",e);
       form_data.append("option","firma");
        //console.log(form_data);             
    $.ajax({
        url: '../assets/all/php/upload_user_photo.php', 
        dataType: 'text',  
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
            if (php_script_response == "No files") {
                alert('No se logro guardar tu firma!!!');
                window.location.replace('dashboard.html');
            }else{
                //alert('Tu foto fue modificada!');
                //window.location.replace('dashboard.html');
            }
        }
    });
}

function upload_user_photo(email){
    //alert('haciendo upload de la photo');
    var form_data = new FormData();                  
    var totalfiles = document.getElementById('foto').files.length;
    var e = email;
//alert(e);
       for (var index = 0; index < totalfiles; index++) {
          form_data.append("foto[]", document.getElementById('foto').files[index]);
       }
       form_data.append("email",e);
       form_data.append("option","foto");
        //console.log(form_data);             
    $.ajax({
        url: '../assets/all/php/upload_user_photo.php', 
        dataType: 'text',  
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
            if (php_script_response == "No files") {
                alert('No se logro guardar tu imagen!!!');
                window.location.replace('dashboard.html');
            }else{
                //alert('Tu foto fue modificada!');
                //window.location.replace('dashboard.html');
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

var currentPage = 1;
var usersPerPage = 10;

function load_list(page = 1) {
    currentPage = page;
    
    // Obtén la referencia a la tabla
    var tableBody = $('#cuerpo_tabla');

    // Limpia cualquier contenido previo en la tabla
    tableBody.empty();

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'load_user_list',
            page: page,
            limit: usersPerPage
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
                        //row.append('<td>' + usuario.nombre + ' ' + usuario.apellido + '</td>');
                        row.append('<td><a href="#" class="editar-usuario" data-id="' + usuario.id + '">' + usuario.nombre + ' ' + usuario.apellido + '</a></td>');
                        row.append('<td>' + usuario.email + '</td>');
                        row.append('<td>' + usuario.nombre_rol + '</td>');

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
                    
                    // Actualizar paginación
                    updatePagination(r.current_page, r.total_pages);
                } else {
                    // No se encontraron usuarios
                    tableBody.append('<tr><td colspan="5">No se encontraron usuarios en la base de datos.</td></tr>');
                    updatePagination(1, 1);
                }
            } else {
                alert(r.error);
            }
        }
    });
}

function updatePagination(currentPage, totalPages) {
    var paginationHtml = '';
    
    // Botón anterior
    if (currentPage > 1) {
        paginationHtml += '<li class="page-item"><a class="page-link" href="#" onclick="load_list(' + (currentPage - 1) + ')">&laquo;</a></li>';
    } else {
        paginationHtml += '<li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>';
    }
    
    // Números de página
    var startPage = Math.max(1, currentPage - 2);
    var endPage = Math.min(totalPages, currentPage + 2);
    
    for (var i = startPage; i <= endPage; i++) {
        if (i === currentPage) {
            paginationHtml += '<li class="page-item active"><a class="page-link" href="#">' + i + '</a></li>';
        } else {
            paginationHtml += '<li class="page-item"><a class="page-link" href="#" onclick="load_list(' + i + ')">' + i + '</a></li>';
        }
    }
    
    // Botón siguiente
    if (currentPage < totalPages) {
        paginationHtml += '<li class="page-item"><a class="page-link" href="#" onclick="load_list(' + (currentPage + 1) + ')">&raquo;</a></li>';
    } else {
        paginationHtml += '<li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>';
    }
    
    $('.pagination').html(paginationHtml);
}


function create_user() {

    var nombre      = $('#nombre');
    var apellido    = $('#apellido');
    var email       = $('#email');
    var foto        = $('#foto');
    var departamento = $('#select_departamento');
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
            sucursal: departamento.val(),
            rol: rol.val(),
            status: status.val(),
            pass1: pass1.val(),
            pass2: pass2.val(),
            firma: firma.val()
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                upload_user_photo(email.val());
                upload_user_firma(email.val());
                alert('Usuario creado correctamente.');
                nombre.val('');
                apellido.val('');
                email.val('');
                foto.val('');
                load_departamento_select();
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

function load_departamento_select() {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'cargar_select_departamento'
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                //alert('Estado actualizado correctamente.');
                $('#select_departamento').empty();
                $('#select_departamento').html(response.html);
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

