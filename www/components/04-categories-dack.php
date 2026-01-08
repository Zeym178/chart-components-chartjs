<?php
// DATOS SIMULADOS (Modo Oscuro)
$darkRingConfig = [
    'id' => 'ringChartDark',
    'title' => 'Chart title goes here',
    'total_percent' => 76,
    'data' => [
        ['color' => '#1976D2', 'value' => 76, 'label' => 'Point 01'], // Azul
        ['color' => '#80DEEA', 'value' => 15, 'label' => 'Point 02'], // Cian
        ['color' => '#EF5350', 'value' => 9,  'label' => 'Point 03'], // Rojo
    ]
];

function renderRingDark($config) {
    $values = json_encode(array_column($config['data'], 'value'));
    $colors = json_encode(array_column($config['data'], 'color'));
    ?>

    <style>
        .card-ring-dark {
            background: #2c2f3f; /* Fondo oscuro exacto de la imagen */
            width: 300px;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
            font-family: 'Arial', sans-serif;
            text-align: center;
            color: #fff;
        }
        .card-ring-dark h3 {
            margin: 0 0 20px 0;
            font-size: 18px;
            font-weight: 600;
            color: #fff;
        }
        .chart-wrapper-dark {
            position: relative;
            height: 180px;
            width: 180px;
            margin: 0 auto 20px auto;
        }
        .center-text-dark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 42px;
            font-weight: 300;
            color: #ffffff;
        }
        .divider-dark {
            border: 0;
            height: 1px;
            background: #44475a; /* Separador sutil */
            margin: 20px 0;
        }
        .legend-inline-dark {
            display: flex;
            justify-content: space-around;
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .legend-inline-dark li {
            font-size: 14px;
            color: #a0a0b0; /* Texto gris claro */
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

    <div class="card-ring-dark">
        <h3><?php echo $config['title']; ?></h3>

        <div class="chart-wrapper-dark">
            <div class="center-text-dark"><?php echo $config['total_percent']; ?>%</div>
            <canvas id="<?php echo $config['id']; ?>"></canvas>
        </div>

        <hr class="divider-dark">

        <ul class="legend-inline-dark">
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
                        borderRadius: 20, // Bordes redondeados clave en este diseño
                        spacing: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '88%', // Anillo muy fino
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

renderRingDark($darkRingConfig);
?>