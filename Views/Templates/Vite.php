<?php
function vite(string $entry): void
{
  $env = APP_ENV;
  $baseUrl = BASE_URL;

  if ($env === 'dev') {
    // En desarrollo: carga desde el servidor de Vite
    echo "hola perrito";
    echo <<<HTML
            <script type="module" src="http://localhost:5173/Assets/@vite/client"></script>
            <script type="module" src="http://localhost:5173/Assets/{$entry}.ts"></script>
        HTML;
  } else {
    // En producción: carga desde los archivos generados
    $manifestPath = "$baseUrl/Assets/.vite/manifest.json";
    if (!file_exists($manifestPath)) {
      echo "<!-- No se encontró el manifest de Vite -->";
      return;
    }

    $manifest = json_decode(file_get_contents($manifestPath), true);
    $viteEntry = "{$entry}.ts";

    if (!isset($manifest[$viteEntry])) {
      echo "<!-- No se encontró la entrada {$viteEntry} en el manifest -->";
      return;
    }

    $entryData = $manifest[$viteEntry];

    // CSS
    if (isset($entryData['css'])) {
      foreach ($entryData['css'] as $css) {
        echo "<link rel='stylesheet' href='{$baseUrl}Assets/{$css}'>\n";
      }
    }

    // JS
    echo "<script type='module' src='{$baseUrl}Assets/{$entryData['file']}'></script>\n";
  }
}
