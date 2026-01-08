<?php
// Componente de gráficos de barras
function barChart($data, $labels, $title = 'Chart title goes here', $theme = 'light', $chartId = null) {
    if (!$chartId) {
        $chartId = 'barChart_' . uniqid();
    }
    
    $themeClass = $theme === 'dark' ? 'theme-dark' : 'theme-light';
    
    // Colores del tema
    $colors = [
        'primary' => 'rgba(20, 122, 214, 1)',      // Azul
        'secondary' => 'rgba(236, 102, 102, 1)'    // Rojo coral
    ];
    
    for ($i = 0; $i < count($data); $i++) {
        $color = $i === 0 ? $colors['primary'] : $colors['secondary'];
        $datasets[] = [
            'label' => isset($labels[$i]) ? $labels[$i] : 'Point ' . sprintf('%02d', $i + 1),
            'data' => $data[$i],
            'backgroundColor' => $color,
            'borderColor' => $color,
            'borderWidth' => 0,
            'borderRadius' => 4,
            'borderSkipped' => false
        ];
    }
    
    $chartData = json_encode([
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        'datasets' => $datasets
    ]);
    
    $chartOptions = json_encode([
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => [
                'display' => true,
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
        ]
    ]);
    
    return "
    <div class='chart-container {$themeClass}'>
        <h3 class='chart-title'>{$title}</h3>
        <div style='position: relative; height: 350px;'>
            <canvas id='{$chartId}'></canvas>
        </div>
    </div>
    
    <script>
    (function() {
        const ctx = document.getElementById('{$chartId}').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {$chartData},
            options: {$chartOptions}
        });
    })();
    </script>";
}
?>