<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gráficos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Fila 1: Tres gráficos de dona -->
        <div class="row">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Chart title</h3>
                    <p class="chart-subtitle">15 April - 15 May</p>
                </div>
                <div class="chart-wrapper">
                    <canvas id="doughnutChart1"></canvas>
                    <div class="chart-value">58%</div>
                </div>
            </div>
            
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Chart title</h3>
                    <p class="chart-subtitle">15 April - 15 May</p>
                </div>
                <div class="chart-wrapper">
                    <canvas id="doughnutChart2"></canvas>
                    <div class="chart-value">58%</div>
                </div>
            </div>
            
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Chart title</h3>
                    <p class="chart-subtitle">15 April - 15 May</p>
                </div>
                <div class="chart-wrapper">
                    <canvas id="doughnutChart3"></canvas>
                    <div class="chart-value">58%</div>
                </div>
            </div>
        </div>
        
        <!-- Fila 2: Dos gráficos de pastel -->
        <div class="row">
            <div class="chart-card pie-card">
                <div class="chart-header">
                    <h3 class="chart-title">Chart title</h3>
                    <p class="chart-subtitle">Here go numbers XX of total XX</p>
                </div>
                <div class="pie-chart-container">
                    <canvas id="pieChart1"></canvas>
                </div>
            </div>
            
            <div class="chart-card pie-card">
                <div class="chart-header">
                    <h3 class="chart-title">Chart title goes here</h3>
                    <div class="legend-container">
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #3498db;"></span>
                            <span class="legend-text">Point 01</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #2ecc71;"></span>
                            <span class="legend-text">Point 02</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #e74c3c;"></span>
                            <span class="legend-text">Point 03</span>
                        </div>
                    </div>
                </div>
                <div class="pie-chart-container">
                    <canvas id="pieChart2"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>