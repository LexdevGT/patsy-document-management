$(function(){

    setTimeout(sidebar,600);  
    cargar_estatus_documentos(); 
    load_proceso_principal();
    load_tipo_docto_select();
    cargar_select_usuarios();

    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $('#enviar').click(function(){
        crear_documento();
        Toast.fire({
            icon: 'success',
            title: 'Solicitud enviada!'
        });
        setTimeout(function() {
            location.reload();
          }, 12000);
    });

    $('#proceso').change(function(){
        load_subprocesos();
    });

    $('#subirArchivo').change(function(){
        var fileName = this.files[0].name;
        $('.custom-file-label').html(fileName);
        //console.log(fileName);
    });

    $('.select2').select2();

});


function new_function() {

    // Obtener el valor del parámetro 'id' de la URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    //console.log('ID: '+id);

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
                window.location.replace('revision.html');
            }
        }
    });
}


function crear_documento() {
    // Recopila los valores de los campos del formulario
    var status = $('#status').val();
    var proceso_principal = $('#proceso').val();
    var subproceso = $('#subproceso').val();
    var tipo_documento = 'NA';
    var nombre_documento = $('#nombre_docto').val();
    //var quien_solicita = $('#quien_solicita').val();
    var quien_revisa = $('#quien_revisa').val();
    var quien_aprueba = $('#quien_aprueba').val();
    var quien_visualiza = $('#quien_visualiza').val();
    var quien_imprime = $('#quien_imprime').val();
    var objetivo = $('#objetivo').val();
    var archivo = $('#subirArchivo')[0].files[0]; // Obtiene el primer archivo seleccionado

    //alert("Proceso: "+proceso_principal+" tipo documento: " + tipo_documento);
    if(proceso_principal != 0 && tipo_documento != 0){

        // Obtén la fecha y hora actual
        var fechaActual = new Date();

        // Obtiene el año, mes y día
        var año = fechaActual.getFullYear();
        var mes = ('0' + (fechaActual.getMonth() + 1)).slice(-2); // Agrega 1 al mes ya que los meses son indexados desde 0
        var dia = ('0' + fechaActual.getDate()).slice(-2);

        // Obtiene la hora, minutos y segundos
        var hora = ('0' + fechaActual.getHours()).slice(-2);
        var minuto = ('0' + fechaActual.getMinutes()).slice(-2);
        var segundo = ('0' + fechaActual.getSeconds()).slice(-2);

        var siglas_proceso_principal = proceso_principal.substring(0,2);
        var siglas_tipo_documento = tipo_documento;
        //console.log(siglas_tipo_documento);
        siglas_tipo_documento = siglas_tipo_documento.substring(0,2);
        var codigo = siglas_tipo_documento+'-'+siglas_proceso_principal+'-';
        //$('#codigo').val(codigo);

        // Creando el objeto FormData y agrego los datos del formulario
        var formData = new FormData();
        formData.append('option', 'crear_documento');
        formData.append('nombre', nombre_documento);
        formData.append('proceso_principal', proceso_principal);
        formData.append('subproceso', subproceso);
        //formData.append('tipo_documento', tipo_documento);
        formData.append('codigo', codigo);
        //formData.append('quien_elabora', quien_solicita);
        formData.append('quien_revisa', quien_revisa);
        //formData.append('quien_aprueba', quien_aprueba);
        formData.append('quien_aprueba', '');
        formData.append('quien_visualiza', quien_visualiza);
        formData.append('quien_imprime', quien_imprime);
        formData.append('alcance', objetivo);
        formData.append('solicitud',status);

        // Agrega el archivo al objeto FormData
        formData.append('archivo', archivo);
//console.log(formData);
//debugger;
        // Realiza una solicitud AJAX con el objeto FormData
        $.ajax({
            type: 'POST',
            url: '../assets/all/php/services.php', // Ruta del script PHP que procesará los datos
            data: formData,
            processData: false, // Evita que jQuery procese los datos automáticamente
            contentType: false, // Evita que jQuery establezca automáticamente el encabezado Content-Type
            dataType: 'json',
            success: function (response) {
                //console.log('RESPONSE: '+response)
                if (response.error === '') {
                    // Los datos se han guardado correctamente, puedes realizar acciones adicionales si es necesario
                    
                    alert('Documento solicitado exitosamente');
                    alert('El código de tu documento solicitado es el siguiente: '+response.codigo+' por si deseas apuntarlo!');
                    
                    location.reload();
                } else {
                    alert(response.error); // Muestra un mensaje de error si algo salió mal en el servidor
                }
            },
            error: function (xhr, status, error) {
                console.log('ERROR: '+error);
                alert('Error al enviar los datos al servidor: ' + error + ' STATUS: ' + status); // Maneja los errores de la solicitud AJAX
            }
        });

    }else{
        alert('Se debe elegir proceso principal y tipo de documento para poder crear el archivo!');
    }  
}

function cargar_select_usuarios() {

    // Obtener el valor del parámetro 'id' de la URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');

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
                $('.usuarios').empty();
                $('.usuarios').empty();
                var select_html = "<option value='0'>Selecciona un usuario...</option>";
                $.each(response.html, function(index, info) {
                    select_html += "<option value='"+info.id+"'>"+info.nombre+"</option>";
                });
                $('.usuarios').html(select_html);
            } else {
                alert(response.error);
                window.location.replace('revision.html');
            }
        }
    });
}


function load_tipo_docto_select() {

    // Obtener el valor del parámetro 'id' de la URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    //console.log('ID: '+id);

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_select_tipo_de_documentos'
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                $('#select_tipo_documento').empty();
                var select_html = "<option value='0'>Selecciona un tipo de documento...</option>";
                $.each(response.html, function(index, info) {
                    select_html += "<option value='"+info.id+"'>"+decodeURI(escape(info.nombre))+"</option>";
                });
                $('#select_tipo_documento').html(select_html);
            } else {
                alert(response.error);
                window.location.replace('revision.html');
            }
        }
    });
}

function load_subprocesos() {
    var principal = $('#proceso').val();

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_proceso_principal_select',
            directory: principal,
            principal: ''
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                $('#subproceso').empty();
                $('#subproceso').html(response.html);
            } else {
                alert(response.error);
            }
        }
    });
}

function load_proceso_principal() {
    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_proceso_principal_select',
            directory: '',
            principal: ''
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                $('#proceso').empty();
                $('#proceso').html(response.html);
            } else {
                alert(response.error);
            }
        }
    });
}

function cargar_estatus_documentos() {

    // Obtener el valor del parámetro 'id' de la URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    //console.log('ID: '+id);

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_estatus_documentos'
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                $('#status').empty();
                var select_html = "<option value='0'>Selecciona un estatus...</option>";
                $.each(response.list, function(index, info) {
                    select_html += "<option value='"+info.id+"'>"+decodeURI(escape(info.nombre))+"</option>";
                });
                $('#status').html(select_html);
            } else {
                alert(response.error);
                window.location.replace('revision.html');
            }
        }
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.fa-file-signature').parent().addClass( "active" );
}



