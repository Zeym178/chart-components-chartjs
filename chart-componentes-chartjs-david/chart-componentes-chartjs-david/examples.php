<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - David</title>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="stylesheet" href="styles/chart-themes.css">
    
    <style>
        body { font-family: sans-serif; background-color: #f3f4f6; margin: 0; }
        .dashboard { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); 
            gap: 20px; 
            padding: 20px; 
        }
        .chart-card { 
            background: white; 
            padding: 15px; 
            border-radius: 8px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            min-height: 300px;
        }
        .chart-card.dark { background: #1f2937; color: white; }
    </style>
</head>
<body>

<h2 style="padding:20px">Line & Area Charts – David</h2>

<div class="dashboard">

<?php
// 1. IMPORTANTE: Requerimos el archivo donde está definida la función
require_once 'components/line-area-charts.php';

// 2. Ahora llamamos a las funciones
echo lineAreaChart(
    "areaLight",
    ["Jan","Feb","Mar","Apr","May"],
    [
        [
            "label" => "Sales",
            "data" => [120,150,180,160,200],
            "fill" => true,
            "tension" => 0.4,
            "borderColor" => "#3b82f6",
            "backgroundColor" => "rgba(59,130,246,0.35)"
        ]
    ],
    "light"
);

echo lineAreaChart(
    "areaDark",
    ["Mon","Tue","Wed","Thu","Fri"],
    [
        [
            "label" => "Users",
            "data" => [30,45,60,55,80],
            "fill" => true,
            "tension" => 0.4,
            "borderColor" => "#06b6d4",
            "backgroundColor" => "rgba(6,182,212,0.35)"
        ]
    ],
    "dark"
);

echo lineAreaChart(
    "multiArea",
    ["Q1","Q2","Q3","Q4"],
    [
        [
            "label" => "Income",
            "data" => [300,400,450,600],
            "fill" => true,
            "borderColor" => "#22c55e",
            "backgroundColor" => "rgba(34,197,94,0.35)"
        ],
        [
            "label" => "Expenses",
            "data" => [200,250,300,350],
            "fill" => true,
            "borderColor" => "#ef4444",
            "backgroundColor" => "rgba(239,68,68,0.35)"
        ]
    ],
    "dark"
);

echo lineAreaChart(
    "trendLine",
    ["2019","2020","2021","2022","2023"],
    [
        [
            "label" => "Growth",
            "data" => [20,35,50,65,85],
            "fill" => false,
            "borderColor" => "#a855f7",
            "borderWidth" => 3,
            "tension" => 0.3
        ]
    ],
    "light"
);

echo lineAreaChart(
    "stackedArea",
    ["Jan","Feb","Mar","Apr","May","Jun"],
    [
        [
            "label" => "Product A",
            "data" => [100,120,140,160,180,200],
            "fill" => true,
            "borderColor" => "#14b8a6",
            "backgroundColor" => "rgba(20,184,166,0.35)"
        ],
        [
            "label" => "Product B",
            "data" => [80,90,100,120,140,160],
            "fill" => true,
            "borderColor" => "#f59e0b",
            "backgroundColor" => "rgba(245,158,11,0.35)"
        ]
    ],
    "dark"
);
?>

</div>

</body>
</html>