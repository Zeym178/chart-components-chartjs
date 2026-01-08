<?php
function renderHorizontalCard($id, $percent, $title, $subtitle) {
    ?>
    <style>
        .horiz-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            font-family: 'Helvetica Neue', Arial, sans-serif;
            width: 300px; /* Ajustable */
            margin-bottom: 20px;
        }

        .horiz-text h4 {
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: 700;
            color: #000;
        }

        .horiz-text p {
            margin: 0;
            font-size: 14px;
            color: #90949c;
        }

        .horiz-chart-wrapper {
            position: relative;
            width: 65px;
            height: 65px;
        }

        .horiz-percent {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 15px;
            font-weight: 700;
            color: #000;
        }
    </style>

    <div class="horiz-card">
        <div class="horiz-text">
            <h4><?php echo htmlspecialchars($title); ?></h4>
            <p><?php echo htmlspecialchars($subtitle); ?></p>
        </div>
        <div class="horiz-chart-wrapper">
            <div class="horiz-percent"><?php echo $percent; ?>%</div>
            <canvas id="<?php echo $id; ?>"></canvas>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('<?php echo $id; ?>').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [<?php echo $percent; ?>, <?php echo 100 - $percent; ?>],
                        backgroundColor: ['#1976D2', '#eff2f5'], // Azul y Gris claro
                        borderWidth: 0,
                        borderRadius: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: { legend: { display: false }, tooltip: { enabled: false } }
                }
            });
        });
    </script>
    <?php
}

// EJEMPLO DE USO:
renderHorizontalCard('hCard1', 76, 'Challenge 01', 'XX of total XX');
?>