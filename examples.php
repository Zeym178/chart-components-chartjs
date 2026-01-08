<?php
/**
 * Ejemplos de uso de los Chart Components
 * Este archivo muestra cómo usar cada componente individualmente
 */

require_once 'ChartComponents.php';
ChartComponents::init();

// ============================================
// EJEMPLO 1: Uso básico de gráfico de barras
// ============================================

echo "<h2>Ejemplo 1: Gráfico de Barras</h2>";

// Datos para el gráfico de barras
$ventasData = [
    [15000, 23000, 18000, 27000, 22000, 31000], // Ventas 2023
    [12000, 20000, 16000, 25000, 24000, 28000]  // Ventas 2024
];

$ventasLabels = ['Ventas 2023', 'Ventas 2024'];

echo ChartComponents::barChart(
    $ventasData, 
    $ventasLabels, 
    'Comparación de Ventas Mensuales', 
    'light'
);

// ============================================
// EJEMPLO 2: Tarjetas de métricas
// ============================================

echo "<h2>Ejemplo 2: Tarjetas de Métricas</h2>";

echo ChartComponents::metricCard(
    'Usuarios Activos', 
    '1,247', 
    'Total este mes', 
    'center', 
    'light'
);

echo ChartComponents::largeNumberCard('95%', 'Tasa de Satisfacción');

// ============================================
// EJEMPLO 3: Barras de progreso múltiples
// ============================================

echo "<h2>Ejemplo 3: Progreso de Proyectos</h2>";

$proyectos = [
    ['label' => 'Frontend', 'value' => 75, 'total' => 100, 'color' => 'primary'],
    ['label' => 'Backend', 'value' => 90, 'total' => 100, 'color' => 'success'],
    ['label' => 'Testing', 'value' => 45, 'total' => 100, 'color' => 'secondary']
];

echo ChartComponents::multiProgressCard('Progreso del Proyecto', $proyectos, 'light');

// ============================================
// EJEMPLO 4: Gráfico de línea con datos reales
// ============================================

echo "<h2>Ejemplo 4: Gráfico de Línea</h2>";

$traficoData = [
    [1200, 1800, 1500, 2200, 1900, 2500] // Visitas mensuales
];

echo ChartComponents::lineChart(
    $traficoData, 
    ['Visitas'], 
    'Tráfico Web', 
    'Enero - Junio 2024', 
    'smooth', 
    'light'
);

// ============================================
// EJEMPLO 5: Versión con tema oscuro
// ============================================

echo "<h2>Ejemplo 5: Tema Oscuro</h2>";

echo ChartComponents::barChart(
    $ventasData, 
    $ventasLabels, 
    'Ventas - Tema Oscuro', 
    'dark'
);

// ============================================
// EJEMPLO 6: Gráfico de área
// ============================================

echo "<h2>Ejemplo 6: Gráfico de Área</h2>";

$ingresoData = [
    [5000, 7500, 6200, 8800, 7400, 9200]
];

echo ChartComponents::areaChart(
    $ingresoData, 
    ['Ingresos'], 
    'Ingresos Mensuales', 
    'Evolución 2024', 
    'light'
);

?>