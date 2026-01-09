<?php
require_once __DIR__ . '/ChartComponents.php';
ChartComponents::init();

function jsonResponse(array $data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function safeTheme($value): string {
    return $value === 'dark' ? 'dark' : 'light';
}

function extractThemeFromCode(string $code): ?string {
    if (preg_match('/\$theme\s*=\s*[\"\'](dark|light)[\"\']\s*;/i', $code, $m)) {
        return strtolower($m[1]);
    }
    return null;
}

$code = $_POST['code'] ?? '';
if (!is_string($code) || trim($code) === '') {
    jsonResponse(['ok' => false, 'error' => 'Missing code payload.'], 400);
}

$theme = safeTheme($_POST['theme'] ?? 'light');
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
    jsonResponse(['ok' => false, 'error' => 'Failed to write temp file. Check folder permissions.'], 500);
}

if (!@rename($tmp, $target)) {
    @unlink($tmp);
    jsonResponse(['ok' => false, 'error' => 'Failed to replace php-playground-user.php. Check folder permissions.'], 500);
}

jsonResponse(['ok' => true, 'url' => 'php-playground-user.php?ts=' . time(), 'theme' => $theme]);
