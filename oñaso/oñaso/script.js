document.addEventListener('DOMContentLoaded', function() {
    // Colores para los gráficos de dona
    const doughnutColors = [
        { main: '#3498db', background: '#ebf5fb' }, // Azul
        { main: '#e74c3c', background: '#fbebeb' }, // Rojo
        { main: '#2ecc71', background: '#ebf7ef' }  // Verde
    ];
    
    // Configuración común para gráficos de dona
    const doughnutOptions = {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '75%',
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: false
            }
        },
        elements: {
            arc: {
                borderWidth: 0
            }
        }
    };
    
    // Crear los tres gráficos de dona
    for (let i = 1; i <= 3; i++) {
        const ctx = document.getElementById(`doughnutChart${i}`).getContext('2d');
        const colors = doughnutColors[i-1];
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [58, 42],
                    backgroundColor: [colors.main, colors.background],
                    borderWidth: 0
                }]
            },
            options: doughnutOptions
        });
    }
    
    // Datos para el primer gráfico de pastel
    const pieData1 = {
        labels: ['Category A', 'Category B', 'Category C', 'Category D'],
        datasets: [{
            data: [35, 25, 20, 20],
            backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f39c12'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    };
    
    // Datos para el segundo gráfico de pastel
    const pieData2 = {
        labels: ['Point 01', 'Point 02', 'Point 03'],
        datasets: [{
            data: [40, 35, 25],
            backgroundColor: ['#3498db', '#2ecc71', '#e74c3c'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    };
    
    // Configuración común para gráficos de pastel
    const pieOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label}: ${context.parsed}%`;
                    }
                }
            }
        }
    };
    
    // Crear los gráficos de pastel
    const pieCtx1 = document.getElementById('pieChart1').getContext('2d');
    new Chart(pieCtx1, {
        type: 'pie',
        data: pieData1,
        options: pieOptions
    });
    
    const pieCtx2 = document.getElementById('pieChart2').getContext('2d');
    new Chart(pieCtx2, {
        type: 'pie',
        data: pieData2,
        options: pieOptions
    });
});