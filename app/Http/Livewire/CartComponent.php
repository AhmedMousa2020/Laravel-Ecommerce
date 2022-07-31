<?php

namespace App\Http\Livewire;

use App\Models\Coupon;
use Livewire\Component;
//use Cart;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class CartComponent extends Component
{
    public $haveCouponCode;
    public $couponCode;
    public $discount;
    public $subTotalAfterDiscount;
    public $taxAfterDiscount;
    public $totaAfterDiscount;


    public function increasequantity($product_id){
        $product = Cart::instance('cart')->get($product_id);
        $new_quantity = $product->qty + 1;
        Cart::instance('cart')->update($product_id,$new_quantity);
        $this->emitTo('cart-count-component','refreshComponent');
    }

    
    public function decreasequantity($product_id){
        $product = Cart::instance('cart')->get($product_id);
        $new_quantity = $product->qty - 1;
        Cart::instance('cart')->update($product_id,$new_quantity);
        $this->emitTo('cart-count-component','refreshComponent');
    }

    public function delete($product_id)
    {
        Cart::instance('cart')->remove($product_id);
        $this->emitTo('cart-count-component','refreshComponent');
    }
    
    public function switchToSaveForLater($rowid){

        $item = Cart::instance('cart')->get($rowid);
        Cart::instance('cart')->remove($rowid);
        Cart::instance('saveForLater')->add($item->id,$item->name,1,$item->price)->associate('App\models\Product');
        $this->emitTo('cart-count-component','refreshComponent');
        session()->flash('success_message','Item has been Saved For Later');
    }

    public function MoveToCart($rowid){

        $item = Cart::instance('saveForLater')->get($rowid);
        Cart::instance('saveForLater')->remove($rowid);
        Cart::instance('cart')->add($item->id,$item->name,1,$item->price)->associate('App\models\Product');
        $this->emitTo('cart-count-component','refreshComponent');
        session()->flash('s_success_message','Item has been Moved To Cart');
    }

    public function deleteFromSaveForLater($rowid)
    {
        Cart::instance('saveForLater')->remove($rowid);
        session()->flash('s_success_message','Item has been Removed From Save For later');
    }
    public function applayCouponCode(){
        $coupon = Coupon::where('code',$this->couponCode)->where('expiry_date','>=',Carbon::today())->where('cart_value','<=',Cart::instance('cart')->subtotal())->first();
        if(!$coupon){
            session()->flash('coupon_message','Coupon Code is Invalid');
            return;
        }else{
            session()->put('coupon',[
                'code'      =>$coupon->code,
                'value'     =>$coupon->value,
                'type'      =>$coupon->type,
                'cart_value'=>$coupon->cart_value
            ]);
        }
    } 

    public function calculateDiscount(){
        if(session()->has('coupon')){
            if(session()->get('coupon')['type'] == 'fixed'){

                $this->discount = session()->get('coupon')['value'];

            }else{

                $this->discount = (Cart::instance('cart')->subtotal() * session()->get('coupon')['value'])/100;
            }
            $this->subTotalAfterDiscount = Cart::instance('cart')->subtotal() - $this->discount;
            $this->taxAfterDiscount = ($this->subTotalAfterDiscount * config('cart.tax'))/100;
            $this->totaAfterDiscount = $this->subTotalAfterDiscount + $this->taxAfterDiscount;

        }
    }
    public function removeCoupon(){
        session()->forget('coupon');
    }

    public function checkout(){
        if(Auth::check()){
            return redirect()->route('checkout');
        }else{
            return redirect()->route('login');
        }
    }

    public function setAmountForCheckout(){

        if(!Cart::instance('cart')->count() > 0){
            session()->forget('checkout');
            return;
        }
        if(session()->has('coupon')){
            session()->put('checkout',[
                'discount'=>$this->discount,
                'subtotal'=>$this->subTotalAfterDiscount,
                'tax'=>$this->taxAfterDiscount,
                'total'=>$this->totaAfterDiscount
            ]);
        }else{
            session()->put('checkout',[
                'discount'=>0,
                'subtotal'=>Cart::instance('cart')->subtotal(),
                'tax'=>Cart::instance('cart')->tax(),
                'total'=>Cart::instance('cart')->total()
            ]);
        }
    }
    public function render()
    {
        if(session()->has('coupon')){
            if(Cart::instance('cart')->subtotal() < session()->get('coupon')['cart_value']){
                    session()->forget('coupon');
            }else{
                $this->calculateDiscount();
            }
        }
        $this->setAmountForCheckout();
        if(Auth::check()){
            Cart::instance('cart')->store(Auth::user()->email);
        }
        return view('livewire.cart-component')->layout("layouts.base");
    }
}
