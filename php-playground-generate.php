<?php
require_once __DIR__ . '/ChartComponents.php';
ChartComponents::init();

function jsonResponse($data, $status) {
    if (function_exists('http_response_code')) {
        http_response_code($status);
    } else {
        header('X-PHP-Response-Code: ' . (int)$status, true, (int)$status);
    }
    header('Content-Type: application/json; charset=utf-8');

    $flags = 0;
    if (defined('JSON_UNESCAPED_SLASHES')) {
        $flags = $flags | JSON_UNESCAPED_SLASHES;
    }
    if (defined('JSON_UNESCAPED_UNICODE')) {
        $flags = $flags | JSON_UNESCAPED_UNICODE;
    }

    echo json_encode($data, $flags);
    exit;
}

function safeTheme($value) {
    return $value === 'dark' ? 'dark' : 'light';
}

function extractThemeFromCode($code) {
    if (preg_match('/\$theme\s*=\s*[\"\'](dark|light)[\"\']\s*;/i', $code, $m)) {
        return strtolower($m[1]);
    }
    return null;
}

$code = isset($_POST['code']) ? $_POST['code'] : '';
if (!is_string($code) || trim($code) === '') {
    jsonResponse(array('ok' => false, 'error' => 'Missing code payload.'), 400);
}

$theme = safeTheme(isset($_POST['theme']) ? $_POST['theme'] : 'light');
$themeFromCode = extractThemeFromCode($code);
if ($themeFromCode !== null) {
    $theme = safeTheme($themeFromCode);
}

// Write the user's code as-is to the aux file. This is intended for local dev.
$out = $code;
if (stripos(ltrim($out), '<?php') !== 0 && stripos(ltrim($out), '<?') !== 0) {
    $out = "<?php\n" . $out;
}

$target = __DIR__ . '/php-playground-user.php';
$tmp = $target . '.tmp';

if (@file_put_contents($tmp, $out) === false) {
    jsonResponse(array('ok' => false, 'error' => 'Failed to write temp file. Check folder permissions.'), 500);
}

if (!@rename($tmp, $target)) {
    @unlink($tmp);
    jsonResponse(array('ok' => false, 'error' => 'Failed to replace php-playground-user.php. Check folder permissions.'), 500);
}

jsonResponse(array('ok' => true, 'url' => 'php-playground-user.php?ts=' . time(), 'theme' => $theme), 200);
