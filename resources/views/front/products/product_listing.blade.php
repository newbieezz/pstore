<?php use App\Models\Product; ?>
      
<!-- ITEMS -->
<!-- ------------------------------------------------- -->
<div class="items">
    @foreach($categoryProducts as $product)
    <div class="item">
        <!-- Display products wtih loop -->
        <div class="item__position">
            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                <!-- Check if the file exist or not, if not then show dummy image -->
                @if(!empty($product['product_image']) && file_exists($product_image_path))
                    <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                @else
                    <img class="img-fluid" src="{{ asset('front/images/product_images/small/noimage.png') }}" alt="NoImage">
                @endif
            </a>
        </div>
        <div class="item__detail">
            <div class="services-content">
                <p>{{ $product['product_code'] }} </p>
                <h5 style="content: center"><a href="{{ url('product/'.$product['product_name']) }}">{{ $product['product_name'] }}</a></h5>
            </div><!-- Call the dunction created inside the products model for the discounted price -->
            <?php $getDiscountedPrice = Product::getDiscountedPrice($product['id']);  ?>
            @if ($getDiscountedPrice > 0)
                <div class="price-template">
                    <div class="item-new-price">
                       DP: ₱ {{ $getDiscountedPrice }} <br>
                       Discount: {{$product['product_discount']}} %
                    </div>
                    {{-- <div class="item-old-price">
                        ₱ {{ $product['product_price'] }}
                    </div> --}}
                </div>
            @else
                <div class="price-template">
                    <div class="item-new-price">
                        ₱ {{ $product['product_price'] }}
                    </div>
                </div>
            @endif
            <p></p>
        </div>
    </div>
    @endforeach
</div>

  