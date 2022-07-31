<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\HomeCategory;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\Sale;
//use Cart;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        $sliders = HomeSlider::where('status',1)->get();
        $latestproducts = Product::orderBy('created_at','DESC')->get()->take(8);
        $saleproducts = Product::where('sale_price','>',0)->inRandomOrder()->get()->take(8);
        $category = HomeCategory::find(1);
        if($category->sel_categories){
            $cats = explode(',', $category->sel_categories);
        }else{
            $cats='';
        }
        
        $categories  = Category::whereIn('id' ,$cats )->get();
        $no_of_products = $category-> no_of_products ;
        $sale = Sale::find(1);
        
        if(Auth::check()){
            Cart::instance('cart')->restore(Auth::user()->email);
            Cart::instance('wishlist')->restore(Auth::user()->email);
        }
        return view('livewire.home-component',['sliders'=>$sliders,'latestproducts'=>$latestproducts,'saleproducts'=>$saleproducts,'categories'=>$categories,'no_of_products'=>$no_of_products,'sale'=>$sale])->layout('layouts.base');
    }
}
