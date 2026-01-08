<?php
// 1. Simulación de datos (esto vendría de tu base de datos)
$chartConfig = [
    'title' => 'Chart title goes here',
    'id'    => 'myDonutChart', // ID único por si tienes varios gráficos
    'data'  => [
        [
            'label' => 'Long category label 01',
            'value' => 55,
            'color' => '#1976D2' // Azul oscuro
        ],
        [
            'label' => 'Long category label 02',
            'value' => 25,
            'color' => '#80DEEA' // Azul claro / Cian
        ],
        [
            'label' => 'Long category label 03',
            'value' => 20,
            'color' => '#EF5350' // Rojo
        ]
    ]
];

// Función auxiliar para renderizar el componente
function renderChartComponent($config) {
    // Extraer arrays para JS
    $labels = json_encode(array_column($config['data'], 'label'));
    $values = json_encode(array_column($config['data'], 'value'));
    $colors = json_encode(array_column($config['data'], 'color'));
    
    ?>
    <style>
        .chart-card {
            background-color: #2c2f3f; /* Fondo oscuro exacto */
            border-radius: 8px;
            padding: 24px;
            width: 320px;
            font-family: 'Arial', sans-serif;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            color: white;
            text-align: center;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            margin-top: 0;
        }

        .canvas-container {
            position: relative;
            height: 200px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .custom-legend {
            list-style: none;
            padding: 0;
            margin-top: 20px;
            text-align: left;
            display: inline-block;
        }

        .custom-legend li {
            margin-bottom: 10px;
            font-size: 14px;
            color: #b0b3c5; /* Color gris claro del texto */
            display: flex;
            align-items: center;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 12px;
        }
    </style>

    <div class="chart-card">
        <h3 class="chart-title"><?php echo htmlspecialchars($config['title']); ?></h3>
        
        <div class="canvas-container">
            <canvas id="<?php echo $config['id']; ?>"></canvas>
        </div>

        <ul class="custom-legend">
            <?php foreach ($config['data'] as $item): ?>
                <li>
                    <span class="legend-dot" style="background-color: <?php echo $item['color']; ?>"></span>
                    <?php echo htmlspecialchars($item['label']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('<?php echo $config['id']; ?>').getContext('2d');
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: <?php echo $labels; ?>,
                    datasets: [{
                        data: <?php echo $values; ?>,
                        backgroundColor: <?php echo $colors; ?>,
                        borderWidth: 0, // Sin bordes como en la imagen
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '55%', // Tamaño del agujero de la dona
                    plugins: {
                        legend: {
                            display: false // Ocultamos leyenda por defecto para usar la nuestra HTML
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });
        });
    </script>
    <?php
}

// 2. Renderizar el componente
renderChartComponent($chartConfig);
?>