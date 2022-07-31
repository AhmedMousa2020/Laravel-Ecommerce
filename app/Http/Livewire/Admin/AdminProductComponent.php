<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
class AdminProductComponent extends Component
{
    use WithPagination;
    public $searchTerm;
public function deleteProduct($id){
    $product  = Product::find($id);
    if($product->image)
    {
        unlink('assets/images/products'.'/'.$product->image);
    }
    if($product->images)
    {
        $images = explode(",",$product->images);
        foreach($images as $image)
        {
            if($image){
                unlink('assets/images/products'.'/'.$image);
            }
        }

}
    $product->delete();
    session()->flash('message', 'Product has been deleted successfully!');
}
    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';

        $products = Product::where('name','LIKE',$searchTerm)
        ->orwhere('stock_status','LIKE',$searchTerm)
        ->orwhere('regular_price','LIKE',$searchTerm)
        ->orwhere('sale_price','LIKE',$searchTerm)->
        orderBy('id','DESC')->paginate(10);
        return view('livewire.admin.admin-product-component',['products'=>$products])->layout('layouts.base');
    }
}
