<?php
// Componente de gráficos de barras nativo con SVG

function nativeBarChart($data, $labels = [], $title = 'Chart title goes here', $theme = 'light') {
    $chartId = 'barChart_' . uniqid();
    $themeClass = $theme === 'dark' ? 'dark' : '';
    
    // Configuración del gráfico
    $width = 400;
    $height = 300;
    $padding = [40, 40, 60, 60]; // top, right, bottom, left
    $chartWidth = $width - $padding[1] - $padding[3];
    $chartHeight = $height - $padding[0] - $padding[2];
    
    // Colores del tema
    $colors = [
        'rgba(20, 122, 214, 1)',     // Azul
        'rgba(236, 102, 102, 1)'     // Rojo coral
    ];
    
    // Etiquetas del eje X
    $xLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
    $barWidth = $chartWidth / (count($xLabels) * count($data) + count($xLabels) - 1);
    $groupWidth = $barWidth * count($data);
    $spacing = $barWidth * 0.2;
    
    // Calcular el máximo valor para escalar
    $maxValue = 0;
    foreach ($data as $series) {
        $maxValue = max($maxValue, max($series));
    }
    $maxValue = ceil($maxValue / 10000) * 10000; // Redondear a 10k
    
    // Generar las barras
    $bars = '';
    $legends = '';
    
    for ($seriesIndex = 0; $seriesIndex < count($data); $seriesIndex++) {
        $series = $data[$seriesIndex];
        $color = $colors[$seriesIndex % count($colors)];
        $label = isset($labels[$seriesIndex]) ? $labels[$seriesIndex] : 'Point ' . sprintf('%02d', $seriesIndex + 1);
        
        // Generar leyenda
        $legends .= "
            <div class='legend-item'>
                <div class='legend-dot legend-" . ($seriesIndex === 0 ? 'blue' : 'red') . "'></div>
                <span>{$label}</span>
            </div>";
        
        for ($i = 0; $i < count($series); $i++) {
            $value = $series[$i];
            $barHeight = ($value / $maxValue) * $chartHeight;
            
            $x = $padding[3] + ($i * ($groupWidth + $spacing)) + ($seriesIndex * $barWidth);
            $y = $padding[0] + $chartHeight - $barHeight;
            
            $bars .= "
                <rect 
                    x='{$x}' 
                    y='{$y}' 
                    width='{$barWidth}' 
                    height='{$barHeight}' 
                    fill='{$color}' 
                    class='bar-rect'
                    data-value='{$value}'
                    data-label='{$xLabels[$i]}'
                    rx='4'
                    ry='4'
                />
            ";
        }
    }
    
    // Generar ejes Y
    $yAxis = '';
    $steps = 5;
    for ($i = 0; $i <= $steps; $i++) {
        $value = ($maxValue / $steps) * $i;
        $y = $padding[0] + $chartHeight - (($value / $maxValue) * $chartHeight);
        
        // Línea de grid horizontal
        if ($i > 0) {
            $yAxis .= "
                <line 
                    x1='{$padding[3]}' 
                    y1='{$y}' 
                    x2='" . ($padding[3] + $chartWidth) . "' 
                    y2='{$y}' 
                    class='chart-grid'
                />
            ";
        }
        
        // Etiqueta del eje Y
        $displayValue = $value >= 1000 ? (($value / 1000) . 'K') : $value;
        $yAxis .= "
            <text 
                x='" . ($padding[3] - 10) . "' 
                y='" . ($y + 4) . "' 
                text-anchor='end' 
                class='chart-axis-text'
            >
                {$displayValue}
            </text>
        ";
    }
    
    // Generar eje X
    $xAxis = '';
    for ($i = 0; $i < count($xLabels); $i++) {
        $x = $padding[3] + ($i * ($groupWidth + $spacing)) + ($groupWidth / 2);
        $y = $height - $padding[2] + 20;
        
        $xAxis .= "
            <text 
                x='{$x}' 
                y='{$y}' 
                text-anchor='middle' 
                class='chart-axis-text'
            >
                {$xLabels[$i]}
            </text>
        ";
    }
    
    return "
        <div class='native-chart-container {$themeClass}'>
            <h3 class='chart-title'>{$title}</h3>
            <div class='chart-legend'>
                {$legends}
            </div>
            <div style='position: relative;'>
                <svg class='svg-chart' viewBox='0 0 {$width} {$height}' id='{$chartId}'>
                    <!-- Grid y ejes Y -->
                    {$yAxis}
                    
                    <!-- Barras -->
                    {$bars}
                    
                    <!-- Eje X -->
                    {$xAxis}
                </svg>
                <div id='tooltip-{$chartId}' class='chart-tooltip'></div>
            </div>
        </div>
        
        <script>
        (function() {
            const svg = document.getElementById('{$chartId}');
            const tooltip = document.getElementById('tooltip-{$chartId}');
            const bars = svg.querySelectorAll('.bar-rect');
            
            bars.forEach(bar => {
                bar.addEventListener('mouseenter', function(e) {
                    const value = this.getAttribute('data-value');
                    const label = this.getAttribute('data-label');
                    tooltip.innerHTML = label + ': $' + parseInt(value).toLocaleString();
                    tooltip.classList.add('show');
                });
                
                bar.addEventListener('mousemove', function(e) {
                    const rect = svg.getBoundingClientRect();
                    tooltip.style.left = (e.clientX - rect.left + 10) + 'px';
                    tooltip.style.top = (e.clientY - rect.top - 10) + 'px';
                });
                
                bar.addEventListener('mouseleave', function() {
                    tooltip.classList.remove('show');
                });
            });
        })();
        </script>
    ";
}
?>