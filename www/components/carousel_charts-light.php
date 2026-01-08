<?php

/**
 * LÓGICA DE RENDERIZADO (Reutilizable)
 * Esta función genera el HTML/CSS/JS necesario para cualquier tarjeta de este tipo.
 */
function renderCarouselCard($uniqueId, $config) {
    // Preparamos datos para JS
    $percentage = $config['percent'];
    $remaining = 100 - $percentage;
    $color = $config['color'];
    ?>

    <style>
        .carousel-card {
            background: #ffffff;
            width: 280px;
            padding: 30px 20px;
            border-radius: 8px; /* Bordes suaves */
            text-align: center;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); /* Sombra muy sutil */
            display: inline-block;
            margin: 20px;
            vertical-align: top;
        }

        .cc-title {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 10px 0;
            color: #000;
        }

        .cc-subtitle {
            font-size: 14px;
            color: #90949c; /* Gris suave */
            margin: 0 0 25px 0;
        }

        /* Contenedor del gráfico para centrar el texto */
        .cc-chart-wrapper {
            position: relative;
            height: 160px;
            width: 160px;
            margin: 0 auto 30px auto;
        }

        .cc-center-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 32px;
            font-weight: 600;
            color: #000;
        }

        /* Paginación (Puntos) */
        .cc-pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .cc-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #d1d5db; /* Gris inactivo */
            transition: background-color 0.3s;
        }
    </style>

    <div class="carousel-card">
        <div class="cc-title"><?php echo htmlspecialchars($config['title']); ?></div>
        <div class="cc-subtitle"><?php echo htmlspecialchars($config['subtitle']); ?></div>

        <div class="cc-chart-wrapper">
            <div class="cc-center-text"><?php echo $percentage; ?>%</div>
            <canvas id="<?php echo $uniqueId; ?>"></canvas>
        </div>

        <div class="cc-pagination">
            <?php for($i = 1; $i <= 3; $i++): ?>
                <span class="cc-dot" 
                      style="<?php echo ($i == $config['active_dot']) ? 'background-color: ' . $color : ''; ?>">
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
                            '<?php echo $color; ?>', // Color activo
                            '#dae0e6'                // Color gris de fondo (track)
                        ],
                        borderWidth: 0,
                        borderRadius: 20, // Bordes redondeados (clave para este diseño)
                        cutout: '82%',    // Grosor del anillo
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false } // Limpio, sin popups
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        });
    </script>
    <?php
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="background: #f4f6f8; padding: 50px; text-align: center;">

    <?php
    // 1. COMPONENTE AZUL (Size-03-2-light.png)
    // Primer punto activo
    renderCarouselCard('chartBlue', [
        'title'      => 'Chart title',
        'subtitle'   => 'Here go numbers XX of total XX',
        'percent'    => 76,
        'color'      => '#1976D2', // Azul fuerte
        'active_dot' => 1          // Primer punto coloreado
    ]);

    // 2. COMPONENTE ROJO (Size-03-1-light.png)
    // Segundo punto activo
    renderCarouselCard('chartRed', [
        'title'      => 'Chart title',
        'subtitle'   => 'Here go numbers XX of total XX',
        'percent'    => 76,
        'color'      => '#EF5350', // Rojo suave
        'active_dot' => 2          // Segundo punto coloreado
    ]);

    // 3. COMPONENTE CYAN (Size-03-light.png)
    // Tercer punto activo
    renderCarouselCard('chartCyan', [
        'title'      => 'Chart title',
        'subtitle'   => 'Here go numbers XX of total XX',
        'percent'    => 76,
        'color'      => '#80DEEA', // Cian/Turquesa
        'active_dot' => 3          // Tercer punto coloreado
    ]);
    ?>

</div>