<?php
require_once __DIR__ . '/ChartComponents.php';
ChartComponents::init();

$theme = 'dark';

$component = 
ChartComponents::colorPalette($theme);

echo ChartComponents::renderComplete($component, 'Preview', $theme);
