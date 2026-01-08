# Chart.js Components

Librería completa de componentes de gráficos interactivos usando Chart.js con temas personalizados, funcionalidades avanzadas y componentes especializados para dashboards modernos.

## 📋 Tabla de Contenidos

- [Instalación](#instalación)
- [Uso Básico](#uso-básico)
- [Componentes Disponibles](#componentes-disponibles)
- [Componentes Especializados](#componentes-especializados)
- [Configuración](#configuración)
- [Temas](#temas)
- [Ejemplos](#ejemplos)

## 🚀 Instalación

1. Copia la carpeta `chart-componentes-chartjs` a tu proyecto
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

### 1. Gráficos de Barras Básicos

```php
// Gráfico de barras estándar
ChartComponents::barChart($data, $labels, $title, $theme, $options);

// Ejemplo básico
$data = [30000, 50000, 70000, 40000, 60000, 65000];
$labels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'];
echo ChartComponents::barChart($data, $labels, 'Ventas 2024', 'light');
```

### 2. Gráficos de Líneas Básicos

```php
// Gráfico de líneas simple
ChartComponents::lineChart($data, $labels, $title, $subtitle, $type, $theme, $chartId);

// Gráfico de área
ChartComponents::areaChart($data, $labels, $title, $subtitle, $theme, $chartId);

// Gráfico de línea suavizada
ChartComponents::smoothLineChart($data, $labels, $title, $subtitle, $theme, $chartId);
```

### 3. Métricas y Tarjetas

```php
// Métrica simple
ChartComponents::metricCard('Usuarios', '1,247', 'Total', $theme);

// Tarjeta de progreso
ChartComponents::progressCard([
    'label' => 'Completado',
    'value' => 75,
    'total' => 100,
    'color' => '#147AD6'
], $theme);

// Barra de progreso
ChartComponents::progressBar('Progreso', 85, '#147AD6', $theme);
```

### 4. Paletas de Colores

```php
// Paleta de colores del sistema
ChartComponents::colorPalette($theme);
```

## 🎨 Componentes Especializados

### Gráficos de Dona y Círculo

```php
// Dona de 3 categorías con texto central
ChartComponents::donutChart3Categories($percentage, $title, $subtitle, $color, $theme);

// Anillo de 4 categorías
ChartComponents::ringChart4Categories([25, 30, 25, 20], ['Cat1', 'Cat2', 'Cat3', 'Cat4'], $colors, $theme);
```

### Componentes de Carousel

```php
// Gráfico con navegación por puntos
ChartComponents::carouselChart($title, $subtitle, $percentage, $color, $activeIndex, $theme);
```

### Lista de Desafíos

```php
// Lista vertical con mini gráficos de dona
$challenges = [
    ['id' => 'ch_01', 'percent' => 76, 'title' => 'Challenge 01', 'subtitle' => 'XX of total XX', 'color' => '#147AD6'],
    ['id' => 'ch_02', 'percent' => 50, 'title' => 'Challenge 02', 'subtitle' => 'XX of total XX', 'color' => '#EC6666']
];
ChartComponents::challengeList($challenges, $theme);
```

### Tarjetas Compactas

```php
// Tarjeta con estadística y mini gráfico
ChartComponents::compactStatCard('354', 'Category', 75, '#147AD6', $theme);

// Tarjeta horizontal con progreso
ChartComponents::horizontalCard('Challenge 01', 'XX of total XX', 76, '#147AD6', $theme);
```

### Gráficos de Línea Avanzados

```php
// Gráfico de área con gradiente
ChartComponents::areaLineChart($data, $labels, $title, $subtitle, $color, $theme);

// Gráfico con anotación destacada
ChartComponents::annotatedLineChart($data, $labels, $title, $subtitle, $annotationValue, $annotationText, $color, $theme);

// Gráfico multilínea con leyenda
$datasets = [
    ['label' => 'Serie 1', 'data' => [100, 200, 150], 'color' => '#147AD6'],
    ['label' => 'Serie 2', 'data' => [150, 180, 200], 'color' => '#EC6666']
];
ChartComponents::multiLineChart($datasets, $labels, $title, $subtitle, $theme);

// Gráfico de línea compacto
ChartComponents::compactLineChart($title, $value, $data, $color, $theme);
```

### Gráficos de Pie y Dona Simples

```php
// Dona simple con porcentaje
ChartComponents::simpleDonutChart($percentage, $title, $subtitle, $color, $theme);

// Pie chart básico
ChartComponents::simplePieChart($data, $colors, $title, $subtitle, $theme);

// Pie chart con leyenda
$chartData = [
    ['label' => 'Point 01', 'value' => 40, 'color' => '#147AD6'],
    ['label' => 'Point 02', 'value' => 35, 'color' => '#79D2DE'],
    ['label' => 'Point 03', 'value' => 25, 'color' => '#EC6666']
];
ChartComponents::pieChartWithLegend($chartData, 'Chart Title', $theme);
```

### Gráficos de Barras Avanzados

```php
// Barra con valor destacado en header
ChartComponents::valueBarChart($data, $labels, '$476', 'Daily average', '#147AD6', $theme);

// Barras con anotación flotante
ChartComponents::annotatedBarChart($data, $labels, $title, $subtitle, '742', 'additional text', '#147AD6', $theme);

// Barras con valores mostrados
ChartComponents::labeledBarChart($data, $labels, $title, $subtitle, '#147AD6', $theme);

// Barras múltiples con series
$datasets = [
    ['label' => 'Point 01', 'data' => [325, 450, 350], 'color' => '#147AD6'],
    ['label' => 'Point 02', 'data' => [225, 350, 280], 'color' => '#EC6666']
];
ChartComponents::multiBarChart($datasets, $labels, $title, $subtitle, $theme);

// Barras combinadas (positivas/negativas)
ChartComponents::combinedBarChart($positiveData, $negativeData, $labels, $title, $subtitle, '#147AD6', '#EC6666', $theme);
```

### Dashboard Grid

```php
// Dashboard completo con múltiples gráficos
$donutCharts = [
    ['percentage' => 58, 'title' => 'Chart title', 'subtitle' => '15 April - 15 May', 'color' => '#147AD6'],
    ['percentage' => 72, 'title' => 'Chart title', 'subtitle' => '15 April - 15 May', 'color' => '#EC6666']
];

$pieCharts = [
    ['data' => [35, 25, 20, 20], 'colors' => ['#147AD6', '#79D2DE', '#EC6666', '#F97316'], 'title' => 'Chart title', 'legend' => false]
];

ChartComponents::chartDashboard($donutCharts, $pieCharts, $theme);
```

## 🎨 Sistema de Temas

### Temas Disponibles

- **Light**: Tema claro con fondo blanco
- **Dark**: Tema oscuro con fondo oscuro

### Cambio de Tema

```php
// Renderizar con tema específico
echo ChartComponents::barChart($data, $labels, 'Título', 'light');
echo ChartComponents::barChart($data, $labels, 'Título', 'dark');

// Toggle de tema en frontend
<a href="?theme=<?php echo $theme === 'light' ? 'dark' : 'light'; ?>">
    Cambiar Tema
</a>
```

### Colores del Sistema

```php
// Paleta principal
$colors = [
    'primary' => '#147AD6',   // Azul principal
    'danger' => '#EC6666',    // Rojo
    'info' => '#79D2DE',      // Cyan
    'warning' => '#F97316'    // Naranja
];
```

## ⚙️ Configuración Avanzada

### 1. Animaciones Personalizadas

```php
$animationConfig = [
    'duration' => 1000,
    'easing' => 'easeOutCubic',
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

### 3. Responsividad

```php
// Clases CSS para layouts responsivos
.grid { display: grid; gap: 20px; }
.grid-2 { grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }
.grid-3 { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
.grid-4 { grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }
```

## 📁 Estructura del Proyecto

```
chart-componentes-chartjs/
├── ChartComponents.php          # Clase principal
├── index.php                    # Demo y ejemplos
├── README.md                    # Documentación
├── components/
│   ├── bar-chart.php           # Gráficos de barras básicos
│   ├── line-charts.php         # Gráficos de líneas básicos
│   ├── metrics.php             # Métricas y tarjetas
│   ├── progress-bars.php       # Barras de progreso
│   ├── color-palette.php       # Paletas de colores
│   ├── donut-charts.php        # Gráficos de dona especializados
│   ├── carousel-charts.php     # Componentes carousel
│   ├── single-combined.php     # Listas de desafíos
│   ├── size-charts.php         # Tarjetas compactas
│   ├── advanced-line-charts.php # Gráficos de línea avanzados
│   ├── pie-donut-charts.php    # Pie y dona simples
│   └── advanced-bar-charts.php # Gráficos de barras avanzados
└── styles/
    └── chart-themes.css        # Estilos y temas CSS
```

## 🎯 Casos de Uso

### Dashboards Empresariales

```php
// Panel de métricas ejecutivas
echo ChartComponents::valueBarChart($salesData, $months, '$2.4M', 'Revenue', '#147AD6', $theme);
echo ChartComponents::compactStatCard('1,247', 'Users', 85, '#147AD6', $theme);
echo ChartComponents::progressCard(['label' => 'Goal Progress', 'value' => 78, 'total' => 100], $theme);
```

### Reportes Analíticos

```php
// Análisis de tendencias
echo ChartComponents::multiLineChart($trendData, $periods, 'Trend Analysis', 'Last 12 months', $theme);
echo ChartComponents::areaLineChart($growthData, $quarters, 'Growth Rate', 'Quarterly', '#147AD6', $theme);
```

### Monitoreo en Tiempo Real

```php
// Indicadores de estado
echo ChartComponents::donutChart3Categories(92, 'System Health', 'All systems operational', '#147AD6', $theme);
echo ChartComponents::annotatedLineChart($performanceData, $timeLabels, 'Performance', 'Live', '99.9%', 'uptime', '#147AD6', $theme);
```

## 🔧 Características Técnicas

- **Chart.js 4.0+**: Última versión con todas las funcionalidades
- **PHP 7.4+**: Compatible con versiones modernas de PHP
- **Responsive**: Adaptativo a todos los tamaños de pantalla
- **Interactivo**: Tooltips, hover effects, leyendas clicables
- **Animado**: Transiciones y animaciones fluidas
- **Temas Duales**: Soporte completo para temas claro y oscuro
- **Modular**: Componentes independientes y reutilizables
- **Performance**: Optimizado para grandes volúmenes de datos
- **CSS Variables**: Sistema de colores consistente
- **Grid Responsivo**: Layout flexible y adaptable

## 📊 Ejemplos Prácticos

### Dashboard Completo

```php
<?php
require_once 'ChartComponents.php';
ChartComponents::init();

$theme = $_GET['theme'] ?? 'light';

$content = "
<div class='grid grid-3'>
    " . ChartComponents::valueBarChart([500, 750, 600, 550, 400], ['M','T','W','T','F'], '$2.4K', 'Daily Revenue', '#147AD6', $theme) . "
    " . ChartComponents::simpleDonutChart(78, 'Completion Rate', 'This Month', '#147AD6', $theme) . "
    " . ChartComponents::compactStatCard('1,247', 'Active Users', 85, '#147AD6', $theme) . "
</div>

<div class='grid grid-2' style='margin-top: 30px;'>
    " . ChartComponents::multiLineChart([
        ['label' => 'Revenue', 'data' => [100, 200, 150, 300, 250, 400], 'color' => '#147AD6'],
        ['label' => 'Profit', 'data' => [50, 100, 75, 150, 125, 200], 'color' => '#EC6666']
    ], ['Jan','Feb','Mar','Apr','May','Jun'], 'Financial Overview', 'Last 6 months', $theme) . "
    " . ChartComponents::pieChartWithLegend([
        ['label' => 'Desktop', 'value' => 45, 'color' => '#147AD6'],
        ['label' => 'Mobile', 'value' => 35, 'color' => '#79D2DE'],
        ['label' => 'Tablet', 'value' => 20, 'color' => '#EC6666']
    ], 'Traffic Sources', $theme) . "
</div>
";

echo ChartComponents::renderComplete($content, 'Analytics Dashboard', $theme);
?>
```

## 🚀 Características Avanzadas

- **Exportación de gráficos** como imagen (PNG, SVG)
- **Interactividad completa** con eventos personalizables
- **Animaciones fluidas** y transiciones suaves
- **Tooltips personalizados** con información detallada
- **Leyendas interactivas** con filtrado de datos
- **Zoom y pan** para exploración de datos
- **Actualización en tiempo real** para dashboards dinámicos
- **Accesibilidad completa** (WCAG 2.1 compatible)

## 📞 Soporte

Para soporte técnico o consultas sobre implementación, consulta la documentación completa incluida en el proyecto o revisa los ejemplos en `index.php`.
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