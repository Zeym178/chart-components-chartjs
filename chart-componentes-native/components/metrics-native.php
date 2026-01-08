<?php
// Componentes de métricas y números

function nativeMetricCard($title, $value, $subtitle = '', $alignment = 'left', $theme = 'light', $size = 'auto') {
    $themeClass = $theme === 'dark' ? 'dark' : '';
    $alignmentClass = $alignment === 'center' ? 'center' : '';
    $sizeClass = $size !== 'auto' ? 'size-' . $size : '';
    
    return "
        <div class='native-chart-container {$themeClass} metric-card {$alignmentClass} {$sizeClass}'>
            <div class='chart-subtitle'>{$subtitle}</div>
            <h3 class='chart-title'>{$title}</h3>
            <div class='metric-value'>{$value}</div>
        </div>
    ";
}

// Función para crear un contenedor flexible de métricas
function nativeMetricsContainer($metrics, $layout = 'flex') {
    $containerClass = $layout === 'grid' ? 'grid grid-4' : 'metrics-flex';
    $output = "<div class='{$containerClass}'>";
    foreach ($metrics as $metric) {
        $output .= $metric;
    }
    $output .= "</div>";
    return $output;
}

function nativeLargeNumberCard($number, $label = '', $theme = 'light') {
    $themeClass = $theme === 'dark' ? 'dark' : '';
    
    return "
        <div class='native-chart-container {$themeClass} metric-card center'>
            <div class='chart-subtitle'>{$label}</div>
            <div class='large-number'>{$number}</div>
        </div>
    ";
}

// Componente específico para mostrar texto con colores de alineación (como en las imágenes)
function nativeTextCard($title, $subtitle, $alignment = 'left', $color = '', $theme = 'light') {
    $themeClass = $theme === 'dark' ? 'dark' : '';
    $alignmentClass = $alignment === 'center' ? 'center' : '';
    
    $colorStyle = '';
    if ($color) {
        $colorMap = [
            'pink' => '#EC4899',
            'blue' => '#3B82F6', 
            'green' => '#10B981',
            'purple' => '#8B5CF6'
        ];
        $colorStyle = isset($colorMap[$color]) ? "color: {$colorMap[$color]};" : '';
    }
    
    return "
        <div class='native-chart-container {$themeClass} metric-card {$alignmentClass}'>
            <div class='chart-subtitle' style='{$colorStyle}'>{$subtitle}</div>
            <h3 class='chart-title'>{$title}</h3>
        </div>
    ";
}

// Componente para mostrar valores con unidades (como '742 additional text')
function nativeValueCard($value, $unit, $description, $alignment = 'left', $theme = 'light') {
    $themeClass = $theme === 'dark' ? 'dark' : '';
    $alignmentClass = $alignment === 'center' ? 'center' : '';
    
    return "
        <div class='native-chart-container {$themeClass} metric-card {$alignmentClass}'>
            <div class='chart-subtitle'>{$description}</div>
            <div class='metric-value'>{$value} <span style='font-size: 0.7em; font-weight: normal;'>{$unit}</span></div>
        </div>
    ";
}
?>