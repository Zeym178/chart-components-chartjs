<?php

/**
 * Gráfico de dona simple con porcentaje central
 * @param int $percentage Porcentaje a mostrar (0-100)
 * @param string $title Título del gráfico
 * @param string $subtitle Subtítulo del gráfico
 * @param string $color Color principal (hex)
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function simpleDonutChart($percentage = 58, $title = 'Chart title', $subtitle = '15 April - 15 May', $color = '#147AD6', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'simpleDonut_' . uniqid();
    $remaining = 100 - $percentage;
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'simple-donut-dark' : 'simple-donut-light';
    
    // Color de fondo según tema
    $bgColor = $theme === 'dark' ? '#404452' : '#f3f4f6';
    
    return "
    <div class='chart-container {$themeClass}' style='width: 280px; height: 280px;'>
        <div class='simple-donut-header'>
            <h3 class='simple-donut-title'>" . htmlspecialchars($title) . "</h3>
            <p class='simple-donut-subtitle'>" . htmlspecialchars($subtitle) . "</p>
        </div>
        
        <div class='simple-donut-wrapper'>
            <div class='simple-donut-percentage'>{$percentage}%</div>
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
                        data: [{$percentage}, {$remaining}],
                        backgroundColor: ['{$color}', '{$bgColor}'],
                        borderWidth: 0,
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
                    elements: {
                        arc: { borderWidth: 0 }
                    }
                }
            });
        });
    </script>";
}

/**
 * Gráfico de pie simple sin leyenda
 * @param array $data Array con valores [35, 25, 20, 20]
 * @param array $colors Array con colores ['#3498db', '#2ecc71', '#e74c3c', '#f39c12']
 * @param string $title Título del gráfico
 * @param string $subtitle Subtítulo del gráfico
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function simplePieChart($data = [35, 25, 20, 20], $colors = ['#147AD6', '#EC6666', '#79D2DE', '#F97316'], $title = 'Chart title', $subtitle = 'Here go numbers XX of total XX', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'simplePie_' . uniqid();
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'simple-pie-dark' : 'simple-pie-light';
    
    $chartData = json_encode($data);
    $chartColors = json_encode($colors);
    
    return "
    <div class='chart-container {$themeClass}' style='width: 280px; height: 280px;'>
        <div class='simple-pie-header'>
            <h3 class='simple-pie-title'>" . htmlspecialchars($title) . "</h3>
            <p class='simple-pie-subtitle'>" . htmlspecialchars($subtitle) . "</p>
        </div>
        
        <div class='simple-pie-wrapper'>
            <canvas id='{$chartId}'></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: {$chartData},
                        backgroundColor: {$chartColors},
                        borderWidth: 2,
                        borderColor: '" . ($theme === 'dark' ? '#2c2f3f' : '#ffffff') . "'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '" . ($theme === 'dark' ? '#2c2f3f' : '#ffffff') . "',
                            titleColor: '" . ($theme === 'dark' ? '#ffffff' : '#1f2937') . "',
                            bodyColor: '" . ($theme === 'dark' ? '#ffffff' : '#1f2937') . "',
                            borderColor: '" . ($theme === 'dark' ? '#404452' : '#e5e7eb') . "',
                            borderWidth: 1,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed + '%';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>";
}

/**
 * Gráfico de pie con leyenda personalizada
 * @param array $data Array con datos: [['label' => 'Point 01', 'value' => 40, 'color' => '#3498db'], ...]
 * @param string $title Título del gráfico
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function pieChartWithLegend($data = [], $title = 'Chart title goes here', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'pieWithLegend_' . uniqid();
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'pie-legend-dark' : 'pie-legend-light';
    
    // Extraer datos
    $values = json_encode(array_column($data, 'value'));
    $colors = json_encode(array_column($data, 'color'));
    
    return "
    <div class='chart-container {$themeClass}' style='width: 320px; height: 300px;'>
        <div class='pie-legend-header'>
            <h3 class='pie-legend-title'>" . htmlspecialchars($title) . "</h3>
            
            <div class='pie-custom-legend'>
                " . implode('', array_map(function($item) {
                    return "<div class='pie-legend-item'>
                        <span class='pie-legend-dot' style='background-color: {$item['color']};'></span>
                        <span class='pie-legend-text'>" . htmlspecialchars($item['label']) . "</span>
                    </div>";
                }, $data)) . "
            </div>
        </div>
        
        <div class='pie-legend-wrapper'>
            <canvas id='{$chartId}'></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: {$values},
                        backgroundColor: {$colors},
                        borderWidth: 2,
                        borderColor: '" . ($theme === 'dark' ? '#2c2f3f' : '#ffffff') . "'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '" . ($theme === 'dark' ? '#2c2f3f' : '#ffffff') . "',
                            titleColor: '" . ($theme === 'dark' ? '#ffffff' : '#1f2937') . "',
                            bodyColor: '" . ($theme === 'dark' ? '#ffffff' : '#1f2937') . "',
                            borderColor: '" . ($theme === 'dark' ? '#404452' : '#e5e7eb') . "',
                            borderWidth: 1,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed + '%';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>";
}

/**
 * Dashboard completo con múltiples gráficos tipo grid
 * @param array $donutCharts Array de configuraciones para donuts
 * @param array $pieCharts Array de configuraciones para pies
 * @param string $theme 'light' o 'dark'
 */
function chartDashboard($donutCharts = [], $pieCharts = [], $theme = 'light') {
    $themeClass = $theme === 'dark' ? 'dashboard-dark' : 'dashboard-light';
    
    $donutHtml = '';
    foreach ($donutCharts as $index => $donut) {
        $donutHtml .= simpleDonutChart(
            $donut['percentage'] ?? 58,
            $donut['title'] ?? 'Chart title',
            $donut['subtitle'] ?? '15 April - 15 May',
            $donut['color'] ?? '#3498db',
            $theme,
            'dashDonut_' . $index
        );
    }
    
    $pieHtml = '';
    foreach ($pieCharts as $index => $pie) {
        if (isset($pie['legend']) && $pie['legend']) {
            $pieHtml .= pieChartWithLegend(
                $pie['data'] ?? [],
                $pie['title'] ?? 'Chart title goes here',
                $theme,
                'dashPie_' . $index
            );
        } else {
            $pieHtml .= simplePieChart(
                $pie['data'] ?? [35, 25, 20, 20],
                $pie['colors'] ?? ['#3498db', '#2ecc71', '#e74c3c', '#f39c12'],
                $pie['title'] ?? 'Chart title',
                $pie['subtitle'] ?? 'Here go numbers XX of total XX',
                $theme,
                'dashPie_' . $index
            );
        }
    }
    
    return "
    <div class='dashboard-container {$themeClass}'>
        <div class='dashboard-row'>
            {$donutHtml}
        </div>
        <div class='dashboard-row'>
            {$pieHtml}
        </div>
    </div>";
}

?>