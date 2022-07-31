<main id="main" class="main-site left-sidebar">

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">home</a></li>
                <li class="item-link"><span>Wishlist</span></li>
            </ul>
        </div>

        <style>
            .product-wish {
                position: absolute;
                top: 10%;
                left: 0;
                right: 30px;
                text-align: right;
                z-index: 99;
                padding-top: 0;
            }

            .product-wish .fa {
                color: #cbcbcb;
                font-size: 30px;
            }

            .product-wish .fa:hover {
                color: #ff2832;
            }

            .product-wish .fill-heart {
                color: #ff2832 !important;
            }

        </style>
        <div class="row">
            @if(Cart::instance('wishlist')->content()->count() > 0)
            <ul class="product-list grid-products equal-container">
                
                @foreach (Cart::instance('wishlist')->content() as $witem)
                    <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
                        <div class="product product-style-3 equal-elem ">
                            <div class="product-thumnail">
                                <a href="{{ route('product.details', ['slug' => $witem->model->slug]) }}"
                                    title="{{ $witem->model->name }}">
                                    <figure><img src="{{ asset('assets/images/products') }}/{{ $witem->model->image }}" alt="{{ $witem->model->name }}"></figure>
                                </a>
                            </div>
                            <div class="product-info">
                                <a href="{{ route('product.details', ['slug' => $witem->model->slug]) }}"
                                    class="product-name"><span>{{ $witem->model->name }}</span></a>
                                <div class="wrap-price"><span
                                        class="product-price">{{ $witem->model->regular_price }}</span></div>
                                <a href="#" class="btn add-to-cart"
                                    wire:click.prevent="MoveProductFromWishlistToCart('{{$witem->rowId}}')">Move To Cart</a>
                                <div class="product-wish">
                                    <a href="#" wire:click.prevent="RemoveFromWishlist({{ $witem->model->id }})"><i class="fa fa-heart fill-heart"></i></a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach    
            </ul>
            @else
                    <h4> No Wishlist items</h4>
            @endif
        </div>
    </div>
</main>
