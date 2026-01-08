<?php

class NativeChartComponents 
{
    public function __construct() {}
    
    /**
     * Incluir todos los archivos de componentes nativos
     */
    public static function init() {
        $basePath = __DIR__ . '/components/';
        
        require_once $basePath . 'color-palette-native.php';
        require_once $basePath . 'metrics-native.php';
        require_once $basePath . 'bar-chart-native.php';
        require_once $basePath . 'progress-native.php';
        require_once $basePath . 'line-chart-native.php';
    }
    
    /**
     * Obtener los estilos CSS necesarios
     */
    public static function getStyles() {
        return file_get_contents(__DIR__ . '/styles/native-themes.css');
    }
    
    // ==========================================
    // COMPONENTES DE COLOR Y MÉTRICAS
    // ==========================================
    
    /**
     * Paleta de colores nativa
     */
    public static function colorPalette($theme = 'light') {
        return nativeColorPalette($theme);
    }
    
    /**
     * Tarjeta de métrica simple nativa
     */
    public static function metricCard($title, $value, $subtitle = '', $alignment = 'left', $theme = 'light') {
        return nativeMetricCard($title, $value, $subtitle, $alignment, $theme);
    }
    
    /**
     * Tarjeta de número grande nativo
     */
    public static function largeNumberCard($number, $label = '', $theme = 'light') {
        return nativeLargeNumberCard($number, $label, $theme);
    }
    
    /**
     * Tarjeta de texto con colores (como h1-left-alignment, etc.)
     */
    public static function textCard($title, $subtitle, $alignment = 'left', $color = '', $theme = 'light') {
        return nativeTextCard($title, $subtitle, $alignment, $color, $theme);
    }
    
    /**
     * Tarjeta de valor con unidades
     */
    public static function valueCard($value, $unit, $description, $alignment = 'left', $theme = 'light') {
        return nativeValueCard($value, $unit, $description, $alignment, $theme);
    }
    
    // ==========================================
    // GRÁFICOS DE BARRAS
    // ==========================================
    
    /**
     * Gráfico de barras nativo con SVG
     * @param array $data Array de arrays con los datos [[10,20,30,40,50,60], [15,25,35,45,55,65]]
     * @param array $labels Etiquetas para cada serie de datos ['Point 01', 'Point 02']
     * @param string $title Título del gráfico
     * @param string $theme 'light' o 'dark'
     */
    public static function barChart($data, $labels = [], $title = 'Chart title goes here', $theme = 'light') {
        return nativeBarChart($data, $labels, $title, $theme);
    }
    
    // ==========================================
    // BARRAS DE PROGRESO
    // ==========================================
    
    /**
     * Barra de progreso individual nativa
     */
    public static function progressBar($label, $value, $total = 100, $color = 'blue', $theme = 'light') {
        return nativeProgressBar($label, $value, $total, $color, $theme);
    }
    
    /**
     * Tarjeta con múltiples barras de progreso nativas
     */
    public static function multiProgressCard($title, $progressItems, $theme = 'light') {
        return nativeMultiProgressCard($title, $progressItems, $theme);
    }
    
    /**
     * Tarjeta de progreso simple nativa
     */
    public static function singleProgressCard($title, $subtitle, $percentage, $theme = 'light') {
        return nativeSingleProgressCard($title, $subtitle, $percentage, $theme);
    }
    
    /**
     * Tarjeta de progreso con icono nativa
     */
    public static function iconProgressCard($title, $subtitle, $time, $icon = '🌙', $theme = 'light') {
        return nativeIconProgressCard($title, $subtitle, $time, $icon, $theme);
    }
    
    /**
     * Progreso circular nativo
     */
    public static function circularProgress($percentage, $size = 80, $theme = 'light') {
        return nativeCircularProgress($percentage, $size, $theme);
    }
    
    // ==========================================
    // GRÁFICOS DE LÍNEA
    // ==========================================
    
    /**
     * Gráfico de línea nativo con SVG
     * @param array $data Array de arrays con los datos [[100,150,200,120,180,160], [80,120,160,140,200,180]]
     * @param array $labels Etiquetas para cada serie de datos
     * @param string $title Título del gráfico
     * @param string $subtitle Subtítulo del gráfico
     * @param string $type Tipo: 'line', 'smooth', 'area'
     * @param string $theme 'light' o 'dark'
     */
    public static function lineChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '', $type = 'line', $theme = 'light') {
        return nativeLineChart($data, $labels, $title, $subtitle, $type, $theme);
    }
    
    /**
     * Gráfico de área nativo
     */
    public static function areaChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '', $theme = 'light') {
        return nativeAreaChart($data, $labels, $title, $subtitle, $theme);
    }
    
    /**
     * Gráfico de línea suavizada nativo
     */
    public static function smoothLineChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '', $theme = 'light') {
        return nativeSmoothLineChart($data, $labels, $title, $subtitle, $theme);
    }
    
    /**
     * Gráfico de línea con anotación nativo
     */
    public static function lineChartWithAnnotation($data, $labels, $title, $subtitle, $annotation, $theme = 'light') {
        return nativeLineChartWithAnnotation($data, $labels, $title, $subtitle, $annotation, $theme);
    }
    
    // ==========================================
    // UTILIDADES
    // ==========================================
    
    /**
     * Generar HTML completo con estilos incluidos
     */
    public static function renderComplete($content, $title = 'Native Chart Components Demo', $theme = 'light') {
        $styles = self::getStyles();
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
                body { 
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
                    line-height: 1.5;
                }
                .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
                {$styles}
            </style>
        </head>
        <body class='{$themeClass}'>
            <div class='container'>
                {$content}
            </div>
        </body>
        </html>";
    }
    
    /**
     * Generar datos de ejemplo para pruebas
     */
    public static function getSampleData() {
        return [
            'barData' => [
                [30000, 50000, 70000, 40000, 60000, 65000], // Point 01
                [20000, 40000, 50000, 35000, 45000, 55000]  // Point 02
            ],
            'lineData' => [
                [350, 450, 200, 350, 480, 230], // Área
                [250, 400, 300, 200, 350, 400], // Línea 1
                [150, 250, 400, 300, 250, 350]  // Línea 2
            ],
            'progressData' => [
                ['label' => 'XX of total XX', 'value' => 25, 'color' => 'blue'],
                ['label' => 'XX of total XX', 'value' => 65, 'color' => 'red'],
                ['label' => 'XX of total XX', 'value' => 45, 'color' => 'cyan']
            ]
        ];
    }
}
?>