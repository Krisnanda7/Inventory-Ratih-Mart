<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageLayout extends Component
{
    public string $title;
    public $header;

    public function __construct(string $title = '', $header = null)
    {
        $this->title = $title;
        $this->header = $header;
    }

    public function render(): View|Closure|string
    {
        return view('components.page-layout');
    }
}

