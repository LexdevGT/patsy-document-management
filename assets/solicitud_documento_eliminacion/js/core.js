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
    });

     $('#codigo').change(function(){
        load_document_name();  
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

function cambio_status_documento(codigo,status){
    var c = codigo;
    var s = status;
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

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
                //window.location.replace('solicitud_documento_eliminacion.html');
                Toast.fire({
                    icon: 'success',
                    title: 'Solicitud enviada!'
                  });
                    setTimeout(function() {
                        location.reload();
                      }, 2000);
            }else{
                alert(r.error);
                window.location.replace('solicitud_documento_eliminacion.html');
            }
        }    
    });
}

function ingresar_permiso(){
    var codigo = $('#codigo').val();
    var nombre = $('#nombre').val();
    var solicitante = $('#quien_solicita').val();
    var aprobacion = $('#quien_aprueba').val();
    var motivo = $('#motivo').val();

    
    var observacion = 'Ingreso de solicitud para eliminar el documento ' + nombre + 'Las observaciones son las siguientes: ' + motivo;
    var status = 4;
    
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
            solicitud: 4,
            status
        }),
        dataType: "json",        
        success: function(r) {                                                   
            if(r.error == ''){
                //alert(r.message);
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
                $('#nombre').empty();
                $('#nombre').val(nombre);
            }else{
                alert(r.error);
                window.location.replace('solicitud_documento_d_i.html');
            }
        }    
    });
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
                    select_html += "<option value='"+info.id+"'>"+decodeURI(escape(info.nombre))+"</option>";
                });
                $('.usuarios').html(select_html);
            } else {
                alert(response.error);
                window.location.replace('solicitud_documento_d_i.html');
            }
        }
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.fa-trash').parent().addClass( "active" );
}

