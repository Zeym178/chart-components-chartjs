<?php

/**
 * Tarjeta compacta horizontal con número grande y mini gráfico donut
 * @param string $value Valor principal (ej: "354")
 * @param string $label Etiqueta (ej: "Category")
 * @param int $percent Porcentaje para el gráfico (0-100)
 * @param string $color Color del gráfico (hex)
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function compactStatCard($value, $label, $percent = 75, $color = '#1976D2', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'compactStat_' . uniqid();
    $remainder = 100 - $percent;
    
    // Colores según tema
    $trackColor = $theme === 'dark' ? '#3f4250' : '#dce3eb';
    $themeClass = $theme === 'dark' ? 'compact-stat-dark' : 'compact-stat-light';
    
    return "
    <div class='chart-container {$themeClass}' style='width: 260px;'>
        <div class='stat-text-content'>
            <span class='stat-value'>" . htmlspecialchars($value) . "</span>
            <span class='stat-label'>" . htmlspecialchars($label) . "</span>
        </div>

        <div class='stat-chart-mini'>
            <canvas id='{$chartId}'></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [{$percent}, {$remainder}],
                        backgroundColor: ['{$color}', '{$trackColor}'],
                        borderWidth: 0, 
                        borderRadius: 20,
                        cutout: '80%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    events: [],
                    animation: {
                        duration: 1000
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                }
            });
        });
    </script>";
}

/**
 * Tarjeta horizontal con texto e info en la izquierda y mini gráfico a la derecha
 * @param string $title Título (ej: "Challenge 01")
 * @param string $subtitle Subtítulo (ej: "XX of total XX")
 * @param int $percent Porcentaje (0-100)
 * @param string $color Color del gráfico (hex)
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function horizontalCard($title, $subtitle, $percent = 76, $color = '#1976D2', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'horizontalCard_' . uniqid();
    $remainder = 100 - $percent;
    
    // Colores según tema
    $trackColor = $theme === 'dark' ? '#404452' : '#eff2f5';
    $themeClass = $theme === 'dark' ? 'horizontal-card-dark' : 'horizontal-card-light';
    
    return "
    <div class='chart-container {$themeClass}' style='width: 340px; margin-bottom: 15px;'>
        <div class='horizontal-info'>
            <h4>" . htmlspecialchars($title) . "</h4>
            <p>" . htmlspecialchars($subtitle) . "</p>
        </div>
        <div class='horizontal-chart-wrap'>
            <div class='horizontal-percent'>{$percent}%</div>
            <canvas id='{$chartId}'></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [{$percent}, {$remainder}],
                        backgroundColor: ['{$color}', '{$trackColor}'],
                        borderWidth: 0,
                        borderRadius: 50,
                        cutout: '75%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false }, 
                        tooltip: { enabled: false } 
                    },
                    animation: false
                }
            });
        });
    </script>";
}

?>