<?php
// Componente de barras de progreso
function progressBar($label, $value, $total = 100, $color = 'primary', $theme = 'light') {
    $themeClass = $theme === 'dark' ? 'theme-dark' : 'theme-light';
    $percentage = ($value / $total) * 100;
    $progressClass = 'progress-' . $color;
    
    return "
    <div class='progress-container'>
        <div class='progress-label'>
            <span>{$label}</span>
            <span>{$percentage}%</span>
        </div>
        <div class='progress-bar-bg {$themeClass}'>
            <div class='progress-bar {$progressClass}' style='width: {$percentage}%'></div>
        </div>
    </div>";
}

function multiProgressCard($title, $progressItems, $theme = 'light', $size = 'auto') {
    $themeClass = $theme === 'dark' ? 'theme-dark' : 'theme-light';
    $sizeClass = $size !== 'auto' ? 'size-' . $size : '';
    
    $progressBars = '';
    foreach ($progressItems as $item) {
        $progressBars .= progressBar(
            $item['label'], 
            $item['value'], 
            $item['total'] ?? 100, 
            $item['color'] ?? 'primary', 
            $theme
        );
    }
    
    return "
    <div class='chart-container progress-style-multi {$sizeClass} {$themeClass}'>
        <h3 class='chart-title'>{$title}</h3>
        {$progressBars}
    </div>";
}

function singleProgressCard($title, $subtitle, $percentage, $theme = 'light', $size = 'auto') {
    $themeClass = $theme === 'dark' ? 'theme-dark' : 'theme-light';
    $sizeClass = $size !== 'auto' ? 'size-' . $size : '';
    
    return "
    <div class='chart-container progress-style-single {$sizeClass} {$themeClass}'>
        <h3 class='chart-title'>{$title}</h3>
        <div class='chart-subtitle'>{$subtitle}</div>
        <div class='progress-container' style='margin-top: 20px;'>
            <div class='progress-bar-bg {$themeClass}'>
                <div class='progress-bar progress-primary' style='width: {$percentage}%'></div>
            </div>
            <div class='progress-label' style='margin-top: 8px; justify-content: flex-end;'>
                <span style='font-size: 18px; font-weight: 600;'>{$percentage}%</span>
            </div>
        </div>
    </div>";
}

function iconProgressCard($title, $subtitle, $time, $icon = '🌙', $theme = 'light', $size = 'auto') {
    $themeClass = $theme === 'dark' ? 'theme-dark' : 'theme-light';
    $sizeClass = $size !== 'auto' ? 'size-' . $size : '';
    
    return "
    <div class='chart-container progress-style-compact {$sizeClass} {$themeClass}' style='display: flex; flex-direction: column; justify-content: space-between;'>
        <div style='display: flex; align-items: center; gap: 12px;'>
            <span style='font-size: 24px;'>{$icon}</span>
            <div>
                <h3 class='chart-title' style='margin: 0;'>{$title}</h3>
                <div class='chart-subtitle' style='margin: 4px 0 0 0;'>{$subtitle}</div>
            </div>
        </div>
        <div style='margin-top: 16px;'>
            <div class='progress-bar-bg {$themeClass}'>
                <div class='progress-bar progress-primary' style='width: 75%'></div>
            </div>
        </div>
    </div>";
}
?>