(function () {
  const presets = window.__PHP_PG_PRESETS__ || {};
  const initialText = window.__PHP_PG_INITIAL_TEXT__ || "<?php\nrequire_once __DIR__ . '/ChartComponents.php';\nChartComponents::init();\n\n$theme = 'light';\n$component = ChartComponents::barChart([[1,2,3]], ['Series'], 'Chart title', $theme);\necho ChartComponents::renderComplete($component, 'Preview', $theme);\n";

  const pgTheme = document.getElementById('pgTheme');
  const pgPreset = document.getElementById('pgPreset');
  const pgReset = document.getElementById('pgReset');
  const pgRun = document.getElementById('pgRun');
  const pgError = document.getElementById('pgError');
  const pgFrame = document.getElementById('pgFrame');
  const generateUrl = window.__PHP_PG_GENERATE_URL__ || 'php-playground-generate.php';

  function showError(message) {
    pgError.style.display = 'block';
    pgError.textContent = message;
  }

  function clearError() {
    pgError.style.display = 'none';
    pgError.textContent = '';
  }

  Object.keys(presets).forEach((key) => {
    const opt = document.createElement('option');
    opt.value = key;
    opt.textContent = key;
    pgPreset.appendChild(opt);
  });
  if (!pgPreset.value) pgPreset.value = Object.keys(presets)[0] || '';

  const textarea = document.getElementById('pgEditor');
  textarea.value = initialText;

  const editor = CodeMirror.fromTextArea(textarea, {
    mode: 'application/x-httpd-php',
    lineNumbers: true,
    tabSize: 2,
    indentUnit: 2,
  });

  function applyTheme(theme) {
    document.body.classList.toggle('theme-dark', theme === 'dark');
    document.body.classList.toggle('theme-light', theme !== 'dark');
    editor.setOption('theme', theme === 'dark' ? 'material-darker' : 'default');
  }

  function detectThemeFromCode(code) {
    const m = code.match(/\$theme\s*=\s*['"](dark|light)['"]\s*;/i);
    return m ? m[1].toLowerCase() : null;
  }

  function setThemeInCode(code, theme) {
    if (!code.includes('$theme')) return code;
    if (!/\$theme\s*=\s*['"](dark|light)['"]\s*;/i.test(code)) return code;
    return code.replace(/\$theme\s*=\s*['"](dark|light)['"]\s*;/i, `$theme = '${theme}';`);
  }

  function renderNow() {
    clearError();
    const code = editor.getValue();
    if (!code || !code.trim()) {
      showError('Write a PHP expression to render a component.');
      return;
    }

    const themeFromCode = detectThemeFromCode(code);
    const theme = themeFromCode || pgTheme.value || 'light';
    if (pgTheme.value !== theme) pgTheme.value = theme;
    applyTheme(theme);

    const body = new URLSearchParams();
    body.set('theme', theme);
    body.set('code', code);

    fetch(generateUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
      body: body.toString(),
    })
      .then(async (res) => {
        const text = await res.text();
        let data = null;
        try {
          data = JSON.parse(text);
        } catch (e) {
          // Not JSON (likely PHP error output)
        }

        if (!res.ok) {
          throw new Error((data && data.error) || text || 'Failed to generate preview file.');
        }
        if (!data || !data.ok) {
          throw new Error((data && data.error) || 'Failed to generate preview file.');
        }
        if (pgFrame && data.url) {
          pgFrame.src = data.url;
        }
      })
      .catch((e) => {
        showError(e.message);
      });
  }

  function loadPreset(key) {
    const preset = presets[key];
    if (!preset) return;
    editor.setValue(preset);
  }

  pgTheme.addEventListener('change', () => {
    const updated = setThemeInCode(editor.getValue(), pgTheme.value);
    if (updated !== editor.getValue()) editor.setValue(updated);
    renderNow();
  });

  pgPreset.addEventListener('change', () => {
    loadPreset(pgPreset.value);
    renderNow();
  });

  pgReset.addEventListener('click', () => {
    loadPreset(pgPreset.value);
    renderNow();
  });

  pgRun.addEventListener('click', () => {
    renderNow();
  });

  let debounceTimer = null;
  editor.on('change', () => {
    clearError();
    window.clearTimeout(debounceTimer);
    debounceTimer = window.setTimeout(renderNow, 700);
  });

  applyTheme(pgTheme.value);
  renderNow();
})();
