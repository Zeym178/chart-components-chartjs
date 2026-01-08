<?php
// Componente de barras de progreso

function nativeProgressBar($label, $value, $total = 100, $color = 'blue', $theme = 'light') {
    $percentage = ($value / $total) * 100;
    $themeClass = $theme === 'dark' ? 'dark' : '';
    $colorClass = 'progress-' . $color;
    
    return "
        <div class='progress-container'>
            <div class='progress-label'>
                <span>{$label}</span>
                <span>{$percentage}%</span>
            </div>
            <div class='progress-track {$themeClass}'>
                <div class='progress-fill {$colorClass}' style='width: {$percentage}%'></div>
            </div>
        </div>
    ";
}

function nativeMultiProgressCard($title, $progressItems, $theme = 'light', $size = 'auto') {
    $themeClass = $theme === 'dark' ? 'dark' : '';
    $sizeClass = $size !== 'auto' ? 'size-' . $size : '';
    
    $progressBars = '';
    foreach ($progressItems as $item) {
        $progressBars .= nativeProgressBar(
            $item['label'], 
            $item['value'], 
            $item['total'] ?? 100, 
            $item['color'] ?? 'blue', 
            $theme
        );
    }
    
    return "
        <div class='native-chart-container progress-style-multi {$sizeClass} {$themeClass}'>
            <h3 class='chart-title'>{$title}</h3>
            {$progressBars}
        </div>
    ";
}

function nativeSingleProgressCard($title, $subtitle, $percentage, $theme = 'light', $size = 'auto') {
    $themeClass = $theme === 'dark' ? 'dark' : '';
    $sizeClass = $size !== 'auto' ? 'size-' . $size : '';
    
    return "
        <div class='native-chart-container progress-style-single {$sizeClass} {$themeClass}'>
            <h3 class='chart-title'>{$title}</h3>
            <div class='chart-subtitle'>{$subtitle}</div>
            <div style='margin-top: 20px; margin-bottom: 16px;'>
                <div class='progress-track {$themeClass}'>
                    <div class='progress-fill progress-blue' style='width: {$percentage}%'></div>
                </div>
            </div>
            <div style='text-align: right; font-size: 18px; font-weight: 600; color: " . 
                ($theme === 'dark' ? 'var(--text-dark)' : 'var(--text-light)') . ";'>
                {$percentage}%
            </div>
        </div>
    ";
}

function nativeIconProgressCard($title, $subtitle, $time, $icon = '🌙', $theme = 'light', $size = 'auto') {
    $themeClass = $theme === 'dark' ? 'dark' : '';
    $sizeClass = $size !== 'auto' ? 'size-' . $size : '';
    
    return "
        <div class='native-chart-container progress-style-compact {$sizeClass} {$themeClass}' style='display: flex; flex-direction: column; justify-content: space-between;'>
            <div style='display: flex; align-items: center; gap: 12px; margin-bottom: 20px;'>
                <span style='font-size: 24px;'>{$icon}</span>
                <div>
                    <h3 class='chart-title' style='margin: 0;'>{$title}</h3>
                    <div class='chart-subtitle' style='margin: 4px 0 0 0;'>{$subtitle}</div>
                </div>
            </div>
            <div>
                <div class='progress-track {$themeClass}' style='margin-bottom: 8px;'>
                    <div class='progress-fill progress-blue' style='width: 75%'></div>
                </div>
            </div>
        </div>
    ";
}

// Componente de progreso circular (como aparece en algunas imágenes)
function nativeCircularProgress($percentage, $size = 80, $theme = 'light') {
    $radius = ($size - 8) / 2;
    $circumference = 2 * pi() * $radius;
    $strokeDasharray = $circumference;
    $strokeDashoffset = $circumference - ($percentage / 100) * $circumference;
    
    $color = $theme === 'dark' ? '#3B82F6' : '#2563EB';
    $bgColor = $theme === 'dark' ? '#4B5563' : '#E5E7EB';
    
    return "
        <div style='position: relative; display: inline-block;'>
            <svg width='{$size}' height='{$size}' style='transform: rotate(-90deg);'>
                <circle
                    cx='" . ($size / 2) . "'
                    cy='" . ($size / 2) . "'
                    r='{$radius}'
                    stroke='{$bgColor}'
                    stroke-width='8'
                    fill='none'
                />
                <circle
                    cx='" . ($size / 2) . "'
                    cy='" . ($size / 2) . "'
                    r='{$radius}'
                    stroke='{$color}'
                    stroke-width='8'
                    fill='none'
                    stroke-linecap='round'
                    stroke-dasharray='{$strokeDasharray}'
                    stroke-dashoffset='{$strokeDashoffset}'
                    style='transition: stroke-dashoffset 0.5s ease;'
                />
            </svg>
            <div style='
                position: absolute; 
                top: 50%; 
                left: 50%; 
                transform: translate(-50%, -50%);
                font-size: 14px;
                font-weight: 600;
                color: " . ($theme === 'dark' ? 'var(--text-dark)' : 'var(--text-light)') . ";
            '>
                {$percentage}%
            </div>
        </div>
    ";
}
?>