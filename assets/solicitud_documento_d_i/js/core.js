$(function(){

    setTimeout(sidebar,600);  
    cargar_select_usuarios();

    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $('#enviar').click(function(){
        ingresar_permiso();
       /*
       Toast.fire({
        icon: 'success',
        title: 'Solicitud enviada!'
      });
        setTimeout(function() {
            location.reload();
          }, 2000);*/
    });

    $('#codigo').change(function(){
        load_document_name();  
    });

    // Autocompletado para el input de documento
    $('#documento').on('input', function(){
        var keyword = $(this).val();
        if(keyword.length >= 2) {
            buscarDocumentos(keyword);
        } else {
            $('#documento-suggestions').hide();
        }
    });

    // Ocultar sugerencias cuando se hace clic fuera
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.autocomplete-container').length) {
            $('#documento-suggestions').hide();
        }
    });

    // Manejar clic en sugerencias
    $(document).on('click', '.suggestion-item', function() {
        var nombre = $(this).data('nombre');
        var codigo = $(this).data('codigo');
        $('#documento').val(nombre);
        $('#codigo').val(codigo);
        $('#documento-suggestions').hide();
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
                window.location.replace('solicitud_documento_d_i.html');
            }
        }    
    });
}

function cambio_status_documento(codigo,status){
    var c = codigo;
    var s = status;
    
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'cambiar_estatus_documento',
            codigo: c,
            status: s              
        }),
        dataType: "json",        
        success: function(r) {                                                   
            if(r.error == ''){
                window.location.replace('solicitud_documento_d_i.html');
            }else{
                alert(r.error);
                window.location.replace('solicitud_documento_d_i.html');
            }
        }    
    });
}

function ingresar_permiso(){
    var codigo = $('#codigo').val();
    var nombre = $('#documento').val();
    var solicitante = $('#solicitante').val();
    var aprobacion = $('#aprobacion').val();
    var solicitud = $('#solicitud').val();

    if(solicitud == 'Digital'){
        var observacion = 'Ingreso de solicitud para permiso documento Digital de ' + nombre;
        var status = 7;
    }else{
        var observacion = 'Ingreso de solicitud para permiso documento Impreso de ' + nombre;
        var status = 8;
    }
    
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'history',
            codigo,
            observacion,
            nombre,
            solicitante,
            aprobacion,
            solicitud,
            status
        }),
        dataType: "json",        
        success: function(r) {                                                   
            if(r.error == ''){
                alert(r.message);
                cambio_status_documento(codigo,status);
                //window.location.replace('solicitud_documento_d_i.html');
            }else{
                alert(r.error);
                //window.location.replace('solicitud_documento_d_i.html');
            }
        }    
    });
}

function load_document_name(){
    var nombre = '';
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'cargar_document_name',
            codigo: $('#codigo').val()                  
        }),
        dataType: "json",        
        success: function(r) {                                                   
            if(r.error == ''){
                $.each(r.data, function(index,value){
                    nombre = value.nombre;
                });
                //alert(nombre);
                $('#documento').empty();
                $('#documento').val(nombre);
            }else{
                alert(r.error);
                window.location.replace('solicitud_documento_d_i.html');
            }
        }    
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.fa-book').parent().addClass( "active" );
}

function cargar_select_usuarios() {

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
                var select_html = "<option value='0'>Selecciona un usuario...</option>";
                $.each(response.html, function(index, info) {
                    select_html += "<option value='"+info.id+"'>"+info.nombre+"</option>";
                });
                $('.usuarios').html(select_html);
            } else {
                alert(response.error);
                window.location.replace('solicitud_documento_d_i.html');
            }
        }
    });
}

function buscarDocumentos(keyword) {
    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'buscar_documentos_por_keyword',
            keyword: keyword
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                var suggestions = $('#documento-suggestions');
                suggestions.empty();
                
                if (response.data && response.data.length > 0) {
                    $.each(response.data, function(index, doc) {
                        var item = $('<div class="suggestion-item" style="padding: 8px; cursor: pointer; border-bottom: 1px solid #eee;">')
                            .data('nombre', doc.nombre)
                            .data('codigo', doc.codigo)
                            .html('<strong>' + doc.nombre + '</strong><br><small>Código: ' + doc.codigo + '</small>');
                        
                        item.hover(
                            function() { $(this).css('background-color', '#f8f9fa'); },
                            function() { $(this).css('background-color', 'white'); }
                        );
                        
                        suggestions.append(item);
                    });
                    suggestions.show();
                } else {
                    suggestions.append('<div style="padding: 8px; color: #6c757d;">No se encontraron documentos</div>');
                    suggestions.show();
                }
            } else {
                console.error('Error al buscar documentos:', response.error);
            }
        },
        error: function() {
            console.error('Error en la petición AJAX');
        }
    });
}

