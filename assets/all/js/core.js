$(function(){

    load_sidebar();   
    load_footer(); 
  
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
                window.location.replace('../dashboard.html');
            }
        }    
    });
}

function load_user_name(nombre){
    $('.user-name').html('<b>'+nombre+'</b>');
}

function load_sidebar(){
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'cargar_barra_izquierda' // Nueva opción para cargar los privilegios
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                var sidebar = buildSidebar(response.data); // Llama a una función para construir el menú
                //var h = '<!-- Sidebar Menu --><nav class="mt-2"><ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"><li class="nav-item"><a href="crear_documento.html" class="nav-link"><i class="nav-icon nav-icon fas fa-pen-nib"></i><p>Crear documento</p></a></li><li class="nav-item"><a href="revision.html" class="nav-link"><i class="nav-icon nav-icon fas fa-glasses"></i><p>Revision</p></a></li><li class="nav-item"><a href="solicitud_documento.html" class="nav-link"><i class="nav-icon null"></i><p>Solicitud de documento</p></a></li><li class="nav-item"><a href="solicitud_documento_d_i.html" class="nav-link"><i class="nav-icon null"></i><p>Solicitud de documento digital o impreso</p></a></li><li class="nav-item"><a href="solicitud_documento_eliminacion.html" class="nav-link"><i class="nav-icon null"></i><p>Eliminar documento</p></a></li><li class="nav-item"><a href="solicitud_documento_externo.html" class="nav-link"><i class="nav-icon null"></i><p>Documentos externos</p></a></li><li class="nav-item"><a href=" " class="nav-link"><i class="nav-icon null"></i><p>Control de cambio</p></a></li><li class="nav-item"><a href="obsoleto.html" class="nav-link"><i class="nav-icon null"></i><p>Obsoleto</p></a></li><li class="nav-item"><a href="buscar.html" class="nav-link"><i class="nav-icon null"></i><p>Buscar</p></a></li><li class="nav-item"><a href=" " class="nav-link"><i class="nav-icon null"></i><p>Reportería</p></a></li><li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-copy"></i><p>Mantenimiento<i class="fas fa-angle-left right"></i><span class="badge badge-info right">7</span></p></a><ul class="nav nav-treeview"><li class="nav-item"><a href="manto_mapaprocesos.html" class="nav-link"><i class="nav-icon null"></i><p>Mapa de procesos</p></a></li><li class="nav-item"><a href="manto_tipodocumento.html" class="nav-link"><i class="nav-icon null"></i><p>Tipo de documentos</p></a></li><li class="nav-item"><a href="manto_sucursal.html" class="nav-link"><i class="nav-icon null"></i><p>Sucursal</p></a></li><li class="nav-item"><a href="manto_region.html" class="nav-link"><i class="nav-icon null"></i><p>Región</p></a></li><li class="nav-item"><a href="manto_empresas.html" class="nav-link"><i class="nav-icon null"></i><p>Empresas</p></a></li><li class="nav-item"><a href="manto_roles.html" class="nav-link"><i class="nav-icon null"></i><p>Roles</p></a></li><li class="nav-item"><a href="manto_usuarios.html" class="nav-link"><i class="nav-icon null"></i><p>Usuarios</p></a></li><li class="nav-item"><a href="manto_privilegios.html" class="nav-link"><i class="nav-icon null"></i><p>Privilegios</p></a></li></ul></li></ul></nav>'
                $('#left-bar').html(sidebar);
                $('.nav-item.has-treeview a.nav-link').on('click', function () {
                    // Muestra u oculta el submenú al hacer clic en el enlace
                    $(this).parent('.nav-item').toggleClass('menu-open');
                });
                load_user_name(response.un);
            } else {
                alert('Error al cargar los privilegios: ' + response.error);
            }
        }
    });
}

function buildSidebar(data) {
    var flagManto = false;
    var sidebarHTML = "<!-- Sidebar Menu -->"+
      "<nav class=\"mt-2\">"+
        "<ul class=\"nav nav-pills nav-sidebar flex-column\" data-widget=\"treeview\" role=\"menu\" data-accordion=\"false\">";

    var sidebarHTMLmantenimiento = "<li class=\"nav-item has-treeview\">"+
            "<a href=\"#\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-copy\"></i>"+
              "<p>"+
                "Mantenimiento"+
                "<i class=\"fas fa-angle-left right\"></i>"+
                "<span class=\"badge badge-info right\">7</span>"+
              "</p>"+
            "</a>"+
            "<ul class=\"nav nav-treeview\">";

    data.forEach(function(privilege) {
        // Comprueba si la ruta contiene "manto" para agregar al submenú de Mantenimiento
        if (privilege.path.includes('manto')) {
            
            sidebarHTMLmantenimiento += "<li class=\"nav-item\">";
            sidebarHTMLmantenimiento += buildMenuItem(privilege);   
            sidebarHTMLmantenimiento += "</li>";
            flagManto = true;
        } else {
            sidebarHTML += "<li class=\"nav-item\">";
            sidebarHTML += buildMenuItem(privilege);
            sidebarHTML += "</li>";
        }
    });

    sidebarHTMLmantenimiento += "</ul></li>";

    if(flagManto){
      sidebarHTML += sidebarHTMLmantenimiento + "</ul></nav>";  
    }else{
      sidebarHTML += "</ul></nav>";
    }
    
    return sidebarHTML;
}

function buildMenuItem(privilege) {
    
    return "<a href=\"" + privilege.path + "\" class=\"nav-link\">" +
        "<i class=\"nav-icon " + privilege.icon + "\"></i>" +
        "<p>" + decodeURI(escape(privilege.nombre_opcion_privilegio)) + "</p>" +
        "</a>";
}

function load_footer(){
    var footer = "<strong>Copyright &copy; 2023 <a href=\"https://www.patsy.com.gt/\">PATSY</a>.</strong>"+
    "Todos los derechos reservados."+
    "<div class=\"float-right d-none d-sm-inline-block\">"+
      "<b>Version</b> 1.0"+
    "</div>"

    $('.main-footer').html(footer);
}