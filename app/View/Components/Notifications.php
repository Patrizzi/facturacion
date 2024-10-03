<?php

namespace App\View\Components;

namespace App\View\Components;

use App\Services\DocumentService;
use Illuminate\View\Component;

class Notifications extends Component {
    public bool $hasSunatPendingDocuments;
    public bool $hasInvoices;
    public array $invoices = [];

    protected DocumentService $documentService;

    /**
     * Create a new component instance.
     *
     * @param DocumentService $documentService
     */
    public function __construct(DocumentService $documentService) {
        $this->documentService = $documentService;

        $this->hasSunatPendingDocuments = $this->documentService
            ->hasPendingDocuments($this->getSunatDocumentTypes());
        $this->hasInvoices = $this->documentService
            ->hasPendingDocuments($this->getInvoiceTypes());

        if ($this->hasInvoices) {
            $this->invoices = $this->documentService
                ->getPendingDocumentsCount($this->getInvoiceTypes());
        }
    }

    /**
     * Define Sunat document types and their fields.
     *
     * @return array
     */
    protected function getSunatDocumentTypes(): array {
        return [
            \App\Facturacion::class => 'f_electronica',
            \App\Facturacion_m::class => 'f_electronica',
            \App\Boleta::class => 'b_electronica',
            \App\Boleta_m::class => 'b_electronica',
            \App\Guia_remision::class => 'g_electronica',
            \App\GuiaRemisionManual::class => 'g_electronica',
            \App\Nota_Credito::class => 'n_electronica',
            \App\Nota_Debito::class => 'n_electronica',
        ];
    }

    /**
     * Define invoice types and their fields.
     *
     * @return array
     */
    protected function getInvoiceTypes(): array {
        return [
            \App\Facturacion::class => 'f_electronica',
            \App\Facturacion_m::class => 'f_electronica',
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.notifications');
    }
}
