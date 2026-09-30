<?php declare(strict_types= 1); ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);   
// BLOQUE 1

$unidades_raw = $_GET['unidades'] ?? null;
$unidades = filter_var($unidades_raw, FILTER_VALIDATE_INT);

if ($unidades === false || $unidades <= 0) {
    http_response_code(400); 
    die('Error 400: La cantidad de unidades debe ser un número entero positivo.');
}
echo "<pre>";
var_dump($unidades);
echo "</pre>";

// BLOQUE 2

/** 
*@param array<array{modelo: string, precio_dia: float}> $vehiculos
*@param int $dias
*@return float
*@throws InvalidArgumentException
*/
// Funcion para interrumpir si la lista esta vacia
function calcular_alquiler(array $vehiculos, int $dias): float{
    if (empty($vehiculos)) {
       throw new InvalidArgumentException("No puede estar vacio el listado de vehiculos");
    }
    // Suma del coste base de todos los vehiculos
    $costeBase = 0.0;
    foreach ($vehiculos as $v) {
        $costeBase += ($v['precio_dia'] ?? 0.0) * $dias;
    }
    // Categorización condicional de descuento o suplemento según la cuantía total
    if ($costeBase > 500) {
        $total = $costeBase * 0.85;
    } elseif ($costeBase > 200) {
        $total = $costeBase * 0.95;

    } else {
        $total = $costeBase;
    }
    return round($total,2);
}

// Lista de vehículos de prueba
$vehiculosSeleccionados = [
    ['modelo' => 'Tesla Model 3', 'precio_dia' => 60.0],
    ['modelo' => 'Nissan Leaf', 'precio_dia' => 40.0],
];

try{
    echo calcular_alquiler($vehiculosSeleccionados, $unidades);
} catch (InvalidArgumentException $error) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($error->getMessage()) . "</p>";
}

?>

