<?php
// Componente de gráficos de línea
function lineChart($data, $labels, $title = 'Chart title goes here', $subtitle = '', $type = 'line', $theme = 'light', $chartId = null) {
    if (!$chartId) {
        $chartId = 'lineChart_' . uniqid();
    }
    
    $themeClass = $theme === 'dark' ? 'theme-dark' : 'theme-light';
    
    // Colores del tema
    $colors = [
        'primary' => 'rgba(20, 122, 214, 1)',      // Azul
        'secondary' => 'rgba(236, 102, 102, 1)',   // Rojo coral
        'success' => 'rgba(121, 210, 222, 1)'      // Verde azulado
    ];
    
    $availableColors = array_values($colors);
    
    for ($i = 0; $i < count($data); $i++) {
        $color = $availableColors[$i % count($availableColors)];
        
        $dataset = [
            'label' => isset($labels[$i]) ? $labels[$i] : 'Point ' . sprintf('%02d', $i + 1),
            'data' => $data[$i],
            'borderColor' => $color,
            'backgroundColor' => $color . '20',
            'borderWidth' => 2,
            'tension' => $type === 'smooth' ? 0.4 : 0,
            'pointBackgroundColor' => $color,
            'pointBorderColor' => $color,
            'pointRadius' => 4,
            'pointHoverRadius' => 6
        ];
        
        if ($type === 'area') {
            $dataset['fill'] = true;
            $dataset['backgroundColor'] = $color . '40';
        } else {
            $dataset['fill'] = false;
        }
        
        $datasets[] = $dataset;
    }
    
    $chartData = json_encode([
        'labels' => ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'],
        'datasets' => $datasets
    ]);
    
    $chartOptions = json_encode([
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => [
                'display' => count($data) > 1,
                'position' => 'top',
                'labels' => [
                    'color' => $theme === 'dark' ? '#94A3B8' : '#64748B',
                    'usePointStyle' => true,
                    'pointStyle' => 'circle',
                    'padding' => 20
                ]
            ]
        ],
        'scales' => [
            'x' => [
                'grid' => [
                    'display' => false
                ],
                'ticks' => [
                    'color' => $theme === 'dark' ? '#94A3B8' : '#64748B'
                ]
            ],
            'y' => [
                'beginAtZero' => true,
                'grid' => [
                    'color' => $theme === 'dark' ? 'rgba(148, 163, 184, 0.1)' : 'rgba(100, 116, 139, 0.1)'
                ],
                'ticks' => [
                    'color' => $theme === 'dark' ? '#94A3B8' : '#64748B'
                ]
            ]
        ],
        'interaction' => [
            'intersect' => false,
            'mode' => 'index'
        ]
    ]);
    
    return "
    <div class='chart-container {$themeClass}'>
        <h3 class='chart-title'>{$title}</h3>
        " . ($subtitle ? "<div class='chart-subtitle'>{$subtitle}</div>" : "") . "
        <div style='position: relative; height: 300px;'>
            <canvas id='{$chartId}'></canvas>
        </div>
    </div>
    
    <script>
    (function() {
        const ctx = document.getElementById('{$chartId}').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {$chartData},
            options: {$chartOptions}
        });
    })();
    </script>";
}

function areaChart($data, $labels = null, $title = 'Chart title goes here', $subtitle = '', $theme = 'light', $chartId = null) {
    return lineChart($data, $labels, $title, $subtitle, 'area', $theme, $chartId);
}

function smoothLineChart($data, $labels = null, $title = 'Chart title goes here', $subtitle = '', $theme = 'light', $chartId = null) {
    return lineChart($data, $labels, $title, $subtitle, 'smooth', $theme, $chartId);
}

// Gráfico de línea con anotación
function lineChartWithAnnotation($data, $labels, $title, $subtitle, $annotation, $theme = 'light', $chartId = null) {
    if (!$chartId) {
        $chartId = 'lineChart_' . uniqid();
    }
    
    $themeClass = $theme === 'dark' ? 'theme-dark' : 'theme-light';
    
    // Preparar los datos
    $datasets = [];
    $color = $theme === 'dark' ? '#3B82F6' : '#2563EB';
    
    $dataset = [
        'label' => $labels[0] ?? 'Data',
        'data' => $data[0],
        'borderColor' => $color,
        'backgroundColor' => $color . '40',
        'borderWidth' => 2,
        'tension' => 0.4,
        'fill' => true,
        'pointBackgroundColor' => $color,
        'pointBorderColor' => $color,
        'pointRadius' => 4,
        'pointHoverRadius' => 6
    ];
    
    $datasets[] = $dataset;
    
    $chartData = json_encode([
        'labels' => ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'],
        'datasets' => $datasets
    ]);
    
    $chartOptions = json_encode([
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => [
                'display' => false
            ]
        ],
        'scales' => [
            'x' => [
                'grid' => [
                    'display' => false
                ],
                'ticks' => [
                    'color' => $theme === 'dark' ? '#94A3B8' : '#64748B'
                ]
            ],
            'y' => [
                'beginAtZero' => true,
                'grid' => [
                    'color' => $theme === 'dark' ? 'rgba(148, 163, 184, 0.1)' : 'rgba(100, 116, 139, 0.1)'
                ],
                'ticks' => [
                    'color' => $theme === 'dark' ? '#94A3B8' : '#64748B'
                ]
            ]
        ]
    ]);
    
    return "
    <div class='chart-container {$themeClass}'>
        <h3 class='chart-title'>{$title}</h3>
        <div class='chart-subtitle'>{$subtitle}</div>
        <div style='position: relative; height: 250px;'>
            <canvas id='{$chartId}'></canvas>
            <div style='position: absolute; top: 20px; right: 20px; background: rgba(0,0,0,0.8); color: white; padding: 8px 12px; border-radius: 4px; font-size: 12px;'>
                <strong>{$annotation['value']}</strong> {$annotation['label']}
            </div>
        </div>
    </div>
    
    <script>
    (function() {
        const ctx = document.getElementById('{$chartId}').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {$chartData},
            options: {$chartOptions}
        });
    })();
    </script>";
}
?>