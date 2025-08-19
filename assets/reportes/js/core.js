$(function(){
    setTimeout(sidebar,500);
    //sidebar();   

    $('#salir').click(function(){
        window.location.replace('dashboard.html');
    });

    // Asigna el evento click al botón "Exportar a Excel"
    $('#exportExcelBtn').click(function () {
        exportToExcel();
    });

  
});

function new_function() {

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
                /* CODE */
            } else {
                alert(response.error);
            }
        }
    });
}

function exportToExcel() {
    // Obtén la tabla
    var table = document.getElementById("full_table");

    // Crea una matriz para almacenar los datos de la tabla
    var data = [];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var rowData = [];
        for (var j = 0, col; col = row.cells[j]; j++) {
            rowData.push(col.innerText);
        }
        data.push(rowData);
    }

    // Crea un objeto de libro de Excel
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet(data), "Sheet1");

    // Guarda el archivo Excel
    XLSX.writeFile(wb, "reporte.xlsx");
}

function load_documentos_revision() {
    
    var table = $('#document_list');
    table.empty();

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'cargar_lista_reporte'
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
               $.each(response.data, function(index,info){
                    var row = $('<tr>');
                    row.append('<td>'+info.number+'</td>');
                    row.append('<td>'+info.codigo+'</td>');
                    row.append('<td>'+info.alcance+'</td>');
                    row.append('<td>'+info.version+'</td>');
                    row.append('<td>'+decodeURI(escape(info.tipo_documento))+'</td>');
                    row.append('<td>'+info.proceso_principal+'</td>');
                    row.append('<td>'+decodeURI(escape(info.status))+'</td>');
                    row.append('</tr>');
                    table.append(row);
                    //console.log(row);
               });

            } else {
                alert(response.error);
            }
        }
    });
}

function sidebar(){
    //alert('tratando de poner active fa-glasses');
    $('.nav-link').removeClass('active');
    $('.nav-link').find('i.fa-chart-bar').parent().addClass( "active" );
    load_documentos_revision();
}

