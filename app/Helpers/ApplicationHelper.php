<?php
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
