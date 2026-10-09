<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $company_name = 'JyP Periféricos',
        public string $company_link = 'http://www.jypsac.com',
        public string $year_copyright = '2019-2022',
        public string $facebook_link = 'https://www.facebook.com/JYPPERIFERICOSSAC',
        public string $whatsapp_link = 'https://api.whatsapp.com/send?phone=51946201443&text=Hola!%20Necesito%20Ayuda%20con%20el%20sistema%20de%20Facturación,%20Gracias!%20',
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.footer');
    }
}
