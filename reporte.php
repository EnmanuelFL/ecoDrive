<?php declare(strict_types= 1);
// BLOQUE 3: Catalogo de la flota

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

// Ordenación descendente por autonomía (<=>)
usort($catalogo, function (array $a, array $b): int {
    return $b['autonomia'] <=> $a['autonomia'];
});

// BLOQUE 4

ob_start();
// Bucle para recorrer el catálogo ya ordenado
foreach ($catalogo as $vehiculo) {
    $categoria_titulo  = mb_convert_case($vehiculo['categoria'], MB_CASE_TITLE, 'UTF-8');
    $modelo_mayus = mb_strtoupper($vehiculo['modelo'], 'UTF-8');
    $vehiculo_longitud = mb_strlen($vehiculo['modelo'], 'UTF-8');

    // Diferenciación de existencia de propiedad vs valor no nulo
    $existe_clave = array_key_exists('descuento', $vehiculo);
    $tiene_valor  = isset($vehiculo['descuento']);
    echo "<p>";
    echo "Modelo: {$modelo_mayus} (Longitud: {$vehiculo_longitud})<br>";
    echo "Categoría: {$categoria_titulo}<br>";
    echo "Autonomía: {$vehiculo['autonomia']} km<br>";
    echo "Existe clave 'descuento': " . ($existe_clave ? 'SÍ' : 'NO') . "<br>";
    echo "Tiene valor NO nulo: " . ($tiene_valor ? 'SÍ' : 'NO');
    echo "</p><hr>";
}
$reporte_html = ob_get_clean();
echo htmlspecialchars($reporte_html,ENT_QUOTES,'UTF-8');
$json = json_encode($catalogo, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
?>
<script>
    const datos = <?= $json ?>;
    console.log("Datos cargados correctamente", datos);
</script>
