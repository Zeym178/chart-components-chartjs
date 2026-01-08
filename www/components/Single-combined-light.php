<?php
// Datos de ejemplo para la lista
$challengesLight = [
    [
        'id'       => 'ch_light_01', // ID único para el canvas
        'percent'  => 76,
        'title'    => 'Challenge 01',
        'subtitle' => 'XX of total XX',
        'color'    => '#1976D2' // Azul
    ],
    [
        'id'       => 'ch_light_02',
        'percent'  => 54, // Variamos un poco para probar
        'title'    => 'Challenge 02',
        'subtitle' => 'XX of total XX',
        'color'    => '#EF5350' // Rojo
    ],
    [
        'id'       => 'ch_light_03',
        'percent'  => 88,
        'title'    => 'Challenge 03',
        'subtitle' => 'XX of total XX',
        'color'    => '#80DEEA' // Cian
    ]
];

function renderChallengeListLight($items) {
    ?>
    <style>
        .challenge-card-light {
            background: #ffffff;
            width: 320px;
            padding: 10px 25px;
            border-radius: 12px;
            /* Sombra suave tipo tarjeta */
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #000;
        }

        .challenge-item {
            display: flex;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #eeeeee;
        }

        /* Quitamos el borde al último elemento */
        .challenge-item:last-child {
            border-bottom: none;
        }

        .chart-mini-wrapper {
            position: relative;
            width: 70px;
            height: 70px;
            margin-right: 20px;
            flex-shrink: 0; /* Evita que el gráfico se aplaste */
        }

        .chart-mini-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 16px;
            font-weight: bold;
            color: #000;
        }

        .challenge-info h4 {
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: 700;
        }

        .challenge-info p {
            margin: 0;
            font-size: 14px;
            color: #999;
        }
    </style>

    <div class="challenge-card-light">
        <?php foreach ($items as $item): ?>
            <div class="challenge-item">
                <div class="chart-mini-wrapper">
                    <div class="chart-mini-text"><?php echo $item['percent']; ?>%</div>
                    <canvas id="<?php echo $item['id']; ?>"></canvas>
                </div>
                
                <div class="challenge-info">
                    <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                    <p><?php echo htmlspecialchars($item['subtitle']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Datos pasados desde PHP
            const items = <?php echo json_encode($items); ?>;

            items.forEach(item => {
                const ctx = document.getElementById(item.id).getContext('2d');
                
                // Calculamos el restante para dibujar el anillo gris
                const remaining = 100 - item.percent;

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [item.percent, remaining],
                            backgroundColor: [
                                item.color,  // Color principal
                                '#eceff1'    // Color gris de fondo (track)
                            ],
                            borderWidth: 0,
                            borderRadius: 20 // Bordes redondeados
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '80%', // Anillo delgado
                        events: [], // Desactiva hover/tooltips para mejorar rendimiento
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: false }
                        },
                        animation: {
                            duration: 1000
                        }
                    }
                });
            });
        });
    </script>
    <?php
}

renderChallengeListLight($challengesLight);
?>