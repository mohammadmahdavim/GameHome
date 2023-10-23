<?php

namespace App\View\Components;

use App\Models\WorkshopStaff;
use Illuminate\View\Component;

class MyWorkshop extends Component
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

        $workShopId=WorkshopStaff::where('user_id',auth()->user()->id)->pluck('workshop_id');
        $rows = \App\Models\Workshop::whereIn('id',$workShopId)->get();

        return view('components.my-workshop',['rows'=>$rows]);
    }
}
