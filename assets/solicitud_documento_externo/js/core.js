$(function(){
/*
    load_user_picture();
    load_sidebar();
    load_headbar();
*/

/*
    $('#enviar-email').click(function(){
        alert('click');
    });    

   
    $('.add_field').click(function(){
        var field = $(this).parent().parent().clone(true);
        //console.log(field); alert('j');
        field.find('input:text').val(''); 
        //console.log(field);
        field.appendTo('.new_fields');

    });

    $('.delete_field').click(function(){
        $(this).parent().parent().remove();
    });
*/
    sidebar();   

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

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.fa-folder-plus').parent().addClass( "active" );
}

