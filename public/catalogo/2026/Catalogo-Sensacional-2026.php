<?php

$catalogos = [
    'general' => [
        'archivo' => 'Catalogo-Sensacional-2026.png',
        'titulo' => 'Catálogo Sensacional 2026',
        'alt' => 'Catálogo de productos Sensacional 2026',
    ],
    'estandar' => [
        'archivo' => 'globos-sensacional-estandar.png',
        'titulo' => 'Colores estándar',
        'alt' => 'Catálogo de globos colores estándar Sensacional',
    ],
    'metalico-perla' => [
        'archivo' => 'globos-sensacional-metalico-perla.png',
        'titulo' => 'Perla y metálicos',
        'alt' => 'Catálogo de globos perla y metálicos Sensacional',
    ],
    'neon-cristal' => [
        'archivo' => 'globos-sensacional-neon-cristal.png',
        'titulo' => 'Cristal y neón',
        'alt' => 'Catálogo de globos cristal y neón Sensacional',
    ],
    'vintage-fashion' => [
        'archivo' => 'globos-sensacional-vintage-fashion.png',
        'titulo' => 'Vintage y fashion',
        'alt' => 'Catálogo de globos vintage y fashion Sensacional',
    ],
    'lanzamientos' => [
        'archivo' => 'globos-sensacional-lanzamientos.png',
        'titulo' => 'Lanzamientos',
        'alt' => 'Catálogo de lanzamientos Sensacional',
    ],
    'para-toda-ocasion' => [
        'archivo' => 'globos-sensacional-para-toda-ocasion.png',
        'titulo' => 'Para toda ocasión',
        'alt' => 'Catálogo de globos para toda ocasión Sensacional',
    ],
    'surtido-mezclado' => [
        'archivo' => 'globos-sensacional-surtido-mezclado.png',
        'titulo' => 'Surtido y mezclas',
        'alt' => 'Catálogo de surtido y mezclas Sensacional',
    ],
];

$clave = $_GET['coleccion'] ?? 'general';
$catalogo = $catalogos[$clave] ?? $catalogos['general'];
$titulo = htmlspecialchars($catalogo['titulo'], ENT_QUOTES, 'UTF-8');
$alt = htmlspecialchars($catalogo['alt'], ENT_QUOTES, 'UTF-8');
$archivo = htmlspecialchars($catalogo['archivo'], ENT_QUOTES, 'UTF-8');

?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $titulo ?> | Sensacional 2026</title>
    <meta name="description" content="<?= $titulo ?>. Globos de látex natural. Envíos a todo México.">
    <style>
        :root { color-scheme: light; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: system-ui, -apple-system, Segoe UI, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }
        header {
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.85rem 1.25rem;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
        }
        a { color: #e11d2e; font-weight: 700; text-decoration: none; }
        a:hover { color: #f97316; }
        main {
            max-width: 920px;
            margin: 0 auto;
            padding: 1.5rem 1rem 3rem;
        }
        img {
            display: block;
            width: 100%;
            height: auto;
            border-radius: 1rem;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
            background: #fff;
        }
    </style>
</head>
<body>
    <header>
        <a href="/productos">← Volver al inicio</a>
        <strong><?= $titulo ?></strong>
    </header>
    <main>
        <img
            src="<?= $archivo ?>"
            alt="<?= $alt ?>"
        >
    </main>
</body>
</html>
