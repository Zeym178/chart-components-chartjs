<?php
// Componente de paleta de colores
function colorPalette($theme = 'light') {
    $themeClass = $theme === 'dark' ? 'theme-dark' : 'theme-light';
    $themeName = $theme === 'dark' ? 'Oscuro' : 'Claro';
    
    return "
    <div class='chart-container {$themeClass}'>
        <h3 class='chart-title'>Tema {$themeName}</h3>
        <div class='color-palette'>
            <div class='color-box' style='background: rgba(20, 122, 214, 1);' title='Azul Mate'></div>
            <div class='color-box' style='background: rgba(236, 102, 102, 1);' title='Rojo Coral Mate'></div>
            <div class='color-box' style='background: rgba(121, 210, 222, 1);' title='Verde Azulado Mate'></div>
            <div class='color-box' style='background: rgba(115, 136, 169, 0.3533);' title='Gris Mate'></div>
            <div class='color-box' style='background: " . ($theme === 'dark' ? 'rgba(51, 51, 64, 1)' : 'rgba(255, 255, 255, 1)') . "; border: 1px solid rgba(115, 136, 169, 0.3533);' title='Fondo'></div>
        </div>
        <div style='margin-top: 16px; font-size: 12px; color: " . ($theme === 'dark' ? '#9CA3AF' : '#6B7280') . ";'>
            Paleta de colores del tema
        </div>
    </div>";
}
?>