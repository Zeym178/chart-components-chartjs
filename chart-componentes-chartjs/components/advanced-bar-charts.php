<?php

/**
 * Gráfico de barras simple con valor destacado
 * @param array $data Datos del gráfico [500, 750, 600, 350, 400, 300, 350]
 * @param array $labels Etiquetas ['M', 'T', 'W', 'T', 'F', 'S', 'S']
 * @param string $mainValue Valor principal a destacar (ej: "$476")
 * @param string $subtitle Subtítulo (ej: "Daily average")
 * @param string $color Color principal (hex)
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function valueBarChart($data, $labels = ['M', 'T', 'W', 'T', 'F', 'S', 'S'], $mainValue = '$476', $subtitle = 'Daily average', $color = '#147AD6', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'valueBar_' . uniqid();
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'value-bar-dark' : 'value-bar-light';
    
    // Preparar datos con colores grises y destacados
    $chartData = json_encode($data);
    $chartLabels = json_encode($labels);
    
    // Crear array de colores - gris para la mayoría, color destacado para algunos
    $greyColor = $theme === 'dark' ? '#4B5563' : '#D1D5DB';
    $colors = array_fill(0, count($data), $greyColor);
    // Destacar las barras más altas
    $maxValue = max($data);
    foreach($data as $index => $value) {
        if($value >= $maxValue * 0.8) { // Si es >= 80% del valor máximo
            $colors[$index] = $color;
        }
    }
    $chartColors = json_encode($colors);
    
    return "
    <div class='chart-container {$themeClass}' style='width: 280px; height: 250px;'>
        <div class='value-bar-header'>
            <div class='value-bar-main'>{$mainValue}</div>
            <div class='value-bar-subtitle'>" . htmlspecialchars($subtitle) . "</div>
            <div class='value-bar-menu'>⋯</div>
        </div>
        
        <div class='value-bar-wrapper'>
            <canvas id='{$chartId}'></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {$chartLabels},
                    datasets: [{
                        data: {$chartData},
                        backgroundColor: {$chartColors},
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        barThickness: 24
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
                            grid: { display: false },
                            ticks: {
                                color: '" . ($theme === 'dark' ? '#9ca3af' : '#6b7280') . "',
                                font: { size: 12 }
                            }
                        },
                        y: {
                            display: true,
                            grid: {
                                color: '" . ($theme === 'dark' ? '#374151' : '#f3f4f6') . "',
                                borderColor: '" . ($theme === 'dark' ? '#374151' : '#e5e7eb') . "'
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
 * Gráfico de barras con anotación destacada
 * @param array $data Datos del gráfico
 * @param array $labels Etiquetas para el eje X
 * @param string $title Título del gráfico
 * @param string $subtitle Subtítulo del gráfico
 * @param string $annotationValue Valor destacado (ej: "742")
 * @param string $annotationLabel Etiqueta de la anotación
 * @param string $color Color principal (hex)
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function annotatedBarChart($data, $labels = ['M', 'T', 'W', 'T', 'F', 'S', 'S'], $title = 'Chart title goes here', $subtitle = '15 April - 21 April', $annotationValue = '742', $annotationLabel = 'additional text', $color = '#147AD6', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'annotatedBar_' . uniqid();
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'annotated-bar-dark' : 'annotated-bar-light';
    
    // Preparar datos con colores grises y destacados
    $greyColor = $theme === 'dark' ? '#4B5563' : '#D1D5DB';
    $colors = array_fill(0, count($data), $greyColor);
    // Destacar la barra con el valor más alto
    $maxIndex = array_search(max($data), $data);
    $colors[$maxIndex] = $color;
    
    $chartData = json_encode($data);
    $chartLabels = json_encode($labels);
    $chartColors = json_encode($colors);
    
    return "
    <div class='chart-container {$themeClass}' style='width: 300px; height: 280px;'>
        <div class='annotated-bar-header'>
            <h4 class='annotated-bar-title'>" . htmlspecialchars($title) . "</h4>
            <p class='annotated-bar-subtitle'>" . htmlspecialchars($subtitle) . "</p>
        </div>
        
        <div class='annotated-bar-wrapper'>
            <div class='bar-annotation'>
                <span class='annotation-value'>{$annotationValue}</span>
                <span class='annotation-text'>" . htmlspecialchars($annotationLabel) . "</span>
            </div>
            <canvas id='{$chartId}'></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {$chartLabels},
                    datasets: [{
                        data: {$chartData},
                        backgroundColor: '{$color}',
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        barThickness: 24
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
                            grid: { display: false },
                            ticks: {
                                color: '" . ($theme === 'dark' ? '#9ca3af' : '#6b7280') . "',
                                font: { size: 12 }
                            }
                        },
                        y: {
                            display: true,
                            grid: {
                                color: '" . ($theme === 'dark' ? '#374151' : '#f3f4f6') . "',
                                borderColor: '" . ($theme === 'dark' ? '#374151' : '#e5e7eb') . "'
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
 * Gráfico de barras con valores mostrados en las barras
 * @param array $data Datos del gráfico
 * @param array $labels Etiquetas para el eje X
 * @param string $title Título del gráfico
 * @param string $subtitle Subtítulo del gráfico
 * @param string $color Color principal (hex)
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function labeledBarChart($data, $labels = ['M', 'T', 'W', 'T', 'F', 'S', 'S'], $title = 'Chart title goes here', $subtitle = '15 April - 21 April', $color = '#147AD6', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'labeledBar_' . uniqid();
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'labeled-bar-dark' : 'labeled-bar-light';
    
    $chartData = json_encode($data);
    $chartLabels = json_encode($labels);
    
    return "
    <div class='chart-container {$themeClass}' style='width: 300px; height: 280px;'>
        <div class='labeled-bar-header'>
            <h4 class='labeled-bar-title'>" . htmlspecialchars($title) . "</h4>
            <p class='labeled-bar-subtitle'>" . htmlspecialchars($subtitle) . "</p>
        </div>
        
        <div class='labeled-bar-wrapper'>
            <canvas id='{$chartId}'></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {$chartLabels},
                    datasets: [{
                        data: {$chartData},
                        backgroundColor: '{$color}',
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        barThickness: 24
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
                        },
                        datalabels: {
                            display: true,
                            anchor: 'end',
                            align: 'top',
                            color: '" . ($theme === 'dark' ? '#ffffff' : '#374151') . "',
                            font: {
                                size: 11,
                                weight: 600
                            },
                            formatter: function(value) {
                                return value;
                            },
                            padding: 4
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            grid: { display: false },
                            ticks: {
                                color: '" . ($theme === 'dark' ? '#9ca3af' : '#6b7280') . "',
                                font: { size: 12 }
                            }
                        },
                        y: {
                            display: true,
                            grid: {
                                color: '" . ($theme === 'dark' ? '#374151' : '#f3f4f6') . "',
                                borderColor: '" . ($theme === 'dark' ? '#374151' : '#e5e7eb') . "'
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
 * Gráfico de barras múltiples con diferentes series
 * @param array $datasets Array de datasets: [['label' => 'Point 01', 'data' => [...], 'color' => '#147AD6'], ...]
 * @param array $labels Etiquetas para el eje X
 * @param string $title Título del gráfico
 * @param string $subtitle Subtítulo del gráfico
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function multiBarChart($datasets, $labels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'], $title = 'Chart title goes here', $subtitle = 'Last 6 months', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'multiBar_' . uniqid();
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'multi-bar-dark' : 'multi-bar-light';
    
    // Preparar datasets para Chart.js
    $chartDatasets = [];
    foreach ($datasets as $dataset) {
        $chartDatasets[] = [
            'label' => $dataset['label'],
            'data' => $dataset['data'],
            'backgroundColor' => $dataset['color'],
            'borderWidth' => 0,
            'borderRadius' => 4,
            'borderSkipped' => false,
            'barThickness' => 20
        ];
    }
    
    $chartData = json_encode($chartDatasets);
    $chartLabels = json_encode($labels);
    
    return "
    <div class='chart-container {$themeClass}' style='width: 320px; height: 300px;'>
        <div class='multi-bar-header'>
            <h4 class='multi-bar-title'>" . htmlspecialchars($title) . "</h4>
            <p class='multi-bar-subtitle'>" . htmlspecialchars($subtitle) . "</p>
            <div class='multi-bar-menu'>⋯</div>
        </div>
        
        <div class='multi-bar-wrapper'>
            <canvas id='{$chartId}'></canvas>
        </div>
        
        <div class='multi-bar-legend'>
            " . implode('', array_map(function($dataset) {
                return "<div class='bar-legend-item'>
                    <span class='bar-legend-dot' style='background-color: {$dataset['color']};'></span>
                    <span class='bar-legend-text'>" . htmlspecialchars($dataset['label']) . "</span>
                </div>";
            }, $datasets)) . "
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {$chartLabels},
                    datasets: {$chartData}
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
                            grid: { display: false },
                            ticks: {
                                color: '" . ($theme === 'dark' ? '#9ca3af' : '#6b7280') . "',
                                font: { size: 12 }
                            }
                        },
                        y: {
                            display: true,
                            grid: {
                                color: '" . ($theme === 'dark' ? '#374151' : '#f3f4f6') . "',
                                borderColor: '" . ($theme === 'dark' ? '#374151' : '#e5e7eb') . "'
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
 * Gráfico de barras combinadas (positivas y negativas)
 * @param array $positiveData Datos positivos
 * @param array $negativeData Datos negativos
 * @param array $labels Etiquetas para el eje X
 * @param string $title Título del gráfico
 * @param string $subtitle Subtítulo del gráfico
 * @param string $positiveColor Color para valores positivos
 * @param string $negativeColor Color para valores negativos
 * @param string $theme 'light' o 'dark'
 * @param string $chartId ID único para el canvas (opcional)
 */
function combinedBarChart($positiveData, $negativeData, $labels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'], $title = 'Chart title goes here', $subtitle = 'Last 6 months', $positiveColor = '#147AD6', $negativeColor = '#EC6666', $theme = 'light', $chartId = null) {
    $chartId = $chartId ?: 'combinedBar_' . uniqid();
    
    // Clases de tema
    $themeClass = $theme === 'dark' ? 'combined-bar-dark' : 'combined-bar-light';
    
    $chartLabels = json_encode($labels);
    $posData = json_encode($positiveData);
    $negData = json_encode($negativeData);
    
    return "
    <div class='chart-container {$themeClass}' style='width: 320px; height: 300px;'>
        <div class='combined-bar-header'>
            <h4 class='combined-bar-title'>" . htmlspecialchars($title) . "</h4>
            <p class='combined-bar-subtitle'>" . htmlspecialchars($subtitle) . "</p>
            <div class='combined-bar-menu'>⋯</div>
        </div>
        
        <div class='combined-bar-wrapper'>
            <canvas id='{$chartId}'></canvas>
        </div>
        
        <div class='combined-bar-legend'>
            <div class='bar-legend-item'>
                <span class='bar-legend-dot' style='background-color: {$positiveColor};'></span>
                <span class='bar-legend-text'>Point 01</span>
            </div>
            <div class='bar-legend-item'>
                <span class='bar-legend-dot' style='background-color: {$negativeColor};'></span>
                <span class='bar-legend-text'>Point 02</span>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('{$chartId}').getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {$chartLabels},
                    datasets: [{
                        label: 'Positive',
                        data: {$posData},
                        backgroundColor: '{$positiveColor}',
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        barThickness: 16
                    }, {
                        label: 'Negative',
                        data: {$negData},
                        backgroundColor: '{$negativeColor}',
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        barThickness: 16
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
                            grid: { display: false },
                            ticks: {
                                color: '" . ($theme === 'dark' ? '#9ca3af' : '#6b7280') . "',
                                font: { size: 12 }
                            }
                        },
                        y: {
                            display: true,
                            grid: {
                                color: '" . ($theme === 'dark' ? '#374151' : '#f3f4f6') . "',
                                borderColor: '" . ($theme === 'dark' ? '#374151' : '#e5e7eb') . "'
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

?>