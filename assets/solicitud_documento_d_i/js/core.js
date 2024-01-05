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

