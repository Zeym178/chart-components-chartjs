<?php

/**
 * Gráfico de dona de 3 categorías
 * @param array $data Array con datos: [['label' => 'Label', 'value' => 55, 'color' => '#1976D2'], ...]
 * @param string $title Título del gráfico
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function donutChart3Categories($data, $title = 'Chart title goes here', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'donutChart_' . uniqid();
    
    // Extraer datos para Chart.js
    $labels = json_encode(array_column($data, 'label'));
    $values = json_encode(array_column($data, 'value'));
    $colors = json_encode(array_column($data, 'color'));
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'chart-container-dark-donut' : 'chart-container-light-donut';
    
    return "
    <div class='chart-container {$themeClass}' style='width: 340px;'>
        <h3 class='chart-title'>" . htmlspecialchars($title) . "</h3>
        
        <div class='donut-canvas-container'>
            <canvas id='{$chartId}'></canvas>
        </div>

        <ul class='donut-legend'>
            " . implode('', array_map(function($item) {
                return "<li>
                    <span class='legend-dot' style='background-color: {$item['color']};'></span>
                    " . htmlspecialchars($item['label']) . "
                </li>";
            }, $data)) . "
        </ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {$labels},
                    datasets: [{
                        data: {$values},
                        backgroundColor: {$colors},
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '55%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });
        });
    </script>";
}

/**
 * Gráfico de anillo (ring chart) de 4 categorías con porcentaje central
 * @param array $data Array con datos: [['label' => 'Point 01', 'value' => 76, 'color' => '#1976D2'], ...]
 * @param string $title Título del gráfico
 * @param int $totalPercent Porcentaje principal a mostrar en el centro
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function ringChart4Categories($data, $title = 'Chart title goes here', $totalPercent = 76, $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'ringChart_' . uniqid();
    
    // Extraer datos
    $values = json_encode(array_column($data, 'value'));
    $colors = json_encode(array_column($data, 'color'));
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'chart-container-dark-ring' : 'chart-container-light-ring';
    
    return "
    <div class='chart-container {$themeClass}' style='width: 320px;'>
        <h3 class='chart-title'>" . htmlspecialchars($title) . "</h3>

        <div class='ring-chart-wrapper'>
            <div class='ring-center-text'>{$totalPercent}%</div>
            <canvas id='{$chartId}'></canvas>
        </div>

        <div class='ring-divider'></div>

        <ul class='ring-legend-inline'>
            " . implode('', array_map(function($item) {
                return "<li>
                    <span class='ring-dot' style='background: {$item['color']};'></span>
                    " . htmlspecialchars($item['label']) . "
                </li>";
            }, $data)) . "
        </ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: {$values},
                        backgroundColor: {$colors},
                        borderWidth: 0,
                        borderRadius: 20,
                        spacing: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '88%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                }
            });
        });
    </script>";
}

?>