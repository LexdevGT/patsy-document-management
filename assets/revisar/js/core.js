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

    $('#summernote').summernote();
    var new_btn = '<div class="note-btn-group btn-group note-view"><button type="button" class="note-btn btn btn-light btn-sm btn-fullscreen note-codeview-keep" tabindex="-1" title="" aria-label="Print" data-original-title="print"><i class="fa fa-print"></i></button><button type="button" class="note-btn btn btn-light btn-sm btn-codeview note-codeview-keep" tabindex="-1" title="" aria-label="download" data-original-title="download"><i class="fa fa-cloud-download-alt"></i></button></div>'
    $('.note-toolbar').append(new_btn);

    $('#revisado').click(function(){
        window.location.replace('revision.html');
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
    $('.nav-link').find('i.fa-glasses').parent().addClass( "active" );
}

