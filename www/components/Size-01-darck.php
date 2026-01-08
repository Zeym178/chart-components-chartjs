<?php
// 1. CONFIGURACIÓN (Datos simulados basados en tu imagen)
$darkCardConfig = [
    'id'      => 'chartDark354', // ID único para el canvas
    'value'   => '354',          // El número grande
    'label'   => 'Category',     // La etiqueta gris
    'percent' => 75,             // Porcentaje de progreso visual
    'colors'  => [
        'main'  => '#1d7bfd',    // Azul brillante (progreso)
        'track' => '#3f4250',    // Gris oscuro (fondo del anillo)
        'bg'    => '#2c2e3a',    // Fondo de la tarjeta
        'text'  => '#ffffff',    // Texto blanco
        'sub'   => '#9ca3af'     // Texto gris
    ]
];

// 2. FUNCIÓN DE RENDERIZADO
function renderDarkStatCard($config) {
    // Calculamos el resto para completar el 100% del gráfico de dona
    $percent = $config['percent'];
    $remainder = 100 - $percent;
    
    // Preparamos datos para JS
    $chartData = json_encode([$percent, $remainder]);
    $chartColors = json_encode([$config['colors']['main'], $config['colors']['track']]);
    ?>

    <style>
        .card-dark-stat {
            background-color: <?php echo $config['colors']['bg']; ?>;
            width: 240px;
            padding: 20px 24px;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-sizing: border-box;
        }

        /* Sección de Texto (Izquierda) */
        .card-dark-stat .text-content {
            display: flex;
            flex-direction: column;
        }

        .card-dark-stat .stat-value {
            color: <?php echo $config['colors']['text']; ?>;
            font-size: 32px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .card-dark-stat .stat-label {
            color: <?php echo $config['colors']['sub']; ?>;
            font-size: 16px;
            font-weight: 400;
        }

        /* Contenedor del Gráfico (Derecha) */
        .card-dark-stat .chart-wrapper-mini {
            position: relative;
            height: 65px;
            width: 65px;
        }
    </style>

    <div class="card-dark-stat">
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
                    labels: ['Progress', 'Remaining'],
                    datasets: [{
                        data: <?php echo $chartData; ?>,
                        backgroundColor: <?php echo $chartColors; ?>,
                        borderWidth: 0, 
                        borderRadius: 20, // Bordes redondeados en los extremos
                        cutout: '80%',    // Grosor del anillo (más alto = más fino)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    events: [], // Desactivar interacciones (hover) para que parezca estático como la imagen
                    animation: {
                        duration: 1000 // Animación suave al cargar
                    },
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
renderDarkStatCard($darkCardConfig);
?>