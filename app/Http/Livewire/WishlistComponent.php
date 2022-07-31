<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;
class WishlistComponent extends Component
{
    public function RemoveFromWishlist($product_id){
        foreach(Cart::instance('wishlist')->content() as $witem){
            if($witem->id == $product_id){
                Cart::instance('wishlist')->remove($witem->rowId);
                $this->emitTo('wishlist-count-component','refreshComponent');
                return;
            }
        }
    }

    public function MoveProductFromWishlistToCart($rowId){
        
        $witem = Cart::instance('wishlist')->get($rowId);
        Cart::instance('wishlist')->remove($rowId);
        Cart::instance('cart')->add($witem->id,$witem->name,1,$witem->price)->associate('App\Models\Product');
        $this->emitTo('wishlist-count-component','refreshComponent');
        $this->emitTo('cart-count-component','refreshComponent');
    }

    public function render()
    {
        return view('livewire.wishlist-component')->layout('layouts.base');
    }
}
