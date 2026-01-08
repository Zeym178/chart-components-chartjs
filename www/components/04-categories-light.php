<?php
// DATOS SIMULADOS
$lightRingConfig = [
    'id' => 'ringChartLight',
    'title' => 'Chart title goes here',
    'total_percent' => 76, // El número grande del centro
    'data' => [
        ['color' => '#1976D2', 'value' => 76, 'label' => 'Point 01'], // Azul (Principal)
        ['color' => '#80DEEA', 'value' => 15, 'label' => 'Point 02'], // Cian
        ['color' => '#EF5350', 'value' => 9,  'label' => 'Point 03'], // Rojo
    ]
];

function renderRingLight($config) {
    // Preparar arrays para JS
    $values = json_encode(array_column($config['data'], 'value'));
    $colors = json_encode(array_column($config['data'], 'color'));
    ?>

    <style>
        .card-ring-light {
            background: #ffffff;
            width: 300px;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            font-family: 'Arial', sans-serif;
            text-align: center;
            color: #000;
        }
        .card-ring-light h3 {
            margin: 0 0 20px 0;
            font-size: 18px;
            font-weight: bold;
        }
        /* Contenedor relativo para posicionar el texto al centro */
        .chart-wrapper-ring {
            position: relative;
            height: 180px;
            width: 180px;
            margin: 0 auto 20px auto;
        }
        .center-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 42px;
            font-weight: 300; /* Letra fina como en la imagen */
            color: #111;
        }
        .divider {
            border: 0;
            height: 1px;
            background: #e0e0e0;
            margin: 20px 0;
        }
        .legend-inline {
            display: flex;
            justify-content: space-around;
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .legend-inline li {
            font-size: 14px;
            color: #777;
            display: flex;
            align-items: center;
        }
        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
            display: inline-block;
        }
    </style>

    <div class="card-ring-light">
        <h3><?php echo $config['title']; ?></h3>

        <div class="chart-wrapper-ring">
            <div class="center-text"><?php echo $config['total_percent']; ?>%</div>
            <canvas id="<?php echo $config['id']; ?>"></canvas>
        </div>

        <hr class="divider">

        <ul class="legend-inline">
            <?php foreach($config['data'] as $item): ?>
                <li>
                    <span class="dot" style="background: <?php echo $item['color']; ?>"></span>
                    <?php echo $item['label']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function(){
            const ctx = document.getElementById('<?php echo $config['id']; ?>').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: <?php echo $values; ?>,
                        backgroundColor: <?php echo $colors; ?>,
                        borderWidth: 0,
                        // borderRadius: 20 crea el efecto de bordes redondeados en los segmentos
                        borderRadius: 20, 
                        spacing: 5 // Pequeño espacio entre segmentos
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '85%', // Hace el anillo muy delgado
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false } // Desactivar tooltip para limpieza visual
                    }
                }
            });
        })();
    </script>
    <?php
}

renderRingLight($lightRingConfig);
?>