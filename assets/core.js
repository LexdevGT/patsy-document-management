$(function(){

    $('#ingresar').click(function(){
        ingresar();
    });

    $('#btn-close-login').click(function(){
        window.location.href = "pages/dashboard.html"
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

function ingresar(){
console.log('Iniciando llamada ajax');
    var email   = $('#email');
    var contra  = $('#contra');
    
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "assets/all/php/services.php",
        data: ({
            option: 'login',
            email:  email.val(),
            contra: contra.val()
        }),
        dataType: "json",        
        success: function(r) {                                                   
            if(r.error == ''){
                var html = '';
                $.each(r.data, function (index, usuario) {
                    html += '<p>Bienvenido ' + usuario.nombre + ' ' + usuario.apellido + '</p>';
                });

                $('.modal-body').html(html)
                $('#modal-login').modal('show');
            }else{
                alert(r.error);
            }
        }    
    });
    
}

