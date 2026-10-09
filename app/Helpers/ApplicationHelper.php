<?php
use Carbon\Carbon;
use Illuminate\Support\Str;

function progressDate($start_date, $end_date){
    $start_date = Carbon::parse($start_date);
    $end_date = Carbon::parse($end_date);
    $current_date = Carbon::today();

    $total_time = $end_date->diffInSeconds($start_date);
    $lapsed_time = $current_date->diffInSeconds($start_date);
    // dd($current_date);
    if ($total_time <= 0 || $end_date < $start_date || $end_date < $current_date) {
        return 100;
    }

    if ($start_date > $current_date) {
        return 0;
    }

    $percent = round(($lapsed_time / $total_time) * 100);
    return $percent;
}

function createdTime($a)
{
    $timeElapsed = now()->diffInSeconds($a->created_at);
    
    switch (true) {
        case $timeElapsed < 60:
            return "{$timeElapsed}s";
        case $timeElapsed < 3600:
            return floor($timeElapsed / 60) . "min";
        case $timeElapsed < 86400:
            return floor($timeElapsed / 3600) . "h";
        case $timeElapsed < 2592000:
            return floor($timeElapsed / 86400) . "d";
        case $timeElapsed < 31536000:
            return floor($timeElapsed / 2592000) . "m";
        default:
            return floor($timeElapsed / 31536000) . "a";
    }
}

function getImageUrl($imagen, $option)
{
    return Str::startsWith($imagen, 'http') 
        ? $imagen 
        : asset(getImagePath($option) . $imagen);
}

function getImagePath($option)
{
    $paths = [
        1 => "/profile/images/",
        2 => "/archivos/imagenes/project_manager/",
    ];

    return $paths[$option] ?? null;
}

function randomPastelColor(): string {

    // Generar valores altos de RGB (valores cercanos a 255) para que sean pasteles
    $r = rand(180, 255);
    $g = rand(180, 255);
    $b = rand(180, 255);

    // Convertir los valores RGB a hexadecimal
    return sprintf("#%02X%02X%02X", $r, $g, $b);
}

function generateColors(callable $functionColor, int $n = 1): array {
    $colors = [];
    for ($i = 0; $i < $n; $i++) {
        $colors[] = $functionColor();
    }
    return $colors;
}

if (!function_exists('push_asset_once')) {
    /**
     * Evita que los estilos, scripts u otros tipos de archivos se agreguen más de una vez, basándose en la extensión de archivo.
     *
     * @param string|array $paths Ruta(s) del archivo CSS/JS generada(s) con asset()
     * @param array $assetTags Mapa opcional de extensiones a su respectivo HTML de inclusión
     * @return string HTML generado para incluir los assets
     */
    function push_asset_once($paths, $assetTags = []) {
        static $pushed = [];

        $defaultAssetTags = [
            'css' => '<link rel="stylesheet" href=":path">',
            'js' => '<script src=":path"></script>',
            // Se pueden agregar más extensiones y sus etiquetas aquí
        ];

        // Fusionar los tipos de assets proporcionados con los predeterminados
        $assetTags = array_merge($defaultAssetTags, $assetTags);

        // Convertir $paths a array si no lo es
        $paths = (array) $paths;

        $html = '';

        foreach ($paths as $path) {
            $fullPath = asset($path);

            // Extraer la extensión del archivo
            $extension = pathinfo($path, PATHINFO_EXTENSION);

            // Verificar si la extensión está soportada
            if (!array_key_exists($extension, $assetTags)) {
                throw new InvalidArgumentException("El tipo de archivo con extensión '$extension' no está soportado.");
            }

            // Usar el nombre del archivo (sin la extensión) como clave única
            $key = pathinfo($path, PATHINFO_FILENAME);

            // Verificar si el archivo ya ha sido agregado
            if (!isset($pushed[$extension][$key])) {
                $pushed[$extension][$key] = true;
                $html .= str_replace(':path', $fullPath, $assetTags[$extension]) . PHP_EOL;
            }
        }

        return $html;
    }
}

function percentage($a): int {
    return 100;
}

function diffDays($a): int {
    return $a->fecha_inicio->diffInDays($a->fecha_cierre);
}

function diffWeeks($a): int {
    return $a->fecha_inicio->diffInWeeks($a->fecha_cierre);
}

function daysToStart($a, Carbon $date): int {
    return $a->fecha_inicio->diffInDays($date);
}

function daysToEnd($a, Carbon $date): int {
    return $a->fecha_cierre->diffInDays($date);
}