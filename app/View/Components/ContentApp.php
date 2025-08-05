<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Request;

class ContentApp extends Component
{
    public $breadcrumbs = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $title = 'Inicio',
        public array $buttons = []
    ) {
        $this->title = $title;
        $this->generateBreadcrumbs();
    }

    /**
     * Genera los breadcrumbs a partir de la URL actual.
     */
    public function generateBreadcrumbs()
    {
        // Obtén la URL actual y divídela en segmentos
        $path = Request::path();  // Esto obtiene la URL sin el dominio
        $segments = explode('/', $path); // Divide la URL en segmentos

        // Crea un array con los breadcrumbs
        $breadcrumbs = [];
        $url = '';

        foreach ($segments as $key => $segment) {
            $url .= '/' . $segment;
            $breadcrumbs[] = [
                'name' => ucfirst($segment), // Capitaliza el primer carácter del segmento
                'url' => url($url), // Genera la URL acumulada
                'is_last' => ($key == count($segments) - 1) // El último segmento debe estar en negrita
            ];
        }

        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.content-app');
    }
}
