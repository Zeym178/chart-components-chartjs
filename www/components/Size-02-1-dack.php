<?php
/**
 * Renderiza una tarjeta horizontal con gráfico pequeño a la derecha.
 * @param string $id ID único para el canvas.
 * @param string $title Título principal (ej: Challenge 01).
 * @param string $subtitle Subtítulo (ej: XX of total XX).
 * @param int $percent Porcentaje (0-100).
 * @param string $colorHex Color del gráfico (hex).
 * @param string $theme 'light' o 'dark'.
 */
function renderHorizontalCard($id, $title, $subtitle, $percent, $colorHex, $theme = 'light') {
    // Definir colores según el tema
    $isDark = ($theme === 'dark');
    $bgColor = $isDark ? '#2c2f3f' : '#ffffff';
    $textColor = $isDark ? '#ffffff' : '#2c2f3f';
    $subTextColor = $isDark ? '#a0a0b0' : '#90949c';
    $trackColor = $isDark ? '#404452' : '#eff2f5';
    
    ?>
    <style>
        .h-card-<?php echo $id; ?> {
            background-color: <?php echo $bgColor; ?>;
            border-radius: 12px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 15px rgba(0,0,0,<?php echo $isDark ? '0.3' : '0.05'; ?>);
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin-bottom: 15px; /* Espacio si se apilan */
            max-width: 320px;
        }
        .hc-info h4 { margin: 0 0 4px 0; font-size: 18px; color: <?php echo $textColor; ?>; font-weight: 700; }
        .hc-info p { margin: 0; font-size: 13px; color: <?php echo $subTextColor; ?>; }
        
        .hc-chart-wrap { position: relative; width: 60px; height: 60px; }
        .hc-percent {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px; font-weight: 700; color: <?php echo $textColor; ?>;
        }
    </style>

    <div class="h-card-<?php echo $id; ?>">
        <div class="hc-info">
            <h4><?php echo $title; ?></h4>
            <p><?php echo $subtitle; ?></p>
        </div>
        <div class="hc-chart-wrap">
            <div class="hc-percent"><?php echo $percent; ?>%</div>
            <canvas id="<?php echo $id; ?>"></canvas>
        </div>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function(){
            const ctx = document.getElementById('<?php echo $id; ?>').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [<?php echo $percent; ?>, <?php echo 100 - $percent; ?>],
                        backgroundColor: ['<?php echo $colorHex; ?>', '<?php echo $trackColor; ?>'],
                        borderWidth: 0,
                        borderRadius: 50,
                        cutout: '75%',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                    animation: false // Desactivar animación si hay muchas en lista para mejor rendimiento
                }
            });
        })();
    </script>
    <?php
}
?>

<div style="background: #f0f2f5; padding: 20px; display: inline-block;">
    <?php renderHorizontalCard('card1', 'Challenge 01', 'XX of total XX', 76, '#1976D2', 'light'); ?>
    <?php renderHorizontalCard('card2', 'Challenge 02', 'XX of total XX', 50, '#EF5350', 'light'); ?>
</div>

<div style="background: #1a1c23; padding: 20px; display: inline-block;">
    <?php renderHorizontalCard('cardDark1', 'Challenge 01', 'XX of total XX', 76, '#1976D2', 'dark'); ?>
    <?php renderHorizontalCard('cardDark2', 'Challenge 02', 'XX of total XX', 50, '#EF5350', 'dark'); ?>
</div>