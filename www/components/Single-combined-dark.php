<?php
// Datos de ejemplo para la lista oscura
$challengesDark = [
    [
        'id'       => 'ch_dark_01',
        'percent'  => 76,
        'title'    => 'Challenge 01',
        'subtitle' => 'XX of total XX',
        'color'    => '#1976D2'
    ],
    [
        'id'       => 'ch_dark_02',
        'percent'  => 76,
        'title'    => 'Challenge 02',
        'subtitle' => 'XX of total XX',
        'color'    => '#EF5350'
    ],
    [
        'id'       => 'ch_dark_03',
        'percent'  => 76,
        'title'    => 'Challenge 03',
        'subtitle' => 'XX of total XX',
        'color'    => '#80DEEA'
    ]
];

function renderChallengeListDark($items) {
    ?>
    <style>
        .challenge-card-dark {
            background: #2c2f3f; /* Fondo oscuro exacto */
            width: 320px;
            padding: 10px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #fff;
        }

        .challenge-item-dark {
            display: flex;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #3e4152; /* Separador sutil oscuro */
        }

        .challenge-item-dark:last-child {
            border-bottom: none;
        }

        .chart-mini-wrapper-dark {
            position: relative;
            width: 70px;
            height: 70px;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .chart-mini-text-dark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 16px;
            font-weight: bold;
            color: #fff;
        }

        .challenge-info-dark h4 {
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: 600;
            color: #fff;
        }

        .challenge-info-dark p {
            margin: 0;
            font-size: 14px;
            color: #8c90a3; /* Gris apagado para subtítulos */
        }
    </style>

    <div class="challenge-card-dark">
        <?php foreach ($items as $item): ?>
            <div class="challenge-item-dark">
                <div class="chart-mini-wrapper-dark">
                    <div class="chart-mini-text-dark"><?php echo $item['percent']; ?>%</div>
                    <canvas id="<?php echo $item['id']; ?>"></canvas>
                </div>
                
                <div class="challenge-info-dark">
                    <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                    <p><?php echo htmlspecialchars($item['subtitle']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const items = <?php echo json_encode($items); ?>;

            items.forEach(item => {
                const ctx = document.getElementById(item.id).getContext('2d');
                const remaining = 100 - item.percent;

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [item.percent, remaining],
                            backgroundColor: [
                                item.color,
                                '#45495e' // Gris oscuro para el "track" de fondo
                            ],
                            borderWidth: 0,
                            borderRadius: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '80%',
                        events: [],
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: false }
                        }
                    }
                });
            });
        });
    </script>
    <?php
}

renderChallengeListDark($challengesDark);
?>