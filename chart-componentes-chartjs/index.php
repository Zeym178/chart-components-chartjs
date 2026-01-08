<?php
require_once 'ChartComponents.php';
ChartComponents::init();

// Configurar tema
$theme = isset($_GET['theme']) ? $_GET['theme'] : 'light';
$themeToggle = $theme === 'light' ? 'dark' : 'light';

// Datos de ejemplo
$sampleBarData = [
    [30000, 50000, 70000, 40000, 60000, 65000], // Point 01
    [20000, 40000, 50000, 35000, 45000, 55000]  // Point 02
];

$sampleLineData = [
    [350, 450, 200, 350, 480, 230], // Area chart data
    [250, 400, 300, 200, 350, 400], // Line 1
    [150, 250, 400, 300, 250, 350]  // Line 2
];

$progressData = [
    ['label' => 'XX of total XX', 'value' => 25, 'total' => 100, 'color' => 'primary'],
    ['label' => 'XX of total XX', 'value' => 65, 'total' => 100, 'color' => 'secondary'], 
    ['label' => 'XX of total XX', 'value' => 45, 'total' => 100, 'color' => 'success']
];

$content = "
<div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;'>
    <h1 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; font-size: 32px; font-weight: 700;'>
        Chart.js Components Demo
    </h1>
    <a href='?theme={$themeToggle}' style='
        padding: 12px 24px; 
        background: rgba(20, 122, 214, 1); 
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
    " . ChartComponents::colorPalette('light') . "
    " . ChartComponents::colorPalette('dark') . "
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    📊 Componentes de Texto y Métricas
</h2>
<div class='grid grid-4'>
    " . ChartComponents::metricCard('Chart title', '', 'h1-left-alignment', 'left', $theme) . "
    " . ChartComponents::largeNumberCard('123', 'Large numbers<br>use for numbers inside donut charts', $theme) . "
    " . ChartComponents::metricCard('Chart title', '', 'h2-left-alignment', 'left', $theme) . "
    " . ChartComponents::metricCard('Chart title', '', 'h2-center-alignment', 'center', $theme) . "
</div>

<div class='grid grid-4' style='margin-top: 20px;'>
    " . ChartComponents::metricCard('Chart title', '', 'h3-left-alignment<br>Here go numbers XX of total XX<br>Point 01 (Legend)', 'left', $theme) . "
    " . ChartComponents::metricCard('Chart title', '', 'h3-center-alignment<br>Here go numbers XX of total XX', 'center', $theme) . "
    " . ChartComponents::metricCard('742', 'additional text', 'h4-left-alignment<br>use for numbers in tooltips', 'left', $theme) . "
    " . ChartComponents::metricCard('26%', '', 'h4-center-alignment<br>use for numbers in tooltips', 'center', $theme) . "
</div>

<div class='grid grid-4' style='margin-top: 20px;'>
    " . ChartComponents::metricCard('742', 'additional text', 'Tooltip-text<br>use for text in tooltips', 'left', $theme) . "
    " . ChartComponents::metricCard('742', '', 'Bar values', 'left', $theme) . "
    " . ChartComponents::metricCard('Jan Feb Mar', '', 'x-axis', 'left', $theme) . "
    " . ChartComponents::metricCard('Jan Feb Mar', '', 'x-axis-bold', 'left', $theme) . "
</div>

<div class='grid grid-2' style='margin-top: 20px;'>
    " . ChartComponents::metricCard('750', '', 'y-axis', 'left', $theme) . "
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    📈 Gráficos de Barras
</h2>
<div class='grid grid-2'>
    " . ChartComponents::barChart($sampleBarData, ['Point 01', 'Point 02'], 'Chart title goes here', 'light') . "
    " . ChartComponents::barChart($sampleBarData, ['Point 01', 'Point 02'], 'Chart title goes here', 'dark') . "
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    📊 Barras de Progreso
</h2>
<div class='grid grid-3'>
    " . ChartComponents::multiProgressCard('Challenge 01', $progressData, $theme) . "
    " . ChartComponents::singleProgressCard('Challenge 01', 'Here go numbers XX of total XX', 35, $theme) . "
    " . ChartComponents::iconProgressCard('Category', '7.2h of 8h', '7.2h of 8h', '🌙', $theme) . "
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    📈 Gráficos de Línea
</h2>
<div class='grid grid-4'>
    " . ChartComponents::lineChartWithAnnotation(
        [array_slice($sampleLineData[0], 0, 6)], 
        ['Data'], 
        'Chart title goes here', 
        '15 April - 21 April',
        ['value' => '489', 'label' => 'additional text'], 
        $theme
    ) . "
    " . ChartComponents::smoothLineChart(
        [array_slice($sampleLineData[1], 0, 6)], 
        ['Data'], 
        'Chart title goes here', 
        '15 April - 21 April', 
        $theme
    ) . "
    " . ChartComponents::lineChart(
        [array_slice($sampleLineData[1], 0, 6), array_slice($sampleLineData[2], 0, 6)], 
        ['Line 1', 'Line 2'], 
        'Chart title goes here', 
        '15 April - 21 April', 
        'line', 
        $theme
    ) . "
    " . ChartComponents::lineChart(
        [array_slice($sampleLineData[0], 0, 6), array_slice($sampleLineData[1], 0, 6), array_slice($sampleLineData[2], 0, 6)], 
        ['Point 1', 'Point 2', 'Point 3'], 
        'Chart title goes here', 
        '15 April - 21 April', 
        'line', 
        $theme
    ) . "
</div>

<div style='
    margin: 60px 0 40px 0; 
    padding: 24px; 
    background: " . ($theme === 'dark' ? 'rgba(20, 122, 214, 0.1)' : 'rgba(20, 122, 214, 0.1)') . "; 
    border-radius: 12px; 
    border-left: 4px solid rgba(20, 122, 214, 1);
'>
    <h3 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin-bottom: 16px; font-size: 20px; font-weight: 600;'>
        📊 Componentes Chart.js
    </h3>
    <div style='color: " . ($theme === 'dark' ? '#9CA3AF' : '#6B7280') . "; line-height: 1.7; margin-bottom: 16px;'>
        <p style='margin-bottom: 12px;'>
            <strong>🎨 Diseño Moderno:</strong> Componentes con estilos optimizados y colores consistentes.
        </p>
        <p style='margin-bottom: 12px;'>
            <strong>📊 Chart.js:</strong> Usando Chart.js con configuraciones personalizadas.
        </p>
        <p style='margin-bottom: 12px;'>
            <strong>🌌 Temas Duales:</strong> Soporte completo para temas claro y oscuro.
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
require_once 'ChartComponents.php';<br>
ChartComponents::init();<br><br>

// Gráfico de barras con Chart.js<br>
\$data = [[30000, 50000, 70000], [20000, 40000, 50000]];<br>
echo ChartComponents::barChart(\$data, ['Serie 1', 'Serie 2']);<br><br>

// Métrica simple<br>
echo ChartComponents::metricCard('Usuarios', '1,247', 'Total');
    </div>
</div>

<!-- ******************** MARSHALL COMPONENTS SECTION ******************** -->

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 60px 0 20px 0; font-size: 24px; font-weight: 600; border-top: 3px solid rgba(20, 122, 214, 1); padding-top: 20px;'>
    🍩 Gráficos de Dona
</h2>
<div class='grid grid-3'>
    " . ChartComponents::donutChart3Categories([
        ['label' => 'Long category label 01', 'value' => 55, 'color' => '#1976D2'],
        ['label' => 'Long category label 02', 'value' => 25, 'color' => '#80DEEA'],
        ['label' => 'Long category label 03', 'value' => 20, 'color' => '#EF5350']
    ], 'Chart title goes here', $theme) . "
    " . ChartComponents::ringChart4Categories([
        ['label' => 'Point 01', 'value' => 76, 'color' => '#1976D2'],
        ['label' => 'Point 02', 'value' => 15, 'color' => '#80DEEA'],
        ['label' => 'Point 03', 'value' => 9, 'color' => '#EF5350']
    ], 'Chart title goes here', 76, $theme) . "
    " . ChartComponents::challengeList([
        ['id' => 'ch_01', 'percent' => 76, 'title' => 'Challenge 01', 'subtitle' => 'XX of total XX', 'color' => '#1976D2'],
        ['id' => 'ch_02', 'percent' => 54, 'title' => 'Challenge 02', 'subtitle' => 'XX of total XX', 'color' => '#EF5350'],
        ['id' => 'ch_03', 'percent' => 88, 'title' => 'Challenge 03', 'subtitle' => 'XX of total XX', 'color' => '#80DEEA']
    ], $theme) . "
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    🎠 Componentes Carousel
</h2>
<div class='grid grid-3'>
    " . ChartComponents::carouselChart('Chart title', 'Here go numbers XX of total XX', 76, '#1976D2', 1, $theme) . "
    " . ChartComponents::carouselChart('Chart title', 'Here go numbers XX of total XX', 76, '#EF5350', 2, $theme) . "
    " . ChartComponents::carouselChart('Chart title', 'Here go numbers XX of total XX', 76, '#80DEEA', 3, $theme) . "
</div>

<h2 style='color: " . ($theme === 'dark' ? '#F9FAFB' : '#1F2937') . "; margin: 40px 0 20px 0; font-size: 24px; font-weight: 600;'>
    📏 Tarjetas Compactas
</h2>
<div class='grid grid-4'>
    " . ChartComponents::compactStatCard('354', 'Category', 75, '#1976D2', $theme) . "
    " . ChartComponents::horizontalCard('Challenge 01', 'XX of total XX', 76, '#1976D2', $theme) . "
    " . ChartComponents::horizontalCard('Challenge 02', 'XX of total XX', 50, '#EF5350', $theme) . "
    " . ChartComponents::compactStatCard('742', 'Category', 85, '#80DEEA', $theme) . "
</div>

<!-- ********************************************************************** -->";

// Renderizar página completa
echo ChartComponents::renderComplete($content, 'Chart.js Components', $theme);
?>