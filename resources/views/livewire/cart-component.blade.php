	<main id="main" class="main-site">

		<div class="container">

			<div class="wrap-breadcrumb">
				<ul>
					<li class="item-link"><a href="/" class="link">home</a></li>
					<li class="item-link"><span>Cart</span></li>
				</ul>
			</div>
			<div class=" main-content-area">
				@if(Cart::instance('cart')->count() > 0)
				<div class="wrap-iten-in-cart">
					@if(Session::has('success_message'))
					<div class="alert alert-success">
						<strong>Success</strong> {{Session::get('success_message')}}
					</div>
					@endif
					<h3 class="box-title">Products Name</h3>
						<ul class="products-cart">
						@foreach (Cart::instance('cart')->content() as $item)
							<li class="pr-cart-item">
								<div class="product-image">
									<figure><img src="{{asset('assets/images/products')}}/{{$item->model->image}}" alt="{{$item->model->name}}"></figure>
								</div>
								<div class="product-name">
									<a class="link-to-product" href="{{route('product.details',['slug'=>$item->model->slug])}}">{{$item->model->name}}</a>
								</div>
								samir
								@foreach ($item->options as $key=>$value)
									<div style="vertical-align:middle;width:180px">
										<b><p>{{$key}}:{{$value}}</p></b>
									</div>
								@endforeach
								<div class="price-field produtc-price"><p class="price">{{$item->model->regular_price}}</p></div>
								<div class="quantity">
									<div class="quantity-input">
										<input type="text" name="product-quatity" value="{{$item->qty}}" data-max="120" pattern="[0-9]*" >									
										<a class="btn btn-increase" wire:click.prevent = "increasequantity('{{$item->rowId}}')" href="#"></a>
										<a class="btn btn-reduce" wire:click.prevent = "decreasequantity('{{$item->rowId}}')" href="#"></a>
									</div>
									<p class="text-center" style="width: 100%;display: flex;margin-left: 20px;"><a href="#"  wire:click.prevent="switchToSaveForLater('{{$item->rowId}}')">Save For Later</a></p>

								</div>
								<div class="price-field sub-total"><p class="price">{{$item->subtotal }}</p></div>
								<div class="delete">
									<a href="#" class="btn btn-delete" title="" wire:click.prevent = "delete('{{$item->rowId}}')">
										<span>Delete from your cart</span>
										<i class="fa fa-times-circle" aria-hidden="true" ></i>
									</a>
								</div>
							</li>	
						@endforeach										
					</ul>
				</div>

				<div class="summary">
					<div class="order-summary">
						<h4 class="title-box">Order Summary</h4>
						<p class="summary-info"><span class="title">Subtotal</span><b class="index">${{Cart::instance('cart')->subtotal()}}</b></p>
						@if(Session::has('coupon'))
							<p class="summary-info"><span class="title">Discount {{Session::get('coupon')['code']}}<a href="#" wire:click.prevent="removeCoupon"><i class="fa fa-times text-danger"></i></a></span><b class="index">${{number_format($discount)}}</b></p>
							<p class="summary-info"><span class="title">SubTotal With Discount</span><b class="index">${{number_format($subTotalAfterDiscount)}}</b></p>
							<p class="summary-info"><span class="title">Tax ({{config('cart.tax')}}%)</span><b class="index">${{number_format($taxAfterDiscount)}}</b></p>
							<p class="summary-info total-info "><span class="title">Total</span><b class="index">${{number_format($totaAfterDiscount)}}</b></p>
						@else
							<p class="summary-info"><span class="title">Tax</span><b class="index">${{Cart::instance('cart')->tax()}}</b></p>
							<p class="summary-info"><span class="title">Shipping</span><b class="index">Free Shipping</b></p>
							<p class="summary-info total-info "><span class="title">Total</span><b class="index">${{Cart::instance('cart')->total()}}</b></p>
						@endif
						
					</div>
					
					<div class="checkout-info">
					@if(!Session::has('coupon'))
						<label class="checkbox-field">
							<input class="frm-input " name="have-code" id="have-code" value="1" type="checkbox" wire:model="haveCouponCode"><span>I have Coupon code</span>
						</label>
						@if($haveCouponCode == 1)
							<div class="summary-item">
								<form wire:submit.prevent="applayCouponCode">
									<h4 class="title-box">Coupon Code</h4>
									@if(Session::has('coupon_message'))
										<div class="alert alert-danger">
											{{Session::get('coupon_message')}}
										</div>
									@endif
									<p class="row-in-form">
										<label for="coupon-code">Enter Your Coupon Code:</label>
										<input type="text" name="coupon-code" wire:model="couponCode"/>
									</p>
									<button  type="submit" class="btn btn-small">Applay</button>
								</form>
							</div>
						@endif	
						@endif
						<a class="btn btn-checkout" href="" wire:click.prevent="checkout">Check out</a>
						<a class="link-to-shop" href="shop.html">Continue Shopping<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
					</div>
					<div class="update-clear">
						<a class="btn btn-clear" href="#">Clear Shopping Cart</a>
						<a class="btn btn-update" href="#">Update Shopping Cart</a>
					</div>
				</div>
					@else
					<div class="text-center" style="padding:30px 0">
					  <h1>Your Cart Is Empty</h1>
					  <P>Add item To it Now</P>
					  <a href="/shop" class="btn btn-success">Shop Now</a>
					</div>  
					@endif
				<div class="wrap-iten-in-cart">
				<h3 class="title-box" style="border-bottob:1px solid; padding-bottom:15px">{{Cart::instance('saveForLater')->count()}} Items Saved For Later</h3>
					@if(Session::has('s_success_message'))
					<div class="alert alert-success">
						<strong>Success</strong> {{Session::get('s_success_message')}}
					</div>
					@endif
					@if(Cart::instance('saveForLater')->count() > 0)
					<h3 class="box-title">Products Name</h3>
						<ul class="products-cart">
						@foreach (Cart::instance('saveForLater')->content() as $item)
							<li class="pr-cart-item">
								<div class="product-image">
									<figure><img src="{{asset('assets/images/products')}}/{{$item->model->image}}" alt="{{$item->model->name}}"></figure>
								</div>
								<div class="product-name">
									<a class="link-to-product" href="{{route('product.details',['slug'=>$item->model->slug])}}">{{$item->model->name}}</a>
								</div>
								<div class="price-field produtc-price"><p class="price">{{$item->model->regular_price}}</p></div>
								<div class="quantity">
									
										<p class="text-center"><a href="#" wire:click.prevent="MoveToCart('{{$item->rowId}}')">Move To Cart</a></p>
									
								</div>
								<div class="delete">
									<a href="#" class="btn btn-delete" title="" wire:click.prevent = "deleteFromSaveForLater('{{$item->rowId}}')">
										<span>Delete from Save For Later</span>
										<i class="fa fa-times-circle" aria-hidden="true" ></i>
									</a>
								</div>
							</li>	
						@endforeach										
					</ul>
					@else
					  <P>No Items Saved For Later</P>
					@endif
				</div>
				<div class="wrap-show-advance-info-box style-1 box-in-site">
					<h3 class="title-box">Most Viewed Products</h3>
					<div class="wrap-products">
						<div class="products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"3"},"1200":{"items":"5"}}' >

							<div class="product product-style-2 equal-elem ">
								<div class="product-thumnail">
									<a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
										<figure><img src="{{asset('assets/images/products/digital_04.jpg')}}" width="214" height="214" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
									</a>
									<div class="group-flash">
										<span class="flash-item new-label">new</span>
									</div>
									<div class="wrap-btn">
										<a href="#" class="function-link">quick view</a>
									</div>
								</div>
								<div class="product-info">
									<a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker [White]</span></a>
									<div class="wrap-price"><span class="product-price">$250.00</span></div>
								</div>
							</div>

							<div class="product product-style-2 equal-elem ">
								<div class="product-thumnail">
									<a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
										<figure><img src="{{asset('assets/images/products/digital_17.jpg')}}" width="214" height="214" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
									</a>
									<div class="group-flash">
										<span class="flash-item sale-label">sale</span>
									</div>
									<div class="wrap-btn">
										<a href="#" class="function-link">quick view</a>
									</div>
								</div>
								<div class="product-info">
									<a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker [White]</span></a>
									<div class="wrap-price"><ins><p class="product-price">$168.00</p></ins> <del><p class="product-price">$250.00</p></del></div>
								</div>
							</div>

							<div class="product product-style-2 equal-elem ">
								<div class="product-thumnail">
									<a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
										<figure><img src="{{asset('assets/images/products/digital_15.jpg')}}" width="214" height="214" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
									</a>
									<div class="group-flash">
										<span class="flash-item new-label">new</span>
										<span class="flash-item sale-label">sale</span>
									</div>
									<div class="wrap-btn">
										<a href="#" class="function-link">quick view</a>
									</div>
								</div>
								<div class="product-info">
									<a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker [White]</span></a>
									<div class="wrap-price"><ins><p class="product-price">$168.00</p></ins> <del><p class="product-price">$250.00</p></del></div>
								</div>
							</div>

							<div class="product product-style-2 equal-elem ">
								<div class="product-thumnail">
									<a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
										<figure><img src="{{asset('assets/images/products/digital_01.jpg')}}" width="214" height="214" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
									</a>
									<div class="group-flash">
										<span class="flash-item bestseller-label">Bestseller</span>
									</div>
									<div class="wrap-btn">
										<a href="#" class="function-link">quick view</a>
									</div>
								</div>
								<div class="product-info">
									<a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker [White]</span></a>
									<div class="wrap-price"><span class="product-price">$250.00</span></div>
								</div>
							</div>

							<div class="product product-style-2 equal-elem ">
								<div class="product-thumnail">
									<a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
										<figure><img src="{{asset('assets/images/products/digital_21.jpg')}}" width="214" height="214" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
									</a>
									<div class="wrap-btn">
										<a href="#" class="function-link">quick view</a>
									</div>
								</div>
								<div class="product-info">
									<a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker [White]</span></a>
									<div class="wrap-price"><span class="product-price">$250.00</span></div>
								</div>
							</div>

							<div class="product product-style-2 equal-elem ">
								<div class="product-thumnail">
									<a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
										<figure><img src="{{asset('assets/images/products/digital_03.jpg')}}" width="214" height="214" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
									</a>
									<div class="group-flash">
										<span class="flash-item sale-label">sale</span>
									</div>
									<div class="wrap-btn">
										<a href="#" class="function-link">quick view</a>
									</div>
								</div>
								<div class="product-info">
									<a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker [White]</span></a>
									<div class="wrap-price"><ins><p class="product-price">$168.00</p></ins> <del><p class="product-price">$250.00</p></del></div>
								</div>
							</div>

							<div class="product product-style-2 equal-elem ">
								<div class="product-thumnail">
									<a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
										<figure><img src="{{asset('assets/images/products/digital_04.jpg')}}" width="214" height="214" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
									</a>
									<div class="group-flash">
										<span class="flash-item new-label">new</span>
									</div>
									<div class="wrap-btn">
										<a href="#" class="function-link">quick view</a>
									</div>
								</div>
								<div class="product-info">
									<a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker [White]</span></a>
									<div class="wrap-price"><span class="product-price">$250.00</span></div>
								</div>
							</div>

							<div class="product product-style-2 equal-elem ">
								<div class="product-thumnail">
									<a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
										<figure><img src="{{asset('assets/images/products/digital_05.jpg')}}" width="214" height="214" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
									</a>
									<div class="group-flash">
										<span class="flash-item bestseller-label">Bestseller</span>
									</div>
									<div class="wrap-btn">
										<a href="#" class="function-link">quick view</a>
									</div>
								</div>
								<div class="product-info">
									<a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker [White]</span></a>
									<div class="wrap-price"><span class="product-price">$250.00</span></div>
								</div>
							</div>
						</div>
					</div><!--End wrap-products-->
				</div>

			</div><!--end main content area-->
		</div><!--end container-->

	</main>
