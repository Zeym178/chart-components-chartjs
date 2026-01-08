<?php
// Componentes de gráficos de línea con SVG

// Función para crear curvas suaves Catmull-Rom
function createSmoothPath($points) {
    if (count($points) < 2) return '';
    if (count($points) === 2) return "M {$points[0]['x']} {$points[0]['y']} L {$points[1]['x']} {$points[1]['y']}";
    
    $path = "M {$points[0]['x']} {$points[0]['y']}";
    
    for ($i = 1; $i < count($points); $i++) {
        if ($i === 1) {
            // Primera curva
            $cp1x = $points[0]['x'] + ($points[1]['x'] - $points[0]['x']) * 0.3;
            $cp1y = $points[0]['y'] + ($points[1]['y'] - $points[0]['y']) * 0.3;
            $cp2x = $points[1]['x'] - ($points[1]['x'] - $points[0]['x']) * 0.3;
            $cp2y = $points[1]['y'] - ($points[1]['y'] - $points[0]['y']) * 0.3;
            $path .= " C {$cp1x} {$cp1y}, {$cp2x} {$cp2y}, {$points[1]['x']} {$points[1]['y']}";
        } else {
            // Curvas intermedias
            $prevPoint = $points[$i - 2] ?? $points[$i - 1];
            $nextPoint = $points[$i + 1] ?? $points[$i];
            
            $cp1x = $points[$i - 1]['x'] + (($points[$i]['x'] - $prevPoint['x']) * 0.25);
            $cp1y = $points[$i - 1]['y'] + (($points[$i]['y'] - $prevPoint['y']) * 0.25);
            $cp2x = $points[$i]['x'] - (($nextPoint['x'] - $points[$i - 1]['x']) * 0.25);
            $cp2y = $points[$i]['y'] - (($nextPoint['y'] - $points[$i - 1]['y']) * 0.25);
            
            $path .= " C {$cp1x} {$cp1y}, {$cp2x} {$cp2y}, {$points[$i]['x']} {$points[$i]['y']}";
        }
    }
    
    return $path;
}

function nativeLineChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '', $type = 'line', $theme = 'light') {
    $chartId = 'lineChart_' . uniqid();
    $themeClass = $theme === 'dark' ? 'dark' : '';
    
    // Configuración del gráfico
    $width = 400;
    $height = 250;
    $padding = [40, 40, 60, 60]; // top, right, bottom, left
    $chartWidth = $width - $padding[1] - $padding[3];
    $chartHeight = $height - $padding[0] - $padding[2];
    
    // Colores del tema
    $colors = [
        'rgba(20, 122, 214, 1)',     // Azul
        'rgba(236, 102, 102, 1)',    // Rojo coral
        'rgba(121, 210, 222, 1)'     // Verde azulado
    ];
    
    // Etiquetas del eje X
    $xLabels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'];
    
    // Calcular el máximo valor para escalar
    $maxValue = 0;
    $minValue = PHP_INT_MAX;
    foreach ($data as $series) {
        $maxValue = max($maxValue, max($series));
        $minValue = min($minValue, min($series));
    }
    
    $range = $maxValue - $minValue;
    $maxValue = $maxValue + ($range * 0.1); // Agregar 10% de padding arriba
    $minValue = max(0, $minValue - ($range * 0.1)); // Agregar 10% de padding abajo, pero no menos que 0
    
    // Generar las líneas y áreas
    $paths = '';
    $points = '';
    $legends = '';
    
    for ($seriesIndex = 0; $seriesIndex < count($data); $seriesIndex++) {
        $series = $data[$seriesIndex];
        $color = $colors[$seriesIndex % count($colors)];
        $label = isset($labels[$seriesIndex]) ? $labels[$seriesIndex] : 'Point ' . sprintf('%02d', $seriesIndex + 1);
        
        // Generar leyenda
        if (count($data) > 1) {
            $colorName = $seriesIndex === 0 ? 'blue' : ($seriesIndex === 1 ? 'red' : 'cyan');
            $legends .= "
                <div class='legend-item'>
                    <div class='legend-dot legend-{$colorName}'></div>
                    <span>{$label}</span>
                </div>";
        }
        
        // Calcular puntos de la línea
        $pathData = [];
        $pointsData = [];
        
        for ($i = 0; $i < count($series); $i++) {
            $value = $series[$i];
            $x = $padding[3] + ($i / (count($series) - 1)) * $chartWidth;
            $y = $padding[0] + $chartHeight - (($value - $minValue) / ($maxValue - $minValue)) * $chartHeight;
            
            $pointsData[] = ['x' => $x, 'y' => $y, 'value' => $value, 'label' => $xLabels[$i]];
        }
        
        // Crear path suave o lineal
        $pathString = '';
        if ($type === 'smooth' || $type === 'smooth-area' || strpos($type, 'curved') !== false) {
            $pathString = createSmoothPath($pointsData);
        } else {
            $pathData = [];
            for ($i = 0; $i < count($pointsData); $i++) {
                $point = $pointsData[$i];
                $pathData[] = ($i === 0 ? 'M' : 'L') . ' ' . $point['x'] . ' ' . $point['y'];
            }
            $pathString = implode(' ', $pathData);
        }
        
        // Si es tipo área, crear el path cerrado
        if ($type === 'area' || $type === 'smooth-area') {
            $areaPath = $pathString;
            $areaPath .= ' L ' . ($padding[3] + $chartWidth) . ' ' . ($padding[0] + $chartHeight);
            $areaPath .= ' L ' . $padding[3] . ' ' . ($padding[0] + $chartHeight);
            $areaPath .= ' Z';
            
            $paths .= "
                <path 
                    d='{$areaPath}' 
                    fill='{$colors[$seriesIndex]}' 
                    fill-opacity='0.15'
                    stroke='none'
                />
            ";
        }
        
        // Área de separación/selección especial para el primer gráfico
        if ($seriesIndex === 0 && strpos($type, 'highlight') !== false) {
            // Crear área destacada en una sección (por ejemplo entre Mar y Apr)
            $highlightStart = $padding[3] + (2 / (count($series) - 1)) * $chartWidth; // Mar
            $highlightEnd = $padding[3] + (3 / (count($series) - 1)) * $chartWidth;   // Apr
            
            $paths .= "
                <rect 
                    x='{$highlightStart}' 
                    y='{$padding[0]}' 
                    width='" . ($highlightEnd - $highlightStart) . "' 
                    height='{$chartHeight}' 
                    fill='{$colors[$seriesIndex]}' 
                    fill-opacity='0.1'
                    stroke='none'
                />
            ";
        }
        
        // Línea principal
        $strokeWidth = 2;
        
        $paths .= "
            <path 
                d='{$pathString}' 
                fill='none' 
                stroke='{$colors[$seriesIndex]}' 
                stroke-width='{$strokeWidth}' 
                class='line-path'
            />
        ";
        
        // Puntos
        foreach ($pointsData as $pointIndex => $point) {
            // Hacer el punto destacado en área de separación si aplica
            $pointRadius = (strpos($type, 'highlight') !== false && $pointIndex === 2) ? '6' : '4';
            $pointStroke = (strpos($type, 'highlight') !== false && $pointIndex === 2) ? 'stroke="white" stroke-width="2"' : '';
            
            $points .= "
                <circle 
                    cx='{$point['x']}' 
                    cy='{$point['y']}' 
                    r='{$pointRadius}' 
                    fill='{$colors[$seriesIndex]}' 
                    class='chart-point'
                    data-value='{$point['value']}'
                    data-label='{$point['label']}'
                    data-series='{$label}'
                    {$pointStroke}
                />
            ";
        }
    }
    
    // Generar ejes Y
    $yAxis = '';
    $steps = 5;
    for ($i = 0; $i <= $steps; $i++) {
        $value = $minValue + (($maxValue - $minValue) / $steps) * $i;
        $y = $padding[0] + $chartHeight - (($value - $minValue) / ($maxValue - $minValue)) * $chartHeight;
        
        // Línea de grid horizontal
        if ($i > 0 && $i < $steps) {
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
        $displayValue = round($value);
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
        $x = $padding[3] + ($i / (count($xLabels) - 1)) * $chartWidth;
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
    
    $legendHtml = count($data) > 1 ? "<div class='chart-legend'>{$legends}</div>" : '';
    $subtitleHtml = $subtitle ? "<div class='chart-subtitle'>{$subtitle}</div>" : '';
    
    return "
        <div class='native-chart-container {$themeClass}'>
            <h3 class='chart-title'>{$title}</h3>
            {$subtitleHtml}
            {$legendHtml}
            <div style='position: relative;'>
                <svg class='svg-chart-small' viewBox='0 0 {$width} {$height}' id='{$chartId}'>
                    <!-- Grid y ejes Y -->
                    {$yAxis}
                    
                    <!-- Paths (áreas y líneas) -->
                    {$paths}
                    
                    <!-- Puntos -->
                    {$points}
                    
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
            const points = svg.querySelectorAll('.chart-point');
            
            points.forEach(point => {
                point.addEventListener('mouseenter', function(e) {
                    const value = this.getAttribute('data-value');
                    const label = this.getAttribute('data-label');
                    const series = this.getAttribute('data-series');
                    tooltip.innerHTML = series + '<br>' + label + ': ' + value;
                    tooltip.classList.add('show');
                });
                
                point.addEventListener('mousemove', function(e) {
                    const rect = svg.getBoundingClientRect();
                    tooltip.style.left = (e.clientX - rect.left + 10) + 'px';
                    tooltip.style.top = (e.clientY - rect.top - 10) + 'px';
                });
                
                point.addEventListener('mouseleave', function() {
                    tooltip.classList.remove('show');
                });
            });
        })();
        </script>
    ";
}

function nativeAreaChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '', $theme = 'light') {
    return nativeLineChart($data, $labels, $title, $subtitle, 'area', $theme);
}

function nativeSmoothLineChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '', $theme = 'light') {
    return nativeLineChart($data, $labels, $title, $subtitle, 'smooth', $theme);
}

function nativeLineChartWithAnnotation($data, $labels, $title, $subtitle, $annotation, $theme = 'light') {
    $chartHtml = nativeLineChart($data, $labels, $title, $subtitle, 'area', $theme);
    
    // Agregar anotación
    $annotationHtml = "
        <div class='chart-annotation' style='top: 20px; right: 20px;'>
            <strong>{$annotation['value']}</strong> {$annotation['label']}
        </div>
    ";
    
    // Insertar la anotación en el contenedor
    $chartHtml = str_replace(
        "<div style='position: relative;'>", 
        "<div style='position: relative;'>{$annotationHtml}", 
        $chartHtml
    );
    
    return $chartHtml;
}
?>