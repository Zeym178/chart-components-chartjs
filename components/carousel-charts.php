<?php

/**
 * Tarjeta de gráfico tipo carousel con paginación
 * @param string $title Título del gráfico
 * @param string $subtitle Subtítulo
 * @param int $percent Porcentaje (0-100)
 * @param string $color Color del gráfico (hex)
 * @param int $activeDot Cuál punto de paginación está activo (1-3)
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function carouselChart($title = 'Chart title', $subtitle = 'Here go numbers XX of total XX', $percent = 76, $color = '#1976D2', $activeDot = 1, $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'carouselChart_' . uniqid();
    $remaining = 100 - $percent;
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'carousel-card-dark' : 'carousel-card-light';
    
    return "
    <div class='chart-container {$themeClass}' style='width: 300px;'>
        <div class='carousel-title'>" . htmlspecialchars($title) . "</div>
        <div class='carousel-subtitle'>" . htmlspecialchars($subtitle) . "</div>

        <div class='carousel-chart-wrapper'>
            <div class='carousel-center-text'>{$percent}%</div>
            <canvas id='{$chartId}'></canvas>
        </div>

        <div class='carousel-pagination'>
            " . implode('', array_map(function($i) use ($activeDot, $color) {
                $dotStyle = ($i == $activeDot) ? "background-color: {$color};" : "";
                return "<span class='carousel-dot' style='{$dotStyle}'></span>";
            }, [1, 2, 3])) . "
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [{$percent}, {$remaining}],
                        backgroundColor: ['{$color}', '" . ($theme === 'dark' ? '#45495e' : '#eff2f5') . "'],
                        borderWidth: 0,
                        borderRadius: 20,
                        cutout: '82%'
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
                        duration: 1000
                    }
                }
            });
        });
    </script>";
}

?>