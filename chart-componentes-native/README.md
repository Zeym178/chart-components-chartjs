# Native Chart Components

Librería de componentes de gráficos nativos usando únicamente SVG, CSS y PHP. Sin dependencias externas.

## 📋 Tabla de Contenidos

- [Instalación](#instalación)
- [Uso Básico](#uso-básico)
- [Componentes Disponibles](#componentes-disponibles)
- [Estructura de Datos](#estructura-de-datos)
- [Temas](#temas)
- [Ejemplos](#ejemplos)

## 🚀 Instalación

1. Copia la carpeta `chart-componentes-native` a tu proyecto
2. Incluye el archivo principal en tu PHP:

```php
require_once 'NativeChartComponents.php';
NativeChartComponents::init();
```

## 🎯 Uso Básico

### Inicialización

```php
<?php
require_once 'NativeChartComponents.php';
NativeChartComponents::init();
?>
```

### Renderizado de Página Completa

```php
$content = "<!-- Tu contenido aquí -->";
echo NativeChartComponents::renderComplete($content, 'Mi Título', 'light');
```

## 📊 Componentes Disponibles

### 1. Gráficos de Barras

```php
// Estructura básica
NativeChartComponents::barChart($data, $labels, $title, $theme);

// Ejemplo
$data = [
    [30000, 50000, 70000, 40000, 60000, 65000], // Serie 1
    [20000, 40000, 50000, 35000, 45000, 55000]  // Serie 2
];
$labels = ['Point 01', 'Point 02'];
echo NativeChartComponents::barChart($data, $labels, 'Ventas Mensuales', 'light');
```

**Parámetros:**
- `$data` (array): Array de arrays con datos numéricos
- `$labels` (array): Etiquetas para cada serie de datos
- `$title` (string): Título del gráfico
- `$theme` (string): 'light' o 'dark'

### 2. Gráficos de Línea

```php
// Gráfico de línea básico
NativeChartComponents::lineChart($data, $labels, $title, $subtitle, $type, $theme);

// Gráfico con curvas suaves
NativeChartComponents::lineChart($data, $labels, $title, $subtitle, 'smooth', $theme);

// Gráfico con anotación
NativeChartComponents::lineChartWithAnnotation($data, $labels, $title, $subtitle, $annotation, $theme);
```

**Parámetros:**
- `$data` (array): Array de arrays con datos numéricos
- `$labels` (array): Etiquetas para cada serie
- `$title` (string): Título del gráfico
- `$subtitle` (string): Subtítulo del gráfico
- `$type` (string): 'line', 'smooth', 'area', 'smooth-area', 'highlight'
- `$theme` (string): 'light' o 'dark'
- `$annotation` (array): Para anotaciones: ['value' => '489', 'label' => 'texto']

### 3. Tarjetas de Métricas

```php
// Métrica básica
NativeChartComponents::metricCard($title, $value, $subtitle, $alignment, $theme, $size);

// Número grande
NativeChartComponents::largeNumberCard($number, $label, $theme);

// Ejemplo
echo NativeChartComponents::metricCard('Usuarios Activos', '1,247', 'Total este mes', 'center', 'light', 'medium');
```

**Parámetros:**
- `$title` (string): Título de la métrica
- `$value` (string): Valor a mostrar
- `$subtitle` (string): Descripción adicional
- `$alignment` (string): 'left', 'center'
- `$theme` (string): 'light' o 'dark'
- `$size` (string): 'auto', 'small', 'medium', 'large'

### 4. Barras de Progreso

```php
// Progreso múltiple
$progressData = [
    ['label' => 'Tarea 1', 'value' => 25, 'total' => 100, 'color' => 'blue'],
    ['label' => 'Tarea 2', 'value' => 65, 'total' => 100, 'color' => 'red'],
    ['label' => 'Tarea 3', 'value' => 45, 'total' => 100, 'color' => 'cyan']
];
echo NativeChartComponents::multiProgressCard('Challenge 01', $progressData, 'light', 'medium');

// Progreso simple
echo NativeChartComponents::singleProgressCard('Challenge 01', 'Descripción', 35, 'light', 'auto');

// Progreso con icono
echo NativeChartComponents::iconProgressCard('Category', 'Descripción', '7.2h of 8h', '🌙', 'light', 'small');
```

**Parámetros de Progress:**
- `$title` (string): Título de la tarjeta
- `$progressData` (array): Array de items con label, value, total, color
- `$percentage` (number): Porcentaje para progreso simple
- `$theme` (string): 'light' o 'dark'
- `$size` (string): 'auto', 'small', 'medium', 'large'

### 5. Paleta de Colores

```php
echo NativeChartComponents::colorPalette('light');
echo NativeChartComponents::colorPalette('dark');
```

## 🎨 Estructura de Datos

### Datos para Gráficos de Barras/Línea
```php
// Una serie
$data = [
    [100, 200, 150, 300, 250, 180]
];

// Múltiples series
$data = [
    [100, 200, 150, 300, 250, 180], // Serie 1
    [80, 150, 200, 280, 200, 160],  // Serie 2
    [120, 180, 170, 250, 220, 190] // Serie 3
];

// Etiquetas correspondientes
$labels = ['Serie 1', 'Serie 2', 'Serie 3'];
```

### Datos para Progress Bars
```php
$progressData = [
    [
        'label' => 'Nombre de la tarea',
        'value' => 75,        // Valor actual
        'total' => 100,       // Valor máximo
        'color' => 'blue'     // Color: 'blue', 'red', 'cyan'
    ]
];
```

## 🌗 Temas

### Tema Claro
```php
$theme = 'light';
```

### Tema Oscuro
```php
$theme = 'dark';
```

### Colores Disponibles
- **Azul**: rgba(20, 122, 214, 1)
- **Rojo**: rgba(236, 102, 102, 1)
- **Verde Azulado**: rgba(121, 210, 222, 1)
- **Gris**: rgba(115, 136, 169, 0.3533)
- **Blanco**: rgba(255, 255, 255, 1)
- **Fondo Oscuro**: rgba(51, 51, 64, 1)

## 📐 Tamaños de Componentes

### Tamaños Disponibles
- `'auto'`: Tamaño flexible (por defecto)
- `'small'`: max-width: 200px, min-height: 100px
- `'medium'`: max-width: 300px, min-height: 120px
- `'large'`: max-width: 400px, min-height: 150px

### Layouts
```php
// Layout flexible
echo NativeChartComponents::metricsContainer($metrics, 'flex');

// Layout grid
echo NativeChartComponents::metricsContainer($metrics, 'grid');
```

## 📂 Estructura de Archivos

```
chart-componentes-native/
├── index.php                      # Demo completo
├── NativeChartComponents.php       # Clase principal
├── README.md                       # Este archivo
├── components/
│   ├── bar-chart-native.php        # Gráficos de barras
│   ├── line-chart-native.php       # Gráficos de línea
│   ├── metrics-native.php          # Tarjetas de métricas
│   ├── progress-native.php         # Barras de progreso
│   └── color-palette-native.php    # Paleta de colores
└── styles/
    └── native-themes.css           # Estilos CSS
```

## 🔍 Ejemplo Completo

```php
<?php
require_once 'NativeChartComponents.php';
NativeChartComponents::init();

// Datos de ejemplo
$barData = [
    [30000, 50000, 70000, 40000, 60000, 65000],
    [20000, 40000, 50000, 35000, 45000, 55000]
];

$lineData = [
    [350, 450, 200, 350, 480, 230]
];

$progressData = [
    ['label' => 'Progreso A', 'value' => 75, 'total' => 100, 'color' => 'blue'],
    ['label' => 'Progreso B', 'value' => 50, 'total' => 100, 'color' => 'red']
];

// Crear contenido
$content = "
    <h2>Dashboard de Ejemplo</h2>
    
    <div class='grid grid-3'>
        " . NativeChartComponents::metricCard('Usuarios', '1,247', 'Total activos', 'center', 'light') . "
        " . NativeChartComponents::metricCard('Ventas', '$47,529', 'Este mes', 'center', 'light') . "
        " . NativeChartComponents::metricCard('Conversión', '3.2%', 'Tasa promedio', 'center', 'light') . "
    </div>
    
    <div class='grid grid-2'>
        " . NativeChartComponents::barChart($barData, ['Producto A', 'Producto B'], 'Ventas por Mes', 'light') . "
        " . NativeChartComponents::lineChart($lineData, ['Usuarios'], 'Tráfico Web', 'Últimos 6 meses', 'smooth', 'light') . "
    </div>
    
    " . NativeChartComponents::multiProgressCard('Objetivos 2024', $progressData, 'light') . "
";

// Renderizar página completa
echo NativeChartComponents::renderComplete($content, 'Mi Dashboard', 'light');
?>
```

## 🔧 Características Técnicas

- **100% Nativo**: Solo SVG, CSS y PHP
- **Sin Dependencias**: No requiere librerías externas
- **Responsive**: Se adapta a diferentes tamaños de pantalla
- **Temas**: Soporte completo para temas claro y oscuro
- **Flexible**: Tamaños automáticos o personalizables
- **Rápido**: Renderizado directo en el servidor

## 🎯 Casos de Uso Ideales

- Dashboards administrativos
- Reportes internos
- Sistemas sin conexión a internet
- Aplicaciones que requieren renderizado servidor
- Proyectos que evitan dependencias de JavaScript