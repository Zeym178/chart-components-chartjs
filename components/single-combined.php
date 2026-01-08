<?php

/**
 * Lista vertical de tarjetas con mini gráficos de dona
 * @param array $items Array de items: [['id' => 'unique', 'percent' => 76, 'title' => 'Challenge 01', 'subtitle' => 'XX of total XX', 'color' => '#1976D2'], ...]
 * @param string $theme 'light' o 'dark'
 */
function challengeList($items, $theme = 'light') {
    $themeClass = $theme === 'dark' ? 'challenge-card-dark' : 'challenge-card-light';
    
    $itemsHtml = implode('', array_map(function($item) use ($theme) {
        return "
        <div class='challenge-item'>
            <div class='chart-mini-wrapper'>
                <div class='chart-mini-text'>{$item['percent']}%</div>
                <canvas id='{$item['id']}'></canvas>
            </div>
            
            <div class='challenge-info'>
                <h4>" . htmlspecialchars($item['title']) . "</h4>
                <p>" . htmlspecialchars($item['subtitle']) . "</p>
            </div>
        </div>";
    }, $items));
    
    $jsItems = json_encode($items);
    $trackColor = $theme === 'dark' ? '#45495e' : '#eceff1';
    
    return "
    <div class='chart-container {$themeClass}' style='width: 340px;'>
        {$itemsHtml}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const items = {$jsItems};

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
                                '{$trackColor}'
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
    </script>";
}

?>