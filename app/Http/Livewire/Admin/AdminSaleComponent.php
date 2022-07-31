<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Sale;
use Carbon\Carbon;

class AdminSaleComponent extends Component
{
    public $sale_date;
    public $status;
    public function mount(){
        $sale = Sale::find(1);
        if($sale){
            $this->sale_date = $sale->sale_date;
            $this->sale_date = $sale->status;
        }else{
            $sale = new Sale();
            $sale-> sale_date = Carbon::now();
            $sale-> status = 0;
            $sale-> save();
        }
        
    }

    public function updateSale()
    {
    $sale = Sale::find (1);
    $sale-> sale_date = $this->sale_date;
    $sale-> status = $this-> status;
    $sale-> save();
    session ()->flash( 'message' , 'Record has been updated successfully');
    }
    public function render()
    {
        $sale = Sale::find (1);
        return view('livewire.admin.admin-sale-component',['sale'=>$sale])->layout('layouts.base');
    }
}
