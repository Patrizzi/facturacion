<?php 

namespace App\View\Components\ProjectManager;

use Illuminate\View\Component;

class BtnLink extends Component
{
    public string $url;
    public string $text;
    public bool $active;

    public function __construct(string $url, string $text, bool $active = false)
    {
        $this->url = $url;
        $this->text = $text;
        $this->active = $active;
    }

    public function isButtonActive() {
        return $this->active ? 'btn-active' : '';
    }

    public function render()
    {
        return view('components.btn-link');
    }
}
