<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class datatablesServerSide extends Component
{
    public $url;
    public $name;
    public $header;
    /**
     * Create a new component instance.
     */
    public function __construct($url = '', $name = 'defult', $header = [])
    {
        $this->url = $url;
        $this->name = $name;
        $this->header = $header;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.datatables-server-side');
    }
}
