<?php
require_once __DIR__ . '/ChartComponents.php';
ChartComponents::init();

require_once __DIR__ . '/php-presets.php';

$themeParam = isset($_GET['theme']) ? $_GET['theme'] : 'light';
$theme = ($themeParam === 'dark') ? 'dark' : 'light';

$presets = cc_playground_presets($theme);

$jsonFlags = 0;
if (defined('JSON_UNESCAPED_SLASHES')) {
	$jsonFlags = $jsonFlags | JSON_UNESCAPED_SLASHES;
}
if (defined('JSON_UNESCAPED_UNICODE')) {
	$jsonFlags = $jsonFlags | JSON_UNESCAPED_UNICODE;
}

$presetsJson = json_encode($presets, $jsonFlags);
$initialCode = reset($presets);
$initialCodeJs = json_encode($initialCode, $jsonFlags);

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
    <div class='pg-sub'>This is real copy-pastable PHP. Change <code>\$theme</code> (dropdown or in code) and the preview will re-render.</div>
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
