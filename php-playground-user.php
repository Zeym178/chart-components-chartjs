<?php
require_once __DIR__ . '/ChartComponents.php';
ChartComponents::init();

$theme = 'light';

$component = 
ChartComponents::colorPalette($theme);

echo ChartComponents::renderComplete($component, 'Preview', $theme);
