<?php

namespace App\View\Components;

use App\TipoCambio;
use Carbon\Carbon;
use Illuminate\View\Component;

class ExchangeRate extends Component {

    public TipoCambio $typeChange;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?float $buys = null,
        public ?float $sale = null,
        public ?float $parallel = null
    ) {
        $this->typeChange = TipoCambio::where('fecha', Carbon::now()->format('Y-m-d'))->first();
        $this->buys = $this->typeChange->compra ?? 0.0;
        $this->sale = $this->typeChange->venta ?? 0.0;
        $this->parallel = $this->typeChange->paralelo ?? 0.0;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.exchange-rate');
    }
}
