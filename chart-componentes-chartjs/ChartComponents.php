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
    public static function multiProgressCard($title, $progressItems, $theme = 'light') {
        return multiProgressCard($title, $progressItems, $theme);
    }
    
    /**
     * Tarjeta de progreso simple
     */
    public static function singleProgressCard($title, $subtitle, $percentage, $theme = 'light') {
        return singleProgressCard($title, $subtitle, $percentage, $theme);
    }
    
    /**
     * Tarjeta de progreso con icono
     */
    public static function iconProgressCard($title, $subtitle, $time, $icon = '🌙', $theme = 'light') {
        return iconProgressCard($title, $subtitle, $time, $icon, $theme);
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