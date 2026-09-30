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

// Bucle para recorrer el catálogo ya ordenado
foreach ($catalogo as $vehiculo) {
    $categoria_titulo  = mb_convert_case($vehiculo['categoria'], MB_CASE_TITLE, 'UTF-8');
    $modelo_mayus = mb_strtoupper($vehiculo['modelo'], 'UTF-8');
    $vehiculo_longitud = mb_strlen($vehiculo['modelo'], 'UTF-8');

    // Diferenciación de existencia de propiedad vs valor no nulo
    $existe_clave = array_key_exists('descuento', $vehiculo);
    $tiene_valor  = isset($vehiculo['descuento']);
}

?>