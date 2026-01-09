<?php

class ChartComponents 
{
    public function __construct() {}
    
    /**
     * Incluir todos los archivos de componentes
     */
    public static function init() {
        $basePath = __DIR__ . '/components/';
        
        require_once $basePath . 'color-palette.php';
        require_once $basePath . 'metrics.php';
        require_once $basePath . 'bar-chart.php';
        require_once $basePath . 'progress-bars.php';
        require_once $basePath . 'line-charts.php';
        
        // ******************** MARSHALL COMPONENTS ********************
        require_once $basePath . 'donut-charts.php';
        require_once $basePath . 'carousel-charts.php';
        require_once $basePath . 'single-combined.php';
        require_once $basePath . 'size-charts.php';
        require_once $basePath . 'advanced-line-charts.php';
        require_once $basePath . 'pie-donut-charts.php';
        // ************************************************************
    }
    
    /**
     * Obtener los estilos CSS necesarios
     */
    public static function getStyles() {
        return file_get_contents(__DIR__ . '/styles/chart-themes.css');
    }
    
    /**
     * Obtener el script de Chart.js CDN
     */
    public static function getChartJsScript() {
        // Usar la versión UMD para navegador, que auto-registra escalas/controladores
        return '<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>';
    }
    
    /**
     * Paleta de colores
     */
    public static function colorPalette($theme = 'light') {
        return colorPalette($theme);
    }
    
    /**
     * Tarjeta de métrica simple
     */
    public static function metricCard($title, $value, $subtitle = '', $alignment = 'left', $theme = 'light') {
        return metricCard($title, $value, $subtitle, $alignment, $theme);
    }
    
    /**
     * Tarjeta de número grande
     */
    public static function largeNumberCard($number, $label = '', $theme = 'light') {
        return largeNumberCard($number, $label, $theme);
    }
    
    /**
     * Gráfico de barras
     * @param array $data Array de arrays con los datos [[10,20,30,40,50,60], [15,25,35,45,55,65]]
     * @param array $labels Etiquetas para cada serie de datos ['Point 01', 'Point 02']
     * @param string $title Título del gráfico
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function barChart($data, $labels = [], $title = 'Chart title goes here', $theme = 'light', $chartId = null) {
        return barChart($data, $labels, $title, $theme, $chartId);
    }
    
    /**
     * Barra de progreso individual
     */
    public static function progressBar($label, $value, $total = 100, $color = 'primary', $theme = 'light') {
        return progressBar($label, $value, $total, $color, $theme);
    }
    
    /**
     * Tarjeta con múltiples barras de progreso
     */
    public static function multiProgressCard($title, $progressItems, $theme = 'light', $size = 'auto') {
        return multiProgressCard($title, $progressItems, $theme, $size);
    }
    
    /**
     * Tarjeta de progreso simple
     */
    public static function singleProgressCard($title, $subtitle, $percentage, $theme = 'light', $size = 'auto') {
        return singleProgressCard($title, $subtitle, $percentage, $theme, $size);
    }
    
    /**
     * Tarjeta de progreso con icono
     */
    public static function iconProgressCard($title, $subtitle, $time, $icon = '🌙', $theme = 'light', $size = 'auto') {
        return iconProgressCard($title, $subtitle, $time, $icon, $theme, $size);
    }
    
    /**
     * Gráfico de línea
     * @param array $data Array de arrays con los datos [[100,150,200,120,180,160], [80,120,160,140,200,180]]
     * @param array $labels Etiquetas para cada serie de datos
     * @param string $title Título del gráfico
     * @param string $subtitle Subtítulo del gráfico
     * @param string $type Tipo: 'line', 'smooth', 'area'
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function lineChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '', $type = 'line', $theme = 'light', $chartId = null) {
        return lineChart($data, $labels, $title, $subtitle, $type, $theme, $chartId);
    }
    
    /**
     * Gráfico de área
     */
    public static function areaChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '', $theme = 'light', $chartId = null) {
        return areaChart($data, $labels, $title, $subtitle, $theme, $chartId);
    }
    
    /**
     * Gráfico de línea suavizada
     */
    public static function smoothLineChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '', $theme = 'light', $chartId = null) {
        return smoothLineChart($data, $labels, $title, $subtitle, $theme, $chartId);
    }
    
    /**
     * Gráfico de línea con anotación
     */
    public static function lineChartWithAnnotation($data, $labels, $title, $subtitle, $annotation, $theme = 'light', $chartId = null) {
        return lineChartWithAnnotation($data, $labels, $title, $subtitle, $annotation, $theme, $chartId);
    }
    
    // ******************** MARSHALL COMPONENTS ********************
    
    /**
     * Gráfico de dona de 3 categorías
     * @param array $data Array con datos: [['label' => 'Label', 'value' => 55, 'color' => '#1976D2'], ...]
     * @param string $title Título del gráfico
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function donutChart3Categories($data, $title = 'Chart title goes here', $theme = 'light', $chartId = null) {
        return donutChart3Categories($data, $title, $theme, $chartId);
    }
    
    /**
     * Gráfico de anillo (ring chart) de 4 categorías con porcentaje central
     * @param array $data Array con datos: [['label' => 'Point 01', 'value' => 76, 'color' => '#1976D2'], ...]
     * @param string $title Título del gráfico
     * @param int $totalPercent Porcentaje principal a mostrar en el centro
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function ringChart4Categories($data, $title = 'Chart title goes here', $totalPercent = 76, $theme = 'light', $chartId = null) {
        return ringChart4Categories($data, $title, $totalPercent, $theme, $chartId);
    }
    
    /**
     * Tarjeta de gráfico tipo carousel con paginación
     * @param string $title Título del gráfico
     * @param string $subtitle Subtítulo
     * @param int $percent Porcentaje (0-100)
     * @param string $color Color del gráfico (hex)
     * @param int $activeDot Cuál punto de paginación está activo (1-3)
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function carouselChart($title = 'Chart title', $subtitle = 'Here go numbers XX of total XX', $percent = 76, $color = '#1976D2', $activeDot = 1, $theme = 'light', $chartId = null) {
        return carouselChart($title, $subtitle, $percent, $color, $activeDot, $theme, $chartId);
    }
    
    /**
     * Lista vertical de tarjetas con mini gráficos de dona
     * @param array $items Array de items: [['id' => 'unique', 'percent' => 76, 'title' => 'Challenge 01', 'subtitle' => 'XX of total XX', 'color' => '#1976D2'], ...]
     * @param string $theme 'light' o 'dark'
     */
    public static function challengeList($items, $theme = 'light') {
        return challengeList($items, $theme);
    }
    
    /**
     * Tarjeta compacta horizontal con número grande y mini gráfico donut
     * @param string $value Valor principal (ej: "354")
     * @param string $label Etiqueta (ej: "Category")
     * @param int $percent Porcentaje para el gráfico (0-100)
     * @param string $color Color del gráfico (hex)
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function compactStatCard($value, $label, $percent = 75, $color = '#1976D2', $theme = 'light', $chartId = null) {
        return compactStatCard($value, $label, $percent, $color, $theme, $chartId);
    }
    
    /**
     * Tarjeta horizontal con texto e info en la izquierda y mini gráfico a la derecha
     * @param string $title Título (ej: "Challenge 01")
     * @param string $subtitle Subtítulo (ej: "XX of total XX")
     * @param int $percent Porcentaje (0-100)
     * @param string $color Color del gráfico (hex)
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function horizontalCard($title, $subtitle, $percent = 76, $color = '#1976D2', $theme = 'light', $chartId = null) {
        return horizontalCard($title, $subtitle, $percent, $color, $theme, $chartId);
    }
    
    /**
     * Gráfico de línea con área (Area Chart)
     * @param array $data Datos del gráfico [[100,150,200,120,180,160]]
     * @param array $labels Etiquetas para el eje X ['Jan', 'Feb', 'Mar', ...]
     * @param string $title Título del gráfico
     * @param string $subtitle Subtítulo del gráfico
     * @param string $color Color principal (hex)
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function areaLineChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '15 April - 21 April', $color = '#147AD6', $theme = 'light', $chartId = null) {
        return areaLineChart($data, $labels, $title, $subtitle, $color, $theme, $chartId);
    }
    
    /**
     * Gráfico de línea con anotación destacada
     * @param array $data Datos del gráfico [100,150,200,120,180,160]
     * @param array $labels Etiquetas para el eje X
     * @param string $title Título del gráfico
     * @param string $subtitle Subtítulo del gráfico
     * @param string $annotationValue Valor a destacar (ej: "489")
     * @param string $annotationLabel Etiqueta de la anotación (ej: "additional text")
     * @param string $color Color principal (hex)
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function annotatedLineChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '15 April - 21 April', $annotationValue = '489', $annotationLabel = 'additional text', $color = '#147AD6', $theme = 'light', $chartId = null) {
        return annotatedLineChart($data, $labels, $title, $subtitle, $annotationValue, $annotationLabel, $color, $theme, $chartId);
    }
    
    /**
     * Gráfico de líneas múltiples con leyenda
     * @param array $datasets Array de datasets: [['label' => 'Point 01', 'data' => [...], 'color' => '#1976D2'], ...]
     * @param array $labels Etiquetas para el eje X
     * @param string $title Título del gráfico
     * @param string $subtitle Subtítulo del gráfico
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function multiLineChart($datasets, $labels = [], $title = 'Chart title goes here', $subtitle = '15 April - 21 April', $theme = 'light', $chartId = null) {
        return multiLineChart($datasets, $labels, $title, $subtitle, $theme, $chartId);
    }
    
    /**
     * Tarjeta compacta con mini gráfico de línea
     * @param string $title Título (ej: "Chart title")
     * @param string $value Valor destacado (ej: "2,476")
     * @param array $data Datos para el mini gráfico [100,150,200,120,180,160]
     * @param string $color Color de la línea (hex)
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function compactLineChart($title = 'Chart title', $value = '2,476', $data = [], $color = '#147AD6', $theme = 'light', $chartId = null) {
        return compactLineChart($title, $value, $data, $color, $theme, $chartId);
    }
    
    /**
     * Gráfico de dona simple con porcentaje central
     * @param int $percentage Porcentaje a mostrar (0-100)
     * @param string $title Título del gráfico
     * @param string $subtitle Subtítulo del gráfico
     * @param string $color Color principal (hex)
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function simpleDonutChart($percentage = 58, $title = 'Chart title', $subtitle = '15 April - 15 May', $color = '#147AD6', $theme = 'light', $chartId = null) {
        return simpleDonutChart($percentage, $title, $subtitle, $color, $theme, $chartId);
    }
    
    /**
     * Gráfico de pie simple sin leyenda
     * @param array $data Array con valores [35, 25, 20, 20]
     * @param array $colors Array con colores ['#3498db', '#2ecc71', '#e74c3c', '#f39c12']
     * @param string $title Título del gráfico
     * @param string $subtitle Subtítulo del gráfico
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function simplePieChart($data = [35, 25, 20, 20], $colors = ['#147AD6', '#EC6666', '#79D2DE', '#F97316'], $title = 'Chart title', $subtitle = 'Here go numbers XX of total XX', $theme = 'light', $chartId = null) {
        return simplePieChart($data, $colors, $title, $subtitle, $theme, $chartId);
    }
    
    /**
     * Gráfico de pie con leyenda personalizada
     * @param array $data Array con datos: [['label' => 'Point 01', 'value' => 40, 'color' => '#3498db'], ...]
     * @param string $title Título del gráfico
     * @param string $theme 'light' o 'dark'
     * @param string $chartId ID único para el canvas (opcional)
     */
    public static function pieChartWithLegend($data = [], $title = 'Chart title goes here', $theme = 'light', $chartId = null) {
        return pieChartWithLegend($data, $title, $theme, $chartId);
    }
    
    /**
     * Dashboard completo con múltiples gráficos tipo grid
     * @param array $donutCharts Array de configuraciones para donuts
     * @param array $pieCharts Array de configuraciones para pies
     * @param string $theme 'light' o 'dark'
     */
    public static function chartDashboard($donutCharts = [], $pieCharts = [], $theme = 'light') {
        return chartDashboard($donutCharts, $pieCharts, $theme);
    }
    
    // =================== Marshall: Advanced Bar Charts Methods ===================
    
    /**
     * Gráfico de barras con valor destacado
     */
    public static function valueBarChart($data, $labels = ['M', 'T', 'W', 'T', 'F', 'S', 'S'], $mainValue = '$476', $subtitle = 'Daily average', $color = '#147AD6', $theme = 'light', $chartId = null) {
        include_once 'components/advanced-bar-charts.php';
        return valueBarChart($data, $labels, $mainValue, $subtitle, $color, $theme, $chartId);
    }

    /**
     * Gráfico de barras con anotación destacada
     */
    public static function annotatedBarChart($data, $labels = ['M', 'T', 'W', 'T', 'F', 'S', 'S'], $title = 'Chart title goes here', $subtitle = '15 April - 21 April', $annotationValue = '742', $annotationLabel = 'additional text', $color = '#147AD6', $theme = 'light', $chartId = null) {
        include_once 'components/advanced-bar-charts.php';
        return annotatedBarChart($data, $labels, $title, $subtitle, $annotationValue, $annotationLabel, $color, $theme, $chartId);
    }

    /**
     * Gráfico de barras con valores mostrados en las barras
     */
    public static function labeledBarChart($data, $labels = ['M', 'T', 'W', 'T', 'F', 'S', 'S'], $title = 'Chart title goes here', $subtitle = '15 April - 21 April', $color = '#147AD6', $theme = 'light', $chartId = null) {
        include_once 'components/advanced-bar-charts.php';
        return labeledBarChart($data, $labels, $title, $subtitle, $color, $theme, $chartId);
    }

    /**
     * Gráfico de barras múltiples con diferentes series
     */
    public static function multiBarChart($datasets, $labels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'], $title = 'Chart title goes here', $subtitle = 'Last 6 months', $theme = 'light', $chartId = null) {
        include_once 'components/advanced-bar-charts.php';
        return multiBarChart($datasets, $labels, $title, $subtitle, $theme, $chartId);
    }

    /**
     * Gráfico de barras combinadas (positivas y negativas)
     */
    public static function combinedBarChart($positiveData, $negativeData, $labels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'], $title = 'Chart title goes here', $subtitle = 'Last 6 months', $positiveColor = '#147AD6', $negativeColor = '#EC6666', $theme = 'light', $chartId = null) {
        include_once 'components/advanced-bar-charts.php';
        return combinedBarChart($positiveData, $negativeData, $labels, $title, $subtitle, $positiveColor, $negativeColor, $theme, $chartId);
    }
    
    // ************************************************************
    
    /**
     * Generar HTML completo con estilos incluidos
     */
    public static function renderComplete($content, $title = 'Chart Components Demo', $theme = 'light') {
        $styles = self::getStyles();
        $chartScript = self::getChartJsScript();
        $themeClass = $theme === 'dark' ? 'theme-dark' : 'theme-light';
        
        return "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$title}</title>
            <style>
                * { box-sizing: border-box; margin: 0; padding: 0; }
                body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
                .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
                .grid { display: grid; gap: 20px; }
                .grid-2 { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }
                .grid-3 { grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); }
                .grid-4 { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
                {$styles}
            </style>
            {$chartScript}
        </head>
        <body class='{$themeClass}'>
            <div class='container'>
                {$content}
            </div>
        </body>
        </html>";
    }
}
?>