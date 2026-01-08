<?php
/**
 * Configuración del gráfico
 * En un caso real, calcularías los porcentajes aquí o dejarías que JS lo haga.
 */
$chartConfigLight = [
    'title' => 'Chart title goes here',
    'id'    => 'lightDonutChart',
    'data'  => [
        [
            'label' => 'Long category label 01',
            'value' => 54,
            'color' => '#1976D2' // Azul fuerte
        ],
        [
            'label' => 'Long category label 02',
            'value' => 30,
            'color' => '#80DEEA' // Cian/Turquesa claro
        ],
        [
            'label' => 'Long category label 03',
            'value' => 26,
            'color' => '#EF5350' // Rojo suave
        ]
    ]
];

function renderLightChart($config) {
    // Preparamos los datos para JS
    $labels = json_encode(array_column($config['data'], 'label'));
    $values = json_encode(array_column($config['data'], 'value'));
    $colors = json_encode(array_column($config['data'], 'color'));
    ?>

    <style>
        .light-chart-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            width: 320px;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            /* Sombra suave para la tarjeta completa */
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
            text-align: center;
            color: #000;
        }

        .light-chart-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            margin-top: 0;
            color: #000;
        }

        .canvas-wrapper {
            position: relative;
            height: 220px;
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .light-legend {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: left;
            display: inline-block;
            width: 100%;
        }

        .light-legend li {
            margin-bottom: 12px;
            font-size: 15px;
            color: #788195; /* Gris azulado suave para el texto */
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .legend-circle {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 15px;
            flex-shrink: 0;
        }
    </style>

    <div class="light-chart-card">
        <h3 class="light-chart-title"><?php echo htmlspecialchars($config['title']); ?></h3>
        
        <div class="canvas-wrapper">
            <canvas id="<?php echo $config['id']; ?>"></canvas>
        </div>

        <ul class="light-legend">
            <?php foreach ($config['data'] as $item): ?>
                <li>
                    <span class="legend-circle" style="background-color: <?php echo $item['color']; ?>"></span>
                    <?php echo htmlspecialchars($item['label']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Registramos el plugin
            Chart.register(ChartDataLabels);

            const ctx = document.getElementById('<?php echo $config['id']; ?>').getContext('2d');
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: <?php echo $labels; ?>,
                    datasets: [{
                        data: <?php echo $values; ?>,
                        backgroundColor: <?php echo $colors; ?>,
                        borderWidth: 0,
                        hoverOffset: 10 // Efecto al pasar el mouse
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '55%', // Grosor de la dona
                    layout: {
                        padding: 20 // Espacio extra para que quepan las burbujas flotantes
                    },
                    plugins: {
                        legend: {
                            display: false // Usamos nuestra leyenda HTML personalizada
                        },
                        tooltip: {
                            enabled: false // Desactivamos tooltip estándar para priorizar las burbujas
                        },
                        // Configuración de las "Burbujas" (Etiquetas)
                        datalabels: {
                            color: '#000000',
                            backgroundColor: '#ffffff',
                            borderRadius: 50, // Hace el fondo circular
                            font: {
                                weight: 'bold',
                                size: 14,
                                family: 'Arial'
                            },
                            padding: {
                                top: 10,
                                bottom: 10,
                                left: 8,
                                right: 8
                            },
                            // Sombra simulada para la burbuja
                            listeners: {
                                enter: function(context) {
                                    context.hovered = true;
                                    return true;
                                },
                                leave: function(context) {
                                    context.hovered = false;
                                    return true;
                                }
                            },
                            // Formato del texto (añadir el %)
                            formatter: function(value, context) {
                                return value + '%';
                            },
                            // Posicionamiento
                            anchor: 'center',
                            align: 'center',
                            offset: 0,
                            // Sombra (Box Shadow no es nativo en canvas, se emula con bordes o plugins extra, 
                            // pero el contraste blanco sobre color funciona bien aquí).
                            borderColor: 'rgba(0,0,0,0.1)',
                            borderWidth: 1
                        }
                    }
                }
            });
        });
    </script>
    <?php
}

// Renderizar
renderLightChart($chartConfigLight);
?>