<?php
/**
 * Ejemplos específicos de uso de los Native Chart Components
 * Componentes 100% nativos sin dependencias externas
 */

require_once 'NativeChartComponents.php';
NativeChartComponents::init();

// ============================================
// EJEMPLO 1: Gráfico de Barras Nativo Exacto
// ============================================

echo "<h2>Ejemplo 1: Gráfico de Barras SVG Nativo</h2>";

// Datos exactos como en las imágenes
\$ventasData = [
    [25000, 35000, 72000, 30000, 52000, 65000], // Point 01 (azul)
    [22000, 45000, 25000, 22000, 45000, 25000]  // Point 02 (rojo)
];

\$ventasLabels = ['Point 01', 'Point 02'];

echo NativeChartComponents::barChart(
    \$ventasData, 
    \$ventasLabels, 
    'Chart title goes here', 
    'light'
);

// ============================================
// EJEMPLO 2: Componentes de Métricas Exactos
// ============================================

echo "<h2>Ejemplo 2: Métricas y Texto (Layout de las Imágenes)</h2>";

echo "<div class='grid grid-4'>";
echo NativeChartComponents::textCard(
    'Chart title', 
    'h1-left-alignment', 
    'left', 
    'pink'
);
echo NativeChartComponents::largeNumberCard(
    '123', 
    'Large numbers<br>use for numbers inside donut charts'
);
echo NativeChartComponents::textCard(
    'Chart title', 
    'h2-center-alignment', 
    'center', 
    'pink'
);
echo NativeChartComponents::valueCard(
    '26%', 
    '', 
    'h4-center-alignment<br>use for numbers in tooltips'
);
echo "</div>";

// ============================================
// EJEMPLO 3: Barras de Progreso Nativas
// ============================================

echo "<h2>Ejemplo 3: Barras de Progreso (CSS Puro)</h2>";

\$proyectosData = [
    ['label' => 'XX of total XX', 'value' => 25, 'color' => 'blue'],
    ['label' => 'XX of total XX', 'value' => 65, 'color' => 'red'],
    ['label' => 'XX of total XX', 'value' => 45, 'color' => 'cyan']
];

echo "<div class='grid grid-3'>";
echo NativeChartComponents::multiProgressCard(
    'Challenge 01', 
    \$proyectosData, 
    'light'
);
echo NativeChartComponents::singleProgressCard(
    'Challenge 01', 
    'Here go numbers XX of total XX', 
    35, 
    'light'
);
echo NativeChartComponents::iconProgressCard(
    'Category', 
    '7.2h of 8h', 
    '7.2h of 8h', 
    '🌙', 
    'light'
);
echo "</div>";

// ============================================
// EJEMPLO 4: Gráficos de Línea SVG Nativos
// ============================================

echo "<h2>Ejemplo 4: Gráficos de Línea (SVG Nativo)</h2>";

\$lineData = [
    [400, 500, 200, 300, 489, 150] // Datos para gráfico con anotación
];

echo "<div class='grid grid-2'>";
// Gráfico con anotación (como en las imágenes)
echo NativeChartComponents::lineChartWithAnnotation(
    \$lineData,
    ['Data'],
    'Chart title goes here',
    '15 April - 21 April',
    ['value' => '489', 'label' => 'additional text'],
    'light'
);

// Gráfico de área simple
echo NativeChartComponents::areaChart(
    [[350, 450, 300, 400, 350, 280]],
    ['Area Data'],
    'Chart title goes here',
    '15 April - 21 April',
    'light'
);
echo "</div>";

// ============================================
// EJEMPLO 5: Comparación Tema Claro vs Oscuro
// ============================================

echo "<h2>Ejemplo 5: Comparación de Temas</h2>";

echo "<div class='grid grid-2'>";
// Tema claro
echo NativeChartComponents::barChart(
    \$ventasData,
    \$ventasLabels,
    'Tema Claro - Chart title goes here',
    'light'
);

// Tema oscuro
echo NativeChartComponents::barChart(
    \$ventasData,
    \$ventasLabels,
    'Tema Oscuro - Chart title goes here',
    'dark'
);
echo "</div>";

// ============================================
// EJEMPLO 6: Paleta de Colores
// ============================================

echo "<h2>Ejemplo 6: Paleta de Colores Exacta</h2>";

echo "<div class='grid grid-2'>";
echo NativeChartComponents::colorPalette('light');
echo NativeChartComponents::colorPalette('dark');
echo "</div>";

echo "<div style='margin: 40px 0; padding: 20px; background: rgba(37, 99, 235, 0.1); border-radius: 8px; border-left: 4px solid #2563EB;'>";
echo "<h3>🎯 Características de los Componentes Nativos:</h3>";
echo "<ul style='margin: 12px 0; padding-left: 20px; line-height: 1.6;'>";
echo "<li><strong>100% SVG + CSS:</strong> Sin dependencias externas como Chart.js</li>";
echo "<li><strong>Fidelidad Exacta:</strong> Colores y diseños idénticos a las imágenes</li>";
echo "<li><strong>Interactivos:</strong> Tooltips nativos con JavaScript vanilla</li>";
echo "<li><strong>Responsive:</strong> Se adaptan a cualquier tamaño de pantalla</li>";
echo "<li><strong>Temas:</strong> Soporte completo para modo claro y oscuro</li>";
echo "<li><strong>Ligero:</strong> Carga más rápida sin librerías externas</li>";
echo "</ul>";
echo "</div>";
?>