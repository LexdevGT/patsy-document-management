$(function() {
    sidebar();
    carga_inicial();

    $('#salir').click(function() {
        window.location.replace('dashboard.html');
    });

    var folderStack = []; // Pila para almacenar las rutas de carpetas

   $('#btnBack').click(function() {
        //console.log('Regresar');
        if (folderStack.length > 0) {
            //console.log(folderStack);
            folderStack.pop(); // Eliminar la carpeta actual de la pila
            var previousFolder = folderStack[folderStack.length - 1]; // Obtener la carpeta anterior
            loadFolders(previousFolder);
        }else{
            //console.log('Length: '+folderStack.length);
        }
    });

    $(document).on('click', '.manto_mapaprocesos_li', function () {
        var folderPath = $(this).data('path');
        folderStack.push(folderPath); // Agregar la carpeta actual a la pila
        //console.log(folderStack);
        loadFolders(folderPath);
    });

    $(document).on('click', '.delete-folder', function(event) {
        event.stopPropagation();
        var folderPath = $(this).data('folder');
        deleteFolder(folderPath);
    });

    $(document).on('click', '.edit-folder', function(event) {

        event.stopPropagation();
        var folderPath = $(this).data('folder');
        //alert('Click Edit: '+folderPath);
        $('#newFolderName').val(''); // Limpiar el campo de entrada antes de mostrarlo
        $('#renameFolderForm').data('folder', folderPath); // Almacenar la ruta de la carpeta en el formulario
        $('#renameFolderForm').removeClass('d-none'); // Mostrar el formulario
    });

    $('#confirmRename').click(function() {
        var folderPath = $('#renameFolderForm').data('folder');
        var newFolderName = $('#newFolderName').val();

        if (newFolderName.trim() !== '') {
            renameFolder(folderPath, newFolderName);
        } else {
            alert('Ingresa un nuevo nombre de carpeta válido.');
        }

        $('#renameFolderForm').addClass('d-none'); // Ocultar el formulario después de cambiar el nombre
        $('#newFolderName').val(''); // Limpiar el campo de entrada
    });

    $('#btnCreateFolder').click(function() {
        var folderPath = folderStack[folderStack.length - 1] || ''; // Carpeta actual o raíz si no hay ninguna carpeta seleccionada
        var newFolderName = prompt('Ingresa el nombre de la nueva carpeta:');

        if (newFolderName !== null) {
            if (newFolderName.trim() !== '') {
                createFolder(folderPath, newFolderName);
            } else {
                alert('Ingresa un nombre válido para la carpeta.');
            }
        }
    });

});

function createFolder(parentPath, folderName) {

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'create_folder',
            folderPath: parentPath,
            folderName
        },
        dataType: 'json',
        success: function(response) {
            if (response.error === '') {
                alert(response.message);
                loadFolders(parentPath); // Actualizar la lista después de crear la carpeta
            } else {
                alert(response.error);
            }
        }
    });
}


function renameFolder(folderPath, newFolderName) {
    var newPath = folderPath.substring(0, folderPath.lastIndexOf("/") + 1) + newFolderName;

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'rename_folder',
            folderPath: folderPath,
            newFolderName: newFolderName
        },
        dataType: 'json',
        success: function(response) {
            if (response.error === '') {
                alert(response.message);
                //loadFolders(newPath); // Actualizar la lista después de cambiar el nombre
                window.location.reload();
            } else {
                alert(response.error);
            }
        }
    });
}


function deleteFolder(folderPath){
    //alert('Folder: '+folderPath);
    
    if (confirm('¿Estás seguro de eliminar esta carpeta?')) {
        $.ajax({
            contentType: 'application/x-www-form-urlencoded',
            type: 'POST',
            url: '../assets/all/php/services.php',
            data: {
                option: 'delete_folder',
                folderPath: folderPath
            },
            dataType: 'json',
            success: function(response) {
                if (response.error === '') {
                    alert(response.message);
                    //loadFolders(folderStack[folderStack.length - 1]);
                    window.location.reload();
                } else {
                    alert(response.error);
                }
            }
        });
    }
    
}

function loadFolders(folderPath) {
    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'load_explorer',
            directory: folderPath
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                $('#folderList').html(response.html);
            } else {
                alert(response.error);
            }
        }
    });
}

function sidebar() {
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.manto_mapa').parent().addClass('active');
}

function carga_inicial() {
    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'manto_mapaprocesos-carga_inicial',
        },
        dataType: 'json',
        success: function(response) {
            if (response.error === '') {
                $('#folderList').html(response.html);
            } else {
                alert(response.error);
                window.location.replace('../dashboard.html');
            }
        }
    });
}
