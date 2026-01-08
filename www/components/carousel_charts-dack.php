<?php

/**
 * FUNCIÓN DE RENDERIZADO (Modo Oscuro)
 * Genera una tarjeta oscura con gráfico y paginación.
 */
function renderDarkCarouselCard($uniqueId, $config) {
    $percentage = $config['percent'];
    $remaining = 100 - $percentage;
    $mainColor = $config['color'];
    ?>

    <style>
        .dark-carousel-card {
            background-color: #2c2f3f; /* Color de fondo exacto de la imagen */
            width: 280px;
            padding: 35px 25px;
            border-radius: 12px;
            text-align: center;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4); /* Sombra oscura profunda */
            display: inline-block;
            margin: 20px;
            vertical-align: top;
            color: #ffffff;
        }

        .dcc-title {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 10px 0;
            color: #ffffff;
        }

        .dcc-subtitle {
            font-size: 14px;
            color: #a0a0b0; /* Gris azulado claro para texto secundario */
            margin: 0 0 30px 0;
        }

        /* Wrapper del gráfico */
        .dcc-chart-wrapper {
            position: relative;
            height: 160px;
            width: 160px;
            margin: 0 auto 35px auto;
        }

        .dcc-center-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 32px;
            font-weight: 600;
            color: #ffffff;
        }

        /* Paginación Oscura */
        .dcc-pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .dcc-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #45495e; /* Gris oscuro para inactivos */
            transition: background-color 0.3s;
        }
    </style>

    <div class="dark-carousel-card">
        <div class="dcc-title"><?php echo htmlspecialchars($config['title']); ?></div>
        <div class="dcc-subtitle"><?php echo htmlspecialchars($config['subtitle']); ?></div>

        <div class="dcc-chart-wrapper">
            <div class="dcc-center-text"><?php echo $percentage; ?>%</div>
            <canvas id="<?php echo $uniqueId; ?>"></canvas>
        </div>

        <div class="dcc-pagination">
            <?php for($i = 1; $i <= 3; $i++): ?>
                <span class="dcc-dot" 
                      style="<?php echo ($i == $config['active_dot']) ? 'background-color: ' . $mainColor : ''; ?>">
                </span>
            <?php endfor; ?>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('<?php echo $uniqueId; ?>').getContext('2d');
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [<?php echo $percentage; ?>, <?php echo $remaining; ?>],
                        backgroundColor: [
                            '<?php echo $mainColor; ?>', // Color vivo
                            '#404452'                // Color gris oscuro para el fondo del anillo
                        ],
                        borderWidth: 0,
                        borderRadius: 20, // Bordes redondeados
                        cutout: '82%',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    },
                    animation: {
                        animateScale: true
                    }
                }
            });
        });
    </script>
    <?php
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="background: #1a1c23; padding: 50px; text-align: center;">

    <?php
    // 1. IMAGEN: Size-03-2-darck.png (Azul, Punto 1 Activo)
    renderDarkCarouselCard('chartDarkBlue', [
        'title'      => 'Chart title',
        'subtitle'   => 'Here go numbers XX of total XX',
        'percent'    => 76,
        'color'      => '#1976D2', // Azul brillante
        'active_dot' => 1
    ]);

    // 2. IMAGEN: Size-03-1-darck.png (Rojo, Punto 2 Activo)
    renderDarkCarouselCard('chartDarkRed', [
        'title'      => 'Chart title',
        'subtitle'   => 'Here go numbers XX of total XX',
        'percent'    => 76,
        'color'      => '#EF5350', // Rojo salmón
        'active_dot' => 2
    ]);

    // 3. IMAGEN: Size-03-darck.png (Cian, Punto 3 Activo)
    renderDarkCarouselCard('chartDarkCyan', [
        'title'      => 'Chart title',
        'subtitle'   => 'Here go numbers XX of total XX',
        'percent'    => 76,
        'color'      => '#80DEEA', // Cian claro
        'active_dot' => 3
    ]);
    ?>

</div>