# EcoDrive

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Git](https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white)

Sistema web en PHP para la simulación, gestión de reservas, tarificación y presentación visual de un catálogo de flota de vehículos eléctricos.

---

## Tabla de Contenidos

- [Descripcion del Proyecto](#descripcion-del-proyecto)
- [Funcionalidades Principales](#funcionalidades-principales)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Requisitos Previos](#requisitos-previos)
- [Guia de Instalacion y Ejecucion](#guia-de-instalacion-y-ejecucion)
- [Casos de Uso y Pruebas](#casos-de-uso-y-pruebas)
- [Autor](#autor)

---

## Descripcion del Proyecto

EcoDrive es una aplicacion desarrollada en PHP enfocada en buenas practicas de programacion (tipado estricto, manejo estructurado de errores y excepciones, sanitizacion de entradas y manipulacion de cadenas multibyte). Su objetivo es procesar presupuestos de alquiler basados en volumen de dias o unidades y desplegar un reporte interactivo con la flota electrica disponible ordenada segun la autonomia de cada modelo.

---

## Funcionalidades Principales

1. **Validacion y Saneamiento de Datos:**
   - Evaluacion de entradas HTTP GET mediante `filter_var` con el filtro `FILTER_VALIDATE_INT`.
   - Control de codigos de respuesta HTTP (retorno de estado `400 Bad Request` en caso de valores no validos o menores o iguales a cero).

2. **Motor de Calculo y Reglas de Negocio:**
   - Calculo de coste base en funcion de tarifas diarias individuales.
   - Escalado de descuentos por tramos:
     - 15% de descuento para importes superiores a $500.
     - 5% de descuento para importes superiores a $200 y hasta $500.
     - Tarifa estandar sin descuento adicional para importes iguales o inferiores a $200.
   - Control de excepciones con `InvalidArgumentException` cuando los datos de vehiculos no son validos o estan vacios.

3. **Gestion y Ordenacion de Flota:**
   - Catalogo estructurado en arrays asociativos con especificaciones de modelo, categoria, autonomia y promociones.
   - Algoritmo de ordenacion descendente por autonomia mediante `usort` y el operador de comparacion combinada (`<=>`).

4. **Interfaz Visual y Seguridad:**
   - Diseno moderno, responsivo y minimalista basado en Tailwind CSS.
   - Manipulacion tipografica segura con extension `mbstring` (`mb_strtoupper`, `mb_convert_case`, `mb_strlen`).
   - Mitigacion de ataques XSS mediante `htmlspecialchars` con flags `ENT_QUOTES` y codificacion UTF-8.
   - Control de presencia y nulidad de campos mediante `array_key_exists` e `isset`.
   - Exportacion segura de datos estructurados a JavaScript mediante `json_encode` con flags de saneamiento de entidades HTML.

---

## Estructura del Proyecto

```text
ecoDrive/
├── .gitignore        # Definicion de archivos y carpetas omitidos por Git
├── README.md         # Documentacion tecnica del proyecto
├── procesador.php    # Modulo de logica de calculo, validacion y manejo de excepciones
└── reporte.php       # Interfaz de usuario, catalogo y generacion de reporte
```

### Detalle de Componentes

- **`procesador.php`**:
  Contiene la logica de backend, tipado estricto (`declare(strict_types=1)`), captura de peticiones `$_GET['unidades']`, definicion y ejecucion de la funcion `calcular_alquiler()`, y captura de excepciones mediante bloques `try-catch`.

- **`reporte.php`**:
  Punto de entrada visual que requiere a `procesador.php`. Define el catalogo de vehiculos, ejecuta el ordenamiento por rendimiento de bateria, procesa el buffer de salida con `ob_start()` / `ob_get_clean()` y maqueta la interfaz con Tailwind CSS.

- **`.gitignore`**:
  Archivo de configuracion para excluir archivos temporales, logs o carpetas de entorno local en el repositorio.

---

## Tecnologias Utilizadas

| Tecnologia | Descripcion |
| --- | --- |
| ![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white) | Lenguaje base del backend (version recomendada: PHP 8.0+) |
| ![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white) | Framework utilitario para el diseno de interfaz mediante CDN |
| ![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white) | Estructura semantica del reporte web |
| ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black) | Integracion de datos exportados en formato JSON en consola |
| ![Git](https://img.shields.io/badge/Git-F05032?style=flat-square&logo=git&logoColor=white) | Sistema de control de versiones |

---

## Requisitos Previos

Para ejecutar este proyecto en otro equipo se requiere:

- **PHP**: Version 8.0 o superior instalada.
- **Extension mbstring**: Habilitada en `php.ini` (habitualmente habilitada por defecto).
- **Navegador Web**: Chrome, Firefox, Edge o Safari.
- **Git** (opcional): Para la clonacion del repositorio.

---

## Guia de Instalacion y Ejecucion

### Metodo 1: Servidor Integrado de PHP (Recomendado para desarrollo rapido)

1. **Obtener los archivos del proyecto:**
   Copie la carpeta `ecoDrive` en el directorio de su preferencia o clone el repositorio:
   ```bash
   git clone <URL_DEL_REPOSITORIO> ecoDrive
   cd ecoDrive
   ```

2. **Verificar la instalacion de PHP:**
   Abra una terminal (PowerShell, CMD o bash) y ejecute:
   ```bash
   php -v
   ```

3. **Iniciar el servidor web embebido:**
   Desde la raiz de la carpeta `ecoDrive`, inicie el servidor de desarrollo:
   ```bash
   php -S localhost:8000
   ```

4. **Abrir en el navegador:**
   Acceda a la siguiente direccion:
   ```text
   http://localhost:8000/reporte.php
   ```

---

### Metodo 2: Entornos XAMPP, Laragon, WAMP o MAMP

1. **Mover la carpeta del proyecto:**
   Copie la carpeta `ecoDrive` dentro de la carpeta publica de su servidor local:
   - **XAMPP**: `C:\xampp\htdocs\ecoDrive`
   - **Laragon**: `C:\laragon\www\ecoDrive`
   - **WampServer**: `C:\wamp64\www\ecoDrive`

2. **Iniciar los servicios:**
   Abra el panel de control correspondiente (por ejemplo, XAMPP Control Panel) e inicie el modulo **Apache**.

3. **Abrir en el navegador:**
   Ingrese a:
   ```text
   http://localhost/ecoDrive/reporte.php
   ```

---

## Casos de Uso y Pruebas

El sistema permite simular diferentes reservas pasando el parametro `unidades` a traves de la URL:

- **Simulacion estandar (3 unidades por defecto):**
  ```text
  http://localhost:8000/reporte.php
  ```

- **Simulacion personalizada (por ejemplo, 5 unidades):**
  ```text
  http://localhost:8000/reporte.php?unidades=5
  ```

- **Prueba de aplicacion de descuento alto (10 unidades):**
  ```text
  http://localhost:8000/reporte.php?unidades=10
  ```

- **Prueba de validacion de error (parametro invalido o negativo):**
  ```text
  http://localhost:8000/reporte.php?unidades=-2
  http://localhost:8000/reporte.php?unidades=texto
  ```
  *Resultado esperado:* Respuesta HTTP 400 con el mensaje `Error 400: La cantidad de unidades debe ser un número entero positivo.`

---

## Autor

Proyecto desarrollado por: **Enmanuel Feliciano Lemos**
