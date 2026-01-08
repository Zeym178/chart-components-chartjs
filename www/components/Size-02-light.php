<?php
// 1. CONFIGURACIÓN (Datos para el tema CLARO)
$lightCardConfig = [
    'id'      => 'chartLight354', // ID único
    'value'   => '354',           // Valor principal
    'label'   => 'Category',      // Etiqueta
    'percent' => 75,              // Porcentaje de la barra azul
    'colors'  => [
        'main'  => '#1d7bfd',     // Azul brillante (igual que el dark)
        'track' => '#dce3eb',     // Gris azulado muy claro (fondo del anillo)
        'bg'    => '#ffffff',     // Fondo Blanco
        'text'  => '#1f2937',     // Gris muy oscuro (casi negro) para lectura óptima
        'sub'   => '#9ca3af'      // Gris medio para la etiqueta
    ]
];

// 2. FUNCIÓN DE RENDERIZADO
function renderLightStatCard($config) {
    // Cálculo de datos para el gráfico
    $percent = $config['percent'];
    $remainder = 100 - $percent;
    
    // Preparar variables para JS
    $chartData = json_encode([$percent, $remainder]);
    $chartColors = json_encode([$config['colors']['main'], $config['colors']['track']]);
    ?>

    <style>
        .card-light-stat {
            background-color: <?php echo $config['colors']['bg']; ?>;
            width: 240px;
            padding: 20px 24px;
            border-radius: 16px;
            /* Sombra suave y difusa para fondo blanco */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-sizing: border-box;
            border: 1px solid #f3f4f6; /* Borde sutil opcional para definición */
        }

        .card-light-stat .text-content {
            display: flex;
            flex-direction: column;
        }

        .card-light-stat .stat-value {
            color: <?php echo $config['colors']['text']; ?>;
            font-size: 32px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .card-light-stat .stat-label {
            color: <?php echo $config['colors']['sub']; ?>;
            font-size: 16px;
            font-weight: 400;
        }

        .card-light-stat .chart-wrapper-mini {
            position: relative;
            height: 65px;
            width: 65px;
        }
    </style>

    <div class="card-light-stat">
        <div class="text-content">
            <span class="stat-value"><?php echo $config['value']; ?></span>
            <span class="stat-label"><?php echo $config['label']; ?></span>
        </div>

        <div class="chart-wrapper-mini">
            <canvas id="<?php echo $config['id']; ?>"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    
    <script>
        (function(){
            const ctx = document.getElementById('<?php echo $config['id']; ?>').getContext('2d');
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'Inactive'],
                    datasets: [{
                        data: <?php echo $chartData; ?>,
                        backgroundColor: <?php echo $chartColors; ?>,
                        borderWidth: 0,
                        borderRadius: 20, // Bordes redondeados
                        cutout: '80%',    // Grosor del anillo
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    events: [], // Estático
                    animation: { duration: 1000 },
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                }
            });
        })();
    </script>
    <?php
}

// 3. EJECUCIÓN
renderLightStatCard($lightCardConfig);
?>