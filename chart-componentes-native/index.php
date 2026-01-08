<?php
require_once 'NativeChartComponents.php';
NativeChartComponents::init();

// Configurar tema
$theme = isset($_GET['theme']) ? $_GET['theme'] : 'light';
$themeToggle = $theme === 'light' ? 'dark' : 'light';

// Obtener datos de ejemplo
$sampleData = NativeChartComponents::getSampleData();

$content = "
<div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;'>
    <h1 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; font-size: 32px; font-weight: 700;'>
        Native Chart Components Demo
    </h1>
    <a href='?theme={$themeToggle}' style='
        padding: 12px 24px; 
        background: " . ($theme === 'dark' ? '#3B82F6' : '#2563EB') . "; 
        color: white; 
        text-decoration: none; 
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    '>
        Cambiar a tema " . ($themeToggle === 'light' ? 'claro' : 'oscuro') . "
    </a>
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    🎨 Paleta de Colores
</h2>
<div class='grid grid-2'>
    " . NativeChartComponents::colorPalette('light') . "
    " . NativeChartComponents::colorPalette('dark') . "
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    📊 Componentes de Texto y Métricas
</h2>
<div class='grid grid-4'>
    " . NativeChartComponents::textCard('Chart title', 'h1-left-alignment', 'left', 'pink', $theme) . "
    " . NativeChartComponents::largeNumberCard('123', 'Large numbers<br>use for numbers inside donut charts', $theme) . "
    " . NativeChartComponents::textCard('Chart title', 'h2-left-alignment', 'left', 'pink', $theme) . "
    " . NativeChartComponents::textCard('Chart title', 'h2-center-alignment', 'center', 'pink', $theme) . "
</div>

<div class='grid grid-4' style='margin-top: 20px;'>
    " . NativeChartComponents::textCard('Chart title', 'h3-left-alignment<br>Here go numbers XX of total XX<br>Point 01 (Legend)', 'left', 'pink', $theme) . "
    " . NativeChartComponents::textCard('Chart title', 'h3-center-alignment<br>Here go numbers XX of total XX', 'center', 'pink', $theme) . "
    " . NativeChartComponents::valueCard('742', 'additional text', 'h4-left-alignment<br>use for numbers in tooltips', 'left', $theme) . "
    " . NativeChartComponents::valueCard('26%', '', 'h4-center-alignment<br>use for numbers in tooltips', 'center', $theme) . "
</div>

<div class='grid grid-4' style='margin-top: 20px;'>
    " . NativeChartComponents::valueCard('742', 'additional text', 'Tooltip-text<br>use for text in tooltips', 'left', $theme) . "
    " . NativeChartComponents::textCard('742', 'Bar values', 'left', '', $theme) . "
    " . NativeChartComponents::textCard('Jan Feb Mar', 'x-axis', 'left', 'pink', $theme) . "
    " . NativeChartComponents::textCard('Jan Feb Mar', 'x-axis-bold', 'left', 'pink', $theme) . "
</div>

<div class='grid grid-2' style='margin-top: 20px;'>
    " . NativeChartComponents::textCard('750', 'y-axis', 'left', 'pink', $theme) . "
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    📈 Gráficos de Barras
</h2>
<div class='grid grid-2'>
    " . NativeChartComponents::barChart($sampleData['barData'], ['Point 01', 'Point 02'], 'Chart title goes here', 'light') . "
    " . NativeChartComponents::barChart($sampleData['barData'], ['Point 01', 'Point 02'], 'Chart title goes here', 'dark') . "
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    📊 Barras de Progreso - Tema Claro
</h2>
<div class='grid grid-3'>
    " . NativeChartComponents::multiProgressCard('Challenge 01', $sampleData['progressData'], 'light') . "
    " . NativeChartComponents::singleProgressCard('Challenge 01', 'Here go numbers XX of total XX', 35, 'light') . "
    " . NativeChartComponents::iconProgressCard('Category', '7.2h of 8h', '7.2h of 8h', '🌙', 'light') . "
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    📊 Barras de Progreso - Tema Oscuro
</h2>
<div class='grid grid-3'>
    " . NativeChartComponents::multiProgressCard('Challenge 01', $sampleData['progressData'], 'dark') . "
    " . NativeChartComponents::singleProgressCard('Challenge 01', 'Here go numbers XX of total XX', 35, 'dark') . "
    " . NativeChartComponents::iconProgressCard('Category', '7.2h of 8h', '7.2h of 8h', '🌙', 'dark') . "
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    📈 Gráficos de Línea - Tema Claro
</h2>
<div class='grid grid-4'>
    " . NativeChartComponents::lineChartWithAnnotation(
        [array_slice($sampleData['lineData'][0], 0, 6)], 
        ['Data'], 
        'Chart title goes here', 
        '15 April - 21 April',
        ['value' => '489', 'label' => 'additional text'], 
        'light'
    ) . "
    " . NativeChartComponents::lineChart(
        [array_slice($sampleData['lineData'][1], 0, 6)], 
        ['Data'], 
        'Chart title goes here', 
        '15 April - 21 April', 
        'smooth', 
        'light'
    ) . "
    " . NativeChartComponents::lineChart(
        [array_slice($sampleData['lineData'][1], 0, 6), array_slice($sampleData['lineData'][2], 0, 6)], 
        ['Line 1', 'Line 2'], 
        'Chart title goes here', 
        '15 April - 21 April', 
        'line', 
        'light'
    ) . "
    " . NativeChartComponents::lineChart(
        [array_slice($sampleData['lineData'][0], 0, 6), array_slice($sampleData['lineData'][1], 0, 6), array_slice($sampleData['lineData'][2], 0, 6)], 
        ['Point 1', 'Point 2', 'Point 3'], 
        'Chart title goes here', 
        '15 April - 21 April', 
        'line', 
        'light'
    ) . "
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    📈 Gráficos de Línea - Tema Oscuro
</h2>
<div class='grid grid-4'>
    " . NativeChartComponents::lineChartWithAnnotation(
        [array_slice($sampleData['lineData'][0], 0, 6)], 
        ['Data'], 
        'Chart title goes here', 
        '15 April - 21 April',
        ['value' => '202', 'label' => 'additional text'], 
        'dark'
    ) . "
    " . NativeChartComponents::lineChart(
        [array_slice($sampleData['lineData'][1], 0, 6)], 
        ['Data'], 
        'Chart title goes here', 
        '15 April - 21 April', 
        'smooth', 
        'dark'
    ) . "
    " . NativeChartComponents::lineChart(
        [array_slice($sampleData['lineData'][1], 0, 6), array_slice($sampleData['lineData'][2], 0, 6)], 
        ['Line 1', 'Line 2'], 
        'Chart title goes here', 
        '15 April - 21 April', 
        'line', 
        'dark'
    ) . "
    " . NativeChartComponents::lineChart(
        [array_slice($sampleData['lineData'][0], 0, 6), array_slice($sampleData['lineData'][1], 0, 6), array_slice($sampleData['lineData'][2], 0, 6)], 
        ['Point 1', 'Point 2', 'Point 3'], 
        'Chart title goes here', 
        '15 April - 21 April', 
        'line', 
        'dark'
    ) . "
</div>

<div style='
    margin: 60px 0 40px 0; 
    padding: 24px; 
    background: " . ($theme === 'dark' ? 'rgba(59, 130, 246, 0.1)' : 'rgba(37, 99, 235, 0.1)') . "; 
    border-radius: 12px; 
    border-left: 4px solid " . ($theme === 'dark' ? '#3B82F6' : '#2563EB') . ";
'>
    <h3 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin-bottom: 16px; font-size: 20px; font-weight: 600;'>
        ✨ Componentes Nativos
    </h3>
    <div style='color: " . ($theme === 'dark' ? '#9CA3AF' : '#6B7280') . "; line-height: 1.7; margin-bottom: 16px;'>
        <p style='margin-bottom: 12px;'>
            <strong>🚀 100% Nativo:</strong> Usando solo SVG, CSS y PHP - sin dependencias externas.
        </p>
        <p style='margin-bottom: 12px;'>
            <strong>🎨 Diseño Consistente:</strong> Colores y estilos optimizados para mejor apariencia visual.
        </p>
        <p style='margin-bottom: 12px;'>
            <strong>🔧 Componentes Reutilizables:</strong> Fáciles de integrar y personalizar.
        </p>
    </div>
    
    <h4 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 20px 0 12px 0; font-size: 16px; font-weight: 600;'>
        Uso Básico:
    </h4>
    <div style='
        background: " . ($theme === 'dark' ? '#1F2937' : '#F8FAFC') . "; 
        padding: 16px; 
        border-radius: 8px; 
        font-family: \"Courier New\", monospace; 
        font-size: 14px;
        color: " . ($theme === 'dark' ? '#E5E7EB' : '#374151') . ";
        line-height: 1.4;
    '>
require_once 'NativeChartComponents.php';<br>
NativeChartComponents::init();<br><br>

// Gráfico de barras nativo<br>
\$data = [[30000, 50000, 70000], [20000, 40000, 50000]];<br>
echo NativeChartComponents::barChart(\$data, ['Serie 1', 'Serie 2']);<br><br>

// Métrica simple<br>
echo NativeChartComponents::metricCard('Usuarios', '1,247', 'Total');
    </div>
</div>
";

// Renderizar página completa
echo NativeChartComponents::renderComplete($content, 'Native Chart Components', $theme);
?>