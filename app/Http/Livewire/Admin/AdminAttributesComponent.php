<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProductAttribute;
class AdminAttributesComponent extends Component
{
    use WithPagination;
    public function deleteAttribute($attribute_id)
    {
        $pattribute= ProductAttribute::find($attribute_id);
        $pattribute->delete();
        session()->flash('message","Attribute has been deleted successfully!');
    }
    public function render()
    {
        $attributes = ProductAttribute::paginate(10);
        return view('livewire.admin.admin-attributes-component',['attributes'=>$attributes])->layout('layouts.base');
    }
}
