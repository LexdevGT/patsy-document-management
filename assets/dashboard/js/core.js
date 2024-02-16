$(function(){

    setTimeout(sidebar,500);   

    cargarGrafica();
    load_documentos_revisados_por_linea();
    loadLineChartData();
  
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

function loadLineChartData() {
    // LINE CHART
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
    var lineChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                gridLines: {
                    display: false,
                }
            }]
        }
    };

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'getLineChartData'
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                var lineChartData = response.data;
                new Chart(lineChartCanvas, {
                    type: 'line',
                    data: lineChartData,
                    options: lineChartOptions
                });
            } else {
                alert(response.error);
            }
        }
    });
}

function load_documentos_revisados_por_linea() {
    // AREA CHART
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
    var areaChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                gridLines: {
                    display: false,
                }
            }]
        }
    };

    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'documentos_revisados_por_dia'
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                var areaChartData = response.data;
                new Chart(areaChartCanvas, {
                    type: 'line',
                    data: areaChartData,
                    options: areaChartOptions
                });
            } else {
                alert(response.error);
            }
        }
    });
}

function cargarGrafica() {
    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'documentos_creados_por_dia'
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                // Extraer datos del servidor
                var fechas = response.data.fechas;
                var cantidades = response.data.cantidades;

                // Configurar y renderizar la gráfica
                configurarGrafica(fechas, cantidades);
            } else {
                alert(response.error);
            }
        }
    });
}

function configurarGrafica(fechas, cantidades) {
    // Configurar datos para la gráfica
    var data = {
        labels: fechas,
        datasets: [{
            label: 'Documentos Creados por Día',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            data: cantidades
        }]
    };

    // Configurar opciones de la gráfica
    var options = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    // Obtener el contexto del lienzo
    var ctx = document.getElementById('barChart').getContext('2d');

    // Crear nueva gráfica de barras
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
}

function obtenerConteoDocumentosAprobados() {
    //alert('iniciamos');
    $.ajax({
        contentType: 'application/x-www-form-urlencoded',
        type: 'POST',
        url: '../assets/all/php/services.php',
        data: {
            option: 'obtener_conteo_documentos_aprobados'
        },
        dataType: 'json',
        success: function (response) {
            if (response.error === '') {
                // Actualiza el valor en el dashboard
                $('#conteoDocumentosAprobados').text(response.message);
            } else {
                alert(response.error);
            }
        }
    });
}

function sidebar(){
    $('.nav-link').removeClass('active');
    obtenerConteoDocumentosAprobados();
    //$('.nav-link').find('i.fa-pen-nib').parent().addClass( "active" );
}

