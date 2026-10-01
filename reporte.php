<?php declare(strict_types=1);

// Simulamos la cantidad de unidades
if (!isset($_GET['unidades'])) {
    $_GET['unidades'] = 3; // Valor por defecto
}

// Cargamos y ejecutamos la logica de procesador.php
require_once 'procesador.php';

// BLOQUE 3:
$catalogo = [
    [
        'modelo' => 'Tesla Model 3 Edición Especial',
        'categoria' => 'tecnología alta gama',
        'autonomia' => 550,
        'descuento' => null 
    ],
    [
        'modelo' => 'Renault Zoé E-Tech',
        'categoria' => 'movilidad urbana',
        'autonomia' => 395,
    ],
    [
        'modelo' => 'BMW iX3 SUV',
        'categoria' => 'todoterreno eléctrico',
        'autonomia' => 460,
        'descuento' => 10 
    ],
    [
        'modelo' => 'Nissan Leaf Ágil',
        'categoria' => 'compacto ecológico',
        'autonomia' => 270,
        'descuento' => null
    ]
];

// Ordenacion descendente por autonomia
usort($catalogo, function (array $a, array $b): int {
    return $b['autonomia'] <=> $a['autonomia'];
});

// BLOQUE 4:
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoDrive</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CSS vía CDN -->
</head>
<body class="bg-slate-100 font-sans text-slate-800 p-6 min-h-screen">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-extrabold text-center text-slate-800 mb-6 tracking-tight">Reporte de EcoDrive</h1>

        <div class="bg-white border-l-4 border-emerald-600 rounded-r-lg p-5 shadow-sm mb-6 flex justify-between items-center">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Simulación de Reserva</p>
                <p class="text-slate-800 font-medium text-sm mt-1">Unidades solicitados: <span class="font-bold text-emerald-600"><?= $unidades ?></span></p>
            </div>
            <div class="text-right">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Coste Total Calculado</p>
                <p class="text-2xl font-extrabold text-emerald-600">$<?= number_format($total_alquiler, 2) ?></p>
            </div>
        </div>

        <!-- Catálogo de la Flota -->
        <div class="space-y-4">
            <?php foreach ($catalogo as $vehiculo): ?>
                <?php
                    $modelo_mayus = htmlspecialchars(mb_strtoupper($vehiculo['modelo'], 'UTF-8'), ENT_QUOTES, 'UTF-8');
                    $categoria_titulo = htmlspecialchars(mb_convert_case($vehiculo['categoria'], MB_CASE_TITLE, 'UTF-8'), ENT_QUOTES, 'UTF-8');
                    $vehiculo_longitud = mb_strlen($vehiculo['modelo'], 'UTF-8');

                    $existe_clave = array_key_exists('descuento', $vehiculo);
                    $tiene_valor  = isset($vehiculo['descuento']);
                ?>

                <div class="bg-white rounded-lg p-5 shadow-sm border-l-4 border-emerald-500 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-bold text-slate-900">
                            <?= $modelo_mayus ?>
                        </h3>
                        <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded-full border border-emerald-200">
                            <?= $vehiculo_longitud ?> caracteres
                        </span>
                    </div>

                    <div class="text-sm space-y-1.5 text-slate-600">
                        <div>
                            <strong class="text-slate-800">Categoría:</strong> <?= $categoria_titulo ?>
                        </div>
                        <div>
                            <strong class="text-slate-800">Autonomía:</strong> <?= $vehiculo['autonomia'] ?> km
                        </div>
                        <div class="pt-2 border-t border-slate-100 flex items-center gap-4 text-xs">
                            <div>
                                <span class="font-semibold text-slate-700">Existe clave 'descuento':</span> 
                                <span class="<?= $existe_clave ? 'text-emerald-600 font-bold' : 'text-rose-600 font-bold' ?>">
                                    <?= $existe_clave ? 'SÍ' : 'NO' ?>
                                </span>
                            </div>
                            <span class="text-slate-300">|</span>
                            <div>
                                <span class="font-semibold text-slate-700">Valor NO nulo:</span> 
                                <span class="<?= $tiene_valor ? 'text-emerald-600 font-bold' : 'text-rose-600 font-bold' ?>">
                                    <?= $tiene_valor ? 'SÍ' : 'NO' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

<?php
$reporte_html = ob_get_clean();

// Salida directa del HTML maquetado 
echo $reporte_html;

$json = json_encode($catalogo, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
?>
<script>
    const datos = <?= $json ?>;
    console.log("Datos cargados correctamente:", datos);
</script>