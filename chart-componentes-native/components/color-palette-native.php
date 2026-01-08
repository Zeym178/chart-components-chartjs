<?php
// Componente de paleta de colores

function nativeColorPalette($theme = 'light') {
    $themeClass = $theme === 'dark' ? 'dark' : '';
    
    return "
        <div class='native-chart-container {$themeClass}'>
            <div class='color-palette'>
                <div class='color-box color-blue'></div>
                <div class='color-box color-red'></div>
                <div class='color-box color-cyan'></div>
                <div class='color-box color-gray'></div>
                <div class='color-box color-white'></div>
            </div>
        </div>
    ";
}
?>