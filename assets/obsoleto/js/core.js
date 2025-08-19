// Variable global para almacenar el historial de navegación
var navigationHistory = [];

$(function(){

    setTimeout(sidebar,600);

    // Manejar clic en el botón de regreso
    $('#btnBack').on('click', function () {
        navigateBack();
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


function load_explorer() {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'cargar_procesos_obsoletos',
            origen: 'obsoletos'
        }),
        dataType: "json",
        success: function (r) {
            if (r.error == '') {
                // Construir tarjetas
                
                var contenidoHTML = '<div class="row">';


                $.each(r.html, function (index, elemento) {
                    contenidoHTML += '<div class="col-md-4 mb-4">';
                    contenidoHTML += '<div class="card h-100">';
                    contenidoHTML += '<div class="card-body d-flex flex-column justify-content-between">';

                    // Si es una carpeta, mostrar icono de carpeta y agregar clic para navegar
                    if (elemento.type === 'folder') {
                        contenidoHTML += '<i class="fas fa-folder fa-3x mb-2" style="max-width: 25px; max-height: 25px;"></i>';
                        contenidoHTML += '<h5 class="card-title folder-name clickable" data-path="' + elemento.name + '">' + elemento.name + '</h5>';
                    } else {
                        // Si es un archivo, mostrar imagen previa y agregar clic para descargar
                        contenidoHTML += '<img src="' + elemento.preview + '" alt="' + elemento.name + '" class="img-fluid mb-2" style="max-width: 25px; max-height: 25px;">';
                        contenidoHTML += '<h5 class="card-title file-name clickable" data-path="' + elemento.downloadLink + '">' + elemento.name + '</h5>';
                    }

                    contenidoHTML += '</div>';
                    contenidoHTML += '</div>';
                    contenidoHTML += '</div>';

                    // Cerrar la fila y abrir una nueva cada tres tarjetas
                    if ((index + 1) % 3 === 0) {
                        contenidoHTML += '</div><div class="row">';
                    }
                });

                contenidoHTML += '</div>';

                // Agregar el contenido al elemento con id "data_explorer"
                $('#data_explorer').html(contenidoHTML);

                // Agregar eventos de clic
                $('.clickable').on('click', function () {
                    var path = $(this).data('path');
                    var isFolder = $(this).hasClass('folder-name');

                    if (isFolder) {
                        // Navegar a la carpeta (ajusta el código según tus necesidades)
                        navigateToFolder(path);
                    } else {
                        // Descargar el archivo (ajusta el código según tus necesidades)
                        downloadFile(path);
                    }
                });
            } else {
                alert(r.error);
                window.location.replace('dashboard.html');
            }
        }
    });
}

// Función para cargar el contenido de una carpeta
function loadFolderContent(folderName) {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'load_folders_obsoletos',  // Opción para cargar el contenido de una carpeta
            folderName: folderName,  // Carpeta específica a cargar
            origen: 'obsoletos'
        },
        dataType: "json",
        success: function (r) {
            if (r.error === '') {
                // Construir y mostrar las tarjetas del contenido de la carpeta
                var contenidoHTML = '<div class="row">';
                
                $.each(r.html, function (index, elemento) {
                    contenidoHTML += '<div class="col-md-4 mb-4">';
                    contenidoHTML += '<div class="card h-100">';
                    contenidoHTML += '<div class="card-body d-flex flex-column justify-content-between">';

                    if (elemento.type === 'folder') {
                        contenidoHTML += '<i class="fas fa-folder fa-3x mb-2" style="max-width: 25px; max-height: 25px;"></i>';
                        contenidoHTML += '<h5 class="card-title folder-name clickable" data-path="' + elemento.name + '">' + elemento.name + '</h5>';
                    } else {
                        contenidoHTML += '<img src="' + elemento.preview + '" alt="' + elemento.name + '" class="img-fluid mb-2" style="max-width: 25px; max-height: 25px;">';
                        contenidoHTML += '<h5 class="card-title file-name clickable" data-path="' + elemento.downloadLink + '">' + elemento.name + '</h5>';
                    }

                    contenidoHTML += '</div>';
                    contenidoHTML += '</div>';
                    contenidoHTML += '</div>';

                    if ((index + 1) % 3 === 0) {
                        contenidoHTML += '</div><div class="row">';
                    }
                });

                contenidoHTML += '</div>';

                $('#data_explorer').html(contenidoHTML);

                // Agregar eventos de clic
                $('.clickable').on('click', function () {
                    var path = $(this).data('path');
                    var isFolder = $(this).hasClass('folder-name');

                    if (isFolder) {
                        navigateToFolder(path);
                    } else {
                        // Descargar el archivo (ajusta el código según tus necesidades)
                        downloadFile(path);
                    }
                });

            } else {
                alert(r.error);
                window.location.replace('dashboard.html');
            }
        }
    });
}

// Función para navegar hacia atrás en el historial
function navigateBack() {
    var p = '';
    // Verificar si hay elementos en el historial
    if (navigationHistory.length > 1) {
        // Obtener la carpeta anterior
        var previousFolder = navigationHistory.pop();
        //console.log('Previous: '+previousFolder);
         // Construyo la cadena path en base al navigationHistory recorriendolo
        $.each(navigationHistory, function(index,value){
            p += value + '/';
        });
        // Actualizar el contenido del explorador
        //loadFolderContent(previousFolder);
        loadFolderContent(p);
    } else {
        // No hay elementos en el historial, ocultar el botón de regreso
        //console.log('Previous: '+navigationHistory);
        navigationHistory.pop();
        //console.log('Present: '+navigationHistory);
        loadFolderContent('start');
        $('#btnBack').hide();
    }
}

// Función para navegar hacia una carpeta
function navigateToFolder(folderName) {
    var p = '';
    // Agregar la carpeta actual al historial
    navigationHistory.push(folderName);
    //console.log(navigationHistory);
    // Construyo la cadena path en base al navigationHistory recorriendolo
    $.each(navigationHistory, function(index,value){
        p += value + '/';
    });
    //console.log('VALUE: '+p);
    // Actualizar el contenido del explorador
    loadFolderContent(p);
    // Mostrar el botón de regreso
    $('#btnBack').show();
}

// Función para descargar el archivo
function downloadFile(fileName) {
    // Ajusta la ruta del servicio PHP que manejará la descarga
    var downloadUrl = '../assets/all/php/download.php';

    // Crear un formulario dinámico para realizar la descarga
    var form = $('<form>', {
        'action': downloadUrl,
        'method': 'POST',
        'target': '_blank' // Abre la descarga en una nueva ventana/tapa
    });

    // Agregar un campo oculto al formulario con el nombre del archivo
    form.append($('<input>', {
        'type': 'hidden',
        'name': 'fileName',
        'value': fileName
    }));

    // Agregar un campo oculto al formulario con el nombre del folder
    form.append($('<input>', {
        'type': 'hidden',
        'name': 'folderName',
        'value': 'obsoletos'
    }));

    // Adjuntar el formulario al cuerpo del documento y enviarlo
    form.appendTo('body').submit().remove();
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.fa-folder').parent().addClass( "active" );
    load_explorer();
}

