<?php declare(strict_types= 1); ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);   

$unidades_raw = $_GET['unidades'] ?? null;
$unidades = filter_var($unidades_raw, FILTER_VALIDATE_INT);

if ($unidades === false || $unidades <= 0) {
    http_response_code(400); 
    die('Error 400: La cantidad de unidades debe ser un número entero positivo.');
}
echo "<pre>";
var_dump($unidades);
echo "</pre>";
?>