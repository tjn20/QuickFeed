<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{

    /**
     * Create a new component instance.
     *
     * @return void
     */
   
    public function render(): View
    {
        return view('layouts.app');
    }
}
