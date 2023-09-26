$(function(){

    load_sidebar();   
    load_footer(); 
  
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

function load_sidebar(){
    /*
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
                // No code 
            }else{
                alert(r.error);
                window.location.replace('../dashboard.html');
            }
        }    
    });
*/
    var sidebar ="<!-- Sidebar Menu -->"+
      "<nav class=\"mt-2\">"+
        "<ul class=\"nav nav-pills nav-sidebar flex-column\" data-widget=\"treeview\" role=\"menu\" data-accordion=\"false\">"+
          "<!-- Add icons to the links using the .nav-icon class"+
               "with font-awesome or any other icon font library -->"+
          "<li class=\"nav-item\">"+
            "<a href=\"dashboard.html\" class=\"nav-link active\">"+
              "<i class=\"nav-icon fas fa-tachometer-alt\"></i>"+
              "<p>"+
                "Inicio"+
              "</p>"+
            "</a>"+
          "</li>"+
          "<li class=\"nav-item\">"+
            "<a href=\"crear_documento.html\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-pen-nib\"></i>"+
              "<p>"+
                "Crear documento"+
              "</p>"+
            "</a>"+
          "</li>"+
          "<li class=\"nav-item\">"+
            "<a href=\"revision.html\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-glasses\"></i>"+
              "<p>"+
                "Revisión"+
              "</p>"+
            "</a>"+
          "</li>"+
          "<!--<li class=\"nav-item\">"+
            "<a href=\"pages/widgets.html\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-th\"></i>"+
              "<p>"+
                "Aprobación / Rechazo"+
              "</p>"+
            "</a>"+
          "</li>-->"+
          "<li class=\"nav-item\">"+
            "<a href=\"solicitud_documento.html\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-file\"></i>"+
              "<p>"+
                "Solicitud de documento"+
              "</p>"+
            "</a>"+
          "</li>"+
          "<li class=\"nav-item\">"+
            "<a href=\"solicitud_documento_d_i.html\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-folder-open\"></i>"+
              "<p>"+
                "Solicitud de documento digital o impreso"+
              "</p>"+
            "</a>"+
          "</li>"+
          "<li class=\"nav-item\">"+
            "<a href=\"solicitud_documento_eliminacion.html\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-trash\"></i>"+
              "<p>"+
                "Eliminar documento"+
              "</p>"+
            "</a>"+
          "</li>"+
          "<li class=\"nav-item\">"+
            "<a href=\"solicitud_documento_externo.html\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-folder-plus\"></i>"+
              "<p>"+
                "Documentos externos"+
              "</p>"+
            "</a>"+
          "</li>"+
          "<li class=\"nav-item\">"+
            "<a href=\"pages/widgets.html\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-th\"></i>"+
              "<p>"+
                "Control de cambio"+
              "</p>"+
            "</a>"+
          "</li>"+
          "<li class=\"nav-item\">"+
            "<a href=\"obsoleto.html\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-folder\"></i>"+
              "<p>"+
                "Obsoleto"+
              "</p>"+
            "</a>"+
          "</li>"+
          "<li class=\"nav-item\">"+
            "<a href=\"buscar.html\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-search\"></i>"+
              "<p>"+
                "Buscar"+
              "</p>"+
            "</a>"+
          "</li>"+
          "<!-- Eliminado ya que buscar hace lo mismo <li class=\"nav-item\">"+
            "<a href=\"pages/widgets.html\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-th\"></i>"+
              "<p>"+
                "Mapa de procesos"+
              "</p>"+
            "</a>"+
          "</li>-->"+
          "<li class=\"nav-item\">"+
            "<a href=\"pages/widgets.html\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-th\"></i>"+
              "<p>"+
                "Reportería"+
              "</p>"+
            "</a>"+
          "</li>"+

          "<li class=\"nav-item\">"+
            "<a href=\"#\" class=\"nav-link\">"+
              "<i class=\"nav-icon fas fa-copy\"></i>"+
              "<p>"+
                "Mantenimiento"+
                "<i class=\"fas fa-angle-left right\"></i>"+
                "<span class=\"badge badge-info right\">7</span>"+
              "</p>"+
            "</a>"+
            "<ul class=\"nav nav-treeview\">"+
              "<li class=\"nav-item\">"+
                "<a href=\"manto_mapaprocesos.html\" class=\"nav-link\">"+
                  "<i class=\"far fa-circle nav-icon manto_mapa\"></i>"+
                  "<p>Mapa de procesos</p>"+
                "</a>"+
              "</li>"+
              "<li class=\"nav-item\">"+
                "<a href=\"manto_tipodocumento.html\" class=\"nav-link\">"+
                  "<i class=\"far fa-circle nav-icon manto_tipodocumento\"></i>"+
                  "<p>Tipo de documentos</p>"+
                "</a>"+
              "</li>"+
              "<li class=\"nav-item\">"+
                "<a href=\"manto_sucursal.html\" class=\"nav-link\">"+
                  "<i class=\"far fa-circle nav-icon manto_sucursal\"></i>"+
                  "<p>Sucursal</p>"+
                "</a>"+
              "</li>"+
              "<li class=\"nav-item\">"+
                "<a href=\"manto_region.html\" class=\"nav-link\">"+
                  "<i class=\"far fa-circle nav-icon manto_region\"></i>"+
                  "<p>Región</p>"+
                "</a>"+
              "</li>"+
              "<!--<li class=\"nav-item\">"+
                "<a href=\"manto_empresas.html\" class=\"nav-link\">"+
                  "<i class=\"far fa-circle nav-icon manto_empresas\"></i>"+
                  "<p>Emperesas</p>"+
                "</a>"+
              "</li>-->"+
              "<li class=\"nav-item\">"+
                "<a href=\"manto_roles.html\" class=\"nav-link\">"+
                  "<i class=\"far fa-circle nav-icon manto_roles\"></i>"+
                  "<p>Roles</p>"+
                "</a>"+
              "</li>"+
              "<li class=\"nav-item\">"+
                "<a href=\"manto_usuarios.html\" class=\"nav-link\">"+
                  "<i class=\"far fa-circle nav-icon manto_usuarios\"></i>"+
                  "<p>Usuarios</p>"+
                "</a>"+
              "</li>"+
              "<li class=\"nav-item\">"+
                "<a href=\"manto_privilegios.html\" class=\"nav-link\">"+
                  "<i class=\"far fa-circle nav-icon manto_privilegios\"></i>"+
                  "<p>Privilegios</p>"+
                "</a>"+
              "</li>"+
            "</ul>"+
          "</li>"+
        "</ul>"+
      "</nav>"+
      "<!-- /.sidebar-menu -->";

      $('#left-bar').html(sidebar);
}



function load_footer(){
    var footer = "<strong>Copyright &copy; 2023 <a href=\"https://www.patsy.com.gt/\">PATSY</a>.</strong>"+
    "Todos los derechos reservados."+
    "<div class=\"float-right d-none d-sm-inline-block\">"+
      "<b>Version</b> 1.0"+
    "</div>"

    $('.main-footer').html(footer);
}