<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class BoardLayout extends Component
{
    public function render(): View
    {
        return view('posts.layout');
    }
}
