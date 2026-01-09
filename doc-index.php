<?php
require_once __DIR__ . '/ChartComponents.php';
ChartComponents::init();

$theme = ($_GET['theme'] ?? 'light') === 'dark' ? 'dark' : 'light';

function docExample(string $title, string $code, string $renderedHtml): string {
	$escaped = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');

	return "
	<?php
	require_once __DIR__ . '/ChartComponents.php';
	ChartComponents::init();

	$defaultTheme = 'light';

	function snippetTemplate(string $componentExpr, string $theme = 'light'): string {
		return "<?php\n" .
			"require_once __DIR__ . '/ChartComponents.php';\n" .
			"ChartComponents::init();\n\n" .
			"\$theme = '" . $theme . "';\n\n" .
			"\$component = \n" .
			$componentExpr . ";\n\n" .
			"echo ChartComponents::renderComplete(\$component, 'Preview', \$theme);\n";
	}

	function snippetCard(string $title, string $code, int $idx): string {
		$id = 'snippet_' . $idx;
		$escaped = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');
		return "
			<section class='snip-card'>
				<div class='snip-head'>
					<div class='snip-title'>{$title}</div>
					<button class='snip-copy' type='button' data-copy='{$id}'>Copy</button>
				</div>
				<pre class='snip-pre'><code id='{$id}'>{$escaped}</code></pre>
			</section>
		";
	}

	$snippets = [
		'colorPalette' => snippetTemplate("ChartComponents::colorPalette(\$theme)", $defaultTheme),

		'metricCard / left' => snippetTemplate("ChartComponents::metricCard('Users', '1,247', 'Last 7 days', 'left', \$theme)", $defaultTheme),
		'metricCard / center' => snippetTemplate("ChartComponents::metricCard('Revenue', '$12,480', 'This month', 'center', \$theme)", $defaultTheme),
		'metricCard / right' => snippetTemplate("ChartComponents::metricCard('Orders', '324', '', 'right', \$theme)", $defaultTheme),
		'largeNumberCard' => snippetTemplate("ChartComponents::largeNumberCard('354', 'Category', \$theme)", $defaultTheme),

		'progressBar / primary' => snippetTemplate("ChartComponents::progressBar('Completed', 75, 100, 'primary', \$theme)", $defaultTheme),
		'progressBar / secondary' => snippetTemplate("ChartComponents::progressBar('In review', 30, 100, 'secondary', \$theme)", $defaultTheme),
		'progressBar / success' => snippetTemplate("ChartComponents::progressBar('Approved', 92, 100, 'success', \$theme)", $defaultTheme),
		'multiProgressCard' => snippetTemplate(
			"ChartComponents::multiProgressCard(\n" .
			"  'Progress',\n" .
			"  [\n" .
			"    ['label' => 'Design', 'value' => 80, 'total' => 100, 'color' => 'primary'],\n" .
			"    ['label' => 'Dev', 'value' => 55, 'total' => 100, 'color' => 'secondary'],\n" .
			"    ['label' => 'QA', 'value' => 35, 'total' => 100, 'color' => 'success'],\n" .
			"  ],\n" .
			"  \$theme\n" .
			")",
			$defaultTheme
		),
		'singleProgressCard' => snippetTemplate("ChartComponents::singleProgressCard('Goal Progress', 'This month', 78, \$theme)", $defaultTheme),
		'iconProgressCard' => snippetTemplate("ChartComponents::iconProgressCard('Sleep', 'Last night', '7h 15m', '🌙', \$theme)", $defaultTheme),

		'barChart / two series' => snippetTemplate(
			"ChartComponents::barChart(\n" .
			"  [\n" .
			"    [30000, 50000, 70000, 40000, 60000, 65000],\n" .
			"    [20000, 40000, 50000, 35000, 45000, 55000],\n" .
			"  ],\n" .
			"  ['Sales', 'Purchases'],\n" .
			"  'Sales vs Purchases',\n" .
			"  \$theme\n" .
			")",
			$defaultTheme
		),
		'barChart / custom chartId' => snippetTemplate("ChartComponents::barChart([[5, 9, 7, 8, 5, 3]], ['Data'], 'With chartId', \$theme, 'myBarChart1')", $defaultTheme),

		'lineChart / smooth' => snippetTemplate("ChartComponents::lineChart([[100, 150, 200, 120, 180, 160]], ['Revenue'], 'Revenue', 'Last 6 months', 'smooth', \$theme)", $defaultTheme),
		'areaChart (wrapper)' => snippetTemplate("ChartComponents::areaChart([[10,20,18,25,22,30]], ['Series'], 'AreaChart wrapper', 'Subtitle', \$theme)", $defaultTheme),
		'smoothLineChart (wrapper)' => snippetTemplate("ChartComponents::smoothLineChart([[10,20,18,25,22,30]], ['Series'], 'Smooth wrapper', 'Subtitle', \$theme)", $defaultTheme),
		'lineChartWithAnnotation' => snippetTemplate(
			"ChartComponents::lineChartWithAnnotation(\n" .
			"  [[100, 150, 200, 120, 180, 160]],\n" .
			"  ['Data'],\n" .
			"  'Chart title',\n" .
			"  '15 April - 21 April',\n" .
			"  ['value' => '489', 'label' => 'additional text'],\n" .
			"  \$theme\n" .
			")",
			$defaultTheme
		),

		'donutChart3Categories' => snippetTemplate(
			"ChartComponents::donutChart3Categories(\n" .
			"  [\n" .
			"    ['label' => 'Point 01', 'value' => 55, 'color' => '#147AD6'],\n" .
			"    ['label' => 'Point 02', 'value' => 25, 'color' => '#79D2DE'],\n" .
			"    ['label' => 'Point 03', 'value' => 20, 'color' => '#EC6666'],\n" .
			"  ],\n" .
			"  'Chart title goes here',\n" .
			"  \$theme\n" .
			")",
			$defaultTheme
		),
		'ringChart4Categories' => snippetTemplate(
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
			")",
			$defaultTheme
		),

		'carouselChart' => snippetTemplate("ChartComponents::carouselChart('Chart title', 'Here go numbers XX of total XX', 76, '#147AD6', 1, \$theme)", $defaultTheme),
		'challengeList' => snippetTemplate(
			"ChartComponents::challengeList(\n" .
			"  [\n" .
			"    ['id' => 'ch_1', 'percent' => 76, 'title' => 'Challenge 01', 'subtitle' => 'XX of total XX', 'color' => '#147AD6'],\n" .
			"    ['id' => 'ch_2', 'percent' => 54, 'title' => 'Challenge 02', 'subtitle' => 'XX of total XX', 'color' => '#79D2DE'],\n" .
			"    ['id' => 'ch_3', 'percent' => 32, 'title' => 'Challenge 03', 'subtitle' => 'XX of total XX', 'color' => '#EC6666'],\n" .
			"  ],\n" .
			"  \$theme\n" .
			")",
			$defaultTheme
		),

		'compactStatCard' => snippetTemplate("ChartComponents::compactStatCard('354', 'Category', 75, '#147AD6', \$theme)", $defaultTheme),
		'horizontalCard' => snippetTemplate("ChartComponents::horizontalCard('Challenge 01', 'XX of total XX', 76, '#147AD6', \$theme)", $defaultTheme),

		'areaLineChart' => snippetTemplate("ChartComponents::areaLineChart([100,150,200,120,180,160], ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', '15 April - 21 April', '#147AD6', \$theme)", $defaultTheme),
		'annotatedLineChart' => snippetTemplate("ChartComponents::annotatedLineChart([100,150,200,120,180,160], ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', '15 April - 21 April', '489', 'additional text', '#147AD6', \$theme)", $defaultTheme),
		'multiLineChart' => snippetTemplate(
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
			")",
			$defaultTheme
		),
		'compactLineChart' => snippetTemplate("ChartComponents::compactLineChart('Chart title', '2,476', [10,20,18,25,22,30,28], '#147AD6', \$theme)", $defaultTheme),

		'simpleDonutChart' => snippetTemplate("ChartComponents::simpleDonutChart(58, 'Chart title', '15 April - 15 May', '#147AD6', \$theme)", $defaultTheme),
		'simplePieChart' => snippetTemplate("ChartComponents::simplePieChart([35, 25, 20, 20], ['#147AD6', '#EC6666', '#79D2DE', '#F97316'], 'Chart title', 'Here go numbers XX of total XX', \$theme)", $defaultTheme),
		'pieChartWithLegend' => snippetTemplate("ChartComponents::pieChartWithLegend([['label'=>'Point 01','value'=>40,'color'=>'#147AD6'],['label'=>'Point 02','value'=>35,'color'=>'#79D2DE'],['label'=>'Point 03','value'=>25,'color'=>'#EC6666']], 'Chart title', \$theme)", $defaultTheme),
		'chartDashboard' => snippetTemplate(
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
			")",
			$defaultTheme
		),

		'valueBarChart' => snippetTemplate("ChartComponents::valueBarChart([500, 750, 600, 550, 400, 300, 350], ['M','T','W','T','F','S','S'], '$476', 'Daily average', '#147AD6', \$theme)", $defaultTheme),
		'annotatedBarChart' => snippetTemplate("ChartComponents::annotatedBarChart([200, 450, 300, 520, 600, 480, 350], ['M','T','W','T','F','S','S'], 'Chart title goes here', '15 April - 21 April', '742', 'additional text', '#147AD6', \$theme)", $defaultTheme),
		'labeledBarChart' => snippetTemplate("ChartComponents::labeledBarChart([200, 450, 300, 520, 600, 480, 350], ['M','T','W','T','F','S','S'], 'Chart title goes here', '15 April - 21 April', '#147AD6', \$theme)", $defaultTheme),
		'multiBarChart' => snippetTemplate("ChartComponents::multiBarChart([['label'=>'Point 01','data'=>[200,300,250,320,280,350],'color'=>'#147AD6'],['label'=>'Point 02','data'=>[150,220,180,260,210,290],'color'=>'#79D2DE']], ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', 'Last 6 months', \$theme)", $defaultTheme),
		'combinedBarChart' => snippetTemplate("ChartComponents::combinedBarChart([120,180,140,200,160,220], [-80,-120,-90,-150,-110,-170], ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', 'Last 6 months', '#147AD6', '#EC6666', \$theme)", $defaultTheme),
	];

	$styles = "
	<style>
		.doc-header { display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:16px; }
		.doc-title { font-size: 22px; font-weight: 700; }
		.doc-sub { font-size: 12px; color: var(--text-muted-light); margin-top: 6px; }
		.doc-actions { display:flex; flex-wrap:wrap; gap:10px; }
		.doc-actions a { text-decoration:none; padding: 8px 12px; border-radius: 10px; border: 1px solid var(--border-light); }

		.snip-grid { display:grid; grid-template-columns: repeat(2, minmax(320px, 1fr)); gap: 14px; }
		@media (max-width: 980px) { .snip-grid { grid-template-columns: 1fr; } }

		.snip-card { border: 1px solid var(--border-light); border-radius: 12px; background: var(--bg-card-light); overflow:hidden; }
		.snip-head { display:flex; justify-content:space-between; align-items:center; gap:10px; padding: 12px 12px 0 12px; }
		.snip-title { font-size: 13px; font-weight: 700; }
		.snip-copy { border-radius: 10px; padding: 7px 10px; border: 1px solid var(--border-light); background: transparent; cursor: pointer; }
		.snip-pre { margin: 0; padding: 12px; overflow:auto; }
		.snip-pre code { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace; font-size: 12px; line-height: 1.5; }
	</style>
	";

	$body = $styles . "
	<div class='doc-header'>
		<div>
			<div class='doc-title'>Docs gallery (snippets)</div>
			<div class='doc-sub'>Copy a full PHP snippet, paste into a new file in this folder, and open it in the browser. Change <code>$theme</code> inside the snippet if needed.</div>
		</div>
		<div class='doc-actions'>
			<a href='php-playground.php'>PHP playground</a>
			<a href='index.php'>Demo index.php</a>
		</div>
	</div>

	<div class='snip-grid'>
	";

	$i = 0;
	foreach ($snippets as $title => $code) {
		$body .= snippetCard($title, $code, $i++);
	}

	$body .= "
	</div>

	<script>
	(function(){
		function copyText(text){
			if (navigator.clipboard && navigator.clipboard.writeText) {
				return navigator.clipboard.writeText(text);
			}
			const ta = document.createElement('textarea');
			ta.value = text;
			ta.style.position = 'fixed';
			ta.style.left = '-9999px';
			document.body.appendChild(ta);
			ta.select();
			try { document.execCommand('copy'); } finally { document.body.removeChild(ta); }
			return Promise.resolve();
		}

		document.querySelectorAll('[data-copy]').forEach((btn) => {
			btn.addEventListener('click', () => {
				const id = btn.getAttribute('data-copy');
				const el = document.getElementById(id);
				if (!el) return;
				copyText(el.textContent || '').then(() => {
					const prev = btn.textContent;
					btn.textContent = 'Copied';
					setTimeout(() => (btn.textContent = prev), 900);
				});
			});
		});
	})();
	</script>
	";

	echo ChartComponents::renderComplete($body, 'Docs gallery (snippets)', $defaultTheme);
		<div class='doc-title'>Chart.js Components – Documentation Gallery</div>
		<div class='doc-note'>Theme: <strong>{$theme}</strong> · This page is generated by <code>doc-index.php</code></div>
	</div>
	<div class='doc-actions'>
		<a href='?theme={$toggleTheme}'>Switch to {$toggleTheme} theme</a>
		<a href='index.php?theme={$theme}'>Open demo index.php</a>
	</div>
</div>
";

$content .= "
<nav class='doc-nav'>
	<a href='#palette'>Palette</a>
	<a href='#metrics'>Metrics</a>
	<a href='#progress'>Progress</a>
	<a href='#bars-basic'>Bars (basic)</a>
	<a href='#lines-basic'>Lines (basic)</a>
	<a href='#donuts'>Donuts</a>
	<a href='#carousel'>Carousel</a>
	<a href='#challenges'>Challenges</a>
	<a href='#compact'>Compact cards</a>
	<a href='#lines-advanced'>Lines (advanced)</a>
	<a href='#pies'>Pies / Donuts</a>
	<a href='#bars-advanced'>Bars (advanced)</a>
</nav>
";

// -----------------------------------------------------------------------------
// Palette
// -----------------------------------------------------------------------------
$content .= "<h2 id='palette' class='doc-section-title'>Color Palette</h2>";
$content .= "<div class='doc-section-desc'>System palette defined in styles/chart-themes.css.</div>";
$content .= docExample(
	'Color palette (theme aware)',
	"echo ChartComponents::colorPalette(\$theme);",
	ChartComponents::colorPalette($theme)
);

// -----------------------------------------------------------------------------
// Metrics
// -----------------------------------------------------------------------------
$content .= "<h2 id='metrics' class='doc-section-title'>Metrics</h2>";
$content .= "<div class='doc-section-desc'>Metric cards and big numbers. Variants: alignment and size (small/medium/large/auto).</div>";

$content .= docExample(
	'Metric card (left, auto)',
	"echo ChartComponents::metricCard('Users', '1,247', 'Total', 'left', \$theme);",
	ChartComponents::metricCard('Users', '1,247', 'Total', 'left', $theme)
);

$content .= docExample(
	'Metric card (center, size=small) – direct component function variant',
	"echo metricCard('Sales', '$2,847', 'Today', 'center', \$theme, 'small');",
	metricCard('Sales', '$2,847', 'Today', 'center', $theme, 'small')
);

$content .= docExample(
	'Large number card (size=medium) – direct component function variant',
	"echo largeNumberCard('354', 'Category', \$theme, 'medium');",
	largeNumberCard('354', 'Category', $theme, 'medium')
);

$content .= docExample(
	'Metrics container helper (flex)',
	"\$items = [\n    metricCard('Users', '1,247', 'Total', 'left', \$theme),\n    largeNumberCard('354', 'Category', \$theme),\n    metricCard('Revenue', '$2.4K', 'Daily', 'left', \$theme),\n];\n\necho metricsContainer(\$items, 'flex');",
	metricsContainer([
		metricCard('Users', '1,247', 'Total', 'left', $theme),
		largeNumberCard('354', 'Category', $theme),
		metricCard('Revenue', '$2.4K', 'Daily', 'left', $theme),
	], 'flex')
);

$content .= docExample(
	'Metrics container helper (grid)',
	"\$items = [\n    metricCard('A', '10', '', 'left', \$theme),\n    metricCard('B', '20', '', 'left', \$theme),\n    metricCard('C', '30', '', 'left', \$theme),\n    metricCard('D', '40', '', 'left', \$theme),\n];\n\necho metricsContainer(\$items, 'grid');",
	metricsContainer([
		metricCard('A', '10', '', 'left', $theme),
		metricCard('B', '20', '', 'left', $theme),
		metricCard('C', '30', '', 'left', $theme),
		metricCard('D', '40', '', 'left', $theme),
	], 'grid')
);

// -----------------------------------------------------------------------------
// Progress
// -----------------------------------------------------------------------------
$content .= "<h2 id='progress' class='doc-section-title'>Progress</h2>";
$content .= "<div class='doc-section-desc'>Progress bars and progress cards.</div>";

$content .= docExample(
	'Progress bar (primary)',
	"echo ChartComponents::progressBar('Completed', 75, 100, 'primary', \$theme);",
	ChartComponents::progressBar('Completed', 75, 100, 'primary', $theme)
);

$content .= docExample(
	'Multi progress card (primary/secondary/success)',
	"echo ChartComponents::multiProgressCard('Project Progress', [\n    ['label' => 'Frontend', 'value' => 70, 'total' => 100, 'color' => 'primary'],\n    ['label' => 'Backend', 'value' => 55, 'total' => 100, 'color' => 'secondary'],\n    ['label' => 'QA', 'value' => 30, 'total' => 100, 'color' => 'success'],\n], \$theme);",
	ChartComponents::multiProgressCard('Project Progress', [
		['label' => 'Frontend', 'value' => 70, 'total' => 100, 'color' => 'primary'],
		['label' => 'Backend', 'value' => 55, 'total' => 100, 'color' => 'secondary'],
		['label' => 'QA', 'value' => 30, 'total' => 100, 'color' => 'success'],
	], $theme)
);

$content .= docExample(
	'Single progress card',
	"echo ChartComponents::singleProgressCard('Goal Progress', 'This month', 78, \$theme);",
	ChartComponents::singleProgressCard('Goal Progress', 'This month', 78, $theme)
);

$content .= docExample(
	'Icon progress card',
	"echo ChartComponents::iconProgressCard('Sleep', 'Last night', '7h 15m', '🌙', \$theme);",
	ChartComponents::iconProgressCard('Sleep', 'Last night', '7h 15m', '🌙', $theme)
);

// -----------------------------------------------------------------------------
// Bars (basic)
// -----------------------------------------------------------------------------
$content .= "<h2 id='bars-basic' class='doc-section-title'>Bar Charts (Basic)</h2>";
$content .= "<div class='doc-section-desc'>Basic bar chart: single or multiple series.</div>";

$content .= docExample(
	'Bar chart (single series)',
	"\$data = [[30000, 50000, 70000, 40000, 60000, 65000]];\n\n// series labels\n\$series = ['Sales'];\n\necho ChartComponents::barChart(\$data, \$series, 'Sales 2024', \$theme);",
	ChartComponents::barChart([[30000, 50000, 70000, 40000, 60000, 65000]], ['Sales'], 'Sales 2024', $theme)
);

$content .= docExample(
	'Bar chart (two series)',
	"\$data = [\n    [30000, 50000, 70000, 40000, 60000, 65000],\n    [20000, 40000, 50000, 35000, 45000, 55000],\n];\n\n\$series = ['Sales', 'Purchases'];\n\necho ChartComponents::barChart(\$data, \$series, 'Sales vs Purchases', \$theme);",
	ChartComponents::barChart(
		[
			[30000, 50000, 70000, 40000, 60000, 65000],
			[20000, 40000, 50000, 35000, 45000, 55000],
		],
		['Sales', 'Purchases'],
		'Sales vs Purchases',
		$theme
	)
);

// -----------------------------------------------------------------------------
// Lines (basic)
// -----------------------------------------------------------------------------
$content .= "<h2 id='lines-basic' class='doc-section-title'>Line Charts (Basic)</h2>";
$content .= "<div class='doc-section-desc'>Line chart variants: line / smooth / area, and an annotation overlay.</div>";

$content .= docExample(
	'Line chart (type=line)',
	"\$data = [[100, 150, 200, 120, 180, 160]];\n\n\$series = ['Revenue'];\n\necho ChartComponents::lineChart(\$data, \$series, 'Revenue', 'Last 6 months', 'line', \$theme);",
	ChartComponents::lineChart([[100, 150, 200, 120, 180, 160]], ['Revenue'], 'Revenue', 'Last 6 months', 'line', $theme)
);

$content .= docExample(
	'Line chart (type=smooth)',
	"\$data = [[100, 150, 200, 120, 180, 160]];\n\n\$series = ['Revenue'];\n\necho ChartComponents::lineChart(\$data, \$series, 'Revenue', 'Smooth', 'smooth', \$theme);",
	ChartComponents::lineChart([[100, 150, 200, 120, 180, 160]], ['Revenue'], 'Revenue', 'Smooth', 'smooth', $theme)
);

$content .= docExample(
	'Line chart (type=area)',
	"\$data = [[100, 150, 200, 120, 180, 160]];\n\n\$series = ['Revenue'];\n\necho ChartComponents::lineChart(\$data, \$series, 'Revenue', 'Area fill', 'area', \$theme);",
	ChartComponents::lineChart([[100, 150, 200, 120, 180, 160]], ['Revenue'], 'Revenue', 'Area fill', 'area', $theme)
);

$content .= docExample(
	'Line chart (two series; legend auto-shown)',
	"\$data = [\n    [100, 150, 200, 120, 180, 160],\n    [80, 120, 160, 140, 200, 180],\n];\n\n\$series = ['Point 01', 'Point 02'];\n\necho ChartComponents::lineChart(\$data, \$series, 'Two series', 'Legend enabled', 'smooth', \$theme);",
	ChartComponents::lineChart(
		[
			[100, 150, 200, 120, 180, 160],
			[80, 120, 160, 140, 200, 180],
		],
		['Point 01', 'Point 02'],
		'Two series',
		'Legend enabled',
		'smooth',
		$theme
	)
);

$content .= docExample(
	'Line chart with annotation overlay',
	"\$data = [[100, 150, 200, 120, 180, 160]];\n\n\$labels = ['Revenue'];\n\n\$annotation = ['value' => '489', 'label' => 'additional text'];\n\necho ChartComponents::lineChartWithAnnotation(\$data, \$labels, 'Chart title', '15 April - 21 April', \$annotation, \$theme);",
	ChartComponents::lineChartWithAnnotation(
		[[100, 150, 200, 120, 180, 160]],
		['Revenue'],
		'Chart title',
		'15 April - 21 April',
		['value' => '489', 'label' => 'additional text'],
		$theme
	)
);

// -----------------------------------------------------------------------------
// Donuts
// -----------------------------------------------------------------------------
$content .= "<h2 id='donuts' class='doc-section-title'>Donut / Ring</h2>";
$content .= "<div class='doc-section-desc'>Specialized donut and ring components.</div>";

$content .= docExample(
	'Donut (3 categories) with legend',
	"\$data = [\n    ['label' => 'Point 01', 'value' => 55, 'color' => '#147AD6'],\n    ['label' => 'Point 02', 'value' => 25, 'color' => '#79D2DE'],\n    ['label' => 'Point 03', 'value' => 20, 'color' => '#EC6666'],\n];\n\necho ChartComponents::donutChart3Categories(\$data, 'Chart title goes here', \$theme);",
	ChartComponents::donutChart3Categories([
		['label' => 'Point 01', 'value' => 55, 'color' => '#147AD6'],
		['label' => 'Point 02', 'value' => 25, 'color' => '#79D2DE'],
		['label' => 'Point 03', 'value' => 20, 'color' => '#EC6666'],
	], 'Chart title goes here', $theme)
);

$content .= docExample(
	'Ring (4 categories) with center percent',
	"\$data = [\n    ['label' => 'Point 01', 'value' => 40, 'color' => '#147AD6'],\n    ['label' => 'Point 02', 'value' => 25, 'color' => '#79D2DE'],\n    ['label' => 'Point 03', 'value' => 20, 'color' => '#EC6666'],\n    ['label' => 'Point 04', 'value' => 15, 'color' => '#F97316'],\n];\n\necho ChartComponents::ringChart4Categories(\$data, 'Chart title goes here', 76, \$theme);",
	ChartComponents::ringChart4Categories([
		['label' => 'Point 01', 'value' => 40, 'color' => '#147AD6'],
		['label' => 'Point 02', 'value' => 25, 'color' => '#79D2DE'],
		['label' => 'Point 03', 'value' => 20, 'color' => '#EC6666'],
		['label' => 'Point 04', 'value' => 15, 'color' => '#F97316'],
	], 'Chart title goes here', 76, $theme)
);

// -----------------------------------------------------------------------------
// Carousel
// -----------------------------------------------------------------------------
$content .= "<h2 id='carousel' class='doc-section-title'>Carousel Chart</h2>";
$content .= "<div class='doc-section-desc'>Donut card with pagination dots. Variants: percent, color, activeDot.</div>";

$content .= docExample(
	'Carousel chart (activeDot=1)',
	"echo ChartComponents::carouselChart('Chart title', 'Here go numbers XX of total XX', 76, '#147AD6', 1, \$theme);",
	ChartComponents::carouselChart('Chart title', 'Here go numbers XX of total XX', 76, '#147AD6', 1, $theme)
);

$content .= docExample(
	'Carousel chart (activeDot=2, different color)',
	"echo ChartComponents::carouselChart('Chart title', 'Another slide', 58, '#EC6666', 2, \$theme);",
	ChartComponents::carouselChart('Chart title', 'Another slide', 58, '#EC6666', 2, $theme)
);

$content .= docExample(
	'Carousel chart (activeDot=3)',
	"echo ChartComponents::carouselChart('Chart title', 'Third slide', 92, '#79D2DE', 3, \$theme);",
	ChartComponents::carouselChart('Chart title', 'Third slide', 92, '#79D2DE', 3, $theme)
);

// -----------------------------------------------------------------------------
// Challenges
// -----------------------------------------------------------------------------
$content .= "<h2 id='challenges' class='doc-section-title'>Challenge List</h2>";
$content .= "<div class='doc-section-desc'>Vertical list of mini donut charts.</div>";

$content .= docExample(
	'Challenge list (3 items)',
	"\$items = [\n    ['id' => 'ch_01', 'percent' => 76, 'title' => 'Challenge 01', 'subtitle' => 'XX of total XX', 'color' => '#147AD6'],\n    ['id' => 'ch_02', 'percent' => 50, 'title' => 'Challenge 02', 'subtitle' => 'XX of total XX', 'color' => '#EC6666'],\n    ['id' => 'ch_03', 'percent' => 92, 'title' => 'Challenge 03', 'subtitle' => 'XX of total XX', 'color' => '#79D2DE'],\n];\n\necho ChartComponents::challengeList(\$items, \$theme);",
	ChartComponents::challengeList([
		['id' => 'ch_01', 'percent' => 76, 'title' => 'Challenge 01', 'subtitle' => 'XX of total XX', 'color' => '#147AD6'],
		['id' => 'ch_02', 'percent' => 50, 'title' => 'Challenge 02', 'subtitle' => 'XX of total XX', 'color' => '#EC6666'],
		['id' => 'ch_03', 'percent' => 92, 'title' => 'Challenge 03', 'subtitle' => 'XX of total XX', 'color' => '#79D2DE'],
	], $theme)
);

// -----------------------------------------------------------------------------
// Compact cards
// -----------------------------------------------------------------------------
$content .= "<h2 id='compact' class='doc-section-title'>Compact Cards</h2>";
$content .= "<div class='doc-section-desc'>Compact stat card and horizontal progress card.</div>";

$content .= docExample(
	'Compact stat card',
	"echo ChartComponents::compactStatCard('354', 'Category', 75, '#147AD6', \$theme);",
	ChartComponents::compactStatCard('354', 'Category', 75, '#147AD6', $theme)
);

$content .= docExample(
	'Horizontal card',
	"echo ChartComponents::horizontalCard('Challenge 01', 'XX of total XX', 76, '#147AD6', \$theme);",
	ChartComponents::horizontalCard('Challenge 01', 'XX of total XX', 76, '#147AD6', $theme)
);

// -----------------------------------------------------------------------------
// Advanced line
// -----------------------------------------------------------------------------
$content .= "<h2 id='lines-advanced' class='doc-section-title'>Line Charts (Advanced)</h2>";
$content .= "<div class='doc-section-desc'>Advanced line cards: area gradient, annotation box, multi-series with custom legend, and compact sparkline.</div>";

$labels6 = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'];

$content .= docExample(
	'Area line chart (gradient fill)',
	"echo ChartComponents::areaLineChart([100, 150, 200, 120, 180, 160], ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', '15 April - 21 April', '#147AD6', \$theme);",
	ChartComponents::areaLineChart([100, 150, 200, 120, 180, 160], $labels6, 'Chart title goes here', '15 April - 21 April', '#147AD6', $theme)
);

$content .= docExample(
	'Annotated line chart',
	"echo ChartComponents::annotatedLineChart([100, 150, 200, 120, 180, 160], ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', '15 April - 21 April', '489', 'additional text', '#147AD6', \$theme);",
	ChartComponents::annotatedLineChart([100, 150, 200, 120, 180, 160], $labels6, 'Chart title goes here', '15 April - 21 April', '489', 'additional text', '#147AD6', $theme)
);

$content .= docExample(
	'Multi line chart (custom legend)',
	"\$datasets = [\n    ['label' => 'Point 01', 'data' => [100, 150, 200, 120, 180, 160], 'color' => '#147AD6'],\n    ['label' => 'Point 02', 'data' => [80, 120, 160, 140, 200, 180], 'color' => '#EC6666'],\n];\n\necho ChartComponents::multiLineChart(\$datasets, ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', '15 April - 21 April', \$theme);",
	ChartComponents::multiLineChart([
		['label' => 'Point 01', 'data' => [100, 150, 200, 120, 180, 160], 'color' => '#147AD6'],
		['label' => 'Point 02', 'data' => [80, 120, 160, 140, 200, 180], 'color' => '#EC6666'],
	], $labels6, 'Chart title goes here', '15 April - 21 April', $theme)
);

$content .= docExample(
	'Compact line chart (sparkline)',
	"echo ChartComponents::compactLineChart('Chart title', '2,476', [10, 20, 18, 25, 22, 30, 28], '#147AD6', \$theme);",
	ChartComponents::compactLineChart('Chart title', '2,476', [10, 20, 18, 25, 22, 30, 28], '#147AD6', $theme)
);

// -----------------------------------------------------------------------------
// Pies / donuts
// -----------------------------------------------------------------------------
$content .= "<h2 id='pies' class='doc-section-title'>Pie / Donut</h2>";
$content .= "<div class='doc-section-desc'>Simple donut, simple pie, pie with custom legend, and a dashboard grid.</div>";

$content .= docExample(
	'Simple donut chart',
	"echo ChartComponents::simpleDonutChart(78, 'Completion Rate', 'This Month', '#147AD6', \$theme);",
	ChartComponents::simpleDonutChart(78, 'Completion Rate', 'This Month', '#147AD6', $theme)
);

$content .= docExample(
	'Simple pie chart',
	"echo ChartComponents::simplePieChart([35, 25, 20, 20], ['#147AD6','#EC6666','#79D2DE','#F97316'], 'Chart title', 'Here go numbers XX of total XX', \$theme);",
	ChartComponents::simplePieChart([35, 25, 20, 20], ['#147AD6', '#EC6666', '#79D2DE', '#F97316'], 'Chart title', 'Here go numbers XX of total XX', $theme)
);

$content .= docExample(
	'Pie chart with legend',
	"\$data = [\n    ['label' => 'Point 01', 'value' => 40, 'color' => '#147AD6'],\n    ['label' => 'Point 02', 'value' => 35, 'color' => '#79D2DE'],\n    ['label' => 'Point 03', 'value' => 25, 'color' => '#EC6666'],\n];\n\necho ChartComponents::pieChartWithLegend(\$data, 'Chart Title', \$theme);",
	ChartComponents::pieChartWithLegend([
		['label' => 'Point 01', 'value' => 40, 'color' => '#147AD6'],
		['label' => 'Point 02', 'value' => 35, 'color' => '#79D2DE'],
		['label' => 'Point 03', 'value' => 25, 'color' => '#EC6666'],
	], 'Chart Title', $theme)
);

$content .= docExample(
	'Dashboard grid (donuts + pies)',
	"\$donuts = [\n    ['percentage' => 58, 'title' => 'Chart title', 'subtitle' => '15 April - 15 May', 'color' => '#147AD6'],\n    ['percentage' => 72, 'title' => 'Chart title', 'subtitle' => '15 April - 15 May', 'color' => '#EC6666'],\n];\n\n\$pies = [\n    ['data' => [35, 25, 20, 20], 'colors' => ['#147AD6','#79D2DE','#EC6666','#F97316'], 'title' => 'Chart title', 'legend' => false],\n];\n\necho ChartComponents::chartDashboard(\$donuts, \$pies, \$theme);",
	ChartComponents::chartDashboard(
		[
			['percentage' => 58, 'title' => 'Chart title', 'subtitle' => '15 April - 15 May', 'color' => '#147AD6'],
			['percentage' => 72, 'title' => 'Chart title', 'subtitle' => '15 April - 15 May', 'color' => '#EC6666'],
		],
		[
			['data' => [35, 25, 20, 20], 'colors' => ['#147AD6', '#79D2DE', '#EC6666', '#F97316'], 'title' => 'Chart title', 'legend' => false],
		],
		$theme
	)
);

// -----------------------------------------------------------------------------
// Advanced bars
// -----------------------------------------------------------------------------
$content .= "<h2 id='bars-advanced' class='doc-section-title'>Bar Charts (Advanced)</h2>";
$content .= "<div class='doc-section-desc'>Special bar chart cards. Note: <code>labeledBarChart</code> uses chartjs-plugin-datalabels (loaded at the top of this page).</div>";

$content .= docExample(
	'Value bar chart (highlighted max bars)',
	"echo ChartComponents::valueBarChart([500, 750, 600, 550, 400, 300, 350], ['M','T','W','T','F','S','S'], '$476', 'Daily average', '#147AD6', \$theme);",
	ChartComponents::valueBarChart([500, 750, 600, 550, 400, 300, 350], ['M','T','W','T','F','S','S'], '$476', 'Daily average', '#147AD6', $theme)
);

$content .= docExample(
	'Annotated bar chart',
	"echo ChartComponents::annotatedBarChart([200, 450, 300, 520, 600, 480, 350], ['M','T','W','T','F','S','S'], 'Chart title goes here', '15 April - 21 April', '742', 'additional text', '#147AD6', \$theme);",
	ChartComponents::annotatedBarChart([200, 450, 300, 520, 600, 480, 350], ['M','T','W','T','F','S','S'], 'Chart title goes here', '15 April - 21 April', '742', 'additional text', '#147AD6', $theme)
);

$content .= docExample(
	'Labeled bar chart',
	"echo ChartComponents::labeledBarChart([200, 450, 300, 520, 600, 480, 350], ['M','T','W','T','F','S','S'], 'Chart title goes here', '15 April - 21 April', '#147AD6', \$theme);",
	ChartComponents::labeledBarChart([200, 450, 300, 520, 600, 480, 350], ['M','T','W','T','F','S','S'], 'Chart title goes here', '15 April - 21 April', '#147AD6', $theme)
);

$content .= docExample(
	'Multi bar chart (multiple datasets + legend)',
	"\$datasets = [\n    ['label' => 'Point 01', 'data' => [325, 450, 350, 300, 420, 380], 'color' => '#147AD6'],\n    ['label' => 'Point 02', 'data' => [225, 350, 280, 260, 320, 300], 'color' => '#EC6666'],\n];\n\necho ChartComponents::multiBarChart(\$datasets, ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', 'Last 6 months', \$theme);",
	ChartComponents::multiBarChart([
		['label' => 'Point 01', 'data' => [325, 450, 350, 300, 420, 380], 'color' => '#147AD6'],
		['label' => 'Point 02', 'data' => [225, 350, 280, 260, 320, 300], 'color' => '#EC6666'],
	], ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', 'Last 6 months', $theme)
);

$content .= docExample(
	'Combined bar chart (positive + negative)',
	"\$positive = [120, 180, 140, 200, 160, 220];\n\n\$negative = [-80, -120, -90, -150, -110, -170];\n\necho ChartComponents::combinedBarChart(\$positive, \$negative, ['JAN','FEB','MAR','APR','MAY','JUN'], 'Chart title goes here', 'Last 6 months', '#147AD6', '#EC6666', \$theme);",
	ChartComponents::combinedBarChart(
		[120, 180, 140, 200, 160, 220],
		[-80, -120, -90, -150, -110, -170],
		['JAN','FEB','MAR','APR','MAY','JUN'],
		'Chart title goes here',
		'Last 6 months',
		'#147AD6',
		'#EC6666',
		$theme
	)
);

echo ChartComponents::renderComplete($content, 'Chart Components Docs', $theme);

?>
