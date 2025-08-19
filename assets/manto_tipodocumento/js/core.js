// Variables globales para paginación
var currentPage = 1;
var itemsPerPage = 10;
var allData = [];

$(function(){

    sidebar();   

    $('#enviar').click(function(){
        create_tipo_docto();
    });
    
    load_list();  
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

function lista_cambiar_estado(Id, isChecked) {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'cambio_de_status_tipo_docto',
            id: Id,
            nuevo_estado: isChecked ? 1 : 0
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                alert('Estado actualizado correctamente.');
            } else {
                alert('Error al actualizar el estado: ' + response.error);
            }
        }
    });
}

function load_list() {
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: ({
            option: 'load_tipo_docto_list'
        }),
        dataType: "json",
        success: function (r) {
            if (r.error === '') {
                if (r.data && r.data.length > 0) {
                    allData = r.data;
                    currentPage = 1;
                    renderTable();
                    renderPagination();
                } else {
                    allData = [];
                    renderTable();
                    renderPagination();
                }
            } else {
                alert(r.error);
            }
        },
        beforeSend: function(xhr) {
            xhr.overrideMimeType('text/html;charset=ISO-8859-1');
        }
    });
}

function renderTable() {
    var tableBody = $('#cuerpo_tabla');
    tableBody.empty();

    if (allData.length === 0) {
        tableBody.append('<tr><td colspan="4">No se encontraron tipos de documentos.</td></tr>');
        return;
    }

    var start = (currentPage - 1) * itemsPerPage;
    var end = start + itemsPerPage;
    var pageData = allData.slice(start, end);

    $.each(pageData, function (index, tipo_docto) {
        var row = $('<tr>');
        row.append('<td>' + (start + index + 1) + '.</td>');
        row.append('<td>' + decodeURI(escape(tipo_docto.nombre)) + '</td>');
        row.append('<td>' + decodeURI(escape(tipo_docto.siglas)) + '</td>');
        
        var switchHtml = '<div class="form-group">' +
            '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">' +
            '<input type="checkbox" class="custom-control-input" id="customSwitch' + (tipo_docto.id) + '"';
        
        if (tipo_docto.status === '1') {
            switchHtml += ' checked';
        }

        switchHtml += ' onclick="lista_cambiar_estado(' + tipo_docto.id + ', this.checked)"' +
            '>' +
            '<label class="custom-control-label" for="customSwitch' + tipo_docto.id + '"></label>' +
            '</div>' +
            '</div>';

        row.append('<td>' + switchHtml + '</td>');
        tableBody.append(row);
    });
}

function renderPagination() {
    var totalPages = Math.ceil(allData.length / itemsPerPage);
    var paginationContainer = $('.pagination');
    
    paginationContainer.empty();

    // Solo mostrar paginación si hay más de una página
    if (totalPages <= 1) {
        $('.card-footer').hide();
        return;
    }

    $('.card-footer').show();

    // Botón anterior
    var prevDisabled = currentPage === 1 ? 'disabled' : '';
    paginationContainer.append('<li class="page-item ' + prevDisabled + '"><a class="page-link" href="#" onclick="changePage(' + (currentPage - 1) + ')">&laquo;</a></li>');

    // Números de página
    for (var i = 1; i <= totalPages; i++) {
        var active = i === currentPage ? 'active' : '';
        paginationContainer.append('<li class="page-item ' + active + '"><a class="page-link" href="#" onclick="changePage(' + i + ')">' + i + '</a></li>');
    }

    // Botón siguiente
    var nextDisabled = currentPage === totalPages ? 'disabled' : '';
    paginationContainer.append('<li class="page-item ' + nextDisabled + '"><a class="page-link" href="#" onclick="changePage(' + (currentPage + 1) + ')">&raquo;</a></li>');
}

function changePage(page) {
    var totalPages = Math.ceil(allData.length / itemsPerPage);
    
    if (page < 1 || page > totalPages) {
        return;
    }
    
    currentPage = page;
    renderTable();
    renderPagination();
}

function create_tipo_docto() {

    var nombre_tipo_docto   = $('#tipo_documento');
    var siglas              = $('#siglas'); 

    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        type: "POST",
        url: "../assets/all/php/services.php",
        data: {
            option: 'crear_tipo_docto',
            nombre: nombre_tipo_docto.val(),
            siglas: siglas.val()
        },
        dataType: "json",
        success: function (response) {
            if (response.error === '') {
                alert('Tipo de documento creado correctamente.');
                nombre_tipo_docto.val('');
                siglas.val('');
                load_list();
            } else {
                alert('Error al crear el tipo de documento: ' + response.error);
            }
        }
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.manto_tipodocumento').parent().addClass( "active" );
}

