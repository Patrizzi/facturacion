<?php
use Carbon\Carbon;

function progressDate($start_date, $end_date){
    $start_date = Carbon::parse($start_date);
    $end_date = Carbon::parse($end_date);
    $current_date = Carbon::today();

    $total_time = $end_date->diffInSeconds($start_date);
    $lapsed_time = $current_date->diffInSeconds($start_date);

    if ($total_time <= 0 || $end_date < $start_date || $end_date < $current_date) {
        return 100;
    }

    if ($start_date > $current_date) {
        return 0;
    }

    $percent = round(($lapsed_time / $total_time) * 100);
    return $percent;
}

function calculateWeeks($date1, $date2){
    if (is_null($date1) || is_null($date2)) {
        return 0;
    }

    $total_days = Carbon::parse($date2)->diffInDays(Carbon::parse($date1));
    $total_weeks = ceil($total_days / 7) + 1;
    return $total_weeks;
}

function calculateDays($date1, $date2){
    $total_days = Carbon::parse($date2)->diffInDays(Carbon::parse($date1)) + 1;
    return $total_days;
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
