# Chart.js Components

Librería de componentes de gráficos interactivos usando Chart.js con temas personalizados y funcionalidades avanzadas.

## 📋 Tabla de Contenidos

- [Instalación](#instalación)
- [Uso Básico](#uso-básico)
- [Componentes Disponibles](#componentes-disponibles)
- [Configuración](#configuración)
- [Temas](#temas)
- [Ejemplos](#ejemplos)

## 🚀 Instalación

1. Copia la carpeta `charts-componentes` a tu proyecto
2. Incluye el archivo principal en tu PHP:

```php
require_once 'ChartComponents.php';
ChartComponents::init();
```

## 🎯 Uso Básico

### Inicialización

```php
<?php
require_once 'ChartComponents.php';
ChartComponents::init();
?>
```

### Renderizado de Página Completa

```php
$content = "<!-- Tu contenido aquí -->";
echo ChartComponents::renderComplete($content, 'Mi Título', 'light');
```

## 📊 Componentes Disponibles

### 1. Gráficos de Barras Interactivos

```php
// Gráfico básico
ChartComponents::barChart($data, $labels, $title, $theme, $options);

// Ejemplo con opciones personalizadas
$data = [
    ['label' => 'Ventas', 'data' => [30000, 50000, 70000, 40000, 60000, 65000], 'color' => 'blue'],
    ['label' => 'Compras', 'data' => [20000, 40000, 50000, 35000, 45000, 55000], 'color' => 'red']
];
$categories = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'];
$options = ['responsive' => true, 'animation' => true, 'legend' => true];

echo ChartComponents::barChart($data, $categories, 'Ventas vs Compras', 'light', $options);
```

**Parámetros:**
- `$data` (array): Array de datasets con label, data y color
- `$categories` (array): Categorías del eje X
- `$title` (string): Título del gráfico
- `$theme` (string): 'light' o 'dark'
- `$options` (array): Configuraciones adicionales del gráfico

### 2. Gráficos de Línea Avanzados

```php
// Línea básica
ChartComponents::lineChart($data, $labels, $title, $subtitle, $type, $theme);

// Línea con área
ChartComponents::lineChart($data, $labels, $title, $subtitle, 'area', $theme);

// Multi-línea con configuración
$multiData = [
    ['label' => 'Desktop', 'data' => [300, 450, 320, 380, 420, 350], 'color' => 'blue'],
    ['label' => 'Mobile', 'data' => [200, 300, 280, 250, 300, 320], 'color' => 'red'],
    ['label' => 'Tablet', 'data' => [100, 150, 120, 180, 160, 140], 'color' => 'cyan']
];
echo ChartComponents::multiLineChart($multiData, $categories, 'Tráfico por Dispositivo', 'dark');
```

**Tipos de Línea:**
- `'line'`: Línea simple
- `'area'`: Línea con área rellena
- `'smooth'`: Línea con curvas suaves
- `'stepped'`: Línea escalonada
- `'dotted'`: Línea punteada

### 3. Gráficos Circulares (Pie/Donut)

```php
// Gráfico circular básico
$pieData = [
    ['label' => 'Chrome', 'value' => 45.2, 'color' => 'blue'],
    ['label' => 'Firefox', 'value' => 23.8, 'color' => 'red'],
    ['label' => 'Safari', 'value' => 18.4, 'color' => 'cyan'],
    ['label' => 'Edge', 'value' => 12.6, 'color' => 'gray']
];
echo ChartComponents::pieChart($pieData, 'Navegadores Web', 'light');

// Gráfico donut
echo ChartComponents::donutChart($pieData, 'Navegadores Web', 'dark');
```

### 4. Tarjetas de Métricas Interactivas

```php
// Métrica con gráfico sparkline
ChartComponents::metricWithSparkline($title, $value, $sparklineData, $trend, $theme);

// Métrica con comparación
ChartComponents::metricComparison($title, $currentValue, $previousValue, $theme);

// Ejemplo
$sparkData = [10, 15, 12, 18, 22, 19, 25];
echo ChartComponents::metricWithSparkline(
    'Ventas Diarias', 
    '$2,847', 
    $sparkData, 
    'up', 
    'light'
);
```

**Parámetros de Métricas:**
- `$title` (string): Título de la métrica
- `$value` (string): Valor principal
- `$sparklineData` (array): Datos para mini-gráfico
- `$trend` (string): 'up', 'down', 'neutral'
- `$theme` (string): 'light' o 'dark'
- `$size` (string): 'auto', 'small', 'medium', 'large'

### 5. Barras de Progreso Animadas

```php
// Progreso con animación
$progressData = [
    [
        'label' => 'Desarrollo Frontend', 
        'value' => 85, 
        'total' => 100, 
        'color' => 'blue',
        'showPercentage' => true
    ],
    [
        'label' => 'Backend API', 
        'value' => 65, 
        'total' => 100, 
        'color' => 'red',
        'showPercentage' => true
    ]
];

echo ChartComponents::animatedProgressCard(
    'Progreso del Proyecto', 
    $progressData, 
    'light',
    ['animation' => true, 'duration' => 1500]
);

// Progress con gradiente
echo ChartComponents::gradientProgressBar(
    'Completado',
    75,
    'linear-gradient(90deg, #147AD6, #79D2DE)',
    'light'
);
```

### 6. Dashboard en Tiempo Real

```php
// Dashboard con auto-actualización
echo ChartComponents::realtimeDashboard([
    'updateInterval' => 5000, // 5 segundos
    'charts' => ['chart1', 'chart2'],
    'metrics' => ['metric1', 'metric2']
]);
```

## ⚙️ Configuración de Chart.js

### Opciones Globales

```php
$globalOptions = [
    'responsive' => true,
    'maintainAspectRatio' => false,
    'animation' => [
        'duration' => 1000,
        'easing' => 'easeInOutQuart'
    ],
    'plugins' => [
        'legend' => ['display' => true],
        'tooltip' => ['enabled' => true]
    ],
    'scales' => [
        'x' => ['grid' => ['display' => false]],
        'y' => ['beginAtZero' => true]
    ]
];
```

### Configuración por Tipo

```php
// Configuración para barras
$barOptions = [
    'barPercentage' => 0.8,
    'categoryPercentage' => 0.9,
    'scales' => [
        'y' => [
            'beginAtZero' => true,
            'ticks' => ['stepSize' => 10000]
        ]
    ]
];

// Configuración para líneas
$lineOptions = [
    'tension' => 0.4, // Suavidad de curvas
    'pointRadius' => 6,
    'pointHoverRadius' => 8,
    'borderWidth' => 3
];
```

## 🎨 Estructura de Datos

### Datasets para Chart.js
```php
// Dataset básico
$dataset = [
    'label' => 'Nombre del dataset',
    'data' => [10, 20, 30, 40, 50],
    'backgroundColor' => 'rgba(20, 122, 214, 0.2)',
    'borderColor' => 'rgba(20, 122, 214, 1)',
    'borderWidth' => 2
];

// Multiple datasets
$datasets = [
    [
        'label' => 'Serie 1',
        'data' => [65, 59, 80, 81, 56, 55, 40],
        'color' => 'blue' // Se convierte automáticamente
    ],
    [
        'label' => 'Serie 2',
        'data' => [28, 48, 40, 19, 86, 27, 90],
        'color' => 'red'
    ]
];
```

### Datos para Gráficos Circulares
```php
$pieData = [
    ['label' => 'Categoría 1', 'value' => 30, 'color' => 'blue'],
    ['label' => 'Categoría 2', 'value' => 25, 'color' => 'red'],
    ['label' => 'Categoría 3', 'value' => 20, 'color' => 'cyan'],
    ['label' => 'Categoría 4', 'value' => 25, 'color' => 'gray']
];
```

## 🌗 Temas y Personalización

### Sistema de Colores
```css
:root {
    --primary-blue: rgba(20, 122, 214, 1);
    --primary-red: rgba(236, 102, 102, 1);
    --primary-cyan: rgba(121, 210, 222, 1);
    --neutral-gray: rgba(115, 136, 169, 0.3533);
    --white: rgba(255, 255, 255, 1);
    --dark-bg: rgba(51, 51, 64, 1);
}
```

### Tema Personalizado
```php
$customTheme = [
    'colors' => [
        'primary' => '#147AD6',
        'secondary' => '#EC6666',
        'accent' => '#79D2DE'
    ],
    'fonts' => [
        'family' => 'Inter, sans-serif',
        'size' => 12
    ],
    'spacing' => [
        'padding' => 20,
        'margin' => 16
    ]
];

ChartComponents::setCustomTheme($customTheme);
```

## 📱 Responsividad y Adaptativos

### Breakpoints
```php
$responsiveConfig = [
    'mobile' => [
        'maxWidth' => 768,
        'chartHeight' => 250,
        'fontSize' => 10
    ],
    'tablet' => [
        'maxWidth' => 1024,
        'chartHeight' => 300,
        'fontSize' => 12
    ],
    'desktop' => [
        'minWidth' => 1025,
        'chartHeight' => 400,
        'fontSize' => 14
    ]
];
```

## 📂 Estructura de Archivos

```
charts-componentes/
├── index.php                  # Demo interactivo
├── examples.php               # Galería de ejemplos
├── ChartComponents.php        # Clase principal
├── README.md                  # Este archivo
├── components/
│   ├── bar-chart.php          # Gráficos de barras Chart.js
│   ├── line-charts.php        # Gráficos de línea Chart.js
│   ├── metrics.php            # Métricas interactivas
│   ├── progress-bars.php      # Progress bars animadas
│   └── color-palette.php      # Paleta y temas
└── styles/
    └── chart-themes.css       # Estilos y temas CSS
```

## 🔍 Ejemplo Completo Interactivo

```php
<?php
require_once 'ChartComponents.php';
ChartComponents::init();

// Configurar datos
$salesData = [
    ['label' => 'Q1', 'data' => [30000, 35000, 40000], 'color' => 'blue'],
    ['label' => 'Q2', 'data' => [45000, 50000, 55000], 'color' => 'red'],
    ['label' => 'Q3', 'data' => [60000, 65000, 70000], 'color' => 'cyan']
];

$trafficData = [
    ['label' => 'Desktop', 'data' => [350, 450, 320, 380, 420, 350], 'color' => 'blue'],
    ['label' => 'Mobile', 'data' => [280, 350, 280, 250, 300, 320], 'color' => 'red']
];

$deviceData = [
    ['label' => 'Desktop', 'value' => 45.2, 'color' => 'blue'],
    ['label' => 'Mobile', 'value' => 35.8, 'color' => 'red'],
    ['label' => 'Tablet', 'value' => 19.0, 'color' => 'cyan']
];

$content = "
<div class='dashboard-header'>
    <h1>Dashboard Interactivo</h1>
    <div class='theme-switcher'>
        <button onclick='switchTheme()'>🌓 Cambiar Tema</button>
    </div>
</div>

<div class='metrics-grid'>
    " . ChartComponents::metricWithSparkline(
        'Ventas Totales',
        '$127,439',
        [100, 120, 110, 135, 150, 145, 160],
        'up',
        'light'
    ) . "
    " . ChartComponents::metricComparison(
        'Usuarios Activos',
        '8,247',
        '7,891',
        'light'
    ) . "
</div>

<div class='charts-grid'>
    <div class='chart-container'>
        " . ChartComponents::barChart(
            $salesData,
            ['Ene', 'Feb', 'Mar'],
            'Ventas por Trimestre',
            'light',
            ['animation' => true, 'responsive' => true]
        ) . "
    </div>
    
    <div class='chart-container'>
        " . ChartComponents::multiLineChart(
            $trafficData,
            ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            'Tráfico por Dispositivo',
            'light'
        ) . "
    </div>
    
    <div class='chart-container'>
        " . ChartComponents::donutChart(
            $deviceData,
            'Distribución de Dispositivos',
            'light'
        ) . "
    </div>
</div>

<script>
// Funcionalidad de cambio de tema
function switchTheme() {
    // Lógica para cambiar entre tema claro y oscuro
    document.body.classList.toggle('dark-theme');
}

// Auto-actualización cada 30 segundos
setInterval(() => {
    // Actualizar datos en tiempo real
    updateChartData();
}, 30000);
</script>
";

echo ChartComponents::renderComplete($content, 'Dashboard Chart.js', 'light');
?>
```

## 📈 Funcionalidades Avanzadas

### 1. Animaciones Personalizadas
```php
$animationConfig = [
    'duration' => 2000,
    'easing' => 'easeInOutBounce',
    'delay' => 500,
    'onComplete' => 'animationComplete'
];
```

### 2. Interactividad
```php
$interactionConfig = [
    'hover' => true,
    'click' => true,
    'tooltip' => [
        'enabled' => true,
        'mode' => 'nearest',
        'intersect' => false
    ],
    'legend' => [
        'onClick' => 'legendClick',
        'onHover' => 'legendHover'
    ]
];
```

### 3. Exportación
```php
// Exportar como imagen
ChartComponents::exportChart('chartId', 'png', 'mi-grafico.png');

// Exportar datos como JSON
ChartComponents::exportData('chartId', 'json');
```

## 🔧 Características Técnicas

- **Chart.js 4.0+**: Última versión con todas las funcionalidades
- **Responsive**: Adaptativo a todos los tamaños de pantalla
- **Interactivo**: Tooltips, zoom, pan, selección
- **Animado**: Transiciones y animaciones fluidas
- **Temas**: Soporte completo para múltiples temas
- **Modular**: Componentes independientes y reutilizables
- **Performance**: Optimizado para grandes volúmenes de datos

## 🎯 Casos de Uso Ideales

- Dashboards empresariales interactivos
- Reportes con análisis de datos
- Aplicaciones web modernas
- Sistemas de monitoreo en tiempo real
- Plataformas de business intelligence
- Aplicaciones que requieren visualización avanzada