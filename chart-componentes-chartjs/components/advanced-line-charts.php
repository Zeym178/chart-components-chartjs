<?php

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
function areaLineChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '15 April - 21 April', $color = '#147AD6', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'areaChart_' . uniqid();
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'area-chart-dark' : 'area-chart-light';
    
    // Preparar datos para Chart.js
    $chartData = json_encode($data);
    $chartLabels = json_encode($labels);
    
    // Colores para el área
    $gradientStart = $color . '40'; // 25% opacidad
    $gradientEnd = $color . '00';   // 0% opacidad
    
    return "
    <div class='chart-container {$themeClass}' style='width: 300px; height: 200px;'>
        <div class='area-chart-header'>
            <h4 class='area-chart-title'>" . htmlspecialchars($title) . "</h4>
            <p class='area-chart-subtitle'>" . htmlspecialchars($subtitle) . "</p>
        </div>
        
        <div class='area-chart-wrapper'>
            <canvas id='{$chartId}'></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            // Crear gradiente para el área
            const gradient = ctx.createLinearGradient(0, 0, 0, 180);
            gradient.addColorStop(0, '{$gradientStart}');
            gradient.addColorStop(1, '{$gradientEnd}');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {$chartLabels},
                    datasets: [{
                        data: {$chartData},
                        borderColor: '{$color}',
                        backgroundColor: gradient,
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 4,
                        pointHoverBackgroundColor: '{$color}',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '" . ($theme === 'dark' ? '#2c2f3f' : '#ffffff') . "',
                            titleColor: '" . ($theme === 'dark' ? '#ffffff' : '#1f2937') . "',
                            bodyColor: '" . ($theme === 'dark' ? '#ffffff' : '#1f2937') . "',
                            borderColor: '" . ($theme === 'dark' ? '#404452' : '#e5e7eb') . "',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            grid: {
                                color: '" . ($theme === 'dark' ? '#404452' : '#f3f4f6') . "',
                                borderColor: '" . ($theme === 'dark' ? '#404452' : '#e5e7eb') . "'
                            },
                            ticks: {
                                color: '" . ($theme === 'dark' ? '#9ca3af' : '#6b7280') . "',
                                font: { size: 11 }
                            }
                        },
                        y: {
                            display: true,
                            grid: {
                                color: '" . ($theme === 'dark' ? '#404452' : '#f3f4f6') . "',
                                borderColor: '" . ($theme === 'dark' ? '#404452' : '#e5e7eb') . "'
                            },
                            ticks: {
                                color: '" . ($theme === 'dark' ? '#9ca3af' : '#6b7280') . "',
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        });
    </script>";
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
function annotatedLineChart($data, $labels = [], $title = 'Chart title goes here', $subtitle = '15 April - 21 April', $annotationValue = '489', $annotationLabel = 'additional text', $color = '#147AD6', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'annotatedChart_' . uniqid();
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'annotated-chart-dark' : 'annotated-chart-light';
    
    // Preparar datos
    $chartData = json_encode($data);
    $chartLabels = json_encode($labels);
    
    return "
    <div class='chart-container {$themeClass}' style='width: 300px; height: 200px;'>
        <div class='annotated-chart-header'>
            <h4 class='annotated-chart-title'>" . htmlspecialchars($title) . "</h4>
            <p class='annotated-chart-subtitle'>" . htmlspecialchars($subtitle) . "</p>
        </div>
        
        <div class='annotated-chart-wrapper'>
            <div class='annotation-box'>
                <div class='annotation-value'>{$annotationValue}</div>
                <div class='annotation-label'>" . htmlspecialchars($annotationLabel) . "</div>
            </div>
            <canvas id='{$chartId}'></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {$chartLabels},
                    datasets: [{
                        data: {$chartData},
                        borderColor: '{$color}',
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '{$color}',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '" . ($theme === 'dark' ? '#2c2f3f' : '#ffffff') . "',
                            titleColor: '" . ($theme === 'dark' ? '#ffffff' : '#1f2937') . "',
                            bodyColor: '" . ($theme === 'dark' ? '#ffffff' : '#1f2937') . "',
                            borderColor: '" . ($theme === 'dark' ? '#404452' : '#e5e7eb') . "',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            grid: {
                                color: '" . ($theme === 'dark' ? '#404452' : '#f3f4f6') . "',
                                borderColor: '" . ($theme === 'dark' ? '#404452' : '#e5e7eb') . "'
                            },
                            ticks: {
                                color: '" . ($theme === 'dark' ? '#9ca3af' : '#6b7280') . "',
                                font: { size: 11 }
                            }
                        },
                        y: {
                            display: true,
                            grid: {
                                color: '" . ($theme === 'dark' ? '#404452' : '#f3f4f6') . "',
                                borderColor: '" . ($theme === 'dark' ? '#404452' : '#e5e7eb') . "'
                            },
                            ticks: {
                                color: '" . ($theme === 'dark' ? '#9ca3af' : '#6b7280') . "',
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        });
    </script>";
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
function multiLineChart($datasets, $labels = [], $title = 'Chart title goes here', $subtitle = '15 April - 21 April', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'multiChart_' . uniqid();
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'multi-chart-dark' : 'multi-chart-light';
    
    // Preparar datasets para Chart.js
    $chartDatasets = [];
    foreach ($datasets as $dataset) {
        $chartDatasets[] = [
            'label' => $dataset['label'],
            'data' => $dataset['data'],
            'borderColor' => $dataset['color'],
            'backgroundColor' => 'transparent',
            'borderWidth' => 2,
            'fill' => false,
            'tension' => 0.4,
            'pointRadius' => 0,
            'pointHoverRadius' => 4,
            'pointHoverBackgroundColor' => $dataset['color'],
            'pointHoverBorderColor' => '#ffffff',
            'pointHoverBorderWidth' => 2
        ];
    }
    
    $chartData = json_encode($chartDatasets);
    $chartLabels = json_encode($labels);
    
    return "
    <div class='chart-container {$themeClass}' style='width: 300px; height: 200px;'>
        <div class='multi-chart-header'>
            <h4 class='multi-chart-title'>" . htmlspecialchars($title) . "</h4>
            <p class='multi-chart-subtitle'>" . htmlspecialchars($subtitle) . "</p>
        </div>
        
        <div class='multi-chart-wrapper'>
            <canvas id='{$chartId}'></canvas>
        </div>
        
        <div class='multi-chart-legend'>
            " . implode('', array_map(function($dataset) {
                return "<div class='legend-item'>
                    <span class='legend-color' style='background-color: {$dataset['color']};'></span>
                    <span class='legend-text'>" . htmlspecialchars($dataset['label']) . "</span>
                </div>";
            }, $datasets)) . "
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {$chartLabels},
                    datasets: {$chartData}
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '" . ($theme === 'dark' ? '#2c2f3f' : '#ffffff') . "',
                            titleColor: '" . ($theme === 'dark' ? '#ffffff' : '#1f2937') . "',
                            bodyColor: '" . ($theme === 'dark' ? '#ffffff' : '#1f2937') . "',
                            borderColor: '" . ($theme === 'dark' ? '#404452' : '#e5e7eb') . "',
                            borderWidth: 1,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            grid: {
                                color: '" . ($theme === 'dark' ? '#404452' : '#f3f4f6') . "',
                                borderColor: '" . ($theme === 'dark' ? '#404452' : '#e5e7eb') . "'
                            },
                            ticks: {
                                color: '" . ($theme === 'dark' ? '#9ca3af' : '#6b7280') . "',
                                font: { size: 11 }
                            }
                        },
                        y: {
                            display: true,
                            grid: {
                                color: '" . ($theme === 'dark' ? '#404452' : '#f3f4f6') . "',
                                borderColor: '" . ($theme === 'dark' ? '#404452' : '#e5e7eb') . "'
                            },
                            ticks: {
                                color: '" . ($theme === 'dark' ? '#9ca3af' : '#6b7280') . "',
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        });
    </script>";
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
function compactLineChart($title = 'Chart title', $value = '2,476', $data = [], $color = '#147AD6', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'compactLine_' . uniqid();
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'compact-line-dark' : 'compact-line-light';
    
    $chartData = json_encode($data);
    
    return "
    <div class='chart-container {$themeClass}' style='width: 140px; height: 100px;'>
        <div class='compact-line-content'>
            <h5 class='compact-line-title'>" . htmlspecialchars($title) . "</h5>
            <div class='compact-line-value'>{$value}</div>
        </div>
        <div class='compact-line-chart'>
            <canvas id='{$chartId}'></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Array({" . count($data) . "}).fill(''),
                    datasets: [{
                        data: {$chartData},
                        borderColor: '{$color}',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    events: [],
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    },
                    scales: {
                        x: { display: false },
                        y: { display: false }
                    }
                }
            });
        });
    </script>";
}

?>