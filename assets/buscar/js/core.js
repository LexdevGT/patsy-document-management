$(function(){
    sidebar();   
    load_explorer();

    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $('#enviar').click(function(){
       Toast.fire({
        icon: 'success',
        title: 'Solicitud enviada!'
      });
        setTimeout(function() {
            location.reload();
          }, 2000);
    });



    $('#rechazado').click(function(){
        $('#modal-rechazo').modal('show');
    });

    $('#explorer_search').keyup(function(){
        var busqueda = $('#explorer_search').val();
        //alert('cambio: '+busqueda);
        interactive_search(busqueda);
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

function interactive_search(b){

    if(b==''){
        window.location.replace('explorador.html');
    }

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/buscar/php/services.php",
        data: ({
            option: 'interactive_search',
            b            
        }),
        dataType: "json",        
        success: function(r) {                                                   
            if(r.error == ''){
                //alert('llego');

                $('#data_explorer').html(r.html_eplorer);

            }else{
                alert(r.error);
                window.location.replace('../dashboard.html');
            }
        }    
    });
}

function load_explorer(directory='',flag=0){

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/buscar/php/services.php",
        data: ({
            option: 'load_explorer',
            directory,
            flag
        }),
        dataType: "json",        
        success: function(r) {                                                   
            if(r.error == ''){
                //alert(r.message);
                $('#data_explorer').html(r.html);
            }else{
                alert(r.error);
                window.location.replace('dashboard.html');
            }
        }    
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.fa-search').parent().addClass( "active" );
}

