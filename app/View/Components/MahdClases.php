<?php

namespace App\View\Components;

use App\Models\MahdClass;
use Illuminate\View\Component;

class MahdClases extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $rows = MahdClass::with('plane')->get();
        return view('components.mahd-clases',['rows'=>$rows]);
    }
}
