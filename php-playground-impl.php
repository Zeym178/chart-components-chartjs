<?php
require_once __DIR__ . '/ChartComponents.php';
ChartComponents::init();

$theme = ($_GET['theme'] ?? 'light') === 'dark' ? 'dark' : 'light';

function phpPresetTemplate(string $theme, string $componentExpr): string {
  return "<?php\n" .
    "require_once __DIR__ . '/ChartComponents.php';\n" .
    "ChartComponents::init();\n\n" .
    "\$theme = '" . $theme . "';\n\n" .
    "\$component = \n" .
    $componentExpr . ";\n\n" .
    "echo ChartComponents::renderComplete(\$component, 'Preview', \$theme);\n";
}

$presets = [
  'colorPalette' => phpPresetTemplate($theme, "ChartComponents::colorPalette(\$theme)"),

  // Metrics
  'metricCard / left' => phpPresetTemplate($theme,
    "ChartComponents::metricCard('Users', '1,247', 'Last 7 days', 'left', \$theme)"),
  'metricCard / center' => phpPresetTemplate($theme,
    "ChartComponents::metricCard('Revenue', '$12,480', 'This month', 'center', \$theme)"),
  'metricCard / right' => phpPresetTemplate($theme,
    "ChartComponents::metricCard('Orders', '324', '', 'right', \$theme)"),
  'largeNumberCard / with label' => phpPresetTemplate($theme,
    "ChartComponents::largeNumberCard('354', 'Category', \$theme)"),
  'largeNumberCard / number only' => phpPresetTemplate($theme,
    "ChartComponents::largeNumberCard('9,812', '', \$theme)"),

  // Progress
  'progressBar / primary' => phpPresetTemplate($theme,
    "ChartComponents::progressBar('Completed', 75, 100, 'primary', \$theme)"),
  'progressBar / secondary' => phpPresetTemplate($theme,
    "ChartComponents::progressBar('In review', 30, 100, 'secondary', \$theme)"),
  'progressBar / success' => phpPresetTemplate($theme,
    "ChartComponents::progressBar('Approved', 92, 100, 'success', \$theme)"),
  'multiProgressCard / default' => phpPresetTemplate($theme,
    "ChartComponents::multiProgressCard(\n" .
    "  'Progress',\n" .
    "  [\n" .
    "    ['label' => 'Design', 'value' => 80, 'total' => 100, 'color' => 'primary'],\n" .
    "    ['label' => 'Dev', 'value' => 55, 'total' => 100, 'color' => 'secondary'],\n" .
    "    ['label' => 'QA', 'value' => 35, 'total' => 100, 'color' => 'success'],\n" .
    "  ],\n" .
    "  \$theme\n" .
    ")"),
  'multiProgressCard / size sm' => phpPresetTemplate($theme,
    "ChartComponents::multiProgressCard(\n" .
    "  'Progress (sm)',\n" .
    "  [\n" .
    "    ['label' => 'Step 1', 'value' => 20, 'total' => 100, 'color' => 'primary'],\n" .
    "    ['label' => 'Step 2', 'value' => 45, 'total' => 100, 'color' => 'secondary'],\n" .
    "  ],\n" .
    "  \$theme,\n" .
    "  'sm'\n" .
    ")"),
  'singleProgressCard / default' => phpPresetTemplate($theme,
    "ChartComponents::singleProgressCard('Goal Progress', 'This month', 78, \$theme)"),
  'singleProgressCard / size md' => phpPresetTemplate($theme,
    "ChartComponents::singleProgressCard('Goal Progress', 'This month', 78, \$theme, 'md')"),
  'iconProgressCard / moon' => phpPresetTemplate($theme,
    "ChartComponents::iconProgressCard('Sleep', 'Last night', '7h 15m', '🌙', \$theme)"),
  'iconProgressCard / size lg' => phpPresetTemplate($theme,
    "ChartComponents::iconProgressCard('Workout', 'Today', '45m', '🏋️', \$theme, 'lg')"),

  // Bar charts
  'barChart / single series' => phpPresetTemplate($theme,
    "ChartComponents::barChart([[12, 19, 3, 5, 2, 3]], ['Sales'], 'Sales', \$theme)"),
  'barChart / two series' => phpPresetTemplate($theme,
    "ChartComponents::barChart(\n" .
    "  [\n" .
    "    [30000, 50000, 70000, 40000, 60000, 65000],\n" .
    "    [20000, 40000, 50000, 35000, 45000, 55000],\n" .
    "  ],\n" .
    "  ['Sales', 'Purchases'],\n" .
    "  'Sales vs Purchases',\n" .
    "  \$theme\n" .
    ")"),
  'barChart / custom chartId' => phpPresetTemplate($theme,
    "ChartComponents::barChart([[5, 9, 7, 8, 5, 3]], ['Data'], 'With chartId', \$theme, 'myBarChart1')"),

  // Line charts (basic)
  'lineChart / line' => phpPresetTemplate($theme,
    "ChartComponents::lineChart([[100, 150, 200, 120, 180, 160]], ['Revenue'], 'Revenue', 'Last 6 months', 'line', \$theme)"),
  'lineChart / smooth' => phpPresetTemplate($theme,
    "ChartComponents::lineChart([[100, 150, 200, 120, 180, 160]], ['Revenue'], 'Revenue', 'Last 6 months', 'smooth', \$theme)"),
  'lineChart / area' => phpPresetTemplate($theme,
    "ChartComponents::lineChart([[100, 150, 200, 120, 180, 160]], ['Revenue'], 'Revenue', 'Last 6 months', 'area', \$theme)"),
  'lineChart / multi series' => phpPresetTemplate($theme,
    "ChartComponents::lineChart(\n" .
    "  [\n" .
    "    [100, 150, 200, 120, 180, 160],\n" .
    "    [80, 120, 170, 110, 160, 140],\n" .
    "  ],\n" .
    "  ['Revenue', 'Costs'],\n" .
    "  'Revenue vs Costs',\n" .
    "  'Last 6 months',\n" .
    "  'smooth',\n" .
    "  \$theme\n" .
    ")"),
  'lineChart / custom chartId' => phpPresetTemplate($theme,
    "ChartComponents::lineChart([[10,20,18,25,22,30]], ['Series'], 'With chartId', '', 'smooth', \$theme, 'myLine1')"),
  'areaChart (wrapper)' => phpPresetTemplate($theme,
    "ChartComponents::areaChart([[10,20,18,25,22,30]], ['Series'], 'AreaChart wrapper', 'Subtitle', \$theme)"),
  'smoothLineChart (wrapper)' => phpPresetTemplate($theme,
    "ChartComponents::smoothLineChart([[10,20,18,25,22,30]], ['Series'], 'Smooth wrapper', 'Subtitle', \$theme)"),
  'lineChartWithAnnotation' => phpPresetTemplate($theme,
    "ChartComponents::lineChartWithAnnotation(\n" .
    "  [[100, 150, 200, 120, 180, 160]],\n" .
    "  ['Data'],\n" .
    "  'Chart title',\n" .
    "  '15 April - 21 April',\n" .
    "  ['value' => '489', 'label' => 'additional text'],\n" .
    "  \$theme\n" .
    ")"),

  // Donuts / rings
  'donutChart3Categories / default' => phpPresetTemplate($theme,
    "ChartComponents::donutChart3Categories(\n" .
    "  [\n" .
    "    ['label' => 'Point 01', 'value' => 55, 'color' => '#147AD6'],\n" .
    "    ['label' => 'Point 02', 'value' => 25, 'color' => '#79D2DE'],\n" .
    "    ['label' => 'Point 03', 'value' => 20, 'color' => '#EC6666'],\n" .
    "  ],\n" .
    "  'Chart title goes here',\n" .
    "  \$theme\n" .
    ")"),
  'donutChart3Categories / custom chartId' => phpPresetTemplate($theme,
    "ChartComponents::donutChart3Categories([['label'=>'A','value'=>40,'color'=>'#147AD6'],['label'=>'B','value'=>35,'color'=>'#79D2DE'],['label'=>'C','value'=>25,'color'=>'#EC6666']], 'With chartId', \$theme, 'donutA')"),
  'ringChart4Categories / default' => phpPresetTemplate($theme,
    "ChartComponents::ringChart4Categories(\n" .
    "  [\n" .
    "    ['label' => 'Point 01', 'value' => 40, 'color' => '#147AD6'],\n" .
    "    ['label' => 'Point 02', 'value' => 30, 'color' => '#79D2DE'],\n" .
    "    ['label' => 'Point 03', 'value' => 20, 'color' => '#EC6666'],\n" .
    "    ['label' => 'Point 04', 'value' => 10, 'color' => '#F97316'],\n" .
    "  ],\n" .
    "  'Ring chart',\n" .
    "  76,\n" .
    "  \$theme\n" .
    ")"),

  // Carousel
  'carouselChart / default' => phpPresetTemplate($theme,
    "ChartComponents::carouselChart('Chart title', 'Here go numbers XX of total XX', 76, '#147AD6', 1, \$theme)"),
  'carouselChart / red + dot 3' => phpPresetTemplate($theme,
    "ChartComponents::carouselChart('Chart title', 'XX of total XX', 42, '#EC6666', 3, \$theme)"),
  'carouselChart / custom chartId' => phpPresetTemplate($theme,
    "ChartComponents::carouselChart('Chart title', 'Subtitle', 60, '#147AD6', 2, \$theme, 'carousel1')"),

  // Challenge list
  'challengeList / 3 items' => phpPresetTemplate($theme,
    "ChartComponents::challengeList(\n" .
    "  [\n" .
    "    ['id' => 'ch_1', 'percent' => 76, 'title' => 'Challenge 01', 'subtitle' => 'XX of total XX', 'color' => '#147AD6'],\n" .
    "    ['id' => 'ch_2', 'percent' => 54, 'title' => 'Challenge 02', 'subtitle' => 'XX of total XX', 'color' => '#79D2DE'],\n" .
    "    ['id' => 'ch_3', 'percent' => 32, 'title' => 'Challenge 03', 'subtitle' => 'XX of total XX', 'color' => '#EC6666'],\n" .
    "  ],\n" .
    "  \$theme\n" .
    ")"),
  'challengeList / 5 items' => phpPresetTemplate($theme,
    "ChartComponents::challengeList(\n" .
    "  [\n" .
    "    ['id' => 'ch_a', 'percent' => 86, 'title' => 'A', 'subtitle' => 'XX of total XX', 'color' => '#147AD6'],\n" .
    "    ['id' => 'ch_b', 'percent' => 66, 'title' => 'B', 'subtitle' => 'XX of total XX', 'color' => '#79D2DE'],\n" .
    "    ['id' => 'ch_c', 'percent' => 46, 'title' => 'C', 'subtitle' => 'XX of total XX', 'color' => '#EC6666'],\n" .
    "    ['id' => 'ch_d', 'percent' => 26, 'title' => 'D', 'subtitle' => 'XX of total XX', 'color' => '#F97316'],\n" .
    "    ['id' => 'ch_e', 'percent' => 12, 'title' => 'E', 'subtitle' => 'XX of total XX', 'color' => '#10B981'],\n" .
    "  ],\n" .
    "  \$theme\n" .
    ")"),

  // Compact cards
  'compactStatCard / default' => phpPresetTemplate($theme,
    "ChartComponents::compactStatCard('354', 'Category', 75, '#147AD6', \$theme)"),
  'compactStatCard / custom chartId' => phpPresetTemplate($theme,
    "ChartComponents::compactStatCard('1,024', 'Users', 62, '#79D2DE', \$theme, 'compact1')"),
  'horizontalCard / default' => phpPresetTemplate($theme,
    "ChartComponents::horizontalCard('Challenge 01', 'XX of total XX', 76, '#147AD6', \$theme)"),
  'horizontalCard / red' => phpPresetTemplate($theme,
    "ChartComponents::horizontalCard('Challenge 02', 'XX of total XX', 54, '#EC6666', \$theme)"),
  'horizontalCard / custom chartId' => phpPresetTemplate($theme,
    "ChartComponents::horizontalCard('Challenge 03', 'XX of total XX', 32, '#79D2DE', \$theme, 'hcard1')"),

  // Advanced line charts
  'areaLineChart' => phpPresetTemplate($theme,
    "ChartComponents::areaLineChart([100,150,200,120,180,160], ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', '15 April - 21 April', '#147AD6', \$theme)"),
  'annotatedLineChart' => phpPresetTemplate($theme,
    "ChartComponents::annotatedLineChart([100,150,200,120,180,160], ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', '15 April - 21 April', '489', 'additional text', '#147AD6', \$theme)"),
  'multiLineChart' => phpPresetTemplate($theme,
    "ChartComponents::multiLineChart(\n" .
    "  [\n" .
    "    ['label' => 'Point 01', 'data' => [100,150,200,120,180,160], 'color' => '#147AD6'],\n" .
    "    ['label' => 'Point 02', 'data' => [80,120,170,110,160,140], 'color' => '#79D2DE'],\n" .
    "    ['label' => 'Point 03', 'data' => [60,90,130,95,120,110], 'color' => '#EC6666'],\n" .
    "  ],\n" .
    "  ['JAN','FEB','MAR','APR','MAY','JUN'],\n" .
    "  'Chart title goes here',\n" .
    "  '15 April - 21 April',\n" .
    "  \$theme\n" .
    ")"),
  'compactLineChart' => phpPresetTemplate($theme,
    "ChartComponents::compactLineChart('Chart title', '2,476', [10,20,18,25,22,30,28], '#147AD6', \$theme)"),

  // Pie / donut variants
  'simpleDonutChart / default' => phpPresetTemplate($theme,
    "ChartComponents::simpleDonutChart(58, 'Chart title', '15 April - 15 May', '#147AD6', \$theme)"),
  'simpleDonutChart / 82%' => phpPresetTemplate($theme,
    "ChartComponents::simpleDonutChart(82, 'Completion', 'This month', '#79D2DE', \$theme)"),
  'simplePieChart / default' => phpPresetTemplate($theme,
    "ChartComponents::simplePieChart([35, 25, 20, 20], ['#147AD6', '#EC6666', '#79D2DE', '#F97316'], 'Chart title', 'Here go numbers XX of total XX', \$theme)"),
  'simplePieChart / custom' => phpPresetTemplate($theme,
    "ChartComponents::simplePieChart([40, 30, 20, 10], ['#147AD6', '#79D2DE', '#EC6666', '#10B981'], 'Distribution', 'Custom colors', \$theme)"),
  'pieChartWithLegend / 3 items' => phpPresetTemplate($theme,
    "ChartComponents::pieChartWithLegend([\n" .
    "  ['label' => 'Point 01', 'value' => 40, 'color' => '#147AD6'],\n" .
    "  ['label' => 'Point 02', 'value' => 35, 'color' => '#79D2DE'],\n" .
    "  ['label' => 'Point 03', 'value' => 25, 'color' => '#EC6666'],\n" .
    "], 'Chart title', \$theme)"),
  'pieChartWithLegend / 4 items' => phpPresetTemplate($theme,
    "ChartComponents::pieChartWithLegend([\n" .
    "  ['label' => 'A', 'value' => 30, 'color' => '#147AD6'],\n" .
    "  ['label' => 'B', 'value' => 25, 'color' => '#79D2DE'],\n" .
    "  ['label' => 'C', 'value' => 25, 'color' => '#EC6666'],\n" .
    "  ['label' => 'D', 'value' => 20, 'color' => '#F97316'],\n" .
    "], 'Chart title', \$theme)"),
  'chartDashboard' => phpPresetTemplate($theme,
    "ChartComponents::chartDashboard(\n" .
    "  [\n" .
    "    ['percentage' => 58, 'title' => 'Title 01', 'subtitle' => '15 Apr - 15 May', 'color' => '#147AD6'],\n" .
    "    ['percentage' => 73, 'title' => 'Title 02', 'subtitle' => '15 Apr - 15 May', 'color' => '#79D2DE'],\n" .
    "    ['percentage' => 21, 'title' => 'Title 03', 'subtitle' => '15 Apr - 15 May', 'color' => '#EC6666'],\n" .
    "  ],\n" .
    "  [\n" .
    "    ['data' => [35,25,20,20], 'colors' => ['#147AD6','#EC6666','#79D2DE','#F97316'], 'title' => 'Pie 01', 'subtitle' => 'Subtitle'],\n" .
    "    ['data' => [40,30,20,10], 'colors' => ['#147AD6','#79D2DE','#EC6666','#10B981'], 'title' => 'Pie 02', 'subtitle' => 'Subtitle'],\n" .
    "  ],\n" .
    "  \$theme\n" .
    ")"),

  // Advanced bar charts
  'valueBarChart' => phpPresetTemplate($theme,
    "ChartComponents::valueBarChart([500, 750, 600, 550, 400, 300, 350], ['M','T','W','T','F','S','S'], '$476', 'Daily average', '#147AD6', \$theme)"),
  'annotatedBarChart' => phpPresetTemplate($theme,
    "ChartComponents::annotatedBarChart([200, 450, 300, 520, 600, 480, 350], ['M','T','W','T','F','S','S'], 'Chart title goes here', '15 April - 21 April', '742', 'additional text', '#147AD6', \$theme)"),
  'labeledBarChart' => phpPresetTemplate($theme,
    "ChartComponents::labeledBarChart([200, 450, 300, 520, 600, 480, 350], ['M','T','W','T','F','S','S'], 'Chart title goes here', '15 April - 21 April', '#147AD6', \$theme)"),
  'multiBarChart' => phpPresetTemplate($theme,
    "ChartComponents::multiBarChart(\n" .
    "  [\n" .
    "    ['label' => 'Point 01', 'data' => [200,300,250,320,280,350], 'color' => '#147AD6'],\n" .
    "    ['label' => 'Point 02', 'data' => [150,220,180,260,210,290], 'color' => '#79D2DE'],\n" .
    "  ],\n" .
    "  ['JAN','FEB','MAR','APR','MAY','JUN'],\n" .
    "  'Chart title goes here',\n" .
    "  'Last 6 months',\n" .
    "  \$theme\n" .
    ")"),
  'combinedBarChart' => phpPresetTemplate($theme,
    "ChartComponents::combinedBarChart([120,180,140,200,160,220], [-80,-120,-90,-150,-110,-170], ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', 'Last 6 months', '#147AD6', '#EC6666', \$theme)"),
];

$presetsJson = json_encode($presets, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$initialCode = reset($presets);
$initialCodeJs = json_encode($initialCode, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

$docStyles = "
<style>
  .pg-header { display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:16px; }
  .pg-title { font-size: 22px; font-weight: 700; }
  .pg-sub { font-size: 12px; color: var(--text-muted-light); margin-top: 6px; }
  .theme-dark .pg-sub { color: var(--text-muted-dark); }

  .pg-layout { display:grid; grid-template-columns: minmax(340px, 1fr) minmax(360px, 1fr); gap: 18px; align-items: start; }
  @media (max-width: 980px) { .pg-layout { grid-template-columns: 1fr; } }

  .pg-panel { border: 1px solid var(--border-light); border-radius: 12px; padding: 14px; background: var(--bg-card-light); }
  .theme-dark .pg-panel { border-color: var(--border-dark); background: var(--bg-card-dark); }

  .pg-controls { display:flex; flex-wrap:wrap; gap: 10px; align-items:center; margin-bottom: 12px; }
  .pg-controls label { font-size: 12px; font-weight: 600; }
  .pg-controls select, .pg-controls button, .pg-controls a { border-radius: 10px; padding: 8px 10px; border: 1px solid var(--border-light); background: transparent; color: inherit; text-decoration:none; }
  .theme-dark .pg-controls select, .theme-dark .pg-controls button, .theme-dark .pg-controls a { border-color: var(--border-dark); }

    /* Windows/Chrome often render <select> option lists with a light background.
      If the control inherits white text in dark theme, options can become unreadable. */
    .pg-controls select option { color: var(--text-light); background: var(--bg-card-light); }
    .theme-dark .pg-controls select { color-scheme: dark; }

  .pg-error { display:none; margin-top: 10px; font-size: 12px; color: #EC6666; }
  .pg-code-label { font-size: 12px; font-weight: 700; margin-bottom: 8px; }

  .CodeMirror { height: 560px; border-radius: 12px; border: 1px solid var(--border-light); }
  .theme-dark .CodeMirror { border-color: var(--border-dark); }

  .pg-frame { width:100%; height: 820px; border: 1px solid var(--border-light); border-radius: 12px; }
  .theme-dark .pg-frame { border-color: var(--border-dark); }

  .pg-note { font-size: 12px; color: var(--text-muted-light); margin-top: 10px; }
  .theme-dark .pg-note { color: var(--text-muted-dark); }
</style>
";

$codeMirror = "
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/codemirror@5.65.16/lib/codemirror.min.css'>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/codemirror@5.65.16/theme/material-darker.min.css'>
<script src='https://cdn.jsdelivr.net/npm/codemirror@5.65.16/lib/codemirror.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/codemirror@5.65.16/mode/xml/xml.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/codemirror@5.65.16/mode/javascript/javascript.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/codemirror@5.65.16/mode/css/css.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/codemirror@5.65.16/mode/clike/clike.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/codemirror@5.65.16/mode/php/php.min.js'></script>
";

$content = $docStyles . $codeMirror;

$content .= "
<div class='pg-header'>
  <div>
    <div class='pg-title'>PHP Component Playground</div>
    <div class='pg-sub'>This is real copy-pastable PHP. Change <code>$theme</code> (dropdown or in code) and the preview will re-render.</div>
  </div>
  <div class='pg-controls'>
    <a href='php-playground.php?theme={$theme}'>PHP playground</a>
    <a href='doc-index.php'>Docs gallery</a>
  </div>
</div>

<div class='pg-layout'>
  <div class='pg-panel'>
    <div class='pg-controls'>
      <label for='pgTheme'>Theme</label>
      <select id='pgTheme'>
        <option value='light'" . ($theme === 'light' ? " selected" : "") . ">light</option>
        <option value='dark'" . ($theme === 'dark' ? " selected" : "") . ">dark</option>
      </select>

      <label for='pgPreset'>Preset</label>
      <select id='pgPreset'></select>

      <button type='button' id='pgReset'>Reset</button>
      <button type='button' id='pgRun'>Render</button>
    </div>

    <div class='pg-code-label'>PHP (full example)</div>
    <textarea id='pgEditor'></textarea>
    <div class='pg-error' id='pgError'></div>

    <div class='pg-note'>Tip: you can copy the whole snippet into a file as-is.</div>
  </div>

  <div class='pg-panel'>
    <div class='pg-code-label'>Live preview</div>
    <iframe class='pg-frame' id='pgFrame' name='pgFrame' src='php-playground-user.php'></iframe>
  </div>
</div>

<script>
  window.__PHP_PG_PRESETS__ = {$presetsJson};
  window.__PHP_PG_INITIAL_TEXT__ = {$initialCodeJs};
  window.__PHP_PG_GENERATE_URL__ = 'php-playground-generate.php';
</script>
<script src='php-playground.js'></script>
";

echo ChartComponents::renderComplete($content, 'PHP Component Playground', $theme);

?>
