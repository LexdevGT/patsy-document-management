$(function(){

    setTimeout(sidebar,600);
    //sidebar();   
    load_proceso_principal();
    load_tipo_de_documento();
    load_quien_elabora();
    load_quien_revisa();
    load_quien_aprueba();
    load_quien_visualiza();
    load_quien_imprime();

    $('#crear').click(function(){
        crear_documento();
    });
    

    //Initialize Select2 Elements
    $('.select2').select2();

    $('#salir').click(function(){
        window.location.replace('dashboard.html');
    });

    $('#select_proceso_principal').change(function(){
        load_otros_procesos();
        load_subprocesos();
    });

    $('#subirArchivo').change(function(){
        var fileName = this.files[0].name;
        $('.custom-file-label').html(fileName);
        //console.log(fileName);
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

function crear_documento() {
    // Recopila los valores de los campos del formulario
    var nombre = $('#nombre').val();
    var proceso_principal = $('#select_proceso_principal').val();
    var otros_procesos = $('#select_otros_procesos').val();
    var subproceso = $('#select_subproceso').val();
    var tipo_documento = $('#select_tipo_de_documento').val();
    var version = $('#version').val();
    //var codigo = $('#codigo').val();
    var alcance = $('#alcance').val();
    var quien_elabora = $('#select_quien_elabora').val();
    var quien_revisa = $('#select_quien_revisa').val();
    var quien_aprueba = $('#select_quien_aprueba').val();
    var archivo = $('#subirArchivo')[0].files[0]; // Obtiene el primer archivo seleccionado
    var quien_visualiza = $('#select_quien_visualiza').val();
    var quien_imprime = $('#select_quien_imprime').val();



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

        // Crea el string con el formato deseado
        var formatoFechaHora = mes + '-' + dia + '-' + año + '_' + hora + '-' + minuto + '-' + segundo;
        //console.log(formatoFechaHora);
        var siglas_proceso_principal = proceso_principal.substring(0,2);
        var siglas_tipo_documento = $('#select_tipo_de_documento').find("option:selected").text();
        //console.log(siglas_tipo_documento);
        siglas_tipo_documento = siglas_tipo_documento.substring(0,2);


        //var codigo = siglas_proceso_principal+'-'+tipo_documento+'-'+formatoFechaHora;
        var codigo = siglas_proceso_principal+'-'+siglas_tipo_documento+'-';
        

        // Creando el objeto FormData y agrego los datos del formulario
        var formData = new FormData();
        formData.append('option', 'crear_documento');
        formData.append('nombre', nombre);
        formData.append('proceso_principal', proceso_principal);
        formData.append('otros_procesos', otros_procesos);
        formData.append('subproceso', subproceso);
        formData.append('tipo_documento', tipo_documento);
        formData.append('version', version);
        formData.append('codigo', codigo);
        formData.append('alcance', alcance);
        formData.append('quien_elabora', quien_elabora);
        formData.append('quien_revisa', quien_revisa);
        formData.append('quien_aprueba', quien_aprueba);
        formData.append('quien_visualiza', quien_visualiza);
        formData.append('quien_imprime', quien_imprime);

        // Agrega el archivo al objeto FormData
        formData.append('archivo', archivo);

        // Realiza una solicitud AJAX con el objeto FormData
        $.ajax({
            type: 'POST',
            url: '../assets/all/php/services.php', 
            data: formData,
            processData: false, // Evita que jQuery procese los datos automáticamente
            contentType: false, // Evita que jQuery establezca automáticamente el encabezado Content-Type
            dataType: 'json',
            success: function (response) {
                if (response.error === '') {
                    // Los datos se han guardado correctamente, puedes realizar acciones adicionales si es necesario
                    $('#codigo').val(response.codigo);
                    alert('Documento creado exitosamente');
                    alert('El código de tu documento creado es el siguiente: '+response.codigo+' por si deseas apuntarlo!');
                    // Vuelve a cargar la página
                    location.reload();
                } else {
                    alert(response.error); // Muestra un mensaje de error si algo salió mal en el servidor
                }
            },
            error: function (xhr, status, error) {
                alert('Error al enviar los datos al servidor: ' + error); // Maneja los errores de la solicitud AJAX
            }
        });

    }else{
        alert('Se debe elegir proceso principal y tipo de documento para poder crear el archivo!');
    }

}


function load_quien_imprime() {
    var select_html = "<option value='0'>Selecciona un usuario...</option>";

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
                $('#select_quien_imprime').empty();
                $.each(response.html, function(index, info) {
                    select_html += "<option value='"+info.id+"'>"+decodeURI(escape(info.nombre))+"</option>";
                });
                $('#select_quien_imprime').html(select_html);
            } else {
                alert(response.error);
            }
        }
    });
}

function load_quien_visualiza() {
    var select_html = "<option value='0'>Selecciona un usuario...</option>";

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
                $('#select_quien_visualiza').empty();
                $.each(response.html, function(index, info) {
                    select_html += "<option value='"+info.id+"'>"+decodeURI(escape(info.nombre))+"</option>";
                });
                $('#select_quien_visualiza').html(select_html);
            } else {
                alert(response.error);
            }
        }
    });
}

function load_quien_aprueba() {
    var select_html = "<option value='0'>Selecciona un usuario...</option>";

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
                $('#select_quien_aprueba').empty();
                $.each(response.html, function(index, info) {
                    select_html += "<option value='"+info.id+"'>"+decodeURI(escape(info.nombre))+"</option>";
                });
                $('#select_quien_aprueba').html(select_html);
            } else {
                alert(response.error);
            }
        }
    });
}

function load_quien_revisa() {
    var select_html = "<option value='0'>Selecciona un usuario...</option>";

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
                $('#select_quien_revisa').empty();
                $.each(response.html, function(index, info) {
                    select_html += "<option value='"+info.id+"'>"+decodeURI(escape(info.nombre))+"</option>";
                });
                $('#select_quien_revisa').html(select_html);
            } else {
                alert(response.error);
            }
        }
    });
}

function load_quien_elabora() {
    var select_html = "<option value='0'>Selecciona un usuario...</option>";

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
                $('#select_quien_elabora').empty();
                //$('#select_quien_elabora').html(response.html);
                $.each(response.html, function(index, info) {
                    select_html += "<option value='"+info.id+"'>"+decodeURI(escape(info.nombre))+"</option>";
                });
                $('#select_quien_elabora').html(select_html);
            } else {
                alert(response.error);
            }
        }
    });
}

function load_tipo_de_documento() {
    var select_html = "<option value='0'>Selecciona un tipo de documento...</option>";

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
                $('#select_tipo_de_documento').empty();
                $.each(response.html, function(index, info) {
                    select_html += "<option value='"+info.id+"'>"+info.siglas+'-'+decodeURI(escape(info.nombre))+"</option>";
                });
                $('#select_tipo_de_documento').html(select_html);
            } else {
                alert(response.error);
            }
        }
    });
}

function load_subprocesos() {
    var principal = $('#select_proceso_principal').val();

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
                $('#select_subproceso').empty();
                $('#select_subproceso').html(response.html);
            } else {
                alert(response.error);
            }
        }
    });
}

function load_otros_procesos() {
    var principal = $('#select_proceso_principal').val();

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_proceso_principal_select',
            directory: '',
            principal
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                $('#select_otros_procesos').empty();
                $('#select_otros_procesos').html(response.html);
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
                $('#select_proceso_principal').empty();
                $('#select_proceso_principal').html(response.html);
            } else {
                alert(response.error);
            }
        }
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.fa-pen-nib').parent().addClass( "active" );
}

