<?php
// Componente de métricas y números grandes
function metricCard($title, $value, $subtitle = '', $alignment = 'left', $theme = 'light', $size = 'auto') {
    $themeClass = $theme === 'dark' ? 'theme-dark' : 'theme-light';
    $alignClass = $alignment === 'center' ? 'text-align: center;' : 'text-align: left;';
    $sizeClass = $size !== 'auto' ? 'size-' . $size : '';
    
    return "
    <div class='chart-container {$themeClass} metric-card {$sizeClass}' style='{$alignClass}'>
        <div class='chart-subtitle'>{$subtitle}</div>
        <div class='chart-title'>{$title}</div>
        " . ($value ? "<div class='metric-value'>{$value}</div>" : "") . "
    </div>";
}

function largeNumberCard($number, $label = '', $theme = 'light', $size = 'auto') {
    $themeClass = $theme === 'dark' ? 'theme-dark' : 'theme-light';
    $sizeClass = $size !== 'auto' ? 'size-' . $size : '';
    
    return "
    <div class='chart-container {$themeClass} metric-card {$sizeClass}' style='text-align: center;'>
        <div class='chart-subtitle'>{$label}</div>
        <div class='large-number'>{$number}</div>
    </div>";
}

// Función para crear un contenedor flexible de métricas
function metricsContainer($metrics, $layout = 'flex') {
    $containerClass = $layout === 'grid' ? 'grid grid-4' : 'metrics-flex';
    $output = "<div class='{$containerClass}'>";
    foreach ($metrics as $metric) {
        $output .= $metric;
    }
    $output .= "</div>";
    return $output;
}
?>