<?php

function lineAreaChart(
    string $id,
    array $labels,
    array $datasets,
    string $theme = "light"
) {
    $text = $theme === "dark" ? "#ffffff" : "#1f2937";
    $grid = $theme === "dark" ? "#374151" : "#e5e7eb";

    return "
    <div class='chart-card $theme'>
        <canvas id='$id'></canvas>
    </div>

    <script>
    new Chart(document.getElementById('$id'), {
        type: 'line',
        data: {
            labels: " . json_encode($labels) . ",
            datasets: " . json_encode($datasets) . "
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    labels: {
                        color: '$text',
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    backgroundColor: '$theme' === 'dark' ? '#111827' : '#ffffff',
                    titleColor: '$text',
                    bodyColor: '$text',
                    borderColor: '$grid',
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    grid: { color: '$grid' },
                    ticks: { color: '$text' }
                },
                y: {
                    grid: { color: '$grid' },
                    ticks: { color: '$text' }
                }
            }
        }
    });
    </script>
    ";
}
